<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Training extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';
        $this->load->model('Mtraining');
        $this->load->model('scouting/Minnovation');
        $this->load->helper('common_helper');
    }
    public function index()
    {
        redirect('training/view_list/' . $innovationid);
    }
    public function view_list($innovationid = null)
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        $options['innovationid'] = $innovationid;
        $data['traininglist'] = $this->Mtraining->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['isincubAuth'] = false;

        /**** For adding left box ****/
        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);
        $data['innovator'] = $data['innovation']['name_of_entrepreneur'];
        /**** End ***/
        $data['innovationid'] = $innovationid;
        $data['isincubAuth'] = false;
        $data['cpagetitle'] = "Peer to Peer Learning";
        $data['cpage'] = "training/listtraining";

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');
        }
        $this->load->vars($data);
        $this->load->view('../template');
    }
    //adding the training details
    public function addtraining_detail($innovationid = null, $id = null)
    {

        $data['trainingDetails']['list1'] = $this->Mtraining->gettrainingDetails($id);
        $data['trainingDetails']['list2'] = $this->Mtraining->gettrainingmaster($id);
        $data['cpage'] = "addtraining_detail";
        $data['cpagetitle'] = "Add training Detail";
        $data['innovationid'] = $innovationid;
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;
            $options['uploadpath'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/trainingdetail/';
            $this->doupload($options);
            $filename = $_FILES['document']['name'];
            $options['filename'] = $filename;
            $options['start_date'] = date2mysql($options['start_date']);
            $options['to_date'] = date2mysql($options['to_date']);

            $result = $this->Mtraining->inserttraining_detail($options);
            $msg = "Record Inserted!";
            $this->session->set_flashdata('successMsg', $msg);
            redirect('training/view_list/' . $innovationid);
        } else {
            $data['innovationid'] = $innovationid;
            $data['id'] = $id;

            $this->load->view('../template', $data);
        }
    }
    //this function needs to store the status of the request.
    public function liststatus($status = null, $innovationid = null, $id = null)
    {
        if ($status == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();
                $options = $_POST;
                $this->Mtraining->updateliststatus($options);
                redirect('training/view_list/' . $innovationid);
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
                $this->Mtraining->updateliststatus($options);
                redirect('training/view_list/' . $innovationid);
            }

            $data['cpagetitle'] = "Reject Request";
            $data['innovationid'] = $innovationid;
            $data['id'] = $id;
            $data['cpage'] = "listReject";
            $this->load->view('../template_plain', $data);
        }
    }

    //add and edit for the program service offering instance is done here.
    public function form($innovationid = null, $id = null)
    {

        $data['trainingDetails'] = array();
        if ($id != '') {

            $data['cpagetitle'] = "Edit Program Service Offering Instance";
            $data['trainingDetails'] = $this->Mtraining->gettrainingDetail($id);
        } else {
            $data['cpagetitle'] = "Add Program Service Offering Instance";
        }

        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $options = array();
                $options = $_POST;
                $options['uploadpath'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/training/';
                $this->doupload($options);
                $filename = $_FILES['document']['name'];
                $options['filename'] = $filename;
                $result = $this->Mtraining->update($_POST);
                $msg = "Record Updated!";
            } else { 
                $options = array();
                $options = $_POST;
                $options['uploadpath'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/training/';
                $this->doupload($options);
                $filename = $_FILES['document']['name'];
                $options['filename'] = $filename;
                $options['start_date'] = date2mysql($options['start_date']);
                $options['to_date'] = date2mysql($options['to_date']);
                $result = $this->Mtraining->insert($options);
                $msg = "Record Inserted!";
            }

            $this->session->set_flashdata('successMsg', $msg);
            redirect('training/view_list/' . $innovationid);
        }

        $data['innovationid'] = $innovationid;
        $data['id'] = $id;
        $data['cpage'] = "addtrainingreq";
        $this->load->view('../template', $data);
    }
    public function doupload($options)
    {

        if ($_FILES['document']['name'] != '') {
            $filename = $_FILES['document']['name'];

            $_FILES['ty']['name'] = $_FILES['document']['name'];
            $_FILES['ty']['tmp_name'] = $_FILES['document']['tmp_name'];
            $_FILES['ty']['size'] = $_FILES['document']['size'];
            $_FILES['ty']['error'] = $_FILES['document']['error'];
            $_FILES['ty']['type'] = $_FILES['document']['type'];
            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $filename);
            $config['upload_path'] = $options['uploadpath'];
            $config['allowed_types'] = '*';
            $config['file_name'] = $filename;
            $this->load->library('upload');
            $this->upload->initialize($config);
            $data['success_msg'] = $this->upload->do_upload('ty'); //exit
            $this->load->view('addtrainingreq', $data);

        }
    }
    //delete the program service offering request
    public function delete($id = '')
    {
        if ($id != '') {
            $result = $this->Mtraining->delete($id);
            $this->session->set_flashdata('successMsg', 'Applicant deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('training/view_list');
    }
    //budget starts here
    public function budget($innovation)
    {
        //before getting all the details of the innovation and budgetlist
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['budgetList'] = $this->Mtraining->getbudgetList($innovation);
        $data['cpagetitle'] = "Training";
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

    //this function for gettting the approval note,internal node status and the approval amount from the ais.
    public function getinstallment($innovation, $budgetid, $note = null, $approval_id = null)
    {
        if ($approval_id != null and $note == 'approval') {
            $data['budgetList'] = $this->Mtraining->getbudgetList($innovation);
            $budgetid = $data['budgetList']['id'];
            $this->Mtraining->insertApprovalnote($innovation, $budgetid, $approval_id, $budgetid);
            $this->session->set_flashdata('successMsg', 'Approval note request sent successfully!');
            redirect('training/getinstallment/' . $innovation . '/' . $installment);
        }
        if ($note == 'internal') {
            $this->session->set_flashdata('successMsg', 'Internal note request sent successfully!');
            redirect('training/getinstallment/' . $innovation . '/' . $budgetid);
        }
        $data['approvalnoteList'] = $this->Mtraining->getApprovalNote($innovation, $budgetid);
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['budgetList'] = $this->Mtraining->getbudgetList($innovation, $budgetid);
        $data['fundUtilizationList'] = $this->Mtraining->getFundUtilizationList($innovation, $budgetid);

        $data['cpagetitle'] = "trainingship";
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
    public function add_fundutilization($innovation, $budgetid, $fu_id = null)
    {
        $innovationDetails = $this->Minnovation->getInnovation($innovation);
        $data['innovation'] = $innovation;
        $data['budgetid'] = $budgetid;
        if (isset($_POST['txtSubmit'])) {
            $this->load->library('upload');
            $_POST['document'] = $_POST['pre_document'];
            if ($_FILES['document']['name'] != '') {
                $config['upload_path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/fund_utilization/';
                $config['allowed_types'] = '*';
                $config['file_name'] = str_replace(' ', '_', $innovationDetails['name_of_enterprise']) . "-Fund_Utilization-" . str_replace(' ', '_', $_FILES['document']['name']);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $data['upload_error'] = $this->upload->display_errors();
                } else {
                    $upload_data = $this->upload->data();
                    $_POST['document'] = $upload_data['file_name'];

                    if ($_POST['pre_document'] != '') {
                        @unlink('../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/fund_utilization/' . $_POST['pre_document']);
                    }

                }

            }

            if ($_POST['action'] == 'edit') {
                $result = $this->Mtraining->updateFundUtilization($innovation, $budgetid, $_POST);
                $msg = "Record inserted!";
            } else {
                $result = $this->Mtraining->insertFundUtilization($innovation, $budgetid, $_POST);
                $msg = "Record Updated!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('seedfunding/getinstallment/' . $innovation . '/' . $installment);
        }
        $data['fundDetails'] = array();
        if ($fu_id != '') {
            $data['fundDetails'] = $this->Mtraining->getFundUtilization($fu_id);
            if (php72_count($data['fundDetails']) == 0) {
                redirect('training/getinstallment/' . $innovation . '/' . $installment);
            }

            $data['cpagetitle'] = "Edit Fund Utilization";
        } else {
            $data['cpagetitle'] = "Add Fund Utilization";
        }
        $data['cpage'] = "fundUtilization";
        $this->load->view('../template_plain', $data);
    }
    //this function is to add the participant in the selected program service offering
    public function participant($innovation = null, $id = null)
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);
        if ($innovation != '') {
            $data['trainingDetails'] = $this->Mtraining->gettrainingDetails($innovation);
            $data['id'] = $id;
        }
        $options['innovationid'] = $innovation;
        $data['traininglist'] = $this->Mtraining->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['isincubAuth'] = false;

        /**** For adding left box ****/
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['innovator'] = $data['innovation']['name_of_entrepreneur'];
        /**** End ***/
        $data['innovationid'] = $innovation;
        $data['isincubAuth'] = false;
        $data['cpagetitle'] = "Program Service Offering Instance Summary";
        $data['cpage'] = "trainingdetail";

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;
            $data['left_box'] = array('incubatee');
        } else {
            $data['left_box'] = array('innovation_tab');
        }
        $this->load->vars($data);
        $this->load->view('../template');

    }
    public function addparticipant($innovationid = null, $id = null)
    {

        $data['trainingDetails'] = array();
        if ($id != '') {
            $data['cpagetitle'] = "Edit Program Service Offering Instance";
            $data['trainingDetails'] = $this->Mtraining->gettrainingDetails($id);
        } else {
            $data['cpagetitle'] = "Add Program Service Offering Instance";
        }

        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $options = array();
                $options = $_POST;
                $result = $this->Mtraining->updateparticipant($_POST);
                $msg = "Record Updated!";
            } else { 
                $options = array();
                $options = $_POST;
                $result = $this->Mtraining->insertparticipant($options);
                $msg = "Record Inserted!";
            }

            $this->session->set_flashdata('successMsg', $msg);
            redirect('training/participant/' . $innovationid . '/' . $id);
        }

        $data['innovationid'] = $innovationid;
        $data['id'] = $id;
        $data['cpage'] = "addparticipant";
        $this->load->view('../template', $data);
    }
    public function addparticipantstatus()
    {
        $options = array();
        $options = $_POST;
        $innovationid = $options['innovationid'];
        for ($i = 0; $i < php72_count($options['id']); $i++) {
            if (!empty($options['status'][$i])) {
                $data['status'][$options['status'][$i]][] = $options['id'][$i];
            }
        }
        $this->Mtraining->updates($data);
        $this->session->set_flashdata('successMsg', 'Record Updated !');
        redirect('training/participant/' . $innovationid);

    }
    //adding the budget here.
    public function add_fund($innovation)
    {
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'add') {
                $options = $_POST;
                $options['start_date'] = date2mysql($options['start_date']);
                $options['end_date'] = date2mysql($options['end_date']);

                $result = $this->Mtraining->insertbudget($options);
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

}
