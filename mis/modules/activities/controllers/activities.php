<?php
class Activities extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('master/Mmaster');
        $this->load->model('master/Mmaster_settings');
        $this->load->model('master/Mprogram_stage');
        $this->load->model('Mactivities');
        $this->load->model('scouting/Minnovation');
        $this->items_perpage = '15';
    }

    public function index($innovation)
    {
        $this->Mauth->isPartnerCheck();
        $data['innovation'] = $innovation;
        $data['cpagetitle'] = "Activity Details";
        $data['left_box'] = array('screening', 'innovation_tab');
        $data['cpage'] = "activities/index";
        $this->load->view('../template', $data);
    }

    public function view_list($id, $pservice = null, $pstage = null)
    {
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($id);
        $programstage = $status = $time = $totime = '';
        $options = array();
        $data['curstage'] = $pstage;
        $data['addOption'] = false;
        $data['deleteOption'] = false;
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {
            $data['deleteOption'] = true;
            $data['addOption'] = true;
        }
        if (isset($_POST['txtSubmit'])) {
            $programstage = isset($_POST['activity_type']) ? $_POST['activity_type'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            $time = isset($_POST['time']) ? $_POST['time'] : '';
            $totime = isset($_POST['totime']) ? $_POST['totime'] : '';
        }

        $data['activitiesList'] = $this->Mactivities->getActivities($id, $programstage, $status, $time, $totime);
        $data['program_type'] = $programstage;
        $data['activityTypeList'] = $this->Mmaster->getMasterSettings('Activity Type');
        $data['employee'] = $this->Mactivities->getemployeename();
        $data['status'] = $this->Mactivities->getActivityStatus();
        $data['cpagetitle'] = "Activities";
        $data['cpage'] = "activities/list_activities";

        $data['left_box'] = array('screening', 'innovation_tab');
        $data['custom_js'] = array('stage_service');

        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function add_activity($id, $pservice = null, $pstage = null)
    {
        $data['scoutingStage'] = 5;
        $data['id'] = $id;
        $data['curService'] = $pservice;
        $data['curStage'] = $pstage;

        $programStage = (isset($_POST['program_stage'])) ? $_POST['program_stage'] : $data['curStage'];
        //page Options

        $innovationInfo = $this->Minnovation->getInnovation($id);
        $data['activityTypeList'] = $this->Mmaster->getMasterSettings('Activity Type');
        if ($this->input->post('txtSubmit') != '') {
            $msg = $this->upload($_FILES);
            for ($i = 0; $i < count($_FILES['document']['name']); $i++) {
                $_POST['document'][$i] = $_FILES['document']['name'][$i];
            }
            $this->Mactivities->insert($id, $_POST);
            $this->session->set_flashdata('successMsg', 'Activity Added Successfully!');
            redirect('activities/view_list/' . $id . '/' . $pservice . '/' . $pstage);
        }
        $data['innovationInfo'] = $innovationInfo;
        $data['cpagetitle'] = "Add Assessment Details";
        $data['cpage'] = "activities/add_activity";
        $data['left_box'] = array('screening', 'innovation_tab');
        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function edit_activity($innovation, $activity)
    {
        $data['upload_error'] = array();
        $data['scoutingStage'] = 5;
        $data['activityDetails'] = $this->Mactivities->getActivityDetails($activity);
        $data['activityTypeList'] = $this->Mmaster->getMasterSettings('Activity Type');
        if ($_POST['txtSubmit'] != '') {
            $msg = $this->upload($_FILES);
            for ($i = 0; $i < count($_FILES['document']['name']); $i++) {
                $_POST['document'][$i] = $_FILES['document']['name'][$i];
            }
            $date_array = explode("/", $_POST['end_date']); // split the array
            $var_day = $date_array[0]; //day seqment
            $var_month = $date_array[1]; //month segment
            $var_year = $date_array[2]; //year segment
            $new_date_format = "$var_year-$var_month-$var_day";
            $_POST['end_date'] = date('Y-m-d H-i-s', strtotime($new_date_format));
            $this->Mactivities->updateActivity($_POST);
            $this->session->set_flashdata('successMsg', 'Activity Updated Successfully!');
            redirect('activities/view_list/' . $innovation);
        }
        $data['cpagetitle'] = "Update Assessment Details";
        $data['cpage'] = "activities/add_activity";
        $this->load->vars($data);
        $this->load->view('../template_plain');
    }
    public function activity_details($innovation_id, $activity)
    {
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($innovation_id);
        $activityDetails = $this->Mactivities->getActivityDetails($activity);

        //page Options
        $data['editOption'] = false;
        $data['deleteOption'] = false;
        $data['startOption'] = false;
        $data['closeOption'] = false;
        $status = $activityDetails['0']['status'];
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {
            $data['editOption'] = true;
            $data['deleteOption'] = true;
            if ($status != '1') {$data['startOption'] = true;}
            if ($status != '2') {$data['closeOption'] = true;}
        }

        $data['activityDetails'] = $activityDetails;
        $data['status'] = $this->Mactivities->getActivityStatus();
        $data['cpagetitle'] = "Assessment Details";
        $data['cpage'] = "activities/activity_details";

        $data['left_box'] = array('screening', 'innovation_tab');

        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function delete($innovation = null, $id = null, $activity = null)
    {
        $result = $this->Mactivities->deleteActivities($id, $activity);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            $this->session->set_flashdata('successMsg', 'Activity Deleted successfully!');
        }

        redirect('activities/view_list/' . $innovation);

    }
    public function comments($id)
    {
        $data['activityDetails'] = $this->Mactivities->getActivityDetails($id);

        $data['cpage'] = "activities/activity_action";
        $data['left_box'] = array('screening', 'innovation_tab');
        $this->load->vars($data);
        $this->load->view('../template_iframe');
    }
    public function action($innovation, $activity)
    {
        $action = null;
        $data['activityDetails'] = $this->Mactivities->getActivityDetails($activity);
        if ($this->input->post('txtSubmit') != '') {
            $this->Mactivities->updateComments($activity, $_POST);
            $this->session->set_flashdata('successMsg', 'Comments Posted successfully!');
            redirect('activities/comments/' . $activity);
        }
    }
    public function upload($options)
    {
        $msg = '';
        $config['upload_path'] = './uploads/documents/';
        $config['allowed_types'] = '*';
        $_POST['document'] = '';
        $this->load->library('upload');
        for ($i = 0; $i < count($options['document']['name']); $i++) {
            if ($options['document']['name'][$i] != '') {
                $_FILES['ty']['name'] = $options['document']['name'][$i];
            }

            $_FILES['ty']['tmp_name'] = $options['document']['tmp_name'][$i];
            $_FILES['ty']['size'] = $options['document']['size'][$i];
            $_FILES['ty']['type'] = $options['document']['type'][$i];
            $this->upload->initialize($config);
            $this->upload->do_upload('ty');
        }
        return $msg;
    }

}
