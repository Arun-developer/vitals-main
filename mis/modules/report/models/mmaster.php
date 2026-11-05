<?php

class Mmaster extends My_Model {
	public function __construct(){
        
    }
	function findopenamount_new_ajax_count($where){
        /* $query = "select AD.donor as addonor,AD.budget_head as adbudget_head,AD.line_item as adline_item,AD.cost_centre as adcost_centre, AD.amt_required as adamt_required, AD.amt_available as adamt_available, AD.approval_id as adapproval_id,OAN.approval_id,OAN.approval_no,OAN.purpose,OAN.date_of_request,OAN.from_employee,MP.programme  , MS.master_name as donor_name, MSB.master_name as budget_head_name, MSL.master_name as line_item_name, MSC.master_name as sub_line_item_name,I.donor as indonor,I.budget_head as inbudget_head, I.line_item as inline_item, I.cost_centre as incost_centre, I.status,I.reason_payment_sougnt, I.date as indate,I.approval_id as inapproval_id, I.internal_no,I.amount_toapprove as total,I.total_amount as amt_required
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
        return $result->num_rows(); */
    }

    function findopenamt_new_ajax($options, $where, $export = NULL){
		#echo'asdadsasad';die;
        /* $data = array();
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
		echo $query;die;
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

        if ($export == 1) {
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
        return $returnArray; */
    }
	
}

?>