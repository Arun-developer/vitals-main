<?php

class Minternal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
    }

    function get_grantName($id = '') {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $this->db->select(array('name', 'id', 'status_type'));
        $query = $this->db->get('grant_list');

        return $query->result();
    }

    function get_allGrantVal($id = '') {
        $data = array();
        $this->misdb = $this->load->database('mis', TRUE);
        $query = "select t1.grant_id, t2.status_type from approval_note_donors t1 left join " . $this->misdb->database . ".grant_list t2 on t2.id = t1.grant_id where t1.approval_id = '" . $id . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function check_grantStatus($id = '') {
        $this->misdb = $this->load->database('mis', TRUE);
        if ($id != '') {
            $this->misdb->where('id', $id);
        }
        $this->misdb->select(array('name', 'id'));
        $query = $this->misdb->get('grant_list');
        return $query->result();
    }

    function insertInternalNote() {
		
		$additional_list = $this->input->post('additional_list');
		$additional_infoId = 0;
		if(!empty($additional_list)){
			$check_additional = array_values(php72_array_filter($additional_list));
			if(!empty($check_additional)){
				if($check_additional[0] !=''){
					$additional_infoId = $check_additional[0];
				}
			}
		}
		
        $fNameArray = array();
        if (is_array($this->input->post('fArray'))) {
            foreach (@$this->input->post('fArray') as $key => $value):
                $fNameArray[] = $value;
            endforeach;
        }
        $file_name = $_FILES['meet_doc']['name'];
        $file_tmp_name = $_FILES['meet_doc']['tmp_name'];
        foreach ($file_name as $key => $value):
            if ($value != '') {
				//$fName = rand() . "_" . str_replace(" ", "_", $value);
                $rename_file = str_replace(' ', '_', strtolower($value));
                $new_name = preg_replace('/[^A-Za-z0-9.\_]/', '', $rename_file);
                $fName = date('Ymdhis') . '_' . $new_name;
                @copy($file_tmp_name[$key], "uploads/support_docs/" . $fName);
                $fNameArray[] = $fName;
            }
        endforeach;
        $hidfile_name = $this->input->post('exist_doc');
        foreach ($hidfile_name as $key => $value) {
            if ($value != '') {
		//	$fName = rand() . "_" . str_replace(" ", "_", $value);
                $fName = $value;
                $fNameArray[] = $fName;
            }
        }
        $an = $this->referApprovalDonor($this->input->post('select_donor'));
        $internal_number = $this->internalNumber();

        //$get_date = date('d');
        //if($get_date != 30)
        //$financial_date = date("2019-03-31");
        //else
        //$financial_date = date("Y:m:d");

        $this->ais->where('approval_id', $this->input->post('approval_id'));
        $this->ais->set('to_RO', $this->input->post('to_RO'));
        $this->ais->update('approval_note');

        $data = array('internal_no' => $internal_number,
            'approval_id' => $this->input->post('approval_id'),
            'from' => $this->session->userdata('user'),
            'to' => ($this->input->post('option_ro')) ? $this->input->post('option_ro') : '',
            'budget_head' => @$an['0']['budget_head'],
            'donor' => @$an['0']['donor'],
            'grant_id' => @$an['0']['grant_id'],
            'additionalinfo' => $additional_infoId,
            'line_item' => @$an['0']['line_item'],
            //'date' => "2023-03-31",
            'date' => date("Y-m-d", strtotime($this->input->post('date'))),
            'subject' => $this->input->post('subject'),
            'payment_favor' => $this->input->post('payment_favor'),
            'total_amount' => str_replace(',', '', $this->input->post('total_amount')),
            // 'reason_for_deviation' => $this->input->post('reason_for_deviation'),
            'reason_payment_sougnt' => $this->input->post('reason_payment_sougnt'),
            'supporting_documents' => $this->input->post('supporting_documents'),
            'amount_toapprove' => str_replace(',', '', $this->input->post('amount_toapprove')),
            'invoice_date' => date("Y-m-d", strtotime($this->input->post('invoice_date'))),
            'proposed_date' => date("Y-m-d", strtotime($this->input->post('proposed_date'))),
            'partner_id' => $this->session->userdata('partner_id'),
            'attachment' => serialize($fNameArray),
            'andocuments' => serialize($this->input->post('andocument')));

        $this->ais->insert('internal_note', $data);
        $id = $this->ais->insert_id();
        $internalDetails = $this->getInternalNoteDetails($id);
        $employeeDetails = $this->getEmployeeFromUserId($internalDetails['0']['from_employee']);
        $RO_user = $this->reportingUser('supUser', 'All', $employeeDetails['0']['id']);
        $this->ais->where('approval_id', $this->input->post('approval_id'));
        $this->ais->set('internal_note', 'sent');
        // $this->ais->set('to_RO', $RO_user[0]['id']);
        $this->ais->update('approval_note');

        return $id;
		
    }

    function getfinanciallist() {
        $data = array();
        $partner_id = $this->session->userdata('partner_id');
        $query = "select * from financial_year where partner_id = '$partner_id' and status = '0' order by id desc";
        $result = $this->ais->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function internalNumber() {
        $data = array();
        $text = "INT/";
        $position = "front";
        $this->ais->order_by('internal_id', 'desc');
        $this->ais->limit('1', '0');
        $query = $this->ais->get('internal_note');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        if (count($data))
            $id = str_pad((int) $data['0']['internal_id'] + 1, 4, "0", STR_PAD_LEFT);
        else
            $id = '0001';
        return $internalNo = $text . $id;
    }

    function updateInternalNote() { 
	
		
		$additional_list = $this->input->post('additional_list');
		$additional_infoId = 0;
		if(!empty($additional_list)){
			$check_additional = array_values(php72_array_filter($additional_list));
			if(!empty($check_additional)){
				if($check_additional[0] !=''){
					$additional_infoId = $check_additional[0];
				}
			}
		}
		
        $fNameArray = array();
        if (is_array($this->input->post('fArray'))) {
            foreach (@$this->input->post('fArray') as $key => $value):
                $fNameArray[] = $value;
            endforeach;
        }
        $file_name = $_FILES['meet_doc']['name'];
        $file_tmp_name = $_FILES['meet_doc']['tmp_name'];
        foreach ($file_name as $key => $value):
            if ($value != '') {
//                $fName = rand() . "_" . str_replace(" ", "_", $value);
                $rename_file = str_replace(' ', '_', strtolower($value));
                $new_name = preg_replace('/[^A-Za-z0-9.\_]/', '', $rename_file);
                $fName = date('Ymdhis') . '_' . $new_name;
                @copy($file_tmp_name[$key], "uploads/support_docs/" . $fName);
                $fNameArray[] = $fName;
            }
        endforeach;
        $hidfile_name = $this->input->post('exist_doc');

        foreach ($hidfile_name as $key => $value) {
            if ($value != '') {
//                $fName = rand() . "_" . str_replace(" ", "_", $value);
                $fName = $value;
                $fNameArray[] = $fName;
            }
        }
        $status = $this->getstatusinternalnote($this->input->post('internal_edit_id'));

        if ($status[0]['RO_status'] == 'defered') {
            $stat = 'pending';
            $ro_status = 'pending';
            if ($status[0]['PH_status'] == 'defered') {
                $ph_status = 'pending';
            } else {
                $ph_status = $status[0]['PH_status'];
            }
        } else if ($status[0]['PH_status'] == 'defered') {
            $stat = 'pending';
            $ro_status = 'pending';
            $ph_status = 'pending';
        } else {
            $stat = $status[0]['status'];
            $ro_status = $status[0]['RO_status'];
            $ph_status = $status[0]['PH_status'];
        }
        $donid = $this->input->post('select_donor');
        $data2 = array(
            'approval_id' => $this->input->post('old_approval_id'),
            'approval_donor_id' => $donid,
            'internal_id' => $this->input->post('old_internal_id'),
            'date' => $this->input->post('old_date'),
            'old_subject' => $this->input->post('old_subject'),
            'old_donor' => $this->input->post('old_donor'),
            //'old_grant_id' => $this->input->post('old_donor'),
            'old_budget_head' => $this->input->post('old_budget_head'),
            'old_line_item' => $this->input->post('old_line_item'),
            'an_tot_amount' => $this->input->post('an_tot_amount'),
            'old_remain_amt' => $this->input->post('old_remaining_donorbalance'),
            'old_amount_toapprove' => $this->input->post('old_in_amount_toapprove'),
            //'old_invoice_date' => $this->input->post('old_invoice_date'),
            // 'old_proposed_date' => $this->input->post('old_proposed_date'),
            'old_payment_favor' => $this->input->post('old_payment_favor'),
            'edited_by' => $this->session->userdata('user'));

        $this->in_edit_history($data2);
        $an = $this->referApprovalDonor($this->input->post('select_donor'));

        $data = array('payment_favor' => $this->input->post('payment_favor'),
            'budget_head' => @$an['0']['budget_head'],
            'donor' => @$an['0']['donor'],
            'grant_id' => @$an['0']['grant_id'],
            'cost_centre' => @$an['0']['cost_centre'],
            'other_budget_head' => @$an['0']['other_budget_head'],
            'other_donor' => @$an['0']['other_donor'],
            'other_cost_centre' => $an['0']['other_cost_centre'],
            'additionalinfo' => $additional_infoId,
            'line_item' => @$an['0']['line_item'],
            'other_line_item' => @$an['0']['other_line_item'],
            'subject' => $this->input->post('subject'),
            'total_amount' => str_replace(',', '', $this->input->post('total_amount')),
            'reason_for_deviation' => $this->input->post('reason_for_deviation'),
            'reason_payment_sougnt' => $this->input->post('reason_payment_sougnt'),
            'supporting_documents' => $this->input->post('supporting_documents'),
            'amount_toapprove' => str_replace(',', '', $this->input->post('amount_toapprove')),
            'invoice_date' => date("Y-m-d", strtotime($this->input->post('invoice_date'))),
            'proposed_date' => date("Y-m-d", strtotime($this->input->post('proposed_date'))),
            'RO_status' => $ro_status,
            'PH_status' => $ph_status,
            'status' => $stat,
            'attachment' => serialize($fNameArray),
            'andocuments' => serialize($this->input->post('andocument')));

        $this->ais->where('internal_id', $this->input->post('internal_edit_id'));
        $this->ais->update('internal_note', $data);

        return true;
    }

    function getROfromAN($id) {
        $this->ais->select('to_RO');
        $this->ais->where('approval_id', $id);
        $query = $this->ais->get('approval_note');
        return $query->result_array();
    }

    function getstatusinternalnote($id) {
        $this->ais->select('RO_status,PH_status,status');
        $this->ais->where('internal_id', $id);
        $query = $this->ais->get('internal_note');
        return $query->result_array();
    }

    function internalAmount($id) {
        $this->db->where('finance_status', 'confirmed');
        $this->db->where('approval_id', $id);
        $this->db->select("sum(amount_toapprove) as total_amount");
        $query = $this->db->get('internal_note');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row['total_amount'];
            }
        }
        $query->free_result();
        $total = ($data != '') ? $data : '0';
        return $total;
    }

    function getAllInternalNotesCount($where = NULL, $admin = NULL, $type = NULL) {
        //        $type - 1: IN_list, $type - empty: IN_report
        $financialArray = $this->Mmaster->findCurrentFinancialYear();
        $partner_id = $this->session->userdata('partner_id');
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);
        if ($admin == NULL)
            $this->db->where('AN.from_employee', $this->session->userdata('userid'));

        if ($where == NULL) {
            $where = "EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to'";
        }
