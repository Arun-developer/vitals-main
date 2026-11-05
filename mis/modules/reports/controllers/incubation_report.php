<?php
class Incubation_report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck(); // Check user logged in or not
        $this->items_perpage = '15';
        $this->load->model('master/mprogress_master');
        $this->load->model('scouting/Minnovation');
        $this->load->model('mincubation_report');
        $this->load->model('login/Muser');
        $this->load->model('Seedfunding/Mseedfunding');
        $this->load->model('seedfunding/Msfactivities');
    }
    public function index($innovation, $id = null)
    {
        if (isset($_POST)) {
            $data['lineitem'] = $this->mincubation_report->getlineitem($innovation);
            $data['monthreport'] = @$this->mincubation_report->getreport($innovation, $data['lineitem'], $_POST['month'], $_POST['year']);
        } else {
            $data['lineitem'] = $this->mincubation_report->getlineitem($innovation);
            $data['monthreport'] = $data['targetDetails'] = $this->Mseedfunding->getTargetDetails($id);
        }
        if ($_POST['month'] == '') {
            $data['mon'] = date('F');
        } else {
            $data['mon'] = $_POST['month'];
        }

        if ($_POST['year'] == '') {
            $data['year'] = date('Y');
        } else {
            $data['year'] = $_POST['year'];
        }

        $data['innovation'] = $innovation;
        $data['activitiesList'] = $this->Msfactivities->getActivityLists($innovation);
        $data['progressStatus'] = $this->Msfactivities->progressStatus();
        $data['cpagetitle'] = 'Incuabtion Report';
        $data['cpage'] = 'incubation_report';
        $this->load->view('../dashboard_template', $data);
    }

    public function yearlyreport()
    {
        $data['urlcode'] = $this->uri->segment(4);
        $data['tabKey'] = $this->uri->segment(5);
        $data['reportDetails'] = $this->mprogress_master->getcriteriaList();
        $data['fieldsList'] = $this->mprogress_report->getfieldsListyearly();
        $data['answerList'] = $this->mprogress_report->getanswerList();
        $data['cpage'] = 'view_reports';
        $data['cpagetitle'] = 'Incubation Progress Reports';
        $this->load->view('../dashboard_template', $data);
    }
    public function fund_utilized($innovation)
    {
        if (isset($_POST)) {
            $data['lineitem'] = $this->mincubation_report->getlineitem($innovation);
            $data['monthreport'] = @$this->mincubation_report->getreport($innovation, $_POST['month'], $_POST['year']);
        } else {
            $data['lineitem'] = $this->mincubation_report->getlineitem($innovation);
            $data['monthreport'] = $this->mincubation_report->getreport($innovation);
        }
        $data['innovation'] = $innovation;
        $data['activitiesList'] = $this->Msfactivities->getActivityLists($innovation);
        $data['progressStatus'] = $this->Msfactivities->progressStatus();
        $data['cpagetitle'] = 'Incuabtion Report';
        $data['cpage'] = 'fund_utilized';
        $this->load->view('../dashboard_template', $data);
    }

    public function activityreport($innovation)
    {
        $data['innovation'] = $innovation;
        $data['company'] = $this->Minnovation->getInnovation($innovation);
        $data['name_of_enterprise'] = $data['company']['name_of_enterprise'];
        $data['userslist'] = $this->Muser->getUsersList();
        if (isset($_POST['txtSubmit'])) {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $frommonth = $_POST['getMonth']['fromMonth'];
            $tomonth = $_POST['getMonth']['toMonth'];
            $data['activityList'] = $this->mprogress_report->getactivityList($innovation, $data['innovationChecklist'], $frommonth, $tomonth);
        } else {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['activityList'] = $this->mprogress_report->getactivityList($innovation, $data['innovationChecklist']);
        }
        $data['cpagetitle'] = "Activtiy List Report";
        $data['cpage'] = 'view_activity_reports';
        $this->load->view('../dashboard_template', $data);
    }

    public function pdfExport($innovation)
    {
        $year = $this->input->post("defaultYear");
        $month = $this->input->post("month");
        $data['progressList'] = $this->mprogress_report->getProgressReportDetailsByMONTH($innovation, $month, $year);
        $dataView = $this->load->view('reports/export_progress', $data, true);
        $this->load->helper(array('dompdf', 'file'));
        $this->load->helper('file');
        $pdfName = $month . "-" . $year . "Progress_report";
        $pdfData = pdf_create($dataView, $pdfName);
        write_file('Progress Repost', $pdfData);
    }

    public function form($innovation, $mastertype = null, $mastername = null, $type = null, $subcategory = null, $frequency = null, $yearly = null, $monthly = null, $quarterly = null, $weekly = null)
    {
        $data['mastertype'] = $this->Mincubationprogress->getmastertype();
        $data['innovation'] = $innovation;
        $data['type'] = array('metrices', 'activity');
        $data['frequency'] = array('Monthly' => 2, 'Quarterly' => 3);
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['quarterly'] = array('1', '2', '3', '4');
        $data['weekly'] = array('1', '2', '3', '4', '5');
        $mastertype = urldecode($mastertype);
        $mastername = urldecode($mastername);
        $type = urldecode($type);
        $subcategory = urldecode($subcategory);
        if ($mastertype == null) {
            $mastertype = $data['mastertype'][0]['master_type'];
        }
        $data['defaultms'] = $mastertype;
        $data['submastertype'] = $this->Mincubationprogress->getsubmastertype($mastertype);
        if ($mastername == null) {
            $mastername = $data['submastertype'][0]['master_name'];
        }
        $data['defaultsubms'] = $mastername;
        if ($type == null) {
            $type = $data['type'][0];
        }
        $data['defaulttype'] = $type;
        if ($type == 'metrices') {
            $data['subcategory'] = $this->Mincubationprogress->getsubcategory($mastertype, $mastername, $type);
            if ($subcategory == null) {
                $subcategory = $data['subcategory'][0]['subcategory'];
            }
            $data['defaultsubcategory'] = $subcategory;
        }
        if ($frequency == null) {
            $frequency = $data['frequency']['Monthly'];
        }
        $data['defaultfrequency'] = $frequency;
        if ($frequency != '4') {
            if ($yearly == null) {
                $yearly = date('Y');
            }
            $data['defaultyearly'] = $yearly;
            if ($monthly == null) {
                $monthly = date('m');
            }
            $data['defaultmonthly'] = $monthly;
            if ($quarterly == null) {
                $quarterly = $data['quarterly'][0];
            }
            $data['defaultquarterly'] = $quarterly;
            if ($weekly == null) {
                $weekly = $data['weekly'][0];
            }
            $data['defaultweekly'] = $weekly;
        }
        if ($frequency == '1') {
            $data['weekreport'] = $this->Mincubationprogress->getweekreport($innovation, $frequency, $subcategory, $mastername);
            for ($i = 0; $i < php72_count($data['weekly']); $i++) {
                $data['weekanswerreport' . $i] = $this->Mincubationprogress->getweekanswerreport($frequency, $data['weekly'][$i], $subcategory, $type, $mastername, $yearly, $monthly);
            }
        }
        if ($frequency == '2') {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];

            $data['monthreport'] = $this->Mincubationprogress->getmonthreport($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);

            for ($i = 0; $i < php72_count($data['monthly']); $i++) {
                $data['monthanswerreport' . $i] = $this->Mincubationprogress->getmonthanswerreport($frequency, $data['innovationChecklist'], $innovation, $data['monthly'][$i], $subcategory, $yearly, $type, $mastertype, $criteria);
            }
        }
        if ($frequency == '3') {
            $data['quarterlyreport'] = $this->Mincubationprogress->getquarterlyreport($innovation, $frequency, $subcategory);
            for ($i = 0; $i < php72_count($data['quarterly']); $i++) {
                $data['quarterreport' . $i] = $this->Mincubationprogress->getquarterreport($frequency, $data['quarterly'][$i], $subcategory, $yearly, $type);
            }
        } else {
            $data['yearreport'] = $this->Mincubationprogress->getyear_report($innovation, $subcategory, $frequency, $type);
            for ($i = 0; $i < php72_count($data['yearly']); $i++) {
                $data['yearanswerreport' . $i] = $this->Mincubationprogress->getyearanswerreport($frequency, $data['yearly'][$i], $subcategory, $type);
            }
        }
        $data['company'] = $this->Minnovation->getInnovation($innovation);
        $data['name_of_enterprise'] = $data['company']['name_of_enterprise'];
        $data['left_box'] = array('incubation', 'innovation_tab');
        $data['cpagetitle'] = "Progress Report";
        $data['cpage'] = 'villgro_progress_reports';
        $this->load->view('../template', $data);
    }
    public function usersearch($innovation)
    {
        $user = $this->input->post('users');
        $data['company'] = $this->Minnovation->getInnovation($innovation);
        $data['name_of_enterprise'] = $data['company']['name_of_enterprise'];
        $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
        $data['userslist'] = $this->Muser->getUsersList();
        $data['activityList'] = $this->mprogress_report->getactivityList($innovation, $data['innovationChecklist'], null, null, $user);
        $data['innovation'] = $innovation;
        $data['cpage'] = 'view_activity_reports';
        $data['cpagetitle'] = "Activtiy List Report";
        $this->load->view('../template_plain', $data);
    }
    public function view_incubateereport($innovation, $year = null, $month = null)
    {
        $data['innovation'] = $innovation;
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        if (empty($month)) {
            $month = date('m');
        }

        if (empty($year)) {
            $year = date('Y');
        }

        $data['defaultmonth'] = $month;
        $data['defaultyear'] = $year;
        $this->load->model('mprogress');
        $data['incubatee_report'] = $this->mprogress->getincubatee_report($innovation, $month, $year);
        $data['cpage'] = 'incubatee_report';
        $data['cpagetitle'] = 'View Report';
        $this->load->view('../template', $data);

    }
    public function add_incubatee_report($innovation, $year = null, $month = null)
    {
        $data['innovation'] = $innovation;
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        if (empty($month)) {
            $month = date('m');
        }

        if (empty($year)) {
            $year = date('Y');
        }

        $data['defaultmonth'] = $month;
        $data['defaultyear'] = $year;
        if (isset($_POST['txtSubmit'])) {
            $this->upload($_FILES);
            for ($i = 0; $i < php72_count($_FILES['document']['name']); $i++) {
                $_POST['document'][$i] = $_FILES['document']['name'][$i];
            }
            $this->load->model('mprogress');
            $this->mprogress->add_incubatee_report($_POST);
            $this->session->set_flashdata('successMsg', 'Document Added Successfully');
            redirect('reports/incubation_report/add_incubatee_report/' . $innovation);
        }
        $data['cpage'] = 'add_incubatee_report';
        $data['cpagetitle'] = 'Add Report';
        $this->load->view('../template', $data);

    }
    public function upload($options)
    {
        $msg = '';
        $config['upload_path'] = './uploads/documents/';
        $config['allowed_types'] = '*';
        $_POST['document'] = '';
        $this->load->library('upload');
        for ($i = 0; $i < php72_count($options['document']['name']); $i++) {
            if ($options['document']['name'][$i] != '') {
                $_FILES['ty']['name'] = $options['document']['name'][$i];
            }

            $_FILES['ty']['tmp_name'] = $options['document']['tmp_name'][$i];
            $_FILES['ty']['size'] = $options['document']['size'][$i];
            $_FILES['ty']['type'] = $options['document']['type'][$i];
            $this->upload->initialize($config);
            $this->upload->do_upload('ty');
        }
        return $msg;
    }
    public function view_report($year = null, $month = null)
    {
        $this->load->model('mprogress_report');
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        if (empty($month)) {
            $month = date('m');
        }

        if (empty($year)) {
            $year = date('Y');
        }

        $data['defaultmonth'] = $month;
        $data['defaultyear'] = $year;
        $data['kra_details'] = $this->mprogress_report->getkra_details($month, $year);
        $data['cpage'] = 'kra_report';
        $data['cpagetitle'] = 'KRA Report';
        $this->load->vars($data);
        $this->load->view('../template');
    }

}
