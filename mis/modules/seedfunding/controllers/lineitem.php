<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Lineitem extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mlineitem');
        $this->load->model('Mbudget');
        $this->load->model('scouting/Minnovation');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('screening/lineitem/view_list');
    }
    public function view_list($innovation)
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(5);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('screening/lineitem/view_list/' . $innovation),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mlineitem->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 5);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['budgetList'] = $this->Mbudget->getBudgetList($innovation);
        $data['lineitemList'] = $this->Mlineitem->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');

        $data['cpagetitle'] = "Incubation Plan";
        $data['cpage'] = "/listLineitem";
        $data['left_box'] = array('screening', 'innovation_tab');

        $this->load->view('../template', $data);
    }
    public function form($innovation, $id = '')
    {
        $data['innovation'] = $innovation;
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Mlineitem->update($_POST);
                $msg = "Record inserted!";
            } else {
                $result = $this->Mlineitem->insert($_POST);
                $msg = "Record Updated!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('screening/lineitem/view_list/' . $innovation);
        }

        $data['lineitemDetails'] = array();
        if ($id != '') {
            $data['lineitemDetails'] = $this->Mlineitem->getLineitemDetails($id);
            if (php72_count($data['lineitemDetails']) == 0) {
                redirect('screening/lineitem/form/' . $innovation);
            }

            $data['cpagetitle'] = "Edit Report";
        } else {
            $data['cpagetitle'] = "Add Line Item";
        }
        $data['budgetList'] = $this->Mbudget->getBudgetList($innovation);
        $data['cpage'] = "formLineitem";
        $this->load->view('../template_plain', $data);
    }
    public function delete($innovation, $id = '')
    {
        $result = $this->Mlineitem->delete($id);
        if (!empty($result)) {
            $this->session->set_flashdata('errorMsg', $mysqlError($result));
        } else {
            $this->session->set_flashdata('successMsg', 'Line Item Deleted Successfully');
        }

        redirect('screening/lineitem/view_list/' . $innovation);
    }

}
