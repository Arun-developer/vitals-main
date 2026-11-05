<?php

class Mapproval extends My_Model {

    /* function Mapproval() {
        parent::Model();
        #error_reporting(0);
        $this->load->model('Mlogin');
        $this->load->model('Mmaster');
        $this->load->model('Mcommon');
        $this->load->model('Minternal');
        $this->hris = $this->load->database('hris', TRUE);
    } */
	
	public function __construct(){
		$this->load->model('Mlogin');
        $this->load->model('Mmaster');
        $this->load->model('Mcommon');
        //$this->load->model('Minternal');
        $this->hris = $this->load->database('hris', TRUE);
	}
    function get_grantList($id = '') {
        $this->misdb = $this->load->database('mis', TRUE);
        if ($id != '') {
            $this->misdb->where('id', $id);
        }
        $this->misdb->select(array('name', 'id'));
        $query = $this->misdb->get('grant_list');
        return $query->result();
    }

    function isPartnerCheck() {
        if ($this->session->userdata('ais_privilege') == 1) {
            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login/logout');
        }
    }

    function updateApprovalSettings() {
        $data = array('ceo' => $this->input->post('ceo'),
            'finance' => serialize($this->input->post('finance')));
        $this->db->where('partner_id', $this->input->post('id'));
        $this->db->update('approval_setting', $data);
        return $this->db->affected_rows();
    }

