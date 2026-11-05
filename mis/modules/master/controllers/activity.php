<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Activity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mactivity');
        $this->load->model('scouting/Minnovation');
        $this->load->model('Mmaster_settings');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('master/activity/view_list');
    }
    public function view_list()
    {
        $options = array();
        if (isset($_POST['id'])) {
            $options = $_POST;
            $this->Mactivity->insert($options);
            $data['successMsg'] = 'Activities saved Successfully';
        }
        #Loading View and data
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['activityType'] = $this->Mmaster_settings->getMasterSetting('Activity Type');
        $data['cpagetitle'] = "Activity Master";
        $data['cpage'] = "activity/listActivity";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('stage_service');
        $this->load->view('../template', $data);
    }

    public function mapping()
    {
        $options = array();
        if (isset($_POST['txtSubmit'])) {
            $options = $_POST;
            $this->Mactivity->insertMap($options);
            $data['successMsg'] = 'Mapping Saved Successfully';
        }
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['activityType'] = $this->Mmaster_settings->getMasterSetting('Activity Type');
        $data['innovationList'] = $this->Minnovation->getInnovationCombo();
        $data['cpagetitle'] = "Activity Mapping";
        $data['cpage'] = "activity/mapActivity";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('stage_service');
        $this->load->view('../template', $data);
    }

    public function delete($id = '')
    {
        if ($id != '') {
            $result = $this->Mactivity->delete($id);
            $this->session->set_flashdata('successMsg', 'Record deleted Successfully');
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/activity/view_list');
    }

    public function list_activity()
    {
        $program_stage = $this->input->post('program_stage');
        $data['programStageList'] = $this->Mactivity->getActivityListByStage($program_stage);
        $data['activityType'] = $this->Mmaster_settings->getMasterSetting('Activity Type');
        $this->load->view('activity/activityRow', $data);
    }

    public function delete_activity()
    {
        $actId = $this->input->post('actId');
        $result = $this->Mactivity->delete($actId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }

    public function list_activity_map()
    {
        $program_stage = $this->input->post('program_stage');
        $innovation = $this->input->post('innovation');
        $data['usedActivity'] = $this->Mactivity->getMappingActivity($program_stage, $innovation);
        $data['programStageList'] = $this->Mactivity->getActivityListByStage($program_stage);
        $data['activityType'] = $this->Mmaster_settings->getMasterSetting('Activity Type');
        $this->load->view('activity/activityRowMap', $data);
    }

}
