<?php
class Application extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mmaster');
        $this->load->model('Minnovation');
    }
    public function index()
    {
        $data['upload_error'] = array();
        $form_path = "https://villgro.org/";

        if ($this->input->post('txtSubmit') != '') {
            $this->load->library('upload');
            $_POST['business_plan_document'] = '';
            if ($_FILES['business_plan_document']['name'] != '') {
                $config['upload_path'] = './uploads/innovaton/supporting_documents';
                $config['allowed_types'] = '*';
                $config['file_name'] = str_replace(' ', '_', $_POST['name_of_enterprise']) . "-business_plan-" . str_replace(' ', '_', $_FILES['business_plan_document']['name']);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('business_plan_document')) {
                    $data['upload_error'] = $this->upload->display_errors();
                } else {
                    $upload_data = $this->upload->data();
                    $_POST['business_plan_document'] = $upload_data['file_name'];
                }
                unset($config);
            }
            foreach ($_POST['document_type'] as $key => $value):

                if (($_FILES['supporting_documents']['name'][$key] != '' || $_POST['youtube'][$key] != "") && $value != '') {
                    if ($_FILES['supporting_documents']['name'][$key] != '') {
                        $config['upload_path'] = './uploads/innovaton/supporting_documents';
                        $config['allowed_types'] = '*';
                        $config['file_name'] = str_replace(' ', '_', $_POST['name_of_enterprise']) . "-supporting_documents-" . str_replace(' ', '_', $_FILES['supporting_documents']['name'][$key]);
                        $this->upload->initialize($config);

                        $_FILES['file_field']['name'] = $_FILES['supporting_documents']['name'][$key];
                        $_FILES['file_field']['tmp_name'] = $_FILES['supporting_documents']['tmp_name'][$key];
                        $_FILES['file_field']['size'] = $_FILES['supporting_documents']['size'][$key];
                        $_FILES['file_field']['type'] = $_FILES['supporting_documents']['type'][$key];
                        $_FILES['file_field']['error'] = $_FILES['supporting_documents']['error'][$key];

                        if (!$this->upload->do_upload('file_field')) {
                            $data['upload_error'] = $this->upload->display_errors();
                        } else {
                            $upload_data = $this->upload->data();
                            $_POST['supporting_documents'][] = $upload_data['file_name'];
                            $_POST['document_type_value'][] = $value;
                            $_POST['youtubeValue'][] = $_POST['youtube'][$key];
                        }
                        unset($config);

                    } else {
                        $_POST['supporting_documents'][] = '';
                        $_POST['document_type_value'][] = $value;
                        $_POST['youtubeValue'][] = $_POST['youtube'][$key];
                    }
                }
            endforeach;
            $this->Minnovation->directApplication($_POST);
            redirect($form_path . "innovation_form.php?msg=success");
        }
        $data['documentTypeList'] = $this->Mmaster->getMasterSettings('Document Checklist');
        $data['cpagetitle'] = "Incubation Application Form";
        $data['cpage'] = "innovation_form";
        $this->load->vars($data);
        $this->load->view('../template_application');
    }

}
