<?php

class Mcommon extends My_Model {

  /*  function Mcommon() {
        parent::Model();
        $this->hris = $this->load->database('hris', TRUE);
    }  */
	 public function __construct(){
        parent::__construct();
		$this->ais = $this->load->database('ais', TRUE);
    } 

    //change Status
    function changeStatus($TableName = NULL, $label = NULL, $Id = NULL, $Status = NULL) {
        $data = array('status' => $Status);
        $this->db->where($label, $Id);
        $data = $this->db->update($TableName, $data);
        return $data;
    }

    //delete  records
    function delete($TableName = NULL, $Label = NULL, $Id = NULL){
        $data = array();
        $this->ais->where($Label, $Id);
        $data = $this->ais->delete($TableName);
        return $data;
    }

    //delete  records
    function deleteMaster($TableName = NULL, $Label = NULL, $Id = NULL) {
        $data = array();
        $data = array('status' => '-1');
        $this->db->where($Label, $Id);
        $data = $this->db->update($TableName, $data);
        return $this->db->affected_rows();
    }

    //getrecords
    function getRecords($TableName = NULL, $Label = NULL, $Id = NULL) {
        $data = array();
        if ($Id != NULL && $Label != NULL)
            $this->ais->where($Label, $Id);
        $query = $this->ais->get($TableName);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function deleteMasterstatus($TableName = NULL, $MasterType = NULL, $MasterName = NULL) {
        $data = array();
        $data = array('status' => '1');
        $this->db->where('master_type', $MasterType);
        if ($MasterName != NULL)
            $this->db->where('master_name', $MasterName);
        $data = $this->db->update($TableName, $data);
        return $this->db->affected_rows();
    }

    function getstatusDuplicate($MasterType = NULL, $MasterName = NULL, $Id = NULL) {
        $data = array();
        if ($MasterType != NULL)
            $this->db->where('master_type', $MasterType);
        if ($MasterName != NULL)
            $this->db->where('master_name', $MasterName);
        $this->db->select('status');
        $query = $this->db->get('master_settings');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data[0]['status'];
        }
        return $data;
    }

