<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Invester extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';
        $this->load->model('Minvester');
    }
    public function index()
    {
        redirect('master/invester/view_list');
    }
    public function view_list()
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Loading View and data
        $data['left_box'] = array('master');
        $data['boardList'] = $this->Minvester->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['cpagetitle'] = "Invester list";
        $data['cpage'] = "invester/listinvester";
        $this->load->view('../template', $data);

    }
    public function add()
    {
        $exparr = array();
        $sectorarr = array();
        $exparr = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6');
        $sectorarr = array(1 => 'Agriculture', 2 => 'Water', 3 => 'Energy', 4 => 'Others');

        $data['sectorarr'] = $sectorarr;
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;

            if ($_FILES['documents']['name'] != '') {
                $options['documents'] = $_FILES['documents']['name'];
            } else {
                $_FILES['documents']['name'] = "";
                $options['documents'] = "";
            }

            $result = $this->Minvester->insert($options);
            if ($result) {
                $this->session->set_flashdata('successMsg', 'Record inserted !');
                redirect('master/invester');
            }
        }
        $data['cpagetitle'] = "Add Invester Member";
        $data['cpage'] = "invester/addinvester";
        $this->load->view('../template', $data);
    }
    public function edit($id = null)
    {
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;

            if ($_FILES['documents']['name'] != '') {
                $options['documents'] = $_FILES['documents']['name'];
            } else {
                $_FILES['documents']['name'] = "";
                $options['documents'] = "";
            }

            $result = $this->Minvester->update($options);
            if ($result) {
                $this->session->set_flashdata('successMsg', 'Record Updated !');
                redirect('master/invester/view_list');
            }
        }
        $data['id'] = $id;

        #Loading View and data

        $exparr = array();
        $sectorarr = array();
        $exparr = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6');
        $sectorarr = array(1 => 'Agriculture', 2 => 'Water', 3 => 'Energy', 4 => 'Others');
        $data['sectorarr'] = $sectorarr;
        $data['left_box'] = array('master');
        $data['investerDetails'] = $this->Minvester->getinvesterInfo($id);
        $data['cpagetitle'] = "Edit Invester";
        $data['cpage'] = "invester/editinvester";
        $this->load->view('../template', $data);
    }

    public function viewprofile($id = null)
    {
        $data['investerDetails'] = $this->Minvester->getinvesterInfo($id);
        $data['cpagetitle'] = "View Profile";
        $data['cpage'] = "invester/viewprofile";
        $this->load->view('../template_plain', $data);
    }

    /**
     * Function : delete method is used for delete vendors.
     *
     * @param int $id
     *
     */
    public function delete($id = '')
    {
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
    public function changestatus($id = '', $status = '')
    {
        if ($id != '' && $status != '') {

            $options = array('id' => $id, 'status' => $status);

            $this->Minvester->changeStatus($options);
            $this->session->set_flashdata('successMsg', ' Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/invester/view_list');
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

    public function _validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required');
        $this->form_validation->set_rules('vendor_email', 'Email Address', 'required|valid_email');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

}
