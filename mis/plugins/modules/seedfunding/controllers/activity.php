<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Activity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mactivity');
        $this->load->model('Mmilestone');
        $this->load->model('Mgoal');
        $this->load->Model('Minstallment');
        $this->load->model('scouting/Minnovation');
        $this->items_perpage = '15';
    }

    public function view_list($innovation)
    {
        $data['innovation'] = $innovation;
        $options = array();
        if (isset($_POST['txtSubmit'])) {
            if (isset($_POST['id'])) {
                $this->Mactivity->insert($_POST, $innovation);
                $this->session->set_flashdata('successMsg', 'Activity saved Successfully');

            }
            redirect('seedfunding/activities/view_list/' . $innovation);
        }
        #Loading View and data
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);
        $data['activityList'] = $this->Mactivity->getActivityList($innovation);
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['cpagetitle'] = "Activity";
        $data['cpage'] = "listActivity";
        $this->load->view('../template_plain', $data);
    }
    #delete budget head
    public function delete()
    {
        $activityid = $this->input->post('activityid');
        $result = $this->Mactivity->delete($activityid);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }
    public function get()
    {
        if ($this->input->post('goals')) {
            $data['milestoneList'] = $this->Mmilestone->getMilestoneLists($this->input->post('goals'), $this->input->post('innovation'));

            echo json_encode($data['milestoneList']);exit;
        }
    }
}
