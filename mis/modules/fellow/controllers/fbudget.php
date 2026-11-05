<?php
class Fbudget extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('Msfactivities');
        $this->load->model('Mgoal');
        $this->load->model('Mmilestone');
        $this->load->model('Minstallment');
        $this->load->model('Mseedfunding');
        $this->load->model('scouting/Minnovation');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('fbudget/view');
    }
    public function view($innovation)
    {
        #Loading View and data
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);

        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);

        $data['activitiesList'] = $this->Msfactivities->getActivityList($innovation);

        $data['cpagetitle'] = "Seedfunding";
        $data['cpage'] = "sfActivities";

        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');

        }
        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);

    }

    public function getinstallment($innovation, $installment, $note = null, $approval_id = null)
    {
        if ($approval_id != null and $note == 'approval') {
            $this->Mseedfunding->insertApprovalnote($innovation, $installment, $approval_id);
            $this->session->set_flashdata('successMsg', 'Approval note request sent successfully!');
            redirect('seedfunding/getinstallment/' . $innovation . '/' . $installment);
        }
        if ($note == 'internal') {
            $this->session->set_flashdata('successMsg', 'Internal note request sent successfully!');
            redirect('seedfunding/getinstallment/' . $innovation . '/' . $installment);
        }
        $data['approvalnoteList'] = $this->Mseedfunding->getApprovalNote($innovation, $installment);
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['installmentDetails'] = $this->Minstallment->getInstallmentDetails($installment);

        $data['fundUtilizationList'] = $this->Mseedfunding->getFundUtilizationList($innovation, $installment);

        $data['cpagetitle'] = "Seedfunding";
        $data['cpage'] = "getInstallment";

        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');
        }

        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);
    }

    public function add_fundutilization($innovation, $installment, $fu_id = null)
    {
        $innovationDetails = $this->Minnovation->getInnovation($innovation);
        $data['innovation'] = $innovation;
        $data['installment'] = $installment;
        if (isset($_POST['txtSubmit'])) {
            //show($_POST);
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
                $result = $this->Mseedfunding->updateFundUtilization($innovation, $installment, $_POST);
                $msg = "Record inserted!";
            } else {
                $result = $this->Mseedfunding->insertFundUtilization($innovation, $installment, $_POST);
                $msg = "Record Updated!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('seedfunding/getinstallment/' . $innovation . '/' . $installment);
        }
        $data['fundDetails'] = array();
        if ($fu_id != '') {
            $data['fundDetails'] = $this->Mseedfunding->getFundUtilization($fu_id);
            if (php72_count($data['fundDetails']) == 0) {
                redirect('seedfunding/getinstallment/' . $innovation . '/' . $installment);
            }

            $data['cpagetitle'] = "Edit Fund Utilization";
        } else {
            $data['cpagetitle'] = "Add Fund Utilization";
        }
        $data['cpage'] = "fundUtilization";
        $this->load->view('../template_plain', $data);
    }

    public function delete_fundutilization($innovation, $installment, $fu_id = null)
    {
        $fundDetails = $this->Mseedfunding->getFundUtilization($fu_id);
        @unlink('./uploads/fund_utilization/' . $fundDetails['0']['document']);
        $this->Mseedfunding->deleteFundUtilization($fu_id);
        $this->session->set_flashdata('successMsg', 'Record Deleted Successfully');
        redirect('seedfunding/getinstallment/' . $innovation . '/' . $installment);

    }

    public function monthly_progress($innovation)
    {
        $data['progressStatus'] = $this->Msfactivities->progressStatus();
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);
        $data['activitiesList'] = $this->Msfactivities->getActivityList($innovation);

        $data['cpagetitle'] = "Goals & Milestone Target/Achieved";
        $data['cpage'] = "monthlyAchieved";
        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');
        }
        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);
    }
    public function add_month_report($innovation = null, $activity = null, $id = null)
    {
        $data['innovation'] = $innovation;
        $data['activity'] = $activity;
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Mseedfunding->updateTarget($_POST);
                $msg = "Record Updated!";
            } else {
                $result = $this->Mseedfunding->insertTarget($_POST);
                $msg = "Record inserted!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('seedfunding/monthly_progress/' . $innovation);
        }

        $data['targetDetails'] = array();
        if ($id != '') {
            $data['targetDetails'] = $this->Mseedfunding->getTargetDetails($id);
            if (php72_count($data['targetDetails']) == 0) {
                redirect('seedfunding/monthly_progress/' . $innovation);
            }

            $data['cpagetitle'] = "Edit Target/Achieved";
        } else {
            $data['cpagetitle'] = "Add Target/Achieved";
        }
        $data['cpage'] = "formTarget";
        $this->load->view('../template_plain', $data);
    }

    public function view_month_report($innovation = null, $activity = null, $id = null)
    {

        $data['innovation'] = $innovation;
        $data['activity'] = $activity;
        $data['targetDetails'] = array();
        $data['targetDetails'] = $this->Mseedfunding->getTargetDetails($id);
        $data['cpagetitle'] = "View Target/Achieved";
        $data['cpage'] = "viewTarget";
        $this->load->view('../template_plain', $data);
    }

    public function progress_status($innovation = null, $activity = null, $status = null)
    {
        $this->Msfactivities->updateProgressStatus($innovation, $activity, $status);
        $this->session->set_flashdata('successMsg', 'Status Updated Successfully!');
        redirect('seedfunding/monthly_progress/' . $innovation);
    }

}