    function getdonorsfromprogram($program) {
        $data = '';
        $this->ais->where('programme_id', $program);
        $this->ais->select('donor');
        $query = $this->ais->get('master_programme');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = unserialize($row['donor']);
            }
        }
        $data = ($data != '') ? php72_implode(',', $data) : '';
        return $data;
    }

    function getMasterSetting($masterType = NULL, $id = NULL, $pid = NULL, $program = NULL) { 
        $donor_id = explode(',', $this->getdonorsfromprogram($program));
        $partner_id = $this->session->userdata('partner_id');

        $data = array();
        $this->ais->where('ms.status', '1');
        $this->ais->where('ms.partner_id', $partner_id);
        if ($pid != NULL)
            $this->ais->where_in('ms.pid', $pid);

        if ($masterType != NULL) {
            $this->ais->select('ms.master_id,ms.master_name');
            if ($masterType == 'Budget Head') {
                $this->ais->join('master_settings DMS', 'DMS.master_id=ms.pid', 'left');
            } else if ($masterType == 'Line Item') {
                $this->ais->join('master_settings BMS', 'BMS.master_id=ms.pid', 'left');
                $this->ais->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
            } else if ($masterType == 'Cost Centre') {
                $this->ais->join('master_settings CMS', 'CMS.master_id=ms.pid', 'left');
                $this->ais->join('master_settings BMS', 'BMS.master_id=CMS.pid', 'left');
                $this->ais->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
            }
            if ($donor_id[0] != '' && $masterType != 'Donor') {
                $this->ais->where_in('DMS.master_id', $donor_id);
            } else if ($donor_id[0] != '') {
                $this->ais->where_in('ms.master_id', $donor_id);
            }
            $this->ais->where('ms.master_type', $masterType);
        }
        if ($id != NULL) {
            $this->ais->where('ms.master_id', $id);
            $this->ais->select('ms.master_name');
        }

        $this->ais->order_by('ms.master_name');
        $query = $this->ais->get('master_settings ms');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getMasterSetting_old($masterType = NULL, $id = NULL, $pid = NULL) {
        $data = array();
        $this->db->where('status', '1');
        if ($pid != NULL)
            $this->db->where_in('pid', $pid);
        if ($masterType != NULL) {
            $this->db->where('master_type', $masterType);
            $this->db->select('master_id,master_name');
        }
        if ($id != NULL) {
            $this->db->where('master_id', $id);
            $this->db->select('master_name');
        }
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function insertRecords($tableName = NULL) {
        $data = $_POST;
        unset($data['txtsubmit']);
        $result = $this->db->insert('master_asset', $data);
        return $this->db->insert_id();
    }

    function updateRecords($tableName, $column) {
        $data = $_POST;
        unset($data['txtsubmit']);
        unset($data[$column]);
        $this->db->where($column, $this->input->post($column));
        $result = $this->db->update($tableName, $data);
        return $result;
    }

    function getProgramme($donor = NULL, $id = NULL) {
        $data = array();
        $this->db->where('status', '1');
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        if ($id != NULL)
            $this->db->where('programme_id', $id);
        if ($donor != NULL)
            $this->db->where('donor', $donor);

        $query = $this->db->get('master_programme');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    //in cases data need from single table
    function getAllCount($where = NULL, $table = NULL) {
        $data = array();
        $this->db->select("count(*) as total");
        if ($where != NULL)
            $query = $this->db->get_where($table, $where);
        else
            $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    function add_adminemail($email) {
        $data = array('email2' => $email);
        $this->hris->where('id', 'USR001');
        $this->hris->update('hr_users', $data);

        $this->load->library('session');
        $this->session->set_userdata('adminemail', $email);
        return true;
    }

    function getLimitRecords($val = NULL) {
        $data = array();
        if ($val['export'] == 'no')
            $this->db->limit($val['num'], $val['offset']);

        if ($val['orderby'] != '' && $val['ordertype'] != '')
            $this->db->order_by($val['orderby'], $val['ordertype']);

        if ($val['where'] != '')
            $query = $this->db->get_where($val['table'], $val['where']);
        else
            $query = $this->db->get($val['table']);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function gettotaldonoramountLimitRecords($val = NULL, $from = NULL, $to = NULL) {
        $data = array();
        $this->misdb = $this->load->database('mis', TRUE);
        $this->db->select('D1A.*,MP.programme,D.master_name,D2A.master_name as budget_head,D3A.master_name as line_item,D1A.amount');
        $this->db->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->db->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->db->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->db->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->db->join($this->misdb->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');

        if ($val['programme'] != '')
            $this->db->where('MP.programme_id', $val['programme']);

        if ($val['donorid'] != '') {
            $this->db->where('D1A.donor_id', $val['donorid']);
        }
        if ($val['grant_id'] != '') {
            $this->db->where('D1A.grant_id', $val['grant_id']);
        }

        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");

        $query = $this->db->get('master_programme MP');
        return $query->num_rows();
    }

    function getdonoramountLimitRecords($val = NULL, $from = NULL, $to = NULL) {
        $data = array();
        $this->misdb = $this->load->database('mis', TRUE);
        $this->db->select('D1A.*,MP.programme,D.master_name,D2A.master_name as budget_head,D3A.master_name as line_item,D1A.amount');
        $this->db->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->db->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->db->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->db->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->db->join($this->misdb->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');

        if ($val['programme'] != '')
            $this->db->where('MP.programme_id', $val['programme']);

        if ($val['donorid'] != '') {
            $this->db->where('D1A.donor_id', $val['donorid']);
        }

        if ($val['orderby'] != '' && $val['ordertype'] != '')
            $this->db->order_by($val['orderby'], $val['ordertype']);

        if ($val['grant_id'] != '') {
            $this->db->where('D1A.grant_id', $val['grant_id']);
        }

        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $this->db->limit($val['num'], $val['offset']);
        $query = $this->db->get('master_programme MP');
        /* debug_last_query();
          die; */
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    //master
    //in cases data need from single table
    function getAllCountMaster($where = NULL, $table = NULL) {
        $where = $where . " and partner_id='" . $this->session->userdata('partner_id') . "'";
        $query = $this->db->query("select count(*) as total from" . $table . "where status !='-1' and partner_id=");
        $data = array();
        $this->db->select("count(*) as total");
        $this->db->where('status !=', '-1');
        if ($where != NULL)
            $query = $this->db->get_where($table, $where);
        else
            $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    function getLimitRecordsMaster($val = NULL) {
        $data = array();
        $this->db->where('status !=', '-1');
        if ($val['export'] == 'no')
            $this->db->limit($val['num'], $val['offset']);

        if ($val['orderby'] != '' && $val['ordertype'] != '')
            $this->db->order_by($val['orderby'], $val['ordertype']);
        if ($val['where'] != '')
            $query = $this->db->get_where($val['table'], $val['where']);
        else
            $query = $this->db->get($val['table']);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /*     * *** For adding Master Amount showing in approval note *** */
    /*     * ***  March 3,2012 *** */

    function getDonorLimitRecords($prog_search, $val = NULL, $wher, $donorid = 'NULL') {

        $data = array();
        $this->misdb = $this->load->database('mis', TRUE);

        $from = convertMonthYearFrom($val['from']);
        $to = convertMonthYearFrom($val['to']);
        $this->db->select('D1A.*,MP.programme,D.master_name,GL.name as grant_name,GL.id as grant_ids,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');

        $this->db->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->db->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->db->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->db->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->db->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->db->join($this->misdb->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');
        #echo $this->misdb->database;die;
        $this->db->where('MP.partner_id', $this->session->userdata('partner_id'));
        $this->db->where('D.master_type', $wher);
        if ($prog_search != '') {
            $this->db->where("MP.programme LIKE '%$prog_search%'");
        }
        if ($donorid != 'NULL') {
            $this->db->where('D1A.donor_id', $donorid);
        }
        $this->db->where("EXTRACT(YEAR_MONTH FROM D1A.amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM D1A.amount_date)  <= '$to'");
        if (!empty($val['orderby']) && !empty($val['ordertype'])) {
            $this->db->order_by($val['orderby'], $val['ordertype']);
        } else {
            $this->db->order_by('D1A.programme_id', 'asc');
            $this->db->order_by('D1A.donor_id', 'asc');
            $this->db->order_by('D1A.grant_id', 'asc');
        }
        $this->db->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid,D1A.grant_id');


        #$this->db->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');
        $query = $this->db->get('master_programme MP');

//        #echo debug_last_query();die;
        #echo'<pre>';print_r($query->result());die;
        //if ($query->num_rows() > 0) {
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function check_live_funder($prog_search, $val = NULL, $wher, $donorid = 'NULL') {

        $data = array();
        $this->misdb = $this->load->database('mis', TRUE);

        $from = convertMonthYearFrom($val['from']);
        $to = convertMonthYearFrom($val['to']);
        $this->db->select('D1A.*,MP.programme,D.master_name,GL.name as grant_name,GL.id as grant_ids,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');
        $this->db->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->db->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->db->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->db->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->db->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->db->join($this->misdb->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');

        $this->db->where('MP.partner_id', $this->session->userdata('partner_id'));
        $this->db->where('D.master_type', $wher);
        if ($prog_search != '') {
            $this->db->where("MP.programme LIKE '%$prog_search%'");
        }
        if ($donorid != 'NULL') {
            $this->db->where('D1A.donor_id', $donorid);
        }
        /*   $this->db->where("EXTRACT(YEAR_MONTH FROM D1A.amount_date)  >= '$from'");
          $this->db->where("EXTRACT(YEAR_MONTH FROM D1A.amount_date)  <= '$to'"); */
        if (!empty($val['orderby']) && !empty($val['ordertype'])) {
            $this->db->order_by($val['orderby'], $val['ordertype']);
        }
        $this->db->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');

        $query = $this->db->get('master_programme MP');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    /*     * ** End *** */

    function changeallfinancialstatus($TableName = NULL, $label = NULL, $Id = NULL, $Status = NULL) {
        $data = array('status' => '0');
        $this->db->where('id >', '0');
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $data = $this->db->update('financial_year', $data);
        return $data;
    }

    function changeFinancialStatus($TableName = NULL, $Id = NULL) {
        $this->changeallfinancialstatus($TableName = NULL, $Id);
        $data = array('status' => '1');
        $this->db->where('id', $Id);
        $data = $this->db->update('financial_year', $data);
        return $data;
    }

    function get_mastername($id, $name) {
        $master = $this->db->query("select master_name from master_settings where master_type='$name' and master_id='$id'");
        $master_name = $master->result_array();
        return $master_name[0]['master_name'];
    }

    function get_programme($id) {
        $master_prog = $this->db->query("select programme from master_programme where programme_id='$id'");
        $master_Pname = $master_prog->result_array();
        return $master_Pname[0]['programme'];
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

    function get_fellowship($program, $donor, $budget, $line_item, $subline) {
        $programme_id = $program; //9
        $donor_id = $donor; //5;
        $budget_id = $budget; //20;
        $line_item_id = $line_item; //295;
        $subline_item_id = $subline; //304;

        $programme = $this->get_programme($programme_id);
        $donor = $this->get_mastername($donor_id, 'Donor');
        $budget = $this->get_mastername($budget_id, 'Budget Head');
        $line = $this->get_mastername($line_item_id, 'Line Item');
        $subline = $this->get_mastername($subline_item_id, 'Cost Centre');

        $donors = array('Programme' => $programme, 'Donor' => $donor, 'Budget Head' => $budget, 'Line Item' => $line, 'Subline Item' => $subline);

        $financialArray = $this->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);

        $approval_results = $this->db->query("select A.approval_no as Approval_Number,A.date_of_request as Date_of_Request,
                 B.amt_required as Amount_Required, A.status as Status from approval_note A join approval_note_donors B on
	  	 A.approval_id = B.approval_id where A.programme='$programme_id' and B.donor='$donor_id' and
	  	 B.budget_head='$budget_id' and B.line_item='$line_item_id' and B.cost_centre='$subline_item_id' and
                 A.status = 'confirmed' and
	  	 EXTRACT(YEAR_MONTH FROM A.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM A.date_of_request) <= '$to'");

        $total_amount = $this->db->query("select sum(amt_required) as tot_amount from approval_note_donors
                 join approval_note on approval_note.approval_id=approval_note_donors.approval_id where
	  	 approval_note_donors.donor='$donor_id' and
	  	 approval_note_donors.budget_head='$budget_id' and  approval_note_donors.line_item='$line_item_id' and
	  	 approval_note_donors.cost_centre='$subline_item_id' and approval_note.status='confirmed'");
        $total_apn_amt = $total_amount->result_array();
        $this->to_excel($approval_results, $total_apn_amt[0]['tot_amount'], $donors);
    }

    function to_excel($query, $total_amount, $donors, $filename = '') {
        $headers = ''; // just creating the var for field headers to append to below
        $data = ''; // just creating the var for field data to append to below

        $obj = & get_instance();
        $fields = $query->field_data();
        if ($query->num_rows() == 0) {
            echo '<p>The table appears to have no data.</p>';
        } else {
            $filename = $donors['Programme'];
            foreach ($donors as $key => $value) {
                $headers .= $key . "\t" . $value . "\n";
            }
            $headers .= "\n";
            foreach ($fields as $field) {
                $headers .= $field->name . "\t";
            }

            foreach ($query->result() as $row) {
                $line = '';
                foreach ($row as $value) {
                    if ((!isset($value)) OR ( $value == "")) {
                        $value = "\t";
                    } else {
                        $value = str_replace('"', '""', $value);
                        $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
                }
                $data .= trim($line) . "\n";
            }
            $data .= 'Total Amount (Status:Approved)' . "\t" . $total_amount;
            $data = str_replace("\r", "", $data);
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename.xls");
            echo "$headers\n$data";
        }
    }

    function get_balance_sheet_detail($mastertype = NULL, $program = NULL, $donor = NULL, $budget_head = NULL, $line_item = NULL, $grant_id = null) {

        $data = array();
        $financialArray = $this->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);
        $this->db->distinct();
        if ($mastertype == 'Budget Head') {
            $key = 'budget_id';
            $this->db->select('budget_id');
            $this->db->where('programme_id', $program);
            $this->db->where('donor_id', $donor);
            if ($grant_id != '') {
                $this->db->where('grant_id', $grant_id);
            }
        } else if ($mastertype == 'Line Item') {
            $key = 'line_itemid';
            $this->db->select('line_itemid');
            $this->db->where('programme_id', $program);
            $this->db->where('donor_id', $donor);
            $this->db->where('budget_id', $budget_head);
            if ($grant_id != '') {
                $this->db->where('grant_id', $grant_id);
            }
        } else if ($mastertype == 'Cost Centre') {
            $key = 'subline_itemid';
            $this->db->select('subline_itemid');
            $this->db->where('programme_id', $program);
            $this->db->where('donor_id', $donor);
            $this->db->where('budget_id', $budget_head);
            $this->db->where('line_itemid', $line_item);
        }

        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->db->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");

        $query = $this->db->get('balance_amount');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row[$key];
            }
        }
        $query->free_result();
        return $data;
    }

    //funciton for report generation
    function get_sheet($input = array(), $count = '') {
        $programme = $input['programme'];
        $donor = $input['donor'];
        $budget = $input['budget'];
        $lineitem = $input['lineitem'];
        $subline = $input['subline'];
        $from = $input['from'];
        $to = $input['to'];

        $where = '';
        if ($programme != '')
            $where .= " AN.programme='" . $programme . "'and ";
        if ($donor != '')
            $where .= " ADO.donor='" . $donor . "' and ";
        if ($budget != '')
            $where .= " ADO.budget_head='" . $budget . "' and ";
        if ($lineitem != '')
            $where .= " ADO.line_item='" . $lineitem . "' and ";
        if ($subline != '')
            $where .= " ADO.cost_centre='" . $subline . "' and ";

        $q = "select AN.approval_no,INN.internal_no,AN.date_of_request,INN.date,AN.from_employee,MP.programme as programe,
	   	    D.master_name as donor,BH.master_name as budget_head,LI.master_name as line_item,CC.master_name as cost_centre,
	   	    INN.subject,AN.status,INN.status as instatus,ADO.amt_required,ADO.additionalinfo,INN.amount_toapprove
	   	    FROM approval_note_donors ADO JOIN approval_note AN ON AN.approval_id=ADO.approval_id
	   	    LEFT JOIN internal_note INN ON AN.approval_id=INN.approval_id
                    AND ADO.donor=INN.donor AND ADO.budget_head=INN.budget_head AND ADO.line_item= INN.line_item
                    AND ADO.additionalinfo= INN.additionalinfo AND INN.status <> 'cancelled'
                    left join master_programme MP on MP.programme_id = AN.programme
                    left join master_settings D on D.master_id= ADO.donor
                    left join master_settings BH on BH.master_id= ADO.budget_head
                    left join master_settings CC on CC.master_id= ADO.cost_centre
                    left join master_settings LI on LI.master_id= ADO.line_item
                    WHERE " . $where . " AN.status <> 'cancelled'";
        $q.=" and AN.date_of_request >= '$from' and AN.date_of_request <= '$to'
	   	            order by AN.approval_id desc";

        $query = $this->db->query($q);
        if ($count == 'count') {
            return $query->num_rows();
        }
        $result = $query->result_array();
        foreach ($result as $key => $value) {
            $id = $value['from_employee'];
            $this->hris->where('id', $id);
            $emp = $this->hris->get('hr_users');
            $rs = $emp->result_array();
            $value['from_employee'] = $rs[0]['user_name'];
            $add = $value['additionalinfo'];
            $value['additionalinfo'] = $this->get_additional_info($add);
            $data[$key] = array();
            foreach ($value as $rw) {
                array_push($data[$key], $rw);
            }
        }
        return $data;
    }

    //function for an in report ajax call

    function get_sheet_ajaxAN($options, $input, $export = NULL) {
        $data = array();
        $programme = $input['programme'];
        $donor = $input['donor'];
        $budget = $input['budget'];
        $lineitem = $input['lineitem'];
        $subline = $input['subline'];
        //$option = $input['option'];
        $from = $input['from'];
        $to = $input['to'];

        $where = '';
        if ($programme != '')
            $where .= " AN.programme='" . $programme . "' and ";
        if ($donor != '')
            $where .= " ADO.donor='" . $donor . "' and ";
        if ($budget != '')
            $where .= " ADO.budget_head='" . $budget . "' and ";
        if ($lineitem != '')
            $where .= " ADO.line_item='" . $lineitem . "' and ";
        if ($subline != '')
            $where .= " ADO.cost_centre='" . $subline . "' and ";
		
		
        $q = "select AN.approval_no,AN.from_employee,AN.to_RO,
                MP.programme as programe,MP.programme_head as phhead,D.master_name as donor,
	      	BH.master_name as budget_head,LI.master_name as line_item, CC.master_name as cost_centre,
                AN.date_of_request,AN.purpose,AN.status as anstatus, ADO.amt_required,ADO.additionalinfo,ADO.grant_id,INN.subject,INN.INamount
                FROM approval_note_donors ADO JOIN approval_note AN ON AN.approval_id=ADO.approval_id
                left JOIN ( select approval_id,sum(amount_toapprove) as INamount,donor,budget_head,line_item,subject,additionalinfo,
                status from internal_note  where status <> 'cancelled' group by approval_id,donor,budget_head,line_item,additionalinfo)
                as INN ON AN.approval_id=INN.approval_id AND ADO.donor=INN.donor AND ADO.budget_head=INN.budget_head
                AND ADO.line_item= INN.line_item AND ADO.additionalinfo= INN.additionalinfo
	   	left join master_programme MP on MP.programme_id = AN.programme
                left join master_settings D on D.master_id= ADO.donor
                left join master_settings BH on BH.master_id= ADO.budget_head
                left join master_settings CC on CC.master_id= ADO.cost_centre
                left join master_settings LI on LI.master_id= ADO.line_item
                WHERE " . $where . " AN.partner_id = " . $this->session->userdata('partner_id') . " and AN.status <> 'cancelled'
                and AN.date_of_request >= '$from' and AN.date_of_request <= '$to'";
        $q .= " order by AN.approval_id desc ";
        if (isset($options['num']) && isset($options['offset']))
            $q .= " limit " . $options['offset'] . "," . $options['num'];

        $query_ex = $this->db->query($q);
        $total = $this->get_sheet($input, 'count');
        $j = isset($_POST['iDisplayStart']) ? $_POST['iDisplayStart'] : '';
        $result = $query_ex->result_array();
        $data = array();
		$grantName = '';
        foreach ($result as $key => $value) {
            $id = $value['from_employee'];
            $this->hris->where('id', $id);
            $emp = $this->hris->get('hr_users');
            $rs = $emp->result_array();
            $emp_number = $rs[0]['emp_number'];

            #getEmployee
            $this->hris->where('emp_number', $emp_number);
            $employee = $this->hris->get('hs_hr_employee');
            $res1 = $employee->result_array();
            $value['from_employee'] = $res1[0]['emp_firstname'] . " " . $res1[0]['emp_lastname'];

            #RO
            $ROid = $value['to_RO'];
            $this->hris->where('id', $ROid);
            $emp = $this->hris->get('hr_users');
            $rs = $emp->result_array();
            $emp_number = $rs[0]['emp_number'];

            #getROEmployee
            $this->hris->where('emp_number', $emp_number);
            $employee = $this->hris->get('hs_hr_employee');
            $res1 = $employee->result_array();
            $value['to_RO'] = $res1[0]['emp_firstname'] . " " . $res1[0]['emp_lastname'];

            #PH
            $phid = $value['phhead'];
            $this->hris->where('id', $phid);
            $emp = $this->hris->get('hr_users');
            $rs = $emp->result_array();
            $emp_number = $rs[0]['emp_number'];

            #getPHEmployee
            $this->hris->where('emp_number', $emp_number);
            $employee = $this->hris->get('hs_hr_employee');
            $res1 = $employee->result_array();
            $value['phhead'] = $res1[0]['emp_firstname'] . " " . $res1[0]['emp_lastname'];

            $add = $value['additionalinfo'];
            $value['additionalinfo'] = $this->get_additional_info($add);
			
			
			$grant_id = $value['grant_id'];
			if($grant_id!=''){
				$grantData = $this->get_grantName($grant_id);
				$grantName = $grantData[0]->name;
			}
			$value['grant'] = $grantName;
			
			
            foreach ($value as $vkey => $rw) {
                $data[$key][$vkey] = $rw;
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

    function get_sheet_ajax($options, $input, $export = NULL) { #echo'<pre>';print_r($input);die;
        $data = array();
        $programme = $input['programme'];
        $donor = $input['donor'];
        $budget = $input['budget'];
        $lineitem = $input['lineitem'];
        $subline = $input['subline'];
        $from = $input['from'];
        $to = $input['to'];

        $where = '';

        if ($programme != '')
            $where .= " AN.programme='" . $programme . "'and ";
        if ($donor != '')
            $where .= " ADO.donor='" . $donor . "' and ";
        if ($budget != '')
            $where .= " ADO.budget_head='" . $budget . "' and ";
        if ($lineitem != '')
            $where .= " ADO.line_item='" . $lineitem . "' and ";
        if ($subline != '')
            $where .= " ADO.cost_centre='" . $subline . "' and ";
		
        $q = "select AN.approval_no,AN.from_employee,MP.programme as programe,D.master_name as donor,
	      	    BH.master_name as budget_head,LI.master_name as line_item,CC.master_name as cost_centre,
	      	    AN.date_of_request,AN.purpose,AN.status as anstatus,INN.internal_no,INN.date, INN.subject,INN.status as instatus,
	      	    ADO.amt_required,ADO.grant_id,ADO.additionalinfo,INN.RO_date,INN.payment_date,INN.amount_toapprove,INN.check_date,INN.invoice_date,INN.finance_comments
	   	    FROM approval_note_donors ADO JOIN approval_note AN ON AN.approval_id=ADO.approval_id
	   	    LEFT JOIN internal_note INN ON AN.approval_id=INN.approval_id AND ADO.donor=INN.donor
                    AND ADO.budget_head=INN.budget_head AND ADO.line_item= INN.line_item
                    AND ADO.additionalinfo= INN.additionalinfo AND INN.status <> 'cancelled'
                    left join master_programme MP on MP.programme_id = AN.programme
                    left join master_settings D on D.master_id= ADO.donor
                    left join master_settings BH on BH.master_id= ADO.budget_head
                    left join master_settings CC on CC.master_id= ADO.cost_centre
                    left join master_settings LI on LI.master_id= ADO.line_item
   	            WHERE " . $where . " AN.partner_id = " . $this->session->userdata('partner_id') . " and AN.status <> 'cancelled'
   	            and AN.date_of_request >= '$from' and AN.date_of_request <= '$to'";
		
        $q .= " order by AN.approval_id desc ";
        if (isset($options['num']) && isset($options['offset']))
            $q .= " limit " . $options['offset'] . "," . $options['num'];

			

        $query_ex = $this->db->query($q);
		
        $total = $this->get_sheet($input, 'count');
        $j = isset($_POST['iDisplayStart']) ? $_POST['iDisplayStart'] : '';
        $result = $query_ex->result_array();
		
        $data = array();
		$grantName = '';
        foreach ($result as $key => $value) {
			#echo'<pre>';print_r($value['grant_id']);die;
			$grant_id = $value['grant_id'];
			if($grant_id!=''){
				$grantData = $this->get_grantName($grant_id);
				$grantName = $grantData[0]->name;
			}
            $id = $value['from_employee'];
            $this->hris->where('id', $id);
            $emp = $this->hris->get('hr_users');
            $rs = $emp->result_array();
            $value['from_employee'] = $rs[0]['user_name'];
            $add = $value['additionalinfo'];
            $value['additionalinfo'] = $this->get_additional_info($add);
			$value['grant'] = $grantName;
			#unset($value['grant_id']);
			#echo'<pre>';print_r($value);die;
            foreach ($value as $vkey => $rw) {
				
                $data[$key][$vkey] = $rw;
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
	
	function get_grantName($id = '') {
        $this->misdb = $this->load->database('mis', TRUE);
        if ($id != '') {
            $this->misdb->where('id', $id);
        }
        $this->misdb->select(array('name', 'id', 'status_type'));
        $query = $this->misdb->get('grant_list');

        return $query->result();
    }

    function get_sheet_ajax_monthly($options, $input, $export = NULL) {
        $data = array();
        $programme = $input['programme'];
        $donor = $input['donor'];
        $budget = $input['budget'];
        $lineitem = $input['lineitem'];
        $subline = $input['subline'];
        $from = $input['from'];
        $to = $input['to'];

        $where = '';
        if ($programme != '')
            $where .= " AN.programme='" . $programme . "'and ";
        if ($donor != '')
            $where .= " ADO.donor='" . $donor . "' and ";
        if ($budget != '')
            $where .= " ADO.budget_head='" . $budget . "' and ";
        if ($lineitem != '')
            $where .= " ADO.line_item='" . $lineitem . "' and ";
        if ($subline != '')
            $where .= " ADO.cost_centre='" . $subline . "' and ";

        /* hidden due to bug in an in report (not showing when ter s 2 in for one an) */
        $q = "select AN.approval_no,AN.from_employee,MP.programme as programe,D.master_name as donor,
	            BH.master_name as budget_head,LI.master_name as line_item,ADO.additionalinfo,ADO.grant_id,ADO.amt_required,AN.status as an_status,AN.purpose,
	            AN.date_of_request,AN.to_RO,AN.RO_date,MP.programme_head as PH,AN.PH_date,AN.CEO_date,INN.internal_no,INN.date,INN.status as in_status,INN.subject,INN.RO_date as IN_RO_date,INN.PH_date as IN_PH_date,INN.payment_date as payment_date,INN.finance_status as payment_status,INN.check_date as check_date
	   	    FROM approval_note_donors ADO JOIN approval_note AN ON AN.approval_id=ADO.approval_id
	   	    LEFT JOIN internal_note INN ON AN.approval_id=INN.approval_id AND ADO.donor=INN.donor
                    AND ADO.budget_head=INN.budget_head AND ADO.line_item= INN.line_item
                    AND ADO.additionalinfo= INN.additionalinfo AND INN.status <> 'cancelled'
                    left join master_programme MP on MP.programme_id = AN.programme
                    left join master_settings D on D.master_id= ADO.donor
                    left join master_settings BH on BH.master_id= ADO.budget_head
                    left join master_settings CC on CC.master_id= ADO.cost_centre
                    left join master_settings LI on LI.master_id= ADO.line_item
   	            WHERE " . $where . " AN.partner_id = " . $this->session->userdata('partner_id') . " and AN.status <> 'cancelled'
   	            and AN.date_of_request >= '$from' and AN.date_of_request <= '$to'";
        $q .= " order by AN.approval_id desc ";
        if (isset($options['num']) && isset($options['offset']))
            $q .= " limit " . $options['offset'] . "," . $options['num'];

        $query_ex = $this->db->query($q);

        $total = $this->get_sheet($input, 'count');
        $j = isset($_POST['iDisplayStart']) ? $_POST['iDisplayStart'] : '';
        $result = $query_ex->result_array();
        $data = array();
		$grantName = '';
        foreach ($result as $key => $value) {
            if ((php72_cmp($value['amt_required']) >= 20000) && ($value['an_status'] == 'confirmed')) {
                $value['an_confirmed_date'] = $value['CEO_date'];
            } else if ((php72_cmp($value['amt_required']) < 20000) && ($value['an_status'] == 'confirmed')) {
                $value['an_confirmed_date'] = $value['PH_date'];
            } else if ($value['an_status'] == 'closed') {
                if ($value['CEO_date'] != '') {
                    $value['an_confirmed_date'] = $value['CEO_date'];
                } else if ($value['PH_date'] != '') {
                    $value['an_confirmed_date'] = $value['PH_date'];
                } else {
                    $value['an_confirmed_date'] = '';
                }
            } else {
                $value['an_confirmed_date'] = '';
            }
            $value['in_confirmed_date'] = $value['IN_PH_date'];
            $value['from_employee'] = $this->getusername($value['from_employee']);
            $value['to_RO'] = $this->getusername($value['to_RO']);
            $value['PH'] = $this->getusername($value['PH']);
            $add = $value['additionalinfo'];
            $value['additionalinfo'] = $this->get_additional_info($add);
			
			$grant_id = $value['grant_id'];
			if($grant_id!=''){
				$grantData = $this->get_grantName($grant_id);
				$grantName = $grantData[0]->name;
			}
			$value['grant'] = $grantName;
            foreach ($value as $vkey => $rw) {
                $data[$key][$vkey] = $rw;
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

    function getusername($id) {
        $this->hris->where('id', $id);
        $emp = $this->hris->get('hr_users');
        $rs = $emp->result_array();
        $emp_number = $rs[0]['emp_number'];

        #getPHEmployee
        $this->hris->where('emp_number', $emp_number);
        $employee = $this->hris->get('hs_hr_employee');
        $res1 = $employee->result_array();
        return $res1[0]['emp_firstname'] . " " . $res1[0]['emp_lastname'];
    }

    function get_additional_info($id) {
        $this->db->select('additionalinfo');
        $this->db->where('id', $id);
        $query = $this->db->get('additional_info');
        $data = $query->result_array();
        return $data[0]['additionalinfo'];
    }

    function removefrominuse($table, $where) {
        $change = array('transfer_status' => 'notavailable');
        $cond = array('asset_id' => $where, 'transfer_status' => 'using');
        $this->db->where($cond);
        $this->db->update($table, $change);
        return true;
    }

}

?>