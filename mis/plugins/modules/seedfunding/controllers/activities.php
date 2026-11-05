<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Activities extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Msfactivities');
        $this->load->model('Mgoal');
        $this->load->model('Mmilestone');
        $this->load->model('Minstallment');
        $this->load->model('scouting/Minnovation');
        $this->load->model('Mactivity');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('seedfunding/activities/view_list');
    }
    public function view_list($innovation)
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(5);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('seedfunding/activities/view_list/' . $innovation),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Msfactivities->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 5);
        if ($this->uri->segment("5") != "ex") {
            $this->pagination->initialize($config);
        }
        #pagination Ends
        if (isset($_POST['txtSubmit'])) {
            $options = $_POST;
            $data['activitiesList'] = $this->Msfactivities->getActivityLists($innovation, $options['milestone']);

        } else {
            $data['activitiesList'] = $this->Msfactivities->getActivityLists($innovation);
        }
        #Loading View and data
        $data['innovation'] = $inno = $this->Minnovation->getInnovation($innovation);
        if ($inno['partner_id'] != '1' || $inno['partner_id'] != '01') {

            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login');
        }
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['milestoneList'] = $this->Mmilestone->getMilestoneList($innovation);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Incubation Plan";
        $data['cpage'] = "listActivities";

        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');
        }
        if ($this->uri->segment("5") == "ex") {

            $data['cpagetitle'] = " ";
            $data['pageTitle'] = "Seedfunding Report";
            $data['filename'] = "Seedfunding_Report";
            $data['htmView'] = $this->load->view('seedfunding/listActivities', $data, true);
            $templateView = $this->load->view('../template_export', $data, true);
            exportMeAsMPDF($templateView, $data['filename']);
        }

        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);
    }
    public function form($innovation, $id = null)
    {
        $data['innovation'] = $innovation;
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Msfactivities->updatefund($_POST);
                $msg = "Record updated!";
            } else {

                $result = $this->Msfactivities->insert($_POST);
                $msg = "Record Inserted!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('seedfunding/activities/view_list/' . $innovation);
        }

        $data['activitiesDetails'] = array();
        if ($id != null) {
            $data['activitiesDetails'] = $this->Msfactivities->getActivityDetails($innovation, $id);
            $data['cpagetitle'] = "Edit Activities";
        } else {
            $data['cpagetitle'] = "Add Activities";
        }

        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['goalList'] = $this->Mgoal->getGoalList($innovation);
        $data['activityList'] = $this->Mactivity->getactivityList($innovation);
        $data['cpage'] = "formActivities";
        $this->load->view('../template_plain', $data);
    }
    public function delete($innovation, $id = '')
    {
        $result = $this->Msfactivities->delete($id);
        if (!empty($result)) {
            $this->session->set_flashdata('errorMsg', $mysqlError($result));
        } else {
            $this->session->set_flashdata('successMsg', 'Line Item Deleted Successfully');
        }

        redirect('seedfunding/activities/view_list/' . $innovation);
    }
    public function get()
    {
        if ($this->input->post('goals')) {
            $data['milestoneList'] = $this->Mmilestone->getMilestoneLists($this->input->post('goals'), $this->input->post('innovation'));

            echo json_encode($data['milestoneList']);exit;
        }
    }
    public function getactivity()
    {
        if ($this->input->post('installments')) {
            $data['activityList'] = $this->Mmilestone->getactivityLists($this->input->post('installments'), $this->input->post('innovation'));
            echo json_encode($data['activityList']);exit;

        }

    }

}
