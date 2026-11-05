<?php

class Asset extends CI_Controller {

    function __construct() {

        #error_reporting(-1);
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        /*  $this->Mauth->isAdminCheck();
          $this->Mauth->loginUser(); */

//        $this->load->model('asset/Mapproval');
        $this->load->model('asset/Common_model');
        $this->load->model('asset/Mmaster');
        $this->load->model('asset/Mcommon');
        $this->load->model('asset/Masset');
        $this->load->model('asset/Mlogin');
    }

    public function requestlist() {
        $this->load->view('asset/requestlist', $data);
    }

    public function listpayment() {

        $data['vendorList'] = $this->Mmaster->getVendorsList();
        $data['active_menu'] = 'listpayment';
        $orderby = array('vendor_name' => 'asc');
        $data['getVendorsList'] = $this->Common_model->get_all_details('master_vendor', array('status' => '1'), array(), '', '', $orderby, true, 'ais');
        $data['userList'] = $this->Mlogin->getAllUserList();

        $this->load->view('asset/listpayment', $data);
    }

    public function DTrequestlist() {

        #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);

        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $action = $this->input->post('action');

        $return_date_from = $this->input->post('return_date_from');
        $return_date_to = $this->input->post('return_date_to');

        $columnArr = array('master_asset.asset_no', 'master_asset.asset_name', '', 'asset_transaction.issue_date', 'asset_transaction.return_date', 'asset_transaction.ceiling_amount');

        $asset_no = $this->input->post('asset_no');
        if ($asset_no != '') {
            $searchArray[] = "asset_no ='" . $this->input->post('asset_no') . "'";
        }
        if ($action != '') {
            $searchArray[] = "transfer_status = '" . $action . "'";
        }

        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and issue_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "issue_date = '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }
        if ($action == 'returned') {
            if ($this->input->post('return_date_from') != "" && $this->input->post('return_date_to') != "") {
                $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($return_date_from)) . "' and return_date <= '" . date('Y-m-d', strtotime($return_date_to)) . "'";
            } else if ($this->input->post('return_date_from') != "") {
                $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($return_date_from)) . "'";
            } else if ($this->input->post('return_date_to') != "") {
                $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($return_date_to)) . "'";
            }
        }
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        #echo'<pre>';print_r($_POST);die;
        $where = php72_implode(" and ", $searchArray);
        #echo $where;die;
        $assetListCount = $this->Masset->getLimitAssetTransfer($where, '', '', $sort_column, $columnSortOrder);
        $getAll_count = php72_count($assetListCount);

        $assetList = $this->Masset->getLimitAssetTransfer($where, $limit, $start, $sort_column, $columnSortOrder);
        $getLimit_count = php72_count($assetList);
        #echo'<pre>';print_r($assetList);die;
        foreach ($assetList as $lists) {
            $emp_name = '';
            if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }
            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $lists['asset_name'];
            $nestedData[] = $emp_name;
            $nestedData[] = $lists['issue_date'];
            $nestedData[] = $lists['ceiling_amount'];
            $nestedData[] = $lists['transfer_status'];
            $data[] = $nestedData;
            $i++;
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

    public function DTlistpayment() {

        #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $asset_no = $this->input->post('asset_no');
        $vendor = $this->input->post('vendor');
        $employee_id = $this->input->post('employee_id');


        if ($asset_no != '') {
            $searchArray[] = "asset_no ='" . $this->input->post('asset_no') . "'";
        }
        if ($vendor != '') {
            $searchArray[] = "master_vendor.vendor_id ='" . $this->input->post('vendor') . "'";
        }
        if ($employee_id != '') {
            $searchArray[] = "asset_payment.employee_id ='" . $this->input->post('employee_id') . "'";
        }

        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and asset_payment.bill_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        #echo'<pre>';print_r($_POST);die;
        $where = php72_implode(" and ", $searchArray);
        #echo $where;die;

        $columnArr = array('master_asset.asset_no', '', '', '', 'master_vendor.vendor_name', 'asset_payment.payment_type', 'asset_payment.payment_period1', 'asset_payment.bill_date', 'asset_payment.bill_no', 'asset_payment.total_amount', 'asset_payment.ceiling_amount');
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }

        $assetListCount = $this->Masset->getLimitAssetPaymentEmployee($where, '', '', $sort_column, $columnSortOrder);
        $getAll_count = php72_count($assetListCount);

        $assetList = $this->Masset->getLimitAssetPaymentEmployee($where, $limit, $start, $sort_column, $columnSortOrder);
        $getLimit_count = php72_count($assetList);

        foreach ($assetList as $lists) {
       
            if ($lists['donor'] == 0) {
                $donor_type = $lists["other_donor"];
            } else {
                $donor_type = $this->showMaster($lists["donor"]);
            }
           $emp_name="";
           if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }
           
            if ($lists['budget_head'] == 0) {
                $budget_type = $lists["other_budget_head"];
            } else {
                $budget_type = $this->showMaster($lists["budget_head"]);
            }
            if ($lists['line_item'] == 0) {
                $line_item_type = $lists["other_line_item"];
            } else {
                $line_item_type = $this->showMaster($lists["line_item"]);
            }

            if ($lists["total_amount"] < $lists["ceiling_amount"]) {
                $total_amt = 0;
            } else {
                $total_amt = $lists["total_amount"] - $lists["ceiling_amount"];
            }

            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $emp_name;
            $nestedData[] = $donor_type;
            $nestedData[] = $budget_type;
            $nestedData[] = $line_item_type;
            $nestedData[] = $lists['vendor_name'];
            $nestedData[] = $lists['payment_type'];
            $nestedData[] = $lists['payment_period1'];
            $nestedData[] = $lists['bill_date'];
            $nestedData[] = $lists['bill_no'];
            $nestedData[] = $this->numberToCurrency($lists['total_amount']);
            $nestedData[] = $this->numberToCurrency($lists['ceiling_amount']);
            $nestedData[] = $this->numberToCurrency($total_amt);
            $data[] = $nestedData;
            $i++;
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

    function showMaster($master_id) {
        if ($master_id == '') {
            return '-';
        } else {
            $condition = array('master_id' => $master_id);
            $get_masterName = $this->Common_model->get_all_details('master_settings', $condition, array(), '', '', '', true, 'ais');
            return $get_masterName[0]->master_name;
        }
    }

    function ajax_book_request($bookId) {
        $this->load->helper('common_helper');
        $this->load->model('Mlogin');
        $this->load->model('Mlibrary');
        $returnArr = '0';
        $chechDup = $this->Mlibrary->checkRequest($bookId, $this->session->userdata("user"));
        if (php72_count($chechDup) == 0) {
            $this->session->set_flashdata('successMsg', 'Your request sent!');
        } else {
            $returnArr = '2';
            $this->session->set_flashdata('infoMsg', 'Your request already in pending! Request not sent!');
        }
        echo json_encode($returnArr);
    }

    function ajax_request() {
        #error_reporting(-1);
        $requestId = $this->input->post('request_id');
        #echo'<pre>';print_r($requestId);die;
        $returnArr['response'] = '0';
        if ($requestId != '') {
            $this->load->helper('common_helper');
            $this->load->model('Mlogin');
            $this->load->model('Mlibrary');
            $condition = array('library_booking_id' => $requestId);
            $getBookList = $this->Common_model->get_all_details('library_booking', $condition, array(), '', '', '', true, 'ais');
            if ($getBookList['0']->status == 'pending') {
                $returnArr = '1';
                $condition = array('library_booking_id' => $requestId);
                $data = array('cancel_date' => date('Y-m-d'));
                #$this->Common_model->update_data('library_booking', $condition, $data);
                if ($this->session->userdata('isAdmin') == 'Yes') {
                    $mailContant = $this->Mlibrary->libraryMailContant($requestId, 'Admin');
                    #sendMail($mailContant['adminEmail'], $mailContant['toEmail'], 'Book Request Disapproval', $mailContant);
                    #$returnUrl = 'libraryadmin/requests';
                } else {
                    $mailContant = $this->Mlibrary->libraryMailContant($requestId);
                    #sendMail($mailContant['employeeEmail'], $mailContant['toEmail'], 'Book Request Cancel By Employee', $mailContant);
                    #$returnUrl = 'libraryuser/requests';
                }
                $this->session->set_flashdata('successMsg', 'Your Request Cancelled !');
            } else {
                $returnArr = '2';
                $this->session->set_flashdata('warningMsg', 'Your Request Can not be process !');
                #redirect($returnUrl);
            }
        }
        echo json_encode($returnArr);
    }

    function numberToCurrency($num, $type = '') { #echo $num;die;
        $RES = explode('.', $num);
        $num = $RES[0];
        $digit = '';
        if ($RES[1] > 0) {
            $digit = '.' . $RES[1];
        }
        if ($type == 'view') {
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
            return '' . $thecash;
        }
    }

}

?>