<?php
class Seedfunding extends CI_Controller
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
        $this->load->model('Mbudget');
        $this->load->model('scouting/Minnovation');
        $this->load->model('master/Mmailtemplate');
        $this->items_perpage = '15';
    }
    public function view($innovation)
    {
        #Loading View and data
        $data['innovation'] = $inno = $this->Minnovation->getInnovation($innovation);
        if ($inno['partner_id'] != '1' || $inno['partner_id'] != '01') {

            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login');
        }
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);
        $data['BudgetList'] = $this->Mbudget->getbudgetList($innovation);
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

    public function actionhistory($innovation)
    {
        $data = array();
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['installmenthistory'] = $this->Minstallment->getInstallmenthistory($innovation);
        $data['goalhistory'] = $this->Mgoal->getGoalhistory($innovation);
        $data['milestonehistory'] = $this->Mmilestone->getMilestonehistory($innovation);
        $data['activitieshistory'] = $this->Msfactivities->getActivityhistory($innovation);
        $options = $this->Mseedfunding->getlastrecord($innovation);
        $lastid = @$options[0]['id'];
        $data['datehistory'] = $this->Mseedfunding->getdatehistory($innovation, $lastid);
        $data['cpagetitle'] = "Action History";
        $data['cpage'] = "actionhistory";
        $this->load->view('../template_plain', $data);
    }

    //this is for the approve and rejection of the request plan change
    public function liststatus($decision = null, $innovationid = null, $id = null)
    {

        if ($decision == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();
                $options = $_POST;
                $this->Mseedfunding->updateactionhistory($innovationid);
                $option = $this->Mseedfunding->getlastrecord($innovationid);
                $lastid = $option[0]['id'];
                $result = $this->Mseedfunding->insert_approve_history($options, $lastid);
                $this->Mseedfunding->updateliststatus($options);
                redirect('seedfunding/view/' . $innovationid);
            }
            $data['cpagetitle'] = "Approve Request";
            $data['innovationid'] = $innovationid;
            $data['innovation'] = $this->Minnovation->getInnovation($innovationid);
            $data['cpage'] = "listRequest";
            $this->load->view('../template', $data);
        } else {
            if (isset($_POST['rejectSubmit'])) {

                $options = array();
                $options = $_POST;
                $this->Mseedfunding->updateliststatus($options);
                redirect('media/view_list/' . $innovationid);
            }

            $data['cpagetitle'] = "Reject Request";
            $data['innovationid'] = $innovationid;
            $data['cpage'] = "listReject";
            $this->load->view('../template_plain', $data);
        }
    }
    public function milestones($innovation)
    {
        $data['fieldsList'] = $this->Mseedfunding->getfieldsList();
        $data['cpage'] = 'smilestone';
        $this->load->vars($data);
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
        $data['installmentDetails'] = $this->Minstallment->getInstallmentDetails($innovation, $installment);
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
        $data['BudgetList'] = $this->Mbudget->getbudgetList($innovation);
        if (isset($_POST['txtSubmit'])) {

            $this->load->library('upload');

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = '*';
            for ($i = 0; $i < count($_FILES['supporting_documents']['name']); $i++) {
                $_POST['document'] = implode(',', $_FILES['supporting_documents']['name']);
                if ($_FILES['supporting_documents']['name'] != '') {
                    $_FILES['ty']['name'] = $_FILES['supporting_documents']['name'][$i];
                    $_FILES['ty']['tmp_name'] = $_FILES['supporting_documents']['tmp_name'][$i];
                    $_FILES['ty']['size'] = $_FILES['supporting_documents']['size'][$i];
                    $_FILES['ty']['type'] = $_FILES['supporting_documents']['type'][$i];
                    $this->upload->initialize($config);
                    $this->upload->do_upload('ty');
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
            if (count($data['fundDetails']) == 0) {
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
    public function send_editrequest($innovation)
    {
        if (isset($_POST['txtsubmit'])) {
            $options = $_POST;
            $data['innovation'] = $options;
            $this->load->model('common/Minnovation_mail');
            $this->Mseedfunding->updateactionhistory($innovation);
            $this->Minnovation_mail->send_editrequest($innovation, $data);
            $this->Minnovation->updateEditRequest($innovation);
            $this->session->set_flashdata('successMsg', 'Mail Sent Successfully!');
        }
    }
    public function send_incubationplan($innovation)
    {
        if (isset($_POST['txtSubmit'])) {
            $options = $_POST;
            $data['innovation'] = $options;
            $innovation = $_POST['innovation'];
            $this->Screening->send_incubation($innovation);
            $this->session->set_flashdata('successMsg', 'Mail sent Successfully');
        }
        $data['cpage'] = "sendIncubation";
        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();
        $this->load->view('../template', $data);

    }
    public function monthly_progress($innovation)
    {
        $data['progressStatus'] = $this->Msfactivities->progressStatus();
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);
        $data['activitiesList'] = $this->Msfactivities->getActivityLists($innovation);

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
                $_POST['lineitem'] = implode(',', $_POST['lineitem']);
                $result = $this->Mseedfunding->insertTarget($_POST);
                $msg = "Record inserted!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('seedfunding/monthly_progress/' . $innovation);
        }

        $data['targetDetails'] = array();
        if ($id != '') {
            $data['targetDetails'] = $this->Mseedfunding->getTargetDetails($id);
            if (count($data['targetDetails']) == 0) {
                redirect('seedfunding/monthly_progress/' . $innovation);
            }

            $data['cpagetitle'] = "Edit Target/Achieved";
        } else {
            $data['targets'] = $this->Mseedfunding->getnexttarget($innovation, $activity);
            if ($data['targets'] == '') {
                $data['targets'][0] = "";
            }
            $data['budgethead'] = $this->Mseedfunding->getbudgethead($innovation);
            $data['cpagetitle'] = "Add Target/Achieved";
        }
        $data['cpage'] = "formTarget";
        $this->load->view('../template_plain', $data);
    }
    public function getlineitem()
    {
        if ($this->input->post('budget')) {
            $data['lineitemlist'] = $this->Mseedfunding->getlineitem($this->input->post('budget'), $this->input->post('innovation'));

            echo json_encode($data['lineitemlist']);exit;
        }
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

    public function attachment($innovation)
    {
        $data['innovation'] = $innovation;
        $data['cpage'] = "attachment";
        $this->load->view('../template_plain', $data);

    }
    public function mail_form($innovation_id = '', $id = '')
    {
        $innovation = $data['innovation'] = $this->Minnovation->getInnovation($innovation_id);
        if (isset($_POST['txtSubmit'])) {
            $this->Minnovation->updateEditRequest($innovation_id);
            $this->Mseedfunding->updateactionhistory($innovation_id);
            $result = $this->Mseedfunding->insert_mail_history($_POST);
            $msg = "Mail Sent Successfully !";
            $this->session->set_flashdata('successMsg', $msg);
            redirect('seedfunding/view/' . $innovation_id);
        }
        if ($id == '') {
            $data['cpagetitle'] = "Send Mail";
            $data['mailDetails'] = array();
        } else {
            $data['cpagetitle'] = "Resend Mail";
            $data['mailDetails'] = $this->Mmail->getMailInfo($id);
        }
        $data['cpage'] = "sendMail";
        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();
        $this->load->view('../template', $data);
    }
    /* This Function is used for Exporting Pdf
     *  Any chnage in this fuction may cause unknown behaviour
     * Author : Sanjay
     * Date of Modified : 04-02-2012
     */
    public function exportPdf($innovation)
    {

        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);
        $data['BudgetList'] = $this->Mbudget->getbudgetList($innovation);
        $data['activitiesList'] = $this->Msfactivities->getActivityList($innovation);
        $data['activitiesLists'] = $this->Msfactivities->getActivityLists($innovation);
        $htmView = $this->load->view('seedfunding/export_seedfunding', $data, true);
        $this->load->library('mpdf51/mpdf');
        $CI->mpdf = new mPDF('', 'A4', 0, '', 12, 12, 10, 10, 5, 5);
        $this->mpdf->WriteHTML($htmView, 2);
        $this->mpdf->Output('mpdf.pdf', 'I');
    }
    #End exportPdf Function#
    public function send_incubation_plan($innovation)
    {
        $data['cpage'] = "sendIncubation";
        $data['innovation'] = $innovation;
        $data['cpagetitle'] = "Send Incubation Plan";
        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();
        $this->load->view('../template', $data);
    }

}
