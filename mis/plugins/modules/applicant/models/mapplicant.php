<?php

class Mapplicant extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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
        }
        if ($options['innovationid'] != '') {
            $this->db->where('innovation', $options['innovationid']);
        }
        $query = $this->db->get('request_applicant');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getapplicantList($innovationid, $id)
    {
        $data = array();
        $this->db->select("AA.*,A.first_name");
        $this->db->join('applicant A', 'A.id = AA.applicant_id', 'left');
        $this->db->join('request_applicant RA', 'RA.id = AA.request_id', 'left');
        if ($innovationid != '') {
            $this->db->where('AA.innovation', $innovationid);
        }
        if ($id != '') {
            $this->db->where('AA.request_id', $id);
        }
        $query = $this->db->get('assign_applicant AA');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }

    public function insertmasterapplicant($options = array())
    {
        $data = array('sector' => $options['sector'],
            'experience' => $options['experience'],
            'skills' => $options['skills'],
            'first_name' => $options['first_name'],
            'second_name' => "",
            'address' => $options['address'],
            'city' => $options['city'],
            'telephone' => $options['telephone'],
            'mobile' => $options['mobile'],
            'email' => $options['email'],
            'photograph' => $options['photograph'],
            'resume' => $options['resume'],
        );
        $this->db->insert('applicant', $data);

        $id = $this->db->insert_id();
        $data2 = array('innovation' => $options['innovationid'],
            'applicant_id' => $id,
            'request_id' => $options['id'],
            'interview_date' => $options['first_name'],
            'interview_status' => $options['second_name'],
            'status' => $options['address'],
        );

        $result2 = $this->db->insert('assign_applicant', $data2);
        return $result2;
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

    public function getapplicantDetails($id = null)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('request_applicant');
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
        $data = array(
            'innovation' => $options['innovationid'],
            'sector' => $options['sector'],
            'education' => $options['education'],
            'experience' => $options['experience'],
            'description' => $options['description'],
        );
        $result = $this->db->insert('request_applicant', $data);
        return $result;
    }

    public function update($options = array())
    {
        $dataup = array(
            'innovation' => $options['innovationid'],
            'sector' => $options['sector'],
            'education' => $options['education'],
            'experience' => $options['experience'],
            'description' => $options['description']);
        $this->db->where('id', $this->input->post('id'));

        $result = $this->db->update('request_applicant', $dataup);
        return $result;
    }

    public function assignChecklist($options = array())
    {
        $data = array('innovation' => $options['innovationid'],
            'checklist' => implode(',', $options['document']));

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
        //debug_last_query();
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

    public function insertSuggestInvester($innovationid = null, $id = null, $suggest = array())
    {
        foreach ($suggest as $key => $value):
            $data = array(
                'innovation' => $innovationid,
                'invester_id' => $value,
                'invester_id' => $id,
                'member_comments' => "",
                'member_status' => "",
                'incubatee_publish' => "",
                'incubatee_comment' => "",
                'incubatee_status' => "",
                'villgro_status' => "",
            );
            $result2 = $this->db->insert('assign_invester', $data);
        endforeach;

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

    public function masterinvesterDetail($innovationid, $investerid)
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

    public function updatevillgrostatus($options = array())
    {
        $dataup = array('villgro_status' => $options['villgrostatus']);
        $this->db->where('id', $this->input->post('requestid'));
        $result = $this->db->update('assign_invester', $dataup);
        return $result;
    }

    public function updateliststatus($options = array())
    {
        $dataup = array('status' => $options['status']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_applicant', $dataup);
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
                'invester_status' => $options['memberstatus'][$key],
                'incubatee_publish' => $options['incubateepublish'][$key],
                'incubatee_status' => $options['incubateestatus'][$key],
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
        }
        $query->free_result();
        return $data[0];
    }

}
