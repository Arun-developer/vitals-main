<?php

class Asset_admin extends CI_Controller {

    function __construct() {

        #error_reporting(-1);
        parent::__construct();
        /* $this->Mauth->isLoggedCheck();
          $this->Mauth->loginUser(); */
        $this->Mauth->isLoggedCheck();
        $this->Mauth->isAdminCheck();

        $this->load->model('approval/Mapproval');
        $this->load->model('asset_admin/Common_model');
        $this->load->model('asset_admin/Mmaster');
        $this->load->model('asset_admin/Mcommon');
        $this->load->model('asset_admin/Masset');
        $this->load->model('asset_admin/Mapproval');
        $this->load->model('asset_admin/Mlogin');
    }

    public function listasset() {
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['userList'] = $this->Mlogin->getAllUserList();
        /* approval count */

        $data['an_approval_count'] = total_apppending_count();

        $this->load->view('asset_admin/listasset', $data);
    }

    public function requestlist() {

        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['userList'] = $this->Mlogin->getAllUserList();
        #echo'<pre>';print_r($data['assetTypeIT']);die;
        /* approval count */
        // $data['an_approval_count'] = total_apppending_count();
        $this->load->view('asset_admin/requestlist', $data);
    }

    public function transaction_history() {

        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['userList'] = $this->Mlogin->getAllUserList();
        #echo'<pre>';print_r($data['assetTypeIT']);die;
        /* approval count */
        // $data['an_approval_count'] = total_apppending_count();
        $this->load->view('asset_admin/transaction_history', $data);
    }

    public function notavail() {

        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['userList'] = $this->Mlogin->getAllUserList();
        /* approval count */
        // $data['an_approval_count'] = total_apppending_count();
        #echo'<pre>';print_r($data['assetTypeIT']);die;
        $this->load->view('asset_admin/notavail', $data);
    }

    public function listpayment() { #echo'das';die;
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['vendorList'] = $this->Mmaster->getVendorsList();
        $orderby = array('vendor_name' => 'asc');
        $data['getVendorsList'] = $this->Common_model->get_all_details('master_vendor', array('status' => '1'), array(), '', '', $orderby, true, 'ais');
        $data['payment_type'] = array('AMC' => 'AMC', 'usage' => 'Usage', 'repair' => 'Repairs', 'replace' => 'Replacements');
        $data['userList'] = $this->Mlogin->getAllUserList();
        /* approval count */
        // $data['an_approval_count'] = total_apppending_count();
        $this->load->view('asset_admin/listpayment', $data);
    }

    public function listpayment_employee() { #echo'das';die;
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');
        $data['vendorList'] = $this->Mmaster->getVendorsList();
        $orderby = array('vendor_name' => 'asc');
        $data['getVendorsList'] = $this->Common_model->get_all_details('master_vendor', array('status' => '1'), array(), '', '', $orderby, true, 'ais');
        $data['payment_type'] = array('AMC' => 'AMC', 'usage' => 'Usage', 'repair' => 'Repairs', 'replace' => 'Replacements');

        $data['userList'] = $this->Mlogin->getAllUserList();
        #echo'<pre>';print_r($data['userList']);die;
        /* approval count */
        // $data['an_approval_count'] = total_apppending_count();
        $this->load->view('asset_admin/listpayment_employee', $data);
    }

