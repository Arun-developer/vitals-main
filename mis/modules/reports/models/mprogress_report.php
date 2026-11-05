<?php
class Mprogress_report extends CI_Model
{
    public function _construct()
    {
        parent::_construct();
        $this->hris = $this->load->database('hris', true);
    }

    public function getProgressReportDetailsByMONTH($innovation, $month, $year)
    {
        if ($month == '1') {$monthName = "January";}
        if ($month == '2') {$monthName = "February";}
        if ($month == '3') {$monthName = "March";}
        if ($month == '4') {$monthName = "April";}
        if ($month == '5') {$monthName = "May";}
        if ($month == '6') {$monthName = "June";}
        if ($month == '7') {$monthName = "July";}
        if ($month == '8') {$monthName = "August";}
        if ($month == '9') {$monthName = "September";}
        if ($month == '10') {$monthName = "October";}
        if ($month == '11') {$monthName = "November";}
        if ($month == '12') {$monthName = "December";}

        $start_date = date('01-m-Y', strtotime($monthName . $year));
        $end_date = date('t-m-Y', strtotime($monthName . $year));

        $start_date = date2mysql($start_date);
        $end_date = date2mysql($end_date);

        $bdquery = "select PG.answer as answer,PM.mastertype,PM.label from progress_master as PM
								LEFT JOIN progress as PG ON(PG.field = PM.id) where PM.type='metrices' and
								PG.date_type= '2' AND
								PG.start_date = '$start_date' AND
								PG.innovation = '$innovation'
								ORDER BY PM.mastertype
								";
        $query = $this->db->query($bdquery);
        $data = $query->result_array();

        return $data;
    }

    public function getmonthanswerreport($innovation, $checklist = null)
    {
        $data = array();
        $fieldvalues = array();
        if ($checklist == null) {
            $checklist = array();
            $whr = "PM.id = ''";
        } else {
            $whr = "PM.id IN(" . implode(', ', $checklist) . ")";
        }
        $prevmonth = date('m') - 01;
        $month = date('m');
        $year = date('Y');
        $field_name = 'answer';
        $buildqry = "SELECT PG.answer as answer,PM.label,PG.start_date as month FROM progress as PG LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
						PG.date_type = 2 AND (extract(Year FROM PG.start_date) in (0,  " . $year . ")) AND  (PG.innovation in (0,'" . $innovation . "')) AND (extract(month FROM PG.start_date) in (0, " . $month . ")) AND PM.type = 'metrices'";
        $value = $this->db->query($buildqry);
        foreach ($value->result_array() as $rows) {
            $temp = $rows['label'];
            $fieldvalues[$temp] = $rows['answer'];
        }
        foreach ($fieldvalues as $key => $value) {
            if (!is_numeric($value)) {
                $result = $this->splitformula($value, $fieldvalues);
                $valresult = @eval("return $result;");
                $fieldvalues[$key] = $valresult;
            }
        }
        $query = "SELECT PM.label,PM.id as id,PM.pid as pid,PM.mastertype,PM.value,PM.input_type,PM.subcategory as subcategory,PM.id,PM.period,PM.criteria,PG.answer from progress_master as PM LEFT JOIN (SELECT P1.label,P2.answer as answer, P2.Field, extract(month from P2.start_date) as month from progress_master as P1 JOIN progress as P2 ON (P1.id = P2.field) WHERE P2.date_type= 2 AND (extract(Year FROM P2.start_date) = " . $year . ") AND  P2.innovation ='" . $innovation . "' AND (extract(month FROM P2.start_date) =  " . $month . " ))  as PG ON (PM.id = PG.field) WHERE PM.period = 2 AND PM.type='metrices' AND $whr";
        $result = $this->db->query($query);
        $listvalue = $result->result_array();
        for ($i = 0; $i < count($listvalue); $i++) {
            foreach ($fieldvalues as $key => $value) {
                if ($key == $listvalue[$i]['label']) {
                    $listvalue[$i]['answer'] = $value;

                }
            }
            $listvalue[$i]['value'] = unserialize($listvalue[$i]['value']);
            $listvalue[$i]['prevmonth'] = $this->getlastmonth($innovation, $listvalue[$i]['id'], $listvalue[$i]['mastertype']);
        }
        $treeanswer = $this->buildTree($listvalue);
        return $treeanswer;
    }
    public function getlastmonth($innovation, $id, $mastertype)
    {
        $data = array();
        $prevmonth = date('m') - 01;
        $query = "SELECT PG.answer as answer from progress as PG JOIN progress_master as PM ON(PG.field = PM.id) WHERE PG.innovation = '" . $innovation . "' AND PG.field = '" . $id . "' AND PM.mastertype= '" . $mastertype . "' AND extract(month FROM PG.start_date) =  " . $prevmonth . "  AND EXTRACT(year from PG.start_date) = '" . date('Y') . "'";
        $result = $this->db->query($query);
        $data = $result->row_array();
        return @$data['answer'];
    }

