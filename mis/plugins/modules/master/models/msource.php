<?php
#
# Model Class -  hs_quad_master_settings
#

class Msource extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function insert($options = array())
    {
        $data = array('employee' => $options['employee'],
            'source_type' => $options['source_type'],
            'source_name' => $options['source_name'],
            'contact_person' => $options['contact_person'],
            'designation' => $options['designation'],
            'address' => $options['address'],
            'phone' => $options['phone'],
            'mobile' => $options['mobile'],
            'email' => $options['email'],
            'fax' => $options['fax'],
            'frequency' => $options['frequency'],
            'date' => date2mysql($options['date']),
            'alert' => $options['alert'],
            'link' => $options['link'],
            'username' => $options['username'],
            'password' => $options['password'],
            'pagecontent' => $options['pagecontent'],
            'description' => $options['description'],
            'document' => $options['document'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
			#echo'<pre>';print_r($data);die;
        $result = $this->db->insert('source_master', $data);
        return $result;
    }
    public function update($options = array())
    {
        $data = array('employee' => $options['employee'],
            'source_type' => $options['source_type'],
            'source_name' => $options['source_name'],
            'contact_person' => $options['contact_person'],
            'designation' => $options['designation'],
            'address' => $options['address'],
            'phone' => $options['phone'],
            'mobile' => $options['mobile'],
            'email' => $options['email'],
            'fax' => $options['fax'],
            'frequency' => $options['frequency'],
            'date' => date2mysql($options['date']),
            'alert' => $options['alert'],
            'link' => $options['link'],
            'username' => $options['username'],
            'password' => $options['password'],
            'pagecontent' => $options['pagecontent'],
            'description' => $options['description'],
            'document' => $options['document'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'));

        $this->db->where('id', $options['id']);
        $result = $this->db->update('source_master', $data);
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
        $this->db->db_debug = false;
        $result = $this->db->delete('source_master');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
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
        $data = array('status' => $options['status']);
        $this->db->where('id', $options['id']);
        $this->db->update('source_master', $data);
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
            $query = $this->db->get_where('source_master', $whereQuery);
        } else {
            $query = $this->db->get('source_master');
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

    public function getLimitRecords($options = array()){
        $data = array();
        $whereQuery = $this->_search($options);
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        $this->db->select("source_master.*,(select master_name from master_settings where id=source_master.source_type) as master_name, IF(alert = 1,'Yes','No') as alert_title", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = source_master.employee) as emp_name", false);
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('source_master', $whereQuery);
        } else {
            $query = $this->db->get('source_master');
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
        if (!empty($options['source_name'])) {
            $searchArray[] = "source_name like '%" . $options['source_name'] . "%'";
        }

        if (!empty($options['employee'])) {
            $searchArray[] = "employee like '%" . $options['employee'] . "%'";
        }

        if (!empty($options['contact_person'])) {
            $searchArray[] = "contact_person like '%" . $options['contact_person'] . "%'";
        }

        if (!empty($options['source_type'])) {
            $searchArray[] = "source_type = '" . $options['source_type'] . "'";
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

    public function getSourceDetails($id)
    {
        $data = array();
        $this->db->select("source_master.*,(select master_name from master_settings where id=source_master.source_type) as master_name");
        $this->db->where("id", $id);
        $query = $this->db->get('source_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getSourceList()
    {
        $data = array();
        $this->db->select("source_master.*,(select master_name from master_settings where id=source_master.source_type) as master_name");
        $this->db->order_by('source_type', 'asc');
        $query = $this->db->get('source_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getSourceByType($type)
    {
        $data = array();
        $this->db->select('id');
        $this->db->where('source_type', $type);
        $query = $this->db->get('source_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['id'];
            }
        }
        $query->free_result();
        return $data;
    }

    #source combo
    public function getSourceCombo($type)
    {
        $data = array();
        $this->db->select('id,source_name');
        $this->db->where('source_type', $type);
        $this->db->order_by('source_name');
        $query = $this->db->get('source_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