    public function DTlistasset() {

        #echo'<pre>';print_r($_POST);die; #error_reporting(-1);
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

        $columnArr = array('master_asset.asset_type', 'master_asset.asset_no', 'master_asset.asset_name', 'master_asset.asset_code', 'master_asset.serial_no', 'master_asset.purchase_date', 'master_asset.warrenty_expiry_date', 'master_asset.vendor', 'master_asset.AMC', 'master_asset.available_status');

        if ($this->input->post('vendor') != "") {
            $searchArray[] = "asset_type ='" . $this->input->post('vendor') . "'";
        }
        if ($this->input->post('asset_name') != "") {
            $searchArray[] = "asset_name like '%" . $this->input->post('asset_name') . "%'";
        }
        if ($this->input->post('asset_number') != "") {
            $searchArray[] = "asset_no like '%" . $this->input->post('asset_number') . "%'";
        }
        if ($this->input->post('available_status') != "") {
            $searchArray[] = "available_status like '%" . $this->input->post('available_status') . "%'";
        }
        if ($this->input->post('asset_code') != "") {
            $searchArray[] = "asset_code like '%" . $this->input->post('asset_code') . "%'";
        }
        if ($this->input->post('purchase_date_from') != "") {
            $searchArray[] = "purchase_date >= '" . date('Y-m-d', strtotime($this->input->post('purchase_date_from'))) . "' and purchase_date <= '" . date('Y-m-d', strtotime($this->input->post('purchase_date_to'))) . "'";
        }
        if ($this->input->post('employee_id') != "") {
            $empAsset = $this->Masset->getAssetEmpSearch($this->input->post('employee_id'));


            $searchArray[] = "master_asset.asset_id IN ('" . implode("','", $empAsset) . "')";
        }
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        #echo'<pre>';print_r($searchArray);die;
        $where = implode(" and ", $searchArray);
        //print_r($where);die;
        $assetListCount = $this->Masset->getLimitAssetall($where, '', '', $sort_column, $columnSortOrder);
        $getAll_count = count($assetListCount);

        $assetList = $this->Masset->getLimitAssetall($where, $limit, $start, $sort_column, $columnSortOrder);
        $getLimit_count = count($assetList);

        #echo'<pre>';print_r($assetList);die;
        foreach ($assetList as $lists) {

            $asset_id = $lists["asset_id"];
            $ceiling_amount = $this->Masset->get_ceilamount($asset_id);
            $emp_name="";
           if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                if(isset($employe_name[0]->emp_first_name) || isset($employe_name[0]->emp_last_name)){
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;    
                }
                
            }
            $amc_type = 'No';
            if ($lists["AMC"] == 1) {
                $amc_type = 'YES';
            }
            if ($lists["available_status"] == 1) {
                $available_status = 'Available';
            }
            if ($lists["available_status"] != 1) {
                $transfer_status = 'In Use';
            } else {
                $transfer_status = "<a  href='javascript:void(0);' class='action_cls transfer_cls' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . "  data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . " data-attr-amount=" . $ceiling_amount . ">" . 'Transfer' . "</a>";
            }
            $url = base_url() . 'index.php/asset_admin/add_payment/' . $lists['asset_id'];
            $add_payment = "<a  href=" . $url . "  class='action_cls' value=" . $lists['asset_id'] . " data-attr=" . $lists['asset_id'] . " >" . 'Add Payment' . "</a>";

            $vendor_name = "<a  href='javascript:void(0);' class='action_cls get_vendor' value=" . $lists['asset_id'] . " data-attr-id=" . $lists['asset_id'] . " data-attr=" . $lists["vendor_name"] . " data-attr-vid=" . $lists["vendor_id"] . " >" . $lists["vendor_name"] . "</a>";

            $purchase_date = '';
            if ($lists["purchase_date"] != '0000-00-00') {
                $purchase_date = $lists["purchase_date"];
            }
            $warrenty_expiry_date = '';
            if ($lists["warrenty_expiry_date"] != '0000-00-00') {
                $warrenty_expiry_date = $lists["warrenty_expiry_date"];
            }
            $status = '';
            $nestedData = array();
            if ($this->input->post('employee_id') != "") {
            if($emp_name != ""){
            $nestedData[] = $emp_name;
            $nestedData[] = $lists['master_name'];
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $lists["asset_name"];
            $nestedData[] = $lists['asset_code'];
            $nestedData[] = $lists['serial_no'];
            $nestedData[] = $purchase_date;
            $nestedData[] = $warrenty_expiry_date;
            $nestedData[] = $vendor_name;
            $nestedData[] = $amc_type;
            $nestedData[] = $available_status;
            $nestedData[] = $add_payment;
            $nestedData[] = $transfer_status;
            $data[] = $nestedData;
            $i++;
                }
            }else{
            $nestedData[] = $emp_name;
            $nestedData[] = $lists['master_name'];
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $lists["asset_name"];
            $nestedData[] = $lists['asset_code'];
            $nestedData[] = $lists['serial_no'];
            $nestedData[] = $purchase_date;
            $nestedData[] = $warrenty_expiry_date;
            $nestedData[] = $vendor_name;
            $nestedData[] = $amc_type;
            $nestedData[] = $available_status;
            $nestedData[] = $add_payment;
            $nestedData[] = $transfer_status;
            $data[] = $nestedData;
            $i++;
            }
            
        }
        #echo "<pre>";  print_r($data);die;
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTlistasset_export() {

        #echo'<pre>';print_r($_POST);die; #error_reporting(-1);

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $action = $this->input->post('action');
        $return_date_from = $this->input->post('return_date_from');
        $return_date_to = $this->input->post('return_date_to');

        $columnArr = array('master_asset.asset_type', 'master_asset.asset_no', 'master_asset.asset_name', 'master_asset.asset_code', 'master_asset.serial_no', 'master_asset.purchase_date', 'master_asset.warrenty_expiry_date', 'master_asset.vendor', 'master_asset.AMC', 'master_asset.available_status');

        if ($this->input->post('vendor') != "") {
            $searchArray[] = "asset_type ='" . $this->input->post('vendor') . "'";
        }
        if ($this->input->post('asset_name') != "") {
            $searchArray[] = "asset_name like '%" . $this->input->post('asset_name') . "%'";
        }
        if ($this->input->post('asset_number') != "") {
            $searchArray[] = "asset_no like '%" . $this->input->post('asset_number') . "%'";
        }
        if ($this->input->post('available_status') != "") {
            $searchArray[] = "available_status like '%" . $this->input->post('available_status') . "%'";
        }
        if ($this->input->post('asset_code') != "") {
            $searchArray[] = "asset_code like '%" . $this->input->post('asset_code') . "%'";
        }
        if ($this->input->post('purchase_date_from') != "") {
            $searchArray[] = "purchase_date >= '" . date('Y-m-d', strtotime($this->input->post('purchase_date_from'))) . "' and purchase_date <= '" . date('Y-m-d', strtotime($this->input->post('purchase_date_to'))) . "'";
        }
        if ($this->input->post('employee_id') != "") {
            $empAsset = $this->Masset->getAssetEmpSearch($this->input->post('employee_id'));
            $searchArray[] = "master_asset.asset_id IN ('" . implode("','", $empAsset) . "')";
        }

        #echo'<pre>';print_r($searchArray);die;
        $where = implode(" and ", $searchArray);
        #echo $where;die;
        $AN_report = $assetListCount = $this->Masset->getLimitAssetall($where, '', '', '', '');


        #echo'<pre>';print_r($AN_report);die;
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"List_assets_" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');

        fputcsv($handle, array(
            'Asset Type',
            'Asset Number',
            'Asset Name',
            'Asset Code',
            'Brand Name',
            'Description',
            'Model',
            'Serial Number',
            'Purchase Date',
            'Price',
            'Bill Number',
            'Bill Date',
            'Warranty Expiry Date',
            'Vendor',
            'AMC',
            'AMC Vendor',
            'AMC Period',
            'Employee',
            'Issue Date',
            'Status',
        ));

        foreach ($AN_report as $AN) {
            $transfer_status = 'Available';
            if ($lists["available_status"] != 1) {
                $transfer_status = 'In Use';
            }
            $bill_date = '';
            if ($AN['bill_date'] != '0000-00-00 00:00:00' && $AN['bill_date'] != '0000-00-00') {
                $bill_date = date('d-m-Y', strtotime($AN['bill_date']));
            }
            $warrenty_expiry_date = '';
            if ($AN['warrenty_expiry_date'] != '0000-00-00 00:00:00' && $AN['warrenty_expiry_date'] != '0000-00-00') {
                $warrenty_expiry_date = $AN['warrenty_expiry_date'];
            }
            $AMC_period = '';
            if ($AN['AMC_period'] != '0000-00-00 00:00:00' && $AN['AMC_period'] != '0000-00-00') {
                $AMC_period = $AN['AMC_period'];
            }
            $purchase_date = '';
            if ($AN['purchase_date'] != '0000-00-00 00:00:00' && $AN['purchase_date'] != '0000-00-00') {
                $purchase_date = $AN['purchase_date'];
            }

            fputcsv($handle, array(
                $AN['master_name'],
                $AN['asset_no'],
                $AN['asset_name'],
                $AN['asset_code'],
                $AN['brand_name'],
                $AN['description'],
                $AN['model'],
                $AN['serial_no'],
                $purchase_date,
                $AN['price'],
                $AN['bill_no'],
                $bill_date,
                $warrenty_expiry_date,
                $AN['vendor_name'],
                $AN['AMC'],
                $AN['AMC_vendorname'],
                $AMC_period,
                $AN['employee_id'],
                $AN['issue_date'],
                $transfer_status,
            ));
        }
        fclose($handle);
        exit;
    }

    public function DTrequestlist_export() {

        #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $action = $this->input->post('action');

        $return_date_from = $this->input->post('return_date_from');
        $return_date_to = $this->input->post('return_date_to');

        $columnArr = array('master_asset.asset_no', 'master_settings.master_name', 'master_asset.asset_name', '', 'asset_transaction.issue_date');

        $currentTab = 'using';
        $searchArray[] = "asset_transaction.transfer_status = '" . $currentTab . "'";
        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "master_asset.asset_type ='" . $this->input->post('asset_type') . "'";
        }
        if ($action != '') {
            $searchArray[] = "transfer_status = '" . $action . "'";
        }
        if ($this->input->post('asset_number') != "") {
            $searchArray[] = "asset_no like '%" . $this->input->post('asset_number') . "%'";
        }

