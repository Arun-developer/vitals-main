<?php

class Mtraining extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->ais = $this->load->database('ais', true);
    }

    public function getLimitRecords($options = array())
    {
        $data = array();
        if ($options['innovationid'] != '') {
            $this->db->where('innovation', $options['innovationid']);
        }
        $query = $this->db->get('request_training');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();

        return $data;
    }

    public function gettrainingmaster()
    {
        $data1 = array();
        $query = $this->db->get('training_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data1[] = $row;

            }
        }$query->free_result();
        return $data1;
    }
    public function getparticipant($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('training_participant');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }return $data;

    }

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

    public function gettrainingDetails($id = null)
    {
        $data = array();
        $query = $this->db->get('training_participant');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function gettrainingDetail($id = null)
    {
        $data = array();
        $query = $this->db->get('request_training');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function searchMentor($options = array())
    {

        $data = array();

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('mentor', $whereQuery);
        } else {
            $query = $this->db->get('mentor');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }
    public function inserttraining_detail($options = array())
    {
        $data2 = array(
            'training_id' => $options['id'],
            'innovation' => $options['innovationid'],
            'facilitator' => $options['facilitator_name'],
            'topic' => $options['topic'],
            'start_date' => $options['start_date'],
            'end_date' => $options['to_date'],
            'document' => $options['filename'],
            'description' => $options['description']);
        $result = $this->db->insert('training_details', $data2);
        return $result;

    }
    public function insert($options = array())
    {
        $data = array(
            'innovation' => $options['innovationid'],
            'start_date' => $options['start_date'],
            'end_date' => $options['to_date'],
            'fund_allocated' => $options['fund_allocated'],
            'fund_utilized' => $options['fund_utilized'],
            'documents' => $options['filename']);

        $result = $this->db->insert('request_training', $data);
        return $result;
    }
    public function insertparticipant($options = array())
    {
        $data = array(
            'participant_name' => $options['participant_name'],
            'participant_type' => $options['participant_type'],
            'participant_status' => $options['participant_status'],
            'participant_organization' => $options['participant_organization']);

        $result = $this->db->insert('training_participant', $data);
        return $result;
    }
    public function updateparticipant($options = array())
    {
        $dataup = array(
            'participant_name' => $options['participant_name'],
            'participant_type' => $options['participant_type'],
            'participant_status' => $options['participant_status'],
            'participant_organization' => $options['participant_organization']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('training_participant', $dataup);
        return $result;
    }
    public function update($options = array())
    {
        $dataup = array(
            'innovation' => $options['innovationid'],
            'title' => $options['title'],
            'topic' => $options['topic'],
            'requested_on' => $options['requested_on'],
            'training_name' => $options['training_name'],
            'Document' => $options['filename'],
            'description' => $options['description']);
        $this->db->where('id', $this->input->post('id'));

        $result = $this->db->update('request_training', $dataup);
        return $result;
    }
    public function delete($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $this->db->delete('request_training', $data);
        return true;
    }

    public function updateliststatus($options = array())
    {

        $dataup = array('status' => $options['status']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_training', $dataup);
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
    public function updateAll($options = array(), $innovationid, $requestid)
    {
        foreach ($options['id'] as $key => $activity) {
            $data = array(
                'invester_status' => $options['memberstatus'][$key],
                'incubatee_publish' => $options['incubateepublish'][$key],
                'incubatee_status' => $options['incubateestatus'][$key],
                'amount_approved' => $options['amountapproved'][$key],
            );
            $this->db->where('id', $options['id'][$key]);
            $this->db->where('innovation', $innovationid);
            $this->db->where('request_id', $requestid);
            $result = $this->db->update('assign_invester', $data);
        }

        return $result;
    }
    public function getProgramstageandProgramservice($title)
    {
        $data = array();
        $this->db->select("PS.id,PS.program_service_offering");
        $this->db->join('program_service_offering PSO', 'PSO.id =PS.program_service_offering', 'left');
        $this->db->where("PSO.title", $title);
        $query = $this->db->get('program_stage PS');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data[0];
    }
    public function insertbudget($options = array())
    {
        $data = array(
            'innovation' => $options['innovation'],
            'line_item' => $options['line_item'],
            'start_date' => $options['start_date'],
            'end_date' => $options['end_date'],
            'amount' => $options['amount'],
            'remarks' => $options['remarks']);
        $result = $this->db->insert('training_budget', $data);
        return $result;
    }
    public function getbudgetlist($innovation, $budgetid = null)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where_in('id', $budgetid);
        $query = $this->db->get('training_budget');
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
        $this->db->insert('tbudget_approvalnote', $data);
    }
    public function getApprovalNote($innovation, $budgetid)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where('budgetid', $budgetid);
        $query = $this->db->get('tbudget_approvalnote');
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
        $query = $this->db->get('tbudget_fundutilization');
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
        $q .= " where AP.approval_id IN (" . php72_implode(',', $approval_note) . ")";
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
    public function getInternalNote($approval_id)
    {
        $data = array();
        $q = "select INTER.*,IF(INTER.donor=0,INTER.other_donor,D.master_name) as donor,
							IF(INTER.cost_centre=0,INTER.other_cost_centre,CC.master_name) as cost_centre,
							IF(INTER.budget_head=0,INTER.other_budget_head,BH.master_name) as budget_head,
							IF(INTER.line_item=0,INTER.other_line_item,LI.master_name) as line_item,
							AN.approval_no,AN.from_employee
							from internal_note INTER";
        $q .= " left join approval_note AN on AN.approval_id= INTER.approval_id";
        $q .= " left join master_programme MP on MP.programme_id = AN.programme";
        $q .= " left join master_settings D on D.master_id= INTER.donor";
        $q .= " left join master_settings BH on BH.master_id= INTER.budget_head";
        $q .= " left join master_settings CC on CC.master_id= INTER.cost_centre";
        $q .= " left join master_settings LI on LI.master_id= INTER.line_item";

        $q .= " where INTER.approval_id = '" . $approval_id . "'";
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
            'date' => date2mysql($form['date']),
            'amount' => $form['amount'],
            'comments' => $form['comments'],
            'document' => $form['document'],
            'created_date' => date($this->config->item('mysqlDate')));
        $this->db->insert('tbudget_fundutilization', $data);
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
        $this->db->update('tbudget_fundutilization', $data);
    }

    public function getFundUtilization($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('tbudget_fundutilization');
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
        $this->db->delete('t_fundutilization');
        return true;
    }
    public function updates($update)
    {
        if (!empty($update)) {
            foreach ($update['status'] as $key => $value) {

                $query = "update training_participant set `status` = '" . $key . "' where `id` IN ('" . php72_implode("','", $value) . "')";
                $this->db->query($query);

            }
            return $this->db->affected_rows();

        }

    }

}
