<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Grade extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mgrade');
        $this->load->model('Mmaster_settings');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('master/grade/view_list');
    }
    public function view_list($id = ''){

        $options = array();

        if ($id != '') {
            $data['gradeDetails'] = $this->Mgrade->getGradeDetails($id);
            $programstage = $data['gradeDetails'][0]['program_stage'];
            $datainfo = $this->Mgrade->findGradefield($programstage);
            $data['programtype'] = $datainfo['programtype'];
            $data['programservice'] = $datainfo['programservice'];
            $data['programstage'] = $datainfo['programstage'];
            $data['programserviceid'] = $datainfo['programserviceid'];
            $data['programtypeid'] = $datainfo['programtypeid'];
            $data['programstageid'] = $programstage;
        }
        if (isset($_POST['id'])) {
            $options = $_POST;
            $this->Mgrade->insert($options);
            $data['successMsg'] = 'Activities saved Successfully';
        }
        #Loading View and data
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['gradingCategory'] = $this->Mmaster_settings->getMasterSetting('Grading Category');
        $data['cpagetitle'] = "Grading Master";
        $data['cpage'] = "grade/listGrade";

        $data['left_box'] = array('master');
        $data['custom_js'] = array('stage_service');

        $this->load->view('../template', $data);
    }
    public function list_grade()
    {
        $program_stage = $this->input->post('program_stage');
        $data['gradingCategory'] = $this->Mmaster_settings->getMasterSetting('Grading Category');
        $data['gradeList'] = $this->Mgrade->getGradeListByStage($program_stage);
        $this->load->view('grade/gradeRow', $data);
    }
    public function form($id = '')
    {
        if (isset($_POST['txtSubmit'])) {
            $options = $_POST;
            if ($id == '') {
                $id = $this->Mgrade->insert($options);
                $data['successMsg'] = 'Activities saved Successfully';
                redirect('master/grade/view_list/' . $id);
            } else {
                $options['id'] = $id;
                $this->Mgrade->update($options);
                $data['successMsg'] = 'Activities Updated Successfully';
                redirect('master/grade/view_list/' . $id);
            }
        }
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['gradingCategory'] = $this->Mmaster_settings->getMasterSetting('Grading Category');
        if ($id == '') {
            $data['cpagetitle'] = "Grading Master - Add Grade";
            $data['gradeDetails'] = array();
        } else {

            $data['cpagetitle'] = "Grading Master - Update Grade";
            $data['gradeDetails'] = $this->Mgrade->getGradeDetails($id);
            if (php72_count($data['gradeDetails']) == 0) {
                redirect('master/grade/form');
            }

        }
        $data['cpage'] = "grade/addGrade";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('stage_service');
        $this->load->view('../template', $data);
    }
    public function delete_grade()
    {
        $gradeId = $this->input->post('gradeId');

        $result = $this->Mgrade->delete($gradeId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }

}
