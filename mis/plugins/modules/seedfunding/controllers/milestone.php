<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Milestone extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mmilestone');
        $this->load->model('Mgoal');
        $this->load->model('scouting/Minnovation');
        $this->load->Model('Minstallment');
        $this->items_perpage = '15';
    }

    public function view_list($innovation)
    {

        $data['innovation'] = $innovation;
        $options = array();

        if (isset($_POST['txtSubmit'])) {
            if (isset($_POST['id'])) {
                $this->Mmilestone->insert($_POST, $innovation);
                $this->session->set_flashdata('successMsg', 'Milestone saved Successfully');
            }
            redirect('seedfunding/activities/view_list/' . $innovation);
        }
        #Loading View and data
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['cpagetitle'] = "Milestone";
        $data['cpage'] = "listMilestone";
        $this->load->view('../template_plain', $data);
    }
    #delete budget head
    public function delete()
    {
        $milestoneId = $this->input->post('milestoneId');
        $result = $this->Mmilestone->delete($milestoneId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }
}
