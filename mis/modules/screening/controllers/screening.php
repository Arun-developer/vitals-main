<?php

class Screening extends CI_Controller {

    public function __construct() {

        parent::__construct();

        date_default_timezone_set("Asia/Calcutta");

        $this->load->model('master/Sector_model');

        $this->template = '../template';

        $this->load->model('scouting/Minnovation');

        $this->load->model('master/Mmaster_settings');

        $this->load->model('master/Mchecklist');

        $this->load->model('master/Mprogram_stage');

        $this->load->model('activities/Mactivities');

        $this->load->model('master/Mscreening_master');

        $this->load->model('master/Mmeans_validation');

        $this->load->model('Mscreening');

        $this->load->model('Mcompany');

        $this->load->model('Minvitation');

        $this->load->model('Mscreening_validation');

        $this->load->model('Mscreening_comments');

        $this->load->model('Mpreic');

        $this->load->model('Mscreening_documents');

        $this->load->model('Mnda');

        $this->load->model('Magreement');

        $this->load->model('common/Minnovation_mail');
    }

    public function allow($invite_code) {

        if ($this->Mauth->isLogged()) {

            if (!empty($invite_code) && php72_count($this->Minnovation->getInnovationDetails($invite_code))) {

                return $invite_code;
            }
        }

        $data['invite_code'] = $invite_code;

        if ($invite_code == null) {
            echo "You are Allowed!";
        }

        $invitation = $this->Minvitation->getInvitationByCode($invite_code);

        if (php72_count($invitation)) {
            if ($invitation['0']['status'] == '1') {
                return $invitation['0']['innovation'];
            } else {
                echo "The Application Form is Blocked by Admin";
            }
        } else {
            echo "Invalid URL";
        }

        exit;
    }

    public function ic_confirm($id) {

        $data['id'] = $id;

        if (isset($_POST['txtSubmit'])) {
            if ($_POST['decision'] != '') {
                $_POST['filename'] = $_FILES['document']['name'];

                $this->Mscreening->addic($_POST, $id);

                $this->session->set_flashdata('successMsg', 'IC status Successfully Updated!');

                redirect('login/detailed_diligence/' . $id);
            }
            redirect('login/detailed_diligence/' . $id);
        }

        $data['cpage'] = 'ic_confirm';

        $data['cpagetitle'] = 'Add Minutes of IC';

        $this->load->view('../template', $data);
    }

    public function accept($id = '') {

        $id = $this->allow($id);

        $data['innovation'] = $id;

        $this->Minnovation->updateAcceptStatus('1', $id);

        redirect('screening/form/' . $this->uri->segment('3'));
    }

    public function updateCompletedStatus($id = '') {
        $id = $this->allow($id);

        $data['innovation'] = $id;

        $this->Minnovation->updateAcceptStatus('1', $id);

        return true;
    }

    public function form($code = '', $criteria = '11', $option = '') {

        $id = $this->allow($code);

        $innovation = $this->Minnovation->getInnovation($id);

        if (!php72_count($innovation) || $id == '') {
            show_error('Page not Found');
        }

        #check NDA acceptance

        $template = '../template';

        if (!$this->Mauth->isLogged()) {

            $ndaList = $this->Mnda->getNdaListPending($id);

            $template = '../template';

            if (php72_count($ndaList) && $innovation['accept_status'] == '0') {

                redirect('screening/nda_list/' . $code);
            }
        }

        #form values add or update

        if (isset($_POST['txtSubmit'])) {

            if (php72_count($_FILES) > 0) {

                $this->makePost($innovation['name_of_enterprise']);
            }

            foreach ($_FILES as $key => $filerow) {

                if (!empty($_FILES[$key]['name'])) {

                    $config['upload_path'] = base_url() . 'uploads/innovaton/supporting_documents';

                    $config['allowed_types'] = '*';

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload($key)) {

                        $error = array('error' => $this->upload->display_errors());
                    } else {

                        echo "success";
                    }
                }

                if (!empty($_POST['olddocument_' . $key])) {

                    $_POST[$key] = $_POST['olddocument_' . $key];
                } else {

                    $_POST[$key] = $_FILES[$key]['name'];
                }
            }

            $this->Mscreening->insert($_POST);

            $this->session->set_flashdata('successMsg', 'Details Added Successfully!');

            redirect('screening/form/' . $code . '/' . $criteria);
        }

        $data = array();

        $data['code'] = $code;

        $data['criteria'] = $criteria;

        $data['innovation'] = $innovation;

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        if ($this->Mscreening->checkDuplicate($id, $data['criteria'])) {

            $data['fieldsList'] = $this->Mscreening_master->getFiledsList($criteria);

            $isView = false;
        } else {

            $data['listingType'] = $this->Mscreening->getTemplateType($id);

            foreach ($data['listingType'] as $row) {

                $row['id'];

                $row['listing_type'];

                if ($row['listing_type'] == "showPersonal") {

                    $data['fieldsList'] = $this->Mscreening->getFiledsByPerticularIncubatee($id, $criteria);
                }
            }

            $data['fieldsList'] = $this->Mscreening->getFiledsAnswerList($id, $criteria);

            $isView = true;
        }

        if ($option == 'edit') {

            $isView = false;
        }

        $data['isView'] = $isView;

        if ($this->input->post('statusValue')) {

            $isView = $this->input->post('isView');

            $status = $this->input->post("statusValue");

            $name_enterprenur = $this->input->post("name_enterprenur");

            $this->Mscreening->updateStatusIncubatee($name_enterprenur, $status);

            $isView = true;
        }

        $data['screeningValidation'] = $this->Mscreening_validation->getScreeningValidation($id, $criteria);

        $data['assessComments'] = $this->Mscreening_comments->getScreeningComments($id, $criteria);

        $data['cpagetitle'] = "Screening Application";

        if ($isView) {
            $data['cpage'] = "view_details";
        } else {
            $data['cpage'] = "form";
        }

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function download() {

        $this->load->helper('download');

        $name = 'Rahul_Enterprises_screening_SiteVisitSchedule_Biosense.xls';

        $path = base_url() . 'uploads/screening/' . $name;

        $data = file_get_contents($path); // Read the file's contents

        force_download($name, $data);
    }

