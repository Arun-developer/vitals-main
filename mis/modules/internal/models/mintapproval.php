<?php

class Mintapproval extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
    }

//echo $this->ais->last_query(); exit;
    public function approvalNumber() {
        $data = array();
        $text = "APN/";
        $position = "front";
        $this->ais->order_by('approval_id', 'desc');
        $this->ais->limit('1', '0');
        $query = $this->ais->get('approval_note');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        if (count($data))
            $id = str_pad((int) $data['0']['approval_id'] + 1, 4, "0", STR_PAD_LEFT);
        else
            $id = '0001';
        return $approvalNo = $text . $id;
    }

    public function getROlist($emp_id) {
        $this->db->select('t1.report_subordinate as emp_id,t2.emp_name');
        $this->db->join('hr_user_profile t2', 't2.id = t1.report_subordinate', 'left');
        $this->db->where(array('t1.report_supervisor' => $emp_id, 't1.report_method' => '1', 't1.status' => '1', 't2.status' => '1'));
        $this->db->order_by('t2.emp_name', 'asc');
        $query = $this->db->get('hr_user_reporting t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function findCurrentFinancialYear() {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('status', '1');
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->ais->get('financial_year');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getProgrammeList($id = '') {
        $data = array();
        $financial = $this->findCurrentFinancialYear();
        $from = converttodate($financial[0]['from']);
        $to = converttodate($financial[0]['to']);

        $this->ais->select('MP.*');
        $this->ais->join('balance_amount BA', 'BA.programme_id=MP.programme_id');
        if ($id != '')
            $this->ais->where('MP.programme_id', $id);
        $this->ais->where(array('MP.partner_id' => $this->session->userdata('partner_id'), 'BA.amount_date >=' => $from, 'BA.amount_date <=' => $to, 'MP.status' => '1'));
        $this->ais->order_by('MP.programme', 'asc');
        $this->ais->group_by('BA.programme_id');
        $query = $this->ais->get('master_programme MP');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getDonorList($id = '') {
        $data = array();
        $financial = $this->findCurrentFinancialYear();
        $from = converttodate($financial[0]['from']);
        $to = converttodate($financial[0]['to']);
        $this->ais->select('MS.master_name, BA.donor_id');
        $this->ais->join('master_settings MS', 'MS.master_id=BA.donor_id');
        if ($id != '')
            $this->ais->where('BA.programme_id', $id);
        $this->ais->where(array('BA.amount_date >=' => $from, 'BA.amount_date <=' => $to));
        $this->ais->order_by('MS.master_name', 'asc');
        $this->ais->group_by(array("BA.programme_id", "BA.donor_id"));
        $query = $this->ais->get('balance_amount BA');
        $rows = $query->result_array();
        return $rows;
    }

    function getGrantList($id = '') {
        $this->db->select("id, name");
        $this->db->where(array('funder_id' => $id, 'status_type' => 'open'));
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('grant_list');
        $rows = $query->result_array();
        return $rows;
    }

    function getBudgetList($program = '', $donor = '', $grant = '') {
        $financialArray = $this->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);
        $this->ais->distinct();
        $this->ais->select('MS.master_name, BA.budget_id');
        $this->ais->join('master_settings MS', 'MS.master_id=BA.budget_id');
        $this->ais->where(array('BA.programme_id' => $program, 'BA.donor_id' => $donor, 'BA.grant_id' => $grant));
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $this->ais->order_by('MS.master_name', 'asc');
        $query = $this->ais->get('balance_amount BA');
        $rows = $query->result_array();
        return $rows;
    }

    function getLineItemList($program = '', $donor = '', $grant = '', $budget = '') {
        $financialArray = $this->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);
        $this->ais->distinct();
        $this->ais->select('MS.master_name, BA.line_itemid');
        $this->ais->join('master_settings MS', 'MS.master_id=BA.budget_id');
        $this->ais->where(array('BA.programme_id' => $program, 'BA.donor_id' => $donor, 'BA.grant_id' => $grant, 'BA.budget_id' => $budget));
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $this->ais->order_by('MS.master_name', 'asc');
        $query = $this->ais->get('balance_amount BA');
        $rows = $query->result_array();
        return $rows;
    }

    function getAdditionalDetails($program = '', $donor = '', $budget = '', $line = '') {
        $this->ais->select('id,additionalinfo');
        $this->ais->where(array('programme' => $program, 'donor' => $donor, 'budgethead' => $budget, 'lineitem' => $line));
        $this->ais->order_by('additionalinfo', 'asc');
        $query = $this->ais->get('additional_info');
        $rows = $query->result_array();
        return $rows;
    }

    function tot_amt_in($an_id, $an_don, $an_bh, $an_li, $an_details) {
        if ($an_details == NULL || $an_details == '') {
            $an_details = 0;
        }
        $details = array(
            'approval_id' => $an_id,
            'donor' => $an_don,
            'budget_head' => $an_bh,
            'line_item' => $an_li,
            'additionalinfo' => $an_details
        );
        $this->ais->select_sum('amount_toapprove');
        $this->ais->where($details);
        $query = $this->ais->get('internal_note');
        return $query->result_array();
    }

    function checkAmountAssigned($programmeid, $donorid, $budgetid, $lineitemid, $sublinelitem, $from, $to, $grant_id) {
        $this->ais->select('sum(amount)as amount');
        $this->ais->where('programme_id', $programmeid);
        if ($donorid != '') {
            $this->ais->where('donor_id', $donorid);
        }
        if ($budgetid != '') {
            $this->ais->where('budget_id', $budgetid);
        }
        if ($lineitemid != '') {
            $this->ais->where('line_itemid', $lineitemid);
        }
        if ($sublinelitem != '') {
            $this->ais->where('subline_itemid', $sublinelitem);
        }
        if ($grant_id != '') {
            $this->ais->where('grant_id', $grant_id);
        }

        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $query = $this->ais->get('balance_amount');

        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data[0]['amount'];
    }

    function checkApprovalNoteAmount($programme, $donor, $budgethead, $lineitem = 'NULL', $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {
        $data = array();
        $this->ais->select('sum(amt_required)as totalamount');
        $this->ais->join('approval_note AN', 'AN.approval_id=ANDO.approval_id');
        if ($programme != "") {
            $this->ais->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->ais->where('ANDO.donor', $donor);
        }
        if ($budgethead != "") {
            $this->ais->where('ANDO.budget_head', $budgethead);
        }
        if ($lineitem != '') {
            $this->ais->where('ANDO.line_item', $lineitem);
        }
        if ($grant_id != '') {
            $this->ais->where('ANDO.grant_id', $grant_id);
        }
        $this->ais->where('AN.status !=', 'cancelled');
        $this->ais->where("EXTRACT(YEAR_MONTH FROM date_of_request)  >= '$from'");
        $this->ais->where("EXTRACT(YEAR_MONTH FROM date_of_request)  <= '$to'");
        $query = $this->ais->get('approval_note_donors ANDO');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();

        return $data['0']['totalamount'];
    }

    function checkInternalAmount($programme, $donor, $budgethead, $lineitem, $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {
        $data = array();
        $this->ais->distinct();
        $this->ais->select('sum(amount_toapprove)as totalamount');
        $this->ais->join('approval_note AN', 'AN.approval_id=INTER.approval_id', 'left');
        if ($programme != "") {
            $this->ais->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->ais->where('INTER.donor', $donor);
        }
        if ($budgethead != "") {
            $this->ais->where('INTER.budget_head', $budgethead);
        }
        if ($lineitem != "") {
            $this->ais->where('INTER.line_item', $lineitem);
        }
        if ($sublineitem != "") {
            $this->ais->where('INTER.cost_centre', $sublineitem);
        }
        if ($grant_id != "") {
            $this->ais->where('INTER.grant_id', $grant_id);
        }

        $this->ais->where('INTER.status !=', 'cancelled');
        $this->ais->where("EXTRACT(YEAR_MONTH FROM AN.date_of_request)  >= '$from'");
        $this->ais->where("EXTRACT(YEAR_MONTH FROM AN.date_of_request)  <= '$to'");
        $query = $this->ais->get('internal_note INTER');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['totalamount'];
    }

    function checkRecoveredAmount($programme, $donor, $budgethead, $lineitem, $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {
        $data = array();
        $this->ais->select('sum(AD.amount_recovered)as sumamount');
        $this->ais->join('recovered_amount RA', 'RA.id=AD.recover_id', 'left');
        if ($programme != "") {
            $this->ais->where('RA.programme', $programme);
        }
        if ($donor != "") {
            $this->ais->where('RA.donor', $donor);
        }
        if ($budgethead != "") {
            $this->ais->where('RA.budget_head', $budgethead);
        }
        if ($lineitem != "") {
            $this->ais->where('RA.line_item', $lineitem);
        }
        if ($sublineitem != "") {
            $this->ais->where('RA.sub_line_item', $sublineitem);
        }

        if ($grant_id != "") {
            $this->ais->where('RA.grant_id', $grant_id);
        }

        $this->ais->where("EXTRACT(YEAR_MONTH FROM AD.recovered_date)  >= '$from'");
        $this->ais->where("EXTRACT(YEAR_MONTH FROM AD.recovered_date)  <= '$to'");
        $query = $this->ais->get('recovered_amount_detail AD');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['sumamount'];
    }

    function getDTApprovalNotes_old($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL, $report = NULL) {
        $data = array();
        $month = array('1', '2', '3');
        if (in_array(date('m'), $month)) {
            $yr = date("Y") - 1;
            $date = $yr . "-04-01";
        } else
            $date = date("Y-04-01");

        $enddate = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
        $enddate = date("Y-m-d", $enddate);
        $whereArray = array();

        $this->misdb = $this->load->database('mis', TRUE);

        $q = "select IF(AN.donor=0,AN.other_donor,CONCAT(D.master_name,' - ',GL.name)) as donor,
                    IF(line_item=0,other_line_item,LI.master_name) as line_item,
                    IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
                    AN.amt_available, AN.amt_required, AP.payment_favor,
                    MP.programme as programme_name,MP.programme_head,
                    if(AP.raise_from='',AP.from_employee,AP.raise_from)as from_employee,
                    if(AP.raise_RO='',AP.to_RO,AP.raise_RO)as to_RO,
                    MP.programme as programme_name,MP.programme_head,AP.approval_no,AP.date_of_request,AP.date_of_seeking_approval ,AP.date_payment_required,
                    AP.comments_RO, AP.comments_PH, AP.comments_CEO, AP.supporting_documents, AP.estimated_in_workplan, AP.above_50000,
                    AP.purpose,AP.status,AP.RO_status,AP.CEO_status,AP.PH_status,AP.approval_id,AP.internal_note,AP.raise_from, AI.additionalinfo from approval_note AP     ";

        $q .= " left join master_programme MP on AP.programme= MP.programme_id";
        $q .= " left join approval_note_donors AN on AP.approval_id= AN.approval_id";
        $q .= " left join master_settings D on D.master_id= AN.donor";
        $q .= " left join master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join master_settings LI on LI.master_id= AN.line_item";
        $q .= " left join additional_info AI on AI.id = AN.additionalinfo";
        $q .= " left join " . $this->misdb->database . ".grant_list GL on GL.id = AN.grant_id";

        if ($admin == NULL)
            $whereArray[] = "AP.from_employee ='" . $this->session->userdata('user') . "'";

        if ($where != NULL)
            $whereArray[] = $where;

        $whereCond = implode(' and ', $whereArray);

        $financialArray = $this->Mmaster->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);

        if ($whereCond != '') {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and AP.partner_id='" . $this->session->userdata('partner_id') . "' and " . $whereCond;
        } else {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and AP.partner_id='" . $this->session->userdata('partner_id') . "'";
        }

        if ($report == NULL)
            $q .= " group by AP.approval_id";

        if ($orderby != NULL && $ordertype != NULL)
            $q .= " order by " . $orderby . " " . $ordertype;
        else
            $q .= " order by AP.date_of_request DESC";

        if ($num != NULL || $offset != NULL) {
            $offset = (!is_numeric($offset)) ? '0' : $offset;
            $q .= " LIMIT " . $offset . "," . $num;
        }

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getDTApprovalNotesCount($search_field, $search_value, $current_user, $columns, $requestData) {
        $data = array();
        $month = array('1', '2', '3');
        if (in_array(date('m'), $month)) {
            $yr = date("Y") - 1;
            $date = $yr . "-04-01";
        } else
            $date = date("Y-04-01");

        $enddate = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
        $enddate = date("Y-m-d", $enddate);
        $whereArray = array();

//        $misdb = $this->load->database('mis', TRUE);
        $aisdb = $this->load->database('ais', TRUE);

        $q = "select IF(AN.donor=0,AN.other_donor,CONCAT(D.master_name,' - ',GL.name)) as donor,
                    IF(line_item=0,other_line_item,LI.master_name) as line_item,
                    IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
                    AN.amt_available, AN.amt_required, AP.payment_favor,
                    MP.programme as programme_name,MP.programme_head,
                    if(AP.raise_from='',AP.from_employee,AP.raise_from)as from_employee,
                    if(AP.raise_RO='',AP.to_RO,AP.raise_RO)as to_RO,
                    MP.programme as programme_name,MP.programme_head,AP.approval_no,AP.date_of_request,AP.date_of_seeking_approval ,AP.date_payment_required,
                    AP.comments_RO, AP.comments_PH, AP.comments_CEO, AP.supporting_documents, AP.estimated_in_workplan, AP.above_50000,
                    AP.purpose,AP.status,AP.RO_status,AP.CEO_status,AP.PH_status,AP.approval_id,AP.internal_note,AP.raise_from, AI.additionalinfo from " . $aisdb->database . ".approval_note AP";
        $q .= " left join " . $aisdb->database . ".master_programme MP on AP.programme= MP.programme_id";
        $q .= " left join " . $aisdb->database . ".approval_note_donors AN on AP.approval_id= AN.approval_id";
        $q .= " left join " . $aisdb->database . ".master_settings D on D.master_id= AN.donor";
        $q .= " left join " . $aisdb->database . ".master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join " . $aisdb->database . ".master_settings LI on LI.master_id= AN.line_item";
        $q .= " left join " . $aisdb->database . ".additional_info AI on AI.id = AN.additionalinfo";
        $q .= " left join grant_list GL on GL.id = AN.grant_id";
//        $q .= " left join " . $misdb->database . ".grant_list GL on GL.id = AN.grant_id";

        if ($admin == NULL)
            $whereArray[] = "AP.from_employee ='" . $this->session->userdata('user') . "'";

        if ($where != NULL)
            $whereArray[] = $where;

        $whereCond = implode(' and ', $whereArray);

        $financialArray = $this->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);

        if ($whereCond != '') {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and AP.partner_id='" . $this->session->userdata('partner_id') . "' and " . $whereCond;
        } else {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and AP.partner_id='" . $this->session->userdata('partner_id') . "'";
        }

        if ($report == NULL)
            $q .= " group by AP.approval_id";

        if ($orderby != NULL && $ordertype != NULL)
            $q .= " order by " . $orderby . " " . $ordertype;
        else
            $q .= " order by AP.date_of_request DESC";

        if ($num != NULL || $offset != NULL) {
            $offset = (!is_numeric($offset)) ? '0' : $offset;
            $q .= " LIMIT " . $offset . "," . $num;
        }

      

        $query = $this->db->get($q);
        $rows = $query->num_rows();
        return $rows;

//        $query = $this->db->query($q);
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row) {
//                $data[] = $row;
//            }
//        }
//        $query->free_result();
//        return $data;



        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "t1.id = '$search_value'";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(t1.emp_name LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "t4.partner_name LIKE '%$search_value%'";
        } else if ($search_field == '4' && $search_value != '') {
            $cond = "t3.job_title LIKE '%$search_value%'";
        } else if ($search_field == '5' && $search_value != '') {
            $cond = '';
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        if ($this->session->userdata['user_type'] != 'superadmin') {
            $partner_id = $this->session->userdata['partner_id'];
            $this->db->where('t1.partner_id', $partner_id);
        }

        $this->db->where(array('t1.emp_type' => $current_user, 't1.status' => '1'));
        $query = $this->db->get('hr_user_profile t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTApprovalNotes($num, $offset, $search_field, $search_value, $current_user, $columns, $requestData) {

        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.emp_name,t1.emp_type,t3.job_title,t4.partner_name,t5.user_type");
        $this->db->join('hr_job_salary t2', 't2.emp_id =  t1.id', 'left');
        $this->db->join('hr_job_designation t3', 't3.id =  t2.designation', 'left');
        $this->db->join('hr_partner_type t4', 't4.id =  t1.partner_id', 'left');
        $this->db->join('hr_user_type t5', 't5.id =  t1.emp_type', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "t1.id = '$search_value'";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(t1.emp_name LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "t4.partner_name LIKE '%$search_value%'";
        } else if ($search_field == '4' && $search_value != '') {
            $cond = "t3.job_title LIKE '%$search_value%'";
        } else if ($search_field == '5' && $search_value != '') {
            $cond = '';
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        if ($this->session->userdata['user_type'] != 'superadmin') {
            $partner_id = $this->session->userdata['partner_id'];
            $this->db->where('t1.partner_id', $partner_id);
        }

        $this->db->where(array('t1.emp_type' => $current_user, 't1.status' => '1'));
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_user_profile t1');
        $rows = $query->result_array();
        return $rows;
    }

    function getLimitApprovalNotes($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL, $report = NULL) {

        $data = array();
        $month = array('1', '2', '3');
        if (in_array(date('m'), $month)) {
            $yr = date("Y") - 1;
            $date = $yr . "-04-01";
        } else
            $date = date("Y-04-01");

        $enddate = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
        $enddate = date("Y-m-d", $enddate);
        $whereArray = array();
        $aisdb = $this->load->database('ais', TRUE);
        $q = "select IF(AN.donor=0,AN.other_donor,CONCAT(D.master_name,' - ',GL.name)) as donor,
                    IF(line_item=0,other_line_item,LI.master_name) as line_item,
                    IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
                    AN.amt_available, AN.amt_required, AP.payment_favor,
                    MP.programme as programme_name,MP.programme_head,
                    if(AP.raise_from='',AP.from_employee,AP.raise_from)as from_employee,
                    if(AP.raise_RO='',AP.to_RO,AP.raise_RO)as to_RO,
                    MP.programme as programme_name,MP.programme_head,AP.approval_no,AP.date_of_request,AP.date_of_seeking_approval ,AP.date_payment_required,
                    AP.comments_RO, AP.comments_PH, AP.comments_CEO, AP.supporting_documents, AP.estimated_in_workplan, AP.above_50000,
                    AP.purpose,AP.status,AP.RO_status,AP.CEO_status,AP.PH_status,AP.approval_id,AP.internal_note,AP.raise_from, AI.additionalinfo from " . $aisdb->database . ".approval_note AP     ";
        $q .= " left join " . $aisdb->database . ".master_programme MP on AP.programme= MP.programme_id";
        $q .= " left join " . $aisdb->database . ".approval_note_donors AN on AP.approval_id= AN.approval_id";
        $q .= " left join " . $aisdb->database . ".master_settings D on D.master_id= AN.donor";
        $q .= " left join " . $aisdb->database . ".master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join " . $aisdb->database . ".master_settings LI on LI.master_id= AN.line_item";
        $q .= " left join " . $aisdb->database . ".additional_info AI on AI.id = AN.additionalinfo";
        $q .= " left join grant_list GL on GL.id = AN.grant_id";
        $query = $this->db->query($q);

        #print_r($this->session->all_userdata());die;#$userId ='USR122';
        if ($admin == NULL)
            $whereArray[] = "AP.from_employee ='" . $this->session->userdata('user_id') . "'";
        # $whereArray[] = "AP.from_employee ='" . $userId . "'";
        if ($where != NULL)
            $whereArray[] = $where;

        $whereCond = implode(' and ', $whereArray);
        #echo'<pre>';print_r($whereCond);die;
        $financialArray = $this->findCurrentFinancialYears();
        $from = $this->convertMonthYearFroms($financialArray[0]['from']);
        $to = $this->convertMonthYearTos($financialArray[0]['to']);

        if ($whereCond != '') {
            $q .=" Where $whereCond";
            /* $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and AP.partner_id='" . $this->session->userdata('partner_id') . "' and " . $whereCond;  */
        } else {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and AP.partner_id='" . $this->session->userdata('partner_id') . "'";
        }

        if ($report == NULL)
            $q .= " group by AP.approval_id";

        if ($orderby != NULL && $ordertype != NULL)
            $q .= " order by " . $orderby . " " . $ordertype;
        else
            $q .= " order by AP.date_of_request DESC";


        if ($num != NULL || $offset != NULL) {
            $offset = (!is_numeric($offset)) ? '0' : $offset;
            $q .= " LIMIT " . $offset . "," . $num;
        }

        #echo $q;die;
        $query = $this->db->query($q);

        #echo'<pre>';print_r($query->result());die;

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function findCurrentFinancialYears() {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('status', '1');
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->ais->get('financial_year');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function convertMonthYearFroms($from) {
        $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
            'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
        $fromarray = explode(' ', $from);
        if (!empty($fromarray)) {
            list($fromMonth, $fromYear) = array_pad(explode(' ', $from, 2), 2, null);
        }

        $fromMonth = $month[$fromMonth];
        $yearmonth1 = $fromYear . $fromMonth;
        return $yearmonth1;
    }

    function convertMonthYearTos($to) {
        $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
            'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
        list($toMonth, $toYear) = array_pad(explode(' ', $to, 2), 2, null);
        if (isset($toMonth)) {
            $toMonth = $month[$toMonth];
        }

        $yearmonth2 = $toYear . $toMonth;
        return $yearmonth2;
    }

    function getUserNameInfo($userid) {
        $data = array();
        $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,admin_email,personal_email,official_email", false);
        $this->db->where('hr_user_profile.id', $userid);
        $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
        $query = $this->db->get('hr_user_login');
	
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getApprovalSetting($option) {
        $data = array();
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->ais->get('approval_setting');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            $query->free_result();
            return $data['0'][$option];
        }
    }

    function getPartner($id) {

        $this->ais->select('*');
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $this->ais->where('approval_id', $id);
        $query = $this->ais->get('approval_note');
        return $query->num_rows();
    }

    function get_grantList($id = '') {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $this->db->select(array('name', 'id'));
        $query = $this->db->get('grant_list');
        return $query->result();
    }

    function selectComment($id) {
        $data = array();
        if ($id != NULL)
            $this->ais->where('approval_id', $id);
        $this->ais->order_by("id", "desc");
        $this->ais->limit(5);
        $query = $this->ais->get('approval_note_comment');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function selectTotalComment($id) {
        $data = array();
        if ($id != NULL)
            $this->ais->where('approval_id', $id);
        $this->ais->order_by("id", "desc");
        $query = $this->ais->get('approval_note_comment');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return 0;
    }

    function adminDetails() {
        $data = array();
        $this->db->where('is_admin', 'Yes');
        $query = $this->db->get('hr_users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getApprovalNote($id) {
        $data = array();
        $query = $this->ais->query("SELECT master_programme.programme as programme_name,master_programme.programme_head,approval_note.programme,
			  if(approval_note.raise_RO='',approval_note.to_RO,approval_note.raise_RO)as to_RO,
			  if(approval_note.raise_from='',approval_note.from_employee,approval_note.raise_from)as from_employee,
			  approval_note.approval_no,approval_note.partner_id,approval_note.date_of_request,approval_note.date_of_seeking_approval,approval_note.date_payment_required,
			  approval_note.purpose,approval_note.status,approval_note.approval_id,approval_note.internal_note,
			  approval_note.above_50000,approval_note.RO_status,approval_note.PH_status,approval_note.CEO_status,approval_note.RO_date,
			  approval_note.PH_date,approval_note.CEO_date,approval_note.approved_ro,approval_note.approved_by,approval_note.ip_address,approval_note.approved_from,
			  approval_note.supporting_documents,approval_note.finance_comments,approval_note.comments_RO,approval_note.comments_PH,
			  approval_note.comments_CEO,approval_note.estimated_in_workplan,approval_note.attachment,approval_note.raise_from,
			  approval_note.payment_favor,approval_note.check_no,approval_note.finance_status
			  FROM (`approval_note`)
			  LEFT JOIN `master_programme` ON `master_programme`.`programme_id` = `approval_note`.`programme`
			  WHERE `approval_note`.`approval_id` = '$id' ");

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_partnerName($partner_id) {
        $data = array();
        $this->db->select("currency");
        $this->db->where('id', $partner_id);
        $query = $this->db->get('hr_partner_type');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function reportingUser($type, $field, $empNumber = NULL) { #echo '<pre>'; print_r($this->session->all_userdata());exit;
        $subUserArray = array();
        if ($empNumber == NULL) {
            $employees = $this->getReportingUser($this->session->userdata('emp_number'), $type);
        } else {
            $employees = $this->getReportingUser($empNumber, $type);
        }

        foreach ($employees as $row) {
            $subUserArray[] = $row['id'];
        }
        if ($field == 'userId')
            return $subUserArray;
        else
            return $employees;
    }

    function getReportingUser($employeeId, $option) {
        $data = array();
        if ($option == 'subUser') {
            $lable1 = 'report_subordinate';
            $lable2 = 'report_supervisor';
        } elseif ($option == 'supUser') {
            $lable1 = 'report_supervisor';
            $lable2 = 'report_subordinate';
        }
        $this->db->where($lable1, $employeeId);
        $this->db->select($lable2 . ",CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id,official_email,personal_email", false);
        $this->db->join("hr_user_profile", 'hr_user_profile.id=hr_user_reporting.' . $lable2);
        $query = $this->db->get('hr_user_reporting');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function int_amt_sumof($id) {
        $q1 = "select sum(amount_toapprove) as int_amount from internal_note where approval_id='" . $id . "' and status <> 'cancelled' and status <> 'draft'";
        $query1 = $this->ais->query($q1);
        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row1) {
                $data = $row1['int_amount'];
            }
        }
        $query1->free_result();
        if ($data)
            return $data;
        else
            return 0;
    }

    function getApprovalDonors($id) {
        $data = array();
        $q = "select AN.grant_id,AN.approval_donor_id,
            IF(AN.donor=0,other_donor,D.master_name) as donor,
            IF(line_item=0,other_line_item,LI.master_name) as line_item,
            IF(cost_centre=0,other_cost_centre,CC.master_name) as cost_centre,
            IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
            AN.amt_available,
            AN.amt_required, AI.additionalinfo from approval_note_donors AN";
        $q .= " left join master_settings D on D.master_id= AN.donor";
        $q .= " left join master_settings CC on CC.master_id= AN.cost_centre";
        $q .= " left join master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join master_settings LI on LI.master_id= AN.line_item";
        $q .= " left join additional_info AI on AI.id = AN.additionalinfo";
        $q .= " where approval_id='" . $id . "'";

        /* $offset = 0;
          $num = 3;
          $q .= " LIMIT " . $offset . "," . $num; */

        $query = $this->ais->query($q);
        #echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $query->result_array();
    }

    function insertapprovaldraft() {
        $fNameArray = array();
        $file_name = $_FILES['fileX']['name'];
        $file_tmp_name = $_FILES['fileX']['tmp_name'];
        foreach ($file_name as $key => $value):
            if ($value != '') {
                $fName = rand() . "_" . str_replace(" ", "_", $value);
                @copy($file_tmp_name[$key], "uploads/support_docs/" . $fName);
                $fNameArray[] = $fName;
            }
        endforeach;
        $work_plan = 'yes';
        $amount = 0;
        foreach ($this->input->post('amt_required') as $key => $value):
            $amount += $value;
        endforeach;
        if ($this->session->userdata('currency') == 'INR' && $amount > 50000) {
            $above = 'yes';
        } else if ($this->session->userdata('currency') != 'INR' && $amount > 1500) {
            $above = 'yes';
        } else {
            $above = 'no';
        }

//        $get_date = date('d');
//        if ($get_date != 30)
//            $financial_date = date("2019-03-31");
//        else
//            $financial_date = date("Y:m:d");

        $data = array('approval_no' => $this->approvalNumber(),
            'date_of_request' => date("Y:m:d"),
            'date_of_seeking_approval' => ddmmyyyy2mysql($this->input->post('date_of_seeking_approval')),
            //'date_of_request' => "2023-03-31",
            //'date_of_seeking_approval' => "2023-03-31",
            'from_employee' => $this->session->userdata('user'),
//            'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'to_RO' => $this->input->post('to_RO'),
            'purpose' => $this->input->post('purpose'),
            'programme' => $this->input->post('programme'),
            'UCID' => $this->input->post('UCID'),
            'supporting_documents' => implode(',', $this->input->post('supporting_documents')),
            'above_50000' => $above,
            'status' => 'draft',
            'comments_RO' => '',
            'comments_PH' => '',
            'partner_id' => $this->session->userdata('partner_id'),
            'attachment' => serialize($fNameArray));
        $this->db->insert('approval_note', $data);
        $id = $this->db->insert_id();
        $this->insertDonors($id);
        return true;
    }

    function insertApprovalNote() {
        $fNameArray = array();
        $file_name = $_FILES['fileX']['name'];
        $file_tmp_name = $_FILES['fileX']['tmp_name'];
        foreach ($file_name as $key => $value):
            if ($value != '') {
                $fName = rand() . "_" . str_replace(" ", "_", $value);
                @copy($file_tmp_name[$key], "uploads/support_docs/" . $fName);
                $fNameArray[] = $fName;
            }
        endforeach;
        $yes = 'yes';
        $amount = 0;
        foreach ($this->input->post('amt_required') as $key => $value):
            $amount += $value;
        endforeach;
        if ($this->session->userdata('currency') == 'INR' && $amount > 50000) {
            $above = 'yes';
        } else if ($this->session->userdata('currency') != 'INR' && $amount > 1500) {
            $above = 'yes';
        } else {
            $above = 'no';
        }

//        $get_date = date('d');
//        if ($get_date != 30)
//            $financial_date = date("2019-03-31");
//        else
//            $financial_date = date("Y:m:d");

        $data = array('approval_no' => $this->approvalNumber(),
            'date_of_request' => date("Y:m:d"),
            'date_of_seeking_approval' => ddmmyyyy2mysql($this->input->post('date_of_seeking_approval')),
            //'date_of_request' => "2023-03-31",
            //'date_of_seeking_approval' => "2023-03-31",
            'from_employee' => $this->session->userdata('user'),
//            'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'to_RO' => $this->input->post('to_RO'),
            'purpose' => $this->input->post('purpose'),
            'comments_RO' => '',
            'comments_PH' => '',
            'programme' => $this->input->post('programme'),
            'UCID' => $this->input->post('UCID'),
            'supporting_documents' => implode(',', $this->input->post('supporting_documents')),
            'estimated_in_workplan' => $yes,
            'partner_id' => $this->session->userdata('partner_id'),
            'above_50000' => $above,
            'attachment' => serialize($fNameArray));

        $this->db->insert('approval_note', $data);
        $id = $this->db->insert_id();
        $this->insertDonors($id);
        $this->updateApprovalId($id);
        return $id;
    }

    function getMasterSetting($masterType = NULL, $id = NULL, $pid = NULL, $program = NULL) {

        $donor_id = explode(',', $this->getdonorsfromprogram($program));
        $partner_id = $this->session->userdata('partner_id');

        $data = array();
        $this->ais->where('ms.status', '1');
        $this->ais->where('ms.partner_id', $partner_id);
        if ($pid != NULL)
            $this->ais->where_in('ms.pid', $pid);

        if ($masterType != NULL) {
            $this->ais->select('ms.master_id,ms.master_name');
            if ($masterType == 'Budget Head') {
                $this->ais->join('master_settings DMS', 'DMS.master_id=ms.pid', 'left');
            } else if ($masterType == 'Line Item') {
                $this->ais->join('master_settings BMS', 'BMS.master_id=ms.pid', 'left');
                $this->ais->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
            } else if ($masterType == 'Cost Centre') {
                $this->ais->join('master_settings CMS', 'CMS.master_id=ms.pid', 'left');
                $this->ais->join('master_settings BMS', 'BMS.master_id=CMS.pid', 'left');
                $this->ais->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
            }
            if ($donor_id[0] != '' && $masterType != 'Donor') {
                $this->ais->where_in('DMS.master_id', $donor_id);
            } else if ($donor_id[0] != '') {
                $this->ais->where_in('ms.master_id', $donor_id);
            }
            $this->ais->where('ms.master_type', $masterType);
        }
        if ($id != NULL) {
            $this->ais->where('ms.master_id', $id);
            $this->ais->select('ms.master_name');
        }

        $this->ais->order_by('ms.master_name');
        $query = $this->ais->get('master_settings ms');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getBalanceProgramme($id = NULL) {
        $data = array();
        $financial = $this->findCurrentFinancialYear();
        $from = converttodate($financial[0]['from']);
        $to = converttodate($financial[0]['to']);
        $this->ais->select('MP.*');
        $this->ais->join('balance_amount BA', 'BA.programme_id=MP.programme_id');
        $this->ais->where('MP.status', '1');
        if ($id != NULL)
            $this->ais->where('MP.programme_id', $id);
        $this->ais->where('BA.amount_date >=', $from);
        $this->ais->where('BA.amount_date <=', $to);
        $this->ais->where('MP.partner_id', $this->session->userdata('partner_id'));
        $this->ais->group_by('BA.programme_id');
        $this->ais->order_by('MP.programme', 'asc');
        $query = $this->ais->get('master_programme MP');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getdonorsfromprogram($program) {
        $data = '';
        $this->ais->where('programme_id', $program);
        $this->ais->select('donor');
        $query = $this->ais->get('master_programme');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = unserialize($row['donor']);
            }
        }
        $data = ($data != '') ? implode(',', $data) : '';
        return $data;
    }

    function getRecords($TableName = NULL, $Label = NULL, $Id = NULL) {
        $data = array();
        if ($Id != NULL && $Label != NULL)
            $this->ais->where($Label, $Id);
        $query = $this->ais->get($TableName);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getempidfromuserid($userid) {
        $this->db->select('emp_id');
        $this->db->where("id", $userid);
        $query = $this->db->get('hr_user_login');
        return $query->result_array();
    }

    function converttodate($data) {
        $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
            'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
        @list($Month, $Year) = array_pad(explode(' ', $data, 2), 2, null);
        if (isset($Month))
            @$Month = $month[$Month];
        $day = '01';
        if ($Month == '03')
            $day = '31';
        $date = $Year . '-' . $Month . '-' . $day;
        return $date;
    }

    function getBalanceDonor($id = NULL) {
        $data = array();
        $financial = $this->findCurrentFinancialYear();
        $from = $this->converttodate($financial[0]['from']);
        $to = $this->converttodate($financial[0]['to']);
        $this->ais->select('BA.donor_id');
        if ($id != NULL)
            $this->ais->where('BA.programme_id', $id);
        $this->ais->where('BA.amount_date >=', $from);
        $this->ais->where('BA.amount_date <=', $to);
        $this->ais->group_by(array("BA.programme_id", "BA.donor_id"));
        $query = $this->ais->get('balance_amount BA');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['donor_id'];
            }
        }
        $query->free_result();
        return $data;
    }

    function getCurrentInAmt($programme = '', $donor = '', $budgethead = '', $lineitem = '', $details, $approval_id = '') {
        if ($details == NULL || $details == '') {
            $details = 0;
        }
        $this->ais->select('sum(amount_toapprove) as amount_toapprove');
        $this->ais->where('approval_id', $approval_id);
        $this->ais->where('additionalinfo', $details);
        $this->ais->where('donor', $donor);
        $this->ais->where('budget_head', $budgethead);
        $this->ais->where('line_item', $lineitem);
        $query = $this->ais->get('internal_note');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                return $row['amount_toapprove'];
            }
        } else {
            return 0;
        }
    }

    function getCurrentAmt($programme = '', $donor = '', $budgethead = '', $lineitem = '', $approval_id = '') {
        $this->ais->select('ANDO.amt_required');
        $this->ais->join('approval_note AN', 'AN.approval_id=ANDO.approval_id');
        $this->ais->where('AN.approval_id', $approval_id);
        $this->ais->where('ANDO.donor', $donor);
        $this->ais->where('ANDO.budget_head', $budgethead);
        $this->ais->where('ANDO.line_item', $lineitem);
        $query = $this->ais->get('approval_note_donors ANDO');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                return $row['amt_required'];
            }
        } else {
            return 0;
        }
    }

    function updateApprovalNote() {
        #error_reporting(-1);
        $fNameArray = array();
        if (is_array($this->input->post('fArray'))) {
            foreach (@$this->input->post('fArray') as $key => $value):
                $fNameArray[] = $value;
            endforeach;
        }
        $file_name = $_FILES['meet_doc']['name'];
        $file_tmp_name = $_FILES['meet_doc']['tmp_name'];
        foreach ($file_name as $key => $value):
            if ($value != '') {
                $fName = rand() . "_" . str_replace(" ", "_", $value);
                @copy($file_tmp_name[$key], "uploads/support_docs/" . $fName);
                $fNameArray[] = $fName;
            }
        endforeach;
        $above = 'no';
        $work_plan = 'yes';
        $amount = '';
        foreach ($this->input->post('amt_required') as $key => $value) {

            $amount += $value;
        }
        if ($this->session->userdata('currency') == 'INR' && $amount > 50000) {
            $above = 'yes';
        } else if ($this->session->userdata('currency') != 'INR' && $amount > 1500) {
            $above = 'yes';
        } else {
            $above = 'no';
        }


        $status = $this->getstatusapprovalnote($this->input->post('approval_id'));

        if ($status[0]['RO_status'] == 'defered') {
            $ro_status = 'pending';
            $ph_status = 'pending';
            if ($status[0]['CEO_status'] != 'defered') {
                $ceo_status = $status[0]['CEO_status'];
            } else {
                $ceo_status = 'pending';
            }
            $stat = 'pending';
        } else if ($status[0]['RO_status'] == 'pending' && $status[0]['CEO_status'] == 'defered') {
            $ro_status = 'pending';
            $ph_status = 'pending';
            $ceo_status = 'pending';
            $stat = 'pending';
        } else if ($status[0]['RO_status'] == 'confirmed' && $status[0]['PH_status'] == 'confirmed' && $status[0]['CEO_status'] == 'pending' && $status[0]['status'] == 'confirmed') {
            $ro_status = 'confirmed';
            $ph_status = 'confirmed';
            $ceo_status = 'pending';
            $stat = 'confirmed';
        } else if ($status[0]['RO_status'] == 'confirmed' && $status[0]['PH_status'] == 'confirmed' && $status[0]['CEO_status'] == 'pending') {
            $ro_status = 'confirmed';
            $ph_status = 'confirmed';
            $ceo_status = 'pending';
            $stat = 'pending';
        } else if ($status[0]['RO_status'] == 'confirmed' && $status[0]['PH_status'] == 'defered' && $status[0]['CEO_status'] == 'pending') {
            $ro_status = 'confirmed';
            $ph_status = 'pending';
            $ceo_status = 'pending';
            $stat = 'pending';
        } else if ($status[0]['PH_status'] == 'defered') {
            $ro_status = 'pending';
            $ph_status = 'pending';
            $ceo_status = $status[0]['CEO_status'];
            $stat = 'pending';
        } else if ($status[0]['CEO_status'] == 'defered') {
            $ceo_status = 'pending';
            $ro_status = $status[0]['RO_status'];
            $ph_status = 'pending';
            $stat = 'pending';
        } else {
            $ro_status = $status[0]['RO_status'];
            $ph_status = $status[0]['PH_status'];
            $ceo_status = $status[0]['CEO_status'];
            $stat = $status[0]['status'];
        }

        if ($status[0]['status'] == 'draft') {
            $ro_status = $status[0]['RO_status'];
            $ph_status = $status[0]['PH_status'];
            $ceo_status = $status[0]['CEO_status'];
            $stat = 'pending';
        }
        $this->ais->where('approval_id', $this->input->post('approval_id'));
        $query = $this->ais->get('approval_note_donors');
        $count = $query->num_rows();
        if ($count > 0) {
            $result = $query->result_array();
        }

        $olddetails = array(
            'approval_id' => $this->input->post('approval_id'),
            'edited_by' => $this->session->userdata('user'),
            'programme_id' => $this->input->post('program_id'),
            'date_of_seeking_approval' => date("Y-m-d", strtotime($this->input->post('date_of_seeking_approval'))),
            //'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'to_RO' => $this->input->post('to_RO'),
            'grant_id' => $result[$key]['grant_list'],
            'donor' => $result[$key]['donor'],
            'budget_head' => $result[$key]['budget_head'],
            'line_item' => $result[$key]['line_item'],
            'amt_available' => $result[$key]['amt_available'],
            'amt_required' => $result[$key]['amt_required']
        );

        $editedAN = $this->insertANedithistory($olddetails);
        $supporting_documents = 'supporting_documents';
        if ($this->input->post('supporting_documents') != '') {
            $supporting_documents = implode(',', $this->input->post('supporting_documents'));
        }
        $data = array(
            'date_of_seeking_approval' => date("Y-m-d", strtotime($this->input->post('date_of_seeking_approval'))),
            //'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'purpose' => $this->input->post('purpose'),
            'to_RO' => $this->input->post('to_RO'),
            'supporting_documents' => $supporting_documents,
            'estimated_in_workplan' => $work_plan,
            'above_50000' => $above,
            'RO_status' => $ro_status,
            'PH_status' => $ph_status,
            'CEO_status' => $ceo_status,
            'status' => $stat,
            'attachment' => serialize($fNameArray));

        $this->ais->where('approval_id', $this->input->post('approval_id'));
        $this->ais->update('approval_note', $data);
        $this->ais->where('approval_id', $this->input->post('approval_id'));
        $this->ais->delete('approval_note_donors');
        $this->insertDonors($this->input->post('approval_id'));

        return true;
    }

    function getstatusapprovalnote($id) {
        $this->ais->select('RO_status,PH_status,CEO_status,status');
        $this->ais->where('approval_id', $id);
        $query = $this->ais->get('approval_note');
        return $query->result_array();
    }

    function insertDonors($id) {
        $donor = $this->input->post('donor_list');
        $grant_list = $this->input->post('grant_list');
        $other_donor = $this->input->post('other_donor');
        $budget_head = $this->input->post('budget_list');
        $other_budget_head = $this->input->post('other_budget_head');
        $line_item = $this->input->post('line_list');
        $other_line_item = $this->input->post('other_line_item');
        $cost_centre = $this->input->post('cost_centre');
        $other_cost_centre = $this->input->post('other_cost_centre');
        $additional_info = $this->input->post('additional_list');
        $amt_available = $this->input->post('amt_available');
        $amt_required = $this->input->post('amt_required');
        foreach ($donor as $key => $value):
            $data = array('approval_id' => $id,
                'budget_head' => $budget_head[$key],
                'grant_id' => $grant_list[$key],
                'donor' => $donor[$key],
                'line_item' => $line_item[$key],
                'other_budget_head' => $other_budget_head[$key],
                'other_donor' => $other_donor[$key],
                'other_line_item' => $other_line_item[$key],
                'cost_centre' => $cost_centre[$key],
                'other_cost_centre' => $other_cost_centre[$key],
                'additionalinfo' => $additional_info[$key],
                'amt_available' => $amt_available[$key],
                'amt_required' => $amt_required[$key]);

            #echo'<pre>';print_r($data);die;
            $this->ais->insert('approval_note_donors', $data);
        endforeach;
    }

    function insertANedithistory($data) {
        $this->ais->insert('an_edit_history', $data);
        return true;
    }

    function get_allGrantVal($id = '') {
        $data = array();
        $this->ais = $this->load->database('ais', TRUE);
        $query = "select t1.grant_id, t1.status_type from grant_list t1 left join " . $this->ais->database . ".approval_note_donors t2 on t1.id = t1.grant_id where t2.approval_id = '" . $id . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function getarchiveApprovalNotes($from = NULL, $to = NULL, $num = NULL, $offset = NULL, $where = NULL, $orderby = NULL, $ordertype = NULL) {
        $data = array();
        $q = "select IF(AN.donor=0,AN.other_donor,D.master_name) as donor,
                        IF(line_item=0,other_line_item,LI.master_name) as line_item,
                        IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
                        AN.amt_available, AN.amt_required , AP.payment_favor,
                        MP.programme as programme_name,MP.programme_head,
                        if(AP.raise_from='',AP.from_employee,AP.raise_from)as from_employee,
                        if(AP.raise_RO='',AP.to_RO,AP.raise_RO)as to_RO,
                        MP.programme as programme_name,MP.programme_head,AP.approval_no,AP.date_of_request,AP.date_of_seeking_approval ,AP.date_payment_required,
                        AP.purpose,AP.status,AP.approval_id,AP.internal_note,AP.raise_from, AI.additionalinfo from approval_note AP     ";
        $q .= " left join master_programme MP on AP.programme= MP.programme_id";
        $q .= " left join approval_note_donors AN on AP.approval_id= AN.approval_id";
        $q .= " left join master_settings D on D.master_id= AN.donor";
        $q .= " left join master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join master_settings LI on LI.master_id= AN.line_item";
        $q .= " left join additional_info AI on AI.id = AN.additionalinfo";

        $financeuser = array_pop($this->getfinanceusers());

        if ($where != NULL) {
            $whereArray[] = $where;
            $whereCond = implode(' and ', $whereArray);
        } else {
            $whereCond = "1=1";
        }
        $q .= " where  AP.date_of_request >= '" . $from . "' and AP.date_of_request <= '" . $to . "' and $whereCond";

        if ($orderby != NULL && $ordertype != NULL)
            $q .= " order by " . $orderby . " " . $ordertype;
        else
            $q .= " order by AP.date_of_request DESC";

        if ($num != NULL || $offset != NULL) {
            $offset = (!is_numeric($offset)) ? '0' : $offset;
            $q .= " LIMIT " . $offset . "," . $num;
        }
        $query = $this->ais->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getarchiveApprovalNotesCount($from = NULL, $to = NULL, $where = NULL) {
        $data = array();
        $q = "select IF(AN.donor=0,AN.other_donor,D.master_name) as donor,
                        IF(line_item=0,other_line_item,LI.master_name) as line_item,
                        IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
                        AN.amt_available, AN.amt_required, AP.payment_favor,
                        MP.programme as programme_name,MP.programme_head,
                        if(AP.raise_from='',AP.from_employee,AP.raise_from)as from_employee,
                        if(AP.raise_RO='',AP.to_RO,AP.raise_RO)as to_RO,
                        MP.programme as programme_name,MP.programme_head,AP.approval_no,AP.date_of_request,AP.date_of_seeking_approval ,AP.date_payment_required,
                        AP.purpose,AP.status,AP.approval_id,AP.internal_note,AP.raise_from from approval_note AP     ";
        $q .= " left join master_programme MP on AP.programme= MP.programme_id";
        $q .= " left join approval_note_donors AN on AP.approval_id= AN.approval_id";
        $q .= " left join master_settings D on D.master_id= AN.donor";
        $q .= " left join master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join master_settings LI on LI.master_id= AN.line_item";

        $financeuser = array_pop($this->getfinanceusers());

        if ($where != NULL) {
            $whereArray[] = $where;
            $whereCond = implode(' and ', $whereArray);
        } else {
            $whereCond = "1=1";
        }

        $q .= " where  AP.date_of_request >= '" . $from . "' and AP.date_of_request <= '" . $to . "' and $whereCond";
        $query = $this->ais->query($q);
        return $query->num_rows();
    }

    function getfinanceusers() {
        $data = array();
        $this->ais->where('partner_id', 1);
        $query = "select * from approval_setting";
        $result = $this->ais->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = unserialize($row['finance']);
        }
        return $data;
    }

    function getfinanciallist() {
        $data = array();
        $query = "select * from financial_year where status = '0'";
        $result = $this->ais->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function getApprovalDonors_id($id) {
        $data = array();
        $q = "select AN.approval_donor_id,IF(donor=0,other_donor,D.master_id) as donor,
                IF(line_item=0,other_line_item,LI.master_id) as line_item,
                IF(cost_centre=0,other_cost_centre,CC.master_id) as cost_centre,
                IF(budget_head=0,other_budget_head,BH.master_id) as budget_head,
                AN.amt_available,AN.additionalinfo,
                AN.amt_required from approval_note_donors AN";
        $q .= " left join master_settings D on D.master_id= AN.donor";
        $q .= " left join master_settings CC on CC.master_id= AN.cost_centre";
        $q .= " left join master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join master_settings LI on LI.master_id= AN.line_item";
        $q .= " where approval_id='" . $id . "'";

        $query = $this->ais->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    function internalnoteid($id) {
        $data = array();
        $q = "select internal_id, approval_id, amount_toapprove, donor, line_item, cost_centre, budget_head
		  from internal_note where approval_id='" . $id . "' and status <> 'cancelled'";

        $query = $this->ais->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function action_close($status, $id) {
        $this->ais->set('status', $status);
        $this->ais->where('approval_id', $id);
        $this->ais->update('approval_note');
        return $this->ais->affected_rows();
    }

    function update_apn($id, $amt, $apn_donor_id) {
        $this->ais->set('amt_required', $amt);
        $this->ais->where('approval_id', $id);
        $this->ais->where('approval_donor_id', $apn_donor_id);
        $this->ais->update('approval_note_donors');
        return true;
    }

    function inserttodb($approvalid, $message) {

        if (!empty($_POST)) {
            $commentdate = date("Y-m-d H:i:s");
            $fromemployee = $this->session->userdata('username');
            $empid = $this->session->userdata('user');
            $commentArray = array(
                'approval_id' => $approvalid,
                'from_employee' => $fromemployee,
                'empid' => $empid,
                'message' => $message,
                'commentdate' => $commentdate
            );
            $this->ais->insert('approval_note_comment', $commentArray);
            return $this->returnMarkup($fromemployee, $message, $commentdate);
        }
    }

    function returnMarkup($fromemployee, $message, $commentdate) {
        return '<div class="commentPanel" id="commentPanel" align="left">
                <label style="float:left;"><b>' . $fromemployee . '</b></label>
                <span class="commentdate">' . $commentdate . '</span>
                <div style="float:left;">
                <label class="postedComments ">' . $message . '</label>
                </div> </div>';
    }

    function actionApprovePH($option, $id) {
        if ($option == 'approve') {
            $this->ais->set('PH_status', 'confirmed');
            $this->ais->set('status', 'pending');
        } else if ($option == 'disapprove') {
            $this->ais->set('PH_status', 'cancelled');
            $this->ais->set('status', 'cancelled');
        } else {
            $this->ais->set('PH_status', 'defered');
            $this->ais->set('status', 'defered');
            $this->ais->set('RO_status', 'confirmed');
        }
        $this->ais->set('PH_date', date("Y-m-d H:i:s"));
        $this->ais->set('comments_PH', $this->input->post('comments_PH'));
        $this->ais->where('approval_id', $id);
        $this->ais->update('approval_note');
        return $this->ais->affected_rows();
    }

    function approval_confirmed($id) {
        $this->ais->set('status', 'confirmed');
        $this->ais->where('CEO_status', 'confirmed');
        $this->ais->where('PH_status', 'confirmed');
        $this->ais->where('RO_status', 'confirmed');
        $this->ais->where('approval_id', $id);
        $this->ais->update('approval_note');
        return $this->ais->affected_rows();
    }

    function getEmployeeFromUserId($userId) {
        $data = $this->getUserInfo($userId);
        if (count($data)) {
            return $this->employeeDetails($data['0']['emp_id']);
        } else
            return true;
    }

    function getUserInfo($userId) {

        #$data = $dataArr = array();
        $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,emp_gender,official_mobile", false);
        $this->db->where('hr_user_login.emp_id', $userId);
        $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
        $this->db->group_by('hr_user_login.user_name');
        $query = $this->db->get('hr_user_login');
        if ($query->num_rows() > 0) {
            $dataArr = json_decode(json_encode($query->result()), true);
        }

        return $dataArr;
    }

    function employeeDetails($employeeId) {
        $data = array();
        $this->db->where('id', $employeeId);
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getCeo() {
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $this->ais->select('ceo');
        $query = $this->ais->get('approval_setting');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $rows) {
                $ceoid = $rows['ceo'];
            }
        }
        return $ceoid;
    }

    function actionApproveCEO($option, $id) {
        if ($option == 'approve') {
            $this->ais->set('CEO_status', 'confirmed');
            $this->ais->set('status', 'pending');
        } elseif ($option == 'disapprove') {
            $this->ais->set('CEO_status', 'cancelled');
            $this->ais->set('status', 'cancelled');
        } else if ($this->input->post('employee') == 'programme_head') {
            $this->ais->set('CEO_status', 'defered');
            $this->ais->set('PH_status', 'pending');
            $this->ais->set('status', 'defered');
        } else {
            $this->ais->set('CEO_status', 'defered');
            $this->ais->set('PH_status', 'pending');
            $this->ais->set('RO_status', 'pending');
            $this->ais->set('status', 'defered');
        }

        $this->ais->set('approved_by', $approveby);
        $this->ais->set('ip_address', $ipaddress);
        $this->ais->set('approved_from', $approve_from);
        $this->ais->set('CEO_date', date("Y-m-d H:i:s"));
        $this->ais->set('comments_CEO', $this->input->post('comments_CEO'));
        $this->ais->where('approval_id', $id);
        $this->ais->update('approval_note');
        return $this->ais->affected_rows();
    }

    function mailContent($requestId, $touser = NULL) {
        $approvalDetails = $this->getApprovalNote($requestId);
        $approvalDonorsList = $this->getApprovalDonors($requestId);
        $employeeDetails = $this->getEmployeeFromUserId($approvalDetails['0']['from_employee']);
        $empEmail = $employeeDetails['0']['emp_work_email'] != '' ? $employeeDetails['0']['emp_work_email'] : $employeeDetails['0']['emp_oth_email'];
        $reportingAuth = $this->reportingUser('supUser', 'All', $employeeDetails['0']['emp_number']);
        $roName = $reportingAuth[0]['user_name'];
        if (count($reportingAuth) == 1)
            $reportAuthEmail = $reportingAuth['0']['emp_work_email'] != '' ? $reportingAuth['0']['emp_work_email'] : $reportingAuth['0']['emp_oth_email'];
        else if (count($reportingAuth) > 1) {
            $rodetails = $this->getUserNameInfo($approvalDetails['0']['to_RO']);
            $reportAuthEmail = $rodetails['0']['emp_work_email'] != '' ? $rodetails['0']['emp_work_email'] : $rodetails['0']['emp_oth_email'];
        } else
            $reportAuthEmail = '';

        $adminEmail = $this->session->userdata('adminEmail');
        $phDetails = $this->getEmployeeFromUserId($approvalDetails['0']['programme_head']);
        $phEmail = $phDetails['0']['emp_work_email'] != '' ? $phDetails['0']['emp_work_email'] : $phDetails['0']['emp_oth_email'];
        $ceoUser = $this->getApprovalSetting('ceo');
        $ceoDetails = $this->getEmployeeFromUserId($ceoUser);
        $ceoEmail = $ceoDetails['0']['emp_work_email'] != '' ? $ceoDetails['0']['emp_work_email'] : $ceoDetails['0']['emp_oth_email'];

        switch ($touser) {
            case('To'):
                $toName = $roName;
                break;
            case('employee'):
                $toName = $employeeDetails['0']['emp_firstname'];
                break;
            case('ph'):
                $toName = $phDetails['0']['emp_firstname'];
                break;
            case('ceo'):
                $toName = $ceoDetails['0']['emp_firstname'];
                break;
        }

        $donors = '<table cellspacing="1" width="100%" align="center"  cellpadding="7" cellspacing="2" border="0"  >
                        <tr>
                            <td bgcolor="#EFEFEF"><strong>Donor</strong></td>
                            <td bgcolor="#EFEFEF"><strong>Budget Head</strong></td>
                            <td bgcolor="#EFEFEF"><strong>Line Item</strong></td>
                            <td bgcolor="#EFEFEF"><strong>Detail</strong></td>
                            <td bgcolor="#EFEFEF"><strong>Amount Available</strong></td>
                            <td bgcolor="#EFEFEF"><strong>Amount Required</strong></td>
                        </tr>';

        foreach ($approvalDonorsList as $row) {
            $donors .= '<tr bgcolor="#F0F0F0">
                            <td>' . $row["donor"] . '</td>
                            <td>' . $row["budget_head"] . '</td>
                            <td>' . $row["line_item"] . '</td>
                            <td>' . $row["additionalinfo"] . '</td>
                            <td>' . $this->session->userdata('currency') . ' ' . formatnumber($row["amt_available"]) . '</td>
                            <td>' . $this->session->userdata('currency') . ' ' . formatnumber($row["amt_required"]) . '</td>
                        </tr>';
        }

        $donors .='</table>';
        $this->db->where('id', $approvalDetails['0']['partner_id']);
        $getPartner = $this->db->get('hr_partner_type');
        $getData = $getPartner->result_array();
        $partner_name = $getData[0]['partner_name'];

        $org = array('#partner_nam#', '#date_of_seeking_approval#', '#from_employee#', '#to_RO#', '#purpose#', '#payment_favor#', '#programme_name#', '#supporting_documents#', '#comments_RO#', '#comments_PH#', '#comments_CEO#', '#estimated_in_workplan#', '#above_50000#', '#donors#', '#status#', '#RO_status#', '#PH_status#', '#approval_no#', '#programme_head#', '#From#', '#To#', '#check_no#', '#payment_status#', '#finance_comments#', '#RO_date#', '#PH_date#', '#CEO_date#');

        $replace = array(strtoupper($partner_name),
            date('Y-m-d', strtotime($approvalDetails['0']['date_of_seeking_approval'])),
            $this->getEmployeeName($approvalDetails['0']['from_employee']),
            $this->getEmployeeName($approvalDetails['0']['to_RO']),
            $approvalDetails['0']['purpose'],
            $approvalDetails['0']['payment_favor'],
            $approvalDetails['0']['programme_name'],
            $approvalDetails['0']['supporting_documents'],
            $approvalDetails['0']['comments_RO'],
            $approvalDetails['0']['comments_PH'],
            $approvalDetails['0']['comments_CEO'],
            $approvalDetails['0']['estimated_in_workplan'],
            $approvalDetails['0']['above_50000'],
            $donors,
            $approvalDetails['0']['status'],
            $approvalDetails['0']['RO_status'],
            $approvalDetails['0']['PH_status'],
            $approvalDetails['0']['approval_no'],
            $this->getEmployeeName($approvalDetails['0']['programme_head']),
            $this->session->userdata('username'),
            $toName,
            $approvalDetails['0']['check_no'],
            ucfirst($approvalDetails['0']['finance_status']),
            $approvalDetails['0']['finance_comments'],
            date('Y-m-d', strtotime($approvalDetails['0']['RO_date'])),
            date('Y-m-d', strtotime($approvalDetails['0']['PH_date'])),
            date('Y-m-d', strtotime($approvalDetails['0']['CEO_date']))
        );

        $attach = array();
        $attachFile = unserialize($approvalDetails['0']['attachment']);
        foreach (@$attachFile as $key => $value):
            $attach[] = "uploads/support_docs/" . $value;
        endforeach;

        $data = array('org' => $org,
            'replace' => $replace,
            'employeeEmail' => $empEmail,
            'adminEmail' => $adminEmail,
            'reportAuthEmail' => $reportAuthEmail,
            'phEmail' => $phEmail,
            'ceoEmail' => $ceoEmail,
            'attach' => $attach
        );

        return $data;
    }

    function getEmployeeName($userId) {
        $result = $this->getUserInfo($userId);
        return $result['0']['user_name'];
    }

    function sendMail($from = NULL, $to = array(), $tamplate = NULL, $mailContant = NULL, $attach = NULL, $ccEmail = NULL) {
        $mailTemplate = $this->getMailTemplate($tamplate);
        $messageSubject = $mailTemplate['0']['messagesubject'];
        $messageBody = str_replace($mailContant['org'], $mailContant['replace'], $mailTemplate['0']['messagebody']);
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->from('mis@mis.villgroapps.org', 'Admin');
        $this->email->to($to);

        if (!empty($attach)) {
            foreach ($attach as $key => $value):
                $this->email->attach($value);
            endforeach;
        }
        $this->email->subject($messageSubject);
        $this->email->message($messageBody);
        $this->email->send();
        return true;
    }

    function getMailTemplate($messageType) {
        $data = array();
        $this->ais->where('messagetype', $messageType);
        $query = $this->ais->get('mailtemplate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function actionApproveNote($option, $id, $ipaddress, $approve_from) {
        if ($option == 'approve') {
            $status = 'confirmed';
        } elseif ($option == 'disapprove') {
            $status = 'cancelled';
        } elseif ($option == 'close') {
            $status = 'closed';
        } elseif ($option == 'defer') {
            $status = 'defered';
        }
        $approveby = $this->session->userdata('username');
        $this->ais->set('status', $status);
        $this->ais->set('approved_by', $approveby);
        $this->ais->set('ip_address', $ipaddress);
        $this->ais->set('approved_from', $approve_from);
        $this->ais->where('approval_id', $id);
        $this->ais->update('approval_note');
        return $this->ais->affected_rows();
    }

    function getAllApprovalNotesCount($where = NULL, $admin = NULL, $report = NULL) {
        $data = array();
        $whereArray = array();
        $q = "select count(distinct(AN.approval_id)) as total,sum(AN.amt_required) as total_amount from approval_note AP";
        $q .= " left join master_programme MP on AP.programme= MP.programme_id";
        $q .= " left join approval_note_donors AN on AP.approval_id= AN.approval_id";
        if ($admin == NULL)
            $whereArray[] = "AP.from_employee ='" . $this->session->userdata('user') . "'";

        if ($where != NULL)
            $whereArray[] = $where;

        $whereCond = implode(' and ', $whereArray);

        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFroms($financialArray[0]['from']);
        $to = $this->convertMonthYearTos($financialArray[0]['to']);

        if ($whereCond != '') {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and " . $whereCond;
        } else {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to'";
        }
        $partner_id = $this->session->userdata('partner_id');
        $q .= " and AP.partner_id = '$partner_id'";

        $query = $this->ais->query($q);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            $data = array_pop($data);
        }
        $query->free_result();
        return $data;
    }

    function getAllUserList() {
        $data = array();
        $this->db->distinct('hr_user_profile.emp_first_name');
        $this->db->select("hr_user_login.id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id", false);
        $this->db->where('hr_user_profile.partner_id', $this->session->userdata('partner_id'));
        $this->db->where_in('emp_type', array(3, 2, 7, 10));
        $this->db->join('hr_user_login', 'hr_user_login.emp_id = hr_user_profile.id');
        $this->db->order_by('hr_user_profile.emp_first_name');
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getApprovalActionHistory($options = array()) {
        $data = array();
        if (isset($options['num']) && isset($options['offset']))
            $this->ais->limit($options['num'], $options['offset']);
        if (!empty($options['employee'])) {
            $this->ais->where('ana.from_employee', $options['employee']);
        }
        if ($options['orderby'] != NULL && $options['ordertype'] != NULL)
            $this->ais->order_by($options['orderby'], $options['ordertype']);
        $this->ais->select('an.approval_no,ana.*');
        $this->ais->join('approval_note an', 'an.approval_id=ana.approval_id');
        $this->ais->where('ana.partner_id', $this->session->userdata('partner_id'));
        $query = $this->ais->get('approval_note_actionhistory ana');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getInternalNote($approval_id) {
        $data = array();
        $this->ais->select('*');
        $this->ais->from('internal_note');
        $this->ais->where('approval_id', $approval_id);
        $query = $this->ais->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getStatusINT($id = NULL) {
        $q = "select * from internal_note where approval_id=" . $id . " and (status ='pending' or status ='draft' or status = 'defered')";
        $result = $this->ais->query($q);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getProgramme_id($id) {
        $q = "select programme from approval_note where approval_id='" . $id . "'";
        $query = $this->ais->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    function actionApproveRO($option, $id) {
        if ($option == 'approve') {
            $this->ais->set('RO_status', 'confirmed');
            $this->ais->set('status', 'pending');
        } else if ($option == 'disapprove') {
            $this->ais->set('RO_status', 'cancelled');
            $this->ais->set('status', 'cancelled');
        } else {
            $this->ais->set('RO_status', 'defered');
            $this->ais->set('status', 'defered');
        }

        $this->ais->set('RO_date', date("Y-m-d H:i:s"));
        $this->ais->set('comments_RO', $this->input->post('comments_RO'));
        $this->ais->where('approval_id', $id);
        $this->ais->update('approval_note');
        return $this->ais->affected_rows();
    }

    function get_ph_user($userID, $partnerId) {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('status', '1');
        $this->ais->where('partner_id', $partnerId);
        $this->ais->where('programme_head', $userID);
        $query = $this->ais->get('master_programme');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
