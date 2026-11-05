<?php

class Mmentor extends CI_Model
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
        } else
        if ($options['innovationid'] != '') {
            $this->db->where('innovation', $options['innovationid']);
        }
        $query = $this->db->get('request_mentor');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getmentorList($innovationid, $id)
    {
        $data = array();
        $this->db->select("AM.*,M.first_name");
        $this->db->join('mentor M', 'M.id = AM.mentor_id', 'left');
        $this->db->join('request_mentor RM', 'RM.id = AM.request_id', 'left');
        if ($innovationid != '') {
            $this->db->where('AM.innovation', $innovationid);
        }
        if ($id != '') {
            $this->db->where('AM.request_id', $id);
        }
        $query = $this->db->get('assign_mentor AM');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }

    public function calculateWorkingDaysInMonth($year = '', $month = '')
    {
        //in case no values are passed to the function, use the current month and year
        if ($year == '') {
            $year = date('Y');
        }
        if ($month == '') {
            $month = date('m');
        }
        //create a start and an end datetime value based on the input year
        $startdate = strtotime($year . '-' . $month . '-01');
        $enddate = strtotime('+' . (date('t', $startdate) - 1) . ' days', $startdate);
        $currentdate = $startdate;
        //get the total number of days in the month
        $return = intval((date('t', $startdate)), 10);
        //loop through the dates, from the start date to the end date
        while ($currentdate <= $enddate) {
            //if you encounter a Saturday or Sunday, remove from the total days count
            if ((date('D', $currentdate) == 'Sat') || (date('D', $currentdate) == 'Sun')) {
                $return = $return - 1;
            }
            $currentdate = strtotime('+1 day', $currentdate);
        } //end date walk loop
        //return the number of working days
        return $return;
    }

    public function Villgroemployeedetail($empid = null)
    {
        $data = array();
        $dbm = $this->load->database('hris', true);
        $query = $dbm->query("SELECT * from hs_hr_employee where emp_number='$empid'");
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function Villgroemp($empid = null)
    {
        $data = array();
        $dbm = $this->load->database('hris', true);
        $query = $dbm->query("SELECT employee_id from hs_hr_employee where emp_number='$empid'");
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return @$data[0]['employee_id'];
    }

    public function getemployeenumber($empid = null)
    {
        $data = array();
        $dby = $this->load->database('hris', true);

        $query = $dby->query("SELECT emp_number from hs_hr_employee where employee_id='$empid'");

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function findInnovatortitle($innovatorid)
    {
        $data = array();
        $this->db->select("IP.name_of_enterprise as title");
        $query = $this->db->get('innovation_pool IP');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data[0]['title'];
    }

    public function calculateMentoringhours($innovationid, $empid)
    {
        $data = array();
        $title = $this->findInnovatortitle($innovationid);
        $db1 = $this->load->database('hris', true);
        $db1->dbprefix = "";

        $db1->select("sum(hour) as totalhour, employee_id");
        $db1->join('project_work PW', 'PW.id = HN.project_id', 'left');

        $db1->where('PW.work_name', $title);
        $db1->where('employee_id', $empid);
        $query = $db1->get('hs_hr_time_new HN');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function calculatebasicSalary($employeeno)
    {
        $data = array();
        $days = $this->calculateWorkingDaysInMonth();
        $dbx = $this->load->database('hris', true);
        $dbx->dbprefix = "";
        $dbx->select("BS.ebsal_basic_salary as basicsalary");
        $dbx->where('BS.emp_number', $employeeno);
        $query = $dbx->get('hs_hr_emp_basicsalary_history BS');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

    }

    public function calculateCostperhour($salary, $days, $mentorhour)
    {

        if ($salary != 0) {

            $perdaysalary = ($salary) / ($days);

            if ($perdaysalary != 0) {

                $perhoursalary = $perdaysalary / 8;

            } else {
                $perhoursalary = 0;
            }
        } else {
            $perhoursalary = 0;
        }

        $totalmoney = $perhoursalary * $mentorhour;

        return $totalmoney;

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

    public function emplist()
    {
        $data = array();
        $db1 = $this->load->database('hris', true);
        $emptype = "employee";

        $query = $db1->query("SELECT emp_number,emp_lastname,emp_firstname,emp_work_email from
			  hs_hr_employee  where  emp_type='$emptype' ");

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getmentorDetails($id = null)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('request_mentor');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function searchMentor($options = array())
    {
        $data = array();

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('mentor', $whereQuery);
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

    public function insertSuggestMentor($innovationid = null, $id = null, $suggest = array(), $company)
    {
        foreach ($suggest as $key => $value):

            $data = array(
                'innovation' => $innovationid,
                'mentor_id' => $value,
                'request_id' => $id,
                'company' => $company,
                'villgro_status' => 1,
            );
            $result2 = $this->db->insert('assign_mentor', $data);

        endforeach;

        return true;
    }

    public function assignedBoardmember($innovation = null, $id = null)
    {

        $data = array();
        $this->db->select("M.*,AM.*");
        $this->db->join('mentor M', 'M.id = AM.mentor_id', 'left');
        $this->db->where('AM.innovation', $innovation);
        if ($id != '') {
            $this->db->where('AM.request_id', $id);
        }
        $query = $this->db->get('assign_mentor AM');

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
        $data = array('request_mentornumber' => $requestNo,
            'innovation' => $options['innovationid'],
            'no_mentor' => $options['nomentor'],
            'sector' => $options['sector'],
            'experience' => $options['experience'],
            'description' => $options['description'],
        );
        $result = $this->db->insert('request_mentor', $data);
        return $result;
    }

    public function requestNumber()
    {
        $data = array();
        $text = "MEN/";
        $position = "front";
        $this->db->order_by('id', 'desc');
        $this->db->limit('1', '0');
        $query = $this->db->get('request_mentor');
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
            'no_mentor' => $options['nomentor'],
            'sector' => $options['sector'],
            'experience' => $options['experience'],
            'description' => $options['description']);
        $this->db->where('id', $this->input->post('id'));

        $result = $this->db->update('request_mentor', $dataup);
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

    public function mastermentorDetail($mentorid, $company)
    {
        $data = array();
        if ($company == 'Villgro') {
            $data = array();
            $db1 = $this->load->database('hris', true);
            $query = $db1->query("SELECT * from
			  		  hs_hr_employee  where  emp_number=$mentorid");
        } else {
            $data = array();
            $this->db->select("I.*,AI.*");
            $this->db->join('invester I', 'I.id = AI.invester_id', 'left');
            $this->db->where('AI.innovation', $innovationid);
            $this->db->where("invester_id", $investerid);
            $query = $this->db->get('assign_invester AI');
        }

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

        $result = $this->db->update('assign_mentor', $dataup);
        return $result;
    }

    public function updateliststatus($options = array())
    {
        $dataup = array('status' => $options['status']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_mentor', $dataup);
        return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('request_mentor');
        return true;
    }

    public function mentoractionHistory($options = array())
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

                'mentorhours' => $options['mentorhour'][$key],
                'mentormoney' => $options['mentoramount'][$key],
            );
            $this->db->where('id', $options['id'][$key]);
            $this->db->where('innovation', $innovationid);
            $result = $this->db->update('assign_mentor', $data);
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

}
