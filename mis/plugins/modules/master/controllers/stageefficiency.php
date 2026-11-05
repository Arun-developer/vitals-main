<?php
class Stageefficiency extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('master/Mstageefficiency');
    }
    public function setup()
    {
        if (isset($_POST['txtSubmit'])) {
            $this->Mstageefficiency->updateEfficiency($_POST);
            $data['successMsg'] = 'Efficiency setup Updated Successfully';
        }
        $data['stagefficient'] = $this->Mstageefficiency->getStageEfficient();
        $data['cpagetitle'] = "Stage-wise Efficiency Master";
        $data['cpage'] = "masters/stageefficiency";

        $data['left_box'] = array('master');

        $this->load->vars($data);
        $this->load->view('../template');
    }

}
