<?php

class Grading extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mgrading');
        $this->load->model('master/Mgrade');
        $this->load->model('master/Mmaster_settings');
        $this->load->model('master/Mprogram_stage');
        $this->load->model('activities/Mactivities');
        $this->load->model('login/Muser');
        $this->load->model('scouting/Minnovation');
        $this->load->model('scouting/Mincharge');
    }

    public function view($activity = null, $grading = null, $act = 'edit') {

        if ($activity == null) {
            echo "Invalid Url!";
            exit;
        }
        $data['curProgramType'] = 46;
        $data['curService'] = 4;
        $data['scoutingStage'] = 5;
        $data['act'] = $act;
        $data['activity'] = $activity;

        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($activity);

        if (isset($_POST['txtSubmit'])) {
            $_POST['activity'] = $activity;
            if ($this->input->post('grading_id') == '') {
                $this->Mgrading->insertGrading($_POST);
            } else {
                $this->Mgrading->updateGrading($_POST);
            }

            if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
                if ($_POST['result'] == 'Accepted') {
                    $this->Minnovation->changeStatus($innovation['id'], '7'); // status 7 -> lead
                } else {
                    $this->Minnovation->changeStatus($innovation['id'], '3');
                }
                $this->Minnovation->gradingStatus($innovation['id'], '0');
            } else {
                $this->Minnovation->gradingStatus($innovation['id'], '1');
            }

            $data['successMsg'] = 'Details Saved Successfully!';
        }
        #Loading View and data
        if ($grading != null) {
            $data['gradingDetails'] = $this->Mgrading->getGradingDetails($grading, $activity);
            $gradedby = $data['gradingDetails'][0]['created_by'];
            $data['gradesList'] = $this->Mgrading->getGrades($activity, $gradedby);
        } else {
            $data['gradingDetails'] = $this->Mgrading->getGradingDetails($grading, $activity);
            $data['gradesList'] = $this->Mgrading->getGrades($activity);
        }

        $data['gradingList'] = $this->Mgrading->getGradingList($activity);
        $data['gradesMasterList'] = $this->Mgrade->getGradeListByStage('9');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['cpagetitle'] = "Grading & Feedback";
        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array('stage_service');
        if ($act == 'view') {
            $data['cpage'] = "grading/viewDetails";
            $this->load->view('../template_plain', $data);
        } else {
            $this->load->model('master/Mmaster_settings');
            $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $innovation['partner_id']);
            $data['cpage'] = "grading/viewGrading";
            $this->load->view('../template', $data);
        }
    }

    public function grading_innovation($id) {
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($id);
        $data['gradingList'] = $this->Mgrading->getGradingInnovation($id);
        $data['cpage'] = "grading/viewGradingInnovation";
        $data['cpagetitle'] = "Grading Results";
        $data['left_box'] = array('innovation_tab');
        $this->load->view('../template', $data);
    }

    public function spidermap($activity = null, $grading = null) {
        $isMap = $this->Mgrading->makeSpider($activity, $grading);
        if ($isMap) {
            ?>
            <div style="text-align:center; margin-left:60px;  width:600px;"><img src="<?= base_url() ?>map.png" align="center" ></div>
            <?php
        } else {
            echo "No records to display";
        }
    }

    /**
     * Function : _validation method is used for validation before add, edit mailtemplate.
     *
     * ---------------
     *
     * @param null
     */
    public function _validation() {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('meeting_date', 'Meeting Date', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

    public function next_grading($id) {

        $innovationInfo = $this->Minnovation->getInnovation($id);
        $currentStage = $this->Mprogram_stage->getCurrentStage($innovationInfo['stage']);
        $activity = $this->Mactivities->getActivityForGrading($id, $currentStage);

        if (count($activity)) {
            redirect('grading/view/' . $this->uri->segment('4'));
        } else {
            $form['program_stage'] = $currentStage;
            $form['activity_type'] = '29';
            $form['activity_description'] = 'Grading';
            if ($innovationInfo['stage'] == '1') {
                $form['activity_description'] = 'Grading';
            }
            if ($innovationInfo['stage'] == '3') {
                $form['activity_description'] = 'Innovator Presentation - Grading';
            }
            $form['start_date'] = date("m/d/Y");
            $form['end_date'] = '';
            $id = $this->Mactivities->insert($id, $form);
            redirect('grading/view/' . $id . '/' . $this->uri->segment('4'));
        }
    }

    public function pending($id) {
        $innovationInfo = $this->Minnovation->getInnovation($id);
        $currentStage = $this->Mprogram_stage->getCurrentStage($innovationInfo['stage']);
        $activity = $this->Mactivities->getActivityForGrading($id, $currentStage);
        if (count($activity)) {
            redirect('grading/view/' . $activity['0']['id'] . '/' . $this->uri->segment('4'));
        }
    }

}
?>
