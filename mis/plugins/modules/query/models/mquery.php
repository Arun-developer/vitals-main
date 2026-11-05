<?php
#
# Model Class -  hs_quad_master_settings
#

class Mquery extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function insert($options = array())
    {
        $data = array('activity' => $options['activity'],
            'subject_line' => $options['subject_line'],
            'query_description' => $options['query_description'],
            'documents' => $options['documents'],
            'due_date' => date2mysql($options['due_date']),
            'alert' => $options['alert'],
            'employee' => $options['employee'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $result = $this->db->insert('query', $data);
        return $result;
    }
    public function update($options = array())
    {
        $data = array('query_status' => $options['query_status'],
            'subject_line' => $options['subject_line'],
            'query_description' => $options['query_description'],
            'query_response' => $options['query_response'],
            'documents' => $options['documents'],
            'due_date' => date2mysql($options['due_date']),
            'alert' => $options['alert'],
            'employee' => $options['employee'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'));
        $this->db->where('id', $options['id']);
        $result = $this->db->update('query', $data);
        return $result;
    }

    /**
     * Function : delete method is used for delete records by changing status to -1.
     *
     * @param int $vendor_id
     *
     */

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('query');
        return true;
    }

    /**
     * Function : changeStatus method is used for Make active inactive.
     * $options - values
     *     staus
     *    vendor_id
     *
     * @param array $options
     *
     */

    public function changeStatus($options = array())
    {
        $data = array('query_status' => $options['status']);
        $this->db->where('id', $options['id']);
        $this->db->update('query', $data);
        return true;
    }

    /**
     * Function : getAllCount method is used for get count records from  vendors.
     * $options - values
     *     orderby
     *    ordertype
     *    vendorName
     *    contactPerson
     *
     * @param array $options
     *
     */
    public function getAllCount($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(*) as total");

        if ($whereQuery != null) {
            $query = $this->db->get_where('query', $whereQuery);
        } else {
            $query = $this->db->get('query');
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
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        $this->db->select("query.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = query.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = query.employee) as employee_name", false);
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('query', $whereQuery);
        } else {
            $query = $this->db->get('query');
        }

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
        if (!empty($options['subject_line'])) {
            $searchArray[] = "subject_line like '%" . $options['subject_line'] . "%'";
        }

        if (!empty($options['created_by'])) {
            $searchArray[] = "created_by = '" . $options['created_by'] . "'";
        }

        if (!empty($options['employee'])) {
            $searchArray[] = "employee = '" . $options['employee'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    /**
     * Function : getVendorInfo method is used for get vendor details .
     *
     * @param int $vendor_id
     *
     */

    public function getQueryDetails($id)
    {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('query');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
