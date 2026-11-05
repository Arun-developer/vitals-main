<?php

class Massociate_boardmember extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function insert($options = array())
    {
        $requestNo = $this->requestNumber();
        $data = array(
            'request_number' => $requestNo,
            'innovation' => $options['innovationid'],
            'no_boardmember' => $options['boardmemberno'],
            'qualification' => $options['qualification'],
            'description' => $options['description'],
            'functionalarea' => $options['functionalarea'],
        );
        $result = $this->db->insert('request_board_member', $data);
        return $result;
    }

    public function statusArr()
    {
        return array(0 => 'Pending', 1 => 'Accepted', 2 => 'Rejected');
    }

    public function updateliststatus($options = array())
    {
        $dataup = array('status' => $options['status']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_board_member', $dataup);

        return $result;
    }

    public function insertSuggestMember($innovationid = null, $id = null, $suggest = array())
    {
        foreach ($suggest as $key => $value):

            $data = array(
                'innovation' => $innovationid,
                'board_id' => $value,
                'request_id' => $id,
                'member_comments' => "",
                'member_status' => "",
                'incubatee_publish' => "",
                'incubatee_comment' => "",
                'incubatee_status' => "",
                'villgro_status' => "",
            );
            $result2 = $this->db->insert('assign_board_member', $data);
        endforeach;
        return true;

    }

    public function update($options = array())
    {
        $dataup = array(
            'innovation' => $options['innovationid'],
            'no_boardmember' => $options['boardmemberno'],
            'qualification' => $options['qualification'],
            'description' => $options['description'],
            'functionalarea' => $options['functionalarea']);
        $this->db->where('id', $this->input->post('id'));

        $result = $this->db->update('request_board_member', $dataup);
        return $result;
    }

    /**
     * Function : delete method is used for delete records by changing status to -1.
     *
     * @param int $vendor_id
     *
     */

    public function delete($vendor_id)
    {
        $data = array('status' => '-1');
        $this->db->where('vendor_id', $vendor_id);
        $this->db->update('quad_master_vendor', $data);
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
        $this->db->where('vendor_id', $options['vendor_id']);
        $this->db->update('quad_master_vendor', $data);
        return true;
    }

    public function updatevillgrostatus($options = array())
    {
        $dataup = array('villgro_status' => $options['villgrostatus']);
        $this->db->where('id', $this->input->post('requestid'));
        $result = $this->db->update('assign_board_member', $dataup);
        return true;
    }
    public function updateincubateestatus($options = array())
    {

        $dataup = array('incubatee_status' => $options['inubcateestatus']);
        $this->db->where('id', $this->input->post('requestid'));
        $result = $this->db->update('assign_board_member', $dataup);

        return true;
    }

    public function updatememberstatus($options = array())
    {

        $dataup = array('member_status' => $options['memberstatus']);
        $this->db->where('id', $this->input->post('requestid'));
        $result = $this->db->update('assign_board_member', $dataup);

        return true;
    }

    public function memberactionHistory($options = array())
    {
        $currentdate = date('Y-m-d');
        $data = array(
            'board_id' => $options['boardid'],
            'action' => $options['villgrostatus'],
            'comments' => $options['comments'],
            'actiondate' => $currentdate,
            'actionby' => "",
            'innovation' => $options['innovationid'],
        );
        $result = $this->db->insert('boardmember_action_history', $data);
        return $result;
    }

    /**
     * Function : getLimitRecords method is used for get Limit records from  board member.
     *
     * @param array $options
     *
     */

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
        $query = $this->db->get('request_board_member');

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

    public function getmemberDetails($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('request_board_member');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function searchBoardmember($options = array())
    {

        $data = array();
        $whereQuery = $this->_searchparam($options);

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('board_member', $whereQuery);
        } else {
            $query = $this->db->get('board_member');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }

    public function _searchparam($options = array())
    {

        $searchArray = array();
        $where = null;
        if (!empty($options['sector'])) {
            $searchArray[] = "sector like '%" . $options['sector'] . "%'";
        }

        if (!empty($options['experience'])) {
            $searchArray[] = "experience like '%" . $options['experience'] . "%'";
        }

        if (!empty($options['qualification'])) {
            $searchArray[] = "education like '%" . $options['qualification'] . "%'";
        }

        if (count($searchArray)) {
            $where = implode(' AND ', $searchArray);
        }

        return $where;
    }

    public function searchMasterBoardmember($id = null)
    {
        $data = array();
        if (!empty($id)) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('board_member');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function insertBoardDetails($id)
    {
        $assigndata = $this->getassignboardDetails($id);
        $innovation = $assigndata[0]['innovation'];
        $boardid = $assigndata[0]['board_id'];
        $boardarray = $this->findBoardmember($boardid);
        $name = $boardarray[0]['name'];
        $data = array(
            'innovation' => $innovation,
            'members' => $name,
        );
        $result = $this->db->insert('board_details', $data);
        return $result;

    }
    public function findBoardmember($id)
    {
        $data = array();
        $this->db->select('first_name as name');
        $this->db->where('id', $id);
        $query = $this->db->get('board_member');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getassignboardDetails($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('assign_board_member');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function assignedBoardmember($innovation = null, $id = null)
    {
        $data = array();
        $this->db->select("BM.*,ABM.*");
        $this->db->join('board_member BM', 'BM.id = ABM.board_id', 'left');
        $this->db->where('ABM.innovation', $innovation);
        if ($id != '') {
            $this->db->where('ABM.request_id', $id);
        }
        $query = $this->db->get('assign_board_member ABM');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }

    public function updateAll($options = array(), $innovation)
    {

        foreach ($options['id'] as $key => $activity) {

            $data = array(
                'member_status' => $options['memberstatus'][$key],
                'incubatee_status' => $options['incubateestatus'][$key],

            );
            $this->db->where('id', $options['id'][$key]);
            $this->db->where('innovation', $innovation);
            $result = $this->db->update('assign_board_member', $data);

        }

        return $result;
    }

    public function insertmemberComments($innovation = null, $id = null, $options = array())
    {
        $data = array(
            'assign_id' => $id,
            'innovation' => $innovation,
            'document_description' => $options['document_description'],
            'document' => $options['document'],
            'description' => $options['description'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('board_member_comments', $data);
        return true;
    }

    public function selectmemberComments($innovation = null, $id = null)
    {
        $data = array();
        $this->db->select("BMC.*");
        $this->db->where('BMC.innovation', $innovation);
        $this->db->where('BMC.assign_id', $id);
        $query = $this->db->get('board_member_comments BMC');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function insertboardmemeberComments($innovation = null, $id = null, $options = array())
    {

        $data = array(
            'assign_id' => $id,
            'innovation' => $innovation,
            'document_description' => $options['document_description'],
            'description' => $options['description'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('board_member_comments', $data);

        return true;

    }

    public function selectboardmemberComments($innovation = null, $id = null)
    {

        $data = array();
        $this->db->select('BMC.*');
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = BMC.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = BMC.modified_by) as modified_emp", false);
        $this->db->where('BMC.innovation', $innovation);
        $this->db->where('BMC.assign_id', $id);
        $query = $this->db->get('board_member_comments BMC');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
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
        $this->db->insert('board_incubatee_comments', $data);

        return true;
    }

    public function selectincubateeComments($innovation = null, $id = null)
    {
        $data = array();
        $this->db->select("BIC.*");
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = BIC.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = BIC.modified_by) as modified_emp", false);
        $this->db->where('BIC.innovation', $innovation);
        $this->db->where('BIC.assign_id', $id);
        $query = $this->db->get('board_incubatee_comments BIC');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function selectboardmemberinfo($boardid)
    {
        $data = array();
        $this->db->select("BM.first_name,BM.comments");

        $this->db->where('BM.id', $boardid);
        $query = $this->db->get('board_member BM');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data[0];
    }

    public function insertscreenbooarddetails($options)
    {

        $data = array(
            'innovation' => $options['innovationid'],
            'members' => $options['members'],
            'profile' => $options['profile'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );

        $this->db->insert('board_details', $data);
        return true;

    }

    public function requestNumber()
    {
        $data = array();
        $text = "REQ/";
        $position = "front";
        $this->db->order_by('id', 'desc');
        $this->db->limit('1', '0');
        $query = $this->db->get('request_board_member');
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

    public function mastermemeberDetail($innovationid, $boardid)
    {
        $data = array();
        $this->db->where('id', $boardid);
        $query = $this->db->get('board_member');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getactionHistory($boardid)
    {
        $data = array();
        $this->db->select("B.first_name as name,BH.*");
        $this->db->join('board_member B', 'B.id = BH.board_id', 'left');
        $this->db->where("board_id", $boardid);
        $query = $this->db->get('boardmember_action_history BH');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getpreviousHistory($boardid, $innovationid)
    {

        $data = array();
        $this->db->select("IP.name_of_enterprise as name");
        $this->db->join('assign_board_member ABM', 'ABM.innovation = IP.id', 'right');

        $query = $this->db->get('innovation_pool IP');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

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
        }

        $query->free_result();
        return @$data[0];
    }

    public function screeningBoardmember($innovationid)
    {
        $data = array();
        $villgrostatus = 1;

        $this->db->select("B.*,ABM.innovation");
        $this->db->join('board_member B', 'B.id = ABM.board_id', 'left');
        $this->db->where("innovation", $innovationid);
        $this->db->where("villgro_status", $villgrostatus);
        $query = $this->db->get('assign_board_member ABM');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getnoboardmemberAssigned($innovationid, $id)
    {
        $data = array();
        $villgrostatus = 1;
        $this->db->select("count(*)as total,RBM.no_boardmember");
        $this->db->join('assign_board_member ABM', 'ABM.request_id = RBM.id', 'left');
        $this->db->where("ABM.innovation", $innovationid);
        $this->db->where("ABM.request_id", $id);
        $this->db->where("ABM.villgro_status", $villgrostatus);

        $query = $this->db->get('request_board_member RBM');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        return $data[0];

    }

    public function closRequest($id)
    {
        $data = array('request_status' => '1');
        $this->db->where('id', $id);
        $result = $this->db->update('request_board_member', $data);

    }

}
