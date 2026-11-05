<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Fellow extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';
        $this->load->model('Mfellow');
        $this->load->model('scouting/Minnovation');
        $this->load->helper('common_helper');
        $this->load->model('Msfactivities');
        $this->load->model('Mgoal');
        $this->load->model('Mmilestone');
        $this->load->model('Minstallment');
        $this->load->model('Mseedfunding');
        $this->load->model('scouting/Minnovation');
    }
    public function index()
    {
        redirect('fellow/view_list/' . $innovationid);
    }
    public function view_list($innovationid)
    {

        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);
        $options['innovationid'] = $innovationid;
        $data['applicantList'] = $this->Mfellow->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['isincubAuth'] = false;
        /**** For adding left box ****/
        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);
        /**** End ***/
        $data['innovationid'] = $innovationid;
        $data['isincubAuth'] = false;
        $data['cpagetitle'] = "Applicant Request";
        $data['cpage'] = "fellow/listfellow";

        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');

        }
        $data['custom_js'] = array('list_page');
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function form($innovationid = null, $id = null)
    {

        $data['applicantDetails'] = array();
        if ($id != '') {

            $data['cpagetitle'] = "Edit Job Request";
            $data['applicantDetails'] = $this->Mfellow->getapplicantDetails($id);

        } else {
            $data['cpagetitle'] = "Add Job Request";
            $data['request_key'] = $this->Mfellow->getkey();
        }

        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {

                $options = array();
                $options = $_POST;
                $options['uploadpath'] = './uploads/fellow_request/';
                $this->doupload($options);
                $filename = $_FILES['profile']['name'];
                $options['filename'] = $filename;
                $options['request_date'] = date2mysql($options['request_date']);
                $options['from_period'] = date2mysql($options['from_period']);
                $options['to_period'] = date2mysql($options['to_period']);
                $result = $this->Mfellow->updatereq($_POST);
                $msg = "Record Updated!";
            } else {
                $options = array();
                $options = $_POST;
                $options['uploadpath'] = './uploads/fellow_request/';
                $this->doupload($options);
                $filename = $_FILES['profile']['name'];
                $options['filename'] = $filename;
                $options['request_date'] = date2mysql($options['request_date']);
                $options['from_period'] = date2mysql($options['from_period']);
                $options['to_period'] = date2mysql($options['to_period']);

                $result = $this->Mfellow->insert($options);
                $msg = "Record Inserted!";
            }

            $this->session->set_flashdata('successMsg', $msg);
            redirect('fellow/view_list/' . $innovationid);
        }
        $data['id'] = $id;
        $data['innovationid'] = $innovationid;
        $data['cpage'] = "addfellowreq";
        $this->load->view('../template_plain', $data);
    }
    public function add($innovationid, $id)
    {
        $exparr = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6');
        $data['exparr'] = $exparr;
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;
            $options['innovationid'] = $innovationid;
            $options['id'] = $id;
            $options['uploadpath'] = "./uploads/fellow_applicant/";
            $this->doupload($options);
            $filename = $_FILES['profile']['name'];
            $options['filename'] = $filename;
            $options['exp_from'] = date2mysql($options['exp_from']);
            $options['exp_to'] = date2mysql($options['exp_to']);
            $options['date_appointment'] = date2mysql($options['date_appointment']);
            $result = $this->Mfellow->insertapplicant($options);
            if ($result) {
                $this->session->set_flashdata('successMsg', 'Record inserted !');
                redirect('fellow/applicantDetail/' . $innovationid . '/' . $id);
            }
        }
        $data['innovationid'] = $innovationid;
        $data['id'] = $id;
        $data['cpagetitle'] = "Add Applicant";
        $data['cpage'] = "fellow/addapplicant";
        $this->load->view('../template', $data);
    }
    public function edit($id)
    {
        $data['applicantDetails'] = array();
        if ($id != '') {

            $data['cpagetitle'] = "Edit Job Request";
            $data['applicantDetails'] = $this->Mfellow->getapplicantslists($id);
        }
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {

                $options = array();
                $options = $_POST;
                $result = $this->Mfellow->updateapplicants($_POST);
                redirect('fellow/applicantdetail' . $innovationid . '/' . $id);
                $msg = "Record Updated!";
            }
        }
        $data['id'] = $id;
        $data['cpagetitle'] = "Edit Applicant";
        $data['cpage'] = "editapplicant";
        $this->load->view('../template', $data);
    }

    public function liststatus($status = null, $innovationid = null, $id = null)
    {

        if ($status == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();
                $options = $_POST;

                $this->Mfellow->updateliststatus($options);
                redirect('fellow/view_list/' . $innovationid);
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
                $this->Mfellow->updateliststatus($options);
                redirect('fellow/view_list/' . $innovationid);
            }

            $data['cpagetitle'] = "Reject Request";
            $data['innovationid'] = $innovationid;
            $data['id'] = $id;
            $data['cpage'] = "listReject";
            $this->load->view('../template_plain', $data);
        }
    }
    public function jobdetails($innovationid = null, $key = null)
    {
        $data['cpagetitle'] = "Job Request Information";
        $title = "Board Formation";
        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['isincubAuth'] = true;
            $data['left_box'] = array('incubatee');
        } else {
            $data['left_box'] = array('innovation_tab');
        }
        if ($key) {
            $data['jobDetails'] = $this->Mfellow->getjobDetails($key);
            $data['key'] = $key;
            $data['innovationid'] = $innovationid;
        }
        $data['cpage'] = "jobdetails";

        $this->load->view('../template_plain', $data);
    }

    public function applicantdetail($innovationid = null, $id = null)
    {

        $data['cpagetitle'] = "Applicant Request Information";
        $title = "Board Formation";
        if ($id != '') {
            $data['applicantDetails'] = $this->Mfellow->getapplicantDetails($id);
            $data['id'] = $id;
        }
        $data['isincubAuth'] = false;
        $incubatsession = $this->session->userdata('is_incubatee');
        $applicantList = array();
        $data['applicantDetails'] = $this->Mfellow->getapplicantDetails();
        $data['applicantstatus'] = $this->Mfellow->getapplicantstatus();
        $data['applicantList'] = $this->Mfellow->getapplicantList($innovationid);
        $data['innovationid'] = $innovationid;

        /**** For adding left box ****/
        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);
        /**** End ***/

        $data['cpage'] = "applicantdetail";
        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['isincubAuth'] = true;
            $data['left_box'] = array('incubatee');
        } else {
            $data['left_box'] = array('innovation_tab');
        }

        $this->load->vars($data);
        $this->load->view('../template');

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
        //$company=$_POST['company'];
        $suggestmember = $this->Mfellow->insertSuggestfellow($innovationid, $id, $suggest);
        redirect('fellow/applicantdetail/' . $innovationid . '/' . $id);

    }

    public function suggestfellow($innovation, $id)
    {
        $data['id'] = $id;
        $data['innovationid'] = $innovation;
        $data['fellows'] = $this->Mfellow->getfelloerecords();
        $data['cpage'] = 'suggestfellow';
        $data['cpagetitle'] = 'Suggest Fellow';
        $this->load->view('../template', $data);
    }
    public function viewprofile($id = null)
    {
        $data['applicantList'] = $this->Mfellow->getapplicantprofile($id);

        $data['cpagetitle'] = "View Profile";
        $data['cpage'] = "viewprofile";
        $this->load->view('../template_plain', $data);
    }
    public function doupload($options)
    {

        if ($_FILES['profile']['name'] != '') {
            $filename = $_FILES['profile']['name'];
            $_FILES['ty']['name'] = $_FILES['profile']['name'];
            $_FILES['ty']['tmp_name'] = $_FILES['profile']['tmp_name'];
            $_FILES['ty']['size'] = $_FILES['profile']['size'];
            $_FILES['ty']['error'] = $_FILES['profile']['error'];
            $_FILES['ty']['type'] = $_FILES['profile']['type'];
            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $filename);
            $config['upload_path'] = $options['uploadpath'];
            $config['allowed_types'] = '*';
            $config['file_name'] = $filename;
            $this->load->library('upload');
            $this->upload->initialize($config);
            $data['success_msg'] = $this->upload->do_upload('ty');
            $this->load->view('addfellowreq', $data);

        }
    }
    public function do_upload()
    {

        if ($_FILES['profile']['name'] != '') {
            $options = $_POST;
            $filename = $_FILES['profile']['name'];
            $_FILES['ty']['name'] = $_FILES['profile']['name'];
            $_FILES['ty']['tmp_name'] = $_FILES['profile']['tmp_name'];
            $_FILES['ty']['size'] = $_FILES['profile']['size'];
            $_FILES['ty']['error'] = $_FILES['profile']['error'];
            $_FILES['ty']['type'] = $_FILES['profile']['type'];
            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $filename);
            $config['upload_path'] = $options['uploadpath'];
            $config['allowed_types'] = '*';
            $config['file_name'] = $filename;
            $this->upload->initialize($config);
            $data['success_msg'] = $this->upload->do_upload('ty');
            redirect('fellow/induction_view', $data);

        }
    }
    //updating the applicant status by selecting the status and shortlist check box.
    public function addapplicantstatus()
    {
        $options = array();
        $options = $_POST;
        $this->Mfellow->updates($options);
        $this->session->set_flashdata('successMsg', 'Record Inserted !');
        redirect('fellow/induction_view/' . $options['innovation']);

    }
    //induction starts here add fjob_induction here.

    public function job_induction($innovation)
    {
        $data['innovation'] = $innovation;
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'add') {
                $options = $_POST;
                $options['uploadpath'] = './uploads/fellow_jobinduction/';
                $this->doupload($options);
                $filename = $_FILES['profile']['name'];
                $options['filename'] = $filename;
                $options['start_date'] = date2mysql($options['start_date']);
                $options['to_date'] = date2mysql($options['to_date']);
                $result = $this->Mfellow->insertinduction($options);
                $msg = "Record Inserted!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('fellow/induction_view');
        }

        $data['cpagetitle'] = "Job Induction";
        $data['cpage'] = "job_induction";
        $this->load->view('../template', $data);

    }
    //induction summary view here.
    public function induction_view($innovation)
    {
        $data['innovation'] = $innovation;
        $data['cpagetitle'] = "Job Induction Summary";
        $data['inductionlist'] = $this->Mfellow->getinductionlist();
        $data['leftbox'] = array("innovation_tab");
        $data['cpage'] = "induction_view";
        $this->load->view("../template", $data);
    }
    //uploading the induction documents here.
    public function upload_induction()
    {
        $data['pagetitle'] = "Upload Induction Document";
        $data['cpage'] = "upload_induction";
        $data['leftbox'] = array("innvoation_tab");
        $this->load->view('../template_plain', $data);
    }

    //budget for fellow starts here (budget summary view here)
    public function budget($innovation)
    {
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['budgetList'] = $this->Mfellow->getbudgetList($innovation);
        $data['cpagetitle'] = "FellowShip";
        $data['cpage'] = "sfActivities";
        $data['isincubAuth'] = false;
        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['isincubAuth'] = true;
            $data['left_box'] = array('incubatee');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');

        }
        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);
    }
    //adding the budget here.
    public function add_fund($innovation)
    {
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'add') {
                $options = $_POST;
                $options['start_date'] = date2mysql($options['start_date']);
                $options['end_date'] = date2mysql($options['end_date']);

                $result = $this->Mfellow->insertbudget($options);
                $msg = "Record Inserted!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('fellow/budget/' . $innovation);
        }
        $data['innovation'] = $innovation;
        $data['cpagetitle'] = "Adding budget";
        $data['cpage'] = "add_fund";
        $this->load->view('../template', $data);
    }
    //this function for gettting the approval note,internal node status and the approval amount from the ais.
    public function getinstallment($innovation, $installment = null, $note = null, $approval_id = null)
    {
        if ($approval_id != null and $note == 'approval') {
            $data['budgetList'] = $this->Mfellow->getbudgetList($innovation);
            $this->Mfellow->insertApprovalnote($innovation, $budgetid, $approval_id, $budgetid);
            $this->session->set_flashdata('successMsg', 'Approval note request sent successfully!');
            redirect('fellow/getinstallment/' . $innovation . '/' . $installment);
        }
        if ($note == 'internal') {
            $this->session->set_flashdata('successMsg', 'Internal note request sent successfully!');
            redirect('fellow/getinstallment/' . $innovation . '/' . $installment);
        }
        $data['approvalnoteList'] = $this->Mfellow->getApprovalNote($innovation, $installment);
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['budgetList'] = $this->Mfellow->getbudgetList($innovation, $installment);
        $data['fundUtilizationList'] = $this->Mfellow->getFundUtilization($installment);

        $data['cpagetitle'] = "Fellowship";
        $data['cpage'] = "getInstallment";

        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');
        }

        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);
    }
    //adding and updating  the fund utilization here
    public function add_fundutilization($innovation, $installment, $fu_id = null)
    {
        $innovationDetails = $this->Minnovation->getInnovation($innovation);
        $data['innovation'] = $innovation;
        $data['installment'] = $installment;
        if (isset($_POST['txtSubmit'])) {
            $this->load->library('upload');
            $_POST['document'] = $_POST['pre_document'];
            if ($_FILES['document']['name'] != '') {
                $config['upload_path'] = './uploads/fund_utilization/';
                $config['allowed_types'] = '*';
                $config['file_name'] = str_replace(' ', '_', $innovationDetails['name_of_enterprise']) . "-Fund_Utilization-" . str_replace(' ', '_', $_FILES['document']['name']);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $data['upload_error'] = $this->upload->display_errors();
                } else {
                    $upload_data = $this->upload->data();
                    $_POST['document'] = $upload_data['file_name'];

                    if ($_POST['pre_document'] != '') {
                        @unlink('./uploads/fund_utilization/' . $_POST['pre_document']);
                    }

                }

            }

            if ($_POST['action'] == 'edit') {
                echo "inner post";
                $result = $this->Mfellow->updateFundUtilization($innovation, $budgetid, $_POST);
                $msg = "Record inserted!";
            } else {
                $result = $this->Mfellow->insertFundUtilization($innovation, $budgetid, $_POST);
                $msg = "Record Updated!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('fellow/getinstallment/' . $innovation . '/' . $installment);
        }
        $data['fundDetails'] = array();
        if ($fu_id != '') {
            $data['fundDetails'] = $this->Mfellow->getFundUtilization($fu_id);
            if (php72_count($data['fundDetails']) == 0) {
                redirect('fellow/getinstallment/' . $innovation . '/' . $installment);
            }

            $data['cpagetitle'] = "Edit Fund Utilization";
        } else {
            $data['cpagetitle'] = "Add Fund Utilization";
        }
        $data['cpage'] = "fundUtilization";
        $this->load->view('../template_plain', $data);
    }

}
