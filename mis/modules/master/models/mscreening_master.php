<?php
#
# Model Class -  hs_quad_master_settings
#

class Mscreening_master extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getOrderCount($id = '', $type = '')
    {
        $data = array();
        $this->db->select("max(`order`) as total");

        if ($type == 'main') {
            $this->db->where('criteria', $id);
            $this->db->where('pid', '0');
        }
        if ($type == 'sub') {
            $this->db->where('parent_value', '');
            $this->db->where('pid', $id);
        }
        $query = $this->db->get('screening_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    public function insert($options = array())
    {
        $data = array('criteria' => $options['criteria'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])),
            'order' => $this->getOrderCount($options['criteria'], 'main') + 1);
			#echo'<pre>';print_r($data);die;
        $result = $this->db->insert('screening_master', $data);
        return $result;
    }
    public function update($options = array())
    {
        $data = array('criteria' => $options['criteria'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])));
			#echo'<pre>';print_r($data);die;
        $this->db->where('id', $options['id']);
        $result = $this->db->update('screening_master', $data);
        return $result;
    }
    public function insertAssess($options = array())
    {
        $data = array('criteria' => $options['criteria'],
            'pid' => $options['pid'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])),
            'order' => $this->getOrderCount($options['pid'], 'sub') + 1);
			#echo'<pre>';print_r($data);die;
        $result = $this->db->insert('screening_master', $data);
        return $result;
    }
    public function updateAssess($options = array())
    {
        $data = array('pid' => $options['pid'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])));
        $this->db->where('id', $options['id']);
		#echo'<pre>';print_r($data);die;
        $result = $this->db->update('screening_master', $data);
        return $result;
    }
    public function insertSub($options = array())
    {
        $data = array('criteria' => $options['criteria'],
            'pid' => $options['pid'],
            'parent_value' => $options['parent_value'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])));
			#echo'<pre>';print_r($data);die;
        $result = $this->db->insert('screening_master', $data);
        return $result;
    }
    public function updateSub($options = array())
    {
        $data = array('pid' => $options['pid'],
            'parent_value' => $options['parent_value'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])));
			#echo'<pre>';print_r($data);die;
        $this->db->where('id', $options['id']);
        $result = $this->db->update('screening_master', $data);
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
        $result = $this->db->delete('screening_master');
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
        $this->db->update('screening_master', $data);
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
            $query = $this->db->get_where('screening_master', $whereQuery);
        } else {
            $query = $this->db->get('screening_master');
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
        $this->db->select("screening_master.*");
        $this->db->select("(select master_name from master_settings where id=screening_master.criteria) as criteria_title");

        $this->db->where('pid', '0');

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        $this->db->order_by('criteria', 'asc');
        $this->db->order_by('order', 'asc');
        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('screening_master', $whereQuery);
        } else {
            $query = $this->db->get('screening_master');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['value'] = unserialize($row['value']);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getAssessmentList($id)
    {
        $data = array();
        $this->db->where('pid', $id);
		#$this->db->where('parent_value', NULL);
        $this->db->where('parent_value', '');
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('screening_master');
		#echo debug_last_query();die;

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['value'] = unserialize($row['value']);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getSubfieldList($id)
    {
        $data = array();
        $this->db->where('pid', $id);
        $this->db->where('parent_value !=', '');
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('screening_master');
		#echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['value'] = unserialize($row['value']);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getFiledsList($criteria, $pid = '0', $subfield = null)
    {
        $data = array();
        $this->db->select('screening_master.*');
        $this->db->select("(select count(id) from screening_master SM where SM.pid=screening_master.id and parent_value = '') as assess_field");
        $this->db->select("(select count(id) from screening_master SM1 where SM1.pid=screening_master.id and parent_value != '') as sub_field");
        $this->db->where('criteria', $criteria);
        $this->db->where('pid', $pid);
        if ($subfield == null and $pid != '0') {
            $this->db->where('parent_value', '');
        } elseif ($subfield != null) {
            $this->db->where('parent_value', $subfield);
        }

        $this->db->where('status', '1');
        $this->db->order_by('screening_master.order', 'asc');
        $query = $this->db->get('screening_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['value'] = unserialize($row['value']);
                $row['answer'] = '';
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function makeOrder($criteria, $id, $order, $type)
    {
        $get_order = $this->db->query("select `order` from screening_master where `id` = '" . $id . "'");
        $pre = array_pop($get_order->result_array());
        if ($order == 'Up') {
            $val = $pre['order'] - 1;
        } else {
            $val = $pre['order'] + 1;
        }
        if ($val > 0) {
            if ($type = 'main') {
                $q1 = "update screening_master set `order` = '" . $pre['order'] . "' where `order` = '" . $val . "' and criteria = '" . $criteria . "' and pid = '0'";
                $this->db->query($q1);
                $q2 = "update screening_master set `order` = '" . $val . "' where `id` = '" . $id . "' and criteria = '" . $criteria . "' and pid = '0'";
                $this->db->query($q2);
            }
            if ($type = 'sub') {
                $q1 = "update screening_master set `order` = '" . $pre['order'] . "' where `order` = '" . $val . "' and pid = '" . $criteria . "'";
                $this->db->query($q1);
                $q2 = "update screening_master set `order` = '" . $val . "' where `id` = '" . $id . "' and pid = '" . $criteria . "'";
                $this->db->query($q2);
            }
        }
        return true;
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
        if (!empty($options['criteria'])) {
            $searchArray[] = "criteria = '" . $options['criteria'] . "'";
        }

        if (!empty($options['label'])) {
            $searchArray[] = "label = '" . $options['label'] . "'";
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

    public function getReportsInfo($id)
    {
        $data = array();
        $this->db->select("screening_master.*");
        $this->db->select("(select master_name from master_settings where id=screening_master.criteria) as criteria_title");
        $this->db->where("id", $id);
        $query = $this->db->get('screening_master');
		#echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row["value"] = unserialize($row["value"]);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
