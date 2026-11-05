<?php
/**
 *
 * Incubation Progress Master Model Page
 *
 * @Model Name         mprogress_master.php
 * @Author             Sanjoy Dey
 * @Created Date       11-11-2011
 * @Modified Date      18-11-2011
 * @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011
 * @Modified Portion
 * @Modified By        Sanjoy Dey
 * @version            CodeIgniter_2.0.3
 * @link               http://www.codeigniter.com
 * @since              File available since Release 2.0.3
 * @Warning            Any change in this file may cause abnormal behaviour of application.
 *
 */

class Mprogress_master extends CI_Model
{

    //Conctructor Function
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
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
        $query = $this->db->get('progress_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data['0']['total'];
    }

    public function getfields()
    {
        $query = "SELECT * from progress_master ORDER BY mastertype";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getactivityRecords($innovation)
    {

        $data = array();
        $this->db->select('id');
        $this->db->select('label');
        $this->db->select('criteria');
        $this->db->select('mastertype');
        $this->db->select('innovation');
        $this->db->select('period');
        $this->db->select('assigned_to');
        $this->db->where('type', 'activity');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('progress_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getfellowList()
    {
        $data = array();
        $this->hris->select('emp_number');
        $this->hris->select('emp_firstname');
        $emptype = array('fellow', 'consultant');
        $this->hris->where_in('emp_type', $emptype);
        $query = $this->hris->get('hs_hr_employee');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }

    public function getIncubateeList()
    {

        $this->db->select("id,name_of_enterprise");
        $this->db->where('stage', '5');
        $query = $this->db->get('innovation_pool');
		#echo debug_last_query();die;
        $data = $query->result_array();
        return $data;
    }

    public function getcriteria()
    {
        $this->db->select('id,master_name');
        $this->db->where('iris_tab', 'standard');
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    //getcriteriaList is used to save period values in array
    public function getcriteriaList()
    {

        $list = array(
            "1" => 'Weekly Report',
            "2" => 'Monthly Report',
            "3" => 'Quarterly Report',
            "4" => 'Yearly Report',
        );
        return $list;

    }
    //get master type from the master_Settings table
    public function getmastertype()
    {
        $data = array();
        $this->db->select('master_type');
        $this->db->distinct('master_type');
        $this->db->where('iris_tab', 'standard');
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        return $data;

    }
    //getMasterSettings is used to get Master details from db
    public function getMasterSettings($id)
    {

        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('master_settings');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }
    //getmaster name from master_Settings table by using master_type
    public function getmastername($mastertype)
    {
        $data = array();
        $this->db->select('id,master_name');
        if ($mastertype != "") {
            $this->db->where_in('master_type', $mastertype);
        }

        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    //getMasterSetting is used for getting master details from db
    public function getMasterSetting($masterType = null)
    {
        $data = array();
        $this->db->where('status', '1');
        $this->db->where('master_type', $masterType);
        $this->db->select('id,master_name');
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;

    }

    public function insert_activity($options = array())
    {
        $innovation = $options['innovation']['0'];

        foreach ($options['id'] as $key => $value) {
            if ($options['id'][$key] == '') {
                $data = array('criteria' => $options['subcriteria'][$key],
                    'type' => 'activity',
                    'period' => $options['period'][$key],
                    'listing_type' => 'particular',
                    'innovation' => $innovation,
                    'assigned_to' => $options['assigned'][$key],
                    'mastertype' => $options['mastertype'][$key],
                    'label' => $options['label'][$key]);
                $result = $this->db->insert('progress_master', $data);
                $id = $this->db->insert_id();

                $query = "UPDATE checklist_incubation SET checklist = CONCAT(checklist,',$id') WHERE innovation = '$innovation'";
                $value = $this->db->query($query);
            } else {
                $data = array('criteria' => $options['subcriteria'][$key],
                    'type' => 'activity',
                    'period' => $options['period'][$key],
                    'listing_type' => 'particular',
                    'innovation' => $innovation,
                    'assigned_to' => $options['assigned'][$key],
                    'mastertype' => $options['mastertype'][$key],
                    'label' => $options['label'][$key]);
                $this->db->where('id', $options['id'][$key]);
                $id = $options['id'][$key];
                $query = "UPDATE checklist_incubation SET checklist = CONCAT(checklist,',$id') WHERE innovation ='$innovation' and position(',$id,' IN CONCAT(CONCAT(',',checklist),',')) = 0";
                $value = $this->db->query($query);
            }
        }
    }

    //insert function is used for adding data in db
    public function insert($options = array())
    {
        $data = array('mastertype' => $options['mastertype'],
            'criteria' => $options['criteria'],
            'period' => $options['period'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'info' => $options['info'],
            'required' => $options['required'],
            'class' => $options['class'],
            'subcategory' => $options['subcategory'],
            'type' => 'metrices',
            'value' => serialize(php72_array_filter($options['value'])),
            'order' => $this->getOrderCount($options['criteria'], 'main') + 1);
		#echo'<pre>';print_r($data);die;
        $result = $this->db->insert('progress_master', $data);
        return $result;
    }

    //getRecords function is used to get records details from database based on id
    public function getRecords($id)
    {

        $data = array();
        $this->db->select("PM.*,(SELECT master_name FROM master_settings MS where MS.id = PM.criteria) as criteria_title");
        $this->db->where('id', $id);
        $query = $this->db->get('progress_master PM');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row["value"] = unserialize($row["value"]);
                $data[] = $row;
            }
        }

        return $data;
    }

    //Update function is used for updating data in db
    public function update($options = array())
    {
        $data = array(
            'criteria' => $options['criteria'],
            'mastertype' => $options['mastertype'],
            'period' => $options['period'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'info' => $options['info'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(php72_array_filter($options['value'])));
        $this->db->where('id', $options['id']);
        $result = $this->db->update('progress_master', $data);
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
            'value' => serialize(php72_array_filter($options['value'])),
            'order' => $this->getOrderCount($options['pid'], 'sub') + 1);
        $result = $this->db->insert('progress_master', $data);
        return $result;
    }

    public function updateAssess($options = array())
    {
        $data = array('pid' => $options['pid'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(php72_array_filter($options['value'])));
        $this->db->where('id', $options['id']);
        $result = $this->db->update('progress_master', $data);
        return $result;
    }

    public function insertSub($options = array())
    {
        $data = array(
            'criteria' => $options['criteria'],
            'pid' => $options['pid'],
            'parent_value' => $options['parent_value'],
            'mastertype' => $options['mastertype'],
            'period' => $options['period'],
            'type' => $options['type'],
            'innovation' => $options['innovation'],
            'subcategory' => $options['subcategory'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(php72_array_filter($options['value'])));
			#echo'<pre>';print_r($data);die;
        $result = $this->db->insert('progress_master', $data);

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
            'value' => serialize(php72_array_filter($options['value'])));
			
        $this->db->where('id', $options['id']);
        $result = $this->db->update('progress_master', $data);
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
        $result = $this->db->delete('progress_master');
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
        $this->db->update('progress_master', $data);
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

        $this->db->where('type', 'metrices');
        $this->db->where('pid', '0');

        if ($whereQuery != null) {
            $query = $this->db->get_where('progress_master', $whereQuery);
        } else {
            $query = $this->db->get('progress_master');
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
		
        $this->db->select("progress_master.*");
        $this->db->select("(select master_name from master_settings where id=progress_master.criteria) as criteria_title");

        $this->db->where('pid', '0');
        $this->db->where('type', 'metrices');
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        $this->db->order_by('criteria', 'asc');
        $this->db->order_by('order', 'asc');
        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('progress_master', $whereQuery);
        } else {
            $query = $this->db->get('progress_master');
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

    public function getSubfieldList($id)
    {
        $data = array();
        $this->db->where('pid', $id);
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('progress_master');
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

    /* Start of Ajax field Details  */
    public function getajxFiledsList($ajxValue, $criteria, $pid = '0', $subfield = null)
    {
        $data = array();
        $this->db->select('progress_master.*');
        $this->db->select("(select count(id) from progress_master SM where SM.pid=progress_master.id and parent_value = '') as assess_field");
        $this->db->select("(select count(id) from progress_master SM1 where SM1.pid=progress_master.id and parent_value != '') as sub_field");
        $this->db->where('criteria', $criteria);
        $this->db->where('pid', $pid);
        $this->db->where('period', $ajxValue);
        if ($subfield == null and $pid != '0') {
            $this->db->where('parent_value', '');
        } elseif ($subfield != null) {
            $this->db->where('parent_value', $subfield);
        }

        $this->db->where('status', '1');
        $this->db->order_by('progress_master.order', 'asc');
        $query = $this->db->get('progress_master');
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

    /* end of Ajax feild Details  */

    //getFiledsList method is used to get All fieldlist from database
    public function getFiledsList($criteria, $pid = '0', $subfield = null, $period = null)
    {
        $data = array();
        $this->db->select('progress_master.*');
        $this->db->select("(select count(id) from progress_master SM where SM.pid=progress_master.id and parent_value = '') as assess_field");
        $this->db->select("(select count(id) from progress_master SM1 where SM1.pid=progress_master.id and parent_value != '') as sub_field");
        $this->db->where('criteria', $criteria);
        $this->db->where('pid', $pid);

        if ($subfield == null and $pid != '0') {
            $this->db->where('parent_value', '');
        }

        if ($period) {
            $this->db->where('period', $period);
        } elseif ($subfield != null) {
            $this->db->where('parent_value', $subfield);
        }

        $this->db->where('status', '1');
        $this->db->order_by('progress_master.order', 'asc');

        $query = $this->db->get('progress_master');

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
        $get_order = $this->db->query("select `order` from progress_master where `id` = '" . $id . "'");
        $pre = array_pop($get_order->result_array());
        if ($order == 'Up') {
            $val = $pre['order'] - 1;
        } else {
            $val = $pre['order'] + 1;
        }
        if ($val > 0) {
            if ($type = 'main') {
                $q1 = "update progress_master set `order` = '" . $pre['order'] . "' where `order` = '" . $val . "' and criteria = '" . $criteria . "' and pid = '0'";
                $this->db->query($q1);
                $q2 = "update progress_master set `order` = '" . $val . "' where `id` = '" . $id . "' and criteria = '" . $criteria . "' and pid = '0'";
                $this->db->query($q2);
            }
            if ($type = 'sub') {
                $q1 = "update progress_master set `order` = '" . $pre['order'] . "' where `order` = '" . $val . "' and pid = '" . $criteria . "'";
                $this->db->query($q1);
                $q2 = "update progress_master set `order` = '" . $val . "' where `id` = '" . $id . "' and pid = '" . $criteria . "'";
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

    public function getProgressInfo($id)
    {
        $data = array();
        $this->db->select("progress_master.*");
        $this->db->select("(select master_name from master_settings where id=progress_master.criteria) as criteria_title");
        $this->db->where("id", $id);
        $query = $this->db->get('progress_master');
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
