<?php

class Funder extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('funder_model');
        $checkUsers = $this->getUsers();
        $this->auth = '0';
        if (!empty($checkUsers)) {
            if ($checkUsers['finance_user'] == '1' || $checkUsers['donor_team'] == '1' || $checkUsers['admin_user'] == '1' || $checkUsers['super_admin'] == '1') {
                $this->auth = '1';
            }
        }
    }

    public function display_summary_list() {
        $type = $this->input->post('type');
        $funder_id = $this->input->post('funder_name');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $status_type = $this->input->post('status_type');
        $search_val = $this->input->post('search_val');
        $export_status = $this->input->post('export_status');

        #Get Funder Types
        $funder_types = $this->funder_model->get_all_details('funder_types', array('status' => 1, 'partner_id' => $this->session->userdata('partner_id')), array('id', 'name'), '', '', array('name' => 'asc'));
        $funderTypeArr = $finalFunderType = $OtherTypeArr = array();
        foreach ($funder_types as $lists) {
            if ($lists->name != 'Others') {
                $funderTypeArr[$lists->id] = $lists->name;
            } else {
                $OtherTypeArr[$lists->id] = $lists->name;
            }
        }
        $finalFunderType = $funderTypeArr + $OtherTypeArr;
        $data['fundertypeList'] = $finalFunderType;

        $export = $this->input->get('export');
        $join [0] ['select'] = "gl.disbursement_amount as gl_deposite_amt,gl.projected_amount as gl_projected_amount,gl.amount_utilized as gl_amount_utilized,gl.id as gl_id,gl.name as gl_name, gl.grant_amount as gl_amount, gl.status_type as gl_status,gl.start_date as gl_start_date,gl.end_date as gl_end_date";
        $join [0] ['table'] = 'grant_list as gl';
        $join [0] ['condition'] = "gl.funder_id = funder_list.id";
        $join [0] ['type'] = "LEFT";

        //Filter
        $condition = array();
        $data['search_type'] = '';
        $data['type'] = '';
        if (isset($type) && $type != '') {
            $data['type'] = $type;
        }
        if ($type == 'funder') {
            $condition['funder_list.name LIKE'] = "%$search_val%";
            $data['search_val'] = $search_val;
        } else if ($type == 'start_date') {
            $join [0] ['type'] = "INNER";
            $filter_start_date = $start_date;
            $join [0] ['condition'] = "gl.funder_id = funder_list.id AND gl.start_date > $filter_start_date";

            $data['start_date'] = $start_date;
        } else if ($type == 'grant_status') {
            $join [0] ['type'] = "INNER";
            $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.status_type='$search_val'";
            $data['search_val'] = $search_val;
        } else if ($type == 'end_date' && $end_date != '') {
            $join [0] ['type'] = "INNER";
            $filter_end_date = $end_date;
            $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.end_date < '$filter_end_date'";
            $data['end_date'] = $end_date;
        } else if ($type == 'grant_name' && $search_val != '') {
            $join [0] ['type'] = "INNER";
            $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.name LIKE '%$search_val%'";
            $data['search_val'] = $search_val;
        } else if ($type == 'grant_amount' && $search_val != '') {
            $join [0] ['type'] = "INNER";
            $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.grant_amount = '$search_val'";
            $data['search_val'] = $search_val;
        } else if ($type == 'amount_received' && $search_val != '') {
            $join [0] ['type'] = "INNER";
            $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.disbursement_amount = '$search_val'";
            $data['search_val'] = $search_val;
        } else if ($type == 'total_utilized' && $search_val != '') {
            $join [0] ['type'] = "INNER";
            $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.amount_utilized = '$search_val'";
            $data['search_val'] = $search_val;
        } else if ($type == 'project_amount' && $search_val != '') {
            $join [0] ['type'] = "INNER";
            $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.projected_amount = '$search_val'";
            $data['search_val'] = $search_val;
        }

        if ($type == 'start_date') {
            $join [0] ['type'] = "INNER";
            $sdate = date('Y-m-d', strtotime($filter_start_date));
            $join [0] ['condition'] = "gl.funder_id = funder_list.id AND gl.start_date > '$sdate'";
            $data['start_date'] = $start_date;
        }
        if ($type == 'end_date' && $end_date != '') {
            $join [0] ['type'] = "INNER";
            $edate = date('Y-m-d', strtotime($filter_end_date));
            $join [0] ['condition'] = "gl.funder_id = funder_list.id AND gl.end_date < '$edate'";
            $data['end_date'] = $end_date;
        }

        $condition['funder_list.partner_id'] = $this->session->userdata('partner_id');
        $groupBy = '';
        $data['total_amount_rec'] = $getGrantAmount = $this->funder_model->get_all_details('disbursement_schedule', array(), array('grant_id', 'SUM(amount_deposite) AS amount'), '', '', '', '', '', '', array('grant_id'), '');
        $order_by = array("gl.start_date" => "desc");
        $fields = array('funder_list.id', 'funder_list.name', 'funder_list.fcra_status', 'funder_list.type');
        $getFunderData = $this->funder_model->get_all_details('funder_list', $condition, $fields, '', '', $order_by, '', '', $join, $groupBy);

        $get_DisbAmt = json_decode(json_encode($getGrantAmount), true);
        $get_GrantId = php72_array_column($get_DisbAmt, 'grant_id');
        $get_Amount = php72_array_column($get_DisbAmt, 'amount');
        $GetSumAmount = array_combine($get_GrantId, $get_Amount);
        $data['totalAmount'] = array();
        if (!empty($GetSumAmount)) {
            $data['totalAmount'] = $GetSumAmount;
        }

        if (!empty($getFunderData)) {
            $funder_details = array();
            foreach ($getFunderData as $values) {
                $funder_details[$values->id][] = array('id' => $values->id, 'name' => $values->name, 'fcra_status' => $values->fcra_status,
                    'type' => $values->type, 'gl_id' => $values->gl_id, 'gl_name' => $values->gl_name, 'gl_amount' => $values->gl_amount,
                    'gl_amount_utilized' => $values->gl_amount_utilized, 'gl_projected_amount' => $values->gl_projected_amount, 'gl_status' => ucfirst($values->gl_status), 'gl_deposite_amt' => $values->gl_deposite_amt, 'gl_start_date' => date('d-m-Y', strtotime($values->gl_start_date)), 'gl_end_date' => date('d-m-Y', strtotime($values->gl_end_date)),
                );
            }
        }


        $this->aiss = $this->load->database('ais', TRUE);
        $an_in_groupby = array('grant_id');
        $this->aiss->select('sum(amt_required)as totalamount,grant_id,donor');
        $this->aiss->join('approval_note AN', 'AN.approval_id=ANDO.approval_id');
        $this->aiss->where('AN.status !=', 'cancelled');
        $this->aiss->where('ANDO.grant_id !=', '');
        $this->aiss->group_by($an_in_groupby);
        $an_query = $this->aiss->get('approval_note_donors ANDO');

        $an_amountArr = array();
        foreach ($an_query->result() as $list) {
            $an_amountArr[$list->grant_id] = $list->totalamount;
        }
        $data['project_utz_amount'] = $an_amountArr;

        $this->aiss->select('sum(amount_toapprove)as totalamount,grant_id,donor');
        $this->aiss->join('approval_note AN', 'AN.approval_id=INTER.approval_id', 'left');
        $this->aiss->where('INTER.status !=', 'cancelled');
        $this->aiss->where('INTER.grant_id !=', '');
        $this->aiss->group_by($an_in_groupby);
        $in_query = $this->aiss->get('internal_note INTER');

        $in_amountArr = array();
        foreach ($in_query->result() as $list) {
            $in_amountArr[$list->grant_id] = $list->totalamount;
        }
        $data['total_utz_amount'] = $in_amountArr;

        $funderLimtArr = array_slice(array_values($funder_details), 0, 15);
        $i = 1;
        $COUNTS = '';
        $resdfs = '';
        $mainlist = array();
        foreach ($funderLimtArr as $result) {
            $COUNTS += php72_count($result);
            foreach ($result as $res) {

                $resdfs += $i;
                $mainlist[] = $res;
                $i++;
            }
        }

        $totalId = array();
        foreach ($mainlist as $test) {
            if ($test['gl_id'] != '') {
                $totalId[] = $test['id'];
            }
        }
        $COUNTS = $COUNTS + count(array_unique($totalId));
        $data['pagination_counts'] = $COUNTS;

        $getFunderLists = $this->funder_model->get_all_details('funder_list', array(), array('id', 'name'));
        $data['funder_lists'] = $funder_details;
        $data['funder_data'] = $getFunderLists;

        $groupBy_in = array('donor');
        $getInternalAmt = $this->funder_model->get_all_details('internal_note', array(), array('SUM(amount_toapprove) as approval_amount', 'donor'), '', '', '', true, 'ais', '', $groupBy_in);
        $getInternaAmt_arr = json_decode(json_encode($getInternalAmt), true);
        $approval_amount = php72_array_column($getInternaAmt_arr, 'approval_amount');
        $donor_ids = php72_array_column($getInternaAmt_arr, 'donor');
        $GetDonorApp_amt = array_combine($donor_ids, $approval_amount);
        $data['total_utilized'] = $GetDonorApp_amt;

        if ($export_status == '1') {
            $exportArr = array();
            $headerArray = array('Funder', 'Grant Id', 'Type', 'Status', 'Start Date', 'End Date', 'Grant Amount (' . $this->session->userdata['currency'] . ')', 'Amount Received (' . $this->session->userdata['currency'] . ')', 'Project Utilized (' . $this->session->userdata['currency'] . ')', 'Total Utilised (' . $this->session->userdata['currency'] . ')', 'Grant Status');
            foreach ($getFunderData as $list) {

                $status_fcra = '';
                if ($list->fcra_status == 'fcra') {
                    $status_fcra = strtoupper($list->fcra_status);
                } else if ($list->fcra_status == 'non_fcra') {
                    $res_fcra = explode("_", $list->fcra_status);
                    $status_fcra = ucfirst($res_fcra[0]) . ' ' . strtoupper($res_fcra[1]);
                }

                $this->load->helper('excel_helper');
                $gl_start_date = '';
                if ($list->gl_start_date != '')
                    $gl_start_date = date('d-m-Y', strtotime($list->gl_start_date));
                $gl_end_date = '';
                if ($list->gl_end_date != '')
                    $gl_end_date = date('d-m-Y', strtotime($list->gl_end_date));
                $exportArr[] = array($list->name, $list->gl_name, $finalFunderType[$list->type], $status_fcra, $gl_start_date, $gl_end_date, $this->numberToCurrency($list->gl_amount), $this->numberToCurrency($GetSumAmount[$list->gl_id]), $this->numberToCurrency($an_amountArr[$list->gl_id]), $this->numberToCurrency($in_amountArr[$list->gl_id]), ucfirst($list->gl_status));
            }
            dataarray_to_excel($headerArray, $exportArr);
            exit;
        }else {
            $this->load->view('funder/display_summary_list', $data);
        }
    }

    public function add_funder_form() {
        checkAuth();
        $funder_types = $this->funder_model->get_all_details('funder_types', array('status' => 1, 'partner_id' => $this->session->userdata('partner_id')), array('id', 'name'), '', '', array('name' => 'asc'));
        $funderTypeArr = $finalFunderType = $OtherTypeArr = array();
        foreach ($funder_types as $lists) {
            if ($lists->name != 'Others') {
                $funderTypeArr[$lists->id] = $lists->name;
            } else {
                $OtherTypeArr[$lists->id] = $lists->name;
            }
        }
        $finalFunderType = $funderTypeArr + $OtherTypeArr;
        $data['fundertypeList'] = $finalFunderType;


        $countryArr = $this->funder_model->get_all_details('hr_country', array(), array('country_code', 'country_name'));
        $data['country_list'] = $countryArr;
        $this->load->view('funder/add_funder_form', $data);
    }

    public function edit_funder_form() {
    
        checkAuth();
        $funder_id = $this->uri->segment(3);
        if ($funder_id != '') {
            $condition = array('id' => $funder_id);
            $funder_list = array();
            $getFunderData = $this->funder_model->get_all_details('funder_list', $condition, array('id', 'name', 'pan', 'grant_service', 'address', 'city', 'country', 'type', 'fcra_status'));
            #echo'<pre>';print_r($getFunderData);die;
            #$countryArr = $this->funder_model->get_all_details('hr_country', array('status' => 1), array('id', 'country_code', 'country_name'));
            $countryArr = $this->funder_model->get_all_details('hr_country', array(), array('country_code', 'country_name'));
            $data['country_list'] = $countryArr;

            if (!empty($getFunderData[0])) {
                $funder_list = $getFunderData;
                $data['funder_list'] = $funder_list[0];
            } else {
                $this->setErrorMessage('error', 'Record(s) not found');
            }
            $condition = array('funder_id' => $funder_id);
            $getFunderContact = $this->funder_model->get_all_details('funder_contacts', $condition, array('id', 'name', 'funder_id', 'designation', 'mobile_number', 'email'));
            if (!empty($getFunderContact)) {
                $data['funder_contact'] = $getFunderContact;
            }
            $condition = array('funder_id' => $funder_id);
            $getFunderDoc = $this->funder_model->get_all_details('funder_documents', $condition, array('id', 'description', 'file_name'));
            if (!empty($getFunderDoc)) {
                $data['funder_document'] = $getFunderDoc;
            }

            #Get Funder Types
            $funder_types = $this->funder_model->get_all_details('funder_types', array('status' => 1, 'partner_id' => $this->session->userdata('partner_id')), array('id', 'name'), '', '', array('name' => 'asc'));
            $funderTypeArr = $finalFunderType = $OtherTypeArr = array();
            foreach ($funder_types as $lists) {
                if ($lists->name != 'Others') {
                    $funderTypeArr[$lists->id] = $lists->name;
                } else {
                    $OtherTypeArr[$lists->id] = $lists->name;
                }
            }
            $finalFunderType = $funderTypeArr + $OtherTypeArr;
            $data['fundertypeList'] = $finalFunderType;

            $this->load->view('funder/edit_funder_form', $data);
        } else {
            $this->setErrorMessage('error', 'Record(s) not Found');
            redirect('funder/edit_funder_form');
        }
    }

    public function edit_funder_documents() {
        #error_reporting(-1);

        checkAuth();
        $funder_id = $this->uri->segment(3);
        if ($funder_id != '') {
            $conditions = array('funder_id' => $funder_id);
            $join[0]['select'] = "emp.emp_first_name,emp.emp_last_name";
            $join[0]['table'] = 'hr_user_profile as emp';
            $join[0]['condition'] = "funder_documents.uploaded_by = emp.id";
            $join[0]['type'] = "LEFT";

            $getFunderDoc = $this->funder_model->get_all_details('funder_documents', $conditions, array('funder_documents.id', 'description', 'funder_id', 'file_name', 'created_date', 'updated_date'), '', '', '', '', '', $join, '');
            #echo'<pre>';print_r($getFunderDoc);die;
            if (!empty($getFunderDoc)) {
                $data['funder_document'] = $getFunderDoc;
            }
            $data['user_name'] = $getFunderDoc[0]->emp_first_name . ' ' . $getFunderDoc[0]->emp_last_name;

            $data['funder_name'] = '';
            if ($funder_id != '') {
                $getfunderName = $this->funder_model->get_all_details('funder_list', array('id' => $funder_id), array('id', 'name'));
                if (isset($getfunderName[0]->id) && $getfunderName[0]->id != '') {
                    $data['funder_name'] = $getfunderName[0]->name;
                }
            }
            $updated_date_doc = date('d-m-Y', strtotime($getFunderDoc[0]->created_date));
            if (isset($getFunderDoc[0]->updated_date) && $getFunderDoc[0]->updated_date != '') {
                if (php72_cmp($getFunderDoc[0]->updated_date) > 0) {
                    $updated_date_doc = date('d-m-Y', strtotime($getFunderDoc[0]->updated_date));
                }
            }
            #echo'<pre>';print_r($data);die;
            $data['updated_date_doc'] = $updated_date_doc;
            $this->load->view('funder/edit_funder_documents', $data);
        } else {
            $this->setErrorMessage('error', 'Record(s) not found');
            $this->load->view('funder/edit_funder_documents', $data);
        }
    }

    public function display_grant_list() {
        #error_reporting(-1);
        checkAuth();
        $funder_id = $this->uri->segment(3);

        if ($funder_id != '') {
            $condition = array('funder_id' => $funder_id);
            $grant_list = array();
            $getFunderName = $this->funder_model->get_all_details('funder_list', array('id' => $funder_id), array('id', 'name'));
            $data['funder_name'] = $getFunderName[0]->name;
            $data['funder_id'] = $funder_id;
        } else {
            $this->setErrorMessage('error', 'Record(s) not found');
            redirect('funder/edit_funder_form');
        }
        $this->load->view('funder/display_grant_list', $data);
    }

    public function edit_grant_form() { #error_reporting(-1);
        checkAuth();
        $grant_id = $this->uri->segment(3);
        if (isset($grant_id) && $grant_id != '') {
            $getGrantData = $this->funder_model->get_all_details('grant_list', array('id' => $grant_id), array('id', 'name', 'status', 'programme_id', 'funder_id', 'grant_id', 'grant_amount', 'start_date', 'end_date', 'purpose', 'signed_date', 'status_type'));
            $data['grand_lists'] = $getGrantData[0];
            $data['funder_name'] = $data['funder_id'] = '';
            if (isset($getGrantData[0]->funder_id) && $getGrantData[0]->funder_id != '') {
                $getfunderName = $this->funder_model->get_all_details('funder_list', array('id' => $getGrantData[0]->funder_id), array('id', 'name'));
                $data['funder_name'] = $getfunderName[0]->name;
            }
            $data['funder_id'] = $getGrantData[0]->funder_id;


            $condition = array('partner_id' => $this->session->userdata('partner_id'));
            $orderby = array("programme" => "asc");
            $getProgrammeList = $this->funder_model->get_all_details('master_programme', $condition, array(), '', '', $orderby, true, 'ais');
            $data['programe_list'] = $getProgrammeList;
            $getDisbursementData = $this->funder_model->get_all_details('disbursement_schedule', array('grant_id' => $grant_id), array('id', 'status', 'programme_id', 'funder_id', 'milestone', 'grant_id', 'amount', 'date_of_disbursement', 'date_of_deposite', 'amount_deposite', 'comments'));
            $data['disbursement_list'] = $getDisbursementData;
            $getGrantReport = $this->funder_model->get_all_details('grant_reports', array('grant_id' => $grant_id), array('id', 'submit_date', 'status', 'programme_id', 'funder_id', 'date_of_report', 'responsibility', 'comments', 'file_name'));
            $data['grant_report_list'] = $getGrantReport;

            $getGrant_line = $this->funder_model->get_all_details('grant_line', array('grant_id' => $grant_id), array('id', 'status', 'programme_id', 'funder_id', 'budget_head_id', 'lineitem_id', 'subline_id', 'amount', 'comments'));
            $data['grantline_list'] = $getGrant_line;
            $donor_id = $getGrantData[0]->funder_id;
            $budgetList = $this->funder_model->getMasterSetting('Budget Head', NULL, $donor_id, '', true, 'ais');
            $data['budgetList'] = $budgetList;

            $order_by = array("emp_first_name" => "asc");
            $condition_response = array('partner_id' => array($this->session->userdata('partner_id')), 'emp_type' => array('2', '3'));
            $getEmployeeList = $this->funder_model->get_all_details_win('hr_user_profile', $condition_response, array('id', 'emp_first_name', 'emp_last_name'), '', '', $order_by);

            #echo'<pre>';print_r($getGrantData);die;
            $data['responsibility'] = $getEmployeeList;
        } else {
            $this->setErrorMessage('error', 'Record not found');
            redirect('funder/edit_funder_form');
        }
        $this->load->view('funder/edit_grant_form', $data);
    }

    public function add_grant_form() {
        checkAuth();
        $data['funder_id'] = $funder_id = $this->uri->segment('3');
        $condition = array('partner_id' => $this->session->userdata('partner_id'));
        $orderby = array("programme" => "asc");
        $getProgrammeList = $this->funder_model->get_all_details('master_programme', $condition, array(), '', '', $orderby, true, 'ais');
        $data['programe_list'] = $getProgrammeList;

        $data['funder_name'] = '';
        if ($funder_id != '') {
            $getfunderName = $this->funder_model->get_all_details('funder_list', array('id' => $funder_id), array('id', 'name'));
            if (isset($getfunderName[0]->id) && $getfunderName[0]->id != '') {
                $data['funder_name'] = $getfunderName[0]->name;
            }
        }
        $condition_response = array('partner_id' => array($this->session->userdata('partner_id')), 'emp_type' => array('2', '3'));
        $getEmployeeList = $this->funder_model->get_all_details_win('hr_user_profile', $condition_response, array('id', 'emp_first_name', 'emp_last_name'));

        $data['responsibility'] = $getEmployeeList;
        $this->load->view('funder/add_grant_form', $data);
    }

    public function get_resp_users_ajax() {
        $condition_response = array('partner_id' => array($this->session->userdata('partner_id')), 'emp_type' => array('2', '3'));
        $getEmployeeList = $this->funder_model->get_all_details_win('hr_user_profile', $condition_response, array('id', 'emp_first_name', 'emp_last_name'));

        if (!empty($getEmployeeList)) {
            $option = '<option  value="" >--Select--</option>';
            foreach ($getEmployeeList as $lists) {
                $option .= '<option  value="' . $lists->id . '" >' . $lists->emp_first_name . ' ' . $lists->emp_last_name . '</option>';
                $returnArr['status'] = '1';
            }
        }
        $returnArr['response'] = $option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    public function insertEdit_funder() { #echo'<pre>';print_r($_POST);die;
    checkAuth();
    $name = $this->input->post('name');
    $address = $this->input->post('address');
    $type = $this->input->post('type');
    $city = $this->input->post('city');
    $fcra_status = $this->input->post('fcra_status');
    $country = $this->input->post('country');
    $pan = $this->input->post('pan');
    $grant_service = $this->input->post('grant_service');
    $funder_id = $this->input->post('funder_id');

    $contact_name = $this->input->post('contact_name');
    $designation = $this->input->post('designation');
    $mobile_number = $this->input->post('mobile_number');
    $email = $this->input->post('email');

    $description = $this->input->post('description');
    $dataArr = $funder_data = array();

        #Funder Details
        
    if ($name != '' && $type != '' && $fcra_status != '' && $grant_service != '') {
        $funder_data = array(
            'name' => $name, 'address' => $address, 'city' => $city, 'country' => $country, 'type' => $type,
            'pan' => $pan, 'grant_service' => $grant_service, 'address' => $address, 'status' => 1,
            'fcra_status' => $fcra_status, 'created_date' => date('Y-m-d H:i:s'), 'created_by' => '', 'updated_date' => '',
            'updated_by' => '', 'partner_id' => $this->session->userdata('partner_id')
        );
        if ($funder_id != '') {
            $condition = array('id' => $funder_id);
            $this->funder_model->update_data('funder_list', $condition, $funder_data);
            $this->funder_model->update_data('master_settings', array('master_type' => 'Donor', 'master_id' => $funder_id), array('master_name' => $name), true, 'ais');

            $this->setErrorMessage('Success', 'Funder details saved successfully');
            redirect('funder/edit_funder_form/' . $funder_id);
            exit;
        } else {
			
            $data = array('master_type' => 'Donor', 'pid' => '0',
                'master_name' => $name, 'partner_id' => $this->session->userdata('partner_id')
            );
			$this->funder_model->insert_data('master_settings', $data, true, 'ais');
			
            $getMasterId = $this->funder_model->get_all_details('master_settings', array('master_type' => 'Donor', 'master_name' => $name), array('master_id'), '', '', '', true, 'ais');
            $master_donor_id = $getMasterId[0]->master_id;
			
            $funder_data = array(
                'id' => $master_donor_id, 'name' => $name, 'address' => $address, 'city' => $city, 'country' => $country, 'type' => $type,
                'pan' => $pan, 'grant_service' => $grant_service, 'address' => $address, 'status' => 1,
                'fcra_status' => $fcra_status, 'created_date' => date('Y-m-d H:i:s'), 'created_by' => '', 'updated_date' => '',
                'updated_by' => '', 'partner_id' => $this->session->userdata('partner_id')
            );
			
            $this->funder_model->insert_data('funder_list', $funder_data);
			
            $funder_id = $master_donor_id;
			#echo'<pre>';print_r($funder_id);die;
        }
    }
    if ((!empty($contact_name) || !empty($designation) || !empty($mobile_number) || !empty($email)) && $funder_id != '') {

        $this->insert_EditFunder_Contacts('add', $funder_id);
    }
    if ($funder_id != '') {
        $this->insert_EditFunder_Doc('add', $funder_id);
    }
        #echo'<pre>';print_r($_POST);die;
    $this->setErrorMessage('Success', 'Funder details saved successfully');
    redirect('funder/add_grant_form/' . $funder_id);
}

    function insert_EditFunder_Contacts($type = '', $funder_id = '') { #error_reporting(-1);
        #echo'<pre>';print_r($_POST);die;
        #Multiple Contact Details
        checkAuth();
        if ($this->input->post('funder_id') != '' && $type == '') {
            $contact_id = $this->input->post('contact_id');
            $funder_id = $this->input->post('funder_id');
            $contact_name = $this->input->post('contact_name');
            $designation = $this->input->post('designation');
            $mobile_number = $this->input->post('mobile_number');
            $email = $this->input->post('email');
        } else {
            $contact_name = $this->input->post('contact_name');
            $designation = $this->input->post('designation');
            $mobile_number = $this->input->post('mobile_number');
            $email = $this->input->post('email');
        }

        $InsertDataArr = $dataArr = array();

        for ($i = 0; $i <= php72_count($contact_name); $i++) {
            $c_name = php72_array_values($contact_name[$i])[0];
            $c_designation = php72_array_values($designation[$i])[0];
            $c_email = php72_array_values($email[$i])[0];
            $c_mobile_number = php72_array_values($mobile_number[$i])[0];

            if ($c_name != '' || $c_designation != '' || $c_email != '' || $c_mobile_number != '') {
                if (isset($contact_id[$i]) && $contact_id[$i] != '') {
                    $dataArr = array(
                        'name' => $c_name, 'status' => 1, 'designation' => $c_designation,
                        'mobile_number' => $c_mobile_number, 'email' => $c_email, 'created_date' => date('Y-m-d H:i:s'),
                        'created_by' => '', 'updated_date' => '', 'updated_by' => ''
                    );
                    $condition = array('id' => $contact_id[$i]);
                    $this->funder_model->update_data('funder_contacts', $condition, $dataArr);
                } else { #echo'<pre>';print_r($contact_name);die;
                $InsertDataArr[] = array(
                    'funder_id' => $funder_id, 'name' => $c_name, 'status' => 1, 'designation' => $c_designation,
                    'mobile_number' => $c_mobile_number, 'email' => $c_email, 'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => '', 'updated_date' => '', 'updated_by' => ''
                );
            }
        }
    }
    if (!empty($InsertDataArr)) {
        $this->funder_model->insert_batch('funder_contacts', $InsertDataArr);
    }
    if ($type == '') {
        $this->setErrorMessage('Success', 'Contact details saved successfully');
            //redirect('funder/display_summary_list');
        redirect('funder/edit_funder_form/' . $funder_id);
        exit;
    }
}

    #Multiple File Upload

function insert_EditFunder_Doc($type = '', $funder_id = '') {

    checkAuth();
    $description = $this->input->post('description');
    $config['overwrite'] = FALSE;
    $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx';
    $config['max_size'] = 10485760;
    $config['upload_path'] = './uploads/file_documents/';
    $this->load->library('upload', $config);
        //error_reporting(-1);
    $file_dataArr = $filenameArr = $images = array();

    if (!empty($_FILES['file_upload'])) {
        if (php72_count($_FILES['file_upload']['name']) > 0) {
            $user_id = $this->session->userdata('emp_number');

                for ($i = 0; $i < php72_count($_FILES['file_upload']['name']); $i++) { #echo array_values($_FILES['file_upload']['type'][$i])[0];die;
                $fName = php72_array_values($_FILES['file_upload']['name'][$i])[0];
                if ($fName != '') {
                    $fileType = pathinfo($fName, PATHINFO_EXTENSION);
                    $file_name = uniqid(md5($fName . '' . time())) . '.' . $fileType;

                    $_FILES['images[]']['name'] = $file_name;
                    $_FILES['images[]']['type'] = $file_type = php72_array_values($_FILES['file_upload']['type'][$i])[0];
                    $_FILES['images[]']['tmp_name'] = php72_array_values($_FILES['file_upload']['tmp_name'][$i])[0];
                    $_FILES['images[]']['error'] = php72_array_values($_FILES['file_upload']['error'][$i])[0];
                    $_FILES['images[]']['size'] = php72_array_values($_FILES['file_upload']['size'][$i])[0];

                    $fileName = $file_name;
                    $images[] = $fileName;
                    $filenameArr[] = $fileName;
                        #echo'<pre>';print_r($_FILES);die;
                    $f_description = php72_array_values($description[$i])[0];

                    if ($fName != '' || $file_type != '' || $f_description != '') {
                        $res = $this->upload->initialize($config);
                        if ($this->upload->do_upload('images[]')) {
                            $uploaded = $this->upload->data();
                            $file_dataArr[] = array(
                                'funder_id' => $funder_id, 'file_name' => $fileName,
                                'description' => $f_description,
                                'uploaded_by' => $user_id,
                                'status' => 1, 'file_type' => $file_type,
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by' => '', 'updated_date' => '',
                                'updated_by' => ''
                            );
                        } else {
                            $logoDetails = $this->upload->display_errors();
                        }
                    }
                }
            }
                #echo'<pre>';print_r($file_dataArr);die;
            if (!empty($file_dataArr)) {
                $this->funder_model->insert_batch('funder_documents', $file_dataArr);
            }
        }
    }
}

function editFunder_Documents() {
        #error_reporting(-1);
    checkAuth();
    $description = $this->input->post('description');
    $document_id = $this->input->post('document_id');
    $funder_id = $this->input->post('funder_id');
    $condition = $file_dataArr = array();
    $user_id = $this->session->userdata('emp_number');

    $updatedName = $this->getAuthorization();
    if (!empty($description)) {
        $config['overwrite'] = FALSE;
        $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx';
        $config['max_size'] = 10485760;
        $config['upload_path'] = './uploads/file_documents/';
        $this->load->library('upload', $config);
        $doc_id = '';
        $countErr = 0;

        for ($i = 0; $i < php72_count($description); $i++) {

            $Check_fname = php72_array_values($_FILES['file_upload']['name'][$i])[0];
            $Check_description_val = php72_array_values($description[$i])[0];
            $countErr++;
            if (!empty($_FILES['file_upload'])) {
                if (php72_count($_FILES['file_upload']['name']) > 0) {
                    $fname = php72_array_values($_FILES['file_upload']['name'][$i])[0];
                    $description_val = php72_array_values($description[$i])[0];

                    $file_dataArr = array();
                    if (isset($fname) && $fname != '') {
                        $fileType = pathinfo($fname, PATHINFO_EXTENSION);
                        $file_name = uniqid(md5($fName . '' . time())) . '.' . $fileType;

                        $_FILES['images[]']['name'] = $file_name;
                        $_FILES['images[]']['type'] = $file_type = php72_array_values($_FILES['file_upload']['type'][$i])[0];
                        $_FILES['images[]']['tmp_name'] = php72_array_values($_FILES['file_upload']['tmp_name'][$i])[0];
                        $_FILES['images[]']['error'] = php72_array_values($_FILES['file_upload']['error'][$i])[0];
                        $_FILES['images[]']['size'] = php72_array_values($_FILES['file_upload']['size'][$i])[0];

                        $fileName = $file_name;
                        $images[] = $fileName;
                        $filenameArr[] = $fileName;

                        $this->upload->initialize($config);
                            #echo'<pre>';print_r($_FILES);
                            #echo $fileName; echo '==';echo $file_type;
                        if ($this->upload->do_upload('images[]')) {
                            $uploaded = $this->upload->data();
                            $file_dataArr = array(
                                'file_name' => $fileName,
                                'status' => 1, 'file_type' => $file_type
                            );
                        } else {
                            $logoDetails = $this->upload->display_errors();
                                #echo'<pre>';print_r($logoDetails);die;
                        }
                            #die;
                    }
                }
            }
            $dataArr = array();
            $document_Ids = $document_id[$i];

                if ($document_Ids != '') {#update
                    $condition = array('id' => $document_Ids);
                    $dataArr = array('description' => $description_val, 'uploaded_by' => $user_id, 'funder_id' => $funder_id, 'updated_by' => $user_id, 'updated_date' => date('Y-m-d H:i:s'));
                    $dataArr = array_merge_recursive($dataArr, $file_dataArr);
                    $get_funderDoc = $this->funder_model->get_all_details('funder_documents', $condition, array('file_name'));
                    if (!empty($file_dataArr)) {
                        if (isset($get_funderDoc[0]->file_name) && $get_funderDoc[0]->file_name != '') {
                            unlink('uploads/file_documents/' . $get_funderDoc[0]->file_name);
                        }
                    }
                    $this->funder_model->update_data('funder_documents', $condition, $dataArr);
                } else {#Insert
                    #echo $Check_fname;
                    if ($Check_fname != '' || $Check_description_val != '') {
                        $dataArr = array(
                            'description' => $description_val, 'funder_id' => $funder_id, 'uploaded_by' => $user_id,
                            'created_date' => date('Y-m-d H:i:s'), 'created_by' => '$user_id'
                        );
                        $dataArr = array_merge_recursive($dataArr, $file_dataArr);
                        $this->funder_model->insert_data('funder_documents', $dataArr);
                    }
                }
            }
        }
        if ($countErr > 0) {
            $this->setErrorMessage('Success', 'Documents details saved successfully');
            redirect('funder/edit_funder_documents/' . $funder_id);
        } else {

        }
        redirect('funder/edit_funder_documents/' . $funder_id);
    }

    public function insertEdit_grant() {
        #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
        checkAuth();
        $name = $this->input->post('name');
        $programme = $this->input->post('programme');
        $donor = $this->input->post('donor');
        $grant_sign_date = $this->input->post('grant_sign_date');
        $grant_start_date = $this->input->post('grant_start_date');
        $grant_end_date = $this->input->post('grant_end_date');
        $purpose = $this->input->post('purpose');
        $grant_amt = str_replace(',', '', $this->input->post('grant_amt'));
        $status_type = $this->input->post('status_type');


        $budget = $this->input->post('budget');
        $line_item = $this->input->post('line_item');
        $sub_line = $this->input->post('sub_line');
        $grant_amount = $this->input->post('grant_amount');
        $grant_comments = $this->input->post('grant_comments');

        $disbursement_mile = $this->input->post('disbursement_mile');
        $date_disbursement = $this->input->post('date_disbursement');
        $disbursement_amount = $this->input->post('disbursement_amount');
        $date_deposite = $this->input->post('date_deposite');
        $amount_deposite = $this->input->post('amount_deposite');
        $disbursement_cmd = $this->input->post('disbursement_cmd');

        $grantreport_sub = $this->input->post('submit_date');
        $grantreport_dop = $this->input->post('grantreport_dop');
        $grantreport_resp = $this->input->post('grantreport_resp');
        $grantreport_cmd = $this->input->post('grantreport_cmd');

        $disbursement_data = $grant_line_data = $file_dataArr = array();

        $tbl_grant_id = $this->input->post('tbl_grant_id'); #from edit section
        $status_commands = $this->input->post('status_commands');

        #echo'<pre>';print_r($_POST);die;
        if (!empty($disbursement_amount)) {
            $i = 0;
            $sum = '';
            foreach ($disbursement_amount as $key => $val) {
                foreach ($val as $sumval) {
                    $sum += str_replace(',', '', $sumval);
                }
            }
        }

        if ($grant_sign_date != '' && $grant_start_date != '' && $grant_end_date != '' && $grant_amt != '' && $status_type != '') {

            $grant_data = array(
                'name' => $name,
                'programme_id' => $programme, 'funder_id' => $donor, 'grant_id' => '' . time(),
                'status' => 1, 'signed_date' => date('Y-m-d H:i:s', strtotime($grant_sign_date)),
                'start_date' => date('Y-m-d H:i:s', strtotime($grant_start_date)),
                'end_date' => date('Y-m-d H:i:s', strtotime($grant_end_date)),
                'purpose' => $purpose, 'grant_amount' => $grant_amt,
                'status_type' => $status_type, 'created_date' => date('Y-m-d H:i:s'),
                'created_by' => '', 'updated_date' => '',
                'updated_by' => '', 'partner_id' => $this->session->userdata('partner_id')
            ); #echo'asdasd';die;
            if ($sum != '') {
                $grant_data['disbursement_amount'] = $sum;
            }
            #echo '<pre>';print_r($grant_data);die;
            if ($tbl_grant_id != '') {
                $condt = array('id' => $tbl_grant_id, 'funder_id' => $donor);
                $get_GrantStatus = $this->funder_model->get_all_details('grant_list', $condt, array('status_type'), '', '', array('status' => 'desc'));

                $condition = array('id' => $tbl_grant_id);
                unset($grant_data['funder_id']);
                unset($grant_data['created_date']);
                unset($grant_data['created_by']);
                unset($grant_data['partner_id']);
                $grant_data['updated_date'] = date('d-m-Y H:i:s');
                #echo'<pre>';print_r($grant_data);die;
                $this->funder_model->update_data('grant_list', $condition, $grant_data);
            } else {
                #echo'<pre>';print_r($grant_data);die;
                $grant_data['name'] = $name;
                $this->funder_model->insert_data('grant_list', $grant_data);
                $grant_id = $this->db->insert_id();
            }
            #echo'<pre>';print_r($grant_data);die;
            #Log start

            $condition = array('user_id' => $this->session->userdata('emp_number'));
            $get_funderDoc = $this->funder_model->get_all_details('funder_logs', $condition, array('id', 'to_status', 'from_status'), '', '', array('to_status' => 'desc'));
            $log_data = array(
                'user_id' => $this->session->userdata('emp_number'),
                'user_name' => $this->session->userdata('emp_name'),
                'partner_id' => $this->session->userdata('partner_id'),
                'funder_id' => $donor,
                'grant_id' => $grant_id,
                'date' => date('Y-m-d H:i:s'),
                'to_status' => $status_type,
                'comments' => $purpose
            );
            if ($tbl_grant_id != '') {
                if (!empty($get_GrantStatus)) {
                    $log_data['from_status'] = $get_GrantStatus[0]->status_type;
                    $log_data['grant_id'] = $tbl_grant_id;
                }
                $log_data['comments'] = $status_commands;
                if (!empty($log_data)) {
                    if ($status_commands != '') {
                        $this->funder_model->insert_data('funder_logs', $log_data);
                    }
                }
            }

            #Log end

            if ($tbl_grant_id != '') {
                $this->setErrorMessage('Success', 'Grant details saved successfully');
                redirect('funder/edit_grant_form/' . $tbl_grant_id);
                exit;
            }
        }

        if (!empty($budget) || !empty($line_item) || !empty($date_deposite) || !empty($grant_amount) || !empty($grant_comments)) {
            $this->inserEdit_grant_line('add', $grant_id, $donor);
        }
        #echo'<pre>';print_r($grant_line_data);
        if (!empty($disbursement_mile) || !empty($date_disbursement) || !empty($disbursement_amount) || !empty($date_deposite) || !empty($amount_deposite) || !empty($disbursement_cmd)) {
            $this->inserEdit_disbursement('add', $grant_id, $donor);
        }
        # echo'<pre>';print_r($disbursement_data);
        #Multiple File Upload
        if ($grant_id != '') {
            $config['overwrite'] = FALSE;
            //$config['encrypt_name'] = TRUE;
            $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx';
            $config['max_size'] = 10485760;
            $config['upload_path'] = './uploads/file_documents/';
            $this->load->library('upload', $config);
            //error_reporting(-1);
            $file_dataArr = $dataArr = $filenameArr = $images = array();

            if (!empty($grantreport_dop)) {
                if (php72_count($grantreport_dop) > 0) {
                    for ($i = 0; $i < php72_count($grantreport_dop); $i++) { #echo array_values($_FILES['file_upload']['type'][$i])[0];die;
                    $f_grantreport_sub = php72_array_values($grantreport_sub[$i])[0];
                    $f_grantreport_resp = php72_array_values($grantreport_resp[$i])[0];
                    $f_grantreport_cmd = php72_array_values($grantreport_cmd[$i])[0];
                    $fType = php72_array_values($_FILES['file_upload']['type'][$i])[0];
                    $f_grantreport_dop = php72_array_values($grantreport_dop[$i])[0];

                    $grantreport_dop_val = $grantreport_sub_val = '';
                    if ($f_grantreport_dop != '')
                        $grantreport_dop_val = date('Y-m-d H:i:s', strtotime($f_grantreport_dop));
                    if ($f_grantreport_sub != '')
                        $grantreport_sub_val = date('Y-m-d H:i:s', strtotime($f_grantreport_dop));


                    if ($f_grantreport_dop != '' || $f_grantreport_resp != '' || $f_grantreport_cmd != '' || $fType != '') {
                        if (!empty($_FILES['file_upload'])) {
                            if (php72_count($_FILES['file_upload']['name']) > 0) {
                                $fName = php72_array_values($_FILES['file_upload']['name'][$i])[0];
                                if ($fName != '') {
                                    $fType = php72_array_values($_FILES['file_upload']['type'][$i])[0];
                                    $fileTypeArr = explode("/", $fType);
                                    $fileType = $fileTypeArr[1];
                                    $fileType = pathinfo($fName, PATHINFO_EXTENSION);

                                    $file_name = uniqid(md5($fName)) . '.' . $fileType;
                                    $_FILES['images[]']['name'] = $file_name;
                                    $_FILES['images[]']['type'] = $file_type = php72_array_values($_FILES['file_upload']['type'][$i])[0];
                                    $_FILES['images[]']['tmp_name'] = php72_array_values($_FILES['file_upload']['tmp_name'][$i])[0];
                                    $_FILES['images[]']['error'] = php72_array_values($_FILES['file_upload']['error'][$i])[0];
                                    $_FILES['images[]']['size'] = php72_array_values($_FILES['file_upload']['size'][$i])[0];



                                    $fileName = $file_name;
                                    $images[] = $fileName;
                                    $filenameArr = $fileName;
                                    $res = $this->upload->initialize($config);
                                    if ($this->upload->do_upload('images[]')) {
                                        $uploaded = $this->upload->data();
                                        $file_dataArr = array(
                                            'file_name' => $file_name
                                        );
                                    } else {
                                        $logoDetails = $this->upload->display_errors();
                                        echo'<pre>';
                                        print_r($logoDetails);
                                    }
                                }
                            }
                        }
                        $dataArr = array(
                            'grant_id' => $grant_id,
                            'status' => 1,
                            'funder_id' => $donor,
                            'submit_date' => $grantreport_sub_val,
                            'date_of_report' => $grantreport_dop_val,
                            'responsibility' => $f_grantreport_resp,
                            'comments' => $f_grantreport_cmd,
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => '', 'updated_date' => '',
                            'updated_by' => '', 'partner_id' => $this->session->userdata('partner_id')
                        );
                        $InsertArr = array_merge_recursive($dataArr, $file_dataArr);
                        if (!empty($InsertArr)) {
                            $this->funder_model->insert_data('grant_reports', $InsertArr);
                        }
                    }
                }
            }
        }
    }
    $this->setErrorMessage('Success', 'Grant line details saved successfully');
    redirect('funder/display_grant_list/' . $donor);
}

    function inserEdit_grant_line($type = '', $grant_id = '', $donor = '') {  #ECHO'<PRE>';print_r($_POST);die;
    checkAuth();
    $tbl_grant_id = $this->input->post('tbl_grant_id');
    if ($tbl_grant_id != '') {
        $budget = $this->input->post('budget');
        $line_item = $this->input->post('line_item');
        $sub_line = $this->input->post('sub_line');
        $grant_amount = $this->input->post('grant_amount');
        $grant_comments = $this->input->post('grant_comments');
        $garntline_id = $this->input->post('garntline_id');
        $programme = $this->input->post('hid_programme_id');
        $donor = $this->input->post('hid_funder_id');
        $grant_id = $tbl_grant_id;
    } else {
        $budget = $this->input->post('budget');
        $line_item = $this->input->post('line_item');
        $sub_line = $this->input->post('sub_line');
        $grant_amount = $this->input->post('grant_amount');
        $grant_comments = $this->input->post('grant_comments');
        $programme = $this->input->post('programme');
    }
    $InsertDataArr = $dataArr = array();
    for ($i = 0; $i <= php72_count($budget) - 1; $i++) {
        $g_budget = php72_array_values($budget[$i])[0];
        $g_line_item = php72_array_values($line_item[$i])[0];
        $g_sub_line = php72_array_values($sub_line[$i])[0];
        $g_grant_amount = str_replace(',', '', php72_array_values($grant_amount[$i])[0]);
        $g_grant_comments = php72_array_values($grant_comments[$i])[0];

        if (isset($garntline_id[$i]) && $garntline_id[$i] != '') {
            $condition = array('id' => $garntline_id[$i]);
            $dataArr = array(
                'programme_id' => $programme, 'funder_id' => $donor, 'budget_head_id' => $g_budget,
                'lineitem_id' => $g_line_item, 'subline_id' => $g_sub_line, 'amount' => $g_grant_amount, 'comments' => $g_grant_comments,
                'updated_date' => date('Y-m-d H:i:s'), 'updated_by' => ''
            );
            $this->funder_model->update_data('grant_line', $condition, $dataArr);
        } else {
            if ($g_budget != '' || $g_line_item != '' || $g_grant_amount != '' || $g_grant_comments != '') {
                $InsertDataArr[] = array(
                    'grant_id' => $grant_id, 'programme_id' => $programme, 'funder_id' => $donor, 'budget_head_id' => $g_budget,
                    'lineitem_id' => $g_line_item, 'subline_id' => $g_sub_line, 'amount' => $g_grant_amount, 'comments' => $g_grant_comments,
                    'status' => 1, 'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => '', 'updated_date' => '',
                    'updated_by' => '', 'partner_id' => $this->session->userdata('partner_id')
                );
            }
        }
    }
    if (!empty($InsertDataArr)) {
        $this->funder_model->insert_batch('grant_line', $InsertDataArr);
    }
    if ($tbl_grant_id != '') {
        $this->setErrorMessage('Success', 'Grant line details saved successfully');
        redirect('funder/edit_grant_form/' . $tbl_grant_id);
        exit;
    }
}

    function inserEdit_disbursement($type = '', $grant_id = '', $donor = '') {  #echo'<pre>';print_r($grant_id);die;
    checkAuth();
    $tbl_grant_id = $this->input->post('tbl_grant_id');
    if ($tbl_grant_id != '') {
        $disbursement_mile = $this->input->post('disbursement_mile');
        $date_disbursement = $this->input->post('date_disbursement');
        $disbursement_amount = $this->input->post('disbursement_amount');
        $date_deposite = $this->input->post('date_deposite');
        $amount_deposite = $this->input->post('amount_deposite');
        $disbursement_cmd = $this->input->post('disbursement_cmd');

        $disbursement_id = $this->input->post('disbursement_id');
        $programme = $this->input->post('hid_programme_id');
        $donor = $this->input->post('hid_funder_id');
        $grant_id = $tbl_grant_id;
    } else {
        $disbursement_mile = $this->input->post('disbursement_mile');
        $date_disbursement = $this->input->post('date_disbursement');
        $disbursement_amount = $this->input->post('disbursement_amount');
        $date_deposite = $this->input->post('date_deposite');
        $amount_deposite = $this->input->post('amount_deposite');
        $disbursement_cmd = $this->input->post('disbursement_cmd');
        $programme = $this->input->post('programme');
    }

    $InsertDataArr = $dataArr = array();
    for ($i = 0; $i <= php72_count($disbursement_mile) - 1; $i++) {
        $d_disbursement_mile = php72_array_values($disbursement_mile[$i])[0];
        $d_date_disbursement = php72_array_values($date_disbursement[$i])[0];
        $d_disbursement_amount = str_replace(',', '', php72_array_values($disbursement_amount[$i])[0]);
        $d_date_deposite = php72_array_values($date_deposite[$i])[0];
        $d_amount_deposite = str_replace(',', '', php72_array_values($amount_deposite[$i])[0]);
        $d_disbursement_cmd = php72_array_values($disbursement_cmd[$i])[0];

        if (isset($disbursement_id[$i]) && $disbursement_id[$i] != '') {
            $condition = array('id' => $disbursement_id[$i]);
            $date_disbursement_val = '';
            if ($d_date_disbursement != '') {
                $date_disbursement_val = date('Y-m-d H:i:s', strtotime($d_date_disbursement));
            }
            $date_deposite_val = '';
            if ($d_date_deposite != '') {
                $date_deposite_val = date('Y-m-d H:i:s', strtotime($d_date_disbursement));
            }
            $dataArr = array(
                'programme_id' => $programme, 'funder_id' => $donor,
                'milestone' => $d_disbursement_mile, 'date_of_disbursement' => $date_disbursement_val,
                'amount' => $d_disbursement_amount, 'date_of_deposite' => $date_deposite_val,
                'amount_deposite' => $d_amount_deposite, 'comments' => $d_disbursement_cmd,
                'updated_date' => date('Y-m-d H:i:s'), 'updated_by' => ''
            );

            $this->funder_model->update_data('disbursement_schedule', $condition, $dataArr);
                #echo'<pre>';print_r($dataArr);die;
                #echo'<pre>';print_r($dataArr);
        } else {
            if ($d_disbursement_mile != '' || $d_date_disbursement != '' || $d_disbursement_amount != '' || $d_date_deposite != '' || $d_amount_deposite != '' || $d_disbursement_cmd != '') {
                $date_disbursement_val = '';
                $date_deposite_val = '';
                if ($d_date_disbursement != '')
                    $date_disbursement_val = date('Y-m-d H:i:s', strtotime($d_date_disbursement));
                if ($d_date_deposite != '')
                    $date_deposite_val = date('Y-m-d H:i:s', strtotime($d_date_disbursement));
                $InsertDataArr[] = array(
                    'grant_id' => $grant_id, 'programme_id' => $programme, 'funder_id' => $donor,
                    'milestone' => $d_disbursement_mile, 'date_of_disbursement' => $date_disbursement_val,
                    'amount' => $d_disbursement_amount, 'date_of_deposite' => $date_deposite_val,
                    'amount_deposite' => $d_amount_deposite, 'comments' => $d_disbursement_cmd, 'status' => 1, 'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => '', 'updated_date' => '', 'updated_by' => '', 'partner_id' => $this->session->userdata('partner_id')
                );
            }
        }
    }
    if (!empty($InsertDataArr)) {
        $this->funder_model->insert_batch('disbursement_schedule', $InsertDataArr);
    }
        #Sum disb amount to grant list
    if ($tbl_grant_id != '') {
        $grant_id = $tbl_grant_id;
    }
    if (!empty($amount_deposite)) {
        $i = 0;
        $sum = '';
        foreach ($amount_deposite as $key => $val) {
            foreach ($val as $sumval) {
                $sum += str_replace(',', '', $sumval);
            }
        }
        if ($sum != '' && php72_cmp($sum) > 0) {
            if ($grant_id != '') {
                $get_disb_amount = $this->funder_model->get_all_details('disbursement_schedule', array('funder_id' => $donor, 'grant_id' => $grant_id), array('SUM(amount_deposite) as amount_deposite'));
                $total_depositeAmt = $get_disb_amount[0]->amount_deposite;
                $grant_data['disbursement_amount'] = $total_depositeAmt;
                $this->funder_model->update_data('grant_list', array('id' => $grant_id), $grant_data);
            } else {
                $grant_data['disbursement_amount'] = $sum;
                $this->funder_model->update_data('grant_list', array('id' => $grant_id), $grant_data);
            }
        }
    }
        #Sum disb amount to grant list
    if ($tbl_grant_id != '') {
        $this->setErrorMessage('Success', 'Disbursement details saved successfully');
        redirect('funder/edit_grant_form/' . $tbl_grant_id);
        exit;
    }
}

    function edit_grantreport_form() { #echo'<pre>';print_r($_POST);die;
    checkAuth();
    $tbl_grant_id = $this->input->post('tbl_grant_id');
    if ($tbl_grant_id != '') {
        $grantreport_sub = $this->input->post('submit_date');
        $grantreport_dop = $this->input->post('grantreport_dop');
        $grantreport_resp = $this->input->post('grantreport_resp');
        $grantreport_cmd = $this->input->post('grantreport_cmd');
        $programme = $this->input->post('hid_programme_id');
        $grantreport_id = $this->input->post('grantreport_id');
        $donor = $this->input->post('hid_funder_id');
        $grant_id = $tbl_grant_id;
    }

    $condition = $file_dataArr = array();

    if (!empty($grantreport_dop)) {
        $config['overwrite'] = FALSE;
            //$config['encrypt_name'] = TRUE;
        $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx';
        $config['max_size'] = 10485760;
        $config['upload_path'] = './uploads/file_documents/';
        $this->load->library('upload', $config);
        $doc_id = $f_grantreport_dop = $fname = $f_grantreport_resp = $f_grantreport_cmd = '';
        for ($i = 0; $i < php72_count($grantreport_dop); $i++) {
            $grantreport_ids = $grantreport_id[$i];
            $check_fname = php72_array_values($_FILES['file_upload']['name'][$i])[0];
            $f_grantreport_sub = php72_array_values($grantreport_sub[$i])[0];
            $f_grantreport_dop = php72_array_values($grantreport_dop[$i])[0];
            $f_grantreport_resp = php72_array_values($grantreport_resp[$i])[0];
            $f_grantreport_cmd = php72_array_values($grantreport_cmd[$i])[0];

            if (!empty($_FILES['file_upload'])) {
                if (php72_count($_FILES['file_upload']['name']) > 0) {
                    $fname = php72_array_values($_FILES['file_upload']['name'][$i])[0];

                    if (isset($fname) && $fname != '') {
                        $fileType = pathinfo($fname, PATHINFO_EXTENSION);

                        $file_name = uniqid(md5($fName . '' . time())) . '.' . $fileType;
                        $_FILES['images[]']['name'] = $file_name;
                        $_FILES['images[]']['type'] = $file_type = php72_array_values($_FILES['file_upload']['type'][$i])[0];
                        $_FILES['images[]']['tmp_name'] = php72_array_values($_FILES['file_upload']['tmp_name'][$i])[0];
                        $_FILES['images[]']['error'] = php72_array_values($_FILES['file_upload']['error'][$i])[0];
                        $_FILES['images[]']['size'] = php72_array_values($_FILES['file_upload']['size'][$i])[0];

                        $fileName = $file_name;
                        $images[] = $fileName;
                        $filenameArr[] = $fileName;

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('images[]')) {
                            $uploaded = $this->upload->data();
                            $file_dataArr = array(
                                'file_name' => $fileName,
                                'status' => 1
                            );
                        } else {
                            $logoDetails = $this->upload->display_errors();
                                # echo'<pre>';print_r($logoDetails);die;
                        }
                    }
                }
                }  #echo'<pre>';print_r($file_dataArr);die;

                if ($grantreport_ids != '') {#update
                    $grantreport_dop_val = $grantreport_sub_val = '';
                    if ($f_grantreport_dop != '')
                        $grantreport_dop_val = date('Y-m-d H:i:s', strtotime($f_grantreport_dop));
                    if ($f_grantreport_sub != '')
                        $grantreport_sub_val = date('Y-m-d H:i:s', strtotime($f_grantreport_sub));

                    $condition = array('id' => $grantreport_ids);
                    $dataArr = array(
                        'grant_id' => $grant_id,
                        'Programme_id' => $programme,
                        'funder_id' => $donor,
                        'date_of_report' => $grantreport_dop_val,
                        'submit_date' => $grantreport_sub_val,
                        'responsibility' => $f_grantreport_resp,
                        'comments' => $f_grantreport_cmd,
                        'updated_date' => date('Y-m-d H:i:s'), 'updated_by' => ''
                    );
                    #echo'<pre>';print_r($dataArr);die;
                    $get_grantDoc = $this->funder_model->get_all_details('grant_reports', $condition, array('file_name'));

                    if (!empty($file_dataArr)) {
                        if (isset($get_grantDoc[0]->file_name) && $get_grantDoc[0]->file_name != '') {
                            unlink('uploads/file_documents/' . $get_grantDoc[0]->file_name);
                        }
                    }
                    $dataArr = array_merge_recursive($dataArr, $file_dataArr);
                    $this->funder_model->update_data('grant_reports', $condition, $dataArr);
                } else {#Insert
                    if ($check_fname || $f_grantreport_sub || $f_grantreport_dop || $f_grantreport_resp || $f_grantreport_cmd) {

                        $grantreport_dop_val = $grantreport_sub_val = '';
                        if ($f_grantreport_dop != '')
                            $grantreport_dop_val = date('Y-m-d H:i:s', strtotime($f_grantreport_dop));
                        if ($f_grantreport_sub != '')
                            $grantreport_sub_val = date('Y-m-d H:i:s', strtotime($f_grantreport_dop));

                        $dataArr = array(
                            'grant_id' => $grant_id,
                            'Programme_id' => $programme,
                            'funder_id' => $donor,
                            'submit_date' => $grantreport_sub_val,
                            'date_of_report' => $grantreport_dop_val,
                            'responsibility' => $f_grantreport_resp,
                            'comments' => $f_grantreport_cmd,
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => '', 'updated_date' => '',
                            'updated_by' => '', 'partner_id' => $this->session->userdata('partner_id')
                        );

                        $dataArr = array_merge_recursive($dataArr, $file_dataArr);
                        $this->funder_model->insert_data('grant_reports', $dataArr);
                    }
                }
            }
        }
        if ($tbl_grant_id != '') {
            $this->setErrorMessage('Success', 'Grant report saved successfully');
            redirect('funder/edit_grant_form/' . $tbl_grant_id);
            exit;
        }
    }

    public function ajax_funder_validate() {
        #error_reporting(-1);
        checkAuth();
        $name = $this->input->post('name');
        $funder_id = $this->input->post('funder_id');
        $mobile_number = $this->input->post('mobile_number');
        $email = $this->input->post('email');
        $pan = $this->input->post('pan');
        $contact_id = $this->input->post('contact_id');
        $mobile_id = php72_array_filter($this->input->post('mobile_id'));
        $email_id = php72_array_filter($this->input->post('email_id'));

        $dataArr = $funder_data = $get_contacts = array();
        $data = array();
        $status = array();
        $returnArr['status'] = 0;
        $status_sum = '';
        $status = array();
        if ($funder_id != '') {
            $condition['id !='] = $funder_id;
        }
        if ($name != '') {
            if ($name != '') {
                $condition['name'] = $name;
                $get_funderData = $this->funder_model->get_all_details('funder_list', $condition, array('id'));
                if (!empty($get_funderData)) {
                    $status[] = 1;
                    $data['name_error'] = 'Name already exists';
                }
            }
        }

        if ($pan != '') {
            $condition['pan'] = $pan;
            unset($condition['name']);
            $get_PanData = $this->funder_model->get_all_details('funder_list', $condition, array('id'));
            if (!empty($get_PanData)) {
                $status[] = 1;
                $data['pan_error'] = 'Pan Number already exists';
            }
        }

        if (!empty($mobile_number)) { #echo'd';die;
        unset($condition['name']);
        unset($condition['pan']);

        for ($i = 0; $i <= php72_count($mobile_number) - 1; $i++) {
            $c_mobile_number = $mobile_number[$i];
            if ($c_mobile_number != '') {
                $get_id = array_search($c_mobile_number, $mobile_id);
                $mobile_error_key = php72_array_keys($mobile_number)[$i];
                $condition2 = array('mobile_number' => $c_mobile_number);
                if ($get_id != '') {
                    $condition2['id !='] = $get_id;
                }
                    # echo'<pre>';print_r($condition2);
                $get_mobile = $this->funder_model->get_all_details('funder_contacts', $condition2, array('id'));
                    # echo'<pre>';print_r($get_mobile);
                    if (!empty($get_mobile)) {#echo'<pre>';print_r($get_mobile);
                    $status[] = 1;
                    $data['phone_err_' . $mobile_error_key] = 'Mobile Number already exists';
                }
            }
        }
    }


    if (!empty($email)) {
        unset($condition['name']);
        unset($condition['pan']);
        for ($i = 0; $i <= php72_count($email) - 1; $i++) {
            $email_error_key = php72_array_keys($email)[$i];
            $c_email = $email[$i];
            $condition = array('email' => $c_email);
            $get_id = array_search($c_email, $email_id);
            if ($get_id != '') {
                $condition['id !='] = $get_id;
            }

            $get_email = $this->funder_model->get_all_details('funder_contacts', $condition, array('id'));
            if (!empty($get_email)) {
                $status[] = 1;
                $data['email_err_' . $email_error_key] = 'Email id already exists';
            }
        }
    }
        #echo'<pre>';print_r($data);die;

    $status_sum = array_sum($status);
    if (php72_cmp($status_sum) > 0) {
        $returnArr['status'] = 1;
    }
    $returnArr['response'] = $data;
    $output = json_encode($returnArr);
    echo $output;
    exit;
}

    function get_donor_ajax_data() {   #echo'<pre>';print_r($_POST);die;
    checkAuth();
    $programe_id = $this->input->post('programe_id');
    $selected_funder_id = $this->input->post('selected_funder_id');

    $returnArr['status'] = '0';
    $returnArr['donor_id'] = '';
    $donor_ids = array();

    if ($selected_funder_id != '') {
        $get_results = $this->funder_model->get_all_details('funder_list', array(), array('name', 'id'));
        if (isset($get_results) && !empty($get_results)) {
            $donor_option = '<option  value="" >--Select--</option>';
            foreach ($get_results as $lists) {
                $selected_opt = '';
                if (isset($selected_funder_id) && $selected_funder_id != '') {
                    if ($selected_funder_id == $lists->id) {
                        $selected_opt = 'selected';
                    }
                }
                $donor_option .= '<option  ' . $selected_opt . ' value="' . $lists->id . '" name="a">' . $lists->name . '</option>';
                $returnArr['status'] = '1';
                $returnArr['donor_id'] = $selected_funder_id;
            }
        }
    }
    $returnArr['response'] = $donor_option;
    $output = json_encode($returnArr);
    echo $output;
    exit;
}

    function get_budget_ajax_data() { #echo'<pre>';print_r($_POST);die;
    checkAuth();
    $donor_id = $this->input->post('donor_id');
    $budgetList = $this->funder_model->getMasterSetting('Budget Head', NULL, $donor_id, '', true, 'ais');

    $returnArr['status'] = '0';
    $budget_option = '';
    $budget_option = '<option  value="" >--Select--</option>';
    if ($donor_id != '') {
        if (!empty($budgetList)) {
                foreach ($budgetList as $lists) { #echo'<pre>';print_r($lists);die;
                $budget_option .= '<option  value="' . $lists['master_id'] . '">' . $lists['master_name'] . '</option>';
                $returnArr['status'] = '1';
            }
        }
        }#echo'<pre>';print_r($budget_option);die;
        $returnArr['response'] = $budget_option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function get_lineitem_ajax_data() { #echo'<pre>';print_r($_POST);die;
    checkAuth();
    $lineitem_id = $this->input->post('lineitem_id');
    $selected_id = $this->input->post('selected_id');

    $lineitemList = $this->funder_model->getMasterSetting('Line Item', NULL, $lineitem_id, '', true, 'ais');

    $returnArr['status'] = '0';
    $lineitem_option = '';
    if ($lineitem_id != '') {
        if (!empty($lineitemList)) {
            $lineitem_option = '<option  value="" >--Select--</option>';
                foreach ($lineitemList as $lists) { #echo'<pre>';print_r($lists);die;
                $selected_opt = '';
                if (isset($selected_id) && $selected_id != '') {
                    if ($selected_id == $lists['master_id']) {
                        $selected_opt = 'selected';
                    }
                }
                $lineitem_option .= '<option ' . $selected_opt . ' value="' . $lists['master_id'] . '" >' . $lists['master_name'] . '</option>';
                $returnArr['status'] = '1';
            }
        }
        }#echo'<pre>';print_r($budget_option);die;
        $returnArr['response'] = $lineitem_option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function get_subline_ajax_data() { #echo'<pre>';print_r($_POST);die;
    checkAuth();
    $lineitem_id = $this->input->post('lineitem_id');
    $sublineitemList = $this->funder_model->getMasterSetting('Cost Centre', NULL, $lineitem_id, '', true, 'ais');
    $sublineitem_option = '';
    $returnArr['status'] = '0';
    if ($sublineitem_id != '') {
        if (!empty($sublineitemList)) {
            $sublineitem_option = '<option  value="" >--Select--</option>';
            foreach ($sublineitemList as $lists) {
                $sublineitem_option .= '<option  value="' . $lists['master_id'] . '" >' . $lists['master_name'] . '</option>';
                $returnArr['status'] = '1';
            }
        }
        }#echo'<pre>';print_r($budget_option);die;
        $returnArr['response'] = $sublineitem_option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function ajax_common_delete() { #error_reporting(-1);
        //echo'<pre>';print_r($_POST);die;
        checkAuth();
        $returnArr['status'] = '0';
        $common_id = $this->input->post('common_id');
        $formType = $this->input->post('formType');
        $grant_id = $this->input->post('grant_id');
        $common_id = array_values(php72_array_filter($common_id));
        if (!empty($common_id) && $formType != '') {

            $condition = array('id' => $common_id);
            if ($formType == 'contact_table') {
                $table_name = 'funder_contacts';
            } else if ($formType == 'funder_document') {
                $table_name = 'funder_documents';
                $condition = array('id' => $common_id);
                $get_file_names = $this->funder_model->get_all_details_win('funder_documents', $condition, array('file_name'));
                foreach ($get_file_names as $lists) {
                    if ($lists->file_name != '') {
                        unlink('uploads/file_documents/' . $lists->file_name);
                    }
                }
            } else if ($formType == 'grantline_table') {
                $table_name = 'grant_line';
            } else if ($formType == 'disbursement_table') {
                $table_name = 'disbursement_schedule';
            } else if ($formType == 'grantreport_table') {
                $table_name = 'grant_reports';
            }
            if ($grant_id != '' && $formType == 'disbursement_table' && !empty($common_id)) {
                $totalAmt = '';
                $get_amount_dep = $this->funder_model->get_all_details_win('disbursement_schedule', $condition, array('SUM(amount_deposite) as amount'));
                $getDisbAmt = $this->funder_model->get_all_details_win('grant_list', array('id' => $grant_id), array('disbursement_amount'));
                if (isset($getDisbAmt[0]->disbursement_amount) && $getDisbAmt[0]->disbursement_amount != '') {
                    if (isset($get_amount_dep[0]->amount) && $get_amount_dep[0]->amount != '') {
                        if ($getDisbAmt[0]->disbursement_amount > $get_amount_dep[0]->amount) {
                            $totalAmt = $getDisbAmt[0]->disbursement_amount - $get_amount_dep[0]->amount;
                        }
                    }
                }
                $this->funder_model->update_data('grant_list', array('id' => $grant_id), array('disbursement_amount' => $totalAmt));
            }
            $this->funder_model->delete_data_in($table_name, $condition);

            $returnArr['status'] = '1';
        }
        $this->setErrorMessage('Success', 'Record(s) deleted successfully');
        $returnArr['response'] = 'Record(s) Deleted successfully';
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function ajax_delete_funder_document() { #echo'<pre>';print_r($_POST);die;
    $id = $this->input->post('id');
    $returnArr['status'] = '0';
    if ($id != '') {
        $get_file_names = $this->funder_model->get_all_details('funder_documents', array('id' => $id), array('file_name'));
        if (!empty($get_file_names)) {
            unlink('uploads/file_documents/' . $get_file_names[0]->file_name);
            $this->funder_model->update_data('funder_documents', array('id' => $id), array('file_name' => ''));
            $returnArr['status'] = '1';
        }
    }
    $this->setErrorMessage('Success', 'Funder document deleted successfully');
    echo json_encode($returnArr);
}

    function ajax_delete_grant_document() { #echo'<pre>';print_r($_POST);die;
    $id = $this->input->post('id');
    $returnArr['status'] = '0';
    if ($id != '') {
        $get_file_names = $this->funder_model->get_all_details('grant_reports', array('id' => $id), array('file_name'));
        if (!empty($get_file_names)) {
            unlink('uploads/file_documents/' . $get_file_names[0]->file_name);
            $this->funder_model->update_data('grant_reports', array('id' => $id), array('file_name' => ''));
            $returnArr['status'] = '1';
        }
    }
    $this->setErrorMessage('Success', 'Grant document deleted successfully');
    echo json_encode($returnArr);
}

function ajax_log_datatable() {
    checkAuth();
    $data = array();
    $draw = $this->input->post('draw');
    $funder_id = $this->input->post('funder_id');
    $grant_id = $this->input->post('grant_id');
    $start = $this->input->post('start');
    $nestedData = $grant_list = array();
    $columnIndex = $_POST['order'][0]['column'];
    $columnSortOrder = $_POST['order'][0]['dir'];

    $columnArr = array('user_name', 'date', 'from_status', 'to_status', 'comments');
    $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
    $limit = 10;
    $fields = array();
    $cond = array('funder_id' => $funder_id, 'grant_id' => $grant_id);
    $getFunder_LogsCount = $this->funder_model->get_all_details('funder_logs', $cond);
    $getFunder_Logs = $this->funder_model->get_all_details('funder_logs', $cond, $fields, $limit, $start, $orderby);

    foreach ($getFunder_Logs as $values) {
        $user_name = $values->user_name;
        $date = date('d-m-Y', strtotime($values->date));
        $from_status = $values->from_status;
        $to_status = $values->to_status;
        $comments = $values->comments;
        $nestedData[] = array($user_name, $date, ucfirst($from_status), ucfirst($to_status), $comments);
    }

    $data = $nestedData;
    $json_data = array(
        "draw" => intval($draw),
        "recordsTotal" => intval(php72_count($getFunder_Logs)),
        "recordsFiltered" => intval(php72_count($getFunder_LogsCount)),
        "data" => $data,
        'POST' => $_POST
    );
    echo json_encode($json_data);
}

function ajax_load_datatable() {
    checkAuth();
    $data = array();
    $draw = $this->input->post('draw');
    $funder_id = $this->input->post('funder_id');
    $start = $this->input->post('start');
    $nestedData = $grant_list = array();
    $columnIndex = $_POST['order'][0]['column'];
    $columnSortOrder = $_POST['order'][0]['dir'];

    $columnArr = array('', 'name', 'start_date', 'end_date', 'grant_amount', 'disbursement_amount', 'projected_amount', 'amount_utilized', 'status_type');
    $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
    $orderby['created_date'] = 'desc';
    $limit = 10;
    $getGrantCount = $this->funder_model->get_all_details('grant_list', array('funder_id' => $funder_id), array());
    $fields = array('id', 'name', 'programme_id', 'grant_amount', 'start_date', 'signed_date', 'status_type', 'end_date', 'purpose', 'projected_amount', 'amount_utilized', 'disbursement_amount');
    $getGrantData = $this->funder_model->get_all_details('grant_list', array('funder_id' => $funder_id, 'partner_id' => $this->session->userdata('partner_id')), $fields, $limit, $start, $orderby);
    $data['grand_lists'] = $getGrantData;
    $data['total_amount_rec'] = $getGrantAmount = $this->funder_model->get_all_details('disbursement_schedule', array(), array('grant_id', 'SUM(amount_deposite) AS amount'), '', '', '', '', '', '', array('grant_id'), '');

    $get_DisbAmt = json_decode(json_encode($getGrantAmount), true);
    $get_GrantId = php72_array_column($get_DisbAmt, 'grant_id');
    $get_Amount = php72_array_column($get_DisbAmt, 'amount');
    $GetSumAmount = array_combine($get_GrantId, $get_Amount);

    $getInternalAmt = $this->funder_model->get_all_details('internal_note', array('donor' => $funder_id), array('SUM(amount_toapprove) as approval_amount'), '', '', '', true, 'ais');

    $approval_amount = '';
    if (isset($getInternalAmt[0]->approval_amount) && $getInternalAmt[0]->approval_amount != '') {
        $approval_amount = $this->numberToCurrency($getInternalAmt[0]->approval_amount);
    }
    $groupBy = 'grant_id';
    $get_aprovalGrant_amt = '';
    $getAndAmount = $this->funder_model->get_all_details('approval_note_donors', array('donor' => $funder_id, 'grant_id !=' => ''), array('amt_required', 'grant_id'), '', '', '', true, 'ais', '', $groupBy);
    $getAprovalGrant = json_decode(json_encode($getAndAmount), true);
    $get_aprovalGrant = php72_array_column($getAprovalGrant, 'grant_id');
    $get_aprovalAmt = php72_array_column($getAprovalGrant, 'amt_required');
    $get_aprovalGrant_amt = array_combine($get_aprovalGrant, $get_aprovalAmt);

        #echo'<pre>';print_r($getInternalAmt);die;
    foreach ($getGrantData as $values) {
        $chekStatus = "";
        if ($this->auth == '0') {
            $chekStatus = "disabled";
        }
        $checkBox = '<input type="checkbox" ' . $chekStatus . ' name="grant_id[]" class="form-control tbl_checkbox" value=' . $values->id . '>';
        $base_url = base_url();


        $projected_amount = $this->numberToCurrency($values->projected_amount);
        $amount_utilized = $this->numberToCurrency($values->amount_utilized);

        $start_date = date('d-m-Y', strtotime($values->start_date));
        $end_date = date('d-m-Y', strtotime($values->end_date));
        $grand_id = '<a href=' . $base_url . 'index.php/funder/edit_grant_form/' . $values->id . '>' . $values->name . '</a>';
        $totalAmt_rec = $this->numberToCurrency($values->disbursement_amount);
        $grantAmt = $this->numberToCurrency($values->grant_amount);
        $nestedData[] = array($checkBox, $grand_id, $start_date, $end_date, $grantAmt, $totalAmt_rec, $projected_amount, $amount_utilized, ucfirst($values->status_type));
    }
    $data = $nestedData;
        #echo'<pre>';print_r($getGrantData);die;
    $json_data = array(
        "draw" => intval($draw),
        "recordsTotal" => intval(php72_count($getGrantData)),
        "recordsFiltered" => intval(php72_count($getGrantCount)),
        "data" => $data,
        'POST' => $_POST
    );
    echo json_encode($json_data);
}

function deleted_grant_list() {
    checkAuth();
    $funder_id = $this->input->post('funder_id');
    $grant_id = $this->input->post('grant_id');
    if ($funder_id != '' && !empty($grant_id)) {
        $condition['grant_id'] = $grant_id;
        $this->funder_model->delete_data_in('grant_list', array('id' => $grant_id));
        $this->funder_model->delete_data_in('grant_line', $condition);
        $this->funder_model->delete_data_in('disbursement_schedule', $condition);
        $this->funder_model->delete_data_in('grant_reports', $condition);
        $this->funder_model->delete_data_in('funder_logs', $condition);
        $this->setErrorMessage('Success', 'Record(s) deleted successfully');
        redirect('funder/display_grant_list/' . $funder_id);
    } else {
        $this->setErrorMessage('error', 'Record not Deleted');
        redirect('funder/display_grant_list/' . $funder_id);
    }
}

    function delete_summay_list() { #echo'<pre>';print_r($_POST);die;
    checkAuth();
    $funder_id = php72_array_filter($this->input->post('funder_id'));
    $grant_id = php72_array_filter($this->input->post('grant_id'));
    if (!empty($grant_id)) {
        $conditionGrant = array('grant_id' => $grant_id);
        $this->funder_model->delete_data_in('grant_list', array('id' => $grant_id));
        $this->funder_model->delete_data_in('grant_line', $conditionGrant);
        $this->funder_model->delete_data_in('disbursement_schedule', $conditionGrant);
        $this->funder_model->delete_data_in('grant_reports', $conditionGrant);
    }
    if (!empty($funder_id)) {
        $condition['funder_id'] = $funder_id;
        $this->funder_model->delete_data_in('grant_list', $condition);
        $this->funder_model->delete_data_in('grant_line', $condition);
        $this->funder_model->delete_data_in('disbursement_schedule', $condition);
        $this->funder_model->delete_data_in('grant_reports', $condition);
        $this->funder_model->delete_data_in('funder_list', array('id' => $funder_id));
        $this->funder_model->delete_data_in('funder_contacts', $condition);
        $this->funder_model->delete_data_in('funder_documents', $condition);
        $this->funder_model->delete_data_in('funder_logs', $condition);

        $condition2['master_id'] = $funder_id;
        $this->funder_model->delete_data_in('master_settings', $condition2, true, 'ais');
    }

    $this->setErrorMessage('Success', 'Record(s) deleted successfully');
    redirect('funder/display_summary_list');
}

    function test_delete_summay_list() { #echo'<pre>';print_r($_POST);die;
    checkAuth();
    $funder_id = php72_array_filter($this->input->post('funder_id'));
    $grant_id = php72_array_filter($this->input->post('grant_id'));
    if (!empty($grant_id)) {
        $conditionGrant = array('grant_id' => $grant_id);
        $this->funder_model->delete_data_in('grant_list', array('id' => $grant_id));
        $this->funder_model->delete_data_in('grant_line', $conditionGrant);
        $this->funder_model->delete_data_in('disbursement_schedule', $conditionGrant);
        $this->funder_model->delete_data_in('grant_reports', $conditionGrant);
    }
    if (!empty($funder_id)) {
        $condition['funder_id'] = $funder_id;
        $this->funder_model->delete_data_in('grant_list', $condition);
        $this->funder_model->delete_data_in('grant_line', $condition);
        $this->funder_model->delete_data_in('disbursement_schedule', $condition);
        $this->funder_model->delete_data_in('grant_reports', $condition);
        $this->funder_model->delete_data_in('funder_list', array('id' => $funder_id));
        $this->funder_model->delete_data_in('funder_contacts', $condition);
        $this->funder_model->delete_data_in('funder_documents', $condition);
        $this->funder_model->delete_data_in('funder_logs', $condition);

        $condition2['master_id'] = $funder_id;
        $this->funder_model->delete_data_in('master_settings', $condition2, true, 'ais');
    }

    $this->setErrorMessage('Success', 'Record(s) deleted successfully');
    redirect('funder/test_display_summary_list');
}

function ajax_Grantname_duplicate() {
    $funder_id = $this->input->post('funder_id');
    $grant_name = $this->input->post('grant_name');
    $grant_id = $this->input->post('grant_id');

    $returnArr['status'] = '0';
    if ($funder_id != '' && $grant_name != '') {
        $condition = array('funder_id' => $funder_id, 'name' => $grant_name);
        if ($grant_id != '') {
            $condition['id !='] = $grant_id;
        }

        $getGrantName = $this->funder_model->get_all_details('grant_list', $condition, array('id'));

        if (!empty($getGrantName[0])) {
            $returnArr['status'] = '1';
        }
    }
    echo json_encode($returnArr);
}

function download_grant_pdf() {
    $grant_id = $this->uri->segment(3);
    $funder_id = $this->uri->segment(4);
    if ($grant_id != '' && $funder_id != '') {

        $join [0] ['select'] = "fl.name as funder_name";
        $join [0] ['table'] = 'funder_list as fl';
        $join [0] ['condition'] = "fl.id = gl.funder_id";
        $join [0] ['type'] = "LEFT";

        $conditionGrant = array('grant_id' => $grant_id);
        $grantFields = array('gl.name', 'gl.signed_date', 'gl.funder_id', 'gl.start_date', 'gl.grant_amount', 'gl.end_date', 'gl.status_type', 'gl.purpose');
        $data['grant_list'] = $getGrantData = $this->funder_model->get_all_details('grant_list as gl', array('gl.id' => $grant_id), $grantFields, '', '', '', '', '', $join, '');

        $budgetList = $this->funder_model->getMasterSetting('Budget Head', NULL, $funder_id, '', true, 'ais');
        $BudgetArr = array();
        if (!empty($budgetList)) {
            foreach ($budgetList as $list) {
                $BudgetArr[$list['master_id']] = $list['master_name'];
            }
        }
        $data['budget_list'] = $BudgetArr;

        $getLineItem = $this->funder_model->get_all_details('master_settings', array('master_type' => 'Line Item'), array('master_id', 'master_name'), '', '', '', true, 'ais');

        $LineItemArr = array();
        if (!empty($getLineItem)) {
            foreach ($getLineItem as $list) {
                $LineItemArr[$list->master_id] = $list->master_name;
            }
        }
        $data['line_iten_list'] = $LineItemArr;
        $data['grant_line'] = $getGrantLineData = $this->funder_model->get_all_details('grant_line', $conditionGrant, array('budget_head_id', 'lineitem_id', 'amount', 'comments'));
        $data['disb_schedule'] = $getDisbSchedule = $this->funder_model->get_all_details('disbursement_schedule', $conditionGrant, array('milestone', 'date_of_disbursement	', 'amount', 'date_of_deposite', 'amount_deposite', 'comments'));
        $data['grant_reports'] = $getGrantReport = $this->funder_model->get_all_details('grant_reports', $conditionGrant, array('date_of_report', 'submit_date	', 'responsibility', 'comments', 'file_name'));


        $condition_response = array('partner_id' => array($this->session->userdata('partner_id')), 'emp_type' => array('2', '3'));
        $getEmployeeList = $this->funder_model->get_all_details_win('hr_user_profile', $condition_response, array('id', 'emp_first_name'));

        $EmpoyeeList = array();
        foreach ($getEmployeeList as $listsUser) {
            $EmpoyeeList[$listsUser->id] = $listsUser->emp_first_name;
        }
        $data['responsibility'] = $EmpoyeeList;

        $this->load->view('funder/grant_pdf', $data);
        $pdfName = 'Grant_Details' . '' . time();
        $html = $this->output->get_output();
            #echo'<pre>';print_r($html);die;
        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->set_option('isRemoteEnabled', TRUE);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream($pdfName, array("Attachment" => 1));
    }
}

function print_grant_pdf() {
    $grant_id = $this->input->post('grant_id');
    $funder_id = $this->input->post('funder_id');
        #echo'<pre>';print($grant_id);die;
    if ($grant_id != '' && $funder_id != '') {
        $join [0] ['select'] = "fl.name as funder_name";
        $join [0] ['table'] = 'funder_list as fl';
        $join [0] ['condition'] = "fl.id = gl.funder_id";
        $join [0] ['type'] = "LEFT";

        $conditionGrant = array('grant_id' => $grant_id);
        $grantFields = array('gl.name', 'gl.signed_date', 'gl.funder_id', 'gl.start_date', 'gl.grant_amount', 'gl.end_date', 'gl.status_type', 'gl.purpose');
        $data['grant_list'] = $getGrantData = $this->funder_model->get_all_details('grant_list as gl', array('gl.id' => $grant_id), $grantFields, '', '', '', '', '', $join, '');

        $budgetList = $this->funder_model->getMasterSetting('Budget Head', NULL, $funder_id, '', true, 'ais');
        $BudgetArr = array();
        if (!empty($budgetList)) {
            foreach ($budgetList as $list) {
                $BudgetArr[$list['master_id']] = $list['master_name'];
            }
        }
        $data['budget_list'] = $BudgetArr;

        $getLineItem = $this->funder_model->get_all_details('master_settings', array('master_type' => 'Line Item'), array('master_id', 'master_name'), '', '', '', true, 'ais');

        $LineItemArr = array();
        if (!empty($getLineItem)) {
            foreach ($getLineItem as $list) {
                $LineItemArr[$list->master_id] = $list->master_name;
            }
        }
        $data['line_iten_list'] = $LineItemArr;
        $data['grant_line'] = $getGrantLineData = $this->funder_model->get_all_details('grant_line', $conditionGrant, array('budget_head_id', 'lineitem_id', 'amount', 'comments'));
        $data['disb_schedule'] = $getDisbSchedule = $this->funder_model->get_all_details('disbursement_schedule', $conditionGrant, array('milestone', 'date_of_disbursement	', 'amount', 'date_of_deposite', 'amount_deposite', 'comments'));
        $data['grant_reports'] = $getGrantReport = $this->funder_model->get_all_details('grant_reports', $conditionGrant, array('date_of_report', 'submit_date	', 'responsibility', 'comments', 'file_name'));


        $condition_response = array('partner_id' => array($this->session->userdata('partner_id')), 'emp_type' => array('2', '3'));
        $getEmployeeList = $this->funder_model->get_all_details_win('hr_user_profile', $condition_response, array('id', 'emp_first_name'));


        $EmpoyeeList = array();
        foreach ($getEmployeeList as $listsUser) {
            $EmpoyeeList[$listsUser->id] = $listsUser->emp_first_name;
        }
        $data['responsibility'] = $EmpoyeeList;
        return $this->load->view('funder/grant_pdf', $data);
        echo htmlentities($html);
        exit;
    }
}

    public function test_display_summary_list() { #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
    $type = $this->input->post('type');
    $funder_id = $this->input->post('funder_name');
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_type = $this->input->post('status_type');
    $search_val = $this->input->post('search_val');
    $export_status = $this->input->post('export_status');

    $export = $this->input->get('export');
    $join [0] ['select'] = "gl.disbursement_amount as gl_deposite_amt,gl.projected_amount as gl_projected_amount,gl.amount_utilized as gl_amount_utilized,gl.id as gl_id,gl.name as gl_name, gl.grant_amount as gl_amount, gl.status_type as gl_status,gl.start_date as gl_start_date,gl.end_date as gl_end_date";
    $join [0] ['table'] = 'grant_list as gl';
    $join [0] ['condition'] = "gl.funder_id = funder_list.id";
    $join [0] ['type'] = "LEFT";

        //Filter
    $condition = array();
    $data['search_type'] = '';
    $data['type'] = '';
    if (isset($type) && $type != '') {
        $data['type'] = $type;
    }
    if ($type == 'funder') {
            //$condition['funder_list.name'] = $search_val;
        $condition = "funder_list.name LIKE '%$search_val%'";
        $data['search_val'] = $search_val;
    } else if ($type == 'start_date') {
        $join [0] ['type'] = "INNER";
        $filter_start_date = $start_date;
            #$join [0] ['condition'] = "gl.funder_id = funder_list.id AND gl.start_date > '$filter_start_date'";
            //(gr.date_of_report BETWEEN CURDATE() + INTERVAL 14 DAY AND CURDATE() + INTERVAL 14 DAY)
        $join [0] ['condition'] = "gl.funder_id = funder_list.id AND gl.start_date > $filter_start_date";

        $data['start_date'] = $start_date;
    } else if ($type == 'grant_status') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.status_type='$search_val'";
        $data['search_val'] = $search_val;
    } else if ($type == 'end_date' && $end_date != '') {
        $join [0] ['type'] = "INNER";
        $filter_end_date = $end_date;
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.end_date < '$filter_end_date'";
        $data['end_date'] = $end_date;
    } else if ($type == 'grant_name' && $search_val != '') {
        $join [0] ['type'] = "INNER";
            #$join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.name = '$search_val'";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.name LIKE '%$search_val%'";
        $data['search_val'] = $search_val;
    } else if ($type == 'grant_amount' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.grant_amount = '$search_val'";
        $data['search_val'] = $search_val;
    } else if ($type == 'amount_received' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.disbursement_amount = '$search_val'";
        $data['search_val'] = $search_val;
    } else if ($type == 'total_utilized' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.amount_utilized = '$search_val'";
        $data['search_val'] = $search_val;
    } else if ($type == 'project_amount' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.projected_amount = '$search_val'";
        $data['search_val'] = $search_val;
    }

    if ($type == 'start_date') {
        $join [0] ['type'] = "INNER";
        $sdate = date('Y-m-d', strtotime($filter_start_date));
        $join [0] ['condition'] = "gl.funder_id = funder_list.id AND gl.start_date > '$sdate'";
        $data['start_date'] = $start_date;
    }
    if ($type == 'end_date' && $end_date != '') {
        $join [0] ['type'] = "INNER";
        $edate = date('Y-m-d', strtotime($filter_end_date));
        $join [0] ['condition'] = "gl.funder_id = funder_list.id AND gl.end_date < '$edate'";
        $data['end_date'] = $end_date;
    }

    $groupBy = '';
    $data['total_amount_rec'] = $getGrantAmount = $this->funder_model->get_all_details('disbursement_schedule', array(), array('grant_id', 'SUM(amount_deposite) AS amount'), '', '', '', '', '', '', array('grant_id'), '');
    $order_by = array("gl.status_type" => "desc");
    $fields = array('funder_list.id', 'funder_list.name', 'funder_list.fcra_status', 'funder_list.type');
    $getFunderData = $this->funder_model->get_all_details('funder_list', $condition, $fields, '', '', $order_by, '', '', $join, $groupBy);

    $get_DisbAmt = json_decode(json_encode($getGrantAmount), true);
    $get_GrantId = php72_array_column($get_DisbAmt, 'grant_id');
    $get_Amount = php72_array_column($get_DisbAmt, 'amount');
    $GetSumAmount = array_combine($get_GrantId, $get_Amount);
    $data['totalAmount'] = array();
    if (!empty($GetSumAmount)) {
        $data['totalAmount'] = $GetSumAmount;
    }
    if (!empty($getFunderData)) {
        $funder_details = array();
        foreach ($getFunderData as $values) {
            $funder_details[$values->id][] = array('id' => $values->id, 'name' => $values->name, 'fcra_status' => $values->fcra_status,
                'type' => $values->type, 'gl_id' => $values->gl_id, 'gl_name' => $values->gl_name, 'gl_amount' => $values->gl_amount,
                'gl_amount_utilized' => $values->gl_amount_utilized, 'gl_projected_amount' => $values->gl_projected_amount, 'gl_status' => ucfirst($values->gl_status), 'gl_deposite_amt' => $values->gl_deposite_amt, 'gl_start_date' => date('d-m-Y', strtotime($values->gl_start_date)), 'gl_end_date' => date('d-m-Y', strtotime($values->gl_end_date)),
            );
        }
    }

        #error_reporting(-1);
    $funderLimtArr = array_slice(array_values($funder_details), 0, 8);
    $i = 1;
    $COUNTS = '';
    $resdfs = '';
    $mainlist = array();
    foreach ($funderLimtArr as $result) {
        $COUNTS += php72_count($result);
        foreach ($result as $res) {
            $resdfs += $i;
            $mainlist[] = $res;
            $i++;
        }
    }
    $totalId = array();
    foreach ($mainlist as $test) {
        if ($test['gl_id'] != '') {
            $totalId[] = $test['id'];
        }
    }
    $COUNTS = $COUNTS + count(array_unique($totalId));
    $data['pagination_counts'] = $COUNTS;


    $getFunderLists = $this->funder_model->get_all_details('funder_list', array(), array('id', 'name'));
    $data['funder_lists'] = $funder_details;
    $data['funder_data'] = $getFunderLists;

    $groupBy_in = array('donor');
    $getInternalAmt = $this->funder_model->get_all_details('internal_note', array(), array('SUM(amount_toapprove) as approval_amount', 'donor'), '', '', '', true, 'ais', '', $groupBy_in);
    $getInternaAmt_arr = json_decode(json_encode($getInternalAmt), true);
    $approval_amount = php72_array_column($getInternaAmt_arr, 'approval_amount');
    $donor_ids = php72_array_column($getInternaAmt_arr, 'donor');
    $GetDonorApp_amt = array_combine($donor_ids, $approval_amount);
    $data['total_utilized'] = $GetDonorApp_amt;
        #echo'<pre>';print_r($funder_details);die;
        #echo'<pre>';print_r($getFunderData);
    if ($export_status == '1') {
        $exportArr = array();
        $headerArray = array('Funder', 'Grant Id', 'Start Date', 'End Date', 'Grant Amount (' . $this->session->userdata['currency'] . ')', 'Amount Received (' . $this->session->userdata['currency'] . ')', 'Project Utilized (' . $this->session->userdata['currency'] . ')', 'Total Utilised (' . $this->session->userdata['currency'] . ')', 'Grant Status');
        foreach ($getFunderData as $list) {
            $this->load->helper('excel_helper');
            $gl_start_date = '';
            if ($list->gl_start_date != '')
                $gl_start_date = date('d-m-Y', strtotime($list->gl_start_date));
            $gl_end_date = '';
            if ($list->gl_end_date != '')
                $gl_end_date = date('d-m-Y', strtotime($list->gl_end_date));
            $exportArr[] = array($list->name, $list->gl_name, $gl_start_date, $gl_end_date, $this->numberToCurrency($list->gl_amount), $this->numberToCurrency($GetSumAmount[$list->gl_id]), $this->numberToCurrency($list->gl_projected_amount), $this->numberToCurrency($list->gl_amount_utilized), ucfirst($list->gl_status));
        }
            #echo'<pre>';print_r($getFunderData);
            #echo'<pre>';print_r($exportArr);die;
        dataarray_to_excel($headerArray, $exportArr);
        exit;
    }else {
        $this->load->view('funder/test_display_summary_list', $data);
    }
}

    public function numberToCurrencyY($num) { #echo $num;die;
        $RES = explode('.', $num);
        $num = $RES[0];
        $digit = '';
        if (php72_cmp($RES[1]) > 0) {
            $digit = '.' . $RES[1];
        }

        if (setlocale(LC_MONETARY, 'en_IN'))
            return money_format('%.0n', $num);
        else {
            $explrestunits = "";
            if (strlen($num) > 3) {
                $lastthree = substr($num, strlen($num) - 3, strlen($num));
                $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
                $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);
                for ($i = 0; $i < sizeof($expunit); $i++) {
                    // creates each of the 2's group and adds a comma to the end
                    if ($i == 0) {
                        $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
                    } else {
                        $explrestunits .= $expunit[$i] . ",";
                    }
                }
                $thecash = $explrestunits . $lastthree . $digit;
            } else {
                $thecash = $num . $digit;
            }
            #echo '<br>'; echo $thecash;
            return '' . $thecash;
        }
    }

    public function ajax_display_summary_list() { #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
    $type = $this->input->post('type');
    $funder_id = $this->input->post('funder_name');
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_type = $this->input->post('status_type');
    $search_val = $this->input->post('search_val');
    $export_status = $this->input->post('export_status');

    $export = $this->input->get('export');
    $join [0] ['select'] = "gl.disbursement_amount as gl_deposite_amt,gl.projected_amount as gl_projected_amount,gl.amount_utilized as gl_amount_utilized,gl.id as gl_id,gl.name as gl_name, gl.grant_amount as gl_amount, gl.status_type as gl_status,gl.start_date as gl_start_date,gl.end_date as gl_end_date";
    $join [0] ['table'] = 'grant_list as gl';
    $join [0] ['condition'] = "gl.funder_id = funder_list.id";
    $join [0] ['type'] = "LEFT";

        //Filter
    $condition = array();
    $data['search_type'] = '';
    $data['type'] = '';
    if (isset($type) && $type != '') {
        $data['type'] = $type;
    }
    if ($type == 'funder' && $funder_id != '') {
        $condition['funder_list.id'] = $funder_id;
        $data['funder_id'] = $funder_id;
    } else if ($type == 'start_date') {
        $join [0] ['type'] = "INNER";
        $filter_start_date = $start_date;
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.start_date > '$filter_start_date'";
        $data['start_date'] = $start_date;
    } else if ($type == 'grant_status' && $status_type != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.status_type='$status_type'";
        $data['grant_status'] = $status_type;
    } else if ($type == 'end_date' && $end_date != '') {
        $join [0] ['type'] = "INNER";
        $filter_end_date = $end_date;
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.end_date < '$filter_end_date'";
        $data['end_date'] = $end_date;
    } else if ($type == 'grant_name' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.name = '$search_val'";
        $data['search_val'] = $search_val;
    } else if ($type == 'grant_amount' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.grant_amount = '$search_val'";
        $data['search_val'] = $search_val;
    } else if ($type == 'amount_received' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.disbursement_amount = '$search_val'";
        $data['search_val'] = $search_val;
    } else if ($type == 'total_utilized' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.amount_utilized = '$search_val'";
        $data['search_val'] = $search_val;
    } else if ($type == 'project_amount' && $search_val != '') {
        $join [0] ['type'] = "INNER";
        $join [0] ['condition'] = "gl.funder_id = funder_list.id and gl.projected_amount = '$search_val'";
        $data['search_val'] = $search_val;
    }

        #echo'<pre>';print_r($join);die;
    $groupBy = '';
    $data['total_amount_rec'] = $getGrantAmount = $this->funder_model->get_all_details('disbursement_schedule', array(), array('grant_id', 'SUM(amount_deposite) AS amount'), '', '', '', '', '', '', array('grant_id'), '');
    $order_by = array("funder_list.created_date" => "desc");
    $fields = array('funder_list.id', 'funder_list.name', 'funder_list.fcra_status', 'funder_list.type');
    $getFunderData = $this->funder_model->get_all_details('funder_list', $condition, $fields, '', '', $order_by, '', '', $join, $groupBy);

    $get_DisbAmt = json_decode(json_encode($getGrantAmount), true);
    $get_GrantId = php72_array_column($get_DisbAmt, 'grant_id');
    $get_Amount = php72_array_column($get_DisbAmt, 'amount');
    $GetSumAmount = array_combine($get_GrantId, $get_Amount);
    $data['totalAmount'] = array();
    if (!empty($GetSumAmount)) {
        $data['totalAmount'] = $GetSumAmount;
    }
    if (!empty($getFunderData)) {
        $funder_details = array();
        foreach ($getFunderData as $values) {
            $funder_details[$values->id][] = array('id' => $values->id, 'name' => $values->name, 'fcra_status' => $values->fcra_status,
                'type' => $values->type, 'gl_id' => $values->gl_id, 'gl_name' => $values->gl_name, 'gl_amount' => $values->gl_amount,
                'gl_amount_utilized' => $values->gl_amount_utilized, 'gl_projected_amount' => $values->gl_projected_amount, 'gl_status' => ucfirst($values->gl_status), 'gl_deposite_amt' => $values->gl_deposite_amt, 'gl_start_date' => date('d-m-Y', strtotime($values->gl_start_date)), 'gl_end_date' => date('d-m-Y', strtotime($values->gl_end_date)),
            );
        }
    }
        #echo'<pre>';print_r($getFunderData);
    $getFunderLists = $this->funder_model->get_all_details('funder_list', array(), array('id', 'name'));
    $data['funder_lists'] = $funder_details;
    $data['funder_data'] = $getFunderLists;

    $groupBy_in = array('donor');
    $getInternalAmt = $this->funder_model->get_all_details('internal_note', array(), array('SUM(amount_toapprove) as approval_amount', 'donor'), '', '', '', true, 'ais', '', $groupBy_in);
    $getInternaAmt_arr = json_decode(json_encode($getInternalAmt), true);
    $approval_amount = php72_array_column($getInternaAmt_arr, 'approval_amount');
    $donor_ids = php72_array_column($getInternaAmt_arr, 'donor');
    $GetDonorApp_amt = array_combine($donor_ids, $approval_amount);
    $data['total_utilized'] = $GetDonorApp_amt;

    $res = array_slice($funder_details, 0, 10);
    $count_sum = '';
    foreach ($res as $keys => $val) {
        $count_sum += php72_count($val);
    }
    $data['pagination_limit'] = $count_sum - 2;

    $i = 0;
    $j = 0;
    if (!empty($funder_lists)) {
        foreach ($funder_lists as $list) {
            $nestedData[] = array('', '', 'SAP INDIA', '234', '234', '234', '243', '234', '234', '34', '43');
        }
    }
    $nestedData[] = array('', '<a class="tlf_row1" href="javascript:"><i class="fas fa-caret-down"></i></a>', '423', '234', '234', '234', '243', '234', '234', '34', '43');
    $data = array();
    $draw = $this->input->post('draw');

    $data = $nestedData;
        #echo'<pre>';print_r($getGrantData);die;
    $json_data = array(
        "draw" => intval($draw),
        "recordsTotal" => 2,
        "recordsFiltered" => 5,
        "data" => $data,
        'POST' => $_POST
    );
    echo json_encode($json_data);
    exit;



        #echo'<pre>';print_r($getFunderData);die;
    if ($export_status == '1') {
        $exportArr = array();
        $headerArray = array('Funder', 'Grant Id', 'Start Date', 'End Date', 'Grant Amount (' . $this->session->userdata['currency'] . ')', 'Amount Received (' . $this->session->userdata['currency'] . ')', 'Project Utilized (' . $this->session->userdata['currency'] . ')', 'Total Utilised (' . $this->session->userdata['currency'] . ')', 'Grant Status');
        foreach ($getFunderData as $list) {
            $this->load->helper('excel_helper');
            $exportArr[] = array($list->name, $list->gl_id, date('d-m-Y', strtotime($list->name)), date('d-m-Y', strtotime($list->gl_end_date)), $list->gl_amount, $GetSumAmount[$list->gl_id], $list->gl_projected_amount, $list->gl_amount_utilized, ucfirst($list->gl_status));
        }
        dataarray_to_excel($headerArray, $exportArr);
        exit;
    } else {
            #echo'<pre>';print_r($data);die;
        $this->load->view('funder/test_display_summary_list', $data);
    }
}

public function send_reporting_mail() {
    $mail_config = partner_smtp();
    $config = array(
        'protocol' => $mail_config['protocol'],
        'smtp_host' => $mail_config['smtp_host'],
        'smtp_port' => $mail_config['smtp_port'],
        'smtp_user' => $mail_config['smtp_user'],
        'smtp_pass' => $mail_config['smtp_pass'],
        'newline' => '\r\n',
    );
    $this->load->library('email', $config);
    $this->email->clear(true);
    $this->email->set_newline("\r\n");
    $this->email->from($mail_config['smtp_user'], $mail_config['smtp_subject']);
    $mail_subject = ucfirst($mail_type) . "Grant Due Date Request";

    $join[0]['select'] = "gr.date_of_report,gl.status_type,gr.responsibility,gr.grant_id,gr.submit_date,gr.comments";
    $join[0]['table'] = 'grant_reports as gr';
    $join[0]['condition'] = "gr.grant_id = gl.id AND gr.responsibility !='' AND (gr.date_of_report BETWEEN CURDATE() + INTERVAL 14 DAY AND CURDATE() + INTERVAL 14 DAY)";
    $join[0]['type'] = "INNER";

    $join[1]['select'] = "emp.official_email,emp.emp_first_name,emp.emp_last_name";
    $join[1]['table'] = 'hr_user_profile as emp';
    $join[1]['condition'] = "gr.responsibility = emp.id";
    $join[1]['type'] = "INNER";

    $fields = array('gl.status_type');
    $getGrant_reports = $this->funder_model->get_all_details('grant_list as gl', array('status_type' => 'open'), $fields, '', '', '', '', '', $join, '');
        #echo'<pre>';print_r($getGrant_reports);
    foreach ($getGrant_reports as $value) {
        if (isset($value->official_email) && $value->official_email != '') {
            $submit_date = date('d-m-Y', strtotime($value->submit_date));
            $date_of_report = date('d-m-Y', strtotime($value->date_of_report));
            $comments = $value->comments;
            $mail_message = "<p>Hi " . $value->emp_first_name . ' ' . $value->emp_last_name . ",</p><p>Following request has been raised due to intimation of grant due date expired soon,<a target='_blank' href='" . base_url() . "index.php/funder/edit_grant_form/" . $value->grant_id . "'>click here</a> to see due date <br/></p><p>Due Date: " . $date_of_report . "<br/>Submitted Date: " . $submit_date . "<br/>Comments: " . $comments . "<br/></p>
            <p>Thanks,<br/>Villgro</p>";
            $this->email->to($value->official_email);
            $this->email->subject($mail_subject);
            $this->email->message($mail_message);
            if ($this->email->send()) {
                echo "mail sent successfully";
            } else {
                echo $this->email->print_debugger();
            }
        }
    }
}

public function test_display_grant_list() {
        #error_reporting(-1);
    checkAuth();
    $funder_id = $this->uri->segment(3);

    if ($funder_id != '') {
        $condition = array('funder_id' => $funder_id);
        $grant_list = array();
        $getFunderName = $this->funder_model->get_all_details('funder_list', array('id' => $funder_id), array('id', 'name'));
        $data['funder_name'] = $getFunderName[0]->name;
        $data['funder_id'] = $funder_id;
    } else {
        $this->setErrorMessage('error', 'Record(s) not found');
        redirect('funder/edit_funder_form');
    }
    $this->load->view('funder/test_display_grant_list', $data);
}

function test() {
    checkAuth();
    $grant_id = $this->uri->segment(3);
    if (isset($grant_id) && $grant_id != '') {
        $getGrantData = $this->funder_model->get_all_details('grant_list', array('id' => $grant_id), array('id', 'name', 'status', 'programme_id', 'funder_id', 'grant_id', 'grant_amount', 'start_date', 'end_date', 'purpose', 'signed_date', 'status_type'));
        $data['grand_lists'] = $getGrantData[0];
        $data['funder_name'] = $data['funder_id'] = '';
        if (isset($getGrantData[0]->funder_id) && $getGrantData[0]->funder_id != '') {
            $getfunderName = $this->funder_model->get_all_details('funder_list', array('id' => $getGrantData[0]->funder_id), array('id', 'name'));
            $data['funder_name'] = $getfunderName[0]->name;
        }
        $data['funder_id'] = $getGrantData[0]->funder_id;


        $condition = array('partner_id' => $this->session->userdata('partner_id'));
        $orderby = array("programme" => "asc");
        $getProgrammeList = $this->funder_model->get_all_details('master_programme', $condition, array(), '', '', $orderby, true, 'ais');
        $data['programe_list'] = $getProgrammeList;
        $getDisbursementData = $this->funder_model->get_all_details('disbursement_schedule', array('grant_id' => $grant_id), array('id', 'status', 'programme_id', 'funder_id', 'milestone', 'grant_id', 'amount', 'date_of_disbursement', 'date_of_deposite', 'amount_deposite', 'comments'));
        $data['disbursement_list'] = $getDisbursementData;
        $getGrantReport = $this->funder_model->get_all_details('grant_reports', array('grant_id' => $grant_id), array('id', 'submit_date', 'status', 'programme_id', 'funder_id', 'date_of_report', 'responsibility', 'comments', 'file_name'));
        $data['grant_report_list'] = $getGrantReport;

        $getGrant_line = $this->funder_model->get_all_details('grant_line', array('grant_id' => $grant_id), array('id', 'status', 'programme_id', 'funder_id', 'budget_head_id', 'lineitem_id', 'subline_id', 'amount', 'comments'));
        $data['grantline_list'] = $getGrant_line;
        $donor_id = $getGrantData[0]->funder_id;
        $budgetList = $this->funder_model->getMasterSetting('Budget Head', NULL, $donor_id, '', true, 'ais');
        $data['budgetList'] = $budgetList;

        $order_by = array("emp_first_name" => "asc");
        $condition_response = array('partner_id' => array($this->session->userdata('partner_id')), 'emp_type' => array('2', '3'));
        $getEmployeeList = $this->funder_model->get_all_details_win('hr_user_profile', $condition_response, array('id', 'emp_first_name', 'emp_last_name'), '', '', $order_by);

            #echo'<pre>';print_r($getGrantData);die;
        $data['responsibility'] = $getEmployeeList;
    } else {
        $this->setErrorMessage('error', 'Record not found');
        redirect('funder/edit_funder_form');
    }
    $this->load->view('funder/test_edit_grant_form', $data);
}

    function get_donor_details() { #error_reporting(-1);
        $getInternalAmt = $this->funder_model->get_all_details('master_settings', array('master_type' => 'Donor'), array('master_id', 'master_type', 'master_name'), '', '', '', true, 'ais');
        foreach ($getInternalAmt as $lists) {

            if ($lists->master_id != '') {

                $funder_data = array(
                    'id' => $lists->master_id, 'name' => $lists->master_name, 'city' => '', 'country' => '', 'type' => 'foundation',
                    'pan' => '', 'grant_service' => 'grant', 'address' => '', 'status' => 1,
                    'fcra_status' => 'non_fcra', 'created_date' => date('Y-m-d H:i:s'), 'created_by' => '', 'updated_date' => '',
                    'updated_by' => '', 'partner_id' => $this->session->userdata('partner_id')
                );
                //echo'<pre>';print_r($funder_data);
                #$this->funder_model->insert_data('funder_list', $funder_data);
            }
        }

        #echo'<pre>';print_r($getInternalAmt);die;
    }
	
	function debit_bank_list() {
		$this->load->view('debit_bank_list');
	}
	
	function addEdit_bank() {

		$getBankId = $this->uri->segment(3); 
		$data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
		$data['vendorId'] = $getBankId;
		$data['vendorDetails'] = array();
		if($getBankId!=''){
			$condition['id'] = $getBankId;
			$getVnedor = $this->funder_model->get_all_details('debit_bank_details', $condition,'', '', '', '');
			if(!empty($getVnedor)){
				$data['vendorDetails'] = $getVnedor[0];
			}
		}
		$this->load->vars($data);
		$this->load->view('debit_bank_details');
	}

	public function insertEditBank() {
		
		$bank_id = $this->input->post('bank_id');
		$insertEditData['donor_type'] = $this->input->post('donor_type');
		$insertEditData['account_number'] = trim($this->input->post('account_number'));
		$insertEditData['bank_name'] = $this->input->post('bank_name');
		$insertEditData['branch_name'] = $this->input->post('branch_name');
		$insertEditData['ifsc_code'] = $this->input->post('ifsc_code');
		$insertEditData['status'] = $this->input->post('status');
		$insertEditData['partner_id'] = 1;
		$insertEditData['status'] = 1;
      
		if(isset($bank_id) && $bank_id!=''){
			#update
			$insertEditData['updated_date'] = date('Y-m-d H:i:s');
			$condition = array('id'=>$bank_id);
			$this->funder_model->update_data('debit_bank_details', $condition, $insertEditData);
		
		}else{
			#insert 
			$insertEditData['created_date'] = date('Y-m-d H:i:s');
			$this->funder_model->insert_data('debit_bank_details', $insertEditData);
			$getLastInsertId = $this->db->insert_id();
		}
        
		$this->session->set_flashdata('successMsg', "Bank details saved successfully");
        redirect('funder/debit_bank_list');
    }

	public function deleteBank() {
        $id = $this->input->post('id');
        $condition = "'" . php72_implode("', '", $id) . "'";
        $table = $_POST['table'];
        $query = $this->funder_model->deleteBankDetail($table, $condition);

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
        } else {
            echo '0';
        }
    }
	
	
	public function DT_bank() {
		
		$user_id = $this->session->userdata('emp_number');
		$role_id = $this->session->userdata('role_id');
		$partner_id = $this->session->userdata('partner_id');
		$conditionFinance = array('partner_id'=>$partner_id);
		$data['user_status'] ='';
		$cond ='';
		
        $requestData = $_POST;
		$columns = array(
				0 => 'id',
				1 => 'account_number',
				2 => 'bank_name',
				3 => 'branch_name',
				4 => 'ifsc_code',
				5 => 'donor_type',
			);
        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
        $data['current_user'] = $current_user = (isset($_POST['current_user'])) ? $_POST['current_user'] : '';
		
		$totalrows = $this->funder_model->getDTBankCount($search_field, $search_value, $current_user, $columns, $requestData,$cond);
		$query = $this->funder_model->getDTBankDetails($requestData['length'], $requestData['start'], $search_field, $search_value, $current_user, $columns, $requestData,$cond);
		#echo'<pre>';print_r($query);die;
		$totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = $report_to = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="employee_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['account_number'];
            $nestedData[] =  $row['bank_name'];
			$nestedData[] =  $row['branch_name'];
			$nestedData[] =  $row['ifsc_code'];
			$nestedData[] =  $row['donor_type'];
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
	
	public function checkAccountNumerExist() {
		$accountNumer = trim($this->input->post('accountNumer'));
		$bankId = $this->input->post('bankId');
		
		if($bankId!=''){
			$getBankDetails = $this->funder_model->get_all_details('debit_bank_details', array('account_number'=>$accountNumer,'id !='=>$bankId), array(''), '', '', '');
		}else{
			$getBankDetails = $this->funder_model->get_all_details('debit_bank_details', array('account_number'=>$accountNumer), array(''), '', '', '');
		}
		$returnArr['status'] = '0';
		if(!empty($getBankDetails)){
			$returnArr['status'] = '1';
		}
		echo json_encode($returnArr);
	}
	

}
