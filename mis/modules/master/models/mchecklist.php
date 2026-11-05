<?php
#
# Model Class -  hs_quad_master_settings
#

class Mchecklist extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($options = array())
    {
        $data = array('area' => $options['area'],
            'document_description' => $options['document_description']);
        $result = $this->db->insert('checklist_master', $data);
        return $result;
    }
    public function update($options = array())
    {
        $data = array('area' => $options['area'],
            'document_description' => $options['document_description']);
        $this->db->where('id', $options['id']);
        $result = $this->db->update('checklist_master', $data);
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
        $result = $this->db->delete('checklist_master');
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
        $this->db->update('checklist_master', $data);
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
            $query = $this->db->get_where('checklist_master', $whereQuery);
        } else {
            $query = $this->db->get('checklist_master');
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
        $query = "SELECT CM.*,MS.master_name as master_name from checklist_master as CM JOIN master_settings as MS ON(MS.id = CM.area)";
        if (@$options['area'] != "") {
            $query .= "where area = '" . $options['area'] . "'";

        }
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
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
        if (!empty($options['document_description'])) {
            $searchArray[] = "document_description like '%" . $options['document_description'] . "%'";
        }

        if (!empty($options['program_type'])) {
            $searchArray[] = "area = '" . $options['area'] . "'";
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

    public function getChecklistInfo($id)
    {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('checklist_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getCheckList()
    {
        $data = array();
        $this->db->select("checklist_master.*,(select master_name from master_settings where id=checklist_master.area) as master_name");
        $this->db->order_by('area', 'asc');
        $this->db->where('status', '1');
        $query = $this->db->get('checklist_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
