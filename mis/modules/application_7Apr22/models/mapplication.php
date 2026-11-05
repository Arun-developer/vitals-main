<?php

class Mapplication extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getApplicationType($id) {
        $this->db->where('id', $id);
        $this->db->select("program, partner_id");
        $query = $this->db->get('innovation_pool');

        $rows = $query->result_array();
        return $rows;
    }

    public function getLastInnovationID() {
        $this->db->select("id");
        $this->db->order_by('id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get('innovation_pool');

        $rows = $query->result_array();
        return $rows;
    }

    public function checkEmailExistValue($email, $partner) {
        $this->db->select('id');
        $this->db->where(array('email_id' => $email, 'partner_id' => $partner));
        $query = $this->db->get('innovation_pool');
        $check = $query->result_array();
        return $check;
    }

    public function getEmpFirstName($id) {
        $this->db->where('id', $id);
        $this->db->select("emp_first_name");
        $query = $this->db->get('hr_user_profile');

        $rows = $query->result_array();
        return $rows;
    }

    public function checkApplicationDetails($table, $id, $field = '') {
        if ($field != '') {
            $this->db->where($field, $id);
        } else {
            $this->db->where('inv_user_id', $id);
        }
        $this->db->select("id");
        $query = $this->db->get($table);

        $rows = $query->result_array();
        return $rows;
    }

    public function insertApplicationDetail($table, $data) {
        $last_inserted = $this->db->insert($table, $data);
        return $last_inserted;
    }

    public function updateApplicationDetail($table, $data, $condition) {
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update($table, $data);
        return $result;
    }

    public function getProgramName($id) {
        $this->db->select('Program_name');
        $this->db->where('program_id', $id);
        $query = $this->db->get('program_type');
        $result = $query->result_array();
        return $result[0]['Program_name'];
    }

    public function getIncApplicationBasic($id) {
        $this->db->where('t1.id', $id);
        $this->db->select("t1.id, t1.copy_id, t1.partner_id, t1.copy_partner_id, t1.partner_count, t1.name_of_entrepreneur, t1.name_of_enterprise, t1.address_line1, t1.address_line2, t1.country, t1.program, t1.email_id, t1.mobile_no, t1.stage, t2.created_date, t2.submitted_date, "
            . "t1.status, t1.created_by, t2.id as inv_user_id, t2.ent_sector as sector_id, t2.sub_sector as sub_sector_id, t2.sub_sector_other, t2.gender, t2.dob, t2.country as country_id, t3.sector as sector_name, t4.sector as sub_sector, t2.website, t2.ent_type, t2.india_based, t2.benificiary, t2.impact_of_product, t5.partner_name, t6.business_plan as doc1, t6.add_info as doc2, t6.inc_cert as doc3");
        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
        $this->db->join('sector_category t3', 't3.id= t1.sector', 'left');
        $this->db->join('sector_category t4', 't4.id= t2.sub_sector', 'left');
        $this->db->join('hr_partner_type t5', 't5.id= t1.partner_id', 'left');
        $this->db->join('inv_additional_info t6', 't6.inv_user_id = t2.id', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getIncApplicationTeam($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.id, t1.name_of_enterprise, t1.stage, t1.status, t1.program, t2.id as inv_user_id, t3.id as team_id, t3.mem_name, t3.mem_occupation, t3.mem_org, t3.mem_email, t3.mem_mobile, t3.mem_gender, t3.mem_resume, t3.linkedin_profile, t4.business_plan as doc1, t4.add_info as doc2, t4.inc_cert as doc3, t5.team_size, t5.primary_point, t5.type_prod, t5.proposal_desc,t5.stage_product');
        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
        $this->db->join('inv_member t3', 't3.inv_user_id = t2.id', 'left');
        $this->db->join('inv_additional_info t4', 't4.inv_user_id = t2.id', 'left');
        $this->db->join('inv_ent_info t5', 't5.inv_user_id = t2.id', 'left');
        $query = $this->db->get('innovation_pool t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getTeamInfo($condition = '') {
        $this->db->where($condition);
        $this->db->select('id');
        $query = $this->db->get('inv_member');

        $rows = $query->result_array();
        return $rows;
    }

    public function getIncApplicationEnterprise($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.id, t1.name_of_enterprise, t1.stage, t1.status, t1.program, t2.id as inv_user_id, t3.in_operation, t3.operate_on_state, t4.ant_org, t3.reco_no, t3.pilots, t3.org_reg_date, t3.org_short_desc, t3.cin, t3.pan, t3.city, t3.pincode, t3.address, t3.tech_challege, t3.vill_support, t3.date_from_incubated, t3.website_url, t3.social_media, t4.ant_org_name, t4.won_competition, t4.competition_name, t4.business_plan as doc1, t4.add_info as doc2, t4.inc_cert as doc3, t5.state_name');
        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
        $this->db->join('inv_ent_info t3', 't3.inv_user_id = t2.id', 'left');
        $this->db->join('inv_additional_info t4', 't4.inv_user_id = t2.id', 'left');
        $this->db->join('eir_state t5', 't5.id = t3.operate_on_state', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getAFDapplicationEnterprise($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t3.*, t1.id, t1.name_of_enterprise, t1.stage, t1.status, t1.program, t2.id as inv_user_id, t4.business_plan as doc1, t4.add_info as doc2, t4.inc_cert as doc3, t5.state_name');
        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
        $this->db->join('inv_ent_info t3', 't3.inv_user_id = t2.id', 'left');
        $this->db->join('inv_additional_info t4', 't4.inv_user_id = t2.id', 'left');
        $this->db->join('eir_state t5', 't5.id = t3.operate_on_state', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getStateByApplication($inc_id) {
        $this->db->where('inv_user_id', $inc_id);
        $this->db->select('operate_on_state');
        $query = $this->db->get('inv_ent_info');
        $rows = $query->result_array();
        return $rows;
    }

    public function getIncApplicationInnovation($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.id, t1.name_of_enterprise, t1.stage, t1.status, t1.program, t2.id as inv_user_id, t3.develop_product, t3.stage_product, t3.inv_desc, t3.inv_problem, t3.inv_alternatives, '
            . 't3.proposal_desc, t3.inv_risks, t4.primary_benifi, t4.research_cus_seg, t4.demographic_profie, t4.avg_monthly, t4.inv_impact, t4.others_benefit, t5.business_plan as doc1, t5.add_info as doc2, t5.inc_cert as doc3');
        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
        $this->db->join('inv_ent_info t3', 't3.inv_user_id = t2.id', 'left');
        $this->db->join('inv_impact t4', 't4.inv_user_id = t2.id', 'left');
        $this->db->join('inv_additional_info t5', 't5.inv_user_id = t2.id', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getAFDapplicationInnovation($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t5.*,t1.id, t1.name_of_enterprise, t1.stage, t1.status, t1.program, t2.id as inv_user_id, t3.develop_product, t3.stage_product, t3.inv_desc, t3.inv_problem, t3.inv_alternatives, '
            . 't3.proposal_desc, t3.inv_risks, t4.primary_benifi, t4.research_cus_seg, t4.demographic_profie, t4.avg_monthly, t4.inv_impact, t4.others_benefit, t5.business_plan as doc1, t5.add_info as doc2, t5.inc_cert as doc3');
        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
        $this->db->join('inv_ent_info t3', 't3.inv_user_id = t2.id', 'left');
        $this->db->join('inv_impact t4', 't4.inv_user_id = t2.id', 'left');
        $this->db->join('inv_additional_info t5', 't5.inv_user_id = t2.id', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getIncApplicationAdditional($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.id, t1.name_of_enterprise, t1.sector_others, t1.stage, t1.status, t1.program, t2.id as inv_user_id, t2.india_based, t2.ent_sector, t3.tanseed_program, t3.company_description, t3.inv_idea_ent, t3.from_villgro, t3.support_name, t3.hear_abt, t3.referal_name, t3.business_plan as doc1, t3.add_info as doc2, t3.inc_cert as doc3');
        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
        $this->db->join('inv_additional_info t3', 't3.inv_user_id = t2.id', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getPitchApplicationBasic($id) {
        $this->db->where('t1.id', $id);
        $this->db->select("t1.id, t1.copy_id, t1.partner_id, t1.copy_partner_id, t1.partner_count, t1.name_of_entrepreneur,t1.name_of_entrepreneur_hi, t1.name_of_enterprise,t1.name_of_enterprise_hi,t1.name_of_enterprise_hi, t1.source, t1.program,"
            . "t1.stage, t1.status, t2.email, t2.mobileno, t2.altmobileno, t2.designation,t2.designation_hi, t2.gender, t2.reg_date, t2.submitted_date, t2.lang_code, t3.source_name, t4.partner_name, t5.doc1, t5.doc2");
        $this->db->join('pitch_user t2', 't2.inno_id = t1.innovation_id', 'left');
        $this->db->join('source_master t3', 't3.id= t1.source', 'left');
        $this->db->join('hr_partner_type t4', 't4.id= t1.partner_id', 'left');
        $this->db->join('award_share t5', 't5.pitch_id= t2.pitch_id', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getPitchApplicationTeam($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.id, t1.name_of_enterprise,t1.name_of_enterprise_hi, t1.stage, t1.status, t1.program, t3.name,t3.name_hi, t3.cur_title,t3.cur_title_hi, t3.other_title,t3.other_title_hi,t3.email, t3.age, t3.phone, t3.gender, t3.cur_org, '
            . 't3.institute, t3.institute_type, t3.institute_link, t3.education_qualify, t3.education_qualify_hi, t3.linkedin, t4.doc1, t4.doc2, t5.male_numb, t5.female_numb, t5.transgender_numb, t5.women_founder, t5.applicant_type, t5.young_team');
        $this->db->join('pitch_user t2', 't2.inno_id = t1.innovation_id', 'left');
        $this->db->join('pitch_step1_members t3', 't3.pitch_id = t2.pitch_id', 'left');
        $this->db->join('award_share t4', 't4.pitch_id= t2.pitch_id', 'left');
        $this->db->join('pitch_step1_info t5', 't5.pitch_id = t2.pitch_id', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getPitchApplicationEnterprise($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.id, t1.name_of_enterprise, t1.stage, t1.status, t1.program, t3.applicant_type, t3.ent_type,t3.dipp_register, t3.dipp_number, t3.company_register, t3.cin_number, t4.incorporation_year, t9.funding_instrument, t5.doc1, t4.describe_solution, t3.city_id as ysvf_city,'
            . 't3.company_address, t4.fund, t4.operation_stage, t8.name as sdg_aligns, t4.fy_20_21, t4.fy_19_20, t4.fy_18_19, t4.fy_17_18, t4.grant_amount, t4.equity_amount, t4.website, t9.funding_range, t5.doc2, t4.saved_water, t3.country as ysvf_country, t3.state_id as ysvf_state,'
            . 't4.accelerate_type, t4.incubated_accelerated,t4.incubated_accelerated_hi,t4.past_fund, t4.other_subsector, t6.state_name, t7.city_name, t4.sub_sector, t10.sector as sector_name, t11.sector as sub_sector_name, t4.areas_other, t4.quest_2, '
            . 't4.ubs_trl, t4.ubs_challenge, t4.corporate_partner, t4.applying_stage');
        $this->db->join('pitch_user t2', 't2.inno_id = t1.innovation_id', 'left');
        $this->db->join('pitch_step1_info t3', 't3.pitch_id = t2.pitch_id', 'left');
        $this->db->join('pitch_step2 t4', 't4.pitch_id = t2.pitch_id', 'left');
        $this->db->join('award_share t5', 't5.pitch_id= t2.pitch_id', 'left');
        $this->db->join('eir_state t6', 't6.id= t3.state_id', 'left');
        $this->db->join('eir_city t7', 't7.id= t3.city_id', 'left');
        $this->db->join('pitch_sdg_aligns t8', 't8.id= t4.sdg_aligns', 'left');
        $this->db->join('pitch_step2_additional t9', 't9.pitch_id = t2.pitch_id', 'left');
        $this->db->join('sector_category t10', 't10.id = t1.sector', 'left');
        $this->db->join('sector_category t11', 't11.id = t4.sub_sector', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getPitchApplicationInnovation($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.id, t1.name_of_enterprise,t1.name_of_enterprise_hi, t1.stage, t1.status, t1.program, t3.quest_1,t3.quest_1_hi, t3.ent_impact,t3.ent_impact_hi, t3.direct_impact_status,t3.sub_sector, t3.prototype_solution, t3.prototype_yes, t3.prototype_no, t3.immersion_program, t3.other_team_info,'
            . 't5.solution_to_fit, t5.solution_to_fit_hi, t5.clinical_solution, t3.direct_impact_sol, t3.direct_impact_sol_hi,t3.patents, t3.patent_desc, t3.patent_desc_hi, t3.prize_recognition, t3.awards, t3.awards_hi, t3.addr_problem,t3.addr_problem_hi,t5.trl_innovation,t5.trl_innovation_hi,'
            . 't5.partnerships_collaborations,t5.partnerships_collaborations_hi,t5.pilot_studies,t5.pilot_studies_hi,t5.expected_investment_amount,t5.expected_investment_amount_hi,t4.doc1,t4.doc2,t3.customer_details,t3.ubs_other_details,t3.quest_2,t3.quest_3,t3.quest_4,');
        $this->db->join('pitch_user t2', 't2.inno_id = t1.innovation_id', 'left');
        $this->db->join('pitch_step2 t3', 't3.pitch_id = t2.pitch_id', 'left');
        $this->db->join('award_share t4', 't4.pitch_id= t2.pitch_id', 'left');
        $this->db->join('pitch_step2_additional t5', 't5.pitch_id = t2.pitch_id', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getPitchApplicationAdditional($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.id, t1.name_of_enterprise, t1.name_of_enterprise_hi, t1.stage, t1.status, t1.program, t3.info_about_program, t3.info_other_mailer, t3.partner_name, t3.inc_name, t3.referral_name, t3.other_org_name,t3.other_org_name_hi, t3.artha_platform, t4.doc1, t4.doc2');
        $this->db->join('pitch_user t2', 't2.inno_id = t1.innovation_id', 'left');
        $this->db->join('pitch_step2 t3', 't3.pitch_id = t2.pitch_id', 'left');
        $this->db->join('award_share t4', 't4.pitch_id= t2.pitch_id', 'left');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getApplicationDetails($id) {
        $this->db->where('t1.id', $id);
        $this->db->select('t1.name_of_enterprise');
        $query = $this->db->get('innovation_pool t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getDTInternalMailCount($options, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $searchArray = array();
        $where = '';
        if (!empty($options['innovation'])) {
            $searchArray[] = "innovation = '" . $options['innovation'] . "'";
        }

        if (!empty($options['mail_type'])) {
            $searchArray[] = "mail_type like '%" . $options['mail_type'] . "%'";
        }

        if (!empty($options['sent_date'])) {
            $searchArray[] = "sent_date >= '" . $options['sent_date'] . "'";
        }

        if (!empty($options['sent_date_to'])) {
            $searchArray[] = "sent_date <= '" . $options['sent_date_to'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        if (!empty($where)) {
            $query = $this->db->get_where('innovation_mail_history', $where);
        } else {
            $query = $this->db->get('innovation_mail_history');
        }

        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTInternalMailDetails($num, $offset, $options, $columns, $requestData) {

        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
        $this->db->limit($num, $offset);

        $searchArray = array();
        $where = '';
        if (!empty($options['innovation'])) {
            $searchArray[] = "innovation = '" . $options['innovation'] . "'";
        }

        if (!empty($options['mail_type'])) {
            $searchArray[] = "mail_type like '%" . $options['mail_type'] . "%'";
        }

        if (!empty($options['sent_date'])) {
            $searchArray[] = "sent_date >= '" . $options['sent_date'] . "'";
        }

        if (!empty($options['sent_date_to'])) {
            $searchArray[] = "sent_date <= '" . $options['sent_date_to'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        if (!empty($where)) {
            $query = $this->db->get_where('innovation_mail_history', $where);
        } else {
            $query = $this->db->get('innovation_mail_history');
        }

        $rows = $query->result_array();
        return $rows;
    }

    public function getDTExternalMailCount($options, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $searchArray = array();
        $where = '';
        if (!empty($options['innovation'])) {
            $searchArray[] = "innovation_id = '" . $options['innovation'] . "'";
        }

        if (!empty($options['mail_type'])) {
            $searchArray[] = "mailtype like '%" . $options['mail_type'] . "%'";
        }

        if (!empty($options['sent_date'])) {
            $searchArray[] = "sent_on >= '" . $options['sent_date'] . "'";
        }

        if (!empty($options['sent_date_to'])) {
            $searchArray[] = "sent_on <= '" . $options['sent_date_to'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        if (!empty($where)) {
            $query = $this->db->get_where('external_mail_history', $where);
        } else {
            $query = $this->db->get('external_mail_history');
        }

        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTExternalMailDetails($num, $offset, $options, $columns, $requestData) {

        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
        $this->db->limit($num, $offset);

        $searchArray = array();
        $where = '';
        if (!empty($options['innovation'])) {
            $searchArray[] = "innovation_id = '" . $options['innovation'] . "'";
        }

        if (!empty($options['mail_type'])) {
            $searchArray[] = "mailtype like '%" . $options['mail_type'] . "%'";
        }

        if (!empty($options['sent_date'])) {
            $searchArray[] = "sent_on >= '" . $options['sent_date'] . "'";
        }

        if (!empty($options['sent_date_to'])) {
            $searchArray[] = "sent_on <= '" . $options['sent_date_to'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        if (!empty($where)) {
            $query = $this->db->get_where('external_mail_history', $where);
        } else {
            $query = $this->db->get('external_mail_history');
        }

        $rows = $query->result_array();
        return $rows;
    }

    public function getAllUsers($branch = '') {
        $data = array();
        if (!empty($branch) || ($branch != '')) {
            $this->db->where('hr_user_login.partner_id', $branch);
        }
        $this->db->where('hr_user_login.status', '1');
        $this->db->select("hr_user_profile.id, emp_name, hr_user_login.emp_id", false);
        $this->db->join('hr_user_login', 'hr_user_profile.id = hr_user_login.emp_id');
        $this->db->group_by("hr_user_login.emp_id");
        $this->db->order_by("hr_user_profile.emp_first_name", "ASC");
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getUserSetup($inv_id) {
        $this->db->where(array('innovation' => $inv_id, 'status' => '1'));
        $query = $this->db->get('assign_associate');

        $rows = $query->result_array();
        return $rows;
    }

    public function updateDetails($table, $data, $condition) {
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update($table, $data);
        return $result;
    }

}
