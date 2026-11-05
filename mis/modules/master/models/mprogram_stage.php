<?php
#
# Model Class -  hs_quad_master_settings
#

class Mprogram_stage extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($options = array())
    {
        $data = array('program_service_offering' => $options['program_service_offering'],
            'title' => $options['title'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $result = $this->db->insert('program_stage', $data);
        return $result;
    }
    public function update($options = array())
    {
        $data = array('program_service_offering' => $options['program_service_offering'],
            'title' => $options['title'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'));
        $this->db->where('id', $options['id']);
        $result = $this->db->update('program_stage', $data);
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
        $this->db->delete('program_stage');
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
        $this->db->update('program_stage', $data);
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
            $query = $this->db->get_where('program_stage PS', $whereQuery);
        } else {
            $query = $this->db->get('program_stage PS');
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

        $this->db->select("PS.*,PSO.title as program_service_title,MS.master_name as master_name");
        $this->db->join('program_service_offering PSO', 'PSO.id=PS.program_service_offering', 'left');
        $this->db->join('master_settings MS', 'MS.id = PSO.program_type', 'left');

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('program_stage PS', $whereQuery);
        } else {
            $query = $this->db->get('program_stage PS');
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
        if (!empty($options['message_type'])) {
            $searchArray[] = "messagetype like '%" . $options['message_type'] . "%'";
        }

        if (!empty($options['status'])) {
            $searchArray[] = "status = '" . $options['status'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function getProgramStageInfo($id)
    {
        $data = array();
        $this->db->where("PS.id", $id);
        $this->db->select("PS.*,PSO.program_type,PSO.title as program_service_title,MS.master_name as master_name");
        $this->db->join('program_service_offering PSO', 'PSO.id=PS.program_service_offering', 'left');
        $this->db->join('master_settings MS', 'MS.id = PSO.program_type', 'left');
        $query = $this->db->get('program_stage PS');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    //listing for combo bu program type
    public function getProgramStageCombo($program_service)
    {
        $data = array();
        $this->db->select("id,title");
        $this->db->where("program_service_offering", $program_service);
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('program_stage');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getCurrentStage($stage)
    {

        $data = array();
        $this->db->select('program_stage');
        $this->db->where('stage', $stage);
        $query = $this->db->get('stage_map');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data[0]['program_stage'];
        }
        $query->free_result();
    }

}
