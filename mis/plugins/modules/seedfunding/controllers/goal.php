<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Goal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mgoal');
        $this->load->model('scouting/Minnovation');
        $this->items_perpage = '15';
    }

    public function view_list($innovation)
    {
        $data['innovation'] = $innovation;
        $options = array();
        if (isset($_POST['txtSubmit'])) {
            if (isset($_POST['id'])) {
                $this->Mgoal->insert($_POST, $innovation);
                $this->session->set_flashdata('successMsg', 'Goal saved Successfully');
            }
            redirect('seedfunding/activities/view_list/' . $innovation);
        }
        #Loading View and data
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['cpagetitle'] = "Goals";
        $data['cpage'] = "listGoal";
        $this->load->view('../template_plain', $data);
    }
    #delete budget head
    public function delete()
    {
        $goalId = $this->input->post('goalId');
        $result = $this->Mgoal->delete($goalId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }
}