    function getfinanciallist() {
        $data = array();
        $query = "select * from financial_year where status = '0'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function getApprovalSetting($option) {
        $data = array();
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->db->get('approval_setting');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            $query->free_result();
            return $data['0'][$option];
        }
    }

    public function get_partnerName($partner_id) {
        $data = array();
        $this->hris->select("currency");
        $this->hris->where('id', $partner_id);
        $query = $this->hris->get('hs_hr_branch');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
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

        $financialArray = $this->Mmaster->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);

        if ($whereCond != '') {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and " . $whereCond;
        } else {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to'";
        }
        $partner_id = $this->session->userdata('partner_id');
        $q .= " and AP.partner_id = '$partner_id'";

        $query = $this->db->query($q);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            $data = array_pop($data);
        }
        $query->free_result();
        return $data;
    }

    function getarchiveApprovalNotes($from = NULL, $to = NULL, $num = NULL, $offset = NULL, $where = NULL) {
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
            $whereCond = php72_implode(' and ', $whereArray);
        } else {
            $whereCond = "1=1";
        }
        $q .= " where  AP.date_of_request >= '" . $from . "' and AP.date_of_request <= '" . $to . "' and $whereCond";
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
            $whereCond = php72_implode(' and ', $whereArray);
        } else {
            $whereCond = "1=1";
        }

        $q .= " where  AP.date_of_request >= '" . $from . "' and AP.date_of_request <= '" . $to . "' and $whereCond";
        $query = $this->db->query($q);
        return $query->num_rows();
    }

    function getfinanceusers() {
        $data = array();
        $this->db->where('partner_id', 1);
        $query = "select * from approval_setting";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = unserialize($row['finance']);
        }
        return $data;
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

    function getImport() {
        $query = $this->db->query("SELECT IF( AN.donor =0, AN.other_donor, D.master_name ) AS donor, IF( AN.line_item =0, AN.other_line_item, LI.master_name ) AS line_item, IF( AN.budget_head =0, AN.other_budget_head, BH.master_name ) AS budget_head, AN.amt_available, AN.amt_required, AP.status, AP.approval_id, IT.total_amount, IT.status, IT.internal_id,AP.payment_favor
                                    FROM approval_note AP
                                    LEFT JOIN approval_note_donors AN ON AP.approval_id = AN.approval_id
                                    LEFT JOIN master_settings D ON D.master_id = AN.donor
                                    LEFT JOIN master_settings BH ON BH.master_id = AN.budget_head
                                    LEFT JOIN master_settings LI ON LI.master_id = AN.line_item
                                    LEFT JOIN internal_note IT ON IT.approval_id = AP.approval_id
                                    WHERE AP.status = 'confirmed'");

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
        $query = $this->db->query("SELECT master_programme.programme as programme_name,master_programme.programme_head,approval_note.programme,
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
//            'date_of_request' => "2020-03-31",
//            'date_of_seeking_approval' => "2020-03-31",
            'from_employee' => $this->session->userdata('user'),
//            'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'to_RO' => $this->input->post('to_RO'),
            'purpose' => $this->input->post('purpose'),
            'comments_RO' => '',
            'comments_PH' => '',
            'programme' => $this->input->post('programme'),
            'UCID' => $this->input->post('UCID'),
            'supporting_documents' => php72_implode(',', $this->input->post('supporting_documents')),
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

    function updateApprovalId($id) {
        $approval_id = $this->insertedApprovalNumber($id);
        $data = array('approval_no' => $approval_id);
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note', $data);
        return true;
    }

    function insertedApprovalNumber($id) {
        $data = array();
        $text = "APN/";
        $position = "front";
        $id = str_pad((int) $id, 4, "0", STR_PAD_LEFT);
        return $approvalNo = $text . $id;
    }

    function updateApprovalNote() {
        $fNameArray = array();
        if (is_array($this->input->post('fArray'))) {
            foreach (@$this->input->post('fArray') as $key => $value):
                $fNameArray[] = $value;
            endforeach;
        }
        $file_name = $_FILES['fileX']['name'];
        $file_tmp_name = $_FILES['fileX']['tmp_name'];
        foreach ($file_name as $key => $value):
            if ($value != '') {
                $fName = rand() . "_" . str_replace(" ", "_", $value);
                @copy($file_tmp_name[$key], "uploads/support_docs/" . $fName);
                $fNameArray[] = $fName;
            }
        endforeach;
        $above = 'no';
        $work_plan = 'yes';
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
        $this->db->where('approval_id', $this->input->post('approval_id'));
        $query = $this->db->get('approval_note_donors');
        $count = $query->num_rows();
        if ($count > 0) {
            $result = $query->result_array();
        }
        $olddetails = array(
            'approval_id' => $this->input->post('approval_id'),
            'edited_by' => $this->session->userdata('user'),
            'programme_id' => $this->input->post('program_id'),
            'date_of_seeking_approval' => ddmmyyyy2mysql($this->input->post('date_of_seeking_approval')),
//            'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'to_RO' => $this->input->post('to_RO'),
            'grant_id' => $result[$key]['grant_list'],
            'donor' => $result[$key]['donor'],
            'budget_head' => $result[$key]['budget_head'],
            'line_item' => $result[$key]['line_item'],
            'amt_available' => $result[$key]['amt_available'],
            'amt_required' => $result[$key]['amt_required']
        );
        $editedAN = $this->insertANedithistory($olddetails);

        $data = array(
            'date_of_seeking_approval' => ddmmyyyy2mysql($this->input->post('date_of_seeking_approval')),
//            'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'purpose' => $this->input->post('purpose'),
            'to_RO' => $this->input->post('to_RO'),
            'supporting_documents' => php72_implode(',', $this->input->post('supporting_documents')),
            'estimated_in_workplan' => $work_plan,
            'above_50000' => $above,
            'RO_status' => $ro_status,
            'PH_status' => $ph_status,
            'CEO_status' => $ceo_status,
            'status' => $stat,
            'attachment' => serialize($fNameArray));

        $this->db->where('approval_id', $this->input->post('approval_id'));
        $this->db->update('approval_note', $data);
        $this->db->where('approval_id', $this->input->post('approval_id'));
        $this->db->delete('approval_note_donors');
        $this->insertDonors($this->input->post('approval_id'));

        return true;
    }

    function send_approval_note($id) {
        $data = array();
        $query = "UPDATE approval_note SET status = 'pending' where approval_id = '" . $id . "'";
        $result = $this->db->query($query);
        return ture;
    }

    function getstatusapprovalnote($id) {
        $this->db->select('RO_status,PH_status,CEO_status,status');
        $this->db->where('approval_id', $id);
        $query = $this->db->get('approval_note');
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
//            'date_of_request' => "2020-03-31",
//            'date_of_seeking_approval' => "2020-03-31",
            'from_employee' => $this->session->userdata('user'),
//            'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'to_RO' => $this->input->post('to_RO'),
            'purpose' => $this->input->post('purpose'),
            'programme' => $this->input->post('programme'),
            'UCID' => $this->input->post('UCID'),
            'supporting_documents' => php72_implode(',', $this->input->post('supporting_documents')),
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

    function deletenote($approval_id) {
        $data = array();
        $query = "DELETE FROM approval_note where approval_id = '" . $approval_id . "'";
        $result = $this->db->query($query);
        return true;
    }

    function insertDonors($id) {
        $donor = $this->input->post('donor');
        $grant_list = $this->input->post('grant_list');
        $other_donor = $this->input->post('other_donor');
        $budget_head = $this->input->post('budget_head');
        $other_budget_head = $this->input->post('other_budget_head');
        $line_item = $this->input->post('line_item');
        $other_line_item = $this->input->post('other_line_item');
        $cost_centre = $this->input->post('cost_centre');
        $other_cost_centre = $this->input->post('other_cost_centre');
        $additional_info = $this->input->post('additional_info');
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
            $this->db->insert('approval_note_donors', $data);
        endforeach;
    }

    function approvalNumber() {
        $data = array();
        $text = "APN/";
        $position = "front";
        $this->db->order_by('approval_id', 'desc');
        $this->db->limit('1', '0');
        $query = $this->db->get('approval_note');
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

        $query = $this->db->query($q);
		#echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $query->result_array();
    }

    /* functions newly added on 3/6/14 for AN close process */

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

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    function getProgramme_id($id) {
        $q = "select programme from approval_note where approval_id='" . $id . "'";
        $query = $this->db->query($q);
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
        $result = $this->db->query($q);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /* function newly added on 3/6/14 for AN close ends */

    /* function added newly on 2/6/14 for internal note remain amount calculation based on selected donor */

    function get_internal_balance($donor_detail) {
        $tot_req_amount = 0;
        $conarray = array('approval_id' => $donor_detail[0]['approval_id'], 'donor' => $donor_detail[0]['donor'], 'budget_head' => $donor_detail[0]['budget_head'], 'line_item' => $donor_detail[0]['line_item']);
        if ($donor_detail[0]['cost_centre']) {
            $conarray['cost_centre'] = $donor_detail[0]['cost_centre'];
        }
        $this->db->select_sum('amount_toapprove');
        $this->db->where($conarray);
        $this->db->where('status !=', 'cancelled');
        $query1 = $this->db->get('internal_note');
        $remaining_amount = $query1->result_array();
        $int_remain = $remaining_amount[0]['amount_toapprove'];
        $this->db->select_sum('amt_required');
        $this->db->where($conarray);
        $query1 = $this->db->get('approval_note_donors');
        $row1 = $query1->result_array(); //echo "<pre>"; var_dump($row1); exit;
        $tot_req_amount = $row1[0]['amt_required'];

        $remain_amt = ($int_remain != '') ? (($tot_req_amount != '') ? $tot_req_amount - $int_remain : $tot_req_amount) : $tot_req_amount;
        return $remain_amt;
    }

    function getDonorDetail($ap_donor_id) {
        $this->db->select('approval_donor_id,donor,budget_head,line_item,amt_available,amt_required');
        $this->db->where('approval_donor_id', $ap_donor_id);
        $query = $this->db->get('approval_note_donors');
        return $query->result_array();
    }

    function get_donor_balance($id, $donor_detail) {
        $tot_req_amount = 0;
        $conarray = array('approval_id' => $id, 'donor' => $donor_detail[0]['donor'], 'budget_head' => $donor_detail[0]['budget_head'], 'line_item' => $donor_detail[0]['line_item']);
        $this->db->select('amt_required');
        $this->db->where($conarray);
        $query1 = $this->db->get('approval_note_donors');
        if ($query1->num_rows() > 1) {
            $row1 = $query1->result_array();
            foreach ($row1 as $rs) {
                $req_amount[] = $rs['amt_required'];
            }
            $tot_req_amount = php72_array_sum($req_amount);
        }
        $this->db->select_sum('amount_toapprove', 'int_amount');
        $this->db->where($conarray);
        $this->db->where('status !=', 'cancelled');
        $query = $this->db->get('internal_note');
        $row = $query->result_array();
        $remaining_amount = (($row[0]['int_amount'] != '')) ? ((($tot_req_amount != '') ? $tot_req_amount : $donor_detail[0]['amt_required']) - $row[0]['int_amount']) : $donor_detail[0]['amt_required'];
        return $remaining_amount;
    }

    function get_edit_donor_balance($int, $id, $donor_detail) {
        $conarray1 = array('internal_id' => $int, 'donor' => $donor_detail[0]['donor'], 'budget_head' => $donor_detail[0]['budget_head'], 'line_item' => $donor_detail[0]['line_item']);
        if ($donor_detail[0]['cost_centre']) {
            $conarray1['cost_centre'] = $donor_detail[0]['cost_centre'];
        }
        $this->db->select('amount_toapprove');
        $this->db->where($conarray1);
        $query1 = $this->db->get('internal_note');
        if ($query1->num_rows() > 0) {
            $total_int = $query1->result_array();
            return $total_int[0]['amount_toapprove'];
        } else {
            return 0;
        }
    }

    function int_amt_sumof($id) {
        $q1 = "select sum(amount_toapprove) as int_amount from internal_note where approval_id='" . $id . "' and status <> 'cancelled' and status <> 'draft'";
        $query1 = $this->db->query($q1);
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

    function getStatusApn($id) {
        $q = "select status from approval_note where approval_id =" . $id;
        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /* end internal note remain amount calculation */

    function referApprovalDonor($id) {
        $data = array();
        $this->db->where('approval_donor_id', $id);
        $query = $this->db->get('approval_note_donors');
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
        $this->db->set('status', $status);
        $this->db->set('approved_by', $approveby);
        $this->db->set('ip_address', $ipaddress);
        $this->db->set('approved_from', $approve_from);
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note');
        return $this->db->affected_rows();
    }

    function actionApproveRO($option, $id) {
        if ($option == 'approve') {
            $this->db->set('RO_status', 'confirmed');
            $this->db->set('status', 'pending');
        } else if ($option == 'disapprove') {
            $this->db->set('RO_status', 'cancelled');
            $this->db->set('status', 'cancelled');
        } else {
            $this->db->set('RO_status', 'defered');
            $this->db->set('status', 'defered');
        }

        $this->db->set('RO_date', date("Y-m-d H:i:s"));
        $this->db->set('comments_RO', $this->input->post('comments_RO'));
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note');
        return $this->db->affected_rows();
    }

    function actionApprovePH($option, $id) {
        if ($option == 'approve') {
            $this->db->set('PH_status', 'confirmed');
            $this->db->set('status', 'pending');
        } else if ($option == 'disapprove') {
            $this->db->set('PH_status', 'cancelled');
            $this->db->set('status', 'cancelled');
        } else {
            $this->db->set('PH_status', 'defered');
            $this->db->set('status', 'defered');
            $this->db->set('RO_status', 'confirmed');
        }

        $this->db->set('PH_date', date("Y-m-d H:i:s"));
        $this->db->set('comments_PH', $this->input->post('comments_PH'));
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note');
        return $this->db->affected_rows();
    }

    function actionApprovePHEnd($option, $id) {
        if ($option == 'approve') {
            $this->db->set('PH_status', 'confirmed');
            $this->db->set('status', 'confirmed');
        } else if ($option == 'disapprove') {
            $this->db->set('PH_status', 'cancelled');
            $this->db->set('status', 'cancelled');
        } else {
            $this->db->set('PH_status', 'defered');
            $this->db->set('status', 'defered');
            $this->db->set('RO_status', 'confirmed');
        }

        $this->db->set('PH_date', date("Y-m-d H:i:s"));
        $this->db->set('comments_PH', $this->input->post('comments_PH'));
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note');
        return $this->db->affected_rows();
    }

    function actionApproveCEO($option, $id) {
        if ($option == 'approve') {
            $this->db->set('CEO_status', 'confirmed');
            $this->db->set('status', 'pending');
        } elseif ($option == 'disapprove') {
            $this->db->set('CEO_status', 'cancelled');
            $this->db->set('status', 'cancelled');
        } else if ($this->input->post('employee') == 'programme_head') {
            $this->db->set('CEO_status', 'defered');
            $this->db->set('PH_status', 'pending');
            $this->db->set('status', 'defered');
        } else {
            $this->db->set('CEO_status', 'defered');
            $this->db->set('PH_status', 'pending');
            $this->db->set('RO_status', 'pending');
            $this->db->set('status', 'defered');
        }

        $this->db->set('approved_by', $approveby);
        $this->db->set('ip_address', $ipaddress);
        $this->db->set('approved_from', $approve_from);
        $this->db->set('CEO_date', date("Y-m-d H:i:s"));
        $this->db->set('comments_CEO', $this->input->post('comments_CEO'));
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note');
        return $this->db->affected_rows();
    }

    function approval_confirmed($id) {
        $this->db->set('status', 'confirmed');
        $this->db->where('CEO_status', 'confirmed');
        $this->db->where('PH_status', 'confirmed');
        $this->db->where('RO_status', 'confirmed');
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note');
        return $this->db->affected_rows();
    }

    function getOldGrantAmount($id) {
        $sql_query = "SELECT  sum(approval_note_donors.amt_required) as projected_amount,internal_note.internal_no as internal_no, an.status as an_status, an.approval_id as approval_id, approval_note_donors.donor as an_donor ,approval_note_donors.grant_id as an_grant_id, approval_note_donors.amt_required as amt_required
        FROM approval_note as an
        LEFT JOIN approval_note_donors ON approval_note_donors.approval_id = an.approval_id
		LEFT JOIN  internal_note ON internal_note.approval_id = an.approval_id
		WHERE an.approval_id = $id AND approval_note_donors.grant_id!=''
		GROUP BY approval_note_donors.grant_id";
        #echo'<pre>';print_r($sql_query);		 pending
        $query = $this->db->query($sql_query);
        return $rows = $query->result();
    }

    function getGrantAmount($id) {

        $sql_query = "SELECT  sum(approval_note_donors.amt_required) as projected_amount,internal_note.internal_no as internal_no, an.status as an_status, an.approval_id as approval_id, approval_note_donors.donor as an_donor ,approval_note_donors.grant_id as an_grant_id, approval_note_donors.amt_required as amt_required
        FROM approval_note as an
        LEFT JOIN approval_note_donors ON approval_note_donors.approval_id = an.approval_id
		LEFT JOIN  internal_note ON internal_note.approval_id = an.approval_id
		WHERE an.status = 'confirmed' AND an.approval_id = $id AND approval_note_donors.grant_id!=''
		GROUP BY approval_note_donors.grant_id";
       
        $query = $this->db->query($sql_query);
        return $rows = $query->result();
    }

    function update_ProGrantAmt($grant_id, $projected_amount) {
        $this->mis_db = $this->load->database('mis', TRUE);
        $this->mis_db->set('projected_amount', 'projected_amount+' . $projected_amount, false);
        $this->mis_db->where('id', $grant_id);
        $this->mis_db->update('grant_list');
    }

    function update_OldProGrantAmt($grant_id, $projected_amount) {
        $this->mis_db = $this->load->database('mis', TRUE);
        $this->mis_db->set('projected_amount', 'projected_amount-' . $projected_amount, false);
        $this->mis_db->where('id', $grant_id);
        $this->mis_db->update('grant_list');
    }

    function financeAction($option, $id) {
        if ($option == 'confirm'):
            $this->db->set('finance_status', 'confirmed');
            $this->db->set('check_no', $this->input->post('check_no'));
        else:
            $this->db->set('finance_status', 'cancelled');
            $this->db->set('finance_comments', $this->input->post('finance_comments'));
        endif;
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note');
        return $this->db->affected_rows();
    }

    function mailContent($requestId, $touser = NULL) {
        $approvalDetails = $this->getApprovalNote($requestId);
        $approvalDonorsList = $this->getApprovalDonors($requestId);
        $employeeDetails = $this->Mlogin->getEmployeeFromUserId($approvalDetails['0']['from_employee']);
        $empEmail = $employeeDetails['0']['emp_work_email'] != '' ? $employeeDetails['0']['emp_work_email'] : $employeeDetails['0']['emp_oth_email'];
        $reportingAuth = reportingUser('supUser', 'All', $employeeDetails['0']['emp_number']);
        $roName = $reportingAuth[0]['user_name'];
        if (php72_count($reportingAuth) == 1)
            $reportAuthEmail = $reportingAuth['0']['emp_work_email'] != '' ? $reportingAuth['0']['emp_work_email'] : $reportingAuth['0']['emp_oth_email'];
        else if (php72_count($reportingAuth) > 1) {
            $rodetails = $this->Mlogin->getUserNameInfo($approvalDetails['0']['to_RO']);
            $reportAuthEmail = $rodetails['0']['emp_work_email'] != '' ? $rodetails['0']['emp_work_email'] : $rodetails['0']['emp_oth_email'];
        } else
            $reportAuthEmail = '';

        $adminEmail = $this->session->userdata('adminEmail');
        $phDetails = $this->Mlogin->getEmployeeFromUserId($approvalDetails['0']['programme_head']);
        $phEmail = $phDetails['0']['emp_work_email'] != '' ? $phDetails['0']['emp_work_email'] : $phDetails['0']['emp_oth_email'];
        $ceoUser = $this->getApprovalSetting('ceo');
        $ceoDetails = $this->Mlogin->getEmployeeFromUserId($ceoUser);
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
        $this->hris->where('id', $approvalDetails['0']['partner_id']);
        $getPartner = $this->hris->get('hs_hr_branch');
        $getData = $getPartner->result_array();
        $partner_name = $getData[0]['branch_name'];

        $org = array('#partner_nam#', '#date_of_seeking_approval#', '#from_employee#', '#to_RO#', '#purpose#', '#payment_favor#', '#programme_name#', '#supporting_documents#', '#comments_RO#', '#comments_PH#', '#comments_CEO#', '#estimated_in_workplan#', '#above_50000#', '#donors#', '#status#', '#RO_status#', '#PH_status#', '#approval_no#', '#programme_head#', '#From#', '#To#', '#check_no#', '#payment_status#', '#finance_comments#', '#RO_date#', '#PH_date#', '#CEO_date#');

        $replace = array(strtoupper($partner_name),
            mysql2ddmmyyyy($approvalDetails['0']['date_of_seeking_approval']),
            getEmployeeName($approvalDetails['0']['from_employee']),
            getEmployeeName($approvalDetails['0']['to_RO']),
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
            getEmployeeName($approvalDetails['0']['programme_head']),
            $this->session->userdata('username'),
            $toName,
            $approvalDetails['0']['check_no'],
            ucfirst($approvalDetails['0']['finance_status']),
            $approvalDetails['0']['finance_comments'],
            mysql2ddmmyyyy($approvalDetails['0']['RO_date']),
            mysql2ddmmyyyy($approvalDetails['0']['PH_date']),
            mysql2ddmmyyyy($approvalDetails['0']['CEO_date'])
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

    /* newly added on 4/6/14  */

    function action_close($status, $id) {
        $this->db->set('status', $status);
        $this->db->where('approval_id', $id);
        $this->db->update('approval_note');
        return $this->db->affected_rows();
    }

    function update_apn($id, $amt, $apn_donor_id) {
        $this->db->set('amt_required', $amt);
        $this->db->where('approval_id', $id);
        $this->db->where('approval_donor_id', $apn_donor_id);
        $this->db->update('approval_note_donors');
        return true;
    }

    function internalnoteid($id) {
        $data = array();
        $q = "select internal_id, approval_id, amount_toapprove, donor, line_item, cost_centre, budget_head
		  from internal_note where approval_id='" . $id . "' and status <> 'cancelled'";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function mailContent_close($requestId, $touser = NULL) {
        $approvalDetails = $this->getApprovalNote($requestId);
        $approvalDonorsList = $this->getApprovalDonors($requestId);
        //get Employee Information
        $employeeDetails = $this->Mlogin->getEmployeeFromUserId($approvalDetails['0']['from_employee']);
        $empEmail = ($employeeDetails['0']['emp_work_email'] != '') ? $employeeDetails['0']['emp_work_email'] : $employeeDetails['0']['emp_oth_email'];
        //reporting authority
        $reportingAuth = reportingUser('supUser', 'All', $employeeDetails['0']['emp_number']);
        if (php72_count($reportingAuth))
            $reportAuthEmail = ($reportingAuth['0']['emp_work_email'] != '') ? $reportingAuth['0']['emp_work_email'] : $reportingAuth['0']['emp_oth_email'];
        else if (php72_count($reportingAuth) > 1) {
            $rodetails = $this->Mlogin->getUserNameInfo($approvalDetails['0']['to_RO']);
            $reportAuthEmail = ($rodetails['0']['emp_work_email'] != '') ? $rodetails['0']['emp_work_email'] : $rodetails['0']['emp_oth_email'];
        } else
            $reportAuthEmail = '';
        $adminEmail = $this->session->userdata('adminEmail');
        //get PH Information
        $phDetails = $this->Mlogin->getEmployeeFromUserId($approvalDetails['0']['programme_head']);
        $phEmail = ($phDetails['0']['emp_work_email'] != '') ? $phDetails['0']['emp_work_email'] : $phDetails['0']['emp_oth_email'];
        //get ceo Information
        $ceoUser = $this->getApprovalSetting('ceo');
        $ceoDetails = $this->Mlogin->getEmployeeFromUserId($ceoUser);
        $ceoEmail = ($ceoDetails['0']['emp_work_email'] != '') ? $ceoDetails['0']['emp_work_email'] : $ceoDetails['0']['emp_oth_email'];
        switch ($touser) {
            case('ro'):
                $toName = @$reportingAuth['0']['user_name'];
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
        $this->hris->where('id', $approvalDetails['0']['partner_id']);
        $getPartner = $this->hris->get('hs_hr_branch');
        $getData = $getPartner->result_array();
        $partner_name = $getData[0]['branch_name'];

        $org = array('#partner_nam#', '#date_of_seeking_approval#', '#from_employee#', '#to_RO#', '#purpose#', '#payment_favor#', '#programme_name#', '#supporting_documents#', '#comments_RO#', '#comments_PH#', '#comments_CEO#', '#estimated_in_workplan#', '#above_50000#', '#donors#', '#status#', '#RO_status#', '#PH_status#', '#approval_no#', '#programme_head#', '#From#', '#To#', '#check_no#', '#payment_status#', '#finance_comments#', '#RO_date#', '#PH_date#', '#CEO_date#', '#closed_by');

        $replace = array(strtoupper($partner_name),
            mysql2ddmmyyyy($approvalDetails['0']['date_of_seeking_approval']),
            getEmployeeName($approvalDetails['0']['from_employee']),
            getEmployeeName($approvalDetails['0']['to_RO']),
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
            getEmployeeName($approvalDetails['0']['programme_head']),
            $this->session->userdata('username'),
            $toName,
            $approvalDetails['0']['check_no'],
            ucfirst($approvalDetails['0']['finance_status']),
            $approvalDetails['0']['finance_comments'],
            mysql2ddmmyyyy($approvalDetails['0']['RO_date']),
            mysql2ddmmyyyy($approvalDetails['0']['PH_date']),
            mysql2ddmmyyyy($approvalDetails['0']['CEO_date']),
            $this->session->userdata('username'));

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
            'attach' => $attach);

        return $data;
    }

    /* newly added on 4/6/14 end */

    function getApprovalDashboard($section, $currentTab) {
        $subUsers = php72_implode("','", reportingUser('subUser', 'userId'));
        $searchArray = array();
        $status = 'status';
        $admin = NULL;
        switch ($section) {
            case 'mylist':
                $admin = NULL;
                $status = 'status';
                break;
            case 'rolist':
                $searchArray[] = "AP.to_RO =  '" . $this->session->userdata('user') . "' ";
                $admin = 'Show all';
                $status = 'RO_status';
                break;
            case 'phlist':
                $searchArray[] = "MP.programme_head = '" . $this->session->userdata('user') . "' AND AP.status = 'pending'";
                $status = 'PH_status';
                $admin = 'Show all';
                if ($currentTab == 'pending' || $currentTab == 'confirmed') {
                    $searchArray[] = "AP.RO_status = 'confirmed'";
                }
                break;
            case 'ceolist':
                $searchArray[] = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' )";
                $admin = 'Show all';
                $status = 'CEO_status';
                if ($currentTab == 'pending' || $currentTab == 'confirmed') {
                    $searchArray[] = "AP.PH_status = 'confirmed' AND AP.status = 'pending'";
                }
                break;
            case 'finance':
                $admin = 'Show all';
                $title = 'Finance';
                if ($currentTab == 'pending') {
                    $searchArray[] = "AP.finance_status = 'inprogress' AND AP.status = 'confirmed'";
                } else if ($currentTab == 'confirmed') {
                    $searchArray[] = "AP.finance_status = 'confirmed' AND AP.status = 'confirmed'";
                }
                break;
            case 'admin':
                $admin = 'Show all';
                $status = 'status';
                break;
        }
        switch ($currentTab) {
            case 'pending':
                $searchArray[] = "AP." . $status . " = 'pending' AND AP.status = 'pending'";
                break;
            case 'confirmed':
                $searchArray[] = "AP." . $status . " = 'confirmed' AND AP.status = 'confirmed'";
                break;
            case 'cancelled':
                $searchArray[] = "AP." . $status . " = 'cancelled' AND AP.status = 'cancelled'";
                break;
            case 'defered':
                $searchArray[] = "  AP.status = 'defered'";
                break;
        }
        $financialArray = $this->Mmaster->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);
        $searchArray[] = "EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to'";

        $where = implode(" and ", $searchArray);
        $total = $this->getAllApprovalNotesCount($where, $admin);
        $this->load->helper('debug');
        return $total['total'];
    }

    /*     * ** Transfer of Approval Notes *** */

    function getAllCountTransfer($options = array()) {
        $data = array();
        $this->db->select('*');
        $this->db->from('approval_note');
        if (!empty($options['employee'])) {
            $this->db->where('from_employee', $options['employee']);
        }

        if (!empty($options['approvalNumber'])) {
            $this->db->where('approval_no', $options['approvalNumber']);
        }

        if (!empty($options['from'])) {
            $this->db->where('date_of_request >=', ddmmyyyy2mysql($options['from']));
            $this->db->where('date_of_request <=', ddmmyyyy2mysql($options['to']));
        }

        $this->db->where('status', 'confirmed');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function transferApporvalNote($options = array()) {
        $data = array();
        if (!empty($options['orderby']) && !empty($options['ordertype']))
            $this->db->order_by($options['orderby'], $options['ordertype']);
        $this->db->select('*');
        $this->db->from('approval_note');
        if (!empty($options['employee'])) {
            $this->db->where('from_employee', $options['employee']);
        }
        if (!empty($options['approvalNumber'])) {
            $this->db->where('approval_no', $options['approvalNumber']);
        }
        if (!empty($options['from'])) {
            $this->db->where('date_of_request >=', ddmmyyyy2mysql($options['from']));
            $this->db->where('date_of_request <=', ddmmyyyy2mysql($options['to']));
        }
        $this->db->where('status', 'confirmed');
        if (isset($options['num']) && isset($options['offset']))
            $this->db->limit($options['num'], $options['offset']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            $query->free_result();
            return $data;
        }
    }

    function assignApporvalNote($options = array()) {
        foreach ($options['assignapproval'] as $key => $value) {
            if ($options['assign'] != '') {
                $emp = $this->Mlogin->getUserInfo($options['assign']);
                $empid = $emp[0]['emp_number'];
                $ro = $this->Mlogin->getReportingUser($empid, 'supUser');
                $reportingofficer = $ro[0]['user_name'];
                $reportTo = $ro[0]['id'];
            }

            $current_date = date("Y-m-d");
            $data = array('from_employee' => $options['assign'], 'raise_from' => $options['assign'], 'to_RO' => $reportTo, 'raise_RO' => $options['to_RO'], 'transfer_date' => $current_date);
            $data2 = array('approval_id' => $options['assignapproval'][$key],
                'from_employee' => $options['employee'],
                'assigned_employee' => $options['assign'],
                'ro' => $reportingofficer,
                'partner_id' => $this->session->userdata('partner_id'),
                'assigned_date' => date("Y-m-d H:i:s")
            );

            $this->db->where('from_employee', $options['employee']);
            $this->db->where('approval_id', $options['assignapproval'][$key]);
            $result = $this->db->update('approval_note', $data);
            $result2 = $this->db->insert('approval_note_actionhistory', $data2);
        }

        return $result;
    }

    /*     * ** Action History ** */

    function getCountUserApprovalActionHistory($options = array()) {
        $data = array();
        if (!empty($options['employee'])) {
            $this->db->where('ana.from_employee', $options['employee']);
        }
        $userid = $this->session->userdata('user');
        $this->db->where('ana.assigned_employee', $userid);
        $this->db->select('an.approval_no,ana.*');
        $this->db->join('approval_note an', 'an.approval_id=ana.approval_id');
        $this->db->where('ana.partner_id', $this->session->userdata('partner_id'));
        $query = $this->db->get('approval_note_actionhistory ana');
        return $query->num_rows();
    }

    function getPartner($id) {
        $this->db->select('*');
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $this->db->where('approval_id', $id);
        $query = $this->db->get('approval_note');
        return $query->num_rows();
    }

    function getPartnerInternal($id) {
        $this->db->select('*');
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $this->db->where('internal_id', $id);
        $query = $this->db->get('internal_note');
        return $query->num_rows();
    }

    /*     * ** Count of Action History ** */

    function countActionHistory() {
        $data = array();
        $this->db->select('*');
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->db->get('approval_note_actionhistory');
        return $query->num_rows();
    }

    /*     * * End *** */

    function getApprovalActionHistory($options = array()) {
        $data = array();
        if (isset($options['num']) && isset($options['offset']))
            $this->db->limit($options['num'], $options['offset']);
        if (!empty($options['employee'])) {
            $this->db->where('ana.from_employee', $options['employee']);
        }
        if ($options['orderby'] != NULL && $options['ordertype'] != NULL)
            $this->db->order_by($options['orderby'], $options['ordertype']);
        $this->db->select('an.approval_no,ana.*');
        $this->db->join('approval_note an', 'an.approval_id=ana.approval_id');
        $this->db->where('ana.partner_id', $this->session->userdata('partner_id'));
        $query = $this->db->get('approval_note_actionhistory ana');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /*     * ** End ** */


    /*     * ** User action history *** */

    function getUserApprovalActionHistory($options = array()) {
        $data = array();
        if (isset($options['num']) && isset($options['offset']))
            $this->db->limit($options['num'], $options['offset']);
        if (!empty($options['employee'])) {
            $this->db->where('ana.from_employee', $options['employee']);
        }
        $userid = $this->session->userdata('user');
        $this->db->where('ana.assigned_employee', $userid);
        if ($options['orderby'] != NULL && $options['ordertype'] != NULL)
            $this->db->order_by($options['orderby'], $options['ordertype']);
        $this->db->select('an.approval_no,ana.*');
        $this->db->join('approval_note an', 'an.approval_id=ana.approval_id');
        $this->db->where('ana.partner_id', $this->session->userdata('partner_id'));
        $query = $this->db->get('approval_note_actionhistory ana');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /*     * ** End ** */

    function getInternalNote($approval_id) {
        $data = array();
        $this->db->select('*');
        $this->db->from('internal_note');
        $this->db->where('approval_id', $approval_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    //////////// get the programe id using programme name//
    function getprogrammeidfromname($programme) {
        $data = array();
        $this->db->where('status', '1');
        if ($programme != NULL) {
            $this->db->select('programme_id,donor');
            $this->db->like('programme', $programme, 'both');
            $query = $this->db->get('master_programme');
            return $query->result_array();
        } else
            return $data;
    }

    //////////////// get the donor id using donor name///////
    function getmasteridfromname($master_name, $masterType = NULL, $p_id = NULL) {
        $data = array();
        if ($master_name != '') {
            $this->db->where('status', '1');
            $this->db->where('master_type', $masterType);
            if ($p_id != NULL) {
                $this->db->where('pid', $p_id);
            }
            $this->db->select('master_id');
            $this->db->like('master_name', $master_name, 'both');
            $query = $this->db->get('master_settings');
            return $query->result_array();
        } else
            return $data;
    }

    ////////////////////////////////returns the available amount for the given donor details /////////////////////////
    function amountAvailable($donor, $budgethead, $lineitem, $sublineitem, $program) {
        $sublineitemid = $sublineitem;
        $lineitemid = $lineitem;
        $budgetid = $budgethead;
        $donorid = $donor;
        $programmeid = $program;
        /*         * ** select current financial year *** */
        $financialArray = $this->Mmaster->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);
        /*         * *** End ** */
        $assignAmount = $this->Mmaster->checkAmountAssigned($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to);
        $approvalAmount = $this->Mmaster->checkApprovalNoteAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to);
        $internalAmount = $this->Mmaster->checkInternalAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to);
        $availableAmount = $assignAmount - ($approvalAmount);
        return $availableAmount;
    }

    ///////////////////function to insert the imported datas //////////////////////////////
    function record_insert($table, $data) {
        $this->db->insert($table, $data);
        return true;
    }

    /////////////function to insert the AN edited details//////
    function insertANedithistory($data) {
        $this->db->insert('an_edit_history', $data);
        return true;
    }

    function get_in_count($an_id, $an_don, $an_bh, $an_li, $an_details) {
        //echo $an_id; echo " "; echo $an_don; echo " ";echo $an_bh;echo " "; echo $an_li; exit;
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
        $this->db->select('*');
        $this->db->where($details);
        $this->db->where('status !=', 'cancelled');
        $query = $this->db->get('internal_note');
        return $query->num_rows();
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
        $this->db->select_sum('amount_toapprove');
        $this->db->where($details);
        $query = $this->db->get('internal_note');
        return $query->result_array();
    }

}

?>