    public function buildTree($ar, $pid = 0)
    {
        $op = array();
        $i = 0;
        foreach ($ar as $item) {
            if ($item['pid'] == $pid) {
                $op[$i] = array(
                    'name' => $item['label'],
                    'parentId' => $item['pid'],
                    'answer' => $item['answer'],
                    'id' => $item['id'],
                    'mastertype' => $item['mastertype'],
                    'subcategory' => $item['subcategory'],
                    'prevmonth' => $item['prevmonth'],
                    'criteria' => $item['criteria'],
                );
                // using recursion
                $children = $this->buildTree($ar, $item['id']);
                if ($children) {
                    $total = 0;
                    $op[$i]['children'] = $children;
                    foreach ($children as $row) {
                        $total += $row['answer'];
                    }
                    $op[$i]['answer'] = $total;
                }
            }
            $i++;
        }
        return $op;
    }
    public function getProgressReportDetailsByQuarter($innovation, $quarter, $year)
    {

        if ($quarter != "" and $year != "") {
            if ($quarter == '1') {
                $start_date = date('01-m-Y', strtotime('January' . $year));
                $end_date = date('t-m-Y', strtotime('March' . $year));
            }
            if ($quarter == '2') {
                $start_date = date('01-m-Y', strtotime('April' . $year));
                $end_date = date('t-m-Y', strtotime('June' . $year));
            }
            if ($quarter == '3') {
                $start_date = date('01-m-Y', strtotime('July' . $year));
                $end_date = date('t-m-Y', strtotime('September' . $year));
            }
            if ($quarter == '4') {
                $start_date = date('01-m-Y', strtotime('October' . $year));
                $end_date = date('t-m-Y', strtotime('December' . $year));
            }

            $quarterStart_date = date2mysql($start_date);
            $quarterEnd_date = date2mysql($end_date);
        }

        $buildquery = "select PG.answer as answer,PG.start_date,PG.end_date,PM.mastertype,PM.label from progress_master as PM
								LEFT JOIN progress as PG ON(PG.field = PM.id) where PM.type='metrices' and
								PG.date_type= '3' AND
								PG.start_date >= '$quarterStart_date' AND
								PG.end_date <= '$quarterEnd_date' AND
								PG.innovation = '$innovation'
								ORDER BY PG.start_date
								";
        $query = $this->db->query($buildquery);
        $data = $query->result_array();

        return $data;

    }

    public function getProgressReportDetailsByYEAR($innovation, $year)
    {
        $start_date = date('Y-m-01', strtotime('January' . $year));
        $end_date = date('Y-m-t', strtotime('December' . $year));
        $buildquery = "select PG.answer as answer,PG.start_date,PG.end_date,PM.mastertype,PM.label from progress_master as PM
								LEFT JOIN progress as PG ON(PG.field = PM.id) where PM.type='metrices' and
								PG.date_type= '4' AND
								PG.start_date >= '$start_date' AND
								PG.end_date <= '$end_date' AND
								PG.innovation = '$innovation'
								ORDER BY PG.start_date
								";
        $query = $this->db->query($buildquery);
        $data = $query->result_array();
        return $data;
    }

