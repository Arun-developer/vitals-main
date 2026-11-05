<?php
/*-

 * Masters Module Controller

 * This section for setting  purpose

 *

 * Master's Controller

 * @quadrupleindia.com

 * author - Prabakar

 */

class Assign_incubation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Massign_incubation');
        $this->load->model('scouting/Minnovation');
        $this->load->model('master/Mprogress_master');
        $this->load->model('incubationprogress/Mincubationprogress');
    }

    public function assign_checklist($innovation)
    {
        if (isset($_POST['txtSubmit'])) {
            $this->Massign_incubation->assignChecklist($_POST);
            $this->session->set_flashdata('successMsg', 'Checklist Assigned Successfully!');
            redirect('assign_incubation/view_checklist/' . $innovation);
        }
        $data['innovationChecklist'] = $this->Massign_incubation->getAssignedChecklist($innovation);
        $data['innovation'] = $innovation;
        $innovationInfo = $this->Minnovation->getInnovation($innovation);

        $data['checkList'] = $this->Massign_incubation->getCheckList($innovation);
        $data['cpagetitle'] = "Assign Metrices Checklist";
        $data['cpage'] = "assign_checklist";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function view_checklist($innovation)
    {
        $data['innovationChecklist'] = $this->Massign_incubation->getAssignedChecklist($innovation);
        $data['checkList'] = $this->Massign_incubation->getInnovationCheckListView($innovation);
        $data['innovation'] = $innovation;
        $innovationInfo = $this->Minnovation->getInnovation($innovation);
        $data['cpagetitle'] = "Metrices Checklist";
        $data['cpage'] = "view_checklist";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function form2($innovation = null, $id = '')
    {
        if (isset($_POST['txtSubmit'])) {
            $result = $this->Mprogress_master->insert_activity($_POST);
            $msg = "Record inserted!";
            $this->session->set_flashdata('successMsg', $msg);
            redirect('assign_incubation/form2/' . $innovation);
        }
        $data['innovation'] = $innovation;
        $data['screeningDetails'] = $this->Mprogress_master->getactivityRecords($innovation);
        $data['mastertype'] = $this->Mprogress_master->getmastertype();
        $data['getcriteria'] = $this->Mprogress_master->getcriteria();
        if ($this->input->post('mastertypes')) {
            $data['mycriteriaList'] = $this->Mprogress_master->getmastername($this->input->post('mastertypes'));
            echo json_encode($data['mycriteriaList']);exit;
        }
        $data['criteriaList'] = $this->Mprogress_master->getcriteriaList();
        $data['fellowList'] = $this->Mprogress_master->getfellowList();
        $data['cpagetitle'] = 'Add IncubationProgress Activity';
        $data['cpage'] = "addField2";
        $this->load->view('../dashboard_template', $data);
    }

}
