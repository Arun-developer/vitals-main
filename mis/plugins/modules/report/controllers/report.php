<?php

class Report extends CI_Controller {

    function __construct() {

		
		#echo $_SERVER['REMOTE_ADDR'];die;
        # error_reporting(-1);
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        /*
          $this->Mauth->isAdminCheck();
          $this->Mauth->loginUser(); */
          $this->load->model('report/Common_model');
          $this->load->model('report/Mmaster');
          $this->load->model('report/Mcommon');
          $this->load->model('report/Masset');
//        $this->load->model('report/Mapproval');
          $this->load->model('report/Mlogin');
          $this->load->model('report/Minnovation');
          $this->load->model('report/Rminnovation_reports'); 
		  
		  #echo'<pre>';print_r($this->session->all_userdata());die;
      }

      public function old_innovations() {
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['userList'] = $this->Mlogin->getAllUserList();
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/old_innovation', $data);
    }

    public function old_innovation_record() {
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['userList'] = $this->Mlogin->getAllUserList();
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/old_innovation_record', $data);
    }

    public function old_innovation_list() {
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['userList'] = $this->Mlogin->getAllUserList();
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/old_innovation_record', $data);
    }

    public function new_report() {
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/new_report', $data);
    }

    public function innovations_report() {
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/innovations_report', $data);
    }

    public function report_an() {
        #error_reporting(-1);
        $data['programmeList'] = $this->Minnovation->getMasterProgramme();

        // report generation codings

        $option['offset'] = '';
        $option['num'] = '';
        $innovationlist = $this->Minnovation->getoldinnovation($where, $option);
        #echo'<pre>';print_r($innovationlist);die;
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/report_an', $data);
    }
	
	public function report_an_test() {
        #error_reporting(-1);
        $data['programmeList'] = $this->Minnovation->getMasterProgramme();

        // report generation codings

        $option['offset'] = '';
        $option['num'] = '';
        $innovationlist = $this->Minnovation->getoldinnovation($where, $option);
        #echo'<pre>';print_r($innovationlist);die;
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/report_an_test', $data);
    }