    public function assessform($id = '', $masterId, $criteria = '11', $pid = '') {

        $innovationInfo = $this->Minnovation->getInnovation($id);

        $template = '../template';

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $data['fileDetails'] = $this->Mscreening->getDocsByCriteria($id, $criteria);

        if (isset($_POST['txtSubmit'])) {

            if (php72_count($_FILES) > 0) {

                $this->makeAssessmentFilePost($innovationInfo['name_of_enterprise']);
            }

            $_POST['fileName'] = $_FILES['document']['name'];

            if ($masterId == "m1") {
                $master = "Document to Produce";
            }

            $this->Mscreening->insertDetails($id, $master, $criteria, $_POST);

            $this->session->set_flashdata('successMsg', 'Details Added Successfully!');

            redirect('screening/assessform/' . $id . '/m1/' . $criteria);
        }

        $data['innovation'] = $id;

        $data['criteria'] = $criteria;

        $data['pid'] = $pid;

        $data['fieldsList'] = $this->Mscreening->getAssessmentListBYCriteria($criteria);

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $data['innovationInfo'] = $innovationInfo;

        $data['cpagetitle'] = "Detailed Assessment";

        $data['cpage'] = "assessform";

        $this->load->vars($data);

        $this->load->view($template);
    }

    //for uploading files and makeing post values

    public function makeAssessmentFilePost($innovation_name = '') {

        foreach ($_FILES['document']['name'] as $key => $value):

            if ($_FILES['document']['name'] != '') {

                $filename = $_FILES['document']['name'][$key];

                $_FILES['ty']['name'] = $_FILES['document']['name'][$key];

                $_FILES['ty']['tmp_name'] = $_FILES['document']['tmp_name'][$key];

                $_FILES['ty']['size'] = $_FILES['document']['size'][$key];

                $_FILES['ty']['error'] = $_FILES['document']['error'][$key];

                $_FILES['ty']['type'] = $_FILES['document']['type'][$key];

                $config['upload_path'] = './uploads/screening/assesment/produce';

                $config['allowed_types'] = '*';

                $config['file_name'] = $filename;

                $this->load->library('upload');

                $this->upload->initialize($config);

                $data['success_msg'] = $this->upload->do_upload('ty'); //exit
            }

        endforeach;
    }

    public function docsto_produce($innovation, $masterId, $criteria) {

        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        if (isset($_POST['txtDocSubmit'])) {

            if (php72_count($_FILES) > 0) {

                $this->makeDocsProducePost($innovationInfo['name_of_enterprise']);
            }

            $_POST['docToProduce'] = $_FILES['docToProduce']['name'];

            $this->Mscreening->insertproducedDocs($innovation, $masterId, $criteria, $_POST);

            $this->session->set_flashdata('successMsg', 'Document uploaded Successfully!');

            redirect('screening/assessform/' . $innovation . '/' . $masterId . '/' . $criteria . '/');
        }
    }

    public function postverifications_comments() {

        $id = $this->input->post("id");

        $innovation = $this->input->post("innovation");

        $ajaxComments = $this->input->post("txtcomments");

        $user = $this->session->userdata("user_name");

        $this->Mscreening->insertdocsVerificationComments($id, $innovation, $ajaxComments, $user);
    }

