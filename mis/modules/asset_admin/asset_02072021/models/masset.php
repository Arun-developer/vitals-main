<?php

class Masset extends My_Model {
	
	public function __construct(){
        $this->hris = $this->load->database('hris', TRUE);
        $this->ais = $this->load->database('ais', TRUE);
    }
    
    function getUserNameInfo($userid) {
        $data = array();
        $this->db->select("hr_user_login.emp_id as emp_number,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,official_email as emp_work_email,personal_email as emp_oth_email", false);
        $this->db->where('hr_user_profile.id', $userid);
        $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
        $query = $this->db->get('hr_user_login');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    
    function transferAsset() {
        $data = array('asset_id' => $this->input->post("asset_id"),
            'employee_id' => $this->input->post("employee_id"),
            'other_employee_id' => $this->input->post("other_employee_id"),
            'issue_date' => ddmmyyyy2mysql($this->input->post("issue_date")),
            'ceiling_amount' => $this->input->post("ceiling_amount"));
        $this->db->insert('asset_transaction', $data);
        $id = $this->db->insert_id();
        $this->availableStatus('0', $this->input->post("asset_id"));
        return $id;
    }

    function transferReturn() {
        $this->db->where('transfer_id', $this->input->post("transfer_id"));
        $data = array('return_date' => ddmmyyyy2mysql($this->input->post("return_date")),
            'transfer_status' => 'returned');
        $this->db->update('asset_transaction', $data);
        $this->availableStatus('1', $this->input->post("asset_id"));
        return true;
    }

    function availableStatus($status, $asset) {
        $this->db->where('asset_id', $asset);
        $this->db->set('available_status', $status);
        $this->db->update('master_asset');
    }

    function useingEmployee($asset, $full = NULL) {
        $data = array();
        $this->db->select('employee_id,other_employee_id');
        $this->db->where('asset_id', $asset);
        $this->db->where('transfer_status', 'using');
        $query = $this->db->get('asset_transaction');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        $user = '';
        if (count($data))
            $user = ($data['0']['employee_id'] == '0') ? $data['0']['other_employee_id'] : getEmployeeName($data['0']['employee_id']);

        if ($full != NULL)
            return $data;
        return $user;
    }

    function getAllassetTransfer($where, $admin = NULL) {
        $data = array();
        if ($admin == NULL)
            $this->db->where('employee_id', $this->session->userdata("user"));
        $this->db->where('master_asset.ina', 'no');
        $this->db->join('master_asset', 'asset_transaction.asset_id=master_asset.asset_id', 'left');
        if ($where != NULL)
            $query = $this->db->get_where('asset_transaction', $where);
        else
            $query = $this->db->get('asset_transaction');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getAssetEmpSearch($emp_id) {
        $data = array();
        $this->db->select('asset_id');
        $this->db->where('employee_id', $emp_id);
        $this->db->where('transfer_status', 'using');
        $query = $this->db->get('asset_transaction');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['asset_id'];
            }
        }
        return $data;
    }