    function report_donor() {

        $programme = $_POST['programme'];
        $programmeList = $this->Minnovation->getMasterProgramme($programme);
        $donor_programme = unserialize($programmeList['0']['donor']);
        $donorList = $this->Minnovation->getMasterSetting('Donor');
        #echo'<pre>';print_r($donorList);die;
        $option .= "<option value=''>--Select--</option>";
        foreach ($donorList as $rows) {
            if (in_array($rows['master_id'], $donor_programme)) {
                $option .= "<option value=" . $rows['master_id'] . " > " . $rows['master_name'] . "</option>";
            }
        }
        #echo'<pre>';print_r($option);die;
        $returnArr['response'] = $option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }
	
	
	function report_an_ajax_test($post = NULL) {

        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $name_of_enterprise = $this->input->post('name_of_enterprise');
        $summary_business = $this->input->post('summary_business');
        $website = $this->input->post('website');
        $name_of_entrepreneur = $this->input->post('name_of_entrepreneur');
        $status = $this->input->post('status');

        $offset = 3;
        $searchArray = array();
        $options['offset'] = $start;
        $options['num'] = $limit;

        $post = $_POST;
        #echo'<pre>';print_r($_POST);
        if ($_POST != '') {
            $post = trim($post, "%22");
            $val = explode(':', $post);
            foreach ($val as $key => $value) {
                $inner_val[] = explode('-', $value);
            }

            foreach ($inner_val as $key => $value) {
                if ($value[0] == "date_from" || $value[0] == "date_to") {
                    $value[1] = implode('-', explode('_', $value[1]));
                }
                $_POST[$value[0]] = urldecode($value[1]);
            }
        }
        $start = date('Y', strtotime('-1 year'));
        // $from = date($start . '-m-d');
        // $from = '2018-04-01';
        $from = $start.'-04-01';
        $to = date('Y-m-d');

        if ($this->input->post('date_from') != '') {
            $from = date('Y-m-d', strtotime($this->input->post('date_from')));
        }
        if ($this->input->post('date_to') != '') {
            $to = date('Y-m-d', strtotime($this->input->post('date_to')));
        }
        $where = array('programme' => $this->input->post('programme'),
            'donor' => $this->input->post('donor'),
            'budget' => $this->input->post('budget'),
            'lineitem' => $this->input->post('lineitem'),
            'subline' => $this->input->post('subline'),
            'from' => $from,
            'to' => $to
        );
        $option['offset'] = '';
        $option['num'] = '';

        $innovationlist = $this->Minnovation->get_sheet_ajax_test($option, $where);
        $an_in_list_count = $innovationlist['aaData'];
        $getAll_count = count($an_in_list_count);
        $innovationlists = $this->Minnovation->get_sheet_ajax_test($options, $where);
        $an_in_list = $innovationlists['aaData'];
        $getLimit_count = count($an_in_list);

        foreach ($an_in_list as $lists) {
            $status = '';

            $nestedData = array();
            $nestedData[] = $lists['approval_no'];
            $nestedData[] = $lists['internal_no'];
            $nestedData[] = $lists['date_of_request'];
            $nestedData[] = $lists['date'];
            $nestedData[] = $lists['from_employee'];
            $nestedData[] = $lists['programe'];
            $nestedData[] = $lists['donor'];
            $nestedData[] = $lists['grant'];
            $nestedData[] = $lists['budget_head'];
            $nestedData[] = $lists['line_item'];
            $nestedData[] = $lists['cost_centre'];
            $nestedData[] = '';
            $nestedData[] = $lists['subject'];
            $nestedData[] = $lists['anstatus'];
            $nestedData[] = $lists['instatus'];
            $nestedData[] = $lists['amt_required'];
            $nestedData[] = $lists['amount_toapprove'];
            $data[] = $nestedData;
            $i++;
            $sno++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    function report_an_ajax($post = NULL) {

        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $name_of_enterprise = $this->input->post('name_of_enterprise');
        $summary_business = $this->input->post('summary_business');
        $website = $this->input->post('website');
        $name_of_entrepreneur = $this->input->post('name_of_entrepreneur');
        $status = $this->input->post('status');

        $offset = 3;
        $searchArray = array();
        $options['offset'] = $start;
        $options['num'] = $limit;

        $post = $_POST;
        #echo'<pre>';print_r($_POST);
        if ($_POST != '') {
            $post = trim($post, "%22");
            $val = explode(':', $post);
            foreach ($val as $key => $value) {
                $inner_val[] = explode('-', $value);
            }

            foreach ($inner_val as $key => $value) {
                if ($value[0] == "date_from" || $value[0] == "date_to") {
                    $value[1] = implode('-', explode('_', $value[1]));
                }
                $_POST[$value[0]] = urldecode($value[1]);
            }
        }
        $start = date('Y', strtotime('-1 year'));
        // $from = date($start . '-m-d');
        // $from = '2018-04-01';
        $from = $start.'-04-01';
        $to = date('Y-m-d');

        if ($this->input->post('date_from') != '') {
            $from = date('Y-m-d', strtotime($this->input->post('date_from')));
        }
        if ($this->input->post('date_to') != '') {
            $to = date('Y-m-d', strtotime($this->input->post('date_to')));
        }
        $where = array('programme' => $this->input->post('programme'),
            'donor' => $this->input->post('donor'),
            'budget' => $this->input->post('budget'),
            'lineitem' => $this->input->post('lineitem'),
            'subline' => $this->input->post('subline'),
            'from' => $from,
            'to' => $to
        );
        $option['offset'] = '';
        $option['num'] = '';

        $innovationlist = $this->Minnovation->get_sheet_ajax($option, $where);
        $an_in_list_count = $innovationlist['aaData'];
        $getAll_count = count($an_in_list_count);
        $innovationlists = $this->Minnovation->get_sheet_ajax($options, $where);
        $an_in_list = $innovationlists['aaData'];
        $getLimit_count = count($an_in_list);

        foreach ($an_in_list as $lists) {
            $status = '';

            $nestedData = array();
            $nestedData[] = $lists['approval_no'];
            $nestedData[] = $lists['internal_no'];
            $nestedData[] = $lists['date_of_request'];
            $nestedData[] = $lists['date'];
            $nestedData[] = $lists['from_employee'];
            $nestedData[] = $lists['programe'];
            $nestedData[] = $lists['donor'];
            $nestedData[] = $lists['grant'];
            $nestedData[] = $lists['budget_head'];
            $nestedData[] = $lists['line_item'];
            $nestedData[] = $lists['cost_centre'];
            $nestedData[] = '';
            $nestedData[] = $lists['subject'];
            $nestedData[] = $lists['anstatus'];
            $nestedData[] = $lists['instatus'];
            $nestedData[] = $lists['amt_required'];
            $nestedData[] = $lists['amount_toapprove'];
            $data[] = $nestedData;
            $i++;
            $sno++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    function an_report_export_an_new($post = NULL) {
		
		
        $export_type = $this->input->post('export_type');
        if ($export_type == 0) {

            $data = array();
            $i = $requestData['start'] + 1;
            $columnIndex = $_POST['order'][0]['column'];
            $columnSortOrder = $_POST['order'][0]['dir'];
            $start = $this->input->post('start');
            $limit = $this->input->post('length');

            $offset = 3;
            $searchArray = array();
            $options['offset'] = $start;
            $options['num'] = $limit;

            $post = $_POST;
            if ($_POST != '') {
                $post = trim($post, "%22");
                $val = explode(':', $post);
                foreach ($val as $key => $value) {
                    $inner_val[] = explode('-', $value);
                }

                foreach ($inner_val as $key => $value) {
                    if ($value[0] == "from_date" || $value[0] == "to_date") {
                        $value[1] = implode('-', explode('_', $value[1]));
                    }
                    $_POST[$value[0]] = urldecode($value[1]);
                }
            }
            $start = date('Y', strtotime('-1 year'));
            $from = date($start . '-m-d');
            $to = date('Y-m-d');

            if ($this->input->post('from_date') != '') {
                $from = date('Y-m-d', strtotime($this->input->post('from_date')));
            }
            if ($this->input->post('to_date') != '') {
                $to = date('Y-m-d', strtotime($this->input->post('to_date')));
            }
            $where = array('programme' => $this->input->post('programme'),
                'donor' => $this->input->post('donor'),
                'budget' => $this->input->post('budget'),
                'lineitem' => $this->input->post('lineitem'),
                'subline' => $this->input->post('subline'),
                'from' => $from,
                'to' => $to
            );

            $innovationlist = $this->Minnovation->get_sheet_ajaxAN($options, $where);
            $AN_report = $innovationlist['aaData'];
			
			

            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"AN_report_" . date('m-d-Y') . ".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $handle = fopen('php://output', 'w');

            fputcsv($handle, array(
                'Approval Id',
                'AN Raised Date',
                'From Employee',
                'Programme',
                'Donor',
                'Grant',
                'Budget Head',
                'Line Item',
                'Sub Line Item',
                'Detail',
                'Subject',
                'AN Status',
                'Amount in AN',
                'IN utilization',
                'RO Name',
                'PH Name',
            ));

            foreach ($AN_report as $AN) {
                fputcsv($handle, array(
                    $AN['approval_no'],
                    $AN['date_of_request'],
                    $AN['from_employee'],
                    $AN['programe'],
                    $AN['donor'],
                    $AN['grant'],
                    $AN['budget_head'],
                    $AN['line_item'],
                    $AN['cost_centre'],
                    $AN['additionalinfo'],
                    $AN['purpose'],
                    $AN['anstatus'],
                    $AN['amt_required'],
                    $AN['INamount'],
                    $AN['to_RO'],
                    $AN['phhead']
                ));
            }
            fclose($handle);
            exit;
        } else if ($export_type == 1) {
			
			
            $data = array();
            $i = $requestData['start'] + 1;
            $columnIndex = $_POST['order'][0]['column'];
            $columnSortOrder = $_POST['order'][0]['dir'];
            $start = $this->input->post('start');
            $limit = $this->input->post('length');

            $offset = 3;
            $searchArray = array();
            $options['offset'] = $start;
            $options['num'] = $limit;

            $post = $_POST;
			
            #echo'<pre>';print_r($_POST);
            if ($_POST != '') {
                $post = trim($post, "%22");
                $val = explode(':', $post);
                foreach ($val as $key => $value) {
                    $inner_val[] = explode('-', $value);
                }

                foreach ($inner_val as $key => $value) {
                    if ($value[0] == "from_date" || $value[0] == "to_date") {
                        $value[1] = implode('-', explode('_', $value[1]));
                    }
                    $_POST[$value[0]] = urldecode($value[1]);
                }
            }
			
            $start = date('Y', strtotime('-1 year'));
            $from = date($start . '-m-d');
            $from = '2018-04-01';
            $to = date('Y-m-d');

            if ($this->input->post('from_date') != '') {
                $from = date('Y-m-d', strtotime($this->input->post('from_date')));
            }
            if ($this->input->post('to_date') != '') {
                $to = date('Y-m-d', strtotime($this->input->post('to_date')));
            }
            $where = array('programme' => $this->input->post('programme'),
                'donor' => $this->input->post('donor'),
                'budget' => $this->input->post('budget'),
                'lineitem' => $this->input->post('lineitem'),
                'subline' => $this->input->post('subline'),
                'from' => $from,
                'to' => $to
            );
			

            $innovationlists = $this->Minnovation->get_sheet_ajax($options, $where);
			if($_SERVER['REMOTE_ADDR']=='172.31.29.137' || $_SERVER['REMOTE_ADDR']='172.31.15.193'){
				#echo'<pre>';print_r($where);DIE;
			}
			
            $an_in_list = $innovationlists['aaData'];

            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"IN_report_" . date('m-d-Y') . ".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            fputcsv($handle, array(
                'Approval Id',
                'Internal_id',
                'AN Raised Date',
                'IN Raised Date',
                'From Employee',
                'Programme',
                'Donor',
                'Grant',
                'Budget Head',
                'Line Item',
                'Sub Line Item',
                'Detail',
                'Subject',
                'AN Status',
                'IN Status',
                'Amount in IN',
                'IN Confirmed date',
                'Payment date',
                'Cheque date',
                'Invoice date',
                'Finance comments'
            ));

            foreach ($an_in_list as $AN) {

                fputcsv($handle, array(
                    $AN['approval_no'],
                    $AN['internal_no'],
                    $AN['date_of_request'],
                    $AN['date'],
                    $AN['from_employee'],
                    $AN['programe'],
                    $AN['donor'],
                    $AN['grant'],
                    $AN['budget_head'],
                    $AN['line_item'],
                    $AN['cost_centre'],
                    $AN['additionalinfo'],
                    $AN['subject'],
                    $AN['anstatus'],
                    $AN['instatus'],
                    $AN['amount_toapprove'],
                    $AN['RO_date'],
                    $AN['payment_date'],
                    $AN['check_date'],
                    $AN['invoice_date'],
                    $AN['finance_comments']
                ));
            }

            fclose($handle);
            exit;
        } else if ($export_type == 2) {

            $data = array();
            $i = $requestData['start'] + 1;
            $columnIndex = $_POST['order'][0]['column'];
            $columnSortOrder = $_POST['order'][0]['dir'];
            $start = $this->input->post('start');
            $limit = $this->input->post('length');

            $offset = 3;
            $searchArray = array();
            $options['offset'] = $start;
            $options['num'] = $limit;

            $post = $_POST;
            #echo'<pre>';print_r($_POST);
            if ($_POST != '') {
                $post = trim($post, "%22");
                $val = explode(':', $post);
                foreach ($val as $key => $value) {
                    $inner_val[] = explode('-', $value);
                }

                foreach ($inner_val as $key => $value) {
                    if ($value[0] == "from_date" || $value[0] == "to_date") {
                        $value[1] = implode('-', explode('_', $value[1]));
                    }
                    $_POST[$value[0]] = urldecode($value[1]);
                }
            }
            $start = date('Y', strtotime('-1 year'));
            $from = date($start . '-m-d');
            $from = '2018-04-01';
            $to = date('Y-m-d');

            if ($this->input->post('from_date') != '') {
                $from = date('Y-m-d', strtotime($this->input->post('from_date')));
            }
            if ($this->input->post('to_date') != '') {
                $to = date('Y-m-d', strtotime($this->input->post('to_date')));
            }
            $where = array('programme' => $this->input->post('programme'),
                'donor' => $this->input->post('donor'),
                'budget' => $this->input->post('budget'),
                'lineitem' => $this->input->post('lineitem'),
                'subline' => $this->input->post('subline'),
                'from' => $from,
                'to' => $to,
                'grant' => $this->input->post('grant'),
            );
			

            $innovationlists = $this->Minnovation->get_sheet_ajax_monthly($options, $where);
            $an_in_list_monthly = $innovationlists['aaData'];

            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"New_report_" . date('m-d-Y') . ".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            fputcsv($handle, array(
                'AN No',
                'From Employee',
                'Program',
                'Donor',
                'Grant',
                'budget head',
                'line item',
                'detail',
                'AN_Amount',
                'AN Status',
                'Purpose description',
                'Raised date',
                'RO Approved Date',
                'AN PH approved date',
                'AN CEO approved date',
                'AN Confirmed date',
                'IN No',
                'Raised date',
                'IN Status',
                'IN Subject',
                'IN RO Approved Date',
                'IN PH approved date',
                'IN Approved Date',
                'IN Payment status',
                'IN Payment date',
                'IN Cheque_date',
                'RO Name',
                'PH Name'
            ));

            foreach ($an_in_list_monthly as $AN) {
                fputcsv($handle, array(
                    $AN['approval_no'],
                    $AN['from_employee'],
                    $AN['programe'],
                    $AN['donor'],
                    $AN['grant'],
                    $AN['budget_head'],
                    $AN['line_item'],
                    $AN['additionalinfo'],
                    $AN['amt_required'],
                    $AN['an_status'],
                    $AN['purpose'],
                    $AN['date_of_request'],
                    $AN['RO_date'],
                    $AN['PH_date'],
                    $AN['CEO_date'],
                    $AN['an_confirmed_date'],
                    $AN['internal_no'],
                    $AN['date'],
                    $AN['in_status'],
                    $AN['subject'],
                    $AN['IN_RO_date'],
                    $AN['IN_PH_date'],
                    $AN['IN_RO_date'],
                    $AN['payment_status'],
                    $AN['payment_date'],
                    $AN['check_date'],
                    $AN['to_RO'],
                    $AN['PH']
                ));
            }

            fclose($handle);
            exit;
        }
    }

