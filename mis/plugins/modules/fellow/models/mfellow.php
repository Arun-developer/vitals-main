<?php

class Mfellow extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->ais = $this->load->database('ais', true);
        $this->hris = $this->load->database('hris', true);
    }

    public function getfelloerecords()
    {
        $data = array();
        $query = "select JA.application_id as id,JA.firstname,JA.lastname,JA.email,JA.source,JA.last_experience as experience,FOA.oferrletter,FOA.notes from  " . $this->hris->database . ".hs_hr_job_application as JA LEFT JOIN
			" . $this->hris->database . ".fellow_offerletter_acceptance as FOA ON(FOA.app_id = JA.application_id) where FOA.status = 1";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function insertSuggestfellow($innovationid = null, $id = null, $suggest = array())
    {
        foreach ($suggest as $key => $value):

            $data = array(
                'innovation' => $innovationid,
                'applicant_name' => $value,
                'request_id' => $id,
                'status' => 1,
            );
            $result2 = $this->db->insert('assign_fellow', $data);

        endforeach;

        return true;
    }

    public function getInnvationStage()
    {
        return array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation');
    }

    public function statusArr()
    {
        return array(0 => 'Pending', 1 => 'Accepted', 2 => 'Rejected');
    }
    public function getkey()
    {
        $data = array();
        $this->db->select_max('request_key');
        $this->db->limit(1, 0);
        $query = $this->db->get('request_fellow');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;

            }
        }return $data;

    }

    public function getLimitRecords($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('instance_master', $whereQuery);
        } else
        if ($options['innovationid'] != '') {
            $this->db->where('innovation', $options['innovationid']);
        }
        $query = $this->db->get('request_fellow');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getapplicantprofile($id = null)
    {
        $data = array();
        $this->db->where_in('applicant_id', $id);
        $query = $this->db->get('fellow_applicant');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }return $data;
    }

    public function getapplicantList($innovation)
    {
        $data = array();
        $query = "select AF.*,JA.firstname,JA.lastname,JA.source,JA.last_experience as experience,FOA.oferrletter,FOA.notes from  " . $this->hris->database . ".hs_hr_job_application as JA LEFT JOIN " . $this->hris->database . ".fellow_offerletter_acceptance as FOA ON(FOA.app_id = JA.application_id) LEFT JOIN
			assign_fellow as AF ON(AF.applicant_id = JA.application_id) where AF.innovation = '" . $innovation . "'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }
        $result->free_result();
        return $data;
    }
    public function getapplicantslists($id)
    {
        $data = array();
        $query = $this->db->get('fapplicant_details');
        $this->db->where('id', $id);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function updates($options = array())
    {
        for ($i = 0; $i < count($options['applicant_id']); $i++) {
            $data = array('first_name' => $options['fname'][$i],
                'last_name' => $options['lname'][$i],
                'innovation' => $options['innovation'],
                'offerletter' => $options['offerletter'][$i],
                'notes' => $options['notes'][$i],
                'status' => $options['status'][$i],
                'shortlist' => $options['shortlist'][$i]);
            if ($options['applicant_id'] == '') {
                $result = $this->db->insert('fapplicant_details', $data);
            } else {
                $this->db->where('applicant_id', $options['applicant_id'][$i]);
                $result = $this->db->update('fapplicant_details', $data);
            }
        }
        return $result;

        return $this->db->affected_rows();
    }
    public function getinductionlist()
    {
        $data = array();
        $query = $this->db->get('fjob_induction');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }return $data;
    }
    public function insertinduction($options)
    {

        $data = array('innovation' => $options['innovation'],
            'program_title' => $options['program_title'],
            'program_description' => $options['program_description'],
            'start_date' => $options['start_date'],
            'end_date' => $options['to_date'],
            'mentor' => $options['mentor'],
            'reporting_officer' => $options['reporting_officer'],
            'document' => $options['filename']);

        $this->db->insert('fjob_induction', $data);
        return $result;
    }
    public function insertapplicant($options = array())
    {
        $data = array('applicant_name' => $options['applicant_name'],
            'experience' => $options['experience'],
            'qualification' => $options['qualification'],
            'history' => $options['history'],
            'appointment_date' => $options['date_appointment'],
            'exp_from' => $options['exp_from'],
            'exp_to' => $options['exp_to'],
            'origin' => $options['origin'],
            'address1' => $options['address'],
            'city' => $options['city'],
            'telephone' => $options['telephone'],
            'mobile' => $options['mobile'],
            'email' => $options['email'],
            'profile' => $options['filename'],
            'area' => $options['area'],
        );
        $this->db->insert('fellow_applicant', $data);

        $id = $this->db->insert_id();
        $data2 = array('applicant_id' => $id,
            'applicant_name' => $options['applicant_name'],
            'date_received' => $options['date_appointment'],
            'qualification' => $options['qualification'],
            'experience' => $options['experience'],
            'profile' => $options['filename'],
        );

        $result2 = $this->db->insert('fapplicant_details', $data2);

        return $result2;
    }

    /**
     * Function : _search method is used for generate Search query .
     *
     * @param array $options
     *
     */

    public function _search($options = array())
    {
        $searchArray = array();
        $where = null;
        if (!empty($options['vendor_name'])) {
            $searchArray[] = "vendor_name like '%" . $options['vendor_name'] . "%'";
        }

        if (!empty($options['contact_person'])) {
            $searchArray[] = "contact_person like '%" . $options['contact_person'] . "%'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }
    public function getjobDetails($key = null)
    {
        $data = array();
        $this->db->where('request_key', $key);
        $query = $this->db->get('request_fellow');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }return $data;
    }

    public function getapplicantDetails($id = null)
    {
        $data = array();
        $query = $this->db->get('request_fellow');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getapplicantstatus($id = null)
    {
        $data = array();
        $query = $this->db->get('fapplicant_details');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insert($options = array())
    {
        $data = array(
            'request_key' => $options['request_key'],
            'innovator_name' => $options['innovator_name'],
            'request_date' => $options['request_date'],
            'from_period' => $options['from_period'],
            'to_period' => $options['to_period'],
            'job_description' => $options['job_description'],
            'documents' => $options['filename'],
            'status' => 0,
            'innovation' => $options['innovationid'],
        );
        $result = $this->db->insert('request_fellow', $data);
        return $result;
    }

    public function updatereq($options = array())
    {
        $dataup = array(
            'request_key' => $options['request_key'],
            'innovator_name' => $options['innovator_name'],
            'request_date' => $options['request_date'],
            'from_period' => $options['from_period'],
            'to_period' => $options['to_period'],
            'job_description' => $options['job_description'],
            'status' => 0);
        $this->db->where('id', $this->input->post('id'));

        $result = $this->db->update('request_fellow', $dataup);
        return $result;
    }

    public function updateliststatus($options = array())
    {

        $dataup = array('status' => $options['status']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_fellow', $dataup);
        return $result;
    }

    public function updateIncuabteeStatus($options = array())
    {

        $dataup = array('status' => $options['status']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_fellow', $dataup);
        return $result;
    }

    public function getactionHistory($investerid)
    {
        $data = array();
        $this->db->select("I.first_name as name,IH.*");
        $this->db->join('invester I', 'I.id = IH.invester_id', 'left');

        $this->db->where("invester_id", $investerid);
        $query = $this->db->get('investeraction_history IH');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function insertbudget($options = array())
    {
        $data = array(
            'innovation' => $options['innovation'],
            'line_item' => $options['lineitem'],
            'start_date' => $options['start_date'],
            'end_date' => $options['end_date'],
            'amount' => $options['amount'],
            'remarks' => $options['remarks']);
        $result = $this->db->insert('fbudget', $data);
        return $result;
    }
    public function getbudgetlist($innovation, $budgetid = null)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where_in('id', $budgetid);
        $query = $this->db->get('fbudget');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }return $data;
    }
    public function insertApprovalnote($innovation, $installment, $approval_id, $budgetid)
    {
        $data = array('innovation' => $innovation,
            'installment' => $installment,
            'approval_note' => $approval_id,
            'budgetid' => $budgetid);
        $this->db->insert('fbudget_approvalnote', $data);
    }
    public function getApprovalNote($innovation, $budgetid)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where('budgetid', $budgetid);
        $query = $this->db->get('fbudget_approvalnote');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['approval_note'];
            }
        }
        $query->free_result();
        if (count($data)) {
            return $this->getApprovalList($data);
        } else {
            return array();
        }

    }
    public function getFundUtilizationList($innovation, $budgetid)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where('budgetid', $budgetid);
        $query = $this->db->get('fbudget_fundutilization');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getApprovalList($approval_note = array())
    {
        $data = array();
        $q = "select IF(AN.donor=0,AN.other_donor,D.master_name) as donor,
							IF(line_item=0,other_line_item,LI.master_name) as line_item,
							IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
							AN.amt_available,
							AN.amt_required ,
							MP.programme as programme_name,MP.programme_head,AP.* from approval_note AP";
        $q .= " left join master_programme MP on AP.programme= MP.programme_id";
        $q .= " left join approval_note_donors AN on AP.approval_id= AN.approval_id";
        $q .= " left join master_settings D on D.master_id= AN.donor";
        $q .= " left join master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join master_settings LI on LI.master_id= AN.line_item";
        $q .= " where AP.approval_id IN (" . implode(',', $approval_note) . ")";
        $q .= " group by AP.approval_id";
        $query = $this->ais->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function insertFundUtilization($innovation, $installment, $form = array())
    {
        $data = array('innovation' => $innovation,
            'installment' => $installment,
            'budgetid' => $budgetid,
            'date' => date2mysql($form['date']),
            'amount' => $form['amount'],
            'comments' => $form['comments'],
            'document' => $form['document'],
            'created_date' => date($this->config->item('mysqlDate')));
        $this->db->insert('fbudget_fundutilization', $data);
    }
    public function updateFundUtilization($innovation, $installment, $form = array())
    {
        $data = array('innovation' => $innovation,
            'installment' => $installment,
            'date' => date2mysql($form['date']),
            'amount' => $form['amount'],
            'comments' => $form['comments'],
            'document' => $form['document'],
            'modified_date' => date($this->config->item('mysqlDate')));
        $this->db->where('id', $form['id']);
        $this->db->update('fbudget_fundutilization', $data);
    }

    public function getFundUtilization($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('fbudget_fundutilization');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function deleteFundUtilization($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('fbudget_fundutilization');
        return true;
    }
    public function updateapplicants($options = array())
    {

        $query = "UPDATE fapplicant_details SET applicant_name = '" . $options['applicant_name'] . "', qualification = '" . $options['qualification'] . "', experience ='" . $options['experience'] . "' , WHERE applicant_id = '" . $options['id'] . "'";
        $result = $this->db->query($query);
        return $result;

    }

}