    function getLimitAssetTransfer($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL) {
      
        $data = array();
        $this->ais->limit($num, $offset);
        if ($admin == NULL)
            $this->ais->where('employee_id', $this->session->userdata("user"));
        $this->ais->join('master_asset', 'asset_transaction.asset_id=master_asset.asset_id', 'left');
        $this->ais->where('master_asset.ina', 'no');
        if ($orderby != NULL && $ordertype != NULL)
            $this->ais->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->ais->get_where('asset_transaction', $where);
        else
            $query = $this->ais->get('asset_transaction');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['transfer_status'] = ($row["transfer_status"] == 'using') ? 'In use' : ucfirst($row["transfer_status"]);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getExportAssetTransfer($where = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL) {
        $data = array();
        if ($admin == NULL)
            $this->db->where('employee_id', $this->session->userdata("user"));

        $this->db->select('master_settings.master_name, asset_transaction.*,master_asset.*,master_vendor.vendor_name,master_vendor.contact_person,master_vendor.vendor_name,a.vendor_name as AMC_vendorname,');
        $this->db->join('master_asset', 'asset_transaction.asset_id=master_asset.asset_id', 'left');
        $this->db->join('master_settings', 'master_asset.asset_type=master_settings.master_id', 'left');
        $this->db->join('master_vendor', 'master_asset.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_vendor as a', 'master_asset.AMC_vendor=a.vendor_id', 'left');
        $this->db->where('master_asset.ina', 'no');
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('asset_transaction', $where);
        else
            $query = $this->db->get('asset_transaction');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['transfer_status'] = ($row["transfer_status"] == 'using') ? 'In use' : ucfirst($row["transfer_status"]);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function addPayment() {
        $employee = ($this->input->post("payment_type") == "usage") ? ($this->input->post("employee_id")) : ('');
        $data = array('asset_id' => $this->input->post("asset_id"),
            'ceiling_amount' => $this->input->post("ceiling_amount"),
            'employee_id' => $employee,
            'other_employee_id' => $this->input->post("other_employee_id"),
            'bill_date' => ddmmyyyy2mysql($this->input->post("bill_date")),
            'bill_no' => $this->input->post("bill_no"),
            'vendor' => $this->input->post("vendor"),
            'budget_head' => $this->input->post("budget_head"),
            'donor' => $this->input->post("donor"),
            'other_budget_head' => $this->input->post("other_budget_head"),
            'other_donor' => $this->input->post("other_donor"),
            'line_item' => $this->input->post("line_item"),
            'other_line_item' => $this->input->post("other_line_item"),
            'cost_centre' => $this->input->post("cost_centre"),
            'other_cost_centre' => $this->input->post("other_cost_centre"),
            'payment_period1' => ddmmyyyy2mysql($this->input->post("payment_period1")),
            'payment_period2' => ddmmyyyy2mysql($this->input->post("payment_period2")),
            'payment_type' => $this->input->post("payment_type"),
            'total_amount' => $this->input->post("total_amount"));
        $this->db->insert('asset_payment', $data);

        return $this->db->insert_id();
    }

    function editPayment() {
        $employee = ($this->input->post("payment_type") == "usage") ? ($this->input->post("employee_id")) : ('');
        $data = array(
            'employee_id' => $employee,
            'other_employee_id' => $this->input->post("other_employee_id"),
            'ceiling_amount' => $this->input->post("ceiling_amount"),
            'bill_date' => ddmmyyyy2mysql($this->input->post("bill_date")),
            'bill_no' => $this->input->post("bill_no"),
            'vendor' => $this->input->post("vendor"),
            'budget_head' => $this->input->post("budget_head"),
            'donor' => $this->input->post("donor"),
            'other_budget_head' => $this->input->post("other_budget_head"),
            'other_donor' => $this->input->post("other_donor"),
            'line_item' => $this->input->post("line_item"),
            'other_line_item' => $this->input->post("other_line_item"),
            'cost_centre' => $this->input->post("cost_centre"),
            'other_cost_centre' => $this->input->post("other_cost_centre"),
            'payment_period1' => ddmmyyyy2mysql($this->input->post("payment_period1")),
            'payment_period2' => ddmmyyyy2mysql($this->input->post("payment_period2")),
            'payment_type' => $this->input->post("payment_type"),
            'total_amount' => $this->input->post("total_amount"));
        $this->db->where('payment_id', $this->input->post("payment_id"));
        $this->db->update('asset_payment', $data);

        return $this->db->insert_id();
    }

    function getAllassetPayment($where) {
        $this->db->select('count(*) as total, sum(total_amount) as total_amount,sum(ceiling_amount) as ceiling_amount');
        $data = array();
        $this->db->join('master_asset', 'asset_payment.asset_id=master_asset.asset_id', 'left');
        if ($where != NULL)
            $query = $this->db->get_where('asset_payment', $where);
        else
            $query = $this->db->get('asset_payment');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return array_pop($data);
    }

    function getLimitAssetPayment($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL) {
        $data = array();
        $this->db->limit($num, $offset);
        $this->db->select('asset_payment.*,master_asset.asset_id,master_asset.asset_type,master_asset.asset_no,master_asset.available_status,master_vendor.vendor_name');
        $this->db->join('master_vendor', 'asset_payment.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_asset', 'asset_payment.asset_id=master_asset.asset_id', 'left');
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('asset_payment', $where);
        else
            $query = $this->db->get('asset_payment');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getExportAssetPayment($where = NULL, $orderby = NULL, $ordertype = NULL) {
        $data = array();
        $this->db->select('master_asset.*,asset_payment.*,master_vendor.vendor_name as pay_vendor_name,asset.vendor_name as vendor_name,amc.vendor_name as AMC_vendorname');
        $this->db->join('master_vendor', 'asset_payment.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_asset', 'asset_payment.asset_id=master_asset.asset_id', 'left');
        $this->db->join('master_vendor as asset', 'master_asset.vendor=asset.vendor_id', 'left');
        $this->db->join('master_vendor as amc', 'master_asset.AMC_vendor=amc.vendor_id', 'left');
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('asset_payment', $where);
        else
            $query = $this->db->get('asset_payment');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['salary_deduction'] = ($row["total_amount"] < $row["ceiling_amount"]) ? '0' : ($row["total_amount"] - $row["ceiling_amount"]);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getChatAssetPayment($where = NULL) {
        $data = array();
        if ($where == NULL) {
            $from = ddmmyyyy2mysql(date("d/m/Y", mktime(0, 0, 0, date("m") - 6, date("d"), date("Y"))));
            $to = ddmmyyyy2mysql(date("d/m/Y"));
            $where = "payment_period1 >= '" . $from . "' and payment_period1 <= '" . $to . "'";
        }
        $query = $this->db->get_where('asset_payment', $where);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getAllassetPaymentEmployee($where, $admin = NULL) {
        $data = array();
        $this->db->select('count(*) as total, sum(total_amount) as total_amount,sum(ceiling_amount) as ceiling_amount');
        if ($admin == NULL)
            $this->db->where('employee_id', $this->session->userdata('user'));

        $this->db->where('employee_id !=', '0');
        $this->db->where('payment_type', 'usage');
        $this->db->join('master_asset', 'asset_payment.asset_id=master_asset.asset_id', 'left');

        if ($where != NULL)
            $query = $this->db->get_where('asset_payment', $where);
        else
            $query = $this->db->get('asset_payment');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return array_pop($data);
    }

    function getLimitAssetPaymentEmployee($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL) {
        $data = array();
        $this->ais->limit($num, $offset);
        if ($admin == NULL)
            $this->ais->where('employee_id', $this->session->userdata('user'));

        $this->ais->where('employee_id !=', '0');
        $this->ais->where('payment_type', 'usage');
        $this->ais->select('asset_payment.*,master_asset.asset_id,master_asset.asset_type,master_asset.asset_no,master_asset.available_status,master_vendor.vendor_name');
        $this->ais->join('master_vendor', 'asset_payment.vendor=master_vendor.vendor_id', 'left');
        $this->ais->join('master_asset', 'asset_payment.asset_id=master_asset.asset_id', 'left');

        if ($orderby != NULL && $ordertype != NULL)
            $this->ais->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->ais->get_where('asset_payment', $where);
        else
            $query = $this->ais->get('asset_payment');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function assetInfo($admin = NULL) {

        $data = array();
        $data_pay = array();
        if ($admin == NULL)
            $this->db->where('employee_id', $this->session->userdata("user"));

        $this->db->where('transfer_status', 'using');
        $query = $this->db->get('asset_transaction');
        $data['usingAssets'] = $query->num_rows();
        $query->free_result();

        if ($admin == NULL)
            $this->db->where('employee_id', $this->session->userdata('user'));

        $this->db->orderby('payment_period1', 'DESC');
        $this->db->limit('1', '0');
        $query = $this->db->get('asset_payment');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data_pay[] = $row;
            }
        }
        $data['payAssets'] = $data_pay;
        $query->free_result();

        return $data;
    }

    function assetTransferMailContent($id) {
        $data = array();
        $this->db->where('transfer_id', $id);
        $this->db->join('master_asset', 'asset_transaction.asset_id=master_asset.asset_id', 'left');
        $query = $this->db->get('asset_transaction');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $adminEmail = $this->session->userdata('adminEmail');
        if ($data['0']['employee_id'] != '0') {
            $employeeDetails = $this->Mlogin->getEmployeeFromUserId($data['0']['employee_id']);
            $empEmail = ($employeeDetails['0']['emp_work_email'] != '') ? $employeeDetails['0']['emp_work_email'] : $employeeDetails['0']['emp_oth_email'];
            $to = $employeeDetails['0']['emp_firstname'];
            $reportingAuth = reportingUser('supUser', 'All', $employeeDetails['0']['emp_number']);
            if (count($reportingAuth))
                $reportAuthEmail = ($reportingAuth['0']['emp_work_email'] != '') ? $reportingAuth['0']['emp_work_email'] : $reportingAuth['0']['emp_oth_email'];
            else
                $reportAuthEmail = '';

            $from = 'Admin';
            $toEmail = array($empEmail, $adminEmail, $reportAuthEmail);
        }
        else {
            $from = 'Admin';
            $toEmail = array($adminEmail);
            $to = $data['0']['other_employee_id'];
            $empEmail = '';
        }

        $org = array('#From#', '#To#', '#user_name#', '#asset_number#', '#asset_name#', '#asset_type#', '#issue_date#', '#ceiling_amount#', '#return_date#');

        $replace = array($from,
            $to,
            ($data['0']["employee_id"] == "0") ? $data['0']["other_employee_id"] : getEmployeeName($data['0']["employee_id"]),
            $data['0']['asset_no'],
            $data['0']['asset_name'],
            showMaster($data['0']['asset_type']),
            mysql2ddmmyyyy($data['0']['issue_date']),
            $data['0']['ceiling_amount'],
            mysql2ddmmyyyy($data['0']['return_date']));

        $data1 = array('org' => $org,
            'replace' => $replace,
            'employeeEmail' => $empEmail,
            'adminEmail' => $adminEmail,
            'toEmail' => $toEmail);

        return $data1;
    }

    function assetPaymentMailContent($id) {
        $this->db->where('payment_id', $id);
        $this->db->select('asset_payment.*,master_asset.asset_id,master_asset.asset_no,master_asset.asset_name,master_asset.asset_type,master_asset.available_status,master_vendor.vendor_name');
        $this->db->join('master_vendor', 'asset_payment.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_asset', 'asset_payment.asset_id=master_asset.asset_id', 'left');
        $query = $this->db->get('asset_payment');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $from = 'Admin';
        if ($data['0']["employee_id"] != '0') {
            $employeeDetails = $this->Mlogin->getEmployeeFromUserId($data['0']['employee_id']);
            $empEmail = ($employeeDetails['0']['emp_work_email'] != '') ? $employeeDetails['0']['emp_work_email'] : $employeeDetails['0']['emp_oth_email'];
            $adminEmail = $this->session->userdata('adminEmail');

            $reportingAuth = reportingUser('supUser', 'All', $employeeDetails['0']['emp_number']);
            if (count($reportingAuth))
                $reportAuthEmail = ($reportingAuth['0']['emp_work_email'] != '') ? $reportingAuth['0']['emp_work_email'] : $reportingAuth['0']['emp_oth_email'];
            else
                $reportAuthEmail = '';

            $to = getEmployeeName($data['0']["employee_id"]);
            $toEmail = array($empEmail, $adminEmail, $reportAuthEmail);
        } else {
            $to = $data['0']["other_employee_id"];
            $toEmail = array($adminEmail);
            $reportAuthEmail = '';
            $adminEmail = '';
        }

        $salary_deduction = ($data['0']["total_amount"] < $data['0']["ceiling_amount"]) ? '0' : ($data['0']["total_amount"] - $data['0']["ceiling_amount"]);

        $org = array('#From#', '#To#', '#user_name#', '#asset_number#', '#asset_name#', '#asset_type#', '#donor#', '#budget_head#', '#line_item#', '#vendor_name#', '#payment_type#', '#payment_period#', '#bill_date#', '#bill_no#', '#total_amount#', '#ceiling_amount#', '#salary_deduction#');
        $replace = array(
            $from,
            $to,
            $to,
            $data['0']['asset_no'],
            $data['0']['asset_name'],
            showMaster($data['0']['asset_type']),
            ($data['0']["donor"] == 0) ? $data['0']["other_donor"] : showMaster($data['0']["donor"]),
            ($data['0']["budget_head"] == 0) ? $data['0']["other_budget_head"] : showMaster($data['0']["budget_head"]),
            ($data['0']["line_item"] == 0) ? $data['0']["other_line_item"] : showMaster($data['0']["line_item"]),
            $data['0']['vendor_name'],
            $data['0']['payment_type'],
            mysql2ddmmyyyy($data['0']['payment_period1']) . " - " . mysql2ddmmyyyy($data['0']['payment_period2']),
            mysql2ddmmyyyy($data['0']['bill_date']),
            $data['0']['bill_no'],
            $data['0']['total_amount'],
            $data['0']['ceiling_amount'],
            $salary_deduction);

        $data1 = array('org' => $org,
            'replace' => $replace,
            'employeeEmail' => $empEmail,
            'adminEmail' => $adminEmail,
            'toEmail' => $toEmail);
        return $data1;
    }

    function getLimitAssetNotavail($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL) {
        $data = array();
        $this->db->limit($num, $offset);
        $this->db->select('ma.*,master_settings.master_name');
        $this->db->join('master_settings', 'ma.asset_type=master_settings.master_id');
        $this->db->where('ma.ina', 'yes');
        if ($where != NULL)
            $this->db->where($where);
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        $query = $this->db->get('master_asset ma');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['transfer_status'] = "Item Not Available";
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function NotavailtoAvail($table, $aid) {
        $val = array(
            'ina' => 'no',
            'ina_reason' => '',
            'ina_comment' => '',
            'available_status' => 1
        );
        $this->db->where('asset_id', $aid);
        $this->db->update($table, $val);
        return true;
    }

    function getExportAssetNotavail($where = NULL, $orderby = NULL, $ordertype = NULL) {
        $data = array();
        $this->db->select('ma.*,master_settings.master_name');
        $this->db->join('master_settings', 'ma.asset_type=master_settings.master_id');
        $this->db->where('ma.ina', 'yes');

        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('master_asset ma', $where);
        else
            $query = $this->db->get('master_asset ma');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}

?>