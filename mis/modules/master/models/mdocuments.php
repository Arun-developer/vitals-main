<?php
#
# Model Class -  hs_quad_master_settings
#

class Mdocuments extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($options = array())
    {
        for ($i = 0; $i < count($options['document']); $i++) {
            $data = array('table' => $this->session->userdata('user_name'),
                'field' => $options['field'],
                'document' => $options['document'][$i],
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date($this->config->item('mysqlDate')),
                'tag' => $options['tag']);
            $result = $this->db->insert('document_master', $data);
        }

        return $result;
    }
    public function update($options = array())
    {
        $data = array('document' => $options['document'],
            'tag' => $options['tag']);
        $this->db->where('id', $options['id']);
        $result = $this->db->update('document_master', $data);
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
        $this->db->delete('document_master');
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
        $data = array('status' => $options['status']);
        $this->db->where('id', $options['id']);
        $this->db->update('document_master', $data);
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
            $query = $this->db->get_where('document_master', $whereQuery);
        } else {
            $query = $this->db->get('document_master');
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
            $this->db->order_by($options['orderby'], $options['orderby']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('document_master', $whereQuery);
        } else {
            $query = $this->db->get('document_master');
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
        if (!empty($options['activity_id'])) {
            $searchArray[] = "field = '" . $options['activity_id'] . "'";
        }

        if (!empty($options['emp_name'])) {
            $searchArray[] = " `table` LIKE '%" . $options['emp_name'] . "%'";
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

    public function getDocumentsInfo($id)
    {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('document_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
