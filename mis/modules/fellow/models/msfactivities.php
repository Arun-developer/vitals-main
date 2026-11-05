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
            'innovation' => $options['innovation'],
            'activity' => $options['activity'],
            'milestone' => $options['milestone'],
            'from' => $options['from'],
            'to' => $options['to'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $this->db->insert('sf_activities', $data);

        $this->inserAmount($this->db->insert_id(), $options);
        return true;
    }
    public function update($options = array())
    {
        $data = array(
            'innovation' => $options['innovation'],
            'activity' => $options['activity'],
            'milestone' => $options['milestone'],
            'from' => $options['from'],
            'to' => $options['to'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'));
        $this->db->where('id', $options['id']);
        $this->db->update('sf_activities', $data);
        $this->inserAmount($options['id'], $options);
        return true;
    }

    public function inserAmount($activity, $options = array())
    {
        foreach ($options['installment_id'] as $key => $value):

            if ($this->checkDuplicateAmount($activity, $value)) {
                $data = array(
                    'activity' => $activity,
                    'amount' => $options['amount'][$key],
                    'installment' => $options['installment_id'][$key]);
                $this->db->insert('sf_activity_amount', $data);
            } else {
                $this->db->set('amount', $options['amount'][$key]);
                $this->db->where('activity', $activity);
                $this->db->where('installment', $options['installment_id'][$key]);
                $this->db->update('sf_activity_amount');
            }
        endforeach;
        return true;
    }
    public function checkDuplicateAmount($activity, $installment)
    {
        $data = array();
        $this->db->where('activity', $activity);
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
        $this->db->select("installment,amount");
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
        $this->db->select('IL.*,SFM.milestone,SFG.goal,SFI.from as from_installment,SFI.to as to_installment,');

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($options['innovation'])) {
            $this->db->where('IB.innovation', $options['innovation']);
        }

        $this->db->join('sf_installments SFI', 'IL.installment = SFI.id', 'left');
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

    public function getActivityList($innovation)
    {
        $data = array();
        $this->db->select('IL.*,SFM.milestone,SFG.goal,SFI.from as from_installment,SFI.to as to_installment,');
        $this->db->where('IL.innovation', $innovation);
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
    public function getActivityDetails($id)
    {
        $data = array();
        $this->db->select("IL.*,SFM.goal");
        $this->db->where('IL.id', $id);
        $this->db->join('sf_milestone SFM', 'IL.milestone = SFM.id', 'left');
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
        $this->db->set('progress_status', $status);
        $this->db->where('id', $activity);
        $this->db->update('sf_activities');
    }

    public function progressStatus()
    {
        return array('Inprogress', 'Completed', 'Not Completed');
    }

}
