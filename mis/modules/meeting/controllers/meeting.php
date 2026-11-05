<?php
class Meeting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mmeeting');
        $this->load->model('activities/Mactivities');
        $this->load->model('login/Muser');
        $this->load->model('scouting/Minnovation');
    }

    public function view($activity = null)
    {
        if ($activity == null) {
            echo "Invalid Url!";
            exit;
        }
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $_POST['activity'] = $activity;
                if ($this->input->post('meeting_id') == '') {
                    $this->Mmeeting->insertMeeting($_POST);
                } else {
                    $this->Mmeeting->updateMeeting($_POST);
                }
                $data['successMsg'] = 'Details Saved Successfully!';
            }
        }

        #Loading View and data
        $data['activity'] = $activity;
        $activityDetails = $this->Mactivities->getActivityDetails($activity);

        $data['innovation'] = $activityDetails['0']['innovation'];
        $data['innovationInfo'] = $innovationInfo = $this->Minnovation->getInnovation($data['innovation']);
        $data['meetingDetails'] = $this->Mmeeting->getMeetingDetails($activity);
        if (count($data['meetingDetails'])) {
            $meeting_id = $data['meetingDetails']['0']['id'];
        } else {
            $meeting_id = '';
        }

        $data['activityDetails'] = $activityDetails;
        $data['actionList'] = $this->Mmeeting->getActionList($meeting_id);
        $data['agendaList'] = $this->Mmeeting->getAgendaList($meeting_id);
        $data['attendeesList'] = $this->Mmeeting->getAttendeesList($meeting_id);

        $data['usersList'] = $this->Muser->getUsersList();

        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();

        $data['cpagetitle'] = "Meeting";
        $data['cpage'] = "viewMeeting";
        $this->load->view('../template', $data);
    }

    public function test()
    {
        $data['cpagetitle'] = "Meeting";
        $data['cpage'] = "test";
        $this->load->view('../template_iframe', $data);
    }

    /**
     * Function : _validation method is used for validation before add, edit mailtemplate.
     *
     * ---------------
     *
     * @param null
     */

    public function _validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('meeting_date', 'Meeting Date', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

}
