<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mreports');
        $this->items_perpage = '15';
        $this->Mauth->isAdminCheck();
    }
    public function index()
    {
        redirect('master/reports/view_list');
    }
    public function view_list()
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/reports/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mreports->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['reportTypes'] = $this->Mreports->getReportTypes();
        $data['reportsList'] = $this->Mreports->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Custom Reports";
        $data['cpage'] = "reports/listReports";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);

    }
    public function form($id = '')
    {
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                if ($_POST['action'] == 'edit') {
                    $result = $this->Mreports->update($_POST);
                    $msg = "Record inserted!";
                } else {
                    $result = $this->Mreports->insert($_POST);
                    $msg = "Record Updated!";
                }
                $this->session->set_flashdata('successMsg', $msg);
                redirect('master/reports/view_list');
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }

        }

        $data['reportsDetails'] = array();
        if ($id != '') {
            $data['reportsDetails'] = $this->Mreports->getReportsInfo($id);
            if (php72_count($data['reportsDetails']) == 0) {
                redirect('master/reports/form');
            }

            $data['cpagetitle'] = "Edit Report";
        } else {
            $data['cpagetitle'] = "Add Report";
        }
        $data['reportTypes'] = $this->Mreports->getReportTypes();
        $data['cpage'] = "reports/addReports";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }

    /**
     * Function : delete method is used for delete reportss.
     *
     * @param int $id
     *
     */
    public function delete($id = '')
    {
        if ($id != '') {
            $result = $this->Mreports->delete($id);
            $this->session->set_flashdata('successMsg', 'Vendor deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/reports/view_list');
    }

    /**
     * Function : changestatus method is used for Changing Status of the reportss.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function changestatus($id = '', $status = '')
    {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mreports->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Vendor Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/reports/view_list');
    }

    /**
     * Function : _validation method is used for validation before add, edit reports.
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
        $this->form_validation->set_rules('report_type', 'Report Type', 'required');
        $this->form_validation->set_rules('report_name', 'Report Name', 'required');
        $this->form_validation->set_rules('report_data', 'Report Data', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

}
