<?php

class Alldocument extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Malldocument');
        $this->load->model('scouting/Minnovation');
        $this->load->model('screening/Mscreening');
        $this->items_perpage = '15';
    }

    public function view_list($id) {
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($id);
        $isInnovation = true;
        $isAsessment = true;
        $isPresentation = true;
        $isScreening = true;
        $isTerms = true;

        if (isset($_POST['section'])) {
            if (!in_array('Innovation', $_POST['section'])) {
                $isInnovation = false;
            }

            if (!in_array('Asessment', $_POST['section'])) {
                $isAsessment = false;
            }

            if (!in_array('Presentation', $_POST['section'])) {
                $isPresentation = false;
            }

            if (!in_array('Screening', $_POST['section'])) {
                $isScreening = false;
            }

            if (!in_array('Terms', $_POST['section'])) {
                $isTerms = false;
            }
        }

        $data['innovationDoc'] = array();
        $data['innovationsupportDoc'] = array();
        $data['assesmentDoc'] = array();
        $data['presentDoc'] = array();
        $data['screeningDoc'] = array();
        $data['signDoc'] = array();

        if ($isInnovation) {
            $data['innovationDoc'] = $this->Malldocument->getInnovationDocument($id);
            $data['innovationsupportDoc'] = $this->Malldocument->getInnovationSupportingDocument($id);
        }
        if ($isAsessment) {
            $data['assesmentDoc'] = $this->Malldocument->getAssessmentDocument($id);
        }

        if ($isPresentation) {
            $data['presentDoc'] = $this->Malldocument->getPresentationDocument($id);
        }

        if ($isScreening) {
            $data['screeningDoc'] = $this->Malldocument->getscreenDoc($id);
        }

        $data['assesDoc'] = $this->Mscreening->getassessdocument($id);
        if ($isTerms) {
            $data['signDoc'] = $this->Malldocument->getsignDoc($id);
        }

        $data['generaldocument'] = $this->Malldocument->getgeneraldocument($id);
        $incubatee = $this->Malldocument->getincubateename($id);
        $username = @$incubatee['user_name'];
        $path = "../ajaxplorer/data/personal/admin/Villgro/departments/ramp/incubation/incubation-innovations-funded";
        $file_names = $this->scanFileNameRecursivly($path);
        $files = array();
        foreach ($file_names as $key => $value) {
            if (isset($username)) {
                if (strpos($value, strtolower($username))) {
                    $files[] = $value;
                }
            }
        }
        $data['files'] = $files;
        $data['cpagetitle'] = "All Document";
        $this->load->vars($data);
        $data['cpage'] = "alldocument";
        $data['custom_js'] = array('list_page');
        if ($this->session->userdata('user_type') != 'incubatee') {
            $data['left_box'] = array('innovation_tab');
            $this->load->view('../template', $data);
        } else {
            $this->load->view('../template', $data);
        }
    }

    public function upload_document($innovation = null) {
        $info = $this->Minnovation->getInnovation($innovation);
        $enterpriseinfo = $this->Minnovation->getinfo($innovation);
        $data['name_of_enterprise'] = $info['name_of_enterprise'];
        $data['innovation'] = $innovation;

        if (isset($_POST['txtsubmit'])) {
            $options = array();
            $this->load->library('upload');
            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/upload_document';
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';
            $config['file_name'] = date('Ymdhis') . '_' . str_replace(' ', '_', $_FILES['upload_document']["name"]);

            $this->upload->initialize($config);

            $_FILES['upload']['name'] = $config['file_name'];
            $_FILES['upload']['tmp_name'] = $_FILES['upload_document']['tmp_name'];
            $_FILES['upload']['size'] = $_FILES['upload_document']['size'];
            $_FILES['upload']['type'] = $_FILES['upload_document']['type'];
            $_FILES['upload']['error'] = $_FILES['upload_document']['error'];

            $this->upload->do_upload('upload');

            $options = $_POST;
            $options['files'] = $config['file_name'];
            $value = $this->Malldocument->insertdocuments($options);
            redirect('common/alldocument/view_list/' . $value);
            $this->session->set_flashdata('successMsg', 'Documents Inserted Successfully');
        }
    }

    public function scanFileNameRecursivly($path = '', $name = array()) {
        $path = $path == '' ? dirname(__FILE__) : $path;
        $lists = @scandir($path);
        if (!empty($lists)) {
            foreach ($lists as $f) {

                if (is_dir($path . DIRECTORY_SEPARATOR . $f) && $f != ".." && $f != ".") {

                } else {
                    $name[] = $path . DIRECTORY_SEPARATOR . $f;
                }
            }
        }
        return $name;
    }

    public function searachfiles() {
        $path = "../ajaxplorer/data/personal/admin/Villgro/departments/ramp/incubation/incubation-innovations-funded";
        $files = array();
        foreach ($file_names as $key => $value) {
            if (strpos($value, 'utmt')) {
                $files[] = $value;
            }
        }
        echo "<pre>";
        print_r($files);
        echo "</pre>";
    }

}