    public function untilized_report() {

        $data['filter_fromdate'] = $fromyear = (isset($_POST['filter_fromdate'])) ? $_POST['filter_fromdate'] : '01-01-' . date('Y');
        $data['filter_todate'] = $toyear = (isset($_POST['filter_todate'])) ? $_POST['filter_todate'] : '31-12-' . date('Y');

        $option['offset'] = '';
        $option['num'] = '';
        $innovationlist = $this->Minnovation->getoldinnovation($where, $option);
        #echo'<pre>';print_r($innovationlist);die;
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/untilized_report', $data);
    }

    public function DTuntilized_report() {

        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $name_of_enterprise = $this->input->post('name_of_enterprise');
        $summary_business = $this->input->post('summary_business');
        $website = $this->input->post('website');
        $name_of_entrepreneur = $this->input->post('name_of_entrepreneur');
        $status = $this->input->post('status');

        $offset = 3;
        $searchArray = array();
        $options['offset'] = $start;
        $options['num'] = $limit;



        if ($this->input->post('name_of_entrepreneur') != "")
            $searchArray[] = "`Name of the Promoter` like '%" . $this->input->post('name_of_entrepreneur') . "%'";
        if ($this->input->post('name_of_enterprise') != "")
            $searchArray[] = "`Name of your Enterprise` like '%" . $this->input->post('name_of_enterprise') . "%'";
        if ($this->input->post('summary_business') != "")
            $searchArray[] = "`Summary` like '%" . $this->input->post('summary_business') . "%'";
        if ($this->input->post('website') != "")
            $searchArray[] = "`website` = '" . $this->input->post('website') . "'";
        if ($this->input->post('status') != "")
            $searchArray[] = "`status` like '%" . $this->input->post('status') . "%'";

        $where = implode(" and ", $searchArray);


        $option['offset'] = '';
        $option['num'] = '';
        $innovationlist = $this->Minnovation->getoldinnovation($where, $option);
        $getAll_count = count($innovationlist);
        $innovationlists = $this->Minnovation->getoldinnovation($where, $options);
        $getLimit_count = count($innovationlists);


        foreach ($innovationlists as $lists) {
            $status = '';

            $nestedData = array();
            $nestedData[] = $lists['Name of the Promoter'];
            $nestedData[] = $lists['Name of your Enterprise'];
            $nestedData[] = $lists['Phone Number'];
            $nestedData[] = (strlen($lists['Summary']) > 50) ? substr($lists['Summary'], 0, 50) . ".." : $lists['Summary'];
            $nestedData[] = $lists['Name of the Promoter'];
            $nestedData[] = $lists['Email Address'];
            $nestedData[] = $lists['Website'];
            $nestedData[] = $lists['Status'];
            $data[] = $nestedData;
            $i++;
            $sno++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTnew_report() {
        #echo'<pre>';print_r($_POST);
        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

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
            $option['created_date'] = $_POST['date_from'];
            $option['created_date_to'] = $_POST['date_to'];
            $options['created_date'] = $_POST['date_from'];
            $options['created_date_to'] = $_POST['date_to'];
            $optionss['created_date'] = $_POST['date_from'];
            $optionss['created_date_to'] = $_POST['date_to'];
            $options_s['created_date'] = $_POST['date_from'];
            $options_s['created_date_to'] = $_POST['date_to'];
            $optionec['created_date'] = $_POST['date_from'];
            $optionec['created_date_to'] = $_POST['date_to'];
            $optiontotal['created_date'] = $_POST['date_from'];
            $optiontotal['created_date_to'] = $_POST['date_to'];
        }


        $innovationList = $this->Rminnovation_reports->getLimitReportRecords($options);
        $innovationList_count = count($innovationList);

        $identified_by = $this->Rminnovation_reports->getLimitReportRecords($optionss);
        $identified_count = count($identified_by);

        $followups = $this->Rminnovation_reports->getLimitReportRecords($options_s);
        $followups_count = count($followups);

        $decision_pending = $this->Rminnovation_reports->getLimitReportRecords($option);
        $decision_pending_count = count($decision_pending);

        $entry_closed = $this->Rminnovation_reports->getLimitReportRecords($optionec);
        $entry_closed_count = count($entry_closed);

        $total_deals = $this->Rminnovation_reports->getLimitReportRecords($optiontotal);
        $total_deals_count = count($total_deals);

        $date = '';
        if ($_POST['date_from'] != '' && $_POST['date_to'] != '') {
            $date = '/' . $_POST['date_from'] . '/' . $_POST['date_to'];
        }

        $url = base_url() . 'index.php/report/innovations_report/' . $innovationList_count . '/innovation' . $date;

        $innovation = "<a  href=" . $url . " class='action_cls return_cls'>" . $innovationList_count . "</a>";

        $url1 = base_url() . 'index.php/report/innovations_report/' . $identified_count . '/identified' . $date;
        $innovations_report_identifiedBy = "<a  href=" . $url1 . " class='action_cls return_cls'>" . $identified_count . "</a>";

        $url2 = base_url() . 'index.php/report/innovations_report/' . $followups_count . '/report_followup' . $date;
        $innovations_report_follow = "<a  href=" . $url2 . " class='action_cls return_cls' >" . $followups_count . "</a>";

        $url3 = base_url() . 'index.php/report/innovations_report/' . $decision_pending_count . '/decision_pending' . $date;
        $innovations_decision_pending = "<a  href=" . $url3 . " class='action_cls return_cls'>" . $decision_pending_count . "</a>";

        $url4 = base_url() . 'index.php/report/innovations_report/' . $entry_closed_count . '/report_entryclosed' . $date;
        $innovations_report_entryclosed = "<a  href=" . $url4 . " class='action_cls return_cls'>" . $entry_closed_count . "</a>";

        $url5 = base_url() . 'index.php/report/innovations_report/' . $entry_closed_count . '/report_totaldeals' . $date;
        $innovations_report_totaldeals = "<a  href=" . $url5 . " class='action_cls return_cls'>" . $total_deals_count . "</a>";

        $dataArr = array(
            'New Application Direct' => $innovation,
            'New Application - Identified By' => $innovations_report_identifiedBy,
            'Entry - Follow Up' => $innovations_report_follow,
            'Entry - Decision Pending' => $innovations_decision_pending,
            'Entry - Closed' => $innovations_report_entryclosed,
            'Total No of Deals' => $innovations_report_totaldeals
        );
        foreach ($dataArr as $key => $val) {
            $status = '';
            $nestedData = array();
            $nestedData[] = $key;
            $nestedData[] = $val;
            $data[] = $nestedData;
            $i++;
            $sno++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(0),
            "recordsFiltered" => intval(5),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function export_findopenamt_new_ajax() {
        #echo'<pre>';print_r($_POST);
        #error_reporting(-1);
        $this->load->model('report/Minnovation');
        $set_export = $this->input->post('set_export');

        $where = "";
        $financialArray = $this->Minnovation->findCurrentFinancialYear();
        #echo'<pre>';print_r($financialArray);die;
        $from = converttodate($financialArray[0]['from']);
        $to = converttodate($financialArray[0]['to']);

        if ($_POST != '') {
            $post = trim($post, "%22");
            $val = explode(':', $post);
            foreach ($val as $key => $value) {
                $inner_val[] = explode('-', $value);
            }
            foreach ($inner_val as $key => $value) {
                if ($value[0] == "from_date" || $value[0] == "to_date") {
                    $value[1] = implode('/', explode('_', $value[1]));
                }
                $_POST[$value[0]] = urldecode($value[1]);
            }
            if ($this->input->post('programme')) {
                $searchArray[] = "MP.programme like '%" . $this->input->post('programme') . "%'";
            }
            if ($this->input->post('donor')) {
                $searchArray[] = "MS.master_name like '%" . $this->input->post('donor') . "%'";
            }
            if ($this->input->post('status')) {
                $searchArray[] = "I.status like '%" . $this->input->post('status') . "%'";
            }
            if ($this->input->post('from_date')) {

                $from = explode('-', $this->input->post('from_date'));
                $fromdate = $from[2] . '-' . $from[1] . '-' . $from[0];
                $searchArray[] = "OAN.date_of_request >= '" . $fromdate . "'";
            } else {
                $searchArray[] = "OAN.date_of_request >= '" . $from . "'";
            }
            if ($this->input->post('to_date')) {
                $to = explode('-', $this->input->post('to_date'));
                $todate = $to[2] . '-' . $to[1] . '-' . $to[0];
                $searchArray[] = "OAN.date_of_request <= '" . $todate . "'";
            } else {
                $searchArray[] = "OAN.date_of_request <= '" . $to . "'";
            }
        } else {
            $searchArray[] = "OAN.date_of_request >= '" . $from . "'";
            $searchArray[] = "OAN.date_of_request <= '" . $to . "'";
        }
        if ($this->session->userdata['user_type'] == 'employee') {
            $searchArray[] = "OAN.from_employee = '" . $this->session->userdata['emp_number'] . "'";
        }
        //$searchArray[] = "OAN.status = 'confirmed'";
        $where = implode(" AND ", $searchArray);

        if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
            $options['offset'] = intval($_POST['iDisplayStart']);
            $options['num'] = intval($_POST['iDisplayLength']);
        }

        #echo $where;
        $innovationlists = $this->Minnovation->findopenamt_new_ajax($option, $where);
        $innovationlists_result = $innovationlists['result'];
        #echo'<pre>';print_r($innovationlists);die;
		if($this->session->userdata('emp_number') == '275') {
			//echo'<pre>';print_r($innovationlists_result);die;
		}
			
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"AN_Unutilized_report_" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array(
            'AN NO',
            'Employee Name',
            'Programme',
            'Donor',
            'Budget Head',
            'Line Item',
            'Sub Line Item',
            'Detail',
            'Budget Amount',
            'AN Date',
            'AN Purpose',
            'IN No',
            'IN Date',
            'IN Purpose',
            'IN Status',
            'Total (AN Amount)',
            'IN Amount',
            'Total ( Remaining Amount)',
			'IN Amount',
			'TDS Name',
			'TDS',
			'Net Amount',
			'Vendor Name',
            'Total ( Remaining Amount)'
        ));

        foreach ($innovationlists_result as $AN) {
            fputcsv($handle, array(
                $AN['AN No'],
                $AN['Employee Name'],
                $AN['Programme'],
                $AN['Donor'],
                $AN['Budget head'],
                $AN['Line Item'],
                $AN['Sub Line Item'],
                $AN['Detail'],
                $AN['Budget Amount'],
                $AN['AN Date'],
                $AN['AN Purpose'],
                $AN['IN No'],
                $AN['IN Date'],
                $AN['IN Purpose'],
                $AN['IN Status'],
                $AN['Total(AN Amount)'],
                $AN['IN Amount'],
                $AN['Total(Remaining Amount)'],
				$AN['IN Amount'],
				$AN['TDS Name'],
				$AN['TDS'],
				$AN['Net Amount'],
				$AN['Vendor Name'],
                $AN['Total(Remaining Amount)']
            ));
        }
        fclose($handle);
        exit;
    }

    public function DTfindopenamt_new_ajax() {

        #echo'<pre>';print_r($_POST);

        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');


        $this->load->model('report/Minnovation');
        $set_export = $this->input->post('set_export');
        $where = "";
        $financialArray = $this->Minnovation->findCurrentFinancialYear();
        #echo'<pre>';print_r($financialArray);die;
        $from = converttodate($financialArray[0]['from']);
        $to = converttodate($financialArray[0]['to']);
        if ($_POST != '') {
            $post = trim($post, "%22");
            $val = explode(':', $post);
            foreach ($val as $key => $value) {
                $inner_val[] = explode('-', $value);
            }
            foreach ($inner_val as $key => $value) {
                if ($value[0] == "date_from" || $value[0] == "date_to") {
                    $value[1] = implode('/', explode('_', $value[1]));
                }
                $_POST[$value[0]] = urldecode($value[1]);
            }
            if ($this->input->post('programme')) {
                $searchArray[] = "MP.programme like '%" . $this->input->post('programme') . "%'";
            }
            if ($this->input->post('donor')) {
                $searchArray[] = "MS.master_name like '%" . $this->input->post('donor') . "%'";
            }
            if ($this->input->post('status')) {
                $searchArray[] = "I.status like '%" . $this->input->post('status') . "%'";
            }
            if ($this->input->post('date_from')) {
                $from = explode('-', $this->input->post('date_from'));
                $fromdate = $from[2] . '-' . $from[1] . '-' . $from[0];
                $searchArray[] = "OAN.date_of_request >= '" . $fromdate . "'";
            } else {
                $searchArray[] = "OAN.date_of_request >= '" . $from . "'";
            }
            if ($this->input->post('date_to')) {
                $to = explode('-', $this->input->post('date_to'));
                $todate = $to[2] . '-' . $to[1] . '-' . $to[0];
                $searchArray[] = "OAN.date_of_request <= '" . $todate . "'";
            } else {
                $searchArray[] = "OAN.date_of_request <= '" . $to . "'";
            }
        } else {
            $searchArray[] = "OAN.date_of_request >= '" . $from . "'";
            $searchArray[] = "OAN.date_of_request <= '" . $to . "'";
        }

        if ($this->session->userdata['user_type'] == 'employee') {
            $searchArray[] = "OAN.from_employee = '" . $this->session->userdata['emp_number'] . "'";
        }
        //$searchArray[] = "OAN.status = 'confirmed'";
        $where = implode(" AND ", $searchArray);


        #Sort
        $columnArr = array('OAN.approval_no', '', 'MP.programme', 'MS.master_name', 'MSB.master_name', 'MSL.master_name', 'MSC.master_name', 'AI.additionalinfo', 'AD.amt_available', 'OAN.date_of_request', 'OAN.purpose', 'I.internal_no');
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        if (!empty($columnSortOrder) && !empty($sort_column)) {
            $options['orderby'] = $sort_column;
            $options['ordertype'] = $columnSortOrder;
        }
        $offset = 3;
        $searchArray = array();
        $options['offset'] = $start;
        $options['num'] = $limit;

        $innovationlists = $this->Minnovation->findopenamt_new_ajax($options, $where);
        $get_innovationlists_count = count($innovationlists['result']);

        unset($options['offset']);
        unset($options['num']);
        $innovationlists_count = $this->Minnovation->findopenamt_new_ajax($options, $where);
        $getAll_count = count($innovationlists_count['result']);

        $data = array();
        $innovationlist_arr = $innovationlists['result'];
        foreach ($innovationlist_arr as $lists) {
            $status = '';
            $line_item = '-';
            if ($lists['Line Item'] != '') {
                $line_item = $lists['Line Item'];
            }
            $sub_line_item = '-';
            if ($lists['Sub Line Item'] != '') {
                $sub_line_item = $lists['Sub Line Item'];
            }
            $details = '-';
            if ($lists['Detail'] != '') {
                $details = $lists['Detail'];
            }

            $nestedData = array();
            $nestedData[] = $lists['AN No'];
            $nestedData[] = $lists['Employee Name'];
            $nestedData[] = $lists['Programme'];
            $nestedData[] = $lists['Donor'];
            $nestedData[] = $lists['Budget head'];
            $nestedData[] = $line_item;
            $nestedData[] = $sub_line_item;
            $nestedData[] = $details;
            $nestedData[] = $lists['Budget Amount'];
            $nestedData[] = $lists['AN Date'];
            $nestedData[] = (strlen($lists['AN Purpose']) > 50) ? substr($lists['AN Purpose'], 0, 50) . ".." : $lists['AN Purpose'];
            $nestedData[] = $lists['IN No'];
            $nestedData[] = $lists['IN Date'];
            $nestedData[] = $lists['IN Purpose'];
            $nestedData[] = $lists['IN Status'];
            $nestedData[] = $lists['Total(AN Amount)'];
            $nestedData[] = $lists['IN Amount'];
            $nestedData[] = $lists['Total(Remaining Amount)'];

            $data[] = $nestedData;
            $i++;
            $sno++;
        }


        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_innovationlists_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );

        echo json_encode($json_data);
    }