    public function getactivityreportbyyear($innovation, $year)
    {
        $data = array();
        $start_date = date('Y-m-01', strtotime('January' . $year));
        $end_date = date('Y-m-t', strtotime('December' . $year));
        $query = "SELECT PM.label,PG.field,PG.document,PG.answer,PG.manager_answer,
		PG.manager_answerby,PM.mastertype,PM.period as date_type,PG.villgro_answer,
		PG.answerby,PG.villgro_answerby,extract(month from PG.start_date) as start_date,extract(year from PG.end_date) as end_date,
		PG.criteria FROM progress as PG  JOIN progress_master as PM ON (PG.field = PM.id)
		where PM.type = 'activity' and   PG.innovation = '" . $innovation . "' and PG.start_date>= '$start_date' and PG.end_date <='$end_date' ORDER BY PM.mastertype";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
            for ($i = 0; $i < count($data); $i++) {
                if (isset($data[$i]['document']) != '') {
                    $data[$i]['document'] = unserialize($data[$i]['document']);
                } else {
                    $data[$i]['document'] = '';
                }
            }
        }
        return $data;
    }
    public function getanswerList()
    {
        $data = array();
        $bdquery = "select PG.answer as answer,PG.date_type,PM.label,PM.mastertype as master_type from progress as PG
								LEFT JOIN progress_master as PM ON(PG.field = PM.id) where PM.type='metrices' and
								PG.date_type=2 ORDER BY PM.mastertype";
        $query = $this->db->query($bdquery);
        if ($query->num_rows() > 0) {
            foreach (array_unique($query->result_array()) as $row) {
                $data[] = php72_array_unique($row);
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getfieldsListyearly($select = null)
    {
        if (!$select) {
            $select = 'IP.name_of_enterprise as innovation_name,MS.master_type as master_name,PG.id,PG.date_type';
        }
        $query = "SELECT " . $select . "	FROM progress as PG
					LEFT JOIN master_settings as MS ON (MS.id = PG.criteria)
					LEFT JOIN innovation_pool as IP ON (PG.innovation = IP.id)
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) where PM.type='metrices' GROUP BY MS.master_type ORDER BY PG.field";

        $value = $this->db->query($query);
        if ($value->num_rows() > 0) {
            foreach ($value->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getsall()
    {
        $sql = "select b.label,a.date_type,a.answer from progress a join progress_master b on a.field = b.id";
        $fieldvalues = array();
        $result = $this->db->query($sql);
        foreach ($result->result_array() as $rows) {

            $temp = $rows['label'];
            $fieldvalues[$temp] = $rows['answer'];
        }

        foreach ($fieldvalues as $key => $value) {
            if (!is_numeric($value)) {
                $result = $this->splitformula($value, $fieldvalues);
                $valresult = @eval("return $result;");
                $fieldvalues[$key] = $valresult;
            }
        }
        return $fieldvalues;
    }
    public function splitformula($value, $fieldvalues)
    {
        $result = array();
        $splitstring = '+-*/()';
        $resultstring = '';
        $operand = "";
        for ($i = 0; $i < strlen($value); $i++) {
            if (stristr($splitstring, $value[$i]) == true) {
                'operand = ' . $operand . ', ';
                if (php72_array_key_exists($operand, $fieldvalues)) {
                    $toadd = $fieldvalues[$operand];
                } else {
                    $toadd = $operand;
                }

                if (is_numeric($toadd)) {
                    $resultstring .= $toadd . $value[$i];
                    $toadd . '<br>';
                }
                $operand = "";
            } else {
                $operand .= $value[$i];
            }
        }

        if ($operand != '') {
            if (php72_array_key_exists($operand, $fieldvalues)) {
                $toadd = $fieldvalues[$operand];
            } else {
                $toadd = $operand;
            }

            if (is_numeric($toadd)) {
                $resultstring .= $toadd;
                'operand = ' . $operand . ', ' . $toadd . '<br>';
            }
        }

        return $resultstring;
    }
    public function getactivityList($innovation, $checklist = array(), $frommonth = null, $tomonth = null, $user = null)
    {
        $data = array();
        if ($frommonth != null && $tomonth != null) {
            $start_date = date('01-m-Y', strtotime($frommonth));
            $end_date = date('t-m-Y', strtotime($tomonth));
            $fromMonth = date2mysql($start_date);
            $toMonth = date2mysql($end_date);
            $where = "and PG.start_date >='" . $fromMonth . "'  and PG.end_date <='" . $toMonth . "'  ";
        } elseif ($user != '') {
            $where = "and PM.assigned_to ='" . $user . "'";
        } else {
            $where = "";
        }

        $query = "SELECT PM.label,PG.field,PG.document,PG.answer,PG.manager_answer,
		PG.manager_answerby,PM.mastertype,PM.period as date_type,PG.villgro_answer,
		PG.answerby,PG.villgro_answerby,extract(month from PG.start_date) as start_date,extract(year from PG.end_date) as end_date,
		PG.criteria FROM progress as PG  JOIN progress_master as PM ON (PG.field = PM.id)
		where PM.type = 'activity' and   PG.innovation = '" . $innovation . "'  " . $where . " ORDER BY PM.mastertype";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
            for ($i = 0; $i < count($data); $i++) {
                if (isset($data[$i]['document']) != '') {
                    $data[$i]['document'] = unserialize($data[$i]['document']);
                } else {
                    $data[$i]['document'] = '';
                }
            }
        }
        return $data;

    }
    public function getkra_details($month, $year)
    {
        $data = array();
        $month = date("F", mktime(0, 0, 0, $month, 1, 2000));
        $date = $month . ' ' . $year;
        $query = "SELECT KM.*,KD.target,KD.achieved from kra_master as KM LEFT JOIN kra_details as KD ON (KM.id = KD.kra_master_id AND KD.month = '" . $date . "') WHERE employee = '" . $this->session->userdata('emp_number') . "'  AND from_date >= '" . $date . "' OR to_date <= '" . $date . "' GROUP BY KM.id";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function addkra_details($options)
    {
        $curdate = date('Y-m-d');
        for ($i = 0; $i < php72_count($options['kra_id']); $i++) {
            $data = array('kra_master_id' => $options['kra_id'][$i],
                'month' => $options['date'],
                'target' => $options['target'][$i],
                'achieved' => $options['achieved'][$i],
                'date' => $curdate);
            $this->db->insert('kra_details', $data);
        }
        return true;
    }
    public function get_listreport()
    {
        $query = "SELECT KM.*,KD.kra_master_id,KD.target,KD.achieved from kra_master as KM LEFT JOIN kra_details as KD ON (KM.id = KD.kra_master_id) GROUP BY KM.id";
        $result = $this->db->query($query);

        return $result->result_array();
    }
    public function get_monthreport($id)
    {
        $query = "SELECT KD.* from kra_details as KD WHERE KD.kra_master_id = '" . $id . "'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}
