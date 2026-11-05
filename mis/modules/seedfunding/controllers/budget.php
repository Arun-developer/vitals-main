<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Budget extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mbudget');
        $this->load->model('Minstallment');
        $this->load->model('scouting/Minnovation');
        $this->load->model('Mgoal');
        $this->load->model('Mmilestone');
        $this->items_perpage = '15';
    }

    public function view_list($innovation)
    {
        $data['innovation'] = $innovation;
        $options = array();
        if (isset($_POST['id'])) {
            $this->Mbudget->insert($_POST, $innovation);
            $this->session->set_flashdata('successMsg', 'Budget saved Successfully');
            redirect('seedfunding/activities/view_list/' . $innovation);
        }
        #Loading View and data
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);

        if ($this->input->post('goals')) {
            $data['milestoneList'] = $this->Mmilestone->getMilestoneLists($this->input->post('goals'), $this->input->post('innovation'));

            echo json_encode($data['milestoneList']);exit;
        } else {
            $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);
        }
        $data['budgetList'] = $this->Mbudget->getbudgetList($innovation);
        $data['cpagetitle'] = "budget";
        $data['cpage'] = "listBudget";
        $this->load->view('../template_plain', $data);
    }
    #delete budget head
    public function delete()
    {
        $budgetId = $this->input->post('budgetId');
        $result = $this->Mbudget->delete($budgetId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }
}