    public function upload_docs($innovation, $criteria, $subfield, $fieldID, $id) {

        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        if (isset($_POST['txtFileSubmit'])) {

            if (php72_count($_FILES) > 0) {

                $_POST['uploaddocs'] = $_FILES['uploadDocs']['name'];

                $config['upload_path'] = './uploads/screening/assessment';

                $config['allowed_types'] = '*';

                $this->load->library('upload', $config);

                foreach ($_FILES as $key => $filerow) {

                    if (!empty($_FILES[$key]['name'])) {
                        $_POST[$key] = $_FILES[$key]['name'];
                    } else if (!empty($_POST['olddocument_' . $key . ''])) {
                        $_POST[$key] = $_POST['olddocument_' . $key . ''];
                    }

                    if (!empty($_FILES[$key]['name'])) {

                        if (!$this->upload->do_upload($key)) {

                            $error = array('error' => $this->upload->display_errors());
                        }
                    }
                }
            }

            $this->Mscreening->insertSiteVisitDocs($_POST);

            $this->session->set_flashdata('successMsg', 'Document uploaded Successfully!');

            redirect('screening/peoplemeet/' . $innovation . '/' . $criteria . '/' . $subfield . '/' . $fieldID . '/');
        }

        $data['innovation'] = $innovation;

        $data['criteria'] = $criteria;

        $data['subfield'] = $subfield;

        $data['id'] = $id;

        $data['rowID'] = $fieldID;

        $data['cpagetitle'] = "Upload Document";

        $data['cpage'] = "upload_peopledocs";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    public function docverifyform($id = '', $masterID, $criteria = '11') {

        $template = '../template';

        $data['fileDetails'] = $this->Mscreening->getDocumentsByInnovation($id);

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $data['cpagetitle'] = "Assessment";

        $data['cpage'] = "docverifyform";

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function peoplemeet() {

        $template = '../template';

        $innovation = $this->uri->segment("3");

        $data['innovation'] = $innovation;

        $criteria = $this->uri->segment("4");

        $subcriteria = $this->uri->segment("5");

        $field = $this->uri->segment("6");

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $data['peopleDetails'] = $this->Mscreening->getConnectingPeopleDetails($innovation, $subcriteria, $field);

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $data['cpagetitle'] = "Assessment-";

        $data['cpage'] = "people_view";

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function comments() {

        $innovation = $this->input->post('innovation');

        $masterType = $this->input->post('master_type');

        $criteria = $this->input->post('criteria');

        $subcriteria = $this->input->post('subcriteria');

        $userName = $this->session->userdata('user_name');

        $comments = $_POST['comment'];

        $htm = "";

        if ($comments != "") {

            $data = $this->Mscreening->insertComments($innovation, $masterType, $criteria, $subcriteria, $comments, $userName);

            $counter = 1;

            $htm .= '<table class="new_comment_table" id="new_comment_table' . $counter . '" align="center">';

            foreach ($data as $row) {

                $htm .= '<tr class="new_comment_row" id="' . $counter . '">';

                $htm .= '<td class="new_comment_img" id="new_comment_img"><img src="no_notification.png" height="50" width="50"></td>';

                $htm .= '<td class="new_comment_text" id="new_comment_text"><b>Arvind : </b>' . $row['comments'];

                $htm .= '<br /><div class="comment_del_but" id="' . $counter . '" align="right""><a href="#">Delete</a></div>';

                $htm .= '</td>';

                $htm .= '</tr>';

                $counter++;
            }

            $htm .= '</table>';

            echo $htm;
        }
    }

    public function assessmentsubmit($innovation, $status) {

        if ($innovation) {

            $this->Mscreening->updateAssessmentStatus($innovation, $status);
        }

        redirect('screening/pre_ic/' . $innovation);
    }

    public function getSubcriteriDetails() {

        $criteria = $this->input->post("master_type");

        if ($this->input->post("master_type")) {

            $data['listBoxItem'] = $this->Mscreening->loadCriteriaDetails($criteria);

            echo json_encode($data['listBoxItem']);
            exit;
        }
    }

    public function getcompany($innovation) {

        $data['innovation'] = $innovation;

        $options = array();

        if (isset($_POST['txtbSubmit'])) {

            $this->Mcompany->insertBoard($_POST, $innovation);

            $this->session->set_flashdata('successMsg', 'Board Details saved Successfully');

            redirect('screening/view_boarddetails/' . $innovation);
        }

        if (isset($_POST['txtiSubmit'])) {

            $this->Mcompany->insertInvestment($_POST, $innovation);

            $this->session->set_flashdata('successMsg', 'Investment Details saved Successfully');

            redirect('screening/view_investdetails/' . $innovation);
        }

        if (isset($_POST['txtfSubmit'])) {

            $this->Mcompany->insertFinancial($_POST, $innovation);

            $this->session->set_flashdata('successMsg', 'Investment Details saved Successfully');

            redirect('screening/view_financial/' . $innovation);
        }

        #Loading View and data

        $data['boardList'] = $this->Mcompany->getBoardList($innovation);

        $data['natureSource'] = $this->Mmaster_settings->getMasterSetting('Nature Source');

        $data['investmentList'] = $this->Mcompany->getInvestmentList($innovation);

        $data['financialList'] = $this->Mcompany->getFinancialList($innovation);

        $data['cpagetitle'] = 'Financial,Board & Investor Details';

        $data['cpage'] = "company";

        if (!$this->Mauth->isLogged()) {

            $template = '../template_user';
        } else {
            $template = '../dashboard_template';
        }

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function getCompanyDetails($code) {

        $data['code'] = $code;

        $innovation = $this->allow($code);

        $data['innovation'] = $innovation;

        #Loading View and data

        $data['boardList'] = $this->Mcompany->getBoardList($innovation);

        $data['natureSource'] = $this->Mmaster_settings->getMasterSetting('Nature Source');

        $data['investmentList'] = $this->Mcompany->getInvestmentList($innovation);

        $data['financialList'] = $this->Mcompany->getFinancialList($innovation);

        $data['cpagetitle'] = "Board Details";

        $data['cpage'] = "company_view";

        if (!$this->Mauth->isLogged()) {

            $template = '../template_user';
        } else {
            $template = '../dashboard_template';
        }

        $this->load->view($template, $data);
    }

    public function view_boarddetails($innovation) {

        $data['innovation'] = $innovation;

        #Loading View and data

        $data['boardList'] = $this->Mcompany->getBoardList($innovation);

        $data['natureSource'] = $this->Mmaster_settings->getMasterSetting('Nature Source');

        $data['investmentList'] = $this->Mcompany->getInvestmentList($innovation);

        $data['cpagetitle'] = "Board Details";

        $data['cpage'] = "company_view";

        $this->load->view('../dashboard_template', $data);
    }

    public function view_investdetails($innovation) {

        $data['innovation'] = $innovation;

        #Loading View and data

        $data['boardList'] = $this->Mcompany->getBoardList($innovation);

        $data['natureSource'] = $this->Mmaster_settings->getMasterSetting('Nature Source');

        $data['investmentList'] = $this->Mcompany->getInvestmentList($innovation);

        $data['cpagetitle'] = "Investment Details";

        $data['cpage'] = "company_view";

        $this->load->view('../dashboard_template', $data);
    }

    public function view_financial($innovation) {

        $data['innovation'] = $innovation;

        $data['boardList'] = $this->Mcompany->getBoardList($innovation);

        $data['natureSource'] = $this->Mmaster_settings->getMasterSetting('Nature Source');

        $data['investmentList'] = $this->Mcompany->getInvestmentList($innovation);

        $data['financialList'] = $this->Mcompany->getFinancialList($innovation);

        $data['cpagetitle'] = "Financial Details";

        $data['cpage'] = "company_view";

        $this->load->view('../dashboard_template', $data);
    }

    public function incubateeform($innovation) {

        $template = '../template';

        if (isset($_POST['txtSubmit'])) {

            $this->Mscreening->insertIncubateeDetailsBYID($_POST, $innovation);

            $resultArray = $this->Mscreening->getIncubateeDetailsBY_Innovation($innovation);

            $incubateeusername = $_POST['username'];

            $incubateePasword = $_POST['userPassword'];

            $empID = $this->session->userdata("emp_number");

            $empMail = $this->Mscreening->getEmpEMailID($empID);

            $this->sendMail($empMail, $resultArray, $incubateeusername, $incubateePasword);

            $msg = "Details Sent Successfully!";

            $this->session->set_flashdata('successMsg', $msg);

            redirect('seedfunding/view/' . $innovation);
        }

        $data['innovation'] = $innovation;

        $data['cpagetitle'] = "Send Incubatee Details";

        $data['cpage'] = "screening/incubatee_details";

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function sendMail($empMail, $resultArray, $incubateeusername, $incubateePasword) {

        $fromMail = @$empMail['0']['emp_oth_email'];

        //

        $userName = $incubateeusername;

        $password = $incubateePasword;

        $messageBody = '<html><body>

        <div style="color:black;">Your Username is :<span style="color:green;">' . $userName . '</span><br>Your Password is : <span style="color:green;">' . $password . '

        </span></div><br><span style="color:black;font-weight:bold;">Please login to Fill your Application Form.</span><br> Thank You

        </body></html>';

        $toEmail = $resultArray['0']['email_id'];

        $messageSubject = "Login Information";

        $this->load->library('email');

        $this->email->clear(true);

        $this->email->set_newline("\r\n");

        $this->email->from($fromMail, "Incubatee");

        $this->email->to($toEmail);

        $this->email->subject($messageSubject);

        $this->email->message($messageBody);

        $this->email->send();
    }

    public function peopleform($innovation) {

        $template = '../template';

        $data['subCriteriaDetails'] = $this->Mscreening->getSubCriteriaDetails();

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        if (isset($_POST['txtsiteSubmit'])) {

            $count = php72_count($_POST['criteria']);
            $result = $this->Mscreening->insertSiteVisit($_POST, $innovation);

            $msg = "Records inserted!";

            $this->session->set_flashdata('successMsg', $msg);

            redirect('screening/peoplemeet/' . $innovation . '/m3/' . $_POST['criteria'][$count - 1] . '/' . $_POST['subcriteria'][$count - 1] . '/' . $_POST['category'][$count - 1]);
        }

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $data['peopleDetails'] = $this->Mscreening->getReportsInfo($innovation);

        $data['innovation'] = $innovation;

        $data['cpagetitle'] = "Add External Validation";

        $data['cpage'] = "screening/addField";

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function externaldelete() {

        $innovation = $this->input->post("Id");

        $this->Mscreening->externalDelete($innovation);

        $this->session->set_flashdata('successMsg', 'Row deleted Successfully');

        redirect('screening/peopleform/' . $innovation);
    }

    public function changestatus($innovation, $criteria, $subfield, $id = '', $status = '') {

        if ($id != '' && $status != '') {

            $options = array('id' => $id, 'status' => $status);

            $this->Mscreening->changeStatus($options);

            $this->session->set_flashdata('successMsg', 'Field Status updated');

            redirect('screening/peoplemeet/' . $innovation . '/' . $criteria . '/' . $subfield . '/');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }
    }

    public function delete($innovation, $criteria, $subfield, $id = '') {

        if ($id != '') {

            $result = $this->Mscreening->delete($id);

            if (!empty($result)) {

                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Field deleted Success fully');
            }

            redirect('screening/peoplemeet/' . $innovation . '/' . $criteria . '/' . $subfield . '/');
        } else {

            $this->session->set_flashdata('successMsg', 'Value Missing');
        }
    }

    #validation check list to open assessment

    public function validation($id = '', $criteria = '11') {

        if (isset($_POST['txtSubmit'])) {

            $this->Mscreening_validation->insertValidation($_POST);

            $this->session->set_flashdata('successMsg', 'Means of Validation Updated Successfully!');

            redirect('screening/form/' . $id . '/' . $criteria);
        }

        $data['innovation'] = $id;

        $data['criteria'] = $criteria;

        $data['validationList'] = $this->Mscreening_validation->getScreeningValidation($id, $criteria);

        $data['cpagetitle'] = "Means of Validation";

        $data['cpage'] = "validation";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    public function view_validation($id = '', $criteria = '11') {

        $data['innovation'] = $id;

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $data['cpagetitle'] = "Means of Validation";

        $data['cpage'] = "view_validation";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    //check list documents

    public function assign_checklist($innovation) {

        if (isset($_POST['txtSubmit'])) {

            $this->Mscreening_documents->assignChecklist($_POST);

            $this->session->set_flashdata('successMsg', 'Checklist Assigned Successfully!');

            redirect('screening/documents/' . $innovation);
        }

        $data['innovationChecklist'] = $this->Mscreening_documents->getAssignedChecklist($innovation);

        $data['innovation'] = $innovation;

        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        $data['checkList'] = $this->Mchecklist->getCheckList();

        $data['cpagetitle'] = "Documents Master List";

        $data['cpage'] = "assign_checklist";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    public function view_checklist($innovation) {

        $data['innovationChecklist'] = $this->Mscreening_documents->getAssignedChecklist($innovation);

        $data['checkList'] = $this->Mscreening_documents->getInnovationCheckListView($innovation);

        $data['innovation'] = $innovation;

        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        $data['cpagetitle'] = "Documents Checklist";

        $data['cpage'] = "view_checklist";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    public function view_peoplelist($innovation) {

        $data['assessmentList'] = $this->Mscreening->getPeopleByInnovation($innovation);

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $data['innovation'] = $innovation;

        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $data['cpagetitle'] = "People to Meetlist";

        $data['cpage'] = "people_to_meet";

        $this->load->vars($data);

        $this->load->view('./template');
    }

    public function getassessment_comments($innovation) {

        $data['commentsList'] = $this->Mscreening->getCommentsByInnovation($innovation);

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $data['innovation'] = $innovation;

        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        $data['cpagetitle'] = "Comments Lis";

        $data['cpage'] = "assessment_comments_list";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    public function documents($code) {

        $data['code'] = $code;

        $id = $this->allow($code);

        $data['innovation'] = $this->Minnovation->getInnovation($id);

        $data['name_of_enterprise'] = $data['innovation']['name_of_enterprise'];

        if (isset($_POST['txtSubmit'])) {

            if (php72_count($_FILES) > 0) {

                $code = $_POST['innovation'];

                $id = $this->allow($_POST['innovation']);

                $data1['innovation'] = $this->Minnovation->getInnovation($id);

                $data1['name_of_enterprise'] = $data1['innovation']['name_of_enterprise'];

                $config['upload_path'] = './uploads/screening';

                $config['allowed_types'] = '*';

                $this->load->library('upload', $config);

                foreach ($_FILES as $key => $filerow) {

                    if (!empty($_FILES[$key]['name'])) {
                        $_POST[$key] = $_FILES[$key]['name'];
                    } else if (!empty($_POST['olddocument_' . $key . ''])) {
                        $_POST[$key] = $_POST['olddocument_' . $key . ''];
                    }

                    if (!empty($_FILES[$key]['name'])) {

                        if (!$this->upload->do_upload($key)) {

                            $error = array('error' => $this->upload->display_errors());
                        }
                    }
                }

                $this->Mscreening_documents->insertDocuments($id, $_POST);
            }

            if (!$this->Mauth->isLogged()) {

                if ($data['innovation']['accept_status'] != '1') {

                    $result = $this->updateCompletedStatus($code);
                }
            }

            $this->session->set_flashdata('successMsg', 'Documents Added Successfully!');

            redirect('screening/documents/' . $_POST['innovation']);
        }

        $data['criteria'] = '';

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $data['innovationChecklist'] = $this->Mscreening_documents->getAssignedChecklist($id);

        $data['checkList'] = $this->Mscreening_documents->getInnovationCheckList($id, $data['innovationChecklist']);

        $data['cpagetitle'] = "Innovator Info";

        $data['cpage'] = "documents_list";

        if (!$this->Mauth->isLogged()) {

            $template = '../template';
        } else {
            $template = '../template';
        }

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function docupload() {

        $this->load->library('upload');

        $config['upload_path'] = './uploads/screening';

        $config['allowed_types'] = '*';

        $this->upload->initialize($config);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("docToProduce")) {

            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        } else {

            $data = array('upload_data' => $this->upload->data());

            $this->load->view('upload_success', $data);
        }
    }

    public function uploadprofile($innovationID, $criteria) {

        $innovation = $this->input->post("innovation");

        $this->load->library('upload');

        $config['upload_path'] = './uploads/screening';

        $config['allowed_types'] = 'gif|jpg|png';

        $this->upload->initialize($config);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("uploadProfilePics")) {

            $data['upload_error'] = $this->upload->display_errors();

            $this->session->set_flashdata('errorMsg', 'The filetype you are attempting to upload is not allowed!');
        } else {
            $data = $this->Mscreening->insertProfileDocsDetails($innovation, $_FILES);

            $data['upload_error'] = $this->upload->data();
        }

        redirect('screening/form/' . $innovation . '/' . $criteria);
    }

    public function makeSiteSchedulePost($innovation_name = '') {

        foreach ($_FILES as $key => $fileRow):

            $_POST[$key] = '';

            $this->load->library('upload');

            if ($_FILES[$key]['name'] != '') {

                $config['upload_path'] = './uploads/screening/assesment/site_visit';

                $config['allowed_types'] = '*';

                $config['file_name'] = str_replace(' ', '_', $innovation_name) . "_screening_" . str_replace(' ', '_', $_FILES[$key]['name']);

                rand() . "_" . $_FILES[$key]['name'];

                $this->upload->initialize($config);

                if (!$this->upload->do_upload($key)) {
                    $data['upload_error'] = $this->upload->display_errors();
                } else {

                    $upload_data = $this->upload->data();

                    $_POST[$key] = $_FILES[$key]['file_name'];
                }
            }

            unset($config);

        endforeach;
    }

    public function makeDocsProducePost($innovation_name = '') {
        foreach ($_FILES as $key => $fileRow):

            $_POST[$key] = '';

            $this->load->library('upload');

            if ($_FILES[$key]['name'] != '') {

                $config['upload_path'] = './uploads/screening/assesment/produce';

                $config['allowed_types'] = '*';

                $config['file_name'] = str_replace(' ', '_', $innovation_name) . "_screening_" . str_replace(' ', '_', $_FILES[$key]['name']);

                rand() . "_" . $_FILES[$key]['name'];

                $this->upload->initialize($config);

                if (!$this->upload->do_upload($key)) {
                    $data['upload_error'] = $this->upload->display_errors();
                } else {

                    $upload_data = $this->upload->data();

                    $_POST[$key] = $upload_data['file_name'];
                }
            }

            unset($config);

        endforeach;
    }

    //for uploading files and makeing post values

    public function makePost($innovation_name = '') {

        foreach ($_FILES as $key => $fileRow):

            $_POST[$key] = '';

            $this->load->library('upload');

            if ($_FILES[$key]['name'] != '') {

                $config['upload_path'] = './uploads/screening/assesment/produce';

                $config['allowed_types'] = '*';

                $config['file_name'] = str_replace(' ', '_', $innovation_name) . "_screening_" . str_replace(' ', '_', $_FILES[$key]['name']);

                rand() . "_" . $_FILES[$key]['name'];

                $this->upload->initialize($config);

                if (!$this->upload->do_upload($key)) {
                    $data['upload_error'] = $this->upload->display_errors();
                } else {

                    $upload_data = $this->upload->data();

                    $_POST[$key] = $config['file_name'];
                }
            }

            unset($config);

        endforeach;
    }

    //ajax subfield

    public function ajax_subfield($option = '') {

        $innovation = $this->input->post('innovation');

        $criteria = $this->input->post('criteria');

        $pid = $this->input->post('pid');

        $parent_value = $this->input->post('parent_value');

        $this->Mscreening->ajaxForm($innovation, $criteria, $pid, $parent_value, $option);
    }

    #adding comments

    public function add_comments($id, $criteria) {

        if ($this->input->post('txtSubmit') != '') {

            $this->Mscreening_comments->insertComments($id, $criteria, $_POST);

            $this->session->set_flashdata('successMsg', 'Comments added Successfully!');

            redirect('screening/form/' . $id . '/' . $criteria);
        }
    }

    public function delete_comments($id, $criteria, $comment_id = '') {

        if ($comment_id != '') {

            $this->Mscreening_comments->deleteComments($comment_id);

            $this->session->set_flashdata('successMsg', 'Record Deleted Successfully!');
        }

        redirect('screening/form/' . $id . '/' . $criteria);
    }

    public function create_docuemnt($id, $save = false) {

        $data['innovation'] = $id;

        $innovationInfo = $this->Minnovation->getInnovation($id);

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $data['innovationInfo'] = $innovationInfo;

        $data['cpagetitle'] = "Screening Information";

        $data['cpage'] = 'create_document';

        $word = $this->load->view('create_document', $data, true);

        if ($save) {

            $path = 'uploads/' . str_replace(' ', '_', $innovationInfo['name_of_enterprise']) . '-Screening_details.doc';

            $fh = fopen($path, 'w+');

            fwrite($fh, $word);

            fclose($fh);
        } else {

            header("Content-type: application/vnd.ms-word");

            header("Content-Disposition: attachment;Filename=assessment_details.doc");

            echo $word;
        }
    }

    #pre-incubation

    public function send_pre_ic($id) {

        $this->create_docuemnt($id, true);

        if (isset($_POST['txtSubmit'])) {
            $innovation = $this->Minnovation->getInnovation($id);

            if (php72_count($_FILES) > 0) {

                $this->makePost($innovation['name_of_enterprise']);
            }

            if ($_POST['send'] == 'send') {
                $this->Mpreic->sendPreIC($_POST);
            } else {
                $this->Mpreic->resendPreIC($_POST);
            }
        }

        $this->session->set_flashdata('successMsg', 'Mail Sent Successfully!');

        redirect('screening/pre_ic/' . $id);
    }

    public function pre_ic($id = '') {

        #innovation details

        $innovation = $data['innovation'] = $this->Minnovation->getInnovation($id);

        #create document

        $this->create_docuemnt($id, true);

        $data['document'] = str_replace(' ', '_', $innovation['name_of_enterprise']) . '-Screening_details.doc';

        #mail info

        $data['userSetup'] = $this->Mmaster->getUserSetup();

        $this->load->model('master/Mmailtemplate');

        $data['mailTemplate'] = $this->Mmailtemplate->getMailtemplate('Pre - IC');

        $data['sentInfo'] = $this->Mpreic->getSentMail($id);

        #comments info

        $data['preIcComments'] = $this->Mpreic->getPreIcComments($id);

        #page

        $data['cpagetitle'] = "Incubation Committie";

        $data['cpage'] = "pre_ic";

        $data['left_box'] = array('screening', 'innovation_tab');

        $this->load->vars($data);

        $this->load->view('../template');
    }

    public function add_preiccomments($id) {
        if ($this->input->post('txtSubmit') != '') {

            $this->Mpreic->insertPreIcComments($_POST);

            $this->session->set_flashdata('successMsg', 'Comments added Successfully!');
        }

        redirect('screening/pre_ic/' . $id);
    }

    public function delete_preiccomments($id, $comment_id = '') {

        if ($comment_id != '') {

            $this->Mpreic->deletePreIcComments($comment_id);

            $this->session->set_flashdata('successMsg', 'Record Deleted Successfully!');
        }

        redirect('screening/pre_ic/' . $id);
    }

    public function send_incubation_plan($innovation) {

        $attachment = array();

        $this->create_docuemnt($innovation, true);

        $this->Minnovation_mail->send_incubation_plan($innovation);

        $this->Minnovation->updateIncubationPlan($innovation);

        $this->session->set_flashdata('successMsg', 'Mail Sent Successfully!');

        redirect('seedfunding/activities/view_list/' . $innovation);
    }

    public function pre_ic_action($status, $id) {

        $this->Minnovation->updatePreIcStatus($status, $id);

        $this->session->set_flashdata('successMsg', 'Status Updated Successfully!');

        redirect('seedfunding/activities/view_list/' . $id);
    }

    #Agreement

    public function update_agreement($innovation) {

        if (isset($_POST['txtSubmit'])) {

            $this->Magreement->updateAgreement($_POST);

            $this->session->set_flashdata('successMsg', 'Agreement Updated Successfully!');

            redirect('screening/agreement/' . $innovation);
        }

        $data['innovationAgreement'] = $this->Magreement->getInnovationAgreement($innovation);

        $data['innovation'] = $innovation;

        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        $data['cpagetitle'] = "Update Agreement";

        $data['cpage'] = "update_agreement";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    public function createagreement($innovation, $save = false) {

        $data['innovation'] = $innovation;

        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        $data['agreement'] = $this->Magreement->getInnovationAgreement($innovation);

        $data['cpagetitle'] = "Screening Information";

        $data['cpage'] = 'create_agreement';

        $word = $this->load->view('create_agreement', $data, true);

        if ($save) {

            $path = 'uploads/agreement' . str_replace(' ', '_', $innovationInfo['name_of_enterprise']) . '-Agreement_signed_final_copy.doc';

            $fh = fopen($path, 'w+');

            fwrite($fh, $word);

            fclose($fh);
        } else {

            header("Content-type: application/vnd.ms-word");

            header("Content-Disposition: attachment;Filename=Agreement_signed_copy.doc");

            echo $word;
        }
    }

    public function agreementhistory($innovation) {

        $data['actionhistory'] = $this->Magreement->getactionhistory($innovation);

        $data['cpage'] = 'agreementhistory';

        $data['cpagetitle'] = 'Agreement Pre History';

        $this->load->view('../template_plain', $data);
    }

    public function showagreement($id) {

        $data['showagreement'] = $this->Magreement->showagreement($id);

        $data['cpage'] = 'showagreement';

        $data['cpagetitle'] = 'Agreement';

        $this->load->view('../template_plain', $data);
    }

    public function agreement($code) {

        $data['code'] = $code;

        $id = $this->allow($code);

        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($id);

        if (isset($_POST['txtSubmit'])) {

            if (php72_count($_FILES) > 0) {

                $this->makePost($innovationInfo['name_of_enterprise']);
            }

            $this->Magreement->insertDocuments($_POST);

            $this->session->set_flashdata('successMsg', 'Documents Added Successfully!');

            redirect('screening/documents/' . $code);
        }

        $data['criteria'] = '';

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $data['agreementComments'] = $this->Magreement->getAgreementComments($id);

        if ($this->Magreement->checkDuplicateAgreement($id)) {

            $this->load->model('master/Mmailtemplate');

            $agreement = $this->Mmailtemplate->getMailtemplate('Agreement');

            $this->Magreement->insertAgreement($id, $agreement['0']['body']);
        }

        $data['innovationAgreement'] = $this->Magreement->getInnovationAgreement($id);

        $data['cpagetitle'] = "Screening Application";

        $data['cpage'] = "aggrement";

        if (!$this->Mauth->isLogged()) {

            $template = '../template_user';
        } else {

            $template = '../template';
        }

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function accept_agreement($code) {

        $id = $this->allow($code);

        $this->Magreement->updateAgreementStatus($id);

        $this->Minnovation->updateAgreement('1', $id);

        $this->session->set_flashdata('successMsg', 'Agreement Accepted!');

        redirect('screening/agreement/' . $code);
    }

    public function agreement_signed($code, $type = 'copy1') {

        $id = $this->allow($code);

        $innovationInfo = $this->Minnovation->getInnovation($id);

        if (isset($_POST['txtSubmit'])) {

            $config['file_name'] = str_replace(' ', '_', $innovationInfo['name_of_enterprise']) . "-Agreement_signed-" . str_replace(' ', '_', $_FILES['signed_document']['name']);

            if ($_FILES['signed_document']['name'] != '') {

                $filename = $_FILES['signed_document']['name'];

                $_FILES['ty']['name'] = $_FILES['signed_document']['name'];

                $_FILES['ty']['tmp_name'] = $_FILES['signed_document']['tmp_name'];

                $_FILES['ty']['size'] = $_FILES['signed_document']['size'];

                $_FILES['ty']['error'] = $_FILES['signed_document']['error'];

                $_FILES['ty']['type'] = $_FILES['signed_document']['type'];

                $config['upload_path'] = './uploads/agreement/';

                $config['allowed_types'] = '*';

                $config['file_name'] = str_replace(' ', '_', $innovationInfo['name_of_enterprise']) . "-Agreement_signed-" . str_replace(' ', '_', $_FILES['signed_document']['name']);

                $this->load->library('upload');

                $this->upload->initialize($config);

                $data['success_msg'] = $this->upload->do_upload('ty');
            }

            if (!empty($filename)) {

                if (!$this->upload->do_upload('signed_document')) {

                    echo $this->upload->display_errors();
                } else {

                    $upload_data = $this->upload->data();

                    $_POST['signed_document'] = $upload_data['file_name'];
                }

                if ($_POST['signed_document'] == '') {

                    $_POST['signed_document'] = $_POST['pre_signed_document'];
                } elseif ($_POST['pre_signed_document'] != '') {

                    @unlink('uploads/agreement/' . $_POST['pre_signed_document']);
                }

                if ($_POST['signed_document'] != '') {
                    if ($type == 'copy2') {

                        $this->Magreement->updateSignedCopy2($_POST);
                    } else {

                        $this->Magreement->updateSignedCopy1($_POST);
                    }
                    $signedcopy = $this->Magreement->getInnovationAgreement($_POST['innovation']);
                    if ($signedcopy[0]['signed_copy1'] != '' && $signedcopy[0]['signed_copy2'] != '') {
                        $ids = $_POST['innovation'];
                        $employees = $this->Sector_model->getEmpId($ids);
                        $emp_Ids = php72_array_map(function ($emp_Ids) {
                            return $emp_Ids['associate_employee'];
                        }, $employees);
                        $employees_id = rtrim(implode(',', $emp_Ids), ',');

                        $log_data = array(
                            'innovation_id' => $innovationInfo['id'],
                            'stage' => 11,
                            'status' => $innovationInfo['status'],
                            'assigned_user' => $employees_id,
                            'modified_by' => $this->session->userdata('emp_number'),
                            'modified_date' => date('Y-m-d H:i:s'),
                        );

                        $table_log = "application_status_log";
                        $result = $this->Minnovation->pitch_insert($table_log, $log_data);

                        $this->Minnovation->agreement_status($id, $innovationInfo['status']); // 8 => incubation status
                        redirect('screening/incubateeform/' . $id);
                    }

                    $this->session->set_flashdata('successMsg', 'Signed copy uploaded!');
                }
            } else {

                $this->session->set_flashdata('errorMsg', 'Please Select Valid Document!');
            }
        }

        redirect('screening/agreement/' . $id);
    }

    public function parseWord($userDoc) {

        $fileHandle = fopen($userDoc, "r");

        $line = @fread($fileHandle, filesize($userDoc));

        $lines = explode(chr(0x0D), $line);

        $outtext = "";

        foreach ($lines as $thisline) {

            $pos = strpos($thisline, chr(0x00));

            if (($pos !== false) || (strlen($thisline) == 0)) {

            } else {

                $outtext .= $thisline . " ";
            }
        }

        $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/", "", $outtext);

        return $outtext;
    }

    public function editagreement() {

        $filepath = $_GET['filepath'];

        $fh = fopen($filepath, 'r');

        $data['username'] = $this->session->userdata('user_name');

        $data['cpage'] = 'editagreement';

        $data['cpagetitle'] = 'Agreement Update';

        $this->load->view('../template_plain', $data);
    }

    public function add_agreement_comments($code) {

        $id = $this->allow($code);

        if ($this->input->post('txtSubmit') != '') {

            $this->Magreement->insertAgreementComments($id, $_POST);

            $this->session->set_flashdata('successMsg', 'Comments added Successfully!');

            redirect('screening/agreement/' . $id);
        }
    }

    public function delete_agreement_comments($id, $comment_id = '') {

        if ($comment_id != '') {

            $this->Magreement->deleteAgreementComments($comment_id);

            $this->session->set_flashdata('successMsg', 'Comments Deleted Successfully!');
        }

        redirect('screening/agreement/' . $id);
    }

    //invite innovatore to fill detail screening form

    public function invite_prescreen($id = '') {

        $data['innovation'] = $this->Minnovation->getInnovation($id);

        $data['inviteInfo'] = $this->Minvitation->getInviteInfo($id);

        $ids = $data['innovation']['id'];

        if (php72_count($data['inviteInfo']) != 0) {

            $data['status'] = $data['inviteInfo'][0]['status'];
        } else {

            $data['status'] = 0;
        }

        if (isset($_POST['txtSubmit'])) {
            $this->Minnovation->diligence_stage($id);

            $employees = $this->Sector_model->getEmpId($ids);
            $emp_Ids = php72_array_map(function ($emp_Ids) {
                return $emp_Ids['associate_employee'];
            }, $employees);
            $employees_id = rtrim(implode(',', $emp_Ids), ',');

            $log_data = array(
                'innovation_id' => $data['innovation']['id'],
                'stage' => 9,
                'status' => 12,
                'assigned_user' => $employees_id,
                'modified_by' => $this->session->userdata('emp_number'),
                'modified_date' => date('Y-m-d H:i:s'),
            );

            $table_log = "application_status_log";
            $result = $this->Minnovation->pitch_insert($table_log, $log_data);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('description', 'Description', 'required');

            if ($this->form_validation->run() != false) {

                if ($_POST['invite'] == 'Invite') {

                    $this->load->library('encrypt');

                    $_POST['invite_code'] = $this->encrypt->sha1(microtime());

                    $this->Minvitation->insertInvitation($id, $_POST);
                } else {
                    $this->Minvitation->reInvitation($id, $_POST);
                }

                $this->session->set_flashdata('successMsg', 'Invitation sent Successfully!');

                redirect('screening/invite_prescreen/' . $id);
            }
        }

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');
        } else {

            $data['left_box'] = array('screening', 'innovation_tab');
        }

        $data['cpagetitle'] = "Invite for detailed diligence";

        $data['cpage'] = "invite_prescreen";

        $this->load->vars($data);

        $this->load->view('../template');
    }

    public function invite_status($id, $status) {

        $data = $this->Minvitation->checkinvitation($id);

        if ($data != null) {

            $this->Minvitation->changeInvitationStatus($id, $status);

            $this->session->set_flashdata('successMsg', 'Invitation Status Updated');

            redirect('screening/invite_prescreen/' . $id);
        } else {

            $this->session->set_flashdata('errorMsg', 'Please Invite to Activate the Url');

            redirect('screening/invite_prescreen/' . $id);
        }
    }

    public function editnda_docs($innovation) {

        if (isset($_POST['txtNDASubmit'])) {

            $insertID = $this->Mscreening->insertDocsTemplate($innovation, $_POST);

            $lastID = @$insertID['0']['id'];

            redirect('screening/nda_list/' . $innovation . '/' . $lastID);
        }

        $checkDuplication = $this->Mscreening->checkDuplicateTemplateByInnovation($innovation);

        if (empty($checkDuplication)) {

            $data['templateDetails'] = $this->Mscreening->getTemplateData();
        } else {

            $data['templateDetails'] = $this->Mscreening->getEditTemplateData($innovation);
        }

        $data['innovation'] = $innovation;

        $data['cpagetitle'] = "Edit NDA Documents";

        $data['cpage'] = "edit_nda_document";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    #NDA list

    public function nda_list($innovation_code = '', $id = '', $action = '') {

        $innovation_id = $this->allow($innovation_code);

        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($innovation_id);

        $data['ndaList'] = $this->Mnda->getNdaList($innovation_id);

        $data['criteria'] = '';

        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');

        $template = '../template';

        if (!$this->Mauth->isLogged()) {

            $template = '../template_user';
        }

        $data['cpagetitle'] = "Non-disclosure agreement";

        $data['cpage'] = "nda_document";

        $data['left_box'] = array('screening', 'innovation_tab');

        $edit = $this->input->post("ndaEdit");

        if (isset($edit)) {

            $data['templateDetails'] = $this->Mscreening->editTemplateData($innovation_id);
        }

        $checkDuplication = $this->Mscreening->checkDuplicateTemplateByInnovation($innovation_id);

        if (empty($checkDuplication)) {

            $data['templateDetails'] = $this->Mscreening->getTemplateData();
        } else {

            $data['templateDetails'] = $this->Mscreening->getEditTemplateData($innovation_id);
        }

        if ($id != "") {

            $data['templateDetails'] = $this->Mscreening->getEditTemplateData($innovation_id, $id);
        }

        $this->load->vars($data);

        $this->load->view($template);
    }

    public function nda_copy1($innovation = '', $id = '', $copy1 = 'copy1') {

        $data['innovationInfo'] = $innovationInfo = $this->Minnovation->getInnovation($innovation);

        $data['ndaDetails'] = array();

        if ($id != '') {
            $data['ndaDetails'] = $this->Mnda->getNdaList($innovation, $id);
        }

        if (isset($_POST['txtSubmit'])) {

            if ($_FILES['copy1']['name'] != '') {

                $this->load->library('upload');

                if ($_FILES['copy1']['name'] != '') {

                    $config['upload_path'] = './uploads/nda/';

                    $config['allowed_types'] = '*';

                    $config['file_name'] = str_replace(' ', '_', $innovationInfo['name_of_enterprise']) . "-NDA-" . str_replace(' ', '_', $_FILES['copy1']['name']);

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('copy1')) {
                        $data['upload_error'] = $this->upload->display_errors();
                    } else {

                        $upload_data = $this->upload->data();

                        $_POST['copy1'] = $upload_data['file_name'];
                    }
                }

                if ($_POST['old_copy1'] != '' && $_POST['copy1'] != '') {
                    unlink('uploads/nda/' . $_POST['old_copy1']);
                } elseif ($_POST['old_copy1'] != '' && $_POST['copy1'] == '') {
                    $_POST['copy1'] = $_POST['old_copy1'];
                }

                if ($id == '' && $copy1 == 'copy1') {
                    $this->Mnda->insertNda($innovation, $_POST);
                } elseif ($copy1 == 'copy1') {
                    $this->Mnda->updateCopy1($id, $_POST);
                } else {
                    $this->Mnda->updateCopy2($id, $_POST);
                }

                $this->session->set_flashdata('successMsg', 'Document Added Successfully!');

                redirect('screening/nda_list/' . $innovation);
            } else {
                redirect('screening/nda_list/' . $innovation);
            }
        }

        $data['cpagetitle'] = "Non-disclosure agreement -" . ucfirst($copy1);

        $data['cpage'] = "nda_copy1";

        $this->load->vars($data);

        $this->load->view('../template_plain');
    }

    public function nda_delete($innovation, $id = '') {

        $ndaDetails = $this->Mnda->getNdaList($innovation, $id);

        @unlink('uploads/nda/' . $ndaDetails['0']['copy2']);

        @unlink('uploads/nda/' . $ndaDetails['0']['copy1']);

        $this->Mnda->delete($id);

        $this->session->set_flashdata('successMsg', 'Document Deleted Successfully!');

        redirect('screening/nda_list/' . $innovation);
    }

    public function mail($id) {

        $data['innovation'] = $this->Minnovation->getInnovation($id);

        $data['inviteInfo'] = $this->Minvitation->getInviteInfo($id);

        $data['cpage'] = "send_prescreen";

        $data['cpagetitle'] = 'invite for due diligence';

        $this->load->view('../template', $data);
    }

    public function view($innovation, $id) {

        $data['mailDetails'] = $this->Minvitation->getinvite($innovation, $id);

        $data['cpage'] = 'inviteinfo';

        $data['cpagetitle'] = 'View Mail';

        $this->load->view('../template_plain', $data);
    }

    public function showalldocuments($innovation) {

        $data['innovation'] = $innovation;

        $data['assessmentdocument'] = $this->Mscreening->getassessdocument($innovation);

        $data['cpage'] = 'showassessdoc';

        $data['cpagetitle'] = 'Assessment Document Details';

        $this->load->view('../dashboard_template', $data);
    }

    public function editassessdoc($innovation, $id) {

        $data['innovation'] = $innovation;

        $data['id'] = $id;

        $data['details'] = $this->Mscreening->getassessdocument($innovation, $id);

        if (isset($_POST['txtDocSubmit'])) {

            $result = $this->Mscreening->editassessdocument($innovation, $id, $_POST);

            $this->session->set_flashdata('successMsg', 'Assessment Details Updated Successfully');

            redirect('screening/assessform/' . $innovation . '/m1/11');
        }

        $data['cpage'] = 'editassessdoc';

        $data['cpagetitle'] = 'Edit Assessment Documents';

        $this->load->view('../template', $data);
    }

    public function discussion() {

        $template = "../dashboard_template";

        $data['cpagetitle'] = "Discussion Board";

        $data['cpage'] = "discussion_view";

        $this->load->vars($data);

        $this->load->view($template);
    }

}
