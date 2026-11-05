<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Checklist extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mmaster_settings');
        $this->load->model('Mchecklist');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('master/checklist/view_list');
    }
    public function view_list()
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/checklist/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mchecklist->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['areaList'] = $this->Mmaster_settings->getMasterSetting('Area/Origin');
        $data['checkList'] = $this->Mchecklist->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Checklist Master";
        $data['cpage'] = "checklist/listChecklist";

        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');

        $this->load->view('../template', $data);
    }
    public function form($id = '')
    {
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Mchecklist->update($_POST);
                $msg = "Record inserted!";
            } else {
                $result = $this->Mchecklist->insert($_POST);
                $msg = "Record Updated!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('master/checklist/view_list');
        }
        $data['checklistDetails'] = array();
        if ($id != '') {
            $data['checklistDetails'] = $this->Mchecklist->getChecklistInfo($id);
            if (php72_count($data['checklistDetails']) == 0) {
                redirect('master/checklist/form');
            }

            $data['cpagetitle'] = "Edit Checklist";
        } else {
            $data['cpagetitle'] = "Add Checklist";
        }
        $data['areaList'] = $this->Mmaster_settings->getMasterSetting('Area/Origin');
        $data['cpage'] = "checklist/addChecklist";
        $this->load->view('../template_plain', $data);
    }

    /**
     * Function : delete method is used for delete mailtemplates.
     *
     * @param int $id
     *
     */
    public function delete($id = '')
    {
        if ($id != '') {
            $result = $this->Mchecklist->delete($id);
            if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Checklist deleted Successfully');
            }

        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/checklist/view_list');
    }
    /**
     * Function : changestatus method is used for Changing Status of the mailtemplates.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function changestatus($id = '', $status = '')
    {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mchecklist->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Source Status updated');
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/checklist/view_list');
    }

}
