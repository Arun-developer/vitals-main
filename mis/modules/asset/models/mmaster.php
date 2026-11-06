<?php

class Mmaster extends Model {

    function Mmaster() { #echo'd';die;
        parent::Model();
        $this->load->model('Mlibrary');
        $this->load->model('Mcommon');
    }

    //Master Settings
    function getMaster($MasterType = NULL, $MasterName = NULL, $Id = NULL) {
        $data = array();
        if ($MasterType != NULL)
            $terms['master_type'] = $MasterType;
        if ($MasterName != NULL)
            $terms['master_name'] = $MasterName;
        if ($Id != NULL)
            $terms['master_id'] = $Id;
        $query = $this->db->get_where('master_settings', $terms);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getMasterDuplicate($MasterType = NULL, $MasterName = NULL, $pid = NULL) {
        $data = array();
        $terms['partner_id'] = $this->session->userdata('partner_id');
        if ($MasterType != NULL)
            $terms['master_type'] = $MasterType;
        if ($MasterName != NULL)
            $terms['master_name'] = $MasterName;
        if ($pid != NULL)
            $terms['pid'] = $pid;
        $query = $this->db->get_where('master_settings', $terms);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function insertMaster() {
        if ($this->input->post('master_type') == 'Cost Centre') {
            $data = array('master_type' => $this->input->post('master_type'),
                'pid' => $this->input->post('pid'),
                'partner_id' => $this->session->userdata('partner_id'),
                'master_name' => $this->input->post('master_name'));
            $result = $this->db->insert('master_settings', $data);
        } else {
            $data = array('master_type' => $this->input->post('master_type'),
                'pid' => $this->input->post('pid'),
                'master_name' => $this->input->post('master_name'),
                'partner_id' => $this->session->userdata('partner_id'));
            $result = $this->db->insert('master_settings', $data);
        }
        return $result;
    }

    function updateMaster() {
        $data = array('master_type' => $this->input->post('master_type'),
            'pid' => $this->input->post('pid'),
            'master_name' => $this->input->post('master_name'));
        $this->db->where('master_id', $this->input->post('master_id'));
        $result = $this->db->update('master_settings', $data);
        return $result;
    }

    //End Master Settings
    //Start Master Programme
    function getMasterProgramme($id = NULL) {
        $data = array();
        $this->db->where('status', '1');
        if ($id != NULL)
            $this->db->where('programme_id', $id);

        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $this->db->order_by('programme', 'asc');
        $query = $this->db->get('master_programme');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getBalanceProgramme($id = NULL) {
        $data = array();
        $financial = $this->findCurrentFinancialYear();
        $from = converttodate($financial[0]['from']);
        $to = converttodate($financial[0]['to']);
        $this->db->select('MP.*');
        $this->db->join('balance_amount BA', 'BA.programme_id=MP.programme_id');
        $this->db->where('MP.status', '1');
        if ($id != NULL)
            $this->db->where('MP.programme_id', $id);
        $this->db->where('BA.amount_date >=', $from);
        $this->db->where('BA.amount_date <=', $to);
        $this->db->where('MP.partner_id', $this->session->userdata('partner_id'));
        $this->db->group_by('BA.programme_id');
        $this->db->order_by('MP.programme', 'asc');
        $query = $this->db->get('master_programme MP');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getBalanceDonor($id = NULL) {
        $data = array();
        $financial = $this->findCurrentFinancialYear();
        $from = converttodate($financial[0]['from']);
        $to = converttodate($financial[0]['to']);
        $this->db->select('BA.donor_id');
        if ($id != NULL)
            $this->db->where('BA.programme_id', $id);
        $this->db->where('BA.amount_date >=', $from);
        $this->db->where('BA.amount_date <=', $to);
        $this->db->group_by(array("BA.programme_id", "BA.donor_id"));
        $query = $this->db->get('balance_amount BA');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['donor_id'];
            }
        }
        $query->free_result();
        return $data;
    }

    function insertProgramme() {
        $data = array('donor' => serialize($this->input->post('donor')),
            'programme' => $this->input->post('programme'),
            'partner_id' => $this->session->userdata('partner_id'),
            'programme_head' => $this->input->post('programme_head'));
        $result = $this->db->insert('master_programme', $data);
        return $result;
    }

    function updateProgramme() {
        $data = array('donor' => serialize($this->input->post('donor')),
            'programme' => $this->input->post('programme'),
            'programme_head' => $this->input->post('programme_head'));
        $this->db->where('programme_id', $this->input->post('programme_id'));
        $result = $this->db->update('master_programme', $data);
        return $result;
    }

    //end Master Programme
    //Start Master Vendors
    function getVendorsList() {
        $data = array();
        $this->db->where('status', '1');
        $this->db->order_by('vendor_name');
        $query = $this->db->get('master_vendor');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function insertVendors() {
        $data = array(
            'vendor_name' => $this->input->post('VendorName'),
            'contact_person' => $this->input->post('ContactPerson'),
            'contact_no' => $this->input->post('ContactNumber'),
            'website' => $this->input->post('Website'),
            'vendor_email' => $this->input->post('EmailAddress'),
            'address' => $this->input->post('CompanyAddress'));
        $result = $this->db->insert('master_vendor', $data);
        $vendor_id = $this->db->insert_id();
        $this->insertContact($vendor_id);
        return $result;
    }

    function insertContact($vendor_id) {
        $this->db->where('vendor_id', $vendor_id);
        $this->db->delete('master_vendor_contact');
        if (isset($_POST['name'])) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $contact_no = $this->input->post('phone');
            foreach ($name as $key => $value) {
                if ($value != "") {
                    $data = array('vendor_id' => $vendor_id,
                        'name' => $value,
                        'email' => $email[$key],
                        'contact_no' => $contact_no[$key]);
                    $this->db->insert('master_vendor_contact', $data);
                }
            }
        }
    }

    function updateVendors() {
        $data = $_POST;
        $Id = $this->input->post('vendor_id');
        $data = array(
            'vendor_name' => $this->input->post('VendorName'),
            'contact_person' => $this->input->post('ContactPerson'),
            'contact_no' => $this->input->post('ContactNumber'),
            'website' => $this->input->post('Website'),
            'vendor_email' => $this->input->post('EmailAddress'),
            'address' => $this->input->post('CompanyAddress'));
        $this->db->where('vendor_id', $Id);
        $data = $this->db->update('master_vendor', $data);
        $this->insertContact($Id);
        return $data;
    }

    //End Master Vendors
    //Start Finance Users
    function insertFinance() {
        $data = array('username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email'),
            'company' => $this->input->post('company'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'));
        $result = $this->db->insert('finance_user', $data);
        return $result;
    }

    function updateFinance() {
        $data = array('username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email'),
            'company' => $this->input->post('company'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'));
        $this->db->where('finance_id', $this->input->post('finance_id'));
        $result = $this->db->update('finance_user', $data);
        return $result;
    }

    //End Finance Users
    //Start Books Master
    function bookNumber() {
        $data = array();
        $book_serial_format = $this->Mlibrary->getLibrarySettings('book_serial_format');
        $position = "front";
        $this->db->order_by('book_id', 'desc');
        $this->db->limit('1', '0');
        $query = $this->db->get('master_books');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        if (count($data))
            $id = str_pad((int) $data['0']['book_id'] + 1, 4, "0", STR_PAD_LEFT);
        else
            $id = '0001';
        return $assetNo = $book_serial_format . $id;
    }

    function getAllBooks($where = NULL) {
        $data = array();
        $this->db->select('count(*) as total');
        $this->db->join('master_settings', 'master_books.master_id=master_settings.master_id');
        if ($where != NULL)
            $query = $this->db->get_where('master_books', $where);
        else
            $query = $this->db->get('master_books');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    function getLimitBooks($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $export = NULL) {
        $data = array();
        if ($export == NULL)
            $this->db->limit($num, $offset);
        $this->db->select('master_settings.master_name, master_books.*');
        $this->db->join('master_settings', 'master_books.master_id=master_settings.master_id');
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('master_books', $where);
        else
            $query = $this->db->get('master_books');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function insertBooks() {
        $data = array('master_id' => $this->input->post('master_id'),
            'book_number' => $this->input->post('book_number'),
            'book_name' => $this->input->post('book_name'),
            'author' => $this->input->post('author'));
        $result = $this->db->insert('master_books', $data);
        return $result;
    }

    function updateBooks() {
        $data = array('master_id' => $this->input->post('master_id'),
            'book_number' => $this->input->post('book_number'),
            'book_name' => $this->input->post('book_name'),
            'author' => $this->input->post('author'));
        $this->db->where('book_id', $this->input->post('book_id'));
        $result = $this->db->update('master_books', $data);
        return $result;
    }

    function getParent($id = NULL) {
        $query = "select pid from master_settings where master_id= '" . $id . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data[0]['pid'];
    }

    function checkDeplicateBook($book_number) {
        $this->db->where('book_number', $book_number);
        $query = $this->db->get('master_books');
        if ($query->num_rows() > 0) {
            return false;
        }
        return true;
    }

    function getLibraryDues($employee) {
        $data = array();
        $this->db->where('library_booking.employee_id', $employee);
        $this->db->where('library_booking.status', 'confirmed');
        $this->db->select('master_settings.master_name,master_books.book_name,master_books.author,master_books.book_number,library_booking.*');
        $this->db->join('master_books', 'library_booking.book_id=master_books.book_id', 'left');
        $this->db->join('master_settings', 'master_books.master_id=master_settings.master_id', 'left');
        $query = $this->db->get('library_booking');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    //End Books Master
    //Start Assets Master
    function assetNumber() {
        $data = array();
        $text = "AST/";
        $position = "front";
        $this->db->order_by('asset_id', 'desc');
        $this->db->limit('1', '0');
        $query = $this->db->get('master_asset');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        if (count($data))
            $id = str_pad((int) $data['0']['asset_id'] + 1, 4, "0", STR_PAD_LEFT);
        else
            $id = '0001';
        return $assetNo = $text . $id;
    }

    function getAllAsset($where = NULL) {
        $data = array();
        $this->db->select('master_settings.master_name, master_asset.*,master_vendor.vendor_name,master_vendor.contact_person,master_vendor.vendor_name,master_vendor.vendor_email,master_vendor.contact_no,master_vendor.address,master_vendor.website,a.vendor_name as AMC_vendorname,a.vendor_email as AMC_vendoremail,a.contact_no as AMC_contactno,a.address as AMC_address,a.website as AMC_website,a.contact_person as AMC_contactperson,master_asset.status as master_status');
        $this->db->join('master_settings', 'master_asset.asset_type=master_settings.master_id', 'left');
        $this->db->join('master_vendor', 'master_asset.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_vendor as a', 'master_asset.AMC_vendor=a.vendor_id', 'left');
        $this->db->join('asset_transaction as asset', 'asset.asset_id=master_asset.asset_id', 'left');
        $this->db->where('master_asset.ina', 'no');

        if ($where != NULL)
            $query = $this->db->get_where('master_asset', $where);
        else
            $query = $this->db->get('master_asset');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getLimitAsset($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $export = NULL) {
        $data = array();
        if ($export == NULL)
            $this->db->limit($num, $offset);
        $this->db->select('master_settings.master_name, master_asset.*,master_vendor.vendor_name,master_vendor.contact_person,master_vendor.vendor_name,
                            master_vendor.vendor_email,master_vendor.contact_no,master_vendor.address,master_vendor.website,a.vendor_name as AMC_vendorname,
                            a.vendor_email as AMC_vendoremail,a.contact_no as AMC_contactno,a.address as AMC_address,a.website as AMC_website,
                            a.contact_person as AMC_contactperson,asset.employee_id,(CASE master_asset.status WHEN 1 THEN "Inactive" ELSE "Active"
                            END) as master_status,asset.issue_date');
        $this->db->join('master_settings', 'master_asset.asset_type=master_settings.master_id', 'left');
        $this->db->join('master_vendor', 'master_asset.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_vendor as a', 'master_asset.AMC_vendor=a.vendor_id', 'left');
        $this->db->join('asset_transaction as asset', 'asset.asset_id=master_asset.asset_id', 'left');

        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('master_asset', $where);
        else
            $query = $this->db->get('master_asset');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getExportAsset($where = NULL, $orderby = NULL, $ordertype = NULL) {
        $data = array();
        $this->db->select('master_settings.master_name, master_asset.*,master_vendor.vendor_name,master_vendor.contact_person,
                            master_vendor.vendor_name,master_vendor.vendor_email,master_vendor.contact_no,master_vendor.address,
                            master_vendor.website,a.vendor_name as AMC_vendorname,a.vendor_email as AMC_vendoremail,a.contact_no as AMC_contactno,
                            a.address as AMC_address,a.website as AMC_website,a.contact_person as AMC_contactperson,asset.employee_id,
                            (CASE master_asset.available_status WHEN 1 THEN "Available" ELSE "In Use"
                            END) as available_status,asset.issue_date');
        $this->db->join('master_settings', 'master_asset.asset_type=master_settings.master_id', 'left');
        $this->db->join('master_vendor', 'master_asset.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_vendor as a', 'master_asset.AMC_vendor=a.vendor_id', 'left');
        $this->db->join('asset_transaction as asset', 'asset.asset_id=master_asset.asset_id', 'left');
        $this->db->where('master_asset.ina', 'no');
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('master_asset', $where);
        else
            $query = $this->db->get('master_asset');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getAMCremindlist() {
        $data = array();
        $beforeweek = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $this->config->item('amcReminder'), date("Y")));
        $this->db->select('AMC_period,warrenty_expiry_date,asset_id');
        $this->db->where('AMC_period', $beforeweek);
        $this->db->where('AMC', 'yes');
        $query = $this->db->get('master_asset');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getAssetDues($employee) {
        $data = array();
        $this->db->where('employee_id', $employee);
        $this->db->where('asset_transaction.transfer_status', 'using');
        $this->db->join('master_asset', 'asset_transaction.asset_id=master_asset.asset_id', 'left');
        $query = $this->db->get('asset_transaction');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function assetMailContent($id) {
        $data = array();
        $this->db->where('asset_id', $id);
        $this->db->select('master_settings.master_name, master_asset.*,master_vendor.vendor_name,master_vendor.contact_person,master_vendor.vendor_name,a.vendor_name as AMC_vendorname,');
        $this->db->join('master_settings', 'master_asset.asset_type=master_settings.master_id', 'left');
        $this->db->join('master_vendor', 'master_asset.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_vendor as a', 'master_asset.AMC_vendor=a.vendor_id', 'left');
        $query = $this->db->get('master_asset');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $adminEmail = $this->session->userdata('adminEmail');
        $from = 'AIS';
        $to = 'Admin';

        $org = array('#From#', '#To#', '#type#', '#asset_type#', '#asset_number#', '#asset_code#', '#asset_name#', '#brand_name#', '#description#', '#model#', '#serial_no#', '#expiry_date#', '#vendor#', '#price#', '#bill_no#', '#bill_date#', '#amc#', '#amc_vendor#', '#available_status#');
        $replace = array($from,
            $to,
            ($data['0']['type'] == 'it') ? 'IT Assets' : 'General Assets',
            showMaster($data['0']['asset_type']),
            $data['0']['asset_no'],
            $data['0']['asset_code'],
            $data['0']['asset_name'],
            $data['0']['brand_name'],
            $data['0']['description'],
            $data['0']['model'],
            $data['0']['serial_no'],
            mysql2ddmmyyyy($data['0']['warrenty_expiry_date']),
            $data['0']['vendor_name'],
            $data['0']['price'],
            $data['0']['bill_no'],
            mysql2ddmmyyyy($data['0']['bill_date']),
            $data['0']['AMC'],
            $data['0']['AMC_vendorname'],
            (php72_cmp($data['0']['available_status']) == 1) ? 'Available' : getEmployeeName($data['0']['available_status']));

        $data1 = array('org' => $org,
            'replace' => $replace,
            'employeeEmail' => '',
            'adminEmail' => $adminEmail,
            'toEmail' => $adminEmail);
        return $data1;
    }

    //End Assets Master
    //Start Template Master
    function insertTemplate() {
        $data = array('messagetype' => $this->input->post('messagetype'),
            'messagesubject' => $this->input->post('messagesubject'),
            'messagebody' => $this->input->post('messagebody'));
        $result = $this->db->insert('mailtemplate', $data);
        return $result;
    }

    function updateTemplate() {
        $data = array(
            'messagesubject' => $this->input->post('messagesubject'),
            'messagebody' => $this->input->post('messagebody'));
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('mailtemplate', $data);
        return $result;
    }

    function getMailTemplate($messageType) {
        $data = array();
        $this->db->where('messagetype', $messageType);
        $query = $this->db->get('mailtemplate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    //End Template Master
    //Start Custome Report Master
    function insertReportData() {
        $data = array('report_type' => $this->input->post('report_type'),
            'report_name' => $this->input->post('report_name'),
            'report_data' => serialize($_POST['report_data']));
        $this->db->insert('master_report', $data);
        return $this->db->insert_id();
    }

    function updateReports() {
        $data = array('report_type' => $this->input->post('report_type'),
            'report_name' => $this->input->post('report_name'),
            'report_data' => serialize($_POST['report_data']));
        $this->db->where('report_id', $this->input->post('report_id'));
        $this->db->update('master_report', $data);
        return $this->db->insert_id();
    }

    function getReportList($report_type) {
        $data = array();
        $this->db->where('report_type', $report_type);
        $query = $this->db->get('master_report');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function customExport($custom_report, $rowExport, $print = NULL) {
        $getReportData = $this->Mcommon->getRecords('master_report', 'report_id', $custom_report);
        $report_data = unserialize($getReportData['0']['report_data']);
        $reporttype = $this->config->item($getReportData['0']['report_type']);
        $sum_rows = array();
        $headerArray = array('S.No');
        foreach ($report_data as $key => $value) {
            array_push($headerArray, $reporttype[$value]);
        }
        if ($headerArray['20'] == 'Is expense estimated in work plan')
            $headerArray['21'] = 'Is expense above 50000';
        for ($i = 0; $i < php72_count($rowExport); $i++) {
            $dataArray[$i] = array();
            array_push($dataArray[$i], ($i + 1));
            foreach ($report_data as $key => $value) {
                $more_option = explode('#', $value);
                if (count($more_option) == '2') {
                    if ($more_option['1'] == 'date')
                        $reportValue = mysql2ddmmyyyy(@$rowExport[$i][$more_option['0']]);
                    if ($more_option['1'] == 'employee') {
                        if (@$rowExport[$i][$more_option['0']] == "0")
                            $reportValue = @$rowExport[$i]["other_" . $more_option['0']];
                        else
                            $reportValue = (strpos(@$rowExport[$i][$more_option['0']], 'SR')) ? getEmployeeName(@$rowExport[$i][$more_option['0']]) : @$rowExport[$i][$more_option['0']];
                    }
                    if ($more_option['1'] == 'master') {
                        if (@php72_cmp($rowExport[$i][$more_option['0']]) == 0)
                            $reportValue = @$rowExport[$i]["other_" . $more_option['0']];
                        else
                            $reportValue = showMaster(@$rowExport[$i][$more_option['0']]);
                    }
                    if ($more_option['1'] == 'sum') {
                        if (isset($rowExport[$i][$more_option['0']]))
                            $reportValue = $rowExport[$i][$more_option['0']];
                    }
                } else {
                    $reportValue = @$rowExport[$i][$value];
                }
                array_push($dataArray[$i], $reportValue);
            }
        }
        $sum_columns[] = '0';
        foreach ($report_data as $row) {
            $pos = strrpos($row, "sum");
            if ($pos)
                $sum_columns[] = '1';
            else
                $sum_columns[] = '0';
        }
        foreach ($dataArray as $key1 => $value1):
            foreach ($value1 as $key => $value):
                if (php72_cmp($sum_columns[$key]) == 0)
                    $sum_value[$key] = '';
                else
                    @$sum_value[$key] += $value;
            endforeach;
        endforeach;

        if (php72_in_array('1', $sum_columns))
            $sum_value['0'] = 'Total';
        $lent = php72_count($dataArray);
        $dataArray[$lent] = array();
        foreach ($sum_value as $key => $value):
            array_push($dataArray[$lent], $value);
        endforeach;
        for ($i = 0; $i < php72_count($dataArray); $i++) {
            if (!empty($data[$i]['3'])) {
                $dataArray[$i]['3'] = date('d/m/Y', strtotime($dataArray[$i]['3']));
            }
            if ($dataArray[$i]['18'] == '0') {
                $dataArray[$i]['18'] = '';
            }

            if ($dataArray[$i]['19'] == '0') {
                $dataArray[$i]['19'] = '';
            }

            if ($headerArray['20'] == 'Is expense estimated in work plan') {
                $this->db->where("approval_no", $dataArray[$i]['1']);
                $query = $this->db->get("approval_note");
                $values = $query->result_array();
                $dataArray[$i]['21'] = $values[0]['above_50000'];
            }
        }
        if ($print == NULL)
            dataarray_to_excel($headerArray, $dataArray);
        else {
            $data['headerArray'] = $headerArray;
            $data['dataArray'] = $dataArray;
            return $data;
        }
    }

    //End Custome Report Master
    // Start business card data base
    function insertBusinessCard() {
        $data = array('source' => $this->input->post('source'),
            'category' => $this->input->post('category'),
            'name' => $this->input->post('name'),
            'designation' => $this->input->post('designation'),
            'company_name' => $this->input->post('company_name'),
            'add1' => $this->input->post('add1'),
            'add2' => $this->input->post('add2'),
            'add3' => $this->input->post('add3'),
            'city' => $this->input->post('city'),
            'pin_code' => $this->input->post('pin_code'),
            'telephone' => $this->input->post('telephone'),
            'mobile' => $this->input->post('mobile'),
            'fax' => $this->input->post('fax'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website'),
            'added_date' => ddmmyyyy2mysql(date("d/m/Y")),
            'added_by' => $this->session->userdata('user'));
        $result = $this->db->insert('business_card', $data);
        return $result;
    }

    function updateBusinessCard() {
        $data = array('source' => $this->input->post('source'),
            'category' => $this->input->post('category'),
            'name' => $this->input->post('name'),
            'designation' => $this->input->post('designation'),
            'company_name' => $this->input->post('company_name'),
            'add1' => $this->input->post('add1'),
            'add2' => $this->input->post('add2'),
            'add3' => $this->input->post('add3'),
            'city' => $this->input->post('city'),
            'pin_code' => $this->input->post('pin_code'),
            'telephone' => $this->input->post('telephone'),
            'mobile' => $this->input->post('mobile'),
            'fax' => $this->input->post('fax'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website'),
            'last_updated' => ddmmyyyy2mysql(date("d/m/Y")));
        $this->db->where('card_id', $this->input->post('card_id'));
        $result = $this->db->update('business_card', $data);
        return $result;
    }

    function getVisitorsCount() {
        $data = array();
        $q = "select count(*) as total from business_card where MONTH(added_date) ='" . date('m') . "' and YEAR(added_date) ='" . date('Y') . "'";
        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    //End Business Card Database
    //Start Visiterlog Section
    function insertVisitorsLog() {
        $data = array('date' => ddmmyyyy2mysql($this->input->post('date')),
            'name_of_visitor' => $this->input->post('name_of_visitor'),
            'name_of_organization' => $this->input->post('name_of_organization'),
            'intending_to_meet' => $this->input->post('intending_to_meet'),
            'other_intending_to_meet' => $this->input->post('other_intending_to_meet'),
            'purpose' => $this->input->post('purpose'),
            'time_in' => $this->input->post('time_in'),
            'time_out' => $this->input->post('time_out'),
            'innovation' => $this->input->post('innovation'));
        $result = $this->db->insert('visitors_log', $data);
        return $result;
    }

    function updateVisitorsLog() {
        $data = array('date' => ddmmyyyy2mysql($this->input->post('date')),
            'name_of_visitor' => $this->input->post('name_of_visitor'),
            'name_of_organization' => $this->input->post('name_of_organization'),
            'intending_to_meet' => $this->input->post('intending_to_meet'),
            'other_intending_to_meet' => $this->input->post('other_intending_to_meet'),
            'purpose' => $this->input->post('purpose'),
            'time_in' => $this->input->post('time_in'),
            'time_out' => $this->input->post('time_out'),
            'innovation' => $this->input->post('innovation'));
        $this->db->where('log_id', $this->input->post('log_id'));
        $result = $this->db->update('visitors_log', $data);
        return $result;
    }

    function getContactCount() {
        $data = array();
        $q = "select count(*) as total from visitors_log where MONTH(date) ='" . date('m') . "' and YEAR(date) ='" . date('Y') . "'";
        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    //End Visiterlog Section

    function getDonorDetail() {
        $data = array();
        $this->db->select("*");
        $this->db->where('status !=', '-1');
        $this->db->where('master_type', 'Donor');
        $this->db->order_by('master_name');
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /*     * ****** Master Donor **** */

    /*     * *** Financial year *** */

    function insertFinancialYear() {
        $data = array(
            'from' => $this->input->post('startDate'),
            'to' => $this->input->post('endDate'),
            'partner_id' => $this->session->userdata('partner_id'),
            'status' => '0');
        $result = $this->db->insert('financial_year', $data);
        return $result;
    }

    function updateFinancialYear() {
        $data = array(
            'from' => $this->input->post('startDate'),
            'to' => $this->input->post('endDate'),
            'status' => '1');
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('financial_year', $data);
        return $result;
    }

    function findCurrentFinancialYear() {
        $data = array();
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->db->get('financial_year');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function totalfinancialYear() {
        $data = array();
        $this->db->select('*');
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->db->get('financial_year');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /*     * *** End ** */

    /*     * **** Donor Amount ** */

    function getdonoramountRecords($val, $from = NULL, $to = NULL) {
        $data = array();
        $this->db->select('MS.master_name,DA.*,sum(DA.amount) as amount');
        $this->db->join('master_settings MS', 'MS.master_id=DA.donor_id', 'left');
        $this->db->where('MS.master_type', 'Donor');
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $this->db->where('DA.partner_id', $this->session->userdata('partner_id'));
        $this->db->group_by('DA.donor_id,');
        $query = $this->db->get('donors_amount DA');

        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function getsingledonoramountRecords($val, $from = NULL, $to = NULL) {
        $data = array();
        $this->db->select('MS.master_name,DA.*');
        $this->db->join('master_settings MS', 'MS.master_id=DA.donor_id', 'left');
        $this->db->where('MS.master_type', 'Donor');
        $this->db->where('donor_id', $val['donorid']);
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $query = $this->db->get('donors_amount DA');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    /*     * ** End ** */

    /*     * ** Balance ** */

    function getsearchLimitRecords($val = NULL, $wher) {
        $data = array();
        $this->misdb = $this->load->database('mis', TRUE);
        $this->db->select('D1A.*,MP.programme,D.master_name,GL.name as grant_name,D2A.master_name as budget_head,D3A.master_name as line_item,
			D4A.master_name as Subline_item,sum(D1A.amount) as amount');
        $this->db->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->db->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->db->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->db->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->db->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->db->join($this->misdb->database . ".grant_list GL on GL.id = D1A.grant_id", 'left');
        $this->db->where('D.partner_id', $this->session->userdata('partner_id'));
        if ($val['where'] != '')
            $this->db->where($val['where']);
        if ($val['export'] == 'no')
        //	$this->db->limit($val['num'],$val['offset']);
            if ($val['orderby'] != '' && $val['ordertype'] != '')
                $this->db->order_by($val['orderby'], $val['ordertype']);
        $this->db->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');
        $this->db->limit($val['num'], $val['offset']);
        $query = $this->db->get('master_programme MP');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function gettotalsearchLimitRecords($val = NULL, $wher) {
        $data = array();
        $this->db->select('D1A.*,MP.programme,D.master_name,D2A.master_name as budget_head,D3A.master_name as line_item,
			D4A.master_name as Subline_item,sum(D1A.amount) as amount');
        $this->db->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->db->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->db->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->db->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->db->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->db->where('D.partner_id', $this->session->userdata('partner_id'));
        if ($val['where'] != '')
            $this->db->where($val['where']);
        if ($val['export'] == 'no')
            $this->db->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid');
        $query = $this->db->get('master_programme MP');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $query->num_rows();
    }

    function getAdditionalInfo($programme, $donor, $budgethead, $lineitem = 'NULL', $sublineitem = 'NULL') {
        $data = array();
        $this->db->select('additionalinfo');
        $this->db->where('programme', $programme);
        $this->db->where('donor', $donor);
        $this->db->where('budgethead', $budgethead);
        $this->db->where('lineitem', $lineitem);
        $this->db->where('subitem', $sublineitem);
        $query = $this->db->get('additional_info');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        $data_val['add_info'] = "";
        if (isset($data['0'])) {
            foreach ($data as $key => $value) {
                $data_val['add_info'] .= @$value['additionalinfo'] . ",";
                $data_val['add_info_value'] = substr($data_val['add_info'], 0, 15) . "..";
            }
            return $data_val;
        } else {
            return '';
        }
    }

    /*     * ** End ** */

    /*     * *** For checking approval amount *** */

    function checkApprovalNoteAmount($programme, $donor, $budgethead, $lineitem = 'NULL', $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {
        $data = array();
        $this->db->select('sum(amt_required)as totalamount');
        $this->db->join('approval_note AN', 'AN.approval_id=ANDO.approval_id');
        if ($programme != "") {
            $this->db->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->db->where('ANDO.donor', $donor);
        }
        if ($budgethead != "") {
            $this->db->where('ANDO.budget_head', $budgethead);
        }
        if ($lineitem != '') {
            $this->db->where('ANDO.line_item', $lineitem);
        }
        if ($grant_id != '') {
            $this->db->where('ANDO.grant_id', $grant_id);
        }
        $this->db->where('AN.status !=', 'cancelled');  // newly added on 29/5/14
        $this->db->where("EXTRACT(YEAR_MONTH FROM date_of_request)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM date_of_request)  <= '$to'");
        $query = $this->db->get('approval_note_donors ANDO');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();

        return $data['0']['totalamount'];
    }

    /*     * *** End*** */

    /*     * ** For checking Internal Amount ** */
	
	function checkInternalAmtManual($programme, $donor,$grant_id){
		$data = array();
        $this->db->distinct();
        $this->db->select('sum(amount_toapprove)as totalamount');
        $this->db->join('approval_note AN', 'AN.approval_id=INTER.approval_id', 'left');
        if ($programme != "") {
            $this->db->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->db->where('INTER.donor', $donor);
        }
        if ($grant_id != "") {
            $this->db->where('INTER.grant_id', $grant_id);
        }

        $this->db->where('INTER.status !=', 'cancelled'); 
        $query = $this->db->get('internal_note INTER');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['totalamount'];
	}
	
	function checkApprovalNoteAmtManual($programme, $donor, $grant_id = '') {
		
        $data = array();
        $this->db->select('sum(amt_required)as totalamount');
		#$this->db->select('*');
        $this->db->join('approval_note AN', 'AN.approval_id=ANDO.approval_id');
        if ($programme != "") {
            $this->db->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->db->where('ANDO.donor', $donor);
        }
        if ($grant_id != '') {
            $this->db->where('ANDO.grant_id', $grant_id);
        }
        $this->db->where('AN.status !=', 'cancelled');
        $query = $this->db->get('approval_note_donors ANDO');
		#echo'<pre>';print_r($query->result());die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['totalamount'];
    }

    function checkInternalAmount($programme, $donor, $budgethead, $lineitem, $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {
        $data = array();
        $this->db->distinct();
        $this->db->select('sum(amount_toapprove)as totalamount');
        $this->db->join('approval_note AN', 'AN.approval_id=INTER.approval_id', 'left');
        if ($programme != "") {
            $this->db->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->db->where('INTER.donor', $donor);
        }
        if ($budgethead != "") {
            $this->db->where('INTER.budget_head', $budgethead);
        }
        if ($lineitem != "") {
            $this->db->where('INTER.line_item', $lineitem);
        }
        if ($sublineitem != "") {
            $this->db->where('INTER.cost_centre', $sublineitem);
        }
        if ($grant_id != "") {
            $this->db->where('INTER.grant_id', $grant_id);
        }

        $this->db->where('INTER.status !=', 'cancelled');  // newly added on 29/5/14
        $this->db->where("EXTRACT(YEAR_MONTH FROM AN.date_of_request)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM AN.date_of_request)  <= '$to'");
        $query = $this->db->get('internal_note INTER');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['totalamount'];
    }

    /*     * * End ** */

    function checkRecoveredAmount($programme, $donor, $budgethead, $lineitem, $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {

        $data = array();
        $this->db->select('sum(AD.amount_recovered)as sumamount');
        $this->db->join('recovered_amount RA', 'RA.id=AD.recover_id', 'left');
        if ($programme != "") {
            $this->db->where('RA.programme', $programme);
        }
        if ($donor != "") {
            $this->db->where('RA.donor', $donor);
        }
        if ($budgethead != "") {
            $this->db->where('RA.budget_head', $budgethead);
        }
        if ($lineitem != "") {
            $this->db->where('RA.line_item', $lineitem);
        }
        if ($sublineitem != "") {
            $this->db->where('RA.sub_line_item', $sublineitem);
        }
		
        if ($grant_id != "") {
            $this->db->where('RA.grant_id', $grant_id);
        }

        $this->db->where("EXTRACT(YEAR_MONTH FROM AD.recovered_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM AD.recovered_date)  <= '$to'");
        $query = $this->db->get('recovered_amount_detail AD');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['sumamount'];
    }

    /*     * **** For inserting amount in line item ** */

    function insertlineitemAmount($options = array()) { 
        foreach ($options['amount'] as $key => $value):
			
			
            if ($options['eventid'][$key] == '') {
                $data = array('programme_id' => $this->input->post('programme'),
                    'donor_id' => $this->input->post('donor'),
                    'grant_id' => $this->input->post('grant'),
                    'budget_id' => $options['budgethead'][$key],
                    'line_itemid' => $options['lineitem'][$key],
                    'subline_itemid' => $options['Sublineitem'][$key],
                    'amount' => $options['amount'][$key],
                    'amount_date' => ddmmyyyy2mysql($this->input->post('date'))
                );

                $data1 = array('programme_id' => $this->input->post('programme'),
                    'donor_id' => $this->input->post('donor'),
                    'grant_id' => $this->input->post('grant'),
                    'budget_id' => $options['budgethead'][$key],
                    'line_itemid' => $options['lineitem'][$key],
                    'subline_itemid' => $options['Sublineitem'][$key],
                    'operation' => 'Added',
                    'amount' => $options['amount'][$key],
                    'ipaddress' => $_SERVER['REMOTE_ADDR'],
                    'amount_date' => ddmmyyyy2mysql($this->input->post('date'))
                );
				
				#echo'<pre>';print_r($data);
                $result2 = $this->db->insert('balance_amount', $data);
                $resultaction = $this->db->insert('masteramount_actionhistory', $data1);
                $id = $this->db->insert_id();

            } else { #echo'<pre>';print_r($_POST);
                $dataedit = array(
                    'programme_id' => $this->input->post('programme'),
                    'donor_id' => $this->input->post('donor'),
					'grant_id' => $this->input->post('grant'),
                    'budget_id' => $options['budgethead'][$key],
                    'line_itemid' => $options['lineitem'][$key],
                    'subline_itemid' => $options['Sublineitem'][$key],
                    'amount' => $options['amount'][$key],
                    'amount_date' => ddmmyyyy2mysql($this->input->post('date'))
                );
				
                if (php72_cmp($options['amountchanged'][$key]) == 1) {
                    $data3 = array(
                        'programme_id' => $this->input->post('programme'),
                        'donor_id' => $this->input->post('donor'),
                        'budget_id' => $options['budgethead'][$key],
                        'line_itemid' => $options['lineitem'][$key],
                        'subline_itemid' => $options['Sublineitem'][$key],
                        'operation' => 'updation',
                        'amount' => $options['amount'][$key],
                        'ipaddress' => $_SERVER['REMOTE_ADDR'],
                        'amount_date' => ddmmyyyy2mysql($this->input->post('date'))
                    );
					
                    $result2 = $this->db->insert('masteramount_actionhistory', $data3);
                }
				echo $options['eventid'][$key];
                $this->db->where('id', $options['eventid'][$key]);
                $result = $this->db->update('balance_amount', $dataedit);
            }
			/* echo'<pre>';print_r($key);
			echo'<pre>';print_r($options['old_BH']);die; */
            if (isset($options['changereason'])) {
                if (php72_array_key_exists($key, $options['old_BH'])) {
                    if (($this->input->post('programme') != $this->input->post('old_program')) || ($this->input->post('donor') != $this->input->post('old_donor')) || ($options['budgethead'][$key] != $options['old_BH'][$key]) || ($options['lineitem'][$key] != $options['old_LI'][$key]) || ($options['Sublineitem'][$key] != $options['old_SLI'][$key]) || ($options['amount'][$key] != $options['old_amount'][$key])) {
                        $change = array(
                            'programme_id' => $this->input->post('programme'),
                            'donor_id' => $this->input->post('donor'),
                            'budget_id' => $options['budgethead'][$key],
                            'line_itemid' => $options['lineitem'][$key],
                            'subline_itemid' => $options['Sublineitem'][$key],
                            'amount' => $options['amount'][$key],
                            'pre_programme_id' => $this->input->post('old_program'),
                            'pre_donor_id' => $this->input->post('old_donor'),
                            'pre_budget_id' => $options['old_BH'][$key],
                            'pre_line_itemid' => $options['old_LI'][$key],
                            'pre_subline_itemid' => $options['old_SLI'][$key],
                            'pre_amount' => $options['old_amount'][$key],
                            'reason' => $options['changereason'],
                            'ipaddress' => $_SERVER['REMOTE_ADDR']
                        );
                        $result3 = $this->db->insert('balance_sheet_edit_history', $change);
                    }
                } else {
                    if ((!php72_array_key_exists($key, $options['old_BH']) && php72_array_key_exists($key, $options['budgethead'])) && (!php72_array_key_exists($key, $options['old_LI']) && php72_array_key_exists($key, $options['lineitem'])) && (!php72_array_key_exists($key, $options['old_SLI']) && php72_array_key_exists($key, $options['Sublineitem'])) && (!php72_array_key_exists($key, $options['old_amount']) && php72_array_key_exists($key, $options['amount']))) {
                        $changes = array(
                            'programme_id' => $this->input->post('programme'),
                            'donor_id' => $this->input->post('donor'),
                            'budget_id' => $options['budgethead'][$key],
                            'line_itemid' => $options['lineitem'][$key],
                            'subline_itemid' => $options['Sublineitem'][$key],
                            'amount' => $options['amount'][$key],
                            'reason' => $options['changereason'],
                            'ipaddress' => $_SERVER['REMOTE_ADDR']
                        );
                        $result3 = $this->db->insert('balance_sheet_edit_history', $changes);
                    }
                }
            } 
        endforeach;
        return true;
    }

    /*     * ** End ** */

    function insertdeletehistory($id) {
        $reason = ($this->uri->segment(10) != '') ? $this->uri->segment(10) : '';
        $balance_detail = $this->getbalanceamount($id);
        $changes = array(
            'pre_programme_id' => $balance_detail[0]['programme_id'],
            'pre_donor_id' => $balance_detail[0]['donor_id'],
            'pre_budget_id' => $balance_detail[0]['budget_id'],
            'pre_line_itemid' => $balance_detail[0]['line_itemid'],
            'pre_subline_itemid' => $balance_detail[0]['subline_itemid'],
            'pre_amount' => $balance_detail[0]['amount'],
            'reason' => $reason,
            'ipaddress' => $_SERVER['REMOTE_ADDR']
        );
        $result3 = $this->db->insert('balance_sheet_edit_history', $changes);
        return $result3;
    }

    function getbalanceamount($id) {
        $this->db->select('programme_id,donor_id,budget_id,line_itemid,subline_itemid,amount');
        $this->db->where('id', $id);
        $query = $this->db->get('balance_amount');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    /*     * *** Amount Transfer and Amount Action History ** */

    function insertdonorAmountMultiple() {
        $data = array('donor_id' => $this->input->post('donor'),
            'amount' => $this->input->post('amount'),
            'partner_id' => $this->session->userdata('partner_id'),
            'amount_date' => ddmmyyyy2mysql($this->input->post('date')));

        $data1 = array(
            'donor_id' => $this->input->post('donor'),
            'amount' => $this->input->post('amount'),
            'amount_date' => ddmmyyyy2mysql($this->input->post('date')),
            'ipaddress' => $_SERVER['REMOTE_ADDR']
        );

        $resultaction = $this->db->insert('donoramount_actionhistory', $data1);
        $result = $this->db->insert('donors_amount', $data);
        return $result;
    }

    function getAmountActionHistory($from, $to, $num, $offset) {
        $data = array();
        $this->db->select('MA.*,MP.programme,D.master_name,D2A.master_name as budget_head,D3A.master_name as line_item');
        $this->db->join('master_programme MP', 'MP.programme_id=MA.programme_id', 'left');
        $this->db->join('master_settings D', 'D.master_id=MA.donor_id', 'left');
        $this->db->join('master_settings D2A', 'D2A.master_id=MA.budget_id', 'left');
        $this->db->join('master_settings D3A', 'D3A.master_id=MA.line_itemid', 'left');
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $this->db->where('D.partner_id', $this->session->userdata('partner_id'));
        $this->db->limit($num, $offset);
        $query = $this->db->get('masteramount_actionhistory MA');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    function gettotalAmountActionHistory($val, $from, $to) {
        $data = array();
        $this->db->select('MA.*,MP.programme,D.master_name,D2A.master_name as budget_head,D3A.master_name as line_item');
        $this->db->join('master_programme MP', 'MP.programme_id=MA.programme_id', 'left');
        $this->db->join('master_settings D', 'D.master_id=MA.donor_id', 'left');
        $this->db->join('master_settings D2A', 'D2A.master_id=MA.budget_id', 'left');
        $this->db->join('master_settings D3A', 'D3A.master_id=MA.line_itemid', 'left');
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $this->db->where('D.partner_id', $this->session->userdata('partner_id'));

        $query = $this->db->get('masteramount_actionhistory MA');
        return $query->num_rows();
    }

    function getdonoramountHistory($from, $to) {
        $data = array();
        $this->db->select('DA.*,D.master_name,');
        $this->db->join('master_settings D', 'D.master_id=DA.donor_id', 'left');
        $this->db->where('D.partner_id', $this->session->userdata('partner_id'));
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $query = $this->db->get('donoramount_actionhistory DA');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function findTransferSubLineItem() {
        $data = array();
        $query = "SELECT * FROM `master_settings` WHERE `master_type`='Cost Centre' and master_name LIKE '%transfer%'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data[0]['master_id'];
    }

    function addtransferDonorAmount() {
        $programme = $this->input->post('programme');
        $donorid = $this->input->post('donorid');
        $budgetid = $this->input->post('budgetid');
        $amount_date = ddmmyyyy2mysql($this->input->post('amountdate'));
        $amount = $this->input->post('amount');
        $lineitem = $this->input->post('lineitem');
        $sublineitem = $this->input->post('sublineitem');
        $transfersublineitem = $this->input->post('transfersublineitem');
        if ($this->input->post('to') != '') {
            $to = $this->input->post('to');
            $toyeararr = explode(" ", $to);
            $toyear = $toyeararr[1];
            $modified_date = $toyear . '-03-03';
        }

        $data = array(
            'programme_id' => $programme,
            'donor_id' => $donorid,
            'budget_id' => $budgetid,
            'line_itemid' => $lineitem,
            'subline_itemid' => $sublineitem,
            'amount' => $amount,
            'amount_date' => $amount_date);

        $data2 = array(
            'programme_id' => $programme,
            'donor_id' => $donorid,
            'budget_id' => $budgetid,
            'line_itemid' => $lineitem,
            'subline_itemid' => $transfersublineitem,
            'amount' => -$amount,
            'amount_date ' => $modified_date);

        $result = $this->db->insert('balance_amount', $data);
        $result2 = $this->db->insert('balance_amount', $data2);
        return $result;
    }

    function getamountrequired($donor = NULL) {
        $query = "select sum(amt_required) from approval_note_donors where donor = '" . $donor . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function findTotalDonorAmount($programme = 'NULL', $donorid = 'NULL', $budgetid = 'NULL', $from = 'NULL', $to = 'NULL') {
        $data = array();
        $this->db->select("sum(amount)as totalamount");
        $this->db->where('programme_id', $programme);
        $this->db->where('donor_id', $donorid);
        $this->db->where('budget_id', $budgetid);
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $query = $this->db->get('balance_amount');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['totalamount'];
    }

    function checkAmountAssigned($programmeid, $donorid, $budgetid, $lineitemid, $sublinelitem, $from, $to, $grant_id) {
		#echo$programmeid;echo'-'; echo $donorid;echo$budgetid;echo'-'; echo $lineitemid;echo'-'; echo $sublinelitem;echo'-'; echo $grant_id;
        $this->db->select('sum(amount)as amount');
        $this->db->where('programme_id', $programmeid);
        /* newly added on 29/5/14 */
        if ($donorid != '') {
            $this->db->where('donor_id', $donorid);
        }
        if ($budgetid != '') {
            $this->db->where('budget_id', $budgetid);
        }
        if ($lineitemid != '') {
            $this->db->where('line_itemid', $lineitemid);
        }
        if ($sublinelitem != '') {
            $this->db->where('subline_itemid', $sublinelitem);
        }
        if ($grant_id != '') {
            $this->db->where('grant_id', $grant_id);
        }
        /* newly added on 29/5/14 end */
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $query = $this->db->get('balance_amount');
        #echo '<pre>';print_r($query->result());die;
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data[0]['amount'];
    }

    function findopenamt($options = array(), $where = NULL) {
        $data = array();
        $this->db->select('AN.approval_no,AN.purpose,AN.date_of_request');
        $this->db->select('I.approval_id,I.status,I.reason_payment_sougnt,I.date,I.internal_no,I.amount_toapprove as total,I.total_amount as amt_required');
        $this->db->select('MP.programme');
        $this->db->select('MS.master_name as donor,MSB.master_name as budget_head,MSL.master_name as line_item');
        $this->db->select('MSC.master_name as sub_line_item');
        $this->db->join('approval_note AN', 'I.approval_id = AN.approval_id');
        $this->db->join('approval_note_donors AP', 'AN.approval_id  = AP.approval_id', 'left');
        $this->db->join('master_settings MS', 'MS.master_id = AP.donor', 'left');
        $this->db->join('master_settings MSB', 'MSB.master_id = AP.budget_head', 'left');
        $this->db->join('master_settings MSL', 'MSL.master_id = AP.line_item', 'left');
        $this->db->join('master_settings MSC', 'MSC.master_id = AP.cost_centre', 'left');
        $this->db->join('master_programme MP', 'MP.programme_id = AN.programme', 'left');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->group_by('I.internal_id');

        $this->db->order_by('AN.approval_no DESC');

        $query = $this->db->get('internal_note I');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }

    function countfindopenamt() {
        $data = array();
        $query = "SELECT MP.programme,AN.approval_no,I.approval_id,I.internal_no,I.amount_toapprove as amount_approve,
            I.total_amount FROM `internal_note` as I JOIN approval_note as AN ON(I.approval_id = AN.approval_id) JOIN master_programme as MP ON(MP.programme_id = AN.programme)
            ORDER BY `AN`.`approval_no` ASC";
        $result = $this->db->query($query);
        return $result->num_rows();
    }

    function donorAmountAssigned($donorid) {
        $data = array();
        $this->db->select('sum(amount)as amount');
        $this->db->where('donor_id', $donorid);
        $query = $this->db->get('donors_amount');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data[0]['amount'];
    }

    function donorAmountUsed($donorid) {
        $data = array();
        $this->db->select('sum(amount)as amount');
        $this->db->where('donor_id', $donorid);
        $query = $this->db->get('balance_amount');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data[0]['amount'];
    }

    function findopenamt_new() {
        $data = array();
        $this->db->select('AN.approval_id,AN.approval_no,AN.purpose,AN.date_of_request,AN.from_employee');
        $this->db->select('MP.programme');
        $this->db->join('master_programme MP', 'MP.programme_id = AN.programme', 'left');
        $searchArray[] = "AN.status = 'confirmed'";
        if ($this->input->post('Programme')) {
            $searchArray[] = "MP.programme like '%" . $this->input->post('Programme') . "%'";
        }
        if ($this->input->post('from_date')) {
            $from = explode('/', $this->input->post('from_date'));
            $fromdate = $from[2] . '-' . $from[1] . '-' . $from[0];
            $searchArray[] = "AN.date_of_request >= '" . $fromdate . "'";
        }
        if ($this->input->post('to_date')) {
            $to = explode('/', $this->input->post('to_date'));
            $todate = $to[2] . '-' . $to[1] . '-' . $to[0];
            $searchArray[] = "AN.date_of_request <= '" . $todate . "'";
        }

        $where = php72_implode(" AND ", $searchArray);
        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->order_by('AN.approval_no DESC');
        $query = $this->db->get('Approval_note AN');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }

    function findopenamount_new_ajax_count($where) {
        $query = "select AD.donor as addonor,AD.budget_head as adbudget_head,AD.line_item as adline_item,AD.cost_centre as adcost_centre, AD.amt_required as adamt_required, AD.amt_available as adamt_available, AD.approval_id as adapproval_id,OAN.approval_id,OAN.approval_no,OAN.purpose,OAN.date_of_request,OAN.from_employee,MP.programme  , MS.master_name as donor_name, MSB.master_name as budget_head_name, MSL.master_name as line_item_name, MSC.master_name as sub_line_item_name,I.donor as indonor,I.budget_head as inbudget_head, I.line_item as inline_item, I.cost_centre as incost_centre, I.status,I.reason_payment_sougnt, I.date as indate,I.approval_id as inapproval_id, I.internal_no,I.amount_toapprove as total,I.total_amount as amt_required
                    from approval_note as OAN
                    join master_programme MP ON MP.programme_id = OAN.programme
                    JOIN approval_note_donors AD ON AD.approval_id = OAN.approval_id
                    JOIN master_settings MS ON MS.master_id = AD.donor
                    JOIN master_settings MSB ON MSB.master_id = AD.budget_head
                    JOIN master_settings MSL ON MSL.master_id = AD.line_item
                    LEFT OUTER JOIN master_settings MSC ON MSC.master_id = AD.cost_centre
                    LEFT OUTER JOIN internal_note I ON I.approval_id = OAN.approval_id AND I.donor =AD.donor
                    AND I.budget_head = AD.budget_head AND I.line_item = AD.line_item
                    AND I.cost_centre = AD.cost_centre AND I.status != 'cancelled'
                    WHERE OAN.approval_id in (select if(COALESCE(AN_S.AN_Amount, 0) - COALESCE(IN_S.IN_Amount, 0) > 0 ,AN.approval_id,NULL) as Approval_id from approval_note as AN
                    LEFT OUTER JOIN (select approval_id, sum(amount_toapprove) as IN_Amount FROM internal_note group by approval_id) as IN_S ON AN.approval_id = IN_S.approval_id
                    JOIN (select approval_id, sum(amt_required) as AN_Amount FROM approval_note_donors group by approval_id) as AN_S ON AN.approval_id =AN_S.approval_id
                    where AN.approval_id = OAN.approval_id order by AN.approval_id)";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        $query .= "order by OAN.approval_no desc";
        $result = $this->db->query($query);
        return $result->num_rows();
    }

    function findopenamt_new_ajax($options, $where, $export = NULL) {
        $data = array();
        $query = "select distinct I.internal_no, AD.donor as addonor,AD.budget_head as adbudget_head,AD.line_item as adline_item,AD.cost_centre as adcost_centre, AD.additionalinfo, AD.amt_required as adamt_required, AD.amt_available as adamt_available, AD.approval_id as adapproval_id,OAN.approval_id,OAN.approval_no,OAN.purpose,OAN.date_of_request,OAN.from_employee,MP.programme  , MS.master_name as donor_name, MSB.master_name as budget_head_name, MSL.master_name as line_item_name, MSC.master_name as sub_line_item_name, AI.additionalinfo as detail, I.donor as indonor,I.budget_head as inbudget_head, I.line_item as inline_item, I.cost_centre as incost_centre, I.status,I.reason_payment_sougnt, I.date as indate,I.approval_id as inapproval_id, I.amount_toapprove as total,I.total_amount as amt_required
                    from approval_note as OAN
                    LEFT OUTER join master_programme MP ON MP.programme_id = OAN.programme
                    LEFT OUTER JOIN approval_note_donors AD ON AD.approval_id = OAN.approval_id
                    LEFT OUTER JOIN additional_info AI ON AI.id = AD.additionalinfo
                    LEFT OUTER JOIN master_settings MS ON MS.master_id = AD.donor
                    LEFT OUTER JOIN master_settings MSB ON MSB.master_id = AD.budget_head
                    LEFT OUTER JOIN master_settings MSL ON MSL.master_id = AD.line_item
                    LEFT OUTER JOIN master_settings MSC ON MSC.master_id = AD.cost_centre
                    LEFT OUTER JOIN internal_note I ON I.approval_id = OAN.approval_id AND I.donor =AD.donor
                    AND I.budget_head = AD.budget_head AND I.line_item = AD.line_item
                    AND I.cost_centre = AD.cost_centre AND I.status != 'cancelled'
                    WHERE OAN.approval_id in (select if(COALESCE(AN_S.AN_Amount, 0) - COALESCE(IN_S.IN_Amount, 0) > 0 ,AN.approval_id,NULL) as Approval_id from approval_note as AN
                    LEFT OUTER JOIN (select approval_id, sum(amount_toapprove) as IN_Amount FROM internal_note group by approval_id) as IN_S ON AN.approval_id = IN_S.approval_id
                    JOIN (select approval_id, sum(amt_required) as AN_Amount FROM approval_note_donors group by approval_id) as AN_S ON AN.approval_id =AN_S.approval_id
                    where AN.approval_id = OAN.approval_id and AN.partner_id = " . $this->session->userdata('partner_id') . "
                    order by AN.approval_id)";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        $query .= "order by OAN.approval_no desc";
        if (isset($options['num']) && isset($options['offset']))
            $query .= " limit " . $options['offset'] . "," . $options['num'];

        $query_ex = $this->db->query($query);
        $total = $this->findopenamount_new_ajax_count($where);
        $j = $_POST['iDisplayStart'];
        foreach ($query_ex->result_array() as $row) {
            $donor = array('donor' => $row['addonor'], 'budget_head' => $row['adbudget_head'], 'line_item' => $row['adline_item'], 'cost_centre' => $row['adcost_centre']);
            $IN_sum = $this->getinternalamt_new($row['approval_id']);
            $AN_sum = $this->getAntotal_amount($row['approval_id']);
            $donor_IN_sum = $this->getinternalamt_donor($row['approval_id'], $donor);
            $amount_diff = $AN_sum[0]['total_AN_amount'] - $IN_sum[0]['sum'];
            $employee = getEmployeeName($row['from_employee']);
            $employee = ($employee != "") ? $employee : '-';
            $date_of_request = date("d/m/Y", strtotime($row['date_of_request']));
            if ($row['indonor'] == $row['addonor'] && $row['inbudget_head'] == $row['adbudget_head'] && $row['incost_centre'] == $row['adcost_centre'] && $row['inline_item'] == $row['adline_item'] && $row['inapproval_id'] == $row['adapproval_id']) {
                $internal_date = date("d/m/Y", strtotime($row['indate']));
                $status = ucfirst($row['status']);
                $donor_remain = $row['adamt_required'] - $donor_IN_sum[0]['donor_sum'];
                $data[] = array("AN No" => $row['approval_no'], "Employee Name" => $employee, "Programme" => $row['programme'], "Donor" => $row['donor_name'], "Budget head" => $row['budget_head_name'], "Line Item" => $row['line_item_name'], "Sub Line Item" => $row['sub_line_item_name'], "Detail" => $row['detail'], "Budget Amount" => formatnumber($row['adamt_available']), "AN Date" => $date_of_request, "AN Purpose" => $row['purpose'], "IN No" => $row['internal_no'], "IN Date" => $internal_date, "IN Purpose" => $row['reason_payment_sougnt'], "IN Status" => $status, "Total(AN Amount)" => formatnumber($AN_sum[0]['total_AN_amount']), "IN Amount" => formatnumber($row['total']), "Total(Remaining Amount)" => formatnumber($amount_diff));
            } else {
                $data[] = array("AN No" => $row['approval_no'], "Employee Name" => $employee, "Programme" => $row['programme'], "Donor" => $row['donor_name'], "Budget head" => $row['budget_head_name'], "Line Item" => $row['line_item_name'], "Sub Line Item" => $row['sub_line_item_name'], "Detail" => $row['detail'], "Budget Amount" => formatnumber($row['adamt_available']), "AN Date" => $date_of_request, "AN Purpose" => $row['purpose'], "IN No" => "-", "IN Date" => "-", "IN Purpose" => "-", "IN Status" => "-", "Total(AN Amount)" => formatnumber($AN_sum[0]['total_AN_amount']), "IN Amount" => "-", "Total(Remaining Amount)" => formatnumber($amount_diff));
            }
        }

        if (php72_cmp($export) == 1) {
            return $data;
        }
        $returnArray = array();
        $returnArray = array(
            "sEcho" => intval($_POST['sEcho']),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => array()
        );
        $returnArray["aaData"] = $data;
        return $returnArray;
    }

    function findopenamt_donor($approval_id) {
        $data = array();
        $this->db->select('AD.*, MS.master_name as donor_name,MSB.master_name as budget_head_name,MSL.master_name as line_item_name,MSC.master_name as sub_line_item_name');
        $this->db->join('master_settings MS', 'MS.master_id = AD.donor', 'left');
        $this->db->join('master_settings MSB', 'MSB.master_id = AD.budget_head', 'left');
        $this->db->join('master_settings MSL', 'MSL.master_id = AD.line_item', 'left');
        $this->db->join('master_settings MSC', 'MSC.master_id = AD.cost_centre', 'left');

        if ($this->input->post('donor')) {
            $this->db->like('MS.master_name', $this->input->post('donor'), 'both');
        }

        $this->db->order_by('AD.approval_id DESC');
        $this->db->where('AD.approval_id', $approval_id);

        $query = $this->db->get('approval_note_donors AD');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }

    function findopenamt_IN($approval_id, $donor_details) {
        $data = array();
        $this->db->select('approval_id,donor,budget_head,line_item,cost_centre,status,reason_payment_sougnt,date,internal_no,amount_toapprove as total,total_amount as amt_required');
        $this->db->where('approval_id', $approval_id);
        $this->db->where('donor', $donor_details['donor']);
        $this->db->where('budget_head', $donor_details['budget_head']);
        $this->db->where('line_item', $donor_details['line_item']);
        $this->db->where('cost_centre', $donor_details['cost_centre']);
        $this->db->where('status !=', 'cancelled');
        if ($this->input->post('status')) {
            $this->db->like('status', $this->input->post('status'), 'both');
        }
        $query = $this->db->get('internal_note');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function getinternalamt_new($approval_id) {
        $this->db->select_sum('amount_toapprove', 'sum');
        $this->db->where('approval_id', $approval_id);
        $this->db->where('status !=', 'cancelled');
        $query = $this->db->get('internal_note');
        return $query->result_array();
    }

    function getAntotal_amount($approval_id) {
        $this->db->select_sum('amt_required', 'total_AN_amount');
        $this->db->where('approval_id', $approval_id);
        $query = $this->db->get('approval_note_donors');
        return $query->result_array();
    }

    function getinternalamt_donor($approval_id, $donor_details) {
        $this->db->select_sum('amount_toapprove', 'donor_sum');
        $this->db->where('approval_id', $approval_id);
        $this->db->where('donor', $donor_details['donor']);
        $this->db->where('budget_head', $donor_details['budget_head']);
        $this->db->where('line_item', $donor_details['line_item']);
        $this->db->where('cost_centre', $donor_details['cost_centre']);
        $this->db->where('status !=', 'cancelled');
        $query = $this->db->get('internal_note');
        return $query->result_array();
    }

    /*     * ** End ** */

///////////////////////// get all approval note//////////////////
    function get_approval_all_ajax_count($where) {
        $query = "select AD.donor as addonor,AD.budget_head as adbudget_head,AD.line_item as adline_item,AD.cost_centre as adcost_centre,
                    AD.amt_required as adamt_required, AD.amt_available as adamt_available, AD.approval_id as adapproval_id,OAN.approval_id,OAN.approval_no,
                    OAN.purpose,OAN.date_of_request,OAN.from_employee,MP.programme  , MS.master_name as donor_name, MSB.master_name as budget_head_name,
                    MSL.master_name as line_item_name, MSC.master_name as sub_line_item_name,I.donor as indonor,I.budget_head as inbudget_head,
                    I.line_item as inline_item, I.cost_centre as incost_centre, I.status,I.reason_payment_sougnt, I.date as indate,I.approval_id as inapproval_id,
                    I.internal_no,I.amount_toapprove as total,I.total_amount as amt_required from approval_note as OAN
                    join master_programme MP ON MP.programme_id = OAN.programme
                    JOIN approval_note_donors AD ON AD.approval_id = OAN.approval_id
                    JOIN master_settings MS ON MS.master_id = AD.donor
                    JOIN master_settings MSB ON MSB.master_id = AD.budget_head
                    JOIN master_settings MSL ON MSL.master_id = AD.line_item
                    LEFT OUTER JOIN master_settings MSC ON MSC.master_id = AD.cost_centre
                    LEFT OUTER JOIN internal_note I ON I.approval_id = OAN.approval_id
                    WHERE I.budget_head = AD.budget_head AND I.donor =AD.donor
                    AND I.line_item = AD.line_item AND I.cost_centre = AD.cost_centre
                    AND OAN.date_of_request >= '2013-04-01' AND OAN.date_of_request <= '2014-02-12'";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        $query .= "order by OAN.approval_no desc";
        $result = $this->db->query($query);
        return $result->num_rows();
    }

    function get_approval_all_ajax($options, $where, $export = NULL) {
        $data = array();
        $query = "select AD.donor as addonor,AD.budget_head as adbudget_head,AD.line_item as adline_item,AD.cost_centre as adcost_centre,
                    AD.amt_required as adamt_required, AD.amt_available as adamt_available, AD.approval_id as adapproval_id,OAN.approval_id,OAN.approval_no,
                    OAN.purpose,OAN.date_of_request,OAN.from_employee,MP.programme  , MS.master_name as donor_name, MSB.master_name as budget_head_name,
                    MSL.master_name as line_item_name, MSC.master_name as sub_line_item_name,I.donor as indonor,I.budget_head as inbudget_head,
                    I.line_item as inline_item, I.cost_centre as incost_centre, I.status,I.reason_payment_sougnt, I.date as indate,I.approval_id as inapproval_id,
                    I.internal_no,I.amount_toapprove as total,I.total_amount as amt_required
                    from approval_note as OAN
                    join master_programme MP ON MP.programme_id = OAN.programme
                    JOIN approval_note_donors AD ON AD.approval_id = OAN.approval_id
                    JOIN master_settings MS ON MS.master_id = AD.donor
                    JOIN master_settings MSB ON MSB.master_id = AD.budget_head
                    JOIN master_settings MSL ON MSL.master_id = AD.line_item
                    LEFT OUTER JOIN master_settings MSC ON MSC.master_id = AD.cost_centre
                    LEFT OUTER JOIN internal_note I ON I.approval_id = OAN.approval_id
                    WHERE I.budget_head = AD.budget_head AND I.donor =AD.donor
                    AND I.line_item = AD.line_item AND I.cost_centre = AD.cost_centre
                    AND OAN.date_of_request >= '2013-04-01' AND OAN.date_of_request <= '2014-02-12'";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        $query .= "order by OAN.approval_no desc";
        if (isset($options['num']) && isset($options['offset']))
            $query .= " limit " . $options['offset'] . "," . $options['num'];

        $query_ex = $this->db->query($query);
        $total = $this->get_approval_all_ajax_count($where);
        $j = $_POST['iDisplayStart'];

        foreach ($query_ex->result_array() as $row) {
            $donor = array('donor' => $row['addonor'], 'budget_head' => $row['adbudget_head'], 'line_item' => $row['adline_item'], 'cost_centre' => $row['adcost_centre']);
            $IN_sum = $this->getinternalamt_new($row['approval_id']);
            $AN_sum = $this->getAntotal_amount($row['approval_id']);
            $donor_IN_sum = $this->getinternalamt_donor($row['approval_id'], $donor);
            $amount_diff = $AN_sum[0]['total_AN_amount'] - $IN_sum[0]['sum'];
            $employee = getEmployeeName($row['from_employee']);
            $employee = ($employee != "") ? $employee : '-';
            $date_of_request = date("d/m/Y", strtotime($row['date_of_request']));
            if ($row['indonor'] == $row['addonor'] && $row['inbudget_head'] == $row['adbudget_head'] && $row['incost_centre'] == $row['adcost_centre'] && $row['inline_item'] == $row['adline_item'] && $row['inapproval_id'] == $row['adapproval_id']) {
                $internal_date = date("d/m/Y", strtotime($row['indate']));
                $status = ucfirst($row['status']);
                $donor_remain = $row['adamt_required'] - $donor_IN_sum[0]['donor_sum'];
                $data[] = array("AN Id" => $row['approval_id'], $row['approval_no'], "AN No" => $row['approval_no'], "Programme" => $row['programme'], "Donor" => $row['donor_name'], "Budget head" => $row['budget_head_name'], "Line Item" => $row['line_item_name'], "Sub Line Item" => $row['sub_line_item_name'],
                    "AN Date" => $date_of_request, "AN Purpose" => $row['purpose'], "IN No" => $row['internal_no'], "IN Date" => $internal_date, "IN Purpose" => $row['reason_payment_sougnt'], "IN Status" => $status, "Total(AN Amount)" => $AN_sum[0]['total_AN_amount'],
                    "IN Amount" => $row['total'], "Total(Remaining Amount)" => $amount_diff);
            } else {
                $data[] = array("AN Id" => $row['approval_id'], "AN No" => $row['approval_no'], "Programme" => $row['programme'], "Donor" => $row['donor_name'], "Budget head" => $row['budget_head_name'], "Line Item" => $row['line_item_name'], "Sub Line Item" => $row['sub_line_item_name'],
                    "AN Date" => $date_of_request, "AN Purpose" => $row['purpose'], "IN No" => "-", "IN Date" => "-", "IN Purpose" => "-", "IN Status" => "-", "Total(AN Amount)" => $AN_sum[0]['total_AN_amount'],
                    "IN Amount" => "-", "Total(Remaining Amount)" => $amount_diff);
            }
        }
        if (php72_cmp($export) == 1) {
            return $data;
        }
        $returnArray = array();
        $returnArray = array(
            "sEcho" => intval($_POST['sEcho']),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => array()
        );

        $returnArray["aaData"] = $data;
        return $returnArray;
    }

    function check_additional($where, $id = NULL) {
        $this->db->select('*');
        $this->db->where($where);
        if ($id != NULL)
            $this->db->where('id != ', $id);
        $query = $this->db->get('additional_info');
        return $query->num_rows();
    }

    function insert_additional($data) {
        $result = $this->db->insert('additional_info', $data);
        return $result;
    }

    function update_additional($data, $where) {
        if (!empty($where)) {
            $this->db->where($where);
            $result = $this->db->update('additional_info', $data);
            return $result;
        }
        return;
    }

    function get_additional_info($where = NULL, $num = NULL, $offset = NULL) {
        $data = array();
        $this->db->select('*');
        if ($where != '')
            $this->db->where($where);
        $this->db->order_by('id', 'desc');
        $this->db->limit($num, $offset);
        $result = $this->db->get('additional_info');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return $data;
    }

    function get_edit_history($where = NULL, $num = NULL, $offset = NULL) {
        $data = array();
        $this->db->select('*');
        if ($where != '')
            $this->db->where($where);
        $this->db->order_by('id', 'desc');
        $this->db->limit($num, $offset);

        $result = $this->db->get('balance_sheet_edit_history');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return $data;
    }

    function getLimitAssetall($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $export = NULL) {
        $data = array();
        if ($export == NULL)
            $this->db->limit($num, $offset);
        $this->db->select('master_settings.master_name, master_asset.*,master_vendor.vendor_name,master_asset.asset_id as master_asset_id,master_vendor.contact_person,master_vendor.vendor_name,master_vendor.vendor_email,master_vendor.contact_no,master_vendor.address,master_vendor.website,a.vendor_name as AMC_vendorname,a.vendor_email as AMC_vendoremail,a.contact_no as AMC_contactno,a.address as AMC_address,a.website as AMC_website,a.contact_person as AMC_contactperson,asset.employee_id,asset.issue_date');
        $this->db->join('master_settings', 'master_asset.asset_type=master_settings.master_id', 'left');
        $this->db->join('master_vendor', 'master_asset.vendor=master_vendor.vendor_id', 'left');
        $this->db->join('master_vendor as a', 'master_asset.AMC_vendor=a.vendor_id', 'left');
        $this->db->join('asset_transaction as asset', 'asset.asset_id=master_asset.asset_id', 'left');
        $this->db->where('master_asset.ina', 'no');
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('master_asset', $where);
        else
            $query = $this->db->get('master_asset');
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
