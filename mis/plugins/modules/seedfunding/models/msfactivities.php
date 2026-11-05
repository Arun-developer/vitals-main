<?php
#
# Model Class -  hs_quad_master_settings
#

class Msfactivities extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function insert($options = array())
    {

        $data = array(
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $this->db->where('innovation', $options['innovation']);
        $this->db->update('sf_activities', $data);
        $this->db->insert('sf_activities_history', $data);
        $this->inserAmount( $options);
        return true;
    }
    public function update($options = array())
    {
        $data = array(
            'innovation' => $options['innovation'],
            'activity' => $options['activity'],
            'milestone' => $options['milestone'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'));
        $this->db->where('id', $options['id']);
        $this->db->update('sf_activities', $data);
        $this->db->insert('sf_activities_history', $data);
        $this->inserAmount($options['id'], $options);
        return true;
    }
    public function updatefund($options = array())
    {
        $data = array('vfunded' => $options['vfunded']);
        $this->db->where('goal', $options['goal']);
        $this->db->where('milestone', $options['milestone']);
        $this->db->where('installment', $options['installment_id']);
        $this->db->update('sf_activity_amount', $data);
        $data2 = array('vfunded' => $options['vfunded'],
            'goal' => $options['goal'],
            'milestone' => $options['milestone'],
            'installment' => $options['installment_id']);
        $this->db->insert('sf_activity_amount', $data2);
    }
    public function inserAmount( $options = array())
    {

        for ($i = 0; $i < count($options['installment_id']); $i++) {
            if ($this->checkDuplicateAmount( $options['milestone'], $options['installment_id'])) {
                $data = array(
                    'goal' => $options['goal'],
                    'milestone' => $options['milestone'],
                    'vfunded' => $options['vfunded'],
                    'installment' => $options['installment_id']);
                $this->db->insert('sf_activity_amount', $data);
                $this->db->insert('sf_activity_amount_history', $data);
            } else {
                $this->db->set('vfunded', $options['vfunded']);
                $this->db->where('milestone', $options['milestone']);
                $this->db->where('goal', $options['goal']);
                $this->db->where('installment', $options['installment_id']);
                $this->db->update('sf_activity_amount');

            }
        }
        return true;
    }
    public function checkDuplicateAmount( $milestone, $installment)
    {
        $data = array();
        $this->db->where('milestone', $milestone);
        $this->db->where('installment', $installment);
        $query = $this->db->get('sf_activity_amount');
        if ($query->num_rows() > 0) {
            return false;
        }
        return true;
    }

    public function getAmount($activity)
    {
        $data = array();
        $this->db->select("installment,vfunded as amount");
        $this->db->where('activity', $activity);
        $query = $this->db->get('sf_activity_amount');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['installment']] = $row['amount'];

            }
        }
        $query->free_result();
        return $data;
    }
    public function getvillgrofund($milestone)
    {
        $data = array();
        $this->db->select("installment,vfunded as amount");
        $this->db->where('milestone', $milestone);
        $query = $this->db->get('sf_activity_amount');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['installment']] = $row['amount'];

            }
        }
        $query->free_result();
        return $data;
    }
    public function getvillgrofundhistory($milestone)
    {
        $data = array();
        $this->db->select("installment,vfunded as amount");
        $this->db->where('milestone', $milestone);
        $query = $this->db->get('sf_activity_amount_history');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['installment']] = $row['amount'];

            }
        }
        $query->free_result();
        return $data;
    }
    public function getbudgetfund($milestone)
    {
        $data = array();
        $this->db->select("installment,budgetamt as amount");
        $this->db->where('id', $milestone);
        $query = $this->db->get('sf_budget');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['installment']] = $row['amount'];

            }
        }
        $query->free_result();
        return $data;
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('sf_activities');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    public function getAllCount($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(*) as total");

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('sf_activities IL', $whereQuery);
        } else {
            $query = $this->db->get('sf_activities IL');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    /**
     * Function : getLimitRecords method is used for get Limit records from  vendors.
     *
     * @param array $options
     *
     */

    public function getLimitRecords($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select('IL.*,SFM.milestone,SFG.goal,SFA.amount,SFA.vfunded,SI.from,SI.to');

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($options['innovation'])) {
            $this->db->where('IB.innovation', $options['innovation']);
        }

        $this->db->join('sf_installment SI', 'SI.innovation = IL.innovation', 'left');
        $this->db->join('sf_activity_amount SFA', 'IL.id = SFA.activity', 'left');
        $this->db->join('sf_milestone SFM', 'IL.milestone = SFM.id', 'left');
        $this->db->join('sf_goal SFG', 'SFM.goal = SFG.id', 'left');
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('sf_activities IL', $whereQuery);
        } else {
            $query = $this->db->get('sf_activities IL');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getActivityList($innovation, $milestone = null, $goal = null)
    {
        $data = array();
        $this->db->select('SFB.*,SFM.milestone,SFM.progress_status,SFM.id as mid,SFG.goal,SFI.from,SFI.to');
        $this->db->join('sf_installments SFI', 'SFB.installment = SFI.id', 'left');
        $this->db->join('sf_milestone SFM', 'SFB.milestone = SFM.id', 'left');
        $this->db->join('sf_goal SFG', 'SFM.goal = SFG.id', 'left');
        $this->db->where('SFB.innovation', $innovation);
        if ($milestone != null) {
            $this->db->where('SFB.milestone', $milestone);
        }

        $this->db->order_by('SFI.from');

        $query = $this->db->get('sf_budget SFB');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getActivityLists($innovation, $milestone = null)
    {
        $data = array();
        $this->db->select('IL.*,SFM.milestone,SFM.id as mid,SFG.goal,SFI.from,SFI.to');
        $this->db->join('sf_installments SFI', 'IL.installment = SFI.id', 'left');
        $this->db->join('sf_milestone SFM', 'IL.milestone = SFM.id', 'left');
        $this->db->join('sf_goal SFG', 'SFM.goal = SFG.id', 'left');
        $this->db->where('IL.innovation', $innovation);
        if ($milestone != null) {
            $this->db->where('IL.milestone', $milestone);
        }
        $this->db->order_by('IL.installment');
        $this->db->order_by('IL.id');

        $query = $this->db->get('sf_activities IL');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getActivityhistory($innovation)
    {
        $data = array();
        $this->db->select('IL.*,SFM.milestone,SFM.id as mid,SFG.goal,SFI.from,SFI.to');
        $this->db->join('sf_installments_history SFI', 'IL.installment = SFI.id', 'left');
        $this->db->join('sf_milestone_history SFM', 'IL.milestone = SFM.id', 'left');
        $this->db->join('sf_goal_history SFG', 'SFM.goal = SFG.id', 'left');
        $this->db->where('IL.innovation', $innovation);
        $this->db->order_by('IL.installment');
        $query = $this->db->get('sf_activities_history IL');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
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
        if (!empty($options['innovation'])) {
            $searchArray[] = "IL.innovation = '" . $options['innovation'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    #
    public function getActivityDetails($innovation, $id)
    {
        $data = array();
        $this->db->select('IL.*,SFM.milestone,SFG.goal,SFG.id as goalid,SFM.id as milestoneid,SFA.vfunded,SFI.from,SFI.to');
        $this->db->where('IL.innovation', $innovation);
        $this->db->where('IL.id', $id);
        $this->db->join('sf_activity_amount SFA', 'IL.id	 = SFA.activity', 'left');
        $this->db->join('sf_installments SFI', 'IL.installment = SFI.id', 'left');
        $this->db->join('sf_milestone SFM', 'IL.milestone = SFM.id', 'left');
        $this->db->join('sf_goal SFG', 'SFM.goal = SFG.id', 'left');
        $query = $this->db->get('sf_activities IL');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getLineitemByBudget($budget)
    {
        $data = array();
        $this->db->where('budget', $budget);
        $query = $this->db->get('sf_activities');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function mailContent($id)
    {
        $content = '';
        return $content;
    }

    public function updateProgressStatus($innovation, $activity, $status)
    {
        $query = "UPDATE sf_activities SET progress_status = '" . $status . "' WHERE innovation = '" . $innovation . "' AND milestone = '" . $activity . "'";
        $result = $this->db->query($query);
        return true;
    }

    public function progressStatus()
    {
        return array('Inprogress', 'Completed', 'Not Completed');
    }

}
