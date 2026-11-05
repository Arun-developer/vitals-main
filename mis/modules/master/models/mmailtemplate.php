<?php

#
# Model Class -  hs_quad_master_settings
#

class Mmailtemplate extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', true);
        $this->hris = $this->load->database('hris', true);
    }

    public function insert($options = array()) {
        $data = array('messagetype' => $options['messagetype'],
            'messagesubject' => $options['messagesubject'],
            'messagebody' => $options['messagebody']);
        $result = $this->db->insert('master_mailtemplate', $data);
        return $result;
    }

    public function update($options = array()) {
        $partner_id = $this->session->userdata['partner_id'];
        $data = array('messagetype' => $options['messagetype'],
            'messagesubject' => $options['messagesubject'],
            'messagebody' => $options['messagebody']);
        $this->db->where('id', $options['id']);
        $this->db->where('partner_id', $partner_id);
        $result = $this->db->update('master_mailtemplate', $data);
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
        $this->db->delete('master_mailtemplate');
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
    public function changeStatus($options = array()) {
        $data = array('status' => $options['status']);
        $this->db->where('id', $options['id']);
        $this->db->update('master_mailtemplate', $data);
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
    public function getAllCounts($where = null, $table = null) {
        $data = array();
        $this->ais->select("count(*) as total");
        if ($where != null) {
            $query = $this->ais->get_where($table, $where);
        } else {
            $query = $this->ais->get($table);
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data['0']['total'];
    }

    public function getAllCount($options = array()) {

        $data = array();
        $this->db->select("count(*) as total");
        $this->db->where("partner_id", $options['partner_id']);
        $query = $this->db->get('master_mailtemplate');

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
    public function getLimitRecord($options = array()) {
        $data = array();
        $this->db->where("partner_id", $options['partner_id']);
        $this->db->limit($options['num'], $options['offset']);
        $query = $this->db->get('master_mailtemplate');
        #echo debug_last_query();die;
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
    public function _search($options = array()) {
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

    /**
     * Function : getVendorInfo method is used for get vendor details .
     *
     * @param int $vendor_id
     *
     */
    public function getTemplateInfo($id) {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('master_mailtemplate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getMailTemplate($mailTemplate, $partner_id) {
        $data = array();
        $this->db->select("messagesubject as subject,messagebody as body");
        $this->db->where('messagetype', $mailTemplate);
        $this->db->where('status', '1');
        $this->db->where('partner_id', $partner_id);
        $query = $this->db->get('master_mailtemplate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getMailType($id = '', $type = '') {
        $data = array();
        if ($id != '') {
            $this->db->where("id", $id);
        }
        if ($type != '') {
            $this->db->where("messagetype LIKE '%" . $type . "%'");
        }
        $partner_id = $this->session->userdata['partner_id'];
        $this->db->select("id,messagetype");
        $this->db->where(array('partner_id' => $partner_id, 'status' => '1'));
        $this->db->order_by("messagetype ASC");
        $query = $this->db->get('master_mailtemplate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function insertTemplate() {
        $data = array('messagetype' => $this->input->post('messagetype'),
            'messagesubject' => $this->input->post('messagesubject'),
            'messagebody' => $this->input->post('messagebody'));
        $result = $this->ais->insert('mailtemplate', $data);
        return $result;
    }

    public function updateTemplate() {
        $data = array(
            'messagesubject' => $this->input->post('messagesubject'),
            'messagebody' => $this->input->post('messagebody'));
        $this->ais->where('id', $this->input->post('id'));
        $result = $this->ais->update('mailtemplate', $data);
        return $result;
    }

    public function getLimitRecords($val = null) {
        $data = array();
        if ($val['export'] == 'no') {
            $this->ais->limit($val['num'], $val['offset']);
        }

        if ($val['orderby'] != '' && $val['ordertype'] != '') {
            $this->ais->order_by($val['orderby'], $val['ordertype']);
        }

        if ($val['where'] != '') {
            $query = $this->ais->get_where($val['table'], $val['where']);
        } else {
            $query = $this->ais->get($val['table']);
        }
        echo debug_last_query();
        die;

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        #echo'<pre>';print_r($val);die;
        $query->free_result();

        return $data;
    }

    public function getRecords($TableName = null, $Label = null, $Id = null) {
        $data = array();
        if ($Id != null && $Label != null) {
            $this->ais->where($Label, $Id);
        }

        $query = $this->ais->get($TableName);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function changeState($TableName = null, $label = null, $Id = null, $Status = null) {
        $data = array('status' => $Status);
        $this->ais->where($label, $Id);
        $data = $this->ais->update($TableName, $data);
        return $data;
    }

    public function gethrrecords_old() {
        $data = array();
        $dbquery = "SELECT * FROM hrisvill_orangehrm.mailsetting";
        $query = $this->db->query($dbquery);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function gethrrecords() {
        $data = array();
        $dbquery = "SELECT * FROM mailsetting";
        $query = $this->hris->query($dbquery);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function gethrTemplateInfo($id) {
        $data = array();
        $dbquery = "SELECT * FROM hrisvill_orangehrm.mailsetting";
        $query = $this->db->query($dbquery);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function gethrTemplateInfo_old($id) {
        $data = array();
        $dbquery = "SELECT * FROM mailsetting";
        $query = $this->hris->query($dbquery);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function hrupdate_old($options = array()) {
        $query = "UPDATE hrisvill_orangehrm.mailsetting SET message = '" . $message . "' where id = '" . $id . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data = $row;
        }
        return $data;
    }

    public function hrupdate($options = array()) {
        $query = "UPDATE mailsetting SET message = '" . $message . "' where id = '" . $id . "'";
        $result = $this->hris->query($query);
        foreach ($result->result_array() as $row) {
            $data = $row;
        }
        return $data;
    }

}
