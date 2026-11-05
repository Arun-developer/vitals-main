<?php
class Mmeans_validation extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function insert($options = array())
    {
        $data = array('criteria' => $options['criteria'],
			'validation' => $options['validation']
		);
        $result = $this->db->insert('means_validation', $data);
        return $result;
    }
    public function update($options = array())
    {
        $data = array('criteria' => $options['criteria'],
            'validation' => $options['validation']);
        $this->db->where('id', $options['id']);
        $result = $this->db->update('means_validation', $data);
        return $result;
    }
    public function delete($id)
    {
        $this->db->db_debug = false;
        $this->db->where('id', $id);
        $this->db->delete('means_validation');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    public function changeStatus($options = array())
    {
        $data = array('status' => $options['status']);
        $this->db->where('id', $options['id']);
        $this->db->update('means_validation', $data);
        return true;
    }

    public function getAllCount($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(*) as total");

        if ($whereQuery != null) {
            $query = $this->db->get_where('means_validation', $whereQuery);
        } else {
            $query = $this->db->get('means_validation');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    public function getLimitRecords($options = array())
    { #echo'asd';
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("means_validation.*");
        $this->db->select("(select master_name from master_settings where id=means_validation.criteria) as criteria_title");

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('means_validation', $whereQuery);
        } else {
            $query = $this->db->get('means_validation');
        }
		#echo debug_last_query();die;

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function _search($options = array())
    {
        $searchArray = array();
        $where = null;
        if (!empty($options['criteria'])) {
            $searchArray[] = "criteria = '" . $options['criteria'] . "'";
        }

        if (!empty($options['value'])) {
            $searchArray[] = "validation = '" . $options['validation'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }
    public function getValidationInfo($id)
    {
        $data = array();
        $this->db->select("means_validation.*");
        $this->db->select("(select master_name from master_settings where id=means_validation.criteria) as criteria_title");
        $this->db->where("id", $id);
        $query = $this->db->get('means_validation');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getValidationByCriteria($criteria)
    {
        $data = array();
        $this->db->where("criteria", $criteria);
        $query = $this->db->get('means_validation');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
}
