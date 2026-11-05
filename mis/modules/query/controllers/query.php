<?php
class Query extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mquery');
        $this->load->model('login/Muser');
        $this->load->model('activities/Mactivities');
        $this->load->model('scouting/Minnovation');
        $this->items_perpage = '15';
    }

    public function view_list($activity = null, $type = null)
    {
        if ($activity == null) {
            echo "Invalid Url!";exit;
        }
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(6);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('query/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mquery->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 6);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['activity'] = $activity;
        $activityDetails = $this->Mactivities->getActivityDetails($activity);
        $data['innovation'] = $activityDetails['0']['innovation'];

        $data['innovationInfo'] = $innovationInfo = $this->Minnovation->getInnovation($data['innovation']);

        $data['activityDetails'] = $activityDetails;
        $data['usersList'] = $this->Muser->getUsersList();
        $data['queryList'] = $this->Mquery->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');

        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();

        $data['cpagetitle'] = "Query";
        $data['cpage'] = "listQuery";
        $this->load->view('../template', $data);
    }
    public function add($activity = null, $type = null)
    {
        if ($activity == null) {
            echo "Invalid Url!";exit;
        }
        $data['errorMsg'] = '';
        $activityDetails = $this->Mactivities->getActivityDetails($activity);
        $data['innovation'] = $activityDetails['0']['innovation'];
        $data['innovationInfo'] = $innovationInfo = $this->Minnovation->getInnovation($data['innovation']);
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                if ($_FILES['documents']['name'] != '') {
                    $config['upload_path'] = './uploads/query';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = str_replace(' ', '_', $innovationInfo['name_of_enterprise']) . "-activities_query-" . str_replace(' ', '_', $_FILES['documents']['name']);
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('documents')) {
                        $data['errorMsg'] = $this->upload->display_errors();
                    } else {
                        $upload_data = $this->upload->data();
                        $_POST['documents'] = $upload_data['file_name'];
                    }
                } else {
                    $_POST['documents'] = '';
                }

                if (empty($data['errorMsg'])) {
                    $_POST['activity'] = $activity;
                    $result = $this->Mquery->insert($_POST);
                    $this->session->set_flashdata('successMsg', 'Record inserted !');
                    redirect('query/view_list/' . $activity);
                }
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }

        }
        $data['activity'] = $activity;
        $data['usersList'] = $this->Muser->getUsersList();
        $data['cpagetitle'] = "Add Query";
        $data['cpage'] = "addQuery";
        $this->load->view('../template_plain', $data);
    }
    public function edit($activity = null, $id = null)
    {
        $data['errorMsg'] = '';
        $activityDetails = $this->Mactivities->getActivityDetails($activity);
        $data['innovation'] = $activityDetails['0']['innovation'];
        $data['innovationInfo'] = $innovationInfo = $this->Minnovation->getInnovation($data['innovation']);
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                //insert mailtemplates
                if ($_FILES['documents']['name'] != '') {
                    if (!empty($_POST['pre_documents'])) {
                        unlink('uploads/query/' . $_POST['pre_documents']);
                    }

                    $config['upload_path'] = './uploads/query';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|doc|txt';
                    $config['file_name'] = str_replace(' ', '_', $innovationInfo['name_of_enterprise']) . "-activities_query-" . str_replace(' ', '_', $_FILES['documents']['name']);
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('documents')) {
                        $data['errorMsg'] = $this->upload->display_errors();
                    } else {
                        $upload_data = $this->upload->data();
                        $_POST['documents'] = $upload_data['file_name'];
                    }
                } else {
                    $_POST['documents'] = $_POST['pre_documents'];
                }

                $_POST['id'] = $id;
                if (empty($data['errorMsg'])) {
                    $this->Mquery->update($_POST);
                    $this->session->set_flashdata('successMsg', 'Record Updated !');
                    redirect('query/view_list/' . $activity);
                }
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }

        }
        #Loading View and data
        $data['activity'] = $activity;
        $data['queryDetails'] = $this->Mquery->getQueryDetails($id);
        $data['usersList'] = $this->Muser->getUsersList();
        $data['cpagetitle'] = "Update/Answer Query";
        $data['cpage'] = "editQuery";
        $this->load->view('../template_plain', $data);
    }

    /**
     * Function : delete method is used for delete mailtemplates.
     *
     * @param int $id
     *
     */
    public function delete($activity = '', $id = '')
    {
        if ($id != '') {
            $result = $this->Mquery->delete($id);
            $this->session->set_flashdata('successMsg', 'Source deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('query/view_list/' . $activity);
    }

    /**
     * Function : changestatus method is used for Changing Status of the mailtemplates.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function changestatus($activity = '', $id = '', $status = '')
    {
        if ($activity != '' && $id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mquery->changeStatus($options);

            $this->session->set_flashdata('successMsg', 'Source Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('query/view_list/' . $activity);
    }

    /**
     * Function : _validation method is used for validation before add, edit mailtemplate.
     *
     * Function called by:
     * ---------------
     * $this->add()
     * $this->edit()
     *
     * @param null
     */

    public function _validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('subject_line', 'Subject Line', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

}
