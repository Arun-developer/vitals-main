<?php
#
# Model Class -  hs_quad_master_settings
#

class Mdiscussion extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function create($options = array())
    {
        $data = array('activity' => $options['activity'],
            'discussion_title' => $options['discussion_title'],
            'description' => $options['description'],
            'link' => $options['link'],
            'documents' => $options['documents'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $result = $this->db->insert('discussion', $data);
        return $result;
    }
    public function add_comments($options = array())
    {
        $data = array('discussion' => $options['discussion'],
            'title' => $options['title'],
            'comments' => $options['comments'],
            'documents' => $options['documents'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $result = $this->db->insert('discussion_comments', $data);
        $this->db->query("UPDATE `discussion` SET `no_of_comments` = no_of_comments+1 WHERE `id` = '" . $options['discussion'] . "'");
        return $result;
    }
    public function update_discussion($options = array())
    {
        $data = array(
            'discussion_title' => $options['discussion_title'],
            'description' => $options['description'],
            'link' => $options['link'],
            'documents' => $options['documents'],
            'created_date' => date($this->config->item('mysqlDate')),
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

    public function deleteComments($id, $discussion)
    {
        $this->db->where('id', $id);
        $this->db->delete('discussion_comments');
        $this->db->query("UPDATE `discussion` SET `no_of_comments` = no_of_comments-1 WHERE `id` = '" . $discussion . "'");
        return true;
    }

    public function getAllCount($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(*) as total");

        if ($whereQuery != null) {
            $query = $this->db->get_where('discussion_comments', $whereQuery);
        } else {
            $query = $this->db->get('discussion_comments');
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

		$this->db->order_by('id', 'desc');
		
        $this->db->select("DC.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = DC.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = DC.modified_by) as employee_name", false);
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('discussion_comments DC', $whereQuery);
        } else {
            $query = $this->db->get('discussion_comments DC');
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
        if (!empty($options['discussion'])) {
            $searchArray[] = "discussion 	 = '" . $options['discussion'] . "'";
        }

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

    public function getDiscussionDetails($activity)
    {
        $data = array();
        $this->db->select("D.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = D.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = D.modified_by) as modified_emp", false);

        $this->db->where("activity", $activity);
        $query = $this->db->get('discussion D');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
