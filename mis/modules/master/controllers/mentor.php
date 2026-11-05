<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Mentor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';
        $this->load->model('Mmentor');
    }
    public function index()
    {
        redirect('master/applicant/view_list');
    }
    public function view_list()
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Loading View and data
        $data['left_box'] = array('master');
        $data['mentorList'] = $this->Mmentor->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['cpagetitle'] = "Mentor list";
        $data['cpage'] = "mentor/listmentor";
        $this->load->view('../template', $data);

    }
    public function add()
    {
        $exparr = array();
        $sectorarr = array();
        $exparr = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6');
        $sectorarr = array(1 => 'Agriculture', 2 => 'Water', 3 => 'Energy', 4 => 'Others');
        $data['exparr'] = $exparr;

        $data['sectorarr'] = $sectorarr;
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;

            if ($_FILES['photograph']['name'] != '') {
                $options['photograph'] = $_FILES['photograph']['name'];
            } else {
                $_FILES['photograph']['name'] = "";
                $options['photograph'] = "";
            }

            if ($_FILES['resume']['name'] != '') {
                $options['resume'] = $_FILES['resume']['name'];
            } else {
                $_FILES['resume']['name'] = "";
                $options['resume'] = "";
            }

            $result = $this->Mmentor->insert($options);
            if ($result) {
                $this->session->set_flashdata('successMsg', 'Record inserted !');
                redirect('master/mentor');
            }
        }
        $data['cpagetitle'] = "Add Applicant";
        $data['cpage'] = "mentor/addapplicant";
        $this->load->view('../template', $data);
    }
    public function edit($id = null)
    {
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;

            if ($_FILES['photograph']['name'] != '') {
                $options['photograph'] = $_FILES['photograph']['name'];
            } else {
                $_FILES['photograph']['name'] = "";
                $options['photograph'] = "";
            }

            if ($_FILES['resume']['name'] != '') {
                $options['resume'] = $_FILES['resume']['name'];
            } else {
                $_FILES['resume']['name'] = "";
                $options['resume'] = "";
            }

            $result = $this->Mmentor->update($options);
            if ($result) {
                $this->session->set_flashdata('successMsg', 'Record Updated !');
                redirect('master/mentor/view_list');
            }
        }
        $data['id'] = $id;
        #Loading View and data
        $exparr = array();
        $sectorarr = array();
        $exparr = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6');
        $sectorarr = array(1 => 'Agriculture', 2 => 'Water', 3 => 'Energy', 4 => 'Others');
        $data['sectorarr'] = $sectorarr;
        $data['exparr'] = $exparr;
        $data['left_box'] = array('master');
        $data['investerDetails'] = $this->Mmentor->getapplicantInfo($id);
        $data['cpagetitle'] = "Edit Applicant";
        $data['cpage'] = "mentor/editinvester";
        $this->load->view('../template', $data);
    }

    public function viewprofile($id = null)
    {
        $data['applicantDetails'] = $this->Mmentor->getapplicantInfo($id);
        $data['cpagetitle'] = "View Profile";
        $data['cpage'] = "mentor/viewprofile";
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
            $result = $this->Mmentor->delete($id);
            $this->session->set_flashdata('successMsg', 'Applicant deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/mentor/view_list');
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

            $this->Mmentor->changeStatus($options);
            redirect('master/mentor/view_list');
            $this->session->set_flashdata('successMsg', ' Status updated');

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/mentor/view_list');
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
