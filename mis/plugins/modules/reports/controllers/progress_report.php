<?php
/* This file is used for Report as Pdf
 *  Any chnage in this fuction may cause unknown behaviour
 * Author : Sanjay
 * Date of Modified : 26-01-2012
 */

class Progress_report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck(); // Check user logged in or not
        $this->items_perpage = '15';
        $this->load->model('master/mprogress_master');
        $this->load->model('scouting/Minnovation');
        $this->load->model('mprogress_report');
        $this->load->model('login/Muser');
        $this->load->model('incubationprogress/Mincubationprogress');
    }
    public function index($innovation, $mastertype = null, $mastername = null, $type = null, $subcategory = null, $frequency = null, $yearly = null, $monthly = null, $quarterly = null, $weekly = null)
    {

        $data['mastertype'] = $this->Mincubationprogress->getmastertype();
        $data['innovation'] = $innovation;
        $data['type'] = array('metrices', 'activity');
        $data['frequency'] = array('Weekly' => 1, 'Monthly' => 2, 'Quarterly' => 3, 'Yearly' => 4);
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['quarterly'] = array('1', '2', '3', '4');
        $data['weekly'] = array('1', '2', '3', '4', '5');
        $mastertype = urldecode(@$mastertype);
        $mastername = urldecode(@$mastername);
        $type = urldecode(@$type);
        $subcategory = urldecode(@$subcategory);
        $data['defaultfrequency'] = $frequency;
        $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
        $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
        $data['monthanswerreport'] = $this->mprogress_report->getmonthanswerreport($innovation, $data['innovationChecklist']);
        $data['innovation'] = $innovation;
        $data['company'] = $this->Minnovation->getInnovation($innovation);
        $data['name_of_enterprise'] = $data['company']['name_of_enterprise'];
        $data['left_box'] = array('incubation', 'innovation_tab');
        $data['cpagetitle'] = "Progress Report";
        $data['cpage'] = 'villgro_progress_reports_backup';
        $this->load->view('./dashboard_template', $data);
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
    /* This Function is used for Exporting Pdf
     *  Any chnage in this fuction may cause unknown behaviour
     * Author : Sanjay
     * Date of Modified : 04-02-2012
     */
    public function exportactivity($innovation)
    {

        $year = $this->input->post("year");
        $data['activityList'] = $this->mprogress_report->getactivityreportbyyear($innovation, $year);
        $dataView = $this->load->view('reports/export_activity', $data, true);

        $this->load->helper(array('dompdf', 'file'));
        $this->load->helper('file');
        $pdfName = $year . "-Activity Progress_report";
        $pdfData = pdf_create($dataView, $pdfName);
        write_file('Activity Report', $pdfData);
    }
    /* This Function is used for Exporting Pdf
     *  Any chnage in this fuction may cause unknown behaviour
     * Author : Sanjay
     * Date of Modified : 04-02-2012
     */
    public function pdfExport($innovation)
    {

        $year = $this->input->post("defaultYear");
        $month = $this->input->post("month");
        $data['progressList'] = $this->mprogress_report->getProgressReportDetailsByMONTH($innovation, $month, $year);
        $data['month'] = $month;
        $data['year'] = $year;
        $dataView = $this->load->view('reports/export_progress', $data, true);
        $this->load->helper(array('dompdf', 'file'));
        $this->load->helper('file');
        if ($month == '1') {$monthName = "January";}if ($month == '2') {$monthName = "February";}
        if ($month == '3') {$monthName = "March";}if ($month == '4') {$monthName = "April";}
        if ($month == '5') {$monthName = "May";}if ($month == '6') {$monthName = "June";}
        if ($month == '7') {$monthName = "July";}if ($month == '8') {$monthName = "August";}
        if ($month == '9') {$monthName = "September";}if ($month == '10') {$monthName = "October";}
        if ($month == '11') {$monthName = "November";}if ($month == '12') {$monthName = "December";}
        $pdfName = $monthName . "-" . $year . "_Progress_report";
        exportMeAsMPDF($dataView, $pdfName);

    }
    /* This Function is used for Exporting Pdf
     *  Any chnage in this fuction may cause unknown behaviour
     * Author : Sanjay
     * Date of Modified : 04-02-2012
     */
    public function pdfQuarterExport($innovation)
    {
        $quarter = $this->input->post("quarter");
        $year = $this->input->post("defaultYear");
        $data['progressList'] = $this->mprogress_report->getProgressReportDetailsByQuarter($innovation, $quarter, $year);
        $data['quarter'] = $quarter;
        $data['year'] = $year;
        $dataView = $this->load->view('reports/export_progress_quarter', $data, true);
        $this->load->helper(array('dompdf', 'file'));
        $this->load->helper('file');
        if ($quarter == '1') {$quarterName = "1st Quarter";}
        if ($quarter == '2') {$quarterName = "2nd Quarter";}
        if ($quarter == '3') {$quarterName = "3rd Quarter";}
        if ($quarter == '4') {$quarterName = "4th Quarter";}
        $pdfName = $quarterName . "-" . $year . "_Progress_report";
        $pdfData = pdf_create($dataView, $pdfName);
        write_file('Progress Repost', $pdfData);
    }
    /* This Function is used for Exporting Pdf
     *  Any chnage in this fuction may cause unknown behaviour
     * Author : Sanjay
     * Date of Modified : 04-02-2012
     */
    public function pdfYearExport($innovation)
    {
        $year = $this->input->post("defaultYear");
        $data['progressList'] = $this->mprogress_report->getProgressReportDetailsByYEAR($innovation, $year);
        $data['year'] = $year;
        $dataView = $this->load->view('reports/export_progress_year', $data, true);
        $pdfName = $year . "_Progress_report";
        exportMeAsMPDF($dataView, $pdfName);
    }

    public function form($innovation, $mastertype = null, $mastername = null, $type = null, $subcategory = null, $frequency = null, $yearly = null, $monthly = null, $quarterly = null, $weekly = null)
    {
        $data['mastertype'] = $this->Mincubationprogress->getmastertype();
        $data['innovation'] = $innovation;
        $data['type'] = array('metrices', 'activity');
        $data['frequency'] = array('Weekly' => 1, 'Monthly' => 2, 'Quarterly' => 3, 'Yearly' => 4);
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
                $subcategory = @$data['subcategory'][0]['subcategory'];
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
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];
            $data['weekreport'] = $this->Mincubationprogress->getweekreport($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);
            for ($i = 0; $i < count($data['weekly']); $i++) {
                $data['weekanswerreport' . $i] = $this->Mincubationprogress->getweekanswerreport($frequency, $data['innovationChecklist'], $innovation, $monthly, $subcategory, $yearly, $type, $mastertype, $criteria);
            }
        }
        if ($frequency == '2') {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];
            $data['monthreport'] = $this->Mincubationprogress->getmonthreport($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);

            for ($i = 0; $i < count($data['monthly']); $i++) {
                $data['monthanswerreport' . $i] = $this->Mincubationprogress->getmonthanswerreport($frequency, $data['innovationChecklist'], $innovation, $data['monthly'][$i], $subcategory, $yearly, $type, $mastertype, $criteria);
            }
        }
        if ($frequency == '3') {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];
            $data['quarterlyreport'] = $this->Mincubationprogress->getquarterlyreport($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);
            
            for ($i = 0; $i < count($data['quarterly']); $i++) {
                $data['quarterreport' . $i] = $this->Mincubationprogress->getquarterreport($frequency, $data['innovationChecklist'], $innovation, $data['quarterly'][$i], $subcategory, $yearly, $type, $mastertype, $criteria);
            }
        } else {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];
            $data['yearreport'] = $this->Mincubationprogress->getyear_report($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);
            for ($i = 0; $i < count($data['yearly']); $i++) {
                $data['yearanswerreport' . $i] = $this->Mincubationprogress->getyearanswerreport($frequency, $data['innovationChecklist'], $innovation, $data['yearreport'], $subcategory, $data['yearly'][$i], $type, $mastertype, $criteria);
            }
        }
        $data['innovation'] = $innovation;
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

}
