<?php

class Minvester extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }

    public function getInnvationStage()
    {
        return array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation');
    }

    public function statusArr()
    {
        return array(0 => 'Pending', 1 => 'Accepted', 2 => 'Rejected');
    }

    public function getLimitRecords($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('instance_master', $whereQuery);
        } else
        if ($options['innovationid'] != '') {
            $this->db->where('innovation', $options['innovationid']);
        }
        $query = $this->db->get('request_invester');
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

    public function getinvesterDetails($id = null)
    {
        $data = array();
        $this->db->where('id', $id);
        $this->db->select("*");
        $query = $this->db->get('request_invester');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();

        return $data;
    }

    public function investerDetail($id)
    {
        $investdata = $this->getassignInvester($id);
        print_r($investdata);
        exit;

    }

    public function getassignInvester($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('assign_invester');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }

    public function insert($options = array())
    {

        $requestNo = $this->requestNumber();
        $data = array(
            'request_investernumber' => $requestNo,
            'innovation' => $options['innovationid'],
            'sector' => $options['sector'],
            'amount' => $options['amount'],
            'description' => $options['description'],
        );
        $result = $this->db->insert('request_invester', $data);
        return $result;
    }

    public function requestNumber()
    {
        $data = array();
        $text = "REQ/";
        $position = "front";
        $this->db->order_by('id', 'desc');
        $this->db->limit('1', '0');
        $query = $this->db->get('request_invester');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        if (count($data)) {
            $id = str_pad((int) $data['0']['id'] + 1, 4, "0", STR_PAD_LEFT);
        } else {
            $id = '0001';
        }

        return $requestNo = $text . $id;
    }

    public function update($options = array())
    {
        $dataup = array(
            'innovation' => $options['innovationid'],
            'sector' => $options['sector'],
            'amount' => $options['amount'],
            'description' => $options['description']);
        $this->db->where('id', $this->input->post('id'));

        $result = $this->db->update('request_invester', $dataup);
        return $result;
    }

    public function assignChecklist($options = array())
    {
        $data = array('innovation' => $options['innovationid'],
            'checklist' => php72_implode(',', $options['document']));

        if ($this->checkDuplicateChecklist($options['innovationid'])) {
            $this->db->insert('invester_document', $data);
        } else {
            $this->db->where('innovation', $options['innovationid']);
            $this->db->update('invester_document', $data);
        }

        return true;
    }

    public function checkDuplicateChecklist($innovationid)
    {
        $this->db->where('innovation', $innovationid);
        $result = $this->db->get('invester_document');
        if ($result->num_rows() > 0) {
            return false;
        }

        return true;
    }

    public function getMasterSettingsbyinnovation($innovationid = null)
    {

        $data = array();
        $this->db->where("innovation", $innovationid);
        $query = $this->db->get('invester_document');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }

    public function matchDocumentMaster($masterType = null, $innovationid = null)
    {
        $firstdata = $this->getMasterSettingsbyinnovation($innovationid);

        if (!empty($firstdata)) {

            $chklist = $firstdata[0]['checklist'];

            $chklist = '(' . $chklist . ')';
            $data = array();
            $this->db->select("MS.*");
            $this->db->where('MS.master_type', $masterType);
            $wherenew = "MS.id in";
            $this->db->where($wherenew, $chklist, false);
            $query = $this->db->get('master_settings MS');

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
            }

            $query->free_result();
            return $data;
        }
    }

    public function searchinvester($options = array())
    {

        $data = array();

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('invester', $whereQuery);
        } else {
            $query = $this->db->get('invester');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertSuggestInvester($innovationid = null, $id, $suggest = array())
    {
        if (is_array($suggest)) {

            foreach ($suggest as $key => $value1):

                $data = array(
                    'innovation' => $innovationid,
                    'invester_id' => $suggest[$key],
                    'request_id' => $id,
                    'invester_comments' => "",
                    'invester_status' => '0',
                    'incubatee_publish' => "",
                    'incubatee_comment' => "",
                    'incubatee_status' => '0',
                    'villgro_status' => '0',
                );

                $result2 = $this->db->insert('assign_invester', $data);

            endforeach;

        }

        return true;

    }

    public function assignedinvester($innovationid = null, $id = null)
    {

        $data = array();
        $this->db->select("I.*,AI.*");
        $this->db->join('invester I', 'I.id = AI.invester_id', 'left');
        $this->db->where('AI.innovation', $innovationid);
        if ($id != '') {
            $this->db->where('AI.request_id', $id);
        }
        $query = $this->db->get('assign_invester AI');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;

    }

    public function assigninvesterDetail($innovationid, $investerid)
    {
        $data = array();
        $this->db->select("I.*,AI.*");
        $this->db->join('invester I', 'I.id = AI.invester_id', 'left');
        $this->db->where('AI.innovation', $innovationid);
        $this->db->where("invester_id", $investerid);
        $query = $this->db->get('assign_invester AI');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }

    public function masterinvesterDetail($investerid)
    {
        $data = array();
        $this->db->where('id', $investerid);
        $query = $this->db->get('invester');
        $value = $query->result_array();
        $query->free_result();
        return $value;

    }

    public function updatevillgrostatus($options = array())
    {
        $dataup = array(
            'villgro_status' => $options['villgrostatus'],
            'invester_comments' => $options['comments'],

        );
        $this->db->where('id', $options['requestid']);

        $result = $this->db->update('assign_invester', $dataup);
        return $result;
    }

    public function updateincubateestatus($options = array())
    {

        $dataup = array('incubatee_status' => $options['incubateestatus']);
        $this->db->where('id', $this->input->post('requestid'));

        $result = $this->db->update('assign_invester', $dataup);

        return $result;
    }

    public function updateinvesterstatus($options = array())
    {

        $dataup = array('invester_status' => $options['investerstatus']);
        $this->db->where('id', $this->input->post('requestid'));
        $result = $this->db->update('assign_invester', $dataup);

        return $result;
    }

    public function updateliststatus($options = array())
    {
        $dataup = array('status' => $options['status'],
            'comments' => $options['comments']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_invester', $dataup);
        return $result;
    }

    public function investeractionHistory($options = array())
    {
        $currentdate = date('Y-m-d');
        $data = array(
            'invester_id' => $options['investerid'],
            'action' => $options['villgrostatus'],
            'comments' => $options['comments'],
            'actiondate' => $currentdate,
            'actionby' => "",
        );
        $result = $this->db->insert('investeraction_history', $data);
        return $result;
    }
    public function getactionHistory($investerid)
    {
        $data = array();
        $this->db->select("I.first_name as name,IH.*");
        $this->db->join('invester I', 'I.id = IH.invester_id', 'left');

        $this->db->where("invester_id", $investerid);
        $query = $this->db->get('investeraction_history IH');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function updateAll($options = array(), $innovationid, $requestid)
    {
        foreach ($options['id'] as $key => $activity) {
            $data = array(
                'invester_status' => $options['invester_status'],
                'amount_approved' => $options['amountapproved'][$key],
            );
            $this->db->where('id', $options['id'][$key]);
            $this->db->where('innovation', $innovationid);
            $this->db->where('request_id', $requestid);
            $result = $this->db->update('assign_invester', $data);
        }

        return $result;
    }

    public function getProgramstageandProgramservice($title)
    {
        $data = array();
        $this->db->select("PS.id,PS.program_service_offering");
        $this->db->join('program_service_offering PSO', 'PSO.id =PS.program_service_offering', 'left');
        $this->db->where("PSO.title", $title);
        $query = $this->db->get('program_stage PS');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            $query->free_result();
            return $data[0];
        } else {
            return $query->num_rows();
        }

    }
    public function insertincubateeComments($innovation = null, $id = null, $options = array())
    {
        if ($this->session->userdata('user_type') == 'incubatee') {
            $is_incubatee = '1';
        } else {
            $is_incubatee = '0';
        }
        $data = array(
            'assign_id' => $id,
            'innovation' => $innovation,
            'document_description' => $options['document_description'],
            'description' => $options['description'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
            'is_incubatee' => $is_incubatee,
        );
        $this->db->insert('invester_incubatee_comments', $data);

        return true;
    }
    public function selectincubateeComments($innovation = null, $id = null)
    {
        $data = array();
        $this->db->select("IIC.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IIC.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IIC.modified_by) as modified_emp", false);
        $this->db->where('IIC.innovation', $innovation);
        $this->db->where('IIC.assign_id', $id);
        $query = $this->db->get('invester_incubatee_comments IIC');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function insertinvestermemberComments($innovation = null, $id = null, $options = array())
    {
        $data = array(
            'assign_id' => $id,
            'innovation' => $innovation,
            'document_description' => $options['document_description'],
            'description' => $options['description'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('invester_member_comments', $data);
        return true;
    }
    public function selectinvestermemberComments($innovation = null, $id = null)
    {
        $data = array();
        $this->db->select("IMC.*");
        $this->db->where('IMC.innovation', $innovation);
        $this->db->where('IMC.assign_id', $id);
        $query = $this->db->get('invester_member_comments IMC');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

}
