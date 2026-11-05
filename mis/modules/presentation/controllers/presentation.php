<?php
class Presentation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('master/Mmaster');
        $this->load->model('Mpresentation');
        $this->load->model('scouting/Minnovation');
        $this->load->model('activities/Mactivities');
        $this->load->model('Mpresentation_comments');
        $this->items_perpage = '15';
    }
    public function view($id = '')
    {
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['presentationList'] = $this->Mpresentation->getDetails($id);

        $data['comments'] = $this->Mpresentation_comments->getComments($id);

        $data['cpagetitle'] = "Innovator Presentation";
        $data['cpage'] = "view_presentation";
        if ($this->session->userdata('user_type') != 'incubatee') {
            $data['left_box'] = array('innovation_tab');
        }
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function form($id = '', $present = '')
    {
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($id);
        if ($this->input->post('txtSubmit') != '') {
            if ($this->_validation()) {
                $_POST['document'] = '';
                if ($_FILES['document']['name'] != '') {
                    $config['upload_path'] = './uploads/presentation';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = str_replace(' ', '_', $innovation['name_of_enterprise']) . "_Presentation_" . str_replace(' ', '_', $_FILES['document']['name']);
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('document')) {
                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $upload_data = $this->upload->data();
                        $_POST['document'] = $upload_data['file_name'];
                    }
                }
                if ($_POST['id'] == '') {
                    $this->Mpresentation->insert($id, $_POST);
                    $this->session->set_flashdata('successMsg', 'Details added Successfully!');
                } else {
                    if ($_POST['document'] != '') {
                        unlink('uploads/presentation/' . $_POST['olddocument']);
                    } else {
                        $_POST['document'] = $_POST['olddocument'];
                    }

                    $this->Mpresentation->update($_POST);
                    $this->session->set_flashdata('successMsg', 'Details added Successfully!');
                }
                redirect('presentation/view/' . $id);
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }

        }

        $data['presentationInfo'] = array();
        $data['cpagetitle'] = "Add Information";
        if ($present != '') {
            $data['presentationInfo'] = $this->Mpresentation->getDetails($id, $present);
            $data['cpagetitle'] = "Edit Information";
        }
        $data['cpage'] = "form";
        $data['left_box'] = array('innovation_tab');
        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function _validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('description', 'Description', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }
    public function delete($innovation, $id)
    {
        if ($id != '') {
            $data['presentationInfo'] = $this->Mpresentation->getDetails($innovation, $id);
            @unlink('uploads/presentation/' . $presentationInfo['0']['document']);
            $this->Mpresentation->delete($id);
            $this->session->set_flashdata('successMsg', 'Record Deleted Successfully!');
        }
        redirect('presentation/view/' . $innovation);
    }
    public function next_grading($id)
    {
        $activity = $this->Mactivities->getActivityForGrading($id);

        if (php72_count($activity)) {
            redirect('grading/view/' . $activity['0']['id']);
        } else {
            $form['program_stage'] = '5';
            $form['activity_type'] = '29';
            $form['activity_description'] = 'Assessment Greading';
            $form['start_date'] = date("m/d/Y");
            $form['end_date'] = '';
            $id = $this->Mactivities->insert($id, $form);
            redirect('grading/view/' . $id);
        }

    }

    #comments
    public function add_comments($id)
    {
        if ($this->input->post('txtSubmit') != '') {
            $this->Mpresentation_comments->insert($id, $_POST);
            $this->session->set_flashdata('successMsg', 'Comments added Successfully!');
            redirect('presentation/view/' . $id);
        }
    }
    public function delete_comments($id, $comment_id = '')
    {
        if ($comment_id != '') {
            $this->Mpresentation_comments->delete($comment_id);
            $this->session->set_flashdata('successMsg', 'Comments Deleted Successfully!');
        }
        redirect('presentation/view/' . $id);
    }

}
