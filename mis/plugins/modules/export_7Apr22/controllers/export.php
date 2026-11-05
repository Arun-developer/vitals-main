<?php

class Export extends CI_Controller {
    /* This function is a constructor for the class Portfolio */

    public function __construct() {
        parent::__construct();
        $this->hris = $this->load->database('hris', TRUE);
        $this->load->model('Mexport');
        $this->load->model('scouting/Minnovation');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->library('upload');
        $this->load->helper(array('file', 'download'));
    }

    public function incubation_export($file, $inv) {
        $innov = 'INV' . $inv;
        $data['incub_details'] = $this->Mexport->getIncubDetails($innov);
        $data['file'] = $file;
        $this->load->vars($data);
        $this->load->view('export/export_incub');
    }

    public function pitch_export($file, $inv) {
        $innov = 'INV' . $inv;
        $data['program'] = $this->Mexport->getProgramID($inv);
        $data['pitch_details'] = $this->Mexport->getPitchDetails($innov);
        $data['file'] = $file;
        $this->load->vars($data);
        $this->load->view('export/export_pitch');
    }

    public function liveli_export($file, $inv) {
        $innov = 'INV' . $inv;
        $data['pitch_details'] = $this->Mexport->getPitchDetails($innov);
        $data['file'] = $file;
        $this->load->vars($data);
        $this->load->view('export/export_liveli');
    }

}
