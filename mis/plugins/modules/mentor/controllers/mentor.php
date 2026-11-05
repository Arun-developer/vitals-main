<?php

/*-

 * Masters Module Controller

 * This section for setting  purpose

 *

 * Master's Controller

 * @quadrupleindia.com

 * author - Prabakar

 */

class Mentor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';

        $this->load->model('Mmentor');

        $this->load->model('scouting/Minnovation');

        $this->load->helper('common_helper');
    }

    public function index()
    {
        redirect('mentor/view_list/' . $innovationid);
    }

    public function view_list($innovationid)
    {
        $data['statusArr'] = statusArr();

        $data['requestStatus'] = requestStatus();

        $options = array();

        $options = $_POST;

        $options['num'] = $this->items_perpage;

        $options['offset'] = $this->uri->segment(4);

        $options['innovationid'] = $innovationid;

        $data['applicantList'] = $this->Mmentor->getLimitRecords($options);

        $data['orderby'] = $this->input->post('sort_column');

        $data['ordertype'] = $this->input->post('sort_order');

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $data['innovationid'] = $innovationid;

        $data['isincubAuth'] = false;

        $data['cpagetitle'] = "Mentor Request";

        $data['isAbi'] = $isAbi = false;

        if (in_array($this->session->userdata('user_type'), array('abi'))) {

			$data['isAbi'] = $isAbi = true;
			
        }

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

        } else {

            $data['left_box'] = array('incubation', 'innovation_tab');

            $data['isincubAuth'] = false;

        }

        $data['cpage'] = "mentor/listmentor";

        $this->load->vars($data);

        if ($this->session->userdata('user_type') != 'incubatee') {
            $this->load->view('../template');
        } else {
            $this->load->view('../dashboard_template');
        }

    }

    public function form($innovationid = null, $id = null)
    {

        $data['sectorarr'] = $sectorarr = array(1 => 'Agriculture', 2 => 'Water', 3 => 'Energy', 4 => 'Others');

        $data['mentorDetails'] = array();

        if ($id != '') {

            $data['cpagetitle'] = "Edit Mentor";

            $data['mentorDetails'] = $this->Mmentor->getmentorDetails($id);

        } else {

            $data['cpagetitle'] = "Add Mentor";

        }

        if (isset($_POST['txtSubmit'])) {

            if ($_POST['action'] == 'edit') {

                $options = array();

                $options = $_POST;

                $result = $this->Mmentor->update($_POST);

                $msg = "Record Updated!";

            } else {

                $options = array();

                $options = $_POST;

                $result = $this->Mmentor->insert($options);

                $msg = "Record Inserted!";

            }

            $this->session->set_flashdata('successMsg', $msg);

            redirect('mentor/view_list/' . $innovationid);

        }

        $data['innovationid'] = $innovationid;

        $data['cpage'] = "addmentorreq";

        $this->load->view('../template_plain', $data);

    }

    public function add($innovationid, $id)
    {

        $exparr = array();

        $sectorarr = array();

        $exparr = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6');

        $sectorarr = array(1 => 'Agriculture', 2 => 'Water', 3 => 'Energy', 4 => 'Others');

        $data['exparr'] = $exparr;

        $data['sectorarr'] = $sectorarr;

        if (isset($_POST['txtSubmit'])) {

            $options = array();

            $options = $_POST;

            $options['innovationid'] = $innovationid;

            $options['id'] = $id;

            if ($_FILES['photograph']['name'] != '') {

                $options['photograph'] = $_FILES['photograph']['name'];

            } else {

                $_FILES['photograph']['name'] = "";

                $options['photograph'] = "";

            }

            if ($_FILES['resume']['name'] != '') {

                $options['resume'] = $_FILES['resume']['name'];

            } else {

                $_FILES['resume']['name'] = "";

                $options['resume'] = "";

            }

            $result = $this->Mmentor->insertmasterapplicant($options);

            if ($result) {

                $this->session->set_flashdata('successMsg', 'Record inserted !');

                redirect('master/applicant');

            }

        }

        $data['innovationid'] = $innovationid;

        $data['id'] = $id;

        $data['cpagetitle'] = "Add Applicant";

        $data['cpage'] = "applicant/addapplicant";

        $this->load->view('../template', $data);

    }

    public function allUpdate($innovationid = null, $requestid = null)
    {

        $options = array();

        $options = $_POST;

        $innovationid = $options['innovationid'];

        $update = $this->Mmentor->updateAll($options, $innovationid, $requestid);

        redirect('mentor/mentorDetail/' . $innovationid . '/' . $requestid);

    }

    public function delete($innovationid, $id = '')
    {

        if ($id != '') {

            $result = $this->Mmentor->delete($id);

            $this->session->set_flashdata('successMsg', 'Mentor deleted Successfully');

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('mentor/view_list/' . $innovationid);

    }

    public function liststatus($status = null, $innovationid = null, $id = null)
    {

        if ($status == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $this->Mmentor->updateliststatus($options);

                redirect('mentor/view_list/' . $innovationid);

            }

            $data['cpagetitle'] = "Approve Request";

            $data['innovationid'] = $innovationid;

            $data['id'] = $id;

            $data['cpage'] = "listRequest";

            $this->load->view('../template_plain', $data);

        } else {

            if (isset($_POST['rejectSubmit'])) {

                $options = array();

                $options = $_POST;

                $this->Mmentor->updateliststatus($options);

                redirect('mentor/view_list/' . $innovationid);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['id'] = $id;

            $data['cpage'] = "listReject";

            $this->load->view('../template_plain', $data);

        }

    }

    public function mentorDetail($innovationid = null, $id = null)
    {

        /***** For  Mentor ****/

        $title = "One-to-One Mentoring";

        $stageandservice = $this->Mmentor->getProgramstageandProgramservice($title);

        $data['pstage'] = $stageandservice['id'];

        $data['pservice'] = $stageandservice['program_service_offering'];

        /*** End ***/

        $data['statusArr'] = statusArr();

        $data['cpagetitle'] = "Mentor Request Information";

        $data['statusarr'] = statusArr();

        $data['pubarr'] = publishArr();

        if ($id != '') {

            $data['mentorDetails'] = $this->Mmentor->getmentorDetails($id);

            $data['id'] = $id;

        }

        $applicantList = array();

        $assignmentorList = $this->Mmentor->getmentorList($innovationid, $id);

        foreach ($assignmentorList as $key => $value) {

            if ($assignmentorList[$key]['company'] != 'outside') {

                $empid = $this->Mmentor->Villgroemp($value['mentor_id']);

                $hour = $this->hour($innovationid, $empid);

                $assignmentorList[$key]['mentorhours'] = $hour;

                $money = $this->money($innovationid, $empid, $hour);

                $assignmentorList[$key]['mentormoney'] = $money;

            }

        }

        $data['assignmentorList'] = $assignmentorList;

        $data['innovationid'] = $innovationid;

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $data['isAbi'] = $isAbi = false;

        if (in_array($this->session->userdata('user_type'), array('abi'))) {

            $data['isAbi'] = $isAbi = true;

        }

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['left_box'] = array('incubation');

            $data['isincubAuth'] = true;

        } else {

            $data['left_box'] = array('incubation', 'innovation_tab');

            $data['isincubAuth'] = false;

        }

        $data['cpage'] = "mentorDetail";

        $this->load->vars($data);

        $this->load->view('../template');

    }

    public function hour($innovationid, $empid)
    {

        $noDays = array();

        $noDays = $this->Mmentor->calculateMentoringhours($innovationid, $empid);

        $employee_id = $noDays[0]['employee_id'];

        $mentorhours = $noDays[0]['totalhour'];

        if ($mentorhours != '' || $mentorhours != 0) {

            return $mentorhours;

        }

        return 0;

    }

    public function money($innovationid, $empid, $mentorhours)
    {

        $mworkday = $this->Mmentor->calculateWorkingDaysInMonth();

        $basicSalary = $this->Mmentor->calculatebasicSalary($empid);

        if (!empty($basicSalary)) {

            $basicsalary = $basicSalary[0]['basicsalary'];

        } else {
            $basicsalary = 0;
        }

        $money = $this->Mmentor->calculateCostperhour($basicsalary, $mworkday, $mentorhours);

        if ($money != '' || $money != '0') {

            return $money;

        }

        return 0;

    }

    public function suggestMentor($innovationid = null, $id = null)
    {

        $data['sectorar'] = sectorArray();

        $emplist = $this->Mmentor->emplist();

        $data['emplist'] = $emplist;

        $options = array();

        $options = $_POST;

        $searchmember = array();

        $data['ordertype'] = $this->input->post('ordertype');

        $data['orderby'] = $this->input->post('orderby');

        $assigndata = $this->Mmentor->assignedBoardmember($innovationid);

        $assign = array();

        foreach ($assigndata as $value) {

            $assign[] = $value['mentor_id'];

        }

        $data['assign'] = $assign;

        $searchmember = $this->Mmentor->searchMentor($options);

        $data['searchmember'] = $searchmember;

        /*** This all information to check whether user is incubateee or not ***/

        $data['isincubAuth'] = false;

        $incubatsession = $this->session->userdata('is_incubatee');

        $data['innovationid'] = $innovationid;

        $data['cpagetitle'] = "Suggest Mentor";

        $data['id'] = $id;

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['left_box'] = array('incubation');

            $data['isincubAuth'] = true;

        } else {

            $data['left_box'] = array('incubation', 'innovation_tab');

            $data['isincubAuth'] = true;

        }

        $data['cpage'] = "suggestmentor";

        $this->load->vars($data);

        $this->load->view('../template');

    }

    public function meeting($innovationid, $id)
    {

        $data['cpage'] = "mentorMeeting";

        $data['cpagetitle'] = "Mentor Meeting";

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');

        } else {

            $data['left_box'] = array('innovation_tab');

        }

        $this->load->vars($data);

        $this->load->view('../template');

    }

    public function changevillgrostatus($status = null, $innovationid = null, $id = null, $requestid = null, $mentorid = null)
    {

        if ($status == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $this->Mmentor->updatevillgrostatus($options);

                $id = $_POST['mentorid'];

                redirect('mentor/mentorDetail/' . $innovationid . '/' . $id);

            }

            $data['cpagetitle'] = "Approve Request";

            $data['innovationid'] = $innovationid;

            $data['requestid'] = $requestid;

            $data['mentorid'] = $mentorid;

            $data['id'] = $id;

            $data['cpage'] = "approveRequest";

            $this->load->view('../template_plain', $data);

        } else {

            if (isset($_POST['rejectSubmit'])) {

                $options = array();

                $options = $_POST;

                $this->Mmentor->updatevillgrostatus($options);

                $id = $_POST['detailid'];

                redirect('mentor/mentorDetail/' . $innovationid . '/' . $id);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['requestid'] = $requestid;

            $data['mentorid'] = $mentorid;

            $data['id'] = $id;

            $data['cpage'] = "rejectRequest";

            $this->load->view('../template_plain', $data);

        }

    }

    public function suggestSubmit($innovationid = null, $id = null)
    {
        if (isset($_POST['txtSubmit'])) {

            $suggest = array();

            foreach ($_POST['check'] as $key => $value) {

                $suggest[] = $value;

            }

        }

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $company = $_POST['company'];

        $suggestmember = $this->Mmentor->insertSuggestMentor($innovationid, $id, $suggest, $company);

        redirect('mentor/mentorDetail/' . $innovationid . '/' . $id);

    }

    public function doupload($options)
    {

        if ($_FILES['filedoc']['name'] != '') {

            $filename = $_FILES['filedoc']['name'];

            $_FILES['ty']['name'] = $_FILES['filedoc']['name'];

            $_FILES['ty']['tmp_name'] = $_FILES['filedoc']['tmp_name'];

            $_FILES['ty']['size'] = $_FILES['filedoc']['size'];

            $_FILES['ty']['error'] = $_FILES['filedoc']['error'];

            $_FILES['ty']['type'] = $_FILES['filedoc']['type'];

            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $filename);

            $config['upload_path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/businessdoc/';

            $config['allowed_types'] = '*';

            $config['file_name'] = $filename;

            $this->load->library('upload', $config);

            $this->upload->do_upload('ty');

        }

    }

    public function mastermentorDetail($mentorid = null, $company)
    {

        $data['company'] = $company;

        $data['mentortotaldetail'] = $mentortotaldetail = $this->Mmentor->mastermentorDetail($mentorid, $company);

        $data['cpage'] = "mastermentordetail";

        $data['cpagetitle'] = "Mentor Detail";

        $this->load->vars($data);

        $this->load->view('../template_plain', $data);

    }

    public function requestDoc($innovationid = null, $id = null)
    {

        if (isset($_POST['txtSubmit'])) {

            $options = array();

            $options = $_POST;

            $this->Minvester->assignChecklist($options);

            $this->session->set_flashdata('successMsg', 'Checklist Assigned Successfully!');

            redirect('invester/investerDetail/' . $innovationid . '/' . $id);

        }

        $data['innovationid'] = $innovationid;

        $data['id'] = $id;

        $masterType = 'Invester Document';

        $data['cpagetitle'] = "Request Document";

        $document = $this->Mmaster_settings->getMasterSetting($masterType);

        $data['document'] = $document;

        $data['cpage'] = "requestdocument";

        $this->load->view('../template_plain', $data);

    }

    public function actionHistory($investerid = null)
    {

        $data['historylist'] = $this->Minvester->getactionHistory($investerid);

        $data['cpagetitle'] = "Action History";

        $data['cpage'] = "actionHistory";

        $data['stage'] = $this->Minvester->statusArr();

        $this->load->view('../template_plain', $data);

    }

}