    public function DTold_innovation() {

        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $name_of_enterprise = $this->input->post('name_of_enterprise');
        $summary_business = $this->input->post('summary_business');
        $website = $this->input->post('website');
        $name_of_entrepreneur = $this->input->post('name_of_entrepreneur');
        $status = $this->input->post('status');


        $offset = 3;
        $searchArray = array();
        $options['offset'] = $start;
        $options['num'] = $limit;

        if ($this->input->post('name_of_entrepreneur') != "")
            $searchArray[] = "`Name of the Promoter` like '%" . $this->input->post('name_of_entrepreneur') . "%'";
        if ($this->input->post('name_of_enterprise') != "")
            $searchArray[] = "`Name of your Enterprise` like '%" . $this->input->post('name_of_enterprise') . "%'";
        if ($this->input->post('summary_business') != "")
            $searchArray[] = "`Summary` like '%" . $this->input->post('summary_business') . "%'";
        if ($this->input->post('website') != "")
            $searchArray[] = "`website` = '" . $this->input->post('website') . "'";
        if ($this->input->post('status') != "")
            $searchArray[] = "`status` like '%" . $this->input->post('status') . "%'";

        $where = implode(" and ", $searchArray);

        $option['offset'] = '';
        $option['num'] = '';
        $innovationlist = $this->Minnovation->getoldinnovation($where, $option);
        $getAll_count = count($innovationlist);
        $innovationlists = $this->Minnovation->getoldinnovation($where, $options);
        $getLimit_count = count($innovationlists);

        foreach ($innovationlists as $lists) {
            $status = '';

            $nestedData = array();
            $nestedData[] = $lists['Name of the Promoter'];
            $nestedData[] = $lists['Name of your Enterprise'];
            $nestedData[] = $lists['Phone Number'];
            $nestedData[] = (strlen($lists['Summary']) > 50) ? substr($lists['Summary'], 0, 50) . ".." : $lists['Summary'];
            $nestedData[] = $lists['Name of the Promoter'];
            $nestedData[] = $lists['Email Address'];
            $nestedData[] = $lists['Website'];
            $nestedData[] = $lists['Status'];
            $data[] = $nestedData;
            $i++;
            $sno++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTold_innovation_record() {

        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $name_of_enterprise = $this->input->post('name_of_enterprise');
        $summary_business = $this->input->post('summary_business');
        $website = $this->input->post('website');
        $name_of_entrepreneur = $this->input->post('name_of_entrepreneur');
        $status = $this->input->post('status');


        $offset = 3;
        $searchArray = array();
        $options['offset'] = $start;
        $options['num'] = $limit;

        if ($this->input->post('name_of_entrepreneur') != "")
            $searchArray[] = "`Name of the Promoter` like '%" . $this->input->post('name_of_entrepreneur') . "%'";
        if ($this->input->post('name_of_enterprise') != "")
            $searchArray[] = "`Name of your Enterprise` like '%" . $this->input->post('name_of_enterprise') . "%'";
        if ($this->input->post('summary_business') != "")
            $searchArray[] = "`Summary` like '%" . $this->input->post('summary_business') . "%'";
        if ($this->input->post('website') != "")
            $searchArray[] = "`website` = '" . $this->input->post('website') . "'";
        if ($this->input->post('status') != "")
            $searchArray[] = "`status` like '%" . $this->input->post('status') . "%'";

        /* $where = implode(" and ", $searchArray);
        echo '<pre>';print_r($_POST);die; */
        $option['offset'] = '';
        $option['num'] = '';
        $where = '';
        $innovationlist = $this->Minnovation->getoldcount($where, $option);
        $getAll_count = count($innovationlist);
        $innovationlists = $this->Minnovation->getoldinnovations($where, $options);
        $getLimit_count = count($innovationlists);
        #echo'<pre>';print_r($innovationlists);die;
        foreach ($innovationlists as $lists) {
            $status = '';

            $nestedData = array();
            $nestedData[] = $lists['Name of the Promoter'];
            $nestedData[] = $lists['Name of your Enterprise'];
            $nestedData[] = $lists['Phone Number'];
            $nestedData[] = (strlen($lists['Summary']) > 50) ? substr($lists['Summary'], 0, 50) . ".." : $lists['Summary'];
            $nestedData[] = $lists['Name of the Promoter'];
            $nestedData[] = $lists['Email Address'];
            $nestedData[] = $lists['Website'];
            $nestedData[] = $lists['Status'];
            $data[] = $nestedData;
            $i++;
            $sno++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTinnovations_report() {

        $getAll_count = $this->input->post('total_count');
        $report_type = $this->input->post('report_type');
        #echo $getAll_count;die;
        if ($getAll_count == '') {
            $getAll_count = 0;
        }
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $created_date = $this->input->post('from_date');
        $created_date_to = $this->input->post('to_date');


        $columnArr = array('IP.innovation_id', 'IP.name_of_enterprise', 'IP.created_date', 'IP.stage', 'IP.status');
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        if (!empty($columnSortOrder) && !empty($sort_column)) {
            $options['orderby'] = $sort_column;
            $options['ordertype'] = $columnSortOrder;
        }

        $options['offset'] = $start;
        $options['num'] = $limit;
        if (!empty($created_date) && !empty($created_date_to)) {
            $options['created_date'] = $created_date;
            $options['created_date_to'] = $created_date_to;
        }

        if ($report_type == 'decision_pending') {
            $options['associate'] = '';
            $options['status'] = '!3';
            $options['grading_status'] = '1';
        } else if ($report_type == 'identified') {
            $options['associate'] = '';
            $options['stage'] = '0';
            $options['status'] = '0';
        } else if ($report_type == 'report_entryclosed') {
            $options['associate'] = '';
            $options['stage'] = '1';
            $options['status'] = '3';
        } else if ($report_type == 'report_totaldeals') {
            $options['associate'] = '';
            $options['source_type'] = '0';
            $options['stage'] = '0';
            $options['status'] = '0';
        } else {
            $options['source_type'] = '0';
            $options['stage'] = '0';
            $options['status'] = '0';
        }

        $innovationList = $this->Rminnovation_reports->getLimitReportRecords($options);
        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $getLimit_count = count($innovationList);

        unset($options['offset']);
        unset($options['num']);
        $innovationList_count = $this->Rminnovation_reports->getLimitReportRecords($options);
        $getLimit_count_all = count($innovationList_count);

        foreach ($innovationList as $lists) {#echo'<pre>';print_r($lists);die;
        $nestedData = array();
        $nestedData[] = $lists['innovation_id'];
        if ($report_type == 'decision_pending') {
            $nestedData[] = $lists['created_emp'];
        }
        $nestedData[] = $lists['name_of_enterprise'];
        $nestedData[] = date('d-m-Y', strtotime($lists['created_date']));
        if ($report_type == 'identified') {
            $nestedData[] = $lists['associate_emp_name'];
        }
        $nestedData[] = $stage[$lists['stage']];
        $nestedData[] = $status[$lists['status']];
        $data[] = $nestedData;
        $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($getLimit_count),
        "recordsFiltered" => intval($getLimit_count_all),
        "data" => $data,
        "POST" => $_POST
    );
    echo json_encode($json_data);
}
public function paypro_list() {
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['userList'] = $this->Mlogin->getAllUserList();
        #echo'<pre>';print_r($data['userList']);die;
        $this->load->view('report/display_paypro_list', $data);
    }
	
	public function DTPaypro() {

        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $name_of_enterprise = $this->input->post('name_of_enterprise');
        $summary_business = $this->input->post('summary_business');
        $website = $this->input->post('website');
        $internal_note = $this->input->post('internal_note');
        $status = $this->input->post('status');


        $offset = 3;
        $searchArray = array();
        $options['offset'] = $start;
        $options['num'] = $limit;

        if ($this->input->post('internal_note') != "")
            $searchArray[] = "`internal_id` like '%" . $this->input->post('internal_note') . "%'";
       
        $where = implode(" and ", $searchArray);

        $option['offset'] = '';
        $option['num'] = '';
        $innovationlist = $this->Minnovation->getPayProData($where, $option);
        $getAll_count = count($innovationlist);
        $innovationlists = $this->Minnovation->getPayProData($where, $options);
        $getLimit_count = count($innovationlists);
		
		$vendor_bank_id  = '';
		$debit_bank_id  = '';
        foreach ($innovationlists as $lists) {
			
			$vendor_bank_id  = $lists['vendor_bank_id'];
			$debit_bank_id  = $lists['debit_bank_id'];
			$vendor_id  = $lists['vendor_id'];
			
			$getBankData = $this->Minnovation->get_bank_details($debit_bank_id);
			$getVendorBankData = $this->Minnovation->get_vendor_bank_details($vendor_bank_id);
			$getVendorData = $this->Minnovation->get_vendor($vendor_id);
			
            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['internal_id'];
            $nestedData[] = $getVendorData[0]['name'];
            $nestedData[] = $lists['net_amount'];
            $nestedData[] = $getVendorBankData[0]['account_number'];
            $nestedData[] = $getBankData[0]['account_number'];
            $nestedData[] = $getVendorBankData[0]['ifsc_code'];
            $data[] = $nestedData;
            $i++;
            $sno++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }
	
	
	
	 public function export_in_paypro(){
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Your Name")
									 ->setLastModifiedBy("Your Name")
									 ->setTitle("Sample Excel Document")
									 ->setSubject("Sample Excel Document")
									 ->setDescription("Sample Excel Document")
									 ->setKeywords("excel sample")
									 ->setCategory("Test file");

		$heading = array(
					"Payment identifier","Amount","Value Date","Beneficiary Name",
					"Bene Account Number","Email ID of beneficiary","Email Body","Debit Account Number","CRN",
					"Receiver IFSC","Receiver A/c type",
					"Remarks","Mobile No"
		);
		
		 $offset = 3;
        $searchArray = array();
        $options['offset'] = $start;
        $options['num'] = $limit;

        if ($this->input->post('internal_note') != "")
            $searchArray[] = "`internal_id` like '%" . $this->input->post('internal_note') . "%'";
       
        $where = implode(" and ", $searchArray);

        $option['offset'] = '';
        $option['num'] = '';
        $data_lists = $this->Minnovation->getPayProData($where, $options);
      
		$this->load->model('vendor/vendor_model');
		$internal_coun= 3;
		$export_form_array = array();
		
		if(!empty($data_lists)){
			$ct = 0;
			foreach($data_lists as $lists){
				$internal_id = $lists['internal_id'];
				$condition = array('internal_id'=>$internal_id); 
				$getTdsDetails = $this->vendor_model->get_all_details('tds_vendor', $condition, array(), '', '', '', true, 'ais');
				
				
					$vendor_bank_id  = $lists['vendor_bank_id'];
					$debit_bank_id  = $lists['debit_bank_id'];
					$vendor_id  = $lists['vendor_id'];
					
					$getBankData = $this->Minnovation->get_bank_details($debit_bank_id);
					$getVendorBankData = $this->Minnovation->get_vendor_bank_details($vendor_bank_id);
					$getVendorData = $this->Minnovation->get_vendor($vendor_id);
					
					 
					$paymentIdentifier = '';
					if(!empty($getVendorBankData)){
						$string = $getVendorBankData[0]['bank_name'];
						if (stripos($string, 'Axis') !== false) {
							$paymentIdentifier = 'I';
						} else {
							$paymentIdentifier = "N";
						}
					}
					$net_amount = '';
					$vendor_name = '';
					$Vendoraccount_number = '';
					$debit_account_number = '';
					$ifsc_code = '';
					if(!empty($getTdsDetails)){
						
						$net_amount = $getTdsDetails[0]->net_amount;
						$vendor_name = $getVendorData[0]['name'];
						$Vendoraccount_number =  $getVendorBankData[0]['account_number'];
						$debit_account_number =  $getBankData[0]['account_number'];
						$ifsc_code =  $getVendorBankData[0]['ifsc_code'];
					}
					
				$export_form_array[] = array(
					$paymentIdentifier,
					$net_amount,
					'',
					$vendor_name,
					$Vendoraccount_number,
					'',
					'INV/'.$lists['internal_id'],
					$debit_account_number,
					'',
					$ifsc_code,
					'',
					'',
					''
				);
			}
			
		}
		
		
	 foreach ($heading as $key => $value) {
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($key, 1)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key, 1, $value);
	}

	foreach ($export_form_array as $rowIndex => $rowData) {
		foreach ($rowData as $columnIndex => $value) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $rowIndex + 2, $value);
		}
	}
#echo'<pre>';print_r($objPHPExcel);die;
	$objPHPExcel->setActiveSheetIndex(0);

	// Set headers for download
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="PayPro.xlsx"');
	header('Cache-Control: max-age=0');

	// Write the Excel file to the browser
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	 }


}

?>