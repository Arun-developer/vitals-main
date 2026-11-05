<?php
class report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('master/Mmaster_settings');
        $this->load->model('master/Mreports');
        $this->load->model('scouting/Minnovation');
        $this->load->model('Minnovation_reports');
    }

    public function innovation_report($currentTab = 'default')
    {
        $options = array();
        $options = $_POST;
        $options['associate'] = '';
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            //for auth user
        } else {
            $innovation = array();
            $this->load->model('scouting/Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
            $options['associate'] = (php72_count($innovation)) ? $innovation : array();
        }

        $options['num'] = '15';
        $options['offset'] = $this->uri->segment(4);
        //show($options);
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('scouting/innovation_report/' . $currentTab),
            'per_page' => '15',
            'total_rows' => 10,
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $data['innovationList'] = $this->Minnovation_reports->getLimitReportRecords($options);
        #pagination Ends

        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['knowAboutUs'] = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reasons');

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();

        if (!empty($options['export'])) {
            $options['num'] = '';
            $options['offset'] = '';
            $reportData = $this->Minnovation_reports->getLimitReportRecords($options);
            if (php72_count($reportData)) {
                foreach ($reportData as $r):
                    $r['stage'] = $data['stage'][$r['stage']];
                    $r['status'] = $data['status'][$r['status']];
                    $reportArray[] = $r;
                endforeach;
                $this->Mexport->export($reportArray, $options['export']);
            } else {
                $data['errorMsg'] = "No Matched records found!";
            }

        }
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovation Report";
        $data['cpage'] = "report/innovation_report";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function source_wise($currentTab = 'source_wise')
    {
        $data['currentTab'] = $currentTab;
        $data['sourceWiseReport'] = $this->Minnovation_reports->getSourceWiseReport('', 'Expand');
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovation Report";
        $data['cpage'] = "report/source_wise_report";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function employee_wise($currentTab = 'employee_wise')
    {
        $data['currentTab'] = $currentTab;
        $data['employeeWiseReport'] = $this->Minnovation_reports->getEmployeeWiseReport();
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovation Report";
        $data['cpage'] = "report/employee_wise_report";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }

    #SCOUTING REPORTS#
    public function monthly_report()
    {
        $options = $_POST;

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');

        $data['monthlyReport'] = $this->Minnovation_reports->getMonthlyReport($options);
        $data['cpagetitle'] = "Monthly Report";
        $data['cpage'] = "report/monthly_report";
        $data['left_box'] = array('report', 'innovation_pool');
        $data['custom_js'] = array('list_page');
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function weekly_report()
    {
        $options = $_POST;

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');

        $data['weeklyReport'] = $this->Minnovation_reports->getWeeklyReport($options);
        $data['cpagetitle'] = "Weekly Report";
        $data['cpage'] = "report/weekly_report";
        $data['left_box'] = array('report', 'innovation_pool');
        $data['custom_js'] = array('list_page');
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function resource_completion()
    {

        $options = $_POST;
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');

        $data['resourceReport'] = $this->Minnovation_reports->getResourceWiseReport($options);
        $data['cpagetitle'] = "Resource Completion Report";
        $data['cpage'] = "report/resource_completion_report";
        $data['left_box'] = array('report', 'innovation_pool');
        $data['custom_js'] = array('list_page');
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function resource_conversion()
    {
        $options = $_POST;
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['resourceReport'] = $this->Minnovation_reports->getResourceWiseReport($options);
        $data['cpagetitle'] = "Resource Conversion Report";
        $data['cpage'] = "report/resource_convertion_report";
        $data['left_box'] = array('report', 'innovation_pool');
        $data['custom_js'] = array('list_page');
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function screening()
    {
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;
            $data['due_diligence'] = $this->Minnovation_reports->due_diligence($options);
        } else {
            $data['due_diligence'] = $this->Minnovation_reports->due_diligence();
        }
        $data['cpagetitle'] = "Screening Report";
        $data['cpage'] = "report/screening_report";
        $data['left_box'] = array('report', 'innovation_pool');
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function new_report()
    {
        $options = array();
        $option = array();
        $optionss = array();
        $options_s = array();
        $optionec = array();
        $optiontotal = array();

        $optiontotal['source_type'] = '0';
        $optiontotal['orderby'] = 'created_emp';
        $optiontotal['ordertype'] = 'ASC';
        $optiontotal['stage'] = '0';
        $optiontotal['status'] = '0';

        $options['source_type'] = '0';
        $options['stage'] = '0';
        $options['status'] = '0';

        $options_s['stage'] = '1';
        $options_s['status'] = '1';
        /*
         * report conditions ended
         */
        $optionss['stage'] = '0';
        $optionss['status'] = '0';
        $optionss['orderby'] = 'created_emp';
        $optionss['ordertype'] = 'ASC';

        $option['status'] = '!3';
        $option['grading_status'] = '1';
        $option['orderby'] = 'created_emp';
        $option['ordertype'] = 'ASC';

        $optionec['status'] = '3';
        $optionec['stage'] = '1';
        $optionec['orderby'] = 'created_emp';
        $optionec['ordertype'] = 'ASC';

        $identified_by = array();
        $innovationList = array();
        $followups = array();
        $decision_pending = array();
        $entry_closed = array();
        $total_deals = array();
        $options['offset'] = $this->uri->segment(4);

        if (!empty($_POST)) {
            $data['created_date'] = $_POST['created_date'];
            $data['created_date_to'] = $_POST['created_date_to'];
            $option['created_date'] = $_POST['created_date'];
            $option['created_date_to'] = $_POST['created_date_to'];
            $options['created_date'] = $_POST['created_date'];
            $options['created_date_to'] = $_POST['created_date_to'];
            $optionss['created_date'] = $_POST['created_date'];
            $optionss['created_date_to'] = $_POST['created_date_to'];
            $options_s['created_date'] = $_POST['created_date'];
            $options_s['created_date_to'] = $_POST['created_date_to'];
            $optionec['created_date'] = $_POST['created_date'];
            $optionec['created_date_to'] = $_POST['created_date_to'];
            $optiontotal['created_date'] = $_POST['created_date'];
            $optiontotal['created_date_to'] = $_POST['created_date_to'];
        }
        //show($options);
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('common/report/innovations_report/' . $currentTab),
            'per_page' => '15',
            'total_rows' => 10,
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $innovationList = $this->Minnovation_reports->getLimitReportRecords($options);

        $identified_by = $this->Minnovation_reports->getLimitReportRecords($optionss);
        $followups = $this->Minnovation_reports->getLimitReportRecords($options_s);
        $decision_pending = $this->Minnovation_reports->getLimitReportRecords($option);
        $entry_closed = $this->Minnovation_reports->getLimitReportRecords($optionec);
        $total_deals = $this->Minnovation_reports->getLimitReportRecords($optiontotal);

        #pagination Ends
        $data['direct_Application'] = php72_count($innovationList);
        $data['identified_by'] = php72_count($identified_by);
        $data['followups'] = php72_count($followups);
        $data['decision_pending'] = php72_count($decision_pending);
        $data['entry_closed'] = php72_count($entry_closed);
        $data['total_deals'] = php72_count($total_deals);
        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['knowAboutUs'] = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reasons');

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovations Report-Direct Application";
        $data['cpage'] = "report/common_new_report";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function innovations_report($created_date = null, $created_date_to = null, $currentTab = 'default')
    {
        $options = array();
        $options = $_POST;
        //show($_POST);
        $options['associate'] = '';
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            //for auth user
        } else {
            $innovation = array();
            $this->load->model('scouting/Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
        }
        /**
         *  report conditions
         */
        if (!empty($created_date) && !empty($created_date_to)) {
            $options['created_date'] = $created_date;
            $options['created_date_to'] = $created_date_to;
        }
        $options['source_type'] = '0';
        $options['stage'] = '0';
        $options['status'] = '0';
        /*
         * report conditions ended
         */
        $options['offset'] = $this->uri->segment(4);
        //show($options);
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('common/report/innovations_report/' . $currentTab),
            'per_page' => '15',
            'total_rows' => 10,
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $data['innovationList'] = $this->Minnovation_reports->getLimitReportRecords($options);
        #pagination Ends

        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['knowAboutUs'] = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reasons');

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();

        if (!empty($options['export'])) {
            $options['num'] = '';
            $options['offset'] = '';
            $reportData = $this->Minnovation_reports->getLimitReportRecords($options);
            if (php72_count($reportData)) {
                foreach ($reportData as $r):
                    $r['stage'] = $data['stage'][$r['stage']];
                    $r['status'] = $data['status'][$r['status']];
                    $reportArray[] = $r;
                endforeach;
                $this->Mexport->export($reportArray, $options['export']);
            } else {
                $data['errorMsg'] = "No Matched records found!";
            }

        }
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovations Report-Direct Application";
        $data['cpage'] = "report/innovations_report";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function innovations_report_identifiedBy($created_date = null, $created_date_to = null, $currentTab = 'default')
    {
        $options = array();
        $options = $_POST;

        //show($_POST);
        $options['associate'] = '';
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            //for auth user
        } else {
            $innovation = array();
            $this->load->model('scouting/Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
        }
        /**
         *  report conditions
         */
        if (!empty($created_date) && !empty($created_date_to)) {
            $options['created_date'] = $created_date;
            $options['created_date_to'] = $created_date_to;
        }
        $options['stage'] = '0';
        $options['status'] = '0';
        $options['orderby'] = 'IP.id';
        $options['ordertype'] = 'DESC';
        /*
         * report conditions ended
         */
        $options['offset'] = $this->uri->segment(4);
        //show($options);
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('common/report/innovations_report_identifiedBy/' . $currentTab),
            'per_page' => '15',
            'total_rows' => 10,
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $data['innovationList'] = $this->Minnovation_reports->getLimitReportRecords($options);
        #pagination Ends

        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['knowAboutUs'] = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reasons');

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();
        if (!empty($options['export'])) {
            $options['num'] = '';
            $options['offset'] = '';
            $reportData = $this->Minnovation_reports->getLimitReportRecords($options);
            if (php72_count($reportData)) {
                foreach ($reportData as $r):
                    $r['stage'] = $data['stage'][$r['stage']];
                    $r['status'] = $data['status'][$r['status']];
                    $reportArray[] = $r;
                endforeach;
                $this->Mexport->export($reportArray, $options['export']);
            } else {
                $data['errorMsg'] = "No Matched records found!";
            }

        }
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovations Report-Identified By";
        $data['cpage'] = "report/innovations_report_identifiedBy";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function innovations_report_followUp($created_date = null, $created_date_to = null, $currentTab = 'default')
    {
        $options = array();
        $options = $_POST;
        //show($_POST);
        $options['associate'] = '';
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            //for auth user
        } else {
            $innovation = array();
            $this->load->model('scouting/Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
        }
        /**
         *  report conditions
         */
        if (!empty($created_date) && !empty($created_date_to)) {
            $options['created_date'] = $created_date;
            $options['created_date_to'] = $created_date_to;
        }
        $options['stage'] = '1';
        $options['status'] = '1';
        $options['orderby'] = 'created_emp';
        $options['ordertype'] = 'ASC';
        /*
         * report conditions ended
         */
        $options['offset'] = $this->uri->segment(4);
        //show($options);
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('common/report/innovations_report_followUp/' . $currentTab),
            'per_page' => '15',
            'total_rows' => 10,
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $data['innovationList'] = $this->Minnovation_reports->getLimitReportRecords($options);

        #pagination Ends

        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['knowAboutUs'] = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reasons');

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();

        if (!empty($options['export'])) {
            $options['num'] = '';
            $options['offset'] = '';
            $reportData = $this->Minnovation_reports->getLimitReportRecords($options);
            if (php72_count($reportData)) {
                foreach ($reportData as $r):
                    $r['stage'] = $data['stage'][$r['stage']];
                    $r['status'] = $data['status'][$r['status']];
                    $reportArray[] = $r;
                endforeach;
                $this->Mexport->export($reportArray, $options['export']);
            } else {
                $data['errorMsg'] = "No Matched records found!";
            }

        }
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovations Report - Entry/Lead Follow-UP";
        $data['cpage'] = "report/innovations_report_followUp";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function innovations_report_DecisionPending($created_date = null, $created_date_to = null, $currentTab = 'default'){
        $options = array();
        $options = $_POST;
        //show($_POST);
        $options['associate'] = '';
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            //for auth user
        } else {
            $innovation = array();
            $this->load->model('scouting/Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
        }
        /**
         *  report conditions
         */
        if (!empty($created_date) && !empty($created_date_to)) {
            $options['created_date'] = $created_date;
            $options['created_date_to'] = $created_date_to;
        }
        $options['status'] = '!3';
        $options['grading_status'] = '1';
        $options['orderby'] = 'created_emp';
        $options['ordertype'] = 'ASC';
        /*
         * report conditions ended
         */
        $options['offset'] = $this->uri->segment(4);
        //show($options);
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('common/report/innovations_report_DecisionPending/' . $currentTab),
            'per_page' => '15',
            'total_rows' => 10,
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $data['innovationList'] = $this->Minnovation_reports->getLimitReportRecords($options);
        #pagination Ends

        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['knowAboutUs'] = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reasons');

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();

        if (!empty($options['export'])) {
            $options['num'] = '';
            $options['offset'] = '';
            $reportData = $this->Minnovation_reports->getLimitReportRecords($options);
            if (php72_count($reportData)) {
                foreach ($reportData as $r):
                    $r['stage'] = $data['stage'][$r['stage']];
                    $r['status'] = $data['status'][$r['status']];
                    $reportArray[] = $r;
                endforeach;
                $this->Mexport->export($reportArray, $options['export']);
            } else {
                $data['errorMsg'] = "No Matched records found!";
            }

        }
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovations Report - Entry/Lead Decision Pending";
        $data['cpage'] = "report/innovations_report_DecisionPending";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function innovations_report_entryclosed($created_date = null, $created_date_to = null, $currentTab = 'default')
    {
        $options = array();
        $options = $_POST;
        //show($_POST);
        $options['associate'] = '';
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            //for auth user
        } else {
            $innovation = array();
            $this->load->model('scouting/Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
        }
        /**
         *  report conditions
         */
        if (!empty($created_date) && !empty($created_date_to)) {
            $options['created_date'] = $created_date;
            $options['created_date_to'] = $created_date_to;
        }
        $options['status'] = '3';
        $options['stage'] = '1';
        $options['orderby'] = 'created_emp';
        $options['ordertype'] = 'ASC';
        /*
         * report conditions ended
         */
        $options['offset'] = $this->uri->segment(4);
        //show($options);
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('common/report/innovations_report_DecisionPending/' . $currentTab),
            'per_page' => '15',
            'total_rows' => 10,
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $data['innovationList'] = $this->Minnovation_reports->getLimitReportRecords($options);
        #pagination Ends

        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['knowAboutUs'] = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reasons');

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();

        if (!empty($options['export'])) {
            $options['num'] = '';
            $options['offset'] = '';
            $reportData = $this->Minnovation_reports->getLimitReportRecords($options);
            if (php72_count($reportData)) {
                foreach ($reportData as $r):
                    $r['stage'] = $data['stage'][$r['stage']];
                    $r['status'] = $data['status'][$r['status']];
                    $reportArray[] = $r;
                endforeach;
                $this->Mexport->export($reportArray, $options['export']);
            } else {
                $data['errorMsg'] = "No Matched records found!";
            }

        }
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovations Report - Entry/Closed";
        $data['cpage'] = "report/innovations_report_entryclosed";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function innovations_report_totaldeals($created_date = null, $created_date_to = null, $currentTab = 'default')
    {
        $options = array();
        $options = $_POST;
        //show($_POST);
        $options['associate'] = '';
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            //for auth user
        } else {
            $innovation = array();
            $this->load->model('scouting/Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
        }
        /**
         *  report conditions
         */
        if (!empty($created_date) && !empty($created_date_to)) {
            $options['created_date'] = $created_date;
            $options['created_date_to'] = $created_date_to;
        }
        $options['stage'] = '0';
        $options['status'] = '0';
        $options['source_type'] = '0';
        $options['orderby'] = 'created_by';
        /*
         * report conditions ended
         */
        $options['offset'] = $this->uri->segment(4);
        //show($options);
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('common/report/innovations_report/' . $currentTab),
            'per_page' => '15',
            'total_rows' => 10,
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $data['innovationList'] = $this->Minnovation_reports->getLimitReportRecords($options);
        #pagination Ends

        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation_report');
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList();
        $data['knowAboutUs'] = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reasons');

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();

        if (!empty($options['export'])) {
            $options['num'] = '';
            $options['offset'] = '';
            $reportData = $this->Minnovation_reports->getLimitReportRecords($options);
            if (php72_count($reportData)) {
                foreach ($reportData as $r):
                    $r['stage'] = $data['stage'][$r['stage']];
                    $r['status'] = $data['status'][$r['status']];
                    $reportArray[] = $r;
                endforeach;
                $this->Mexport->export($reportArray, $options['export']);
            } else {
                $data['errorMsg'] = "No Matched records found!";
            }

        }
        $data['currentTab'] = $currentTab;
        $data['cpagetitle'] = "Innovations Report- Deals Information";
        $data['cpage'] = "report/innovations_report_totaldeals";

        $data['left_box'] = array('report', 'innovation_pool');

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        $this->load->view('../template');
    }
}
