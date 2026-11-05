<?php
class Means_validation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mmeans_validation');
        $this->load->model('Mmaster_settings');
        $this->items_perpage = '15';
        $this->Mauth->isAdminCheck();
    }
    public function index()
    {
        redirect('master/means_validation/view_list');
    }
    public function view_list()
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/means_validation/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mmeans_validation->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');
        $data['validationList'] = $this->Mmeans_validation->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Screening Master - Means of Validation";
        $data['cpage'] = "validation/listValidation";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);

    }
    public function form($id = '')
    {
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Mmeans_validation->update($_POST);
                $msg = "Record inserted!";
            } else {
                $result = $this->Mmeans_validation->insert($_POST);
                $msg = "Record Updated!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('master/means_validation/view_list');
        }
        $data['validationDetails'] = array();
        if ($id != '') {
            $data['validationDetails'] = $this->Mmeans_validation->getValidationInfo($id);
            if (count($data['validationDetails']) == 0) {
                redirect('master/means_validation/form');
            }

            $data['cpagetitle'] = "Edit Fields";
        } else {
            $data['cpagetitle'] = "Add Fields";
        }
        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');
        $data['cpage'] = "validation/addValidation";
        $this->load->view('../template_plain', $data);
    }

    /**
     * Function : delete method is used for delete means_validations.
     *
     * @param int $id
     *
     */
    public function delete($id = '')
    {
        if ($id != '') {
            $result = $this->Mmeans_validation->delete($id);
            if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Validation deleted Successfully');
            }

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/means_validation/view_list');
    }

    public function changestatus($id = '', $status = '')
    {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mmeans_validation->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Field Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/means_validation/view_list');
    }

}
