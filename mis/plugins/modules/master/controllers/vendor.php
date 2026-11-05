<?php

/* -
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */

class Vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mvendor');
        $this->items_perpage = '15';
        $this->Mauth->isAdminUser();
    }

    public function index() {
        redirect('master/vendor/view_list');
    }

    public function view_list() {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/vendor/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mvendor->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends
        #Loading View and data
        $data['vendorList'] = $this->Mvendor->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['title'] = "Vendors Management";
        $data['form'] = "vendor/listVendor";
        $this->load->view('../template', $data);
    }

    public function add() {
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $result = $this->Mvendor->insert($_POST);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record inserted !');
                    redirect('master/vendor');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['title'] = "Add Vendors";
        $data['form'] = "vendor/addVendor";
        $this->load->view('../template', $data);
    }

    public function edit($id) {
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                //insert vendors
                $result = $this->Mvendor->update($_POST);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record Updated !');
                    redirect('master/vendor');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }

        #Loading View and data
        $data['vendorDetails'] = $this->Mvendor->getVendorInfo($id);
        $data['title'] = "Edit Vendors";
        $data['form'] = "vendor/editVendor";
        $this->load->view('../template', $data);
    }

    /**
     * Function : delete method is used for delete vendors.
     *
     * @param int $id
     *
     */
    public function delete($id = '') {
        if ($id != '') {
            $result = $this->Mvendor->delete($id);
            $this->session->set_flashdata('successMsg', 'Vendor deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/vendor/view_list');
    }

    /**
     * Function : changestatus method is used for Changing Status of the vendors.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function changestatus($id = '', $status = '') {
        if ($id != '' && $status != '') {
            $options = array('vendor_id' => $id, 'status' => $status);
            $this->Mvendor->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Vendor Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/vendor/view_list');
    }

    /**
     * Function : _validation method is used for validation before add, edit vendor.
     *
     * Function called by:
     * ---------------
     * $this->add()
     * $this->edit()
     *
     * @param null
     */
    public function _validation() {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required');
        $this->form_validation->set_rules('vendor_email', 'Email Address', 'required|valid_email');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

}
