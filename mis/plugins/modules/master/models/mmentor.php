<?php

class Mmentor extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function insert($options = array())
    {
        $data = array('sector' => $options['sector'],
            'experience' => $options['experience'],
            'skills' => $options['skills'],
            'first_name' => $options['first_name'],
            'address' => $options['address'],
            'city' => $options['city'],
            'telephone' => $options['telephone'],
            'mobile' => $options['mobile'],
            'detail' => $options['history'],
            'email' => $options['email'],
            'photograph' => $options['photograph'],
            'resume' => $options['resume'],
        );
        $result = $this->db->insert('mentor', $data);

        return $result;
    }
    public function update($options = array())
    {

        $data1 = array('sector' => $options['sector'],
            'experience' => $options['experience'],
            'skills' => $options['skills'],
            'first_name' => $options['first_name'],
            'address' => $options['address'],
            'city' => $options['city'],
            'telephone' => $options['telephone'],
            'mobile' => $options['mobile'],
            'email' => $options['email'],
            'detail' => $options['history'],
            'photograph' => $options['photograph'],
            'resume' => $options['resume'],
        );
        $this->db->where('id', $this->input->post('id'));

        $result = $this->db->update('mentor', $data1);
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
        $data = array('status' => '-1');
        $this->db->where('id', $id);
        $this->db->delete('mentor', $data);
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
        $this->db->update('mentor', $data);
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
        $this->db->where("status !=", "-1");

        if ($whereQuery != null) {
            $query = $this->db->get_where('quad_master_vendor', $whereQuery);
        } else {
            $query = $this->db->get('quad_master_vendor');
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

        if (!empty($options['source'])) {
            $this->db->where('source_id', $options['source']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('instance_master', $whereQuery);
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

    /**
     * Function : getVendorInfo method is used for get vendor details .
     *
     * @param int $vendor_id
     *
     */

    public function getapplicantInfo($id)
    {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('mentor');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getVendorsList()
    {
        $data = array();
        $this->db->where('status', '1');
        $query = $this->db->get('quad_master_vendor');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
