<?php

class Mformbuilder extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }

    public function addColumnIfItDoesNotExist() {
        //this query checks for the new column
        $query = ("SHOW COLUMNS " .
                "FROM mis.formbuilder " .
                "LIKE '%" . $options . "%'");
        $result = mysqli_query($query)
                or die("select table tableNameToAddColumnTo " .
                        "in addColumnIfItDoesNotExist() not successful: " .
                        mysqli_error());
        $rarray = mysqli_fetch_array($result);
        if (null == $rarray[0]) {
            //  here are the specifics for your new column,
            //  both the datatype and the position in the table
            $query = ("ALTER TABLE tableNameToAddColumnTo " .
                    "ADD COLUMN newColumnName VARCHAR(100) " .
                    "AFTER columnBeforeNewColumn;");
            $result = mysqli_query($query)
                    or die("altering table tableNameToAddColumnTo not successful: " .
                            mysqli_error());
        }
        return;
    }

    public function formdatainsert($options) {
        unset($options['txtSubmit']);
        foreach ($options as $key => $value) {
            $query = ("SHOW COLUMNS " . "FROM formdata " . "LIKE '%" . $key . "%'");
            $result = $this->db->query($query) or die("select table formdata" . "in formdatainsert() not successful: " .
                            mysqli_error());

            $rarray = $result->result_array();

            if (null == @$rarray[0]) {
                $query = ("ALTER TABLE `formdata` ADD " . $key . " VARCHAR( 100 ) NOT NULL AFTER `id`");
                $result = $this->db->query($query) or die("altering table formdata not successful:" . mysqli_error());
            }
        }

        $data = $options;
        $result = $this->db->insert('formdata', $data);
        return $result;
    }

    public function approve($formid, $username) {
        $data = array('approved_by' => $username,
            'approve_status' => 1);
        $this->db->where('id', $formid);
        $result = $this->db->update('formbuilder', $data);
        return $result;
    }

    public function disapprove($formid, $username) {
        $data = array('cancelled_by' => $username,
            'approve_status' => 0);
        $this->db->where('id', $formid);
        $result = $this->db->update('formbuilder', $data);
        return $result;
    }

    public function getmodules() {
        $data = array();
        $query = "select distinct(name),mod_id from hs_hr_module";
        $result = $this->hris->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getformlist($module) {
        $query = "select mis.FB.*,hris.HM.name,hris.HM.sname from mis.formbuilder as FB JOIN hris.hs_hr_module as HM ON mis.FB.module = hris.HM.mod_id and mis.FB.submodule = hris.HM.smod_id where hris.HM.sname='" . $module . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $row['value'] = unserialize($row['value']);
            $row['input_type'] = unserialize($row['input_type']);
            $row['label'] = unserialize($row['label']);

            $data[] = $row;
        }
        return $data;
    }

    public function getform() {
        $query = "SELECT form_name,id from formbuilder";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getformdata($module = null) {
        $query = "select mis.FD.*,hris.HM.name,hris.HM.sname from mis.formdata as FD JOIN hris.hs_hr_module as HM ON mis.FD.module = hris.HM.name and mis.FD.smodule = hris.HM.sname where hris.HM.sname='" . $module . "'";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getformdatabyname($name) {
        $query = "select mis.FD.*,mis.FB.* from mis.formdata as FD JOIN formbuilder as FB ON(mis.FB.form_name = mis.FD.form_name) where mis.FB.id='" . $name . "'";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function isthere($module) {
        $query = "select mis.FB.*,hris.HM.name,hris.HM.sname from mis.formbuilder as FB JOIN hris.hs_hr_module as HM ON mis.FB.module = hris.HM.mod_id and mis.FB.submodule = hris.HM.smod_id where hris.HM.sname='" . $module . "'";
        $result = $this->db->query($query);
        return $result->num_rows();
    }

    public function getOrderCount($id = '', $type = '') {
        $data = array();
        $this->db->select("max(`order`) as total");
        if ($type == 'main') {
            $this->db->where('module', $id);
        }
        if ($type == 'sub') {
            $this->db->where('parent_value', '');
        }
        $query = $this->db->get('formbuilder');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    public function saveprocess($options = array()) {
        $data = array('approved_by' => $options['user_type']);
        $this->db->where('id', $options['form_name']);
        $result = $this->db->update('formbuilder', $data);
        return $result;
    }

    public function insert($options = array()) {
        $data = array(
            'form_name' => $options['form_name'],
            'label' => serialize(array_filter($options['label'])),
            'input_type' => serialize(array_filter($options['input_type'])),
            'value' => serialize(array_filter($options['value'])),
            'created_by' => $this->session->userdata('user_name'),
            'created_date' => date('d,m,y'));
        $result = $this->db->insert('formbuilder', $data);
        return $result;
    }

    public function insertModule($options = array()) {
        $data = array(
            'module' => $options['module'],
            'submodule' => array_pop($options['submodule']),
            'created_by' => $this->session->userdata('user_name'),
            'created_date' => date('d,m,y'));
        $this->db->where('id', $options['form_name']);
        $result = $this->db->update('formbuilder', $data);
        return $result;
    }

    public function update($options = array()) {

        $data = array(
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])));

        $this->db->where('id', $options['id']);

        $result = $this->db->update('formbuilder', $data);

        return $result;
    }

    public function insertAssess($options = array()) {

        $data = array('criteria' => $options['criteria'],
            'pid' => $options['pid'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])),
            'order' => $this->getOrderCount($options['pid'], 'sub') + 1);

        $result = $this->db->insert('formbuilder', $data);

        return $result;
    }

    public function updateAssess($options = array()) {

        $data = array('pid' => $options['pid'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])));

        $this->db->where('id', $options['id']);

        $result = $this->db->update('formbuilder', $data);

        return $result;
    }

    public function insertSub($options = array()) {

        $data = array('criteria' => $options['criteria'],
            'pid' => $options['pid'],
            'parent_value' => $options['parent_value'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])));

        $result = $this->db->insert('formbuilder', $data);

        return $result;
    }

    public function updateSub($options = array()) {

        $data = array('pid' => $options['pid'],
            'parent_value' => $options['parent_value'],
            'label' => $options['label'],
            'input_type' => $options['input_type'],
            'required' => $options['required'],
            'class' => $options['class'],
            'value' => serialize(array_filter($options['value'])));

        $this->db->where('id', $options['id']);

        $result = $this->db->update('formbuilder', $data);

        return $result;
    }

    /**

     * Function : delete method is used for delete records by changing status to -1.

     *

     * @param int $vendor_id

     *

     */
    public function delete($id) {

        $this->db->where('id', $id);

        $this->db->db_debug = false;

        $result = $this->db->delete('formbuilder');

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
    public function changeStatus($options = array()) {

        $data = array('status' => $options['status']);

        $this->db->where('id', $options['id']);

        $this->db->update('formbuilder', $data);

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
    public function getAllCount($options = array()) {

        $data = array();

        $whereQuery = $this->_search($options);

        $this->db->select("count(*) as total");

        if ($whereQuery != null) {
            $query = $this->db->get_where('formbuilder', $whereQuery);
        } else {
            $query = $this->db->get('formbuilder');
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
    public function getFormLimitRecords() {
        $this->db->select("*");
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('formbuilder');
        $values = $query->result_array();

        return $values;
    }

    public function getLimitRecords($options = array()) {

        $data = array();
        $result = "select mis.FB.*,hris.HM.name,hris.HM.sname from mis.formbuilder as FB JOIN hris.hs_hr_module as HM
                    ON mis.FB.module = hris.HM.mod_id and mis.FB.submodule = hris.HM.smod_id";
        $query = $this->db->query($result);
        foreach ($query->result_array() as $row) {
            $row['value'] = unserialize($row['value']);
            $row['input_type'] = unserialize($row['input_type']);
            $row['label'] = unserialize($row['label']);
            $data[] = $row;
        }
        $query->free_result();
        return $data;
    }

    public function getAssessmentList($id) {

        $data = array();

        $this->db->where('pid', $id);

        $this->db->order_by('order', 'asc');

        $query = $this->db->get('formbuilder');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $row['value'] = unserialize($row['value']);

                $data[] = $row;
            }
        }

        $query->free_result();

        return $data;
    }

    public function getSubfieldList($id) {

        $data = array();
        $this->db->where('parent_value !=', '');
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('formbuilder');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['value'] = unserialize($row['value']);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getsubmodule($module) {
        $data = array();
        $query = "select sname,smod_id from hs_hr_module where mod_id = '" . $module . "'";
        $result = $this->hris->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getFiledsList($criteria, $pid = '0', $subfield = null) {
        $data = array();
        $this->db->select('formbuilder.*');
        $this->db->select("(select count(id) from formbuilder SM where SM.pid=formbuilder.id and parent_value = '') as assess_field");
        $this->db->select("(select count(id) from formbuilder SM1 where SM1.pid=formbuilder.id and parent_value != '') as sub_field");
        $this->db->where_in('criteria', $criteria);
        $this->db->where('pid', $pid);
        if ($subfield == null and $pid != '0') {
            $this->db->where('parent_value', '');
        } elseif ($subfield != null) {
            $this->db->where('parent_value', $subfield);
        }

        $this->db->where('status', '1');
        $this->db->order_by('formbuilder.order', 'asc');
        $query = $this->db->get('formbuilder');
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

    public function makeOrder($criteria, $id, $order, $type) {

        $get_order = $this->db->query("select `order` from formbuilder where `id` = '" . $id . "'");

        $pre = array_pop($get_order->result_array());

        if ($order == 'Up') {

            $val = $pre['order'] - 1;
        } else {

            $val = $pre['order'] + 1;
        }

        if ($val > 0) {

            if ($type = 'main') {

                $q1 = "update formbuilder set `order` = '" . $pre['order'] . "' where `order` = '" . $val . "' and criteria = '" . $criteria . "' and pid = '0'";

                $this->db->query($q1);

                $q2 = "update formbuilder set `order` = '" . $val . "' where `id` = '" . $id . "' and criteria = '" . $criteria . "' and pid = '0'";

                $this->db->query($q2);
            }

            if ($type = 'sub') {

                $q1 = "update formbuilder set `order` = '" . $pre['order'] . "' where `order` = '" . $val . "' and pid = '" . $criteria . "'";

                $this->db->query($q1);

                $q2 = "update formbuilder set `order` = '" . $val . "' where `id` = '" . $id . "' and pid = '" . $criteria . "'";

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
    public function _search($options = array()) {

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
    public function getReportsInfo($id) {

        $data = array();

        $this->db->select("formbuilder.*");
        $this->db->where("id", $id);
        $query = $this->db->get('formbuilder');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row["value"] = unserialize($row["value"]);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getFormName() {

        $this->db->select("id,form_name");
        $query = $this->db->get("formbuilder");
        $data = $query->result_array();

        return $data;
    }

    public function getformListByName($formid) {
        $query = "SELECT FB.form_name,FB.input_type,FB.label,FB.value,PF.publish_type,PF.status
                                               FROM formbuilder as FB
                                               LEFT JOIN publish_form as PF
                                               ON (FB.form_name = PF.form_name) Where FB.id='" . $formid . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $row['value'] = unserialize($row['value']);
            $row['input_type'] = unserialize($row['input_type']);
            $row['label'] = unserialize($row['label']);

            $data[] = $row;
        }

        return $data;
    }

    public function makepublishBYForm($postData = array()) {

        $data = array(
            'form_name' => $postData['formname'],
            'url_path' => $postData['urlpath'],
            'publish_type' => $postData['publishstate'],
            'status' => '1',
            'created_date' => date("Y-m-d"),
        );
        $this->db->insert("publish_form", $data);
    }

    public function getPublishedForm() {

        $buildqry = "SELECT PF.form_name,PF.url_path,PF.publish_type,FB.id
                                               FROM publish_form as PF
                                               LEFT JOIN formbuilder as FB
                                               ON (PF.form_name = FB.form_name)";

        $value = $this->db->query($buildqry);
        $values = $value->result_array();

        return $values;
    }

    public function changePublishgStatus($id, $formname, $status) {

        $path = site_url() . "/formpublish/" . $formname;
        $data = array(
            'publish_url' => $path,
            'publish_status' => $status,
        );
        $this->db->where('id', $id);
        $result = $this->db->update('formbuilder', $data);

        return $result;
    }

    public function getPublishStatus($formName) {

        $buildqry = "SELECT publish_status from formbuilder where form_name='" . $formName . "'";

        $value = $this->db->query($buildqry);
        $values = $value->result_array();
        $value = @$values['0'];
        return $value;
    }

    public function getPublishedFormList() {

        $buildqry = "SELECT * from publish_form";
        $value = $this->db->query($buildqry);
        $values = $value->result_array();

        return $values;
    }

    public function getFormDetailsBYFormName($formName = "") {
        $buildqry = "SELECT * from formdata where form_name= '" . $formName . "' ";
        $value = $this->db->query($buildqry);
        $values = $value->result_array();

        return $values;
    }

}