        if ($this->input->post('employee_id') != "") {
            $empAsset = $this->Masset->getAssetEmpSearch($this->input->post('employee_id'));
            $searchArray[] = "master_asset.asset_id IN ('" . implode("','", $empAsset) . "')";
        }

        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and issue_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }


        #echo'<pre>';print_r($_POST);die;
        $where = implode(" and ", $searchArray);
        #echo $where;die;
        $assetListCount = $this->Masset->getExportAssetTransfer($where, '', '', 1);
        #echo "<pre>";print_r($assetListCount);die;
        #echo'<pre>';print_r($AN_report);die;
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"Assets_in_Use" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');





        fputcsv($handle, array(
            'Asset Type',
            'Asset Number',
            'Asset Name',
            'Asset Code',
            'Brand Name',
            'Description',
            'Model',
            'Serial Number',
            'Purchase Date',
            'Price',
            'Bill Number',
            'Bill Number',
            'Warranty Expiry Date',
            'Vendor',
            'AMC',
            'AMC Vendor',
            'AMC Period',
            'Employee',
            'Issue Date',
            'Status',
        ));

        foreach ($assetListCount as $lists) {
            
            #Data table value show  $lists['transfer_status'] in the table.
            /*$transfer_status = 'Available';
            if ($lists["available_status"] != 1) {
                $transfer_status = 'In Use';
            }*/

            $transfer_status = $lists['transfer_status'];
            $bill_date = '';
            if ($lists['bill_date'] != '0000-00-00 00:00:00' && $lists['bill_date'] != '0000-00-00') {
                $bill_date = $lists['bill_date'];
            }
            $purchase_date = '';
            if ($lists['purchase_date'] != '0000-00-00 00:00:00' && $lists['purchase_date'] != '0000-00-00') {
                $purchase_date = $lists['purchase_date'];
            }
            $warrenty_expiry_date = '';
            if ($lists['warrenty_expiry_date'] != '0000-00-00 00:00:00' && $lists['warrenty_expiry_date'] != '0000-00-00') {
                $warrenty_expiry_date = $lists['warrenty_expiry_date'];
            }
            $AMC_period = '';
            if ($lists['AMC_period'] != '0000-00-00 00:00:00' && $lists['AMC_period'] != '0000-00-00') {
                $AMC_period = $lists['AMC_period'];
            }


            fputcsv($handle, array(
                $lists['master_name'],
                $lists['asset_no'],
                $lists['asset_name'],
                $lists['asset_code'],
                $lists['brand_name'],
                $lists['description'],
                $lists['model'],
                $lists['serial_no'],
                $purchase_date,
                $lists['price'],
                $lists['bill_no'],
                $bill_date,
                $warrenty_expiry_date,
                $lists['vendor_name'],
                $lists['AMC'],
                $lists['AMC_vendorname'],
                $AMC_period,
                $lists['employee_id'],
                $lists['issue_date'],
                $transfer_status,
            ));
        }
        fclose($handle);
        exit;
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

        $columnArr = array('master_asset.asset_no', 'master_settings.master_name', 'master_asset.asset_name', '', 'asset_transaction.issue_date');

        $currentTab = 'using';
        $searchArray[] = "asset_transaction.transfer_status = '" . $currentTab . "'";
        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "master_asset.asset_type ='" . $this->input->post('asset_type') . "'";
        }
        if ($action != '') {
            $searchArray[] = "transfer_status = '" . $action . "'";
        }
        if ($this->input->post('asset_number') != "") {
            $searchArray[] = "asset_no like '%" . $this->input->post('asset_number') . "%'";
        }

        if ($this->input->post('employee_id') != "") {
            $empAsset = $this->Masset->getAssetEmpSearch($this->input->post('employee_id'));
            $searchArray[] = "master_asset.asset_id IN ('" . implode("','", $empAsset) . "')";
        }

        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and issue_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        #echo'<pre>';print_r($_POST);die;
        $where = implode(" and ", $searchArray);
        #echo $where;die;
        $assetListCount = $this->Masset->getLimitAssetTransfer($where, '', '', $sort_column, $columnSortOrder,1);
        $getAll_count = count($assetListCount);

        $assetList = $this->Masset->getLimitAssetTransfer($where, $limit, $start, $sort_column, $columnSortOrder,1);
        $getLimit_count = count($assetList);

        foreach ($assetList as $lists) {
            $emp_name = '';
            if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }
            $return_btn = '';
            if ($lists["transfer_status"] == 'In use') {

                $return_btn = "<a  href='javascript:void(0);' class='action_cls return_cls' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . "  data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'Return' . "</a>  ";
            }

            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $lists['master_name'];
            $nestedData[] = $lists['asset_name'];
            $nestedData[] = $emp_name;
            $nestedData[] = $lists['issue_date'];
            $nestedData[] = $lists['transfer_status'];
            $nestedData[] = $return_btn . "<a  href='javascript:void(0);' class='action_cls delete_cls' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'Delete' . "</a>";
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

    public function DTtransaction_export() {

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $action = $this->input->post('action');

        $return_date_from = $this->input->post('return_date_from');
        $return_date_to = $this->input->post('return_date_to');

        $columnArr = array('master_asset.asset_no', 'master_settings.master_name', 'master_asset.asset_name', '', 'asset_transaction.issue_date');

        $asset_type = $this->input->post('asset_type');

        /* $currentTab="returned";
          $searchArray[] = "asset_transaction.transfer_status = '" . $currentTab . "'"; */
        if ($asset_type != '') {
            $searchArray[] = "master_asset.asset_type ='" . $this->input->post('asset_type') . "'";
        }
        if ($action != '') {
            $searchArray[] = "transfer_status = '" . $action . "'";
        }
        if ($this->input->post('asset_number') != "") {
            $searchArray[] = "asset_no like '%" . $this->input->post('asset_number') . "%'";
        }
        if ($this->input->post('employee_id') != "") {
            $empAsset = $this->Masset->getAssetEmpSearch($this->input->post('employee_id'));
            $searchArray[] = "master_asset.asset_id IN ('" . implode("','", $empAsset) . "')";
        }

        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and issue_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        if ($this->input->post('return_date_from') != "" && $this->input->post('return_date_to') != "") {
            $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and return_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('return_date_from') != "") {
            $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('return_date_to') != "") {
            $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        $where = implode(" and ", $searchArray);
        $assetListCount = $this->Masset->getExportAssetTransfer($where, '', '', '', '');

        #echo'<pre>';print_r($AN_report);die;
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"Assets_in_Use" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');

        fputcsv($handle, array(
            'Asset Type',
            'Asset Number',
            'Asset Name',
            'Asset Code',
            'Brand Name',
            'Description',
            'Model',
            'Serial Number',
            'Purchase Date',
            'Price',
            'Bill Number',
            'Bill Number',
            'Warranty Expiry Date',
            'Vendor',
            'AMC',
            'AMC Vendor',
            'AMC Period',
            'Employee',
            'Issue Date',
            'Status',
        ));

        foreach ($assetListCount as $lists) {
            $transfer_status = 'Available';
            if ($lists["available_status"] != 1) {
                $transfer_status = 'In Use';
            }
            $purchase_date = '';
            if ($lists['purchase_date'] != '0000-00-00 00:00:00' && $lists['purchase_date'] != '0000-00-00') {
                $purchase_date = $lists['purchase_date'];
            }
            $warrenty_expiry_date = '';
            if ($lists['warrenty_expiry_date'] != '0000-00-00 00:00:00' && $lists['warrenty_expiry_date'] != '0000-00-00') {
                $warrenty_expiry_date = $lists['warrenty_expiry_date'];
            }
            $AMC_period = '';
            if ($lists['AMC_period'] != '0000-00-00 00:00:00' && $lists['AMC_period'] != '0000-00-00') {
                $AMC_period = $lists['AMC_period'];
            }
            $bill_date = '';
            if ($lists['bill_date'] != '0000-00-00 00:00:00' && $lists['bill_date'] != '0000-00-00') {
                $bill_date = $lists['bill_date'];
            }

            fputcsv($handle, array(
                $lists['master_name'],
                $lists['asset_no'],
                $lists['asset_name'],
                $lists['asset_code'],
                $lists['brand_name'],
                $lists['description'],
                $lists['model'],
                $lists['serial_no'],
                $purchase_date,
                $lists['price'],
                $lists['bill_no'],
                $bill_date,
                $warrenty_expiry_date,
                $lists['vendor_name'],
                $lists['AMC'],
                $lists['AMC_vendorname'],
                $AMC_period,
                $lists['employee_id'],
                $lists['issue_date'],
                $transfer_status,
            ));
        }
        fclose($handle);
        exit;
    }

    public function DTtransaction() {

        # echo'<pre>';print_r($_POST);die;
        //transfer_status = 'returned'
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

        $columnArr = array('master_asset.asset_no', 'master_settings.master_name', 'master_asset.asset_name', '', 'asset_transaction.issue_date');

        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "master_asset.asset_type ='" . $this->input->post('asset_type') . "'";
        }
        if ($action != '') {
            $searchArray[] = "transfer_status = '" . $action . "'";
        }
        if ($this->input->post('asset_number') != "") {
            $searchArray[] = "asset_no like '%" . $this->input->post('asset_number') . "%'";
        }
        if ($this->input->post('employee_id') != "") {
            $empAsset = $this->Masset->getAssetEmpSearch($this->input->post('employee_id'));
            $searchArray[] = "master_asset.asset_id IN ('" . implode("','", $empAsset) . "')";
        }

        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and issue_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "issue_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        if ($this->input->post('return_date_from') != "" && $this->input->post('return_date_to') != "") {
            $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and return_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('return_date_from') != "") {
            $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('return_date_to') != "") {
            $searchArray[] = "return_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        #echo'<pre>';print_r($_POST);die;
        $where = implode(" and ", $searchArray);
        #echo $where;die;
        $assetListCount = $this->Masset->getLimitAssetTransfer($where, '', '', $sort_column, $columnSortOrder);
        $getAll_count = count($assetListCount);
        #echo $where;
        $assetList = $this->Masset->getLimitAssetTransfer($where, $limit, $start, $sort_column, $columnSortOrder);
        $getLimit_count = count($assetList);
        /*  echo'<pre>';print_r($where);
          echo'<pre>';print_r($assetList);die;
         */
        foreach ($assetList as $lists) {
            $emp_name = '';
            if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }

            $return_date = '';
            if ($lists['return_date'] != '' && $lists['return_date'] != '0000-00-00') {
                $return_date = $lists['return_date'];
            }
            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $lists['master_name'];
            $nestedData[] = $lists['asset_name'];
            $nestedData[] = $emp_name;
            $nestedData[] = $lists['issue_date'];
            $nestedData[] = $return_date;
            $nestedData[] = $lists['transfer_status'];
            $nestedData[] = "<a  href='javascript:void(0);' class='action_cls delete_cls' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'Delete' . "</a>";
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

    public function DTnotavail_export() {

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

        $columnArr = array('ma.asset_type', 'ma.asset_no', 'ma.asset_name', 'ma.asset_code');

        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "ma.asset_type ='" . $this->input->post('asset_type') . "'";
        }

        if ($this->input->post('asset_number') != "") {
            $searchArray[] = "ma.asset_no like '%" . $this->input->post('asset_number') . "%'";
        }
        if ($this->input->post('asset_code') != "") {
            $searchArray[] = "ma.asset_code like '%" . $this->input->post('asset_code') . "%'";
        }

        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        #echo'<pre>';print_r($_POST);die;
        $where = implode(" and ", $searchArray);
        #echo $where;die;
        $assetListCount = $this->Masset->getExportAssetNotavail($where, '', '', $sort_column, $columnSortOrder, 'Show All');

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"Assets_not_available" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');

        fputcsv($handle, array(
            'Master Name',
            'Asset Number',
            'Asset Name',
            'Asset Code',
            'Status',
            'Reason'
        ));

        foreach ($assetListCount as $lists) {
            $transfer_status = 'Available';
            if ($lists["available_status"] != 1) {
                $transfer_status = 'In Use';
            }
            fputcsv($handle, array(
                $lists['master_name'],
                $lists['asset_no'],
                $lists['asset_name'],
                $lists['asset_code'],
                $lists['ina_reason'],
                $lists['ina_comment']
            ));
        }
        fclose($handle);
        exit;
    }

    public function DTnotavail() {

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

        $columnArr = array('ma.asset_type', 'ma.asset_no', 'ma.asset_name', 'ma.asset_code');

        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "ma.asset_type ='" . $this->input->post('asset_type') . "'";
        }

        if ($this->input->post('asset_number') != "") {
            $searchArray[] = "ma.asset_no like '%" . $this->input->post('asset_number') . "%'";
        }
        if ($this->input->post('asset_code') != "") {
            $searchArray[] = "ma.asset_code like '%" . $this->input->post('asset_code') . "%'";
        }

        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        #echo'<pre>';print_r($_POST);die;
        $where = implode(" and ", $searchArray);
        #echo $where;die;
        $assetListCount = $this->Masset->getExportAssetNotavail($where, '', '', $sort_column, $columnSortOrder, 'Show All');
        $getAll_count = count($assetListCount);

        $assetList = $this->Masset->getExportAssetNotavail($where, $limit, $start, $sort_column, $columnSortOrder, 'Show All');
        #echo'<pre>';print_r($assetList);die;
        $getLimit_count = count($assetList);

        foreach ($assetList as $lists) {
            $emp_name = '';
            if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }
            $status = "Available";
            if ($lists["ina"] == 'yes') {
                $status = ucwords($lists["ina_reason"]);
            }
            $nestedData = array();
            $nestedData[] = $lists['master_name'];
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $lists['asset_name'];
            $nestedData[] = $lists['asset_code'];
            $nestedData[] = $status;
            $nestedData[] = $lists['ina_comment'];
            $nestedData[] = "<a  href='javascript:void(0);' class='action_cls delete_cls' data-attr-id=" . $lists['asset_id'] . " >" . 'Available' . "</a>";
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

    function asset_not_available() { #error_reporting(-1);
        $asset_id = $this->input->post('asset_id');
        $this->Masset->NotavailtoAvail('master_asset', $asset_id);
        $this->session->set_flashdata('successMsg', 'Assest updated Successfully');
        echo json_encode($returnArr);
    }

    function delete_tranfer() {
        $asset_id = $this->input->post('asset_id');
        $transfer_id = $this->input->post('transfer_id');
        $currentTab = $this->input->post('currentTab');
        $returnArr = '1';
        $this->Mcommon->delete('asset_transaction', 'transfer_id', $transfer_id);
        if ($currentTab == 'using')
            $this->Masset->availableStatus('1', $asset_id);
        $this->session->set_flashdata('successMsg', 'Record deleted Successfully!');
        //redirect('requestlist/using');
        echo json_encode($returnArr);
    }

    function add_payment($asset_id = '') { #echo'asdasdasd';die;
        #echo $asset_id;die;
        $data['transferAsset'] = $this->config->item('transferAsset');
        $data['ceilingAsset'] = $this->config->item('ceilingAsset');
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');

        $data['vendorList'] = $this->Mmaster->getVendorsList();
        $data['donorList'] = $this->Mcommon->getMasterSetting('Donor');
        $data['budgetHeadList'] = $this->Mcommon->getMasterSetting('Budget Head');
        $data['userList'] = $this->Mlogin->getAllUserList();
        $data['asset_id'] = $this->uri->segment('4');

        $data['assetInfo'] = $this->Mcommon->getRecords('master_asset', 'asset_id', $asset_id);

        $data['costCentreList'] = $this->Mcommon->getMasterSetting('Cost Centre');

        if ($this->input->post('asset_id') != "") {
            $this->form_validation->set_rules('budget_head', 'budget_head', 'required');
            if ($this->input->post('budget_head') == 0)
                $this->form_validation->set_rules('other_budget_head', 'Budget Head', 'required');
            $this->form_validation->set_rules('donor', 'Donor', 'required');
            if ($this->input->post('donor') == 0)
                $this->form_validation->set_rules('other_donor', 'Budget Head', 'required');

            $this->form_validation->set_rules('vendor', 'vendor', 'required');
            $this->form_validation->set_rules('bill_date', 'Bill Date', 'required');
            $this->form_validation->set_rules('payment_period1', 'Payment Period From', 'required');
            $this->form_validation->set_rules('payment_period2', 'Payment Period To', 'required');
            $this->form_validation->set_rules('total_amount', 'Amount', 'required');
            $this->form_validation->set_rules('payment_type', 'Payment Type', 'required');

            if ($this->input->post('payment_type') == 'usage') {
                $this->form_validation->set_rules('employee_id', 'Employee', 'required');
                $this->form_validation->set_rules('ceiling_amount', 'Ceiling Amount', 'required');
            }

            if ($this->form_validation->run() != FALSE) {
                if ($this->uri->segment(3) == 'edit') {
                    $this->Masset->editPayment();
                    $this->session->set_flashdata('successMsg', 'Payment Added Successfully!');
                    redirect('assetadmin/listpayment');
                } else {
                    $result = $this->Masset->addPayment();
                    if ($this->input->post('payment_type') == 'usage')
                        $this->sendpaymentMail($result);
                    $this->session->set_flashdata('successMsg', 'Payment Added Successfully!');
                    redirect('assetadmin/listasset');
                }
            }
        }

        $data['payment_type'] = array('AMC' => 'AMC', 'usage' => 'Usage', 'repair' => 'Repairs', 'replace' => 'Replacements');
        $this->load->view('asset_admin/add_payment', $data);
    }

    function edit_payment($asset_id = '') { #echo'asdasdasd';die;
        #echo $asset_id;die;
        $data['transferAsset'] = $this->config->item('transferAsset');
        $data['ceilingAsset'] = $this->config->item('ceilingAsset');
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');

        $data['vendorList'] = $this->Mmaster->getVendorsList();
        $data['donorList'] = $this->Mcommon->getMasterSetting('Donor');
        $data['budgetHeadList'] = $this->Mcommon->getMasterSetting('Budget Head');
        $data['userList'] = $this->Mlogin->getAllUserList();
        $data['asset_id'] = $this->uri->segment('4');

        $data['assetInfo'] = $this->Mcommon->getRecords('master_asset', 'asset_id', $asset_id);
        $data['costCentreList'] = $this->Mcommon->getMasterSetting('Cost Centre');

        if ($this->input->post('asset_id') != "") {
            $this->Masset->editPayment();
            $this->session->set_flashdata('successMsg', 'Payment Added Successfully!');
        }
        $data['payment_type'] = array('AMC' => 'AMC', 'usage' => 'Usage', 'repair' => 'Repairs', 'replace' => 'Replacements');
        $data['paymentInfo'] = $paymentInfo = $this->Mcommon->getRecords('asset_payment', 'payment_id', $this->uri->segment('4'));
        #echo'<pre>';print_r($paymentInfo );die;
        /* approval count */
        // $data['an_approval_count'] = total_apppending_count();
        $this->load->view('asset_admin/edit_payment', $data);
    }

    function edit_payment_employee($asset_id = '') { #echo'asdasdasd';die;
        #echo $asset_id;die;
        $data['transferAsset'] = $this->config->item('transferAsset');
        $data['ceilingAsset'] = $this->config->item('ceilingAsset');
        $data['assetTypeIT'] = $this->Mcommon->getMasterSetting('IT Asset');
        $data['assetTypeGeneral'] = $this->Mcommon->getMasterSetting('General Asset');

        $data['vendorList'] = $this->Mmaster->getVendorsList();
        $data['donorList'] = $this->Mcommon->getMasterSetting('Donor');
        $data['budgetHeadList'] = $this->Mcommon->getMasterSetting('Budget Head');
        $data['userList'] = $this->Mlogin->getAllUserList();
        $data['asset_id'] = $this->uri->segment('4');

        $data['assetInfo'] = $this->Mcommon->getRecords('master_asset', 'asset_id', $asset_id);
        $data['costCentreList'] = $this->Mcommon->getMasterSetting('Cost Centre');

        if ($this->input->post('asset_id') != "") {
            $this->Masset->editPayment();
            $this->session->set_flashdata('successMsg', 'Payment Added Successfully!');
        }
        $data['payment_type'] = array('AMC' => 'AMC', 'usage' => 'Usage', 'repair' => 'Repairs', 'replace' => 'Replacements');
        $data['paymentInfo'] = $paymentInfo = $this->Mcommon->getRecords('asset_payment', 'payment_id', $this->uri->segment('4'));
        #echo'<pre>';print_r($paymentInfo );die;
        /* approval count */
        // $data['an_approval_count'] = total_apppending_count();
        $this->load->view('asset_admin/edit_payment_employee', $data);
    }

    function insertEdit_payment($asset_id = '') {
        $result = $this->Masset->addPayment();
        $this->session->set_flashdata('successMsg', 'Asset Transfer Successfully !');
        redirect('asset_admin/listasset');
    }

    function asset_edit_payment() { #echo'<pre>';print_r($_POST);die;
        $this->Masset->editPayment();
        $this->session->set_flashdata('successMsg', 'Asset Updated Successfully !');
        redirect('asset_admin/listasset');
    }

    function ajax_get_vendor() {
        $asset_id = $this->input->post('asset_id');
        $vendor_id = $this->input->post('vendor_id');
        $returnArr = '';
        if ($asset_id != '') {
            $searchArray[] = "master_asset.asset_id = '" . $asset_id . "'";
            $searchArray[] = "master_vendor.vendor_id = '" . $vendor_id . "'";
            $where = implode(" and ", $searchArray);
            $assetList = $this->Masset->getLimitAssetall($where, $limit, $start, $sort_column, $columnSortOrder);

            if (!empty($assetList[0])) {
                $vendor_name = $assetList[0]['vendor_name'];
                $contact_person = $assetList[0]['contact_person'];
                $vendor_email = $assetList[0]['vendor_email'];
                $contact_no = $assetList[0]['contact_no'];
                $address = $assetList[0]['address'];
                $website = $assetList[0]['website'];
                $returnArr = array('name' => $vendor_name, 'person' => $contact_person, 'email' => $vendor_email, 'contact' => $contact_no, 'address' => $address, 'website' => $website);
            }
            echo json_encode($returnArr);
        }
    }

    function transfer() {
        $this->load->helper('common_helper');
        #echo'<pre>';print_r($_POST);die;
        if (count($_POST) > 2) {
            $result = $this->Masset->transferAsset();
            $this->sendTransferMail($result);
        }
        $this->session->set_flashdata('successMsg', 'Asset Transfer Successfully !');
        redirect('asset_admin/listasset');
    }

    function return_asset() {
        if (count($_POST) > 2) {
            $this->Masset->transferReturn();
            $this->sendReturnMail($this->input->post("transfer_id"));
            $this->session->set_flashdata('successMsg', 'Asset Returned Successfully!');
            $returnArr = '1';
        } else {
            $this->session->set_flashdata('errorMsg', 'Validation error, Please enter (*) Fields!');
            $returnArr = '0';
        }
        echo json_encode($returnArr);
    }

    function sendTransferMail($id) {
        $this->load->helper('common_helper');
        $mailContent = $this->Masset->assetTransferMailContent($id);
        #echo'<pre>';print_r($mailContent);die;
        sendMail($mailContent['adminEmail'], $mailContent['toEmail'], 'Asset Transfer', $mailContent);
    }

    function sendReturnMail($id) {
        $this->load->helper('common_helper');
        $mailContent = $this->Masset->assetTransferMailContent($id);
        sendMail($mailContent['adminEmail'], $mailContent['toEmail'], 'Assets Return', $mailContent);
    }

    function sendpaymentMail($id) {
        $this->load->helper('common_helper');
        $mailContent = $this->Masset->assetPaymentMailContent($id);
        sendMail($mailContent['adminEmail'], $mailContent['toEmail'], 'Asset Payment', $mailContent);
    }

    function delete_payment($payment_id) {

        $payment_id = $this->input->post('payment_id');
        $this->Mcommon->delete('asset_payment', 'payment_id', $payment_id);
        $this->session->set_flashdata('successMsg', 'Record deleted Successfully!');
        //redirect('asset_admin/listpayment');
        $returnArr = '0';
        echo json_encode($returnArr);
    }

    public function DTlistpayment_export() {

        #echo "<pre>"; print_r($_POST);die;

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $asset_no = $this->input->post('asset_no');
        $vendor = $this->input->post('vendor');
        $employee_id = $this->input->post('employee_id');
        $payment_type = $this->input->post('payment_type');


        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "master_asset.asset_type ='" . $this->input->post('asset_type') . "'";
        }
        if ($asset_no != '') {
            $searchArray[] = "asset_no ='" . $this->input->post('asset_no') . "'";
        }
        if ($vendor != '') {
            $searchArray[] = "master_vendor.vendor_id ='" . $this->input->post('vendor') . "'";
        }
        if ($employee_id != '') {
            $searchArray[] = "asset_payment.employee_id ='" . $this->input->post('employee_id') . "'";
        }
        if ($payment_type != "") {
            $searchArray[] = "payment_type like '%" . $this->input->post('payment_type') . "%'";
        }
        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and asset_payment.bill_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        $where = implode(" and ", $searchArray);

        $assetListCount = $this->Masset->getExportAssetPayment($where, '', '', '', '');
        #echo "<pre>";  print_r($assetListCount);die;
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"Assets_payment" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');

        fputcsv($handle, array(
            'Employee Name',
            'Bill Number',
            'Bill Date',
            'Amount',
            'Ceiling Amount',
            'Salary Deduction',
            'Payment type',
            'Payment Period From',
            'Payment Period To',
            'Donor',
            'Budget Head',
            'Line Item',
            'Cost Centre',
            'Price',
            'Warranty Expiry Date',
            'Asset Vendor',
            'AMC',
            'AMC Vendor',
            'AMC AMC Period'
        ));

        foreach ($assetListCount as $lists) {

            $emp_name = '';
            if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }

            $transfer_status = 'Available';
            if ($lists["available_status"] != 1) {
                $transfer_status = 'In Use';
            }
            if ($lists['donor'] == 0) {
                $donor_type = $lists["other_donor"];
            } else {
                $donor_type = $this->showMaster($lists["donor"]);
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
            $cost_centre = $this->showMaster($lists['cost_centre']);

            $payment_period1 = '';
            if ($lists['bill_date'] != '0000-00-00 00:00:00' && $lists['payment_period1'] != '0000-00-00') {
                $payment_period1 = $lists['payment_period1'];
            }
            $payment_period2 = '';
            if ($lists['payment_period2'] != '0000-00-00 00:00:00' && $lists['payment_period2'] != '0000-00-00') {
                $payment_period2 = $lists['payment_period2'];
            }
            $warrenty_expiry_date = '';
            if ($lists['warrenty_expiry_date'] != '0000-00-00 00:00:00' && $lists['warrenty_expiry_date'] != '0000-00-00') {
                $warrenty_expiry_date = $lists['warrenty_expiry_date'];
            }
            $AMC_period = '';
            if ($lists['AMC_period'] != '0000-00-00 00:00:00' && $lists['AMC_period'] != '0000-00-00') {
                $AMC_period = $lists['AMC_period'];
            }



            fputcsv($handle, array(
                $emp_name,
                $lists['bill_no'],
                $lists['bill_date'],
                $lists['total_amount'],
                $lists['other_employee_id'],
                $lists['salary_deduction'],
                $lists['payment_type'],
                $payment_period1,
                $payment_period2,
                $donor_type,
                $budget_type,
                $line_item_type,
                $cost_centre,
                $lists['price'],
                $warrenty_expiry_date,
                $lists['pay_vendor_name'],
                $lists['AMC'],
                $lists['AMC_vendorname'],
                $AMC_period,
            ));
        }
        fclose($handle);
        exit;
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
        $payment_type = $this->input->post('payment_type');


        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "master_asset.asset_type ='" . $this->input->post('asset_type') . "'";
        }
        if ($asset_no != '') {
            $searchArray[] = "asset_no ='" . $this->input->post('asset_no') . "'";
        }
        if ($vendor != '') {
            $searchArray[] = "master_vendor.vendor_id ='" . $this->input->post('vendor') . "'";
        }

        if ($employee_id != '') {
            $searchArray[] = "asset_payment.employee_id ='" . $this->input->post('employee_id') . "'";
        }

        if ($payment_type != "") {
            $searchArray[] = "payment_type like '%" . $this->input->post('payment_type') . "%'";
        }
        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and asset_payment.bill_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        #echo'<pre>';print_r($_POST);die;
        $where = implode(" and ", $searchArray);
        #echo $where;die;

        $columnArr = array('master_asset.asset_no', '', '', '', 'master_vendor.vendor_name', 'asset_payment.payment_type', 'asset_payment.payment_period1', 'asset_payment.bill_date', 'asset_payment.bill_no', 'asset_payment.total_amount', 'asset_payment.ceiling_amount');
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }

        $assetListCount = $this->Masset->getLimitAssetPayment($where, '', '', $sort_column, $columnSortOrder);
        $getAll_count = count($assetListCount);

        $assetList = $this->Masset->getLimitAssetPayment($where, $limit, $start, $sort_column, $columnSortOrder);
        $getLimit_count = count($assetList);
        #echo'<pre>';print_r($assetList);die;
        $sum=0;
        foreach ($assetList as $lists) {

            $sumpayment=$lists['total_amount'];
             $sum+= $sumpayment;
            if ($lists['donor'] == 0) {
                $donor_type = $lists["other_donor"];
            } else {
                $donor_type = $this->showMaster($lists["donor"]);
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

            $emp_name = '';
            if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }

          
            $stringtagline=ucfirst($line_item_type); 
            if (strlen($stringtagline) > 25) { 
            $tooltip_i='<span class="subsummary" data-toggle="tooltip" data-placement="top" title="'.$stringtagline.'"><i class="fa fa-info-circle"></i> </span>';
            $stringCutedline = substr($stringtagline, 0, 20);     
            $string_cutting_data_line = substr($stringCutedline, 0, strrpos($stringCutedline, ' ')).'...&nbsp;'.$tooltip_i; 
            $summary=$string_cutting_data_line;
            }
            else{
              $summary=$stringtagline;
            }

            $subsummarydata=$this->showMaster($lists['cost_centre']);
           /*
           if (strlen($summary) > $limit)
           $summary = substr($summary, 0, strrpos(substr($summary, 0, $limit), ' ')) . '...';
            if (strlen($subsummary) > $limit)
           $subsummary = substr($subsummary, 0, strrpos(substr($subsummary, 0, $limit), ' ')) . '...';*/

            $status = '';

             $string = strip_tags($subsummarydata);
             $stringtag=ucfirst($string); 
            if (strlen($stringtag) > 25) { //echo "sdfsdf"; die;
            $tooltip_i='<span class="subsummary" data-toggle="tooltip" data-placement="top" title="'.$stringtag.'"><i class="fa fa-info-circle"></i> </span>';
            $stringCuted = substr($stringtag, 0, 20);     
            $string_cutting_data = substr($stringCuted, 0, strrpos($stringCuted, ' ')).'...&nbsp;'.$tooltip_i; 
            $subsummary=$string_cutting_data;
            }
            else{
            $subsummary=$stringtag;
            }
            $nestedData = array();
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $this->showMaster($lists['asset_type']);
            $nestedData[] = $emp_name;

            $nestedData[] = $donor_type;
            $nestedData[] = $budget_type;
            $nestedData[] = $summary;
            $nestedData[] = $subsummary;
            $nestedData[] = $lists['vendor_name'];
            $nestedData[] = $lists['payment_type'];
            $nestedData[] = $lists['payment_period1'];
            $nestedData[] = $lists['bill_date'];
            $nestedData[] = $lists['bill_no'];
            $nestedData[] = $this->numberToCurrency($lists['total_amount']);

            $url = base_url() . 'index.php/asset_admin/edit_payment/' . $lists['asset_id'] . '/' . $lists['payment_id'];
            $nestedData[] = "<a href=" . $url . " class='action_cls return_cls' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . "  data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'Edit Payment' . "</a>  <a  href='javascript:void(0);' class='action_cls delete_cls' data-attr-pid=" . $lists['payment_id'] . ">" . 'Delete' . "</a>";
            $data[] = $nestedData;
            $i++;
        }
        //print_r($sum);die;

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST,
            "sum"=>$this->numberToCurrency($sum)
        );
        echo json_encode($json_data);
    }

    public function DTlistpayment_employee_export() {

        #echo "<pre>";  print_r($_POST);die;

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $asset_no = $this->input->post('asset_number');
        $vendor = $this->input->post('vendor');
        $employee_id = $this->input->post('employee_id');
        $payment_type = $this->input->post('payment_type');

        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "master_asset.asset_type ='" . $this->input->post('asset_type') . "'";
        }
        if ($asset_no != '') {
            $searchArray[] = "asset_no ='" . $this->input->post('asset_number') . "'";
        }
        if ($vendor != '') {
            $searchArray[] = "master_vendor.vendor_id ='" . $this->input->post('vendor') . "'";
        }
        if ($employee_id != '') {
            $searchArray[] = "asset_payment.employee_id ='" . $this->input->post('employee_id') . "'";
        }
        if ($payment_type != "") {
            $searchArray[] = "payment_type like '%" . $this->input->post('payment_type') . "%'";
        }
        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and asset_payment.bill_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        #echo'<pre>';print_r($_POST);die;
        $where = implode(" and ", $searchArray);

        $assetListCount = $this->Masset->getExportAssetPayment($where, '', '', '', '');


        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"Assets_usages" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');

        fputcsv($handle, array(
            'Employee Name',
            'Bill Number',
            'Bill Date',
            'Amount',
            'Ceiling Amount',
            'Salary Deduction',
            'Payment type',
            'Payment Period From',
            'Payment Period To',
            'Donor',
            'Budget Head',
            'Line Item',
            'Cost Centre',
            'Payment Vendor',
            'Asset Type',
            'Asset Number',
            'Asset Name',
            'Serial Number',
            'Purchase Date',
            'Price',
            'Warranty Expiry Date',
            'Asset Vendor',
            'AMC',
            'AMC Vendor',
            'AMC Period'
        ));

        foreach ($assetListCount as $lists) {

            $emp_name = '';
            if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }

            $transfer_status = 'Available';
            if ($lists["available_status"] != 1) {
                $transfer_status = 'In Use';
            }
            if ($lists['donor'] == 0) {
                $donor_type = $lists["other_donor"];
            } else {
                $donor_type = $this->showMaster($lists["donor"]);
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
            $cost_centre = $this->showMaster($lists['cost_centre']);

            $purchase_date = '';
            if ($lists['purchase_date'] != '0000-00-00 00:00:00' && $lists['purchase_date'] != '0000-00-00') {
                $purchase_date = $lists['purchase_date'];
            }
            $warrenty_expiry_date = '';
            if ($lists['warrenty_expiry_date'] != '0000-00-00 00:00:00' && $lists['warrenty_expiry_date'] != '0000-00-00') {
                $warrenty_expiry_date = $lists['warrenty_expiry_date'];
            }
            $AMC_period = '';
            if ($lists['AMC_period'] != '0000-00-00 00:00:00' && $lists['AMC_period'] != '0000-00-00') {
                $AMC_period = $lists['AMC_period'];
            }

            fputcsv($handle, array(
                $emp_name,
                $lists['bill_no'],
                $lists['bill_date'],
                $lists['total_amount'],
                $lists['ceiling_amount'],
                $lists['salary_deduction'],
                $lists['payment_type'],
                $lists['payment_period1'],
                $lists['payment_period2'],
                $donor_type,
                $budget_type,
                $line_item_type,
                $cost_centre,
                $lists['pay_vendor_name'],
                $lists['brand_name'],
                $lists['asset_no'],
                $lists['asset_code'],
                $lists['serial_no'],
                $purchase_date,
                $lists['price'],
                $warrenty_expiry_date,
                $lists['pay_vendor_name'],
                $lists['AMC'],
                $lists['AMC_vendorname'],
                $AMC_period,
            ));
        }
        fclose($handle);
        exit;


        echo'<pre>';
        print_r($assetListCount);
        die;
    }

    public function DTlistpayment_employee() {

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
        $payment_type = $this->input->post('payment_type');


        $asset_type = $this->input->post('asset_type');
        if ($asset_type != '') {
            $searchArray[] = "master_asset.asset_type ='" . $this->input->post('asset_type') . "'";
        }
        if ($asset_no != '') {
            $searchArray[] = "asset_no ='" . $this->input->post('asset_no') . "'";
        }
        if ($vendor != '') {
            $searchArray[] = "master_vendor.vendor_id ='" . $this->input->post('vendor') . "'";
        }
        if ($employee_id != '') {
            $searchArray[] = "asset_payment.employee_id ='" . $this->input->post('employee_id') . "'";
        }
        if ($payment_type != "") {
            $searchArray[] = "payment_type like '%" . $this->input->post('payment_type') . "%'";
        }
        if ($this->input->post('date_from') != "" && $this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "' and asset_payment.bill_date <= '" . date('Y-m-d', strtotime($date_to)) . "'";
        } else if ($this->input->post('date_from') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_from)) . "'";
        } else if ($this->input->post('date_to') != "") {
            $searchArray[] = "asset_payment.bill_date >= '" . date('Y-m-d', strtotime($date_to)) . "'";
        }

        #echo'<pre>';print_r($_POST);die;
        $where = implode(" and ", $searchArray);
        #echo $where;die;

        $columnArr = array('master_asset.asset_no', '', '', '', 'master_vendor.vendor_name', 'asset_payment.payment_type', 'asset_payment.payment_period1', 'asset_payment.bill_date', 'asset_payment.bill_no', 'asset_payment.total_amount', 'asset_payment.ceiling_amount');
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }

        $assetListCount = $this->Masset->getLimitAssetPaymentEmployee($where, '', '', $sort_column, $columnSortOrder);
        $getAll_count = count($assetListCount);

        $assetList = $this->Masset->getLimitAssetPaymentEmployee($where, $limit, $start, $sort_column, $columnSortOrder);
        $getLimit_count = count($assetList);
        #echo'<pre>';print_r($assetList);die;
        $totamountsum=$ceiling_amountsum=$deduction_amountsum=0;
        foreach ($assetList as $lists) {
            if ($lists['donor'] == 0) {
                $donor_type = $lists["other_donor"];
            } else {
                $donor_type = $this->showMaster($lists["donor"]);
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

            $emp_name = '';
            if ($lists['employee_id'] != '') {
                $employe_name = $this->Common_model->get_all_details('hr_user_profile', array('id' => $lists['employee_id']), array('emp_first_name', 'emp_last_name'));
                $emp_name = $employe_name[0]->emp_first_name . ' ' . $employe_name[0]->emp_last_name;
            }

            if (($lists['ceiling_amount'] == 0 ) || ($lists['total_amount'] < $lists['ceiling_amount'])) {
                $deduction_amount = 0;
            } else {
                $deduction_amount = $lists['total_amount'] - $lists['ceiling_amount'];
            }

            $totamountsum+=$lists['total_amount'];
            $ceiling_amountsum+=$lists['ceiling_amount'];
            $deduction_amountsum+=$deduction_amount;

            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['asset_no'];
            $nestedData[] = $this->showMaster($lists['asset_type']);
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
            $nestedData[] = $deduction_amount;

            $url = base_url() . 'index.php/asset_admin/edit_payment_employee/' . $lists['asset_id'] . '/' . $lists['payment_id'];
            $nestedData[] = "<a href=" . $url . " class='action_cls return_cls' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . "  data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'Edit Payment' . "</a>  <a  href='javascript:void(0);' class='action_cls delete_cls' data-attr-pid=" . $lists['payment_id'] . ">" . 'Delete' . "</a>";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST,
            "totamountsum"=> $this->numberToCurrency($totamountsum),
            "ceiling_amountsum"=> $this->numberToCurrency($ceiling_amountsum),
            "deduction_amountsum"=> $this->numberToCurrency($deduction_amountsum)
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