//        else {
//            $where .= "AND EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to'";
//        }
        if ($type == 1)
            $where .= "AND EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to'";

        $where .= " AND INTER.partner_id = $partner_id";
        $this->db->select("count(*) as total, sum(amount_toapprove) as total_amount_toapprove");
        $this->db->join('approval_note AN', 'AN.approval_id = INTER.approval_id');
        $this->db->join('master_programme MP', 'MP.programme_id = AN.programme', 'left');
        if ($where != NULL)
            $query = $this->db->get_where('internal_note INTER', $where);
        else
            $query = $this->db->get('internal_note INTER');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return array_pop($data);
    }

    function getLimitInternalNotes($type = NULL, $where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL, $export = NULL) {
//        $type - 1: IN_list, $type - 2: IN_report

        /*
          $aisdb = $this->load->database('ais', TRUE);
          $q = "select IF(AN.donor=0,AN.other_donor,CONCAT(D.master_name,' - ',GL.name)) as donor,
          IF(line_item=0,other_line_item,LI.master_name) as line_item,
          IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
          AN.amt_available, AN.amt_required, AP.payment_favor,
          MP.programme as programme_name,MP.programme_head,
          if(AP.raise_from='',AP.from_employee,AP.raise_from)as from_employee,
          if(AP.raise_RO='',AP.to_RO,AP.raise_RO)as to_RO,
          MP.programme as programme_name,MP.programme_head,AP.approval_no,AP.date_of_request,AP.date_of_seeking_approval ,AP.date_payment_required,
          AP.comments_RO, AP.comments_PH, AP.comments_CEO, AP.supporting_documents, AP.estimated_in_workplan, AP.above_50000,
          AP.purpose,AP.status,AP.RO_status,AP.CEO_status,AP.PH_status,AP.approval_id,AP.internal_note,AP.raise_from, AI.additionalinfo from " . $aisdb->database . ".approval_note AP     ";
          $q .= " left join " . $aisdb->database . ".master_programme MP on AP.programme= MP.programme_id";
          $q .= " left join " . $aisdb->database . ".approval_note_donors AN on AP.approval_id= AN.approval_id";
          $q .= " left join " . $aisdb->database . ".master_settings D on D.master_id= AN.donor";
          $q .= " left join " . $aisdb->database . ".master_settings BH on BH.master_id= AN.budget_head";
          $q .= " left join " . $aisdb->database . ".master_settings LI on LI.master_id= AN.line_item";
          $q .= " left join " . $aisdb->database . ".additional_info AI on AI.id = AN.additionalinfo";
          $q .= " left join grant_list GL on GL.id = AN.grant_id";
         */

          $data = array();
          $whereArray = array();
          $aisdb = $this->load->database('ais', TRUE);
          $q = "select INTER.*,IF(INTER.donor=0,INTER.other_donor,CONCAT(D.master_name,' - ',GL.name)) as donor,
          IF(INTER.cost_centre=0,INTER.other_cost_centre,CC.master_name) as cost_centre,
          IF(INTER.budget_head=0,INTER.other_budget_head,BH.master_name) as budget_head,
          IF(INTER.line_item=0,INTER.other_line_item,LI.master_name) as line_item,
          IF(AN.programme=0,AN.programme,MP.programme) as programe,
          AN.approval_no, AI.additionalinfo,AN.to_RO,AN.RO_date,INTER.RO_date as in_ro_date,INTER.payment_favor,
          if(AN.transfer_date !='0000-00-00' && AN.transfer_date > INTER.date,AN.raise_from,if(INTER.from !='',INTER.from,AN.from_employee)) AS from_employee
          from " . $aisdb->database . ".internal_note INTER ";

          $q .= " left join " . $aisdb->database . ".approval_note AN on AN.approval_id= INTER.approval_id";
          $q .= " left join " . $aisdb->database . ".master_programme MP on MP.programme_id = AN.programme";
          $q .= " left join " . $aisdb->database . ".master_settings D on D.master_id= INTER.donor";
          $q .= " left join " . $aisdb->database . ".master_settings BH on BH.master_id= INTER.budget_head";
          $q .= " left join " . $aisdb->database . ".master_settings CC on CC.master_id= INTER.cost_centre";
          $q .= " left join " . $aisdb->database . ".master_settings LI on LI.master_id= INTER.line_item";
          $q .= " left join " . $aisdb->database . ".additional_info AI on AI.id = INTER.additionalinfo";
          $q .= " left join " . $aisdb->database . ".approval_note_donors ANDO on ANDO.approval_id= AN.approval_id";
          $q .= " left join " . $this->db->database . ".grant_list GL on GL.id = INTER.grant_id";


          if ($admin == NULL)
            $whereArray[] = "AN.from_employee ='" . $this->session->userdata('user') . "'";
        if ($where != NULL) {
            $whereArray[] = $where;
        }

        $whereCond = implode(' and ', $whereArray);

        $financialArray = $this->findCurrentFinancialYears();
        $from = $this->convertMonthYearFroms($financialArray[0]['from']);
        $to = $this->convertMonthYearTos($financialArray[0]['to']);
// echo $type;/
        if ($type == 1 && $whereCond != '') {
            $q .= " where EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to' and " . $whereCond;
        } else if ($type == 2 && $whereCond != '') {
            $q .= " where " . $whereCond;
        } else {
            #$q .= " where EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to'";
        }

        if ($export == NULL)
            $q .= " group by AN.approval_id, INTER.internal_no";
        else
            $q .= " group by INTER.internal_id";

        if ($orderby != NULL && $ordertype != NULL)
            $q .= " order by " . $orderby . " " . $ordertype;
        else
            $q .= " order by INTER.date DESC";

        if ($num != NULL || $offset != NULL) {
            $offset = (!is_numeric($offset)) ? '0' : $offset;
            $q .= " LIMIT " . $offset . "," . $num;
        }

        $query = $this->db->query($q);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function findCurrentFinancialYears() {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('status', '1');
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->ais->get('financial_year');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function convertMonthYearFroms($from) {
        $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
            'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
        $fromarray = explode(' ', $from);
        if (!empty($fromarray)) {
            list($fromMonth, $fromYear) = array_pad(explode(' ', $from, 2), 2, null);
        }

        $fromMonth = $month[$fromMonth];
        $yearmonth1 = $fromYear . $fromMonth;
        return $yearmonth1;
    }

    function convertMonthYearTos($to) {
        $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
            'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
        list($toMonth, $toYear) = array_pad(explode(' ', $to, 2), 2, null);
        if (isset($toMonth)) {
            $toMonth = $month[$toMonth];
        }

        $yearmonth2 = $toYear . $toMonth;
        return $yearmonth2;
    }

    function getLimitInternalNotes_old($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL, $export = NULL) {
        $data = array();
        $whereArray = array();
        $q = "select INTER.*,IF(INTER.donor=0,INTER.other_donor,D.master_name) as donor,
        IF(INTER.cost_centre=0,INTER.other_cost_centre,CC.master_name) as cost_centre,
        IF(INTER.budget_head=0,INTER.other_budget_head,BH.master_name) as budget_head,
        IF(INTER.line_item=0,INTER.other_line_item,LI.master_name) as line_item, AN.approval_no,
        if(AN.transfer_date !='0000-00-00' && AN.transfer_date > INTER.date,AN.raise_from,if(INTER.from !='',INTER.from,AN.from_employee)) AS from_employee
        from internal_note INTER";
        $q .= " left join approval_note AN on AN.approval_id= INTER.approval_id";
        $q .= " left join master_programme MP on MP.programme_id = AN.programme";
        $q .= " left join master_settings D on D.master_id= INTER.donor";
        $q .= " left join master_settings BH on BH.master_id= INTER.budget_head";
        $q .= " left join master_settings CC on CC.master_id= INTER.cost_centre";
        $q .= " left join master_settings LI on LI.master_id= INTER.line_item";

        if ($admin == NULL)
            $whereArray[] = "AN.from_employee ='" . $this->session->userdata('user') . "'";

        if ($where != NULL)
            $whereArray[] = $where;

        $whereCond = implode(' and ', $whereArray);

        if ($whereCond != '')
            $q .= " where " . $whereCond;

        if ($orderby != NULL && $ordertype != NULL)
            $q .= " order by " . $orderby . " " . $ordertype;
        else
            $q .= " order by INTER.date DESC";

        if ($num != NULL || $offset != NULL) {
            $offset = (!is_numeric($offset)) ? '0' : $offset;
            $q .= " LIMIT " . $offset . "," . $num;
        }

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getfinanceusers() {
        $data = array();
        $query = "select * from approval_setting";
        $this->ais->where('partner_id', 1);
        $result = $this->ais->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = unserialize($row['finance']);
        }
        return $data;
    }

    function getarchiveInternalNotes($from, $to, $num = NULL, $offset = NULL, $where = NULL) {
        $data = array();
        $q = "select INTER.*,IF(INTER.donor=0,INTER.other_donor,D.master_name) as donor,
        IF(INTER.cost_centre=0,INTER.other_cost_centre,CC.master_name) as cost_centre,
        IF(INTER.budget_head=0,INTER.other_budget_head,BH.master_name) as budget_head,
        IF(INTER.line_item=0,INTER.other_line_item,LI.master_name) as line_item,
        AN.approval_no, AI.additionalinfo,
        if(AN.transfer_date !='0000-00-00' && AN.transfer_date > INTER.date,AN.raise_from,if(INTER.from !='',INTER.from,AN.from_employee)) AS from_employee
        from internal_note INTER";
        $q .= " left join approval_note AN on AN.approval_id= INTER.approval_id";
        $q .= " left join master_programme MP on MP.programme_id = AN.programme";
        $q .= " left join master_settings D on D.master_id= INTER.donor";
        $q .= " left join master_settings BH on BH.master_id= INTER.budget_head";
        $q .= " left join master_settings CC on CC.master_id= INTER.cost_centre";
        $q .= " left join master_settings LI on LI.master_id= INTER.line_item";
        $q .= " left join additional_info AI on AI.id = INTER.additionalinfo";
        $financeuser = array_pop($this->getfinanceusers());

        if ($where != NULL) {
            $whereArray[] = $where;
            $whereCond = php72_implode(' and ', $whereArray);
        } else {
            $whereCond = "1=1";
        }

        $q .= " where INTER.date >= '" . $from . "' and INTER.date <= '" . $to . "' and $whereCond";

        if ($num != NULL || $offset != NULL) {
            $offset = (!is_numeric($offset)) ? '0' : $offset;
            $q .= " LIMIT " . $offset . "," . $num;
        }

        $query = $this->ais->query($q);
        // if($this->session->userdata('emp_number') == '308') {
        //     echo $this->ais->last_query();exit;
        // }
		 //echo $this->ais->last_query();exit;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getarchiveInternalNotesCount($from, $to, $num = NULL, $offset = NULL, $where = NULL) {
        $data = array();
        $q = "select INTER.*,IF(INTER.donor=0,INTER.other_donor,D.master_name) as donor,
        IF(INTER.cost_centre=0,INTER.other_cost_centre,CC.master_name) as cost_centre,
        IF(INTER.budget_head=0,INTER.other_budget_head,BH.master_name) as budget_head,
        IF(INTER.line_item=0,INTER.other_line_item,LI.master_name) as line_item, AN.approval_no,
        if(AN.transfer_date !='0000-00-00' && AN.transfer_date > INTER.date,AN.raise_from,if(INTER.from !='',INTER.from,AN.from_employee)) AS from_employee
        from internal_note INTER";
        $q .= " left join approval_note AN on AN.approval_id= INTER.approval_id";
        $q .= " left join master_programme MP on MP.programme_id = AN.programme";
        $q .= " left join master_settings D on D.master_id= INTER.donor";
        $q .= " left join master_settings BH on BH.master_id= INTER.budget_head";
        $q .= " left join master_settings CC on CC.master_id= INTER.cost_centre";
        $q .= " left join master_settings LI on LI.master_id= INTER.line_item";

        $financeuser = array_pop($this->getfinanceusers());
        if ($where != NULL) {
            $whereArray[] = $where;
            $whereCond = php72_implode(' and ', $whereArray);
        } else {
            $whereCond = "1=1";
        }
        $q .= " where INTER.date >= '" . $from . "' and INTER.date <= '" . $to . "' and $whereCond";
        $query = $this->ais->query($q);
        return $query->num_rows();
    }

    function getInternalNoteDetails($id) { #error_reporting(-1);
	
		$aisdb = $this->load->database('ais', TRUE);
        $data = array();
        $query = array();
        $q = "select INTER.*,IF(INTER.donor=0,INTER.other_donor,D.master_name) as donor, GL.name as grant_name,
        IF(INTER.cost_centre=0,INTER.other_cost_centre,CC.master_name) as cost_centre,
        IF(INTER.budget_head=0,INTER.other_budget_head,BH.master_name) as budget_head,
        IF(INTER.line_item=0,INTER.other_line_item,LI.master_name) as line_item,
        IF(AN.programme=0,AN.programme,MP.programme) as programe,
        AN.approval_no,AN.to_RO,AN.attachment as anattachment,AI.additionalinfo,AN.status as approval_status,
        if(AN.transfer_date !='0000-00-00' && AN.transfer_date > INTER.date,AN.raise_from,if(INTER.from !='',INTER.from,AN.from_employee))
        AS from_employee,AN.from_employee as an_from_emp,MP.programme,MP.programme_head,INTER.donor as donor_id, INTER.cost_centre as slitem,INTER.budget_head as bhead,INTER.line_item as litem,INTER.cancelled_date,INTER.comments_admin,INTER.cancelledby,AN.programme as programme_id
        from " . $aisdb->database . ".internal_note INTER ";
        $q .= " left join " . $aisdb->database . ".approval_note AN on AN.approval_id= INTER.approval_id";
        $q .= " left join " . $aisdb->database . ".master_programme MP on AN.programme= MP.programme_id";
        $q .= " left join " . $aisdb->database . ".master_settings D on D.master_id= INTER.donor";
        $q .= " left join " . $aisdb->database . ".master_settings BH on BH.master_id= INTER.budget_head";
        $q .= " left join " . $aisdb->database . ".master_settings CC on CC.master_id= INTER.cost_centre";
        $q .= " left join " . $aisdb->database . ".master_settings LI on LI.master_id= INTER.line_item";
        $q .= " left join " . $aisdb->database . ".additional_info AI on AI.id = INTER.additionalinfo";
        $q .= " left join " . $aisdb->database . ".approval_note_donors ANDO on ANDO.approval_id= AN.approval_id";
        $q .= " left join " . $this->db->database . ".grant_list GL on GL.id = ANDO.grant_id";
        $q .= " where INTER.internal_id = '" . $id . "'";

        /*
          $data = array();
          $whereArray = array();
          $aisdb = $this->load->database('ais', TRUE);
          $q = "select INTER.*,IF(INTER.donor=0,INTER.other_donor,CONCAT(D.master_name,' - ',GL.name)) as donor,
          IF(INTER.cost_centre=0,INTER.other_cost_centre,CC.master_name) as cost_centre,
          IF(INTER.budget_head=0,INTER.other_budget_head,BH.master_name) as budget_head,
          IF(INTER.line_item=0,INTER.other_line_item,LI.master_name) as line_item,
          IF(AN.programme=0,AN.programme,MP.programme) as programe,
          AN.approval_no, AI.additionalinfo,AN.to_RO,
          if(AN.transfer_date !='' && AN.transfer_date > INTER.date,AN.raise_from,if(INTER.from !='',INTER.from,AN.from_employee)) AS from_employee
          from " . $aisdb->database . ".internal_note INTER ";

          $q .= " left join " . $aisdb->database . ".approval_note AN on AN.approval_id= INTER.approval_id";
          $q .= " left join " . $aisdb->database . ".master_programme MP on MP.programme_id = AN.programme";
          $q .= " left join " . $aisdb->database . ".master_settings D on D.master_id= INTER.donor";
          $q .= " left join " . $aisdb->database . ".master_settings BH on BH.master_id= INTER.budget_head";
          $q .= " left join " . $aisdb->database . ".master_settings CC on CC.master_id= INTER.cost_centre";
          $q .= " left join " . $aisdb->database . ".master_settings LI on LI.master_id= INTER.line_item";
          $q .= " left join " . $aisdb->database . ".additional_info AI on AI.id = INTER.additionalinfo";
          $q .= " left join " . $aisdb->database . ".approval_note_donors ANDO on ANDO.approval_id= AN.approval_id";
          $q .= " left join grant_list GL on GL.id = ANDO.grant_id";
         */

          $q .= " group by AN.approval_id,INTER.internal_no";
          $query = $this->db->query($q);
        #echo'<pre>';print_r($query);die;
		
      
          if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getInternalNoteDetailsEdit($id) {
        $data = array();
        $q = "select INTER.*,AN.approval_no,AN.attachment as anattachment, MP.programme as programme_name,AN.programme as prog_id,
        if(AN.transfer_date !='0000-00-00' && AN.transfer_date > INTER.date,AN.raise_from,if(INTER.from !='',INTER.from,AN.from_employee))AS from_employee,
        MP.programme,MP.programme_head from internal_note INTER";
        $q .= " left join approval_note AN on AN.approval_id= INTER.approval_id";
        $q .= " left join master_programme MP on AN.programme= MP.programme_id";
        $q .= " where INTER.internal_id = '" . $id . "'";

        $query = $this->ais->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function internalAdminAction($option, $id) {
        if ($option == 'cancelbyadmin') {
            $cancelledby = $this->session->userdata('emp_name');
            $this->ais->set('cancelledby', $cancelledby);
            $this->ais->set('status', 'cancelled');
            $this->ais->set('cancelled_date', date("Y-m-d H:i:s"));
            $this->ais->set('comments_admin', $this->input->post('comments_admin'));
            $this->ais->where('internal_id', $id);
            $this->ais->update('internal_note');
            return $this->ais->affected_rows();
        }
    }

    function internalRoAction($option, $id) {
        if ($option == 'approve') {
            /* -----Auto approving PH status when approving RO------ */
            $this->ais->set('RO_status', 'confirmed');
            $this->ais->set('PH_status', 'confirmed');
            $this->ais->set('status', 'confirmed');
        } else if ($option == 'disapprove') {
            $this->ais->set('RO_status', 'cancelled');
            $this->ais->set('status', 'cancelled');
        } else {
            $this->ais->set('RO_status', 'defered');
            $this->ais->set('status', 'defered');
        }

        $this->ais->set('RO_date', date("Y-m-d H:i:s"));
        $this->ais->set('comments_RO', $this->input->post('comments_RO'));
        $this->ais->where('internal_id', $id);
        $this->ais->update('internal_note');
        return $this->ais->affected_rows();
    }

    function getGrantAmount($id) {

        $sql_query = "SELECT  sum(internal_note.total_amount) as projected_amount,sum(internal_note.amount_toapprove) as amount_toapprove,internal_note.internal_no as internal_no, internal_note.status as status, internal_note.approval_id as approval_id,internal_note.grant_id as grant_id
        FROM internal_note
        LEFT JOIN approval_note ON approval_note.approval_id = internal_note.approval_id
        WHERE internal_note.status = 'confirmed' AND internal_note.internal_id = $id AND internal_note.grant_id!=''
        GROUP BY internal_note.grant_id";
        $query = $this->db->query($sql_query);
        return $rows = $query->result();
    }

    function getOldGrantAmount($id) {
        $sql_query = "SELECT  sum(internal_note.total_amount) as projected_amount,sum(internal_note.amount_toapprove) as amount_toapprove,internal_note.internal_no as internal_no, internal_note.status as status, internal_note.approval_id as approval_id,internal_note.grant_id as grant_id
        FROM internal_note
        LEFT JOIN approval_note ON approval_note.approval_id = internal_note.approval_id
        WHERE internal_note.internal_id = $id AND internal_note.grant_id!=''
        GROUP BY internal_note.grant_id";
        //an.status = 'confirmed' AND
        $query = $this->db->query($sql_query);
        return $rows = $query->result();
    }

    function updateGrantAmount($grant_id, $ap_amount) {
        $this->mis_db = $this->load->database('mis', TRUE);
        $this->mis_db->set('amount_utilized', 'amount_utilized+' . $ap_amount, false);
        $this->mis_db->where('id', $grant_id);
        $res = $this->mis_db->update('grant_list');
        echo $res;
    }

    function updateOldGrantAmount($grant_id, $ap_amount) {
        $this->mis_db = $this->load->database('mis', TRUE);
        $this->mis_db->set('amount_utilized', 'amount_utilized-' . $ap_amount, false);
        $this->mis_db->where('id', $grant_id);
        $res = $this->mis_db->update('grant_list');
        echo $res;
    }

    function internalPhAction($option, $id, $ipaddress, $approve_from) {
        $approveby = $this->session->userdata('emp_name');
        if ($option == 'approve') {
            $this->ais->set('PH_status', 'confirmed');
            $this->ais->set('status', 'confirmed');
            $this->ais->set('ip_address', $ipaddress);
            $this->ais->set('approved_from', $approve_from);
            $this->ais->set('approved_by', $approveby);
        } else if ($option == 'disapprove') {
            $this->ais->set('PH_status', 'cancelled');
            $this->ais->set('status', 'cancelled');
            $this->ais->set('ip_address', $ipaddress);
            $this->ais->set('approved_from', $approve_from);
            $this->ais->set('approved_by', $approveby);
        } else {
            $this->ais->set('RO_status', 'pending');
            $this->ais->set('PH_status', 'defered');
            $this->ais->set('status', 'defered');
            $this->ais->set('ip_address', $ipaddress);
            $this->ais->set('approved_from', $approve_from);
            $this->ais->set('approved_by', $approveby);
        }

        $this->ais->set('PH_date', date("Y-m-d H:i:s"));
        $this->ais->set('comments_PH', $this->input->post('comments_PH'));
        $this->ais->where('internal_id', $id);
        $this->ais->update('internal_note');
        return $this->ais->affected_rows();
    }

    function internalFinAction($option, $id) {
        $approveby = $this->session->userdata('emp_name');
        if ($option == 'approve') {
            $this->ais->set('payment_date', date("Y-m-d H:i:s"));
            $this->ais->set('finance_status', 'confirmed');
            $this->ais->set('check_no', $this->input->post('cheque_number'));
            $this->ais->set('check_date', date("Y-m-d H:i:s", strtotime($this->input->post('cheque_date'))));
        } else {
            $this->ais->set('finance_status', 'cancelled');
        }

        $this->ais->set('finance_comments', $this->input->post('comments_fin'));
        $this->ais->where('internal_id', $id);
        $this->ais->update('internal_note');
        return $this->ais->affected_rows();
    }

    function mailContent($requestId, $touser = NULL) {
        $internalDetails = $this->getInternalNoteDetails($requestId);
        $employeeDetails = $this->getEmployeeFromUserId($internalDetails['0']['from_employee']);
        $get_RO = $this->getROfromAN($internalDetails[0]['approval_id']);
        $empEmail = ($employeeDetails['0']['official_email'] != '') ? $employeeDetails['0']['official_email'] : $employeeDetails['0']['personal_email'];

        // $reportingAuth = $this->reportingUser('supUser', 'All', $employeeDetails['0']['id']);
        $reportingAuth = $this->employeeDetails($get_RO['0']['to_RO']);
        $roName = $reportingAuth[0]['emp_name'];

        if (php72_count($reportingAuth) == 1)
            $reportAuthEmail = ($reportingAuth['0']['official_email'] != '') ? $reportingAuth['0']['official_email'] : $reportingAuth['0']['personal_email'];
        else if (php72_count($reportingAuth) > 1) {
            $rodetails = $reportingAuth[0]['emp_name'];
            $reportAuthEmail = ($reportingAuth['0']['official_email'] != '') ? $reportingAuth['0']['official_email'] : $reportingAuth['0']['personal_email'];
        } else
        $reportAuthEmail = '';

        $adminEmail = $this->session->userdata('adminEmail');
//        $financeEmail = 'aravindhan.p@claritaz.com';

        $phDetails = $this->getEmployeeFromUserId($internalDetails['0']['programme_head']);
        $phEmail = ($phDetails['0']['official_email'] != '') ? $phDetails['0']['official_email'] : $phDetails['0']['personal_email'];

        switch ($touser) {
            case('ro'):
            $toName = $roName;
            break;
            case('ph'):
            $toName = $phDetails['0']['emp_name'];
            break;
            case('employee'):
            $toName = $employeeDetails['0']['emp_name'];
            break;
        }

        $this->db->where('id', $internalDetails['0']['partner_id']);
        $getPartner = $this->db->get('hr_partner_type');
        $getData = $getPartner->result_array();
        $partner_name = $getData[0]['partner_name'];

        $org = array('#partner_nam#', '#internal_no#', '#date#', '#from_employee#', '#to_RO#', '#subject#', '#approval_no#', '#total_amount#', '#reason_for_deviation#', '#reason_payment_sougnt#', '#supporting_documents#', '#amount_toapprove#', '#invoice_date#', '#proposed_date#', '#payment_favor#', '#programme#', '#budget_head#', '#donor#', '#detail#', '#status#', '#RO_status#', '#PH_status#', '#comments_RO#', '#cancelled_date#', '#cancelledby#', '#comments_admin#', '#programme_head#', '#From#', '#To#', '#check_no#', '#check_date#', '#payment_status#', '#finance_comments#', '#RO_date#');

        $replace = array(strtoupper($partner_name),
            $internalDetails['0']['internal_no'],
            date('d-m-Y', strtotime($internalDetails['0']['date'])),
            $this->getEmployeeName($internalDetails['0']['from_employee']),
            ucfirst($reportingAuth[0]['emp_name']),
            $internalDetails['0']['subject'],
            $internalDetails['0']['approval_no'],
            $this->session->userdata('currency') . ' ' . formatnumber($internalDetails['0']['total_amount']),
            $internalDetails['0']['reason_for_deviation'],
            $internalDetails['0']['reason_payment_sougnt'],
            $internalDetails['0']['supporting_documents'],
            $this->session->userdata('currency') . ' ' . formatnumber($internalDetails['0']['amount_toapprove']),
            date('d-m-Y', strtotime($internalDetails['0']['invoice_date'])),
            date('d-m-Y', strtotime($internalDetails['0']['proposed_date'])),
            $internalDetails['0']['payment_favor'],
            $internalDetails['0']['programe'],
            $internalDetails['0']['budget_head'],
            $internalDetails['0']['donor'] . ' - ' . $internalDetails['0']['grant_name'],
            $internalDetails['0']['additionalinfo'],
            ucfirst($internalDetails['0']['status']),
            ucfirst($internalDetails['0']['RO_status']),
            ucfirst($internalDetails['0']['PH_status']),
            $internalDetails['0']['comments_RO'],
            $internalDetails['0']['cancelled_date'],
            $internalDetails['0']['cancelledby'],
            $internalDetails['0']['comments_admin'],
            $this->getEmployeeName($internalDetails['0']['programme_head']),
            ucfirst($this->session->userdata('emp_name')),
            ucfirst($toName),
            $internalDetails['0']['check_no'],
            date('d-m-Y', strtotime($internalDetails['0']['check_date'])),
            ucfirst($internalDetails['0']['finance_status']),
            $internalDetails['0']['finance_comments'],
            //mysql2ddmmyyyy($internalDetails['0']['invoice_date']),
            date('d-m-Y', strtotime($internalDetails['0']['RO_date'])),
            date('d-m-Y', strtotime($internalDetails['0']['PH_date']))
        );

        $attach = array();
        $attachFile = unserialize($internalDetails['0']['attachment']);
        foreach (@$attachFile as $key => $value):
            $attach[] = "uploads/support_docs/" . $value;
        endforeach;

        $data = array('org' => $org,
            'replace' => $replace,
            'employeeEmail' => $empEmail,
            'adminEmail' => $adminEmail,
            'reportAuthEmail' => $reportAuthEmail,
//            'financeEmail' => 'aravindhan.p@claritaz.com',
            'phEmail' => $phEmail,
            'attach' => $attach);
        return $data;
    }

    function getEmployeeName($userId) {
        $result = $this->getUserInfo($userId);
        return $result['0']['user_name'];
    }

    function getInternalDashboard($section = 'mylist', $currentTab = 'pending') {
        $searchArray = array();
        $subUsers = php72_implode("','", reportingUser('subUser', 'userId'));
        $status = 'status';
        switch ($section) {
            case 'mylist':
            $admin = NULL;
            $searchArray[] = "INTER.from = '" . $this->session->userdata('user') . "'";
            break;
            case 'rolist':
            $single[] = '';
            $having[] = '';
            $users[] = '';
            $sub_user = reportingUser('subUser', 'userId');
            foreach ($sub_user as $row) {
                    //to get emp number
                $this->db->where('emp_id', $row);
                $emp = $this->db->get('hr_user_login');
                $emp_num = $emp->result_array();
                $sub_supUser = reportingUser('supUser', 'All', $emp_num[0]['emp_id']);
                $count = php72_count($sub_supUser);
                if ($count == 1) {
                    $single[] = $row;
                } elseif ($count > 1) {

                    $having[] = $row;
                } else {
                    $users[] = $row;
                }
            }
            $sub_user1 = php72_implode("','", $sub_user);
            $single1 = php72_implode("','", @$single);
            $users1 = php72_implode("','", @$users);
            $having1 = php72_implode("','", @$having);
            $searchArray[] = "((INTER.to IN ('" . $this->session->userdata('user') . "')) or (AN.to_RO ='" . $this->session->userdata('user') . "'))";
            $admin = 'Show all';
            $status = 'RO_status';
            break;
            case 'phlist':
            $searchArray[] = "MP.programme_head = '" . $this->session->userdata('user') . "'";
            if ($currentTab == 'pending' || $currentTab == 'confirmed') {
                $searchArray[] = "INTER.RO_status = 'confirmed'";
            }
            $admin = 'Show all';
            $status = 'PH_status';
            break;
            case 'finance':
            $admin = 'Show all';
            $title = 'Finance';
            if ($currentTab == 'pending') {
                $searchArray[] = "INTER.finance_status = 'inprogress' AND INTER.status = 'confirmed'";
            } else if ($currentTab == 'confirmed') {
                $searchArray[] = "INTER.finance_status = 'confirmed' AND INTER.status = 'confirmed'";
            } else if ($currentTab == 'confirmed') {
                $searchArray[] = "INTER.finance_status = 'cancelled' AND INTER.status = 'confirmed'";
            }
            break;
            case 'admin':
            $admin = 'Show all';
            $status = 'status';
            break;
        }

        switch ($currentTab) {
            case 'pending':
            if ($section != 'finance')
                $searchArray[] = "INTER." . $status . " = 'pending' AND INTER.status = 'pending'";
            break;
            case 'confirmed':
            if ($section != 'finance')
                $searchArray[] = "INTER." . $status . " = 'confirmed' AND INTER.status = 'confirmed'";
            break;
            case 'cancelled':
            if ($section != 'finance')
                $searchArray[] = "INTER." . $status . " = 'cancelled'AND INTER.status = 'cancelled'";
            break;
            case 'defered':
            $searchArray[] = "INTER.status = 'defered'";
            break;
        }

        $financialArray = $this->Mmaster->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);

        $searchArray[] = "EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to'";
        $where = implode(" and ", $searchArray);
        #Pagination Scripts Starts

        $total = $this->getAllInternalNotesCount($where, $admin);
        return $total['total'];
    }

    function financeAction($option, $id) {

        if ($option == 'confirm'):
            $this->ais->set('payment_date', date("Y-m-d H:i:s"));
            $this->ais->set('finance_status', 'confirmed');
            $this->ais->set('check_no', $this->input->post('check_no'));
            $this->ais->set('check_date', date("Y-m-d", strtotime($this->input->post('check_date'))));
            $this->ais->set('finance_comments', $this->input->post('finance_comments'));
            $this->db->set('invoice_date', date("Y-m-d", strtotime($this->input->post('invoice_date'))));
        else:
            $this->ais->set('finance_status', 'cancelled');
            $this->ais->set('finance_comments', $this->input->post('finance_comments'));
        endif;
        $this->ais->where('internal_id', $id);
        $this->ais->update('internal_note');
        return $this->ais->affected_rows();
    }

    /* newly added on 4/6/14 */

    function finance_retain($option, $id) {
        if ($option == 'close') {
            $this->db->set('finance_status', 'inprogress');
            $this->db->set('check_no', '');
            $this->db->set('check_date', '');
            $this->db->set('payment_comment', '');
//            $this->db->set('invoice_date', '');
        }
        $this->db->where('internal_id', $id);
        $this->db->update('internal_note');
        return $this->db->affected_rows();
    }

    function internal_note_sum($approval_id) {
        $query = "select sum(amount_toapprove) as internal_amount from internal_note where approval_id = '" . $approval_id . "' AND finance_status = 'confirmed' ";
        $result = $this->ais->query($query);
        return $result->result_array();
    }

    function Approval_note_amount($approval_id) {
        $query = "select sum(amt_required) as approval_amount from approval_note_donors where approval_id = '" . $approval_id . "'";
        $result = $this->ais->query($query);
        return $result->result_array();
    }

    /* newly added on 4/6/14 ends */

    function referApprovalDonor($id) {
        $data = array();
        $this->ais->where('approval_donor_id', $id);
        $query = $this->ais->get('approval_note_donors');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /* newly added on 2/6/14 */

    /// function to get approval donor id
    function getAPNdonorId($id = NULL, $internal_detail = NULL) {
        $q = "select A.approval_donor_id from approval_note_donors A join internal_note B
        on A.approval_id = B.approval_id where A.donor = '" . $internal_detail[0]['donor'] . "' and
        A.budget_head = '" . $internal_detail[0]['budget_head'] . "' and A.line_item = '" . $internal_detail[0]['line_item'] . "'
        and A.grant_id = '" . $internal_detail[0]['grant_id'] . "' and B.internal_id = '$id'";

        $result = $this->ais->query($q);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function getRecoveredDetail($id) {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('RA.internal_id', $id);
        $query = $this->ais->get('recovered_amount RA');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
        return $data;
    }

    function getRecoveredAmount($recover_id) {
        $data = array();
        // $data['id'] = $data['amount'] = $data['date'] = $data['comment'] = '';
        // $data['sum_amount'] = 0;
        $this->ais->select('*');
        $this->ais->where('AD.recover_id', $recover_id);
        $query = $this->ais->get('recovered_amount_detail AD');
        if ($query->num_rows() > 0) {
            $s = 0;
            $sum_amount = 0;
            foreach ($query->result_array() as $row) {
                $data[$s]['id'] = $row['id'];
                $data[$s]['recover_id'] = $recover_id;
                $data[$s]['amount'] = $row['amount_recovered'];
                $sum_amount += $row['amount_recovered'];
                $data[$s]['sum'] = $sum_amount;
                $data[$s]['date'] = $row['recovered_date'];
                $data[$s]['comments'] = $row['comments'];
                $s++;
            }
        }
        return $data;
    }

    function insert_recover_data($table, $data) {
        $this->ais->insert($table, $data);
        $id = $this->ais->insert_id();
        return $id;
    }

    function update_recover_data($table, $data, $where) {
        $this->ais->where($where);
        $this->ais->update($table, $data);
        return true;
    }

    function delete_recover_data($id, $recover_id) {
        if ($this->ais->delete('recovered_amount_detail', array('id' => $id))) {
            $this->ais->select('id');
            $this->ais->where('recover_id', $recover_id);
            $query = $this->ais->get('recovered_amount_detail');
            if ($query->num_rows() == 0) {
                $this->ais->delete('recovered_amount', array('id' => $recover_id));
                return true;
            }
            return true;
        }
    }

    function in_edit_history($data) {
        $this->ais->insert('in_edit_history', $data);
        return true;
    }

    function getUserNameInfo($userid) {
        $data = array();
        $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,admin_email,personal_email,official_email", false);
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

    function getEmployeeFromUserId($userId) {
        $data = $this->getUserInfo($userId);
        if (php72_count($data)) {
            return $this->employeeDetails($data['0']['emp_id']);
        } else
        return true;
    }

    function getUserInfo($userId) {

        #$data = $dataArr = array();
        $dataArr = '';
        $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,emp_gender,official_mobile,hr_user_profile.id as emp_number, official_email, personal_email, emp_name", false);
        $this->db->where('hr_user_login.emp_id', $userId);
        $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
        $this->db->group_by('hr_user_login.user_name');
        $query = $this->db->get('hr_user_login');
        if ($query->num_rows() > 0) {
            $dataArr = json_decode(json_encode($query->result()), true);
        }

        return $dataArr;
    }

    function employeeDetails($employeeId) {
        $data = array();
        $this->db->where('id', $employeeId);
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function reportingUser($type, $field, $empNumber = NULL) {
        $subUserArray = array();
        if ($empNumber == NULL) {
            $employees = $this->getReportingUser($this->session->userdata('empNumber'), $type);
        } else {
            $employees = $this->getReportingUser($empNumber, $type);
        }

        foreach ($employees as $row) {
            $subUserArray[] = $row['id'];
        }
        if ($field == 'userId')
            return $subUserArray;
        else
            return $employees;
    }

    function getReportingUser($employeeId, $option) {
        $data = array();
        if ($option == 'subUser') {
            $lable1 = 'report_subordinate';
            $lable2 = 'report_supervisor';
        } elseif ($option == 'supUser') {
            $lable1 = 'report_supervisor';
            $lable2 = 'report_subordinate';
        }
        $this->db->where($lable1, $employeeId);
        $this->db->select($lable2 . ",CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id,emp_name,official_email,personal_email", false);
//        $this->db->join("hr_user_login", 'hr_user_login.emp_id=hr_user_reporting.' . $lable2);
        $this->db->join("hr_user_profile", 'hr_user_profile.id=hr_user_reporting.' . $lable2);
        $query = $this->db->get('hr_user_reporting');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function formatnumber($num) {
        $currency = $this->session->userdata('currency');
        if ($currency == 'USD' || $currency == '$') {
            $stringtoreturn = number_format($num);
        } else {
            // This is my function
            // if($num == ''){$num=0;}
            $pos = strpos((string) $num, ".");
            if ($pos === false) {
                $decimalpart = '';
            } else {
                $decimalpart = substr($num, $pos + 1, 2);
                $num = substr($num, 0, $pos);
            }

            if (strlen($num) > 3 & strlen($num) <= 12) {
                $last3digits = substr($num, -3);
                $numexceptlastdigits = substr($num, 0, -3);
                $formatted = $this->makecomma($numexceptlastdigits);
                $stringtoreturn = $formatted . "," . $last3digits; //.".".$decimalpart ;
            } elseif (strlen($num) <= 3) {
                $stringtoreturn = $num; //.".".$decimalpart ;
                if ($decimalpart != '') {
                    $stringtoreturn .= "." . $decimalpart;
                }
            } elseif (strlen($num) > 12) {
                $stringtoreturn = number_format($num, 2);
            }

            if (substr($stringtoreturn, 0, 2) == "-,") {
                $stringtoreturn = "-" . substr($stringtoreturn, 2);
            }
        }

        return $stringtoreturn;
    }

    function makecomma($input) {
        // This function is written by some anonymous person - I got it from Google
        if (strlen($input) <= 2) {
            return $input;
        }
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = $this->makecomma($length) . "," . substr($input, -2);
        return $formatted_input;
    }

    function getMailTemplate($messageType) {
        $data = array();
        $this->ais->where('messagetype', $messageType);
        $query = $this->ais->get('mailtemplate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function get_finance_user($partnerId) {
        $data = array();
        $this->db->select('*');
        $this->db->where('partner_id', $partnerId);
        $query = $this->db->get('user_setup');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function get_internal_balance($donor_detail) {
        $tot_req_amount = 0;
        $conarray = array('approval_id' => $donor_detail[0]['approval_id'], 'donor' => $donor_detail[0]['donor'], 'budget_head' => $donor_detail[0]['budget_head'], 'line_item' => $donor_detail[0]['line_item']);
        if ($donor_detail[0]['cost_centre']) {
            $conarray['cost_centre'] = $donor_detail[0]['cost_centre'];
        }
        $this->ais->select_sum('amount_toapprove');
        $this->ais->where($conarray);
        $this->ais->where('status !=', 'cancelled');
        $query1 = $this->ais->get('internal_note');
        $remaining_amount = $query1->result_array();
        $int_remain = $remaining_amount[0]['amount_toapprove'];
        $this->ais->select_sum('amt_required');
        $this->ais->where($conarray);
        $query1 = $this->ais->get('approval_note_donors');
        $row1 = $query1->result_array(); //echo "<pre>"; var_dump($row1); exit;
        $tot_req_amount = $row1[0]['amt_required'];

        $remain_amt = ($int_remain != '') ? (($tot_req_amount != '') ? $tot_req_amount - $int_remain : $tot_req_amount) : $tot_req_amount;
        return $remain_amt;
    }

    function getDonorDetail($ap_donor_id) {
        $this->ais->select('approval_donor_id,donor,budget_head,line_item,amt_available,amt_required');
        $this->ais->where('approval_donor_id', $ap_donor_id);
        $query = $this->ais->get('approval_note_donors');
        return $query->result_array();
    }

    function get_donor_balance($id, $donor_detail) {
        $tot_req_amount = 0;
        $conarray = array('approval_id' => $id, 'donor' => $donor_detail[0]['donor'], 'budget_head' => $donor_detail[0]['budget_head'], 'line_item' => $donor_detail[0]['line_item']);
        $this->ais->select('amt_required');
        $this->ais->where($conarray);
        $query1 = $this->ais->get('approval_note_donors');
        if ($query1->num_rows() > 1) {
            $row1 = $query1->result_array();
            foreach ($row1 as $rs) {
                $req_amount[] = $rs['amt_required'];
            }
            $tot_req_amount = php72_array_sum($req_amount);
        }
        $this->ais->select_sum('amount_toapprove', 'int_amount');
        $this->ais->where($conarray);
        $this->ais->where('status !=', 'cancelled');
        $query = $this->ais->get('internal_note');
        $row = $query->result_array();
        $remaining_amount = (($row[0]['int_amount'] != '')) ? ((($tot_req_amount != '') ? $tot_req_amount : $donor_detail[0]['amt_required']) - $row[0]['int_amount']) : $donor_detail[0]['amt_required'];
        return $remaining_amount;
    }

    function get_ro_user($userID, $partnerId) {
        $data = array();
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->where('report_method', 1);
        $this->db->where('report_subordinate', $userID);
        $query = $this->db->get('hr_user_reporting');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
	
	
	function getVendorDetails($table='',$condition=array()) {
        $this->db->select('id,name');
		$this->db->where($condition);
		$this->db->order_by('name', 'ASC');
        $query = $this->db->get($table);
		$row = $query->result_array();
		return $row;
    }
	
	function getVendorBankDetails($table='',$condition=array(),$sected=array()) {
        $this->db->select($sected);
		$this->db->where($condition);
        $query = $this->db->get($table);
		$row = $query->result_array();
		return $row;
    }
	
	function getTdsDetails($table='',$condition=array(),$sected=array()) {
        $this->ais->select($sected);
		$this->ais->where($condition);
        $query = $this->ais->get($table);
		$row = $query->result_array();
		return $row;
    }
	
	function insertTdsDetails($table='',$data=array()) {
		$this->ais->insert($table, $data);
	}
	function updateTdsDetails($table='',$condition=array(),$data=array()) {
		$this->ais->where($condition);
        $this->ais->update($table,$data);
	}

    // Reads internal_note rows for the given internal_no values, returning the
    // attachment filenames stored against each.
    function getSupportingDocsByInternalNo($internalNos = array()) {
        if (empty($internalNos)) {
            return array();
        }

        $escaped = array();
        foreach ($internalNos as $internalNo) {
            $escaped[] = "'" . $this->ais->escape_str($internalNo) . "'";
        }
        $inList = implode(',', $escaped);

        $query = "select internal_no, internal_id, attachment, andocuments, supporting_documents from internal_note where internal_no in ($inList)";
        $result = $this->ais->query($query);

        $results = array();
        foreach ($result->result_array() as $row) {
            $files = array();

            foreach (array('attachment', 'andocuments') as $field) {
                if (empty($row[$field])) {
                    continue;
                }
                $unserialized = @unserialize($row[$field]);
                if (is_array($unserialized)) {
                    foreach ($unserialized as $filename) {
                        if (!empty($filename)) {
                            $files[] = $filename;
                        }
                    }
                }
            }

            $results[] = array(
                'internal_no' => $row['internal_no'],
                'internal_id' => $row['internal_id'],
                'files' => array_unique($files),
                'supporting_documents_note' => $row['supporting_documents'],
            );
        }

        return $results;
    }

}

?>