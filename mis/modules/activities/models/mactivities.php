<?php
class Mactivities extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'scouting_activities';
        $this->load->model('master/Mprogram_stage');
        $this->load->model('master/Mmaster');
    }
    public function getActivityStatus()
    {
        return array('Not Started', 'Progress', 'Closed');
    }
    public function insert($innovation, $form = array())
    {
        //insert master
        $data = array('program_stage' => '8',
            'activity_type' => '31',
            'activity_description' => $form['activity_description'],
            'activity_title' => $form['activity_title'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('activity_master', $data);
        $id = $this->db->insert_id();

        //insert activities
        $data1 = array('program_stage' => '8',
            'innovation' => $innovation,
            'activity' => $id,
            'end_date' => date2mysql($form['end_date']),
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('activities', $data1);
        $activity_id = $this->db->insert_id();

        for ($i = 0; $i < count($form['document']); $i++) {
            $data = array('table' => $this->session->userdata('user_name'),
                'field' => $activity_id,
                'document' => $form['document'][$i],
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date($this->config->item('mysqlDate')),
                'tag' => $form['tags']);
            $result = $this->db->insert('document_master', $data);
        }
        return $activity_id;
    }
    public function updateActivity($form)
    {
        //update master
        $data = array('activity_description' => $form['activity_description'],
            'activity_title' => $form['activity_title'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $form['activity']);
        $this->db->update('activity_master', $data);

        //update activities
        $data1 = array('program_stage' => '8',
            'end_date' => $form['end_date'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $form['id']);
        $this->db->update('activities', $data1);

        for ($i = 0; $i < count($form['document']); $i++) {
            $data = array('document' => $form['document'][$i],
                'tag' => $form['tags']);
            $this->db->where('field', $form['id']);
            $result = $this->db->update('document_master', $data);
        }
        return true;
    }

    public function getActivities($innovation, $program_stage = null, $status = null, $time = null, $totime = null)
    {

        $data = array();
        $this->db->select("ACT.*,MAS.activity_type,MAS.activity_title,MAS.activity_description,MS.master_name as activity_type_name");
        $this->db->select("(select CONCAT_WS(' 'emp_first_name,emp_last_name) from  hr_user_profile where id = ACT.created_by) as created_emp", false);
        $this->db->join('activity_master MAS', 'MAS.id = ACT.activity');
        $this->db->join('master_settings MS', 'MAS.activity_type = MS.id');
        if ($program_stage != null) {
            $this->db->where('MAS.activity_type', $program_stage);
        }

        if ($status != null) {
            $this->db->where('ACT.created_by', $status);
        }

        if ($time != null && $totime != null) {
            $stdate = date('Y-m-d', strtotime($time));
            $new = explode('/', $totime);
            $new = array_reverse($new);
            $ttdate = implode('-', $new);
            $this->db->where('ACT.created_date >= ', $stdate);
            $this->db->where('ACT.created_date <= ', $ttdate);
        }
        $this->db->where('ACT.innovation', $innovation);
        $this->db->order_by('ACT.id', 'DESC');
        $query = $this->db->get('activities ACT');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getemployeename()
    {
        $data = array();
        $this->db->order_by('emp_first_name');
        $query = $this->db->get('hr_user_profile');
        return $query->result_array();
    }

    public function changeStatus($id, $status)
    {
        $this->db->set('status', $status);
        $this->db->set('modified_by', $this->session->userdata('emp_number'));
        $this->db->set('modified_date', date($this->config->item('mysqlDate')));
        $this->db->where('id', $id);
        $this->db->update('activities');
        return true;
    }
    public function updateComments($id, $form)
    {
        $this->db->set('remarks', $form['comments']);
        $this->db->set('modified_by', $this->session->userdata('emp_number'));
        $this->db->set('modified_date', date($this->config->item('mysqlDate')));
        $this->db->where('id', $id);
        $this->db->update('activities');
        return true;
    }
    public function deleteActivities($id, $activity)
    {
        $this->db->db_debug = false;
        $this->db->where('id', $id);
        $result = $this->db->delete('activities');
        $this->db->where('id', $activity);
        $result = $this->db->delete('activity_master');
        return true;

    }

    public function getActivityDetails($id)
    {
        $data = array();
        $this->db->select("ACT.*,MAS.activity_type,MAS.activity_title,MAS.activity_description,MS.master_name as activity_type_name,IP.name_of_enterprise,DM.document");
        $this->db->select("(select CONCAT_WS(' 'emp_first_name,emp_last_name) from  hr_user_profile where id = ACT.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' 'emp_first_name,emp_last_name) from  hr_user_profile where id = ACT.modified_by) as modified_emp", false);
        $this->db->select("(select title from  program_stage where id = ACT.program_stage) as program_stage_name", false);
        $this->db->join('activity_master MAS', 'MAS.id = ACT.activity');
        $this->db->join('document_master DM', 'DM.field = ACT.id');
        $this->db->join('master_settings MS', 'MAS.activity_type = MS.id');
        $this->db->join('innovation_pool IP', 'IP.id = ACT.innovation', 'left');
        $this->db->where('ACT.id', $id);

        $query = $this->db->get('activities ACT');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getActivityForGrading($innovation, $stage = '5', $grading = '29')
    {
        $data = array();
        $this->db->select("ACT.id");
        $this->db->where('ACT.innovation', $innovation);
        $this->db->where('ACT.program_stage', $stage);
        $this->db->where('MAS.activity_type', $grading);

        $this->db->join('activity_master MAS', 'MAS.id = ACT.activity');
        $this->db->join('master_settings MS', 'MAS.activity_type = MS.id');
        $query = $this->db->get('activities ACT');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getGradePending($id, $program_stage)
    {

        $currentStage = $this->Mprogram_stage->getCurrentStage($program_stage);
        $list = $this->getActivityForGrading($id);
        if (count($list)) {
            $gradingAll = $this->getGeadingAll($list['0']['id']);
            $gradingAdmin = $this->getGeadingAdmin($list['0']['id']);
            if (count($gradingAll) != '0' && count($gradingAdmin) == '0') {
                return $list['0']['id'];
            }
        }
        return '';
    }

    public function getGeadingAll($activity)
    {
        $data = array();
        $user[] = $this->Mmaster->getCEO();
        $user[] = $this->Mmaster->getCIO();
        $user[] = '0';
        $this->db->select('id');
        $this->db->where('activity', $activity);
        $this->db->where_not_in('created_by', $user);
        $query = $this->db->get('grading_feedback');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getGeadingAdmin($activity)
    {
        $user[] = $this->Mmaster->getCEO();
        $user[] = $this->Mmaster->getCIO();
        $user[] = '0';
        $data = array();
        $this->db->select('id');
        $this->db->where('activity', $activity);
        $this->db->where_in('created_by', $user);
        $query = $this->db->get('grading_feedback');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
