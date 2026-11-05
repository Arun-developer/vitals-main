<?php
class Mbudget extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->ais = $this->load->database('ais', true);
    }
    public function getList()
    {
        $data = array();
        $query = $this->db->get('fbudget');
        if ($query->num_rows > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }return $data;
    }
    public function insertApprovalnote($innovation, $installment, $approval_id)
    {
        $data = array('innovation' => $innovation,
            'installment' => $installment,
            'approval_note' => $approval_id);
        $this->db->insert('f_approval_note', $data);
    }
    public function getApprovalNote($innovation, $installment)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where('installment', $installment);
        $query = $this->db->get('sf_approval_note');
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
        $this->db->insert('sf_fund_utilization', $data);
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
        $this->db->update('sf_fund_utilization', $data);
    }

    public function getFundUtilization($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('sf_fund_utilization');
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
        $this->db->delete('sf_fund_utilization');
        return true;
    }

    public function getFundUtilizationList($innovation, $installment)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where('installment', $installment);
        $query = $this->db->get('sf_fund_utilization');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertTarget($options = array())
    {

        $data = array(
            'innovation' => $options['innovation'],
            'activity' => $options['activity'],
            'target' => $options['target'],
            'month' => $options['month'],
            'achieved' => $options['achieved'],
            'next_target' => $options['next_target'],
            'created_date' => date($this->config->item('mysqlDate')));
        $this->db->insert('sf_monthly_report', $data);
        return true;
    }

    public function updateTarget($options = array())
    {
        $data = array(
            'innovation' => $options['innovation'],
            'activity' => $options['activity'],
            'target' => $options['target'],
            'month' => $options['month'],
            'achieved' => $options['achieved'],
            'next_target' => $options['next_target'],
            'modified_date' => date($this->config->item('mysqlDate')));
        $this->db->where('id', $options['id']);
        $this->db->update('sf_monthly_report', $data);
        return true;
    }

    public function getTargetList($innovation, $activity)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where('activity', $activity);
        $query = $this->db->get('sf_monthly_report');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getTargetDetails($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('sf_monthly_report');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
