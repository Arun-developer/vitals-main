<?php
#
# Model Class -  hs_quad_master_settings
#
class Mgrading extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function insertGrading($options = array())
    {
        $data = array('innovation_id' => $options['activity'],
            'feed_back' => $options['feedback'],
            'score' => $options['totalScore'],
            'result' => $options['result'],
            'fstage' => $options['stage'],
            'reject_reason' => $options['reason'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $this->db->insert('grading_feedback', $data);
        $id = $this->db->insert_id();
        $this->insertGrade($options, $id);
        return $id;
    }
    public function updateGrading($options = array())
    {
        $data = array('feed_back' => $options['feedback'],
            'score' => $options['totalScore'],
            'result' => $options['result'],
            'fstage' => $options['stage'],
            'reject_reason' => $options['reason'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'));
        $this->db->where('id', $options['grading_id']);
        $this->db->update('grading_feedback', $data);
        $this->db->where('grading_id', $options['grading_id']);
        $this->db->delete('grades');
        $this->insertGrade($options, $options['grading_id']);
        return true;
    }
    public function insertGrade($options, $id)
    {
        if (isset($options['grede_id'])) {
            foreach ($options['grede_id'] as $key => $value):

                $data = array('grading_id' => $id,
                    'grading_master' => @$options['grede_id'][$key],
                    'grade' => @$options['grade'][$key],
                    'description' => '');
                $this->db->insert('grades', $data);
            endforeach;
        }
    }

    /**
     * Function : getLimitRecords method is used for get Limit records from  vendors.
     *
     * @param array $options
     *
     */
    public function getGradingInnovation($innovation)
    {
        $data = array();
        $this->db->select("GF.*");
        $this->db->select("(SELECT title FROM program_stage PS WHERE PS.id = A.program_stage) as program_stage");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = GF.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = GF.modified_by) as modified_emp", false);

        $this->db->where('A.innovation', $innovation);
        $this->db->join('activities A', 'A.id = GF.activity');
        $query = $this->db->get('grading_feedback GF');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getGradingList($activity, $grading = null)
    {
        $data = array();
        $this->db->select("GF.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = GF.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = GF.modified_by) as modified_emp", false);

        $this->db->where('innovation_id', $activity);
        if ($grading != null) {
            $this->db->where('id', $grading);
        }

        $query = $this->db->get('grading_feedback GF');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getGradingDetails($grading)
    {
        $data = array();
        $this->db->where('id', $grading);
        $query = $this->db->get('grading_feedback');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getGradingDetailsbyinnovation($innovation)
    {
        $data = array();
        $this->db->where('innovation_id', $innovation);
        $query = $this->db->get('grading_feedback');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getGrades($activity, $grading = null)
    {
        $data = array();
        if ($grading == '') {
            $this->db->where('graded_by', $this->session->userdata('emp_number'));
        } else {
            $this->db->where('graded_by', $grading);
        }
        $this->db->where('grading_id', $activity);
        $query = $this->db->get('grades');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();

        return $data;
    }
    public function getGradingMapData($grading = null)
    {
        $data = array();
        $this->db->select("MS.master_name,avg(grade) as grade");
        if ($grading != null) {
            $this->db->where('G.grading_id', $grading);
        }

        $this->db->join('grading_master GM', 'GM.category = G.grading_master', 'left');
        $this->db->join('master_settings MS', 'MS.id = GM.category', 'left');

        $this->db->group_by('GM.category');
        $query = $this->db->get('grades G');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();

        return $data;
    }
    public function createGradeScoreView()
    {
        $this->db->db_debug = false;
        $query = $this->db->query("DROP VIEW innovation_score");
        $query = $this->db->query("CREATE VIEW innovation_score
									   AS
									   SELECT A.innovation,A.program_stage,ROUND(sum(GF.score),2) as score
									   FROM (`activity_master` AH, `activities` A, `grading_feedback` GF)
									   WHERE `AH`.`id` = `A`.`activity` AND `A`.`id` = `GF`.`activity` group by program_stage,innovation");
    }
    public function dropGredeScoreView()
    {
        $this->db->query("DROP VIEW innovation_score");
    }

    public function makeSpider($activity = null, $grading = null)
    {
        $this->load->library('chart');
        $gradingList = array();
        if ($activity != null) {
            $gradingList = $this->Mgrading->getGradingList($activity, $grading);
        }

        $title = 'Grading & FeedBack';
        $label = array();
        $value = array();
        $serieList = array();

        foreach ($gradingList as $row):
            $grade = $this->Mgrading->getGradingMapData($row['innovation_id']);
            $label = array();
            $value = array();
            foreach ($grade as $gd):

                $label[] = $gd['master_name'];
                $value[] = round($gd['grade'], 0);
            endforeach;
            $serieList[] = array('value' => $value,
                'name' => ($row['created_emp'] != '') ? $row['created_emp'] : 'Admin');
        endforeach;

        if (count($label) && count($serieList)) {
            $this->chart->showChart($title, $label, $serieList);
            return true;
        } else {
            return false;
        }
    }

}
