<?php
class Mincubationprogress extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function getearnedreveune($id, $year, $month)
    {
        $data = array();
        $monthn = $month + 1;
        $query = "select PG.answer,PG.start_date from progress as PG LEFT JOIN progress_master as PM ON(PM.id=PG.field) where PG.innovation = $id and PM.label = 'Earned Reveune'and extract(Year from PG.start_date)=$year GROUP BY extract(Month from PG.start_date)";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }
    public function getlabel($id)
    {
        $data = array();
        $this->db->select('label');
        $this->db->where('id', $id);
        $query = $this->db->get('progress_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }
        return $data;
    }
    public function insertassign($options = array())
    {
        $data = array('assigned_to' => $options['assigned'],
            'label' => $options['label'],
            'assigned_to' => $options['assigned'],
            'type' => $options['type'],
            'year' => $options['year'],
            'innovation' => $options['id']);
        $this->db->insert('progress_validation', $data);
    }
    public function getAssignedChecklist($innovation)
    {
        $data = array();
        $this->db->select("checklist");
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('checklist_incubation');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = explode(',', $row['checklist']);
            }
        }
        return $data;
    }
    public function getmastertype()
    {
        $data = array();
        $query = "select distinct(master_type) from master_settings where iris_tab = 'standard'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getsubmastertype($mastertype)
    {
        $data = array();
        $this->db->select('master_name');
        $this->db->where('master_type', $mastertype);
        $result = $this->db->get('master_settings');
        foreach ($result->result_array() as $row) {
            $data[] = $row;

        }
        return $data;
    }
    public function getsubcategory($mastertype, $mastername, $type)
    {
        $data = array();
        $this->db->select('subcategory');
        $this->db->distinct('subcategory');
        $this->db->where('mastertype', $mastertype);
        $this->db->where('type', $type);
        $result = $this->db->get('progress_master');
        foreach ($result->result_array() as $row) {
            $data[] = $row;

        }
        return $data;
    }
    public function getyear_Report($innovation, $criteria, $checklist, $type, $frequency, $subcategory)
    {
        $data = array();
        $this->db->select("PM.id,PM.label,PM.info,PM.criteria,(select master_name from master_settings where id=PM.criteria) as master_name");
        $checklist = (count($checklist) == 0) ? array('') : $checklist;
        $this->db->where_in('PM.id', $checklist);
        $this->db->where('PM.type', $type);
        $this->db->where('period', '4');
        $this->db->where('criteria', $criteria);
        if ($subcategory != null && $subcategory != 'NULL') {
            $this->db->where('subcategory', $subcategory);
        }
        $query = $this->db->get('progress_master PM');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        //
        return $data;

    }
    public function getquarterlyreport($innovation, $criteria, $checklist, $type, $frequency, $subcategory)
    {

        $data = array();
        $this->db->select("PM.id,PM.label,PM.info,PM.criteria,(select master_name from master_settings where id=PM.criteria) as master_name");
        $checklist = (count($checklist) == 0) ? array('') : $checklist;
        $this->db->where_in('PM.id', $checklist);
        $this->db->where('PM.type', $type);
        $this->db->where('period', '3');
        $this->db->where('criteria', $criteria);
        if ($subcategory != null && $subcategory != 'NULL') {
            $this->db->where('subcategory', $subcategory);
        }
        $query = $this->db->get('progress_master PM');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        //
        return $data;

    }
    public function gettreelabel($innovation, $criteria, $checklist = array(), $type, $frequency, $subcategory = null)
    {
        $data = array();
        
        $query = "SELECT t1.*
FROM progress_master t1
LEFT JOIN progress_master t2 ON t1.pid = t2.id
WHERE t1.type = '" . $type . "' AND t1.period = '" . $frequency . "' AND t1.criteria = '" . $criteria . "' AND t1.subcategory = '" . $subcategory . "'";

        $result = $this->db->query($query);
        $row = $result->result_array();
        $tree = $this->buildTree($row);
        return $tree;

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

    public function getmonthreport($innovation, $criteria, $checklist = array(), $type, $frequency, $subcategory = null)
    {
        $data = array();
        $this->db->select("PM.id,PM.label,PM.info,PM.criteria,(select master_name from master_settings where id=PM.criteria) as master_name");
        $checklist = (count($checklist) == 0) ? array('') : $checklist;
        $this->db->where_in('PM.id', $checklist);
        $this->db->where('PM.type', $type);
        $this->db->where('period', $frequency);
        $this->db->where('criteria', $criteria);

        if ($subcategory != null && $subcategory != 'NULL') {
            $this->db->where('subcategory', $subcategory);
        }
        $query = $this->db->get('progress_master PM');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getweekreport($innovation, $criteria, $checklist = array(), $type, $frequency, $subcategory = null)
    {
        $data = array();
        $this->db->select("PM.id,PM.label,PM.info,PM.criteria,(select master_name from master_settings where id=PM.criteria) as master_name");
        $checklist = (count($checklist) == 0) ? array('') : $checklist;
        $this->db->where_in('PM.id', $checklist);
        $this->db->where('PM.type', $type);
        $this->db->where('period', $frequency);
        $this->db->where('criteria', $criteria);
        if ($subcategory != null && $subcategory != 'NULL') {
            $this->db->where('subcategory', $subcategory);
        }
        $query = $this->db->get('progress_master PM');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getweekanswerreport($frequency, $checklist = array(), $innovation, $month, $subcategory, $year, $type, $mastertype, $criteria)
    {
        $data = array();
        $fieldvalues = array();
        $checklist = (count($checklist) == 0) ? array('NULL') : $checklist;
        $field_name = 'answer';
        if ($type == 'activity') {
            if ($this->session->userdata('user_type') != 'incubatee') {
                $field_name = 'villgro_answer';
            }
            if ($this->session->userdata('user_type') == 'abi') {
                $field_name = 'manager_answer';
            }
            $query = "SELECT PM.label,PM.id,PM.period,PM.criteria,PG.answer,PG.document from progress_master as PM
		LEFT JOIN (SELECT P1.label, P2." . $field_name . " as answer,P2.document as document,
		P2.Field, extract(month from P2.start_date) as month from progress_master as P1 JOIN progress as P2 ON (P1.id = P2.field)
		WHERE P2.date_type= 3  AND (extract(Year FROM P2.start_date) = " . $year . ") AND  P2.innovation ='" . $innovation . "' AND
		(extract(Month FROM P2.start_date) = " . $month . " )
		GROUP BY P1.label, P2.Field,
		extract(Quarter from P2.start_date)) as PG ON (PM.id = PG.field) WHERE PM.period = 3 and PM.type='activity'
		and PM.criteria = '" . $criteria . "' and  PM.id IN(" . implode(', ', $checklist) . ")";
            $result = $this->db->query($query);
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            $buildqry = "SELECT PG.answer as answer,PM.label FROM progress as PG LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
						PG.date_type = 3 AND (extract(Year FROM PG.start_date) in (0,  " . $year . ")) AND
						(PG.innovation in (0,'" . $innovation . "')) AND (extract(month FROM PG.start_date) in (0, " . $month . "))
						AND PM.type = 'metrices' AND PM.id IN(" . implode(', ', $checklist) . ")";
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
            $query = "SELECT PM.label,PM.value,PM.input_type,PM.subcategory as subcategory,PM.id,PM.period,PM.criteria,PG.answer from
		progress_master as PM LEFT JOIN (SELECT P1.label, P2.answer as answer, P2.Field, extract(month from P2.start_date)
		as month from progress_master as P1 JOIN progress as P2 ON (P1.id = P2.field) WHERE P2.date_type= 1 AND
		(extract(Year FROM P2.start_date) = " . $year . ") AND  P2.innovation ='" . $innovation . "' AND
		(extract(Month FROM P2.start_date) = " . $month . " )GROUP BY P1.label, P2.Field, extract(Quarter from P2.start_date)) as PG
		ON (PM.id = PG.field) WHERE PM.period = 1 and  PM.subcategory = '" . $subcategory . "' and PM.id IN(" . implode(', ', $checklist) . ")";
            $result = $this->db->query($query);
            $listvalue = $result->result_array();
            for ($i = 0; $i < count($listvalue); $i++) {
                foreach ($fieldvalues as $key => $value) {
                    if ($key == $listvalue[$i]['label']) {
                        $listvalue[$i]['answer'] = $value;
                    }
                }
            }
            return $listvalue;
        }

    }
    public function getmonthanswerreport($frequency, $checklist = array(), $innovation, $month, $subcategory, $year, $type, $mastertype, $criteria)
    {
        $data = array();
        $fieldvalues = array();
        $checklist = (count($checklist) == 0) ? array('NULL') : $checklist;
        $field_name = 'answer';
        if ($type == 'activity') {
            if ($this->session->userdata('user_type') != 'incubatee') {
                $field_name = 'villgro_answer';
            }
            if ($this->session->userdata('user_type') == 'abi') {
                $field_name = 'manager_answer';
            }
            $query = "SELECT PM.label,PM.id,PM.period,PM.criteria,PG.answer,PG.document from progress_master as PM LEFT JOIN (SELECT P1.label, P2." . $field_name . " as answer,P2.document as document,P2.Field, extract(month from P2.start_date) as month from progress_master as P1 JOIN progress as P2 ON (P1.id = P2.field) WHERE P2.date_type= 2 AND (extract(Year FROM P2.start_date) = " . $year . ") AND  (P2.innovation in (0,'" . $innovation . "')) AND (extract(month FROM P2.start_date) = " . $month . " )GROUP BY P1.label, P2.Field, extract(Quarter from P2.start_date)) as PG ON (PM.id = PG.field) WHERE PM.period = 2 and PM.type='activity' and PM.criteria = '" . $criteria . "' and  PM.id IN(" . implode(', ', $checklist) . ")";
            $result = $this->db->query($query);
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            $buildqry = "SELECT PG.answer as answer,PM.label FROM progress as PG LEFT JOIN progress_master as PM
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
            $query = "SELECT PM.label,PM.id as id,PM.pid as pid,PM.value,PM.input_type,PM.subcategory as subcategory,PM.id,PM.period,PM.criteria,PG.answer from progress_master as PM LEFT JOIN (SELECT P1.label, P2.answer as answer, P2.Field, extract(month from P2.start_date) as month from progress_master as P1 JOIN progress as P2 ON (P1.id = P2.field) WHERE P2.date_type= 2 AND (extract(Year FROM P2.start_date) = " . $year . ") AND  P2.innovation ='" . $innovation . "' AND (extract(month FROM P2.start_date) = " . $month . " )GROUP BY P1.label, P2.Field, extract(Quarter from P2.start_date)) as PG ON (PM.id = PG.field) WHERE PM.period = 2 and  PM.subcategory = '" . $subcategory . "'";
            $result = $this->db->query($query);
            $listvalue = $result->result_array();
            for ($i = 0; $i < count($listvalue); $i++) {
                foreach ($fieldvalues as $key => $value) {
                    if ($key == $listvalue[$i]['label']) {
                        $listvalue[$i]['answer'] = $value;
                    }

                }
                $listvalue[$i]['value'] = unserialize($listvalue[$i]['value']);
            }

            $treeanswer = $this->buildTree($listvalue);
            return $treeanswer;
        }

    }
    public function getcriteria($mastername)
    {
        $data = array();
        $this->db->select('id');
        $this->db->where('master_name', $mastername);
        $query = $this->db->get('master_settings');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getquarterreport($frequency, $checklist = array(), $innovation, $month, $subcategory, $year, $type, $mastertype, $criteria)
    {
        $data = array();
        $fieldvalues = array();
        $checklist = (count($checklist) == 0) ? array('NULL') : $checklist;
        $field_name = 'answer';
        if ($type == 'activity') {
            if ($this->session->userdata('user_type') != 'incubatee') {
                $field_name = 'villgro_answer';
            }
            if ($this->session->userdata('user_type') == 'abi') {
                $field_name = 'manager_answer';
            }
            $query = "SELECT PM.label,PM.id,PM.period,PM.criteria,PG.answer,PG.document from progress_master as PM
		LEFT JOIN (SELECT P1.label, (P2.villgro_answer) as answer,P2.document as document,
		P2.Field, extract(month from P2.start_date) as month from progress_master as P1 JOIN progress as P2 ON (P1.id = P2.field)
		WHERE P2.date_type= 3  AND (extract(Year FROM P2.start_date) = " . $year . ") AND  P2.innovation ='" . $innovation . "' AND
		(extract(Quarter FROM P2.start_date) = '" . $month . "')
		GROUP BY P1.label, P2.Field,
		extract(Quarter from P2.start_date)) as PG ON (PM.id = PG.field) WHERE PM.period = 3 and PM.type='activity'
		and PM.criteria = '" . $criteria . "' and  PM.id IN(" . implode(', ', $checklist) . ")";
            $result = $this->db->query($query);

            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
            return $data;

        } else {
            $buildqry = "SELECT PG.answer as answer,PM.label FROM progress as PG LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
						PG.date_type = 3 AND (extract(Year FROM PG.start_date) in (0,  " . $year . ")) AND
						(PG.innovation in (0,'" . $innovation . "')) AND (extract(month FROM PG.start_date) in (0, " . $month . "))
						AND PM.type = 'metrices' AND PM.id IN(" . implode(', ', $checklist) . ")";
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
            $query = "SELECT PM.label,PM.input_type,PM.value,PM.subcategory as subcategory,PM.id,PM.period,PM.criteria,PG.answer from
		progress_master as PM LEFT JOIN (SELECT P1.label, P2.answer as answer, P2.Field, extract(month from P2.start_date)
		as month from progress_master as P1 JOIN progress as P2 ON (P1.id = P2.field) WHERE P2.date_type= 3 AND
		(extract(Year FROM P2.start_date) = " . $year . ") AND  P2.innovation ='" . $innovation . "' AND
		(extract(Quarter FROM P2.start_date) = " . $month . " )GROUP BY P1.label, P2.Field, extract(Quarter from P2.start_date)) as PG
		ON (PM.id = PG.field) WHERE PM.period = 3 and  PM.subcategory = '" . $subcategory . "' and PM.id IN(" . implode(', ', $checklist) . ")";
            $result = $this->db->query($query);
            $listvalue = $result->result_array();
            for ($i = 0; $i < count($listvalue); $i++) {
                foreach ($fieldvalues as $key => $value) {
                    if ($key == $listvalue[$i]['label']) {
                        $listvalue[$i]['answer'] = $value;
                        $listvalue[$i]['value'] = unserialize($listvalue[$i]['value']);
                    }
                }
            }
            return $listvalue;
        }

    }

    public function getyearanswerreport($frequency, $checklist = array(), $innovation, $month, $subcategory, $year, $type, $mastertype, $criteria)
    {
        $data = array();
        $fieldvalues = array();
        $checklist = (count($checklist) == 0) ? array('NULL') : $checklist;
        $field_name = 'answer';
        if ($type == 'activity') {
            if ($this->session->userdata('user_type') != 'incubatee') {
                $field_name = 'villgro_answer';
            }
            if ($this->session->userdata('user_type') == 'abi') {
                $field_name = 'manager_answer';
            }
            $query = "SELECT PM.label,PM.id,PM.period,PM.criteria,PG.answer,PG.document from progress_master as PM
		LEFT JOIN (SELECT P1.label, P2." . $field_name . " as answer,P2.document as document,P2.Field,
		extract(month from P2.start_date) as month from progress_master as P1 JOIN progress as P2 ON (P1.id = P2.field)
		WHERE P2.date_type= 4 AND (extract(Year FROM P2.start_date) = " . $year . ") AND
		(P2.innovation in (0,'" . $innovation . "')) GROUP BY P1.label, P2.Field, extract(Quarter from P2.start_date)) as PG
		ON (PM.id = PG.field) WHERE PM.period = 4 and PM.type='activity' and PM.criteria = '" . $criteria . "' and
		PM.id IN(" . implode(', ', $checklist) . ")";
            $result = $this->db->query($query);
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            $buildqry = "SELECT PG.answer as answer,PM.label FROM progress as PG LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
						PG.date_type = 4 AND (extract(Year FROM PG.start_date) in (0,  " . $year . "))
						AND  (PG.innovation in (0,'" . $innovation . "'))
						AND PM.type = 'metrices' AND PM.id IN(" . implode(', ', $checklist) . ")";
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
            $query = "SELECT PM.label,PM.input_type,PM.value,PM.subcategory as subcategory,PM.id,PM.period,PM.criteria,PG.answer from progress_master as PM
		LEFT JOIN (SELECT P1.label, P2.answer as answer, P2.Field, extract(month from P2.start_date) as month from progress_master as P1
		JOIN progress as P2 ON (P1.id = P2.field) WHERE P2.date_type= 4 AND (extract(Year FROM P2.start_date) = " . $year . ") AND
		P2.innovation ='" . $innovation . "' GROUP BY P1.label, P2.Field, extract(Quarter from P2.start_date)) as PG ON (PM.id = PG.field) WHERE PM.period = 4 and  PM.subcategory = '" . $subcategory . "'
		and PM.id IN(" . implode(', ', $checklist) . ")";
            $result = $this->db->query($query);
            $listvalue = $result->result_array();
            for ($i = 0; $i < count($listvalue); $i++) {
                foreach ($fieldvalues as $key => $value) {
                    if ($key == $listvalue[$i]['label']) {
                        $listvalue[$i]['answer'] = $value;
                        $listvalue[$i]['value'] = unserialize($listvalue[$i]['value']);
                    }
                }
            }
            return $listvalue;
        }

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
                if (array_key_exists($operand, $fieldvalues)) {
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
            if (array_key_exists($operand, $fieldvalues)) {
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
    public function update_data($field, $data, $rownum, $start_date, $end_date, $frequency, $category, $innovation)
    {

        $query = "select villgro_answer,answer from progress where field = '" . $rownum . "' AND start_date = '" . $start_date . "' AND end_date = '" . $end_date . "' AND date_type ='" . $frequency . "' AND criteria = '" . $field . "' AND innovation='" . $innovation . "'";
        $result = $this->db->query($query);
        $value = $result->result_array();
        $field_name = 'answer';
        if ($category == 'activity') {
            if (($this->session->userdata('user_type') != 'incubatee') && ($this->session->userdata('user_type') != 'abi')) {
                $field_name = 'villgro_answer';
            } else if ($this->session->userdata('user_type') == 'abi') {
                $field_name = 'manager_answer';
            } else {
                $field_name = 'answer';
            }
        }
        if ($result->num_rows() > 0) {
            $query2 = "UPDATE progress
		        SET " . $field_name . "='" . $data . "'
		        WHERE field='" . $rownum . "' AND start_date = '" . $start_date . "'AND end_date ='" . $end_date . "' AND date_type='" . $frequency . "' AND criteria ='" . $field . "' AND innovation = '" . $innovation . "'";
            $this->db->query($query2);
        } else {
            echo $field_name;
            $username = $this->session->userdata('user_name');
            $sql = "INSERT INTO progress(innovation,criteria," . $field_name . ",field,start_date,end_date,date_type," . $field_name . "by)
	       VALUES('$innovation','$field','$data','$rownum','$start_date','$end_date','$frequency','$username')";
            $this->db->query($sql);
        }
    }
    public function insertdocument($options = array())
    {
        $documents = serialize($options['filename']);
        if ($this->checkduplicate($options)) {
            $username = $this->session->userdata('user_name');
            $data = array('innovation' => $options['innovation'],
                'criteria' => $options['criteria'],
                'document' => $documents,
                'field' => $options['field'],
                'date_type' => $options['frequency'],
                'start_date' => $options['start_date'],
                'end_date' => $options['end_date']);
            $result = $this->db->insert('progress', $data);
            return $result;
        } else {

            $data2 = array('document' => $documents);
            $this->db->where('innovation', $options['innovation']);
            $this->db->where('criteria', $options['criteria']);
            $this->db->where('field', $options['field']);
            $this->db->where('start_date', $options['start_date']);
            $this->db->where('end_date', $options['end_date']);
            $this->db->where('date_type', $options['frequency']);
            $result = $this->db->update('progress', $data2);
            return $result;
        }

    }
    public function checkduplicate($options = array())
    {
        $this->db->select('PG.*');
        $this->db->where('innovation', $options['innovation']);
        $this->db->where('criteria', $options['criteria']);
        $this->db->where('field', $options['field']);
        $this->db->where('start_date', $options['start_date']);
        $this->db->where('end_date', $options['end_date']);
        $this->db->where('date_type', $options['frequency']);
        $query = $this->db->get('progress PG');
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }

    }
    public function getfellowList()
    {
        $data = array();
        $this->db->select('emp_number', 'emp_firstname');
        $this->db->where('emp_type', 'fellow');
        $query = $this->hris->get('hs_hr_employee');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }
    public function getratios($innovation, $checklist = array())
    {
        $data = array();
        $this->db->select("PM.id,PM.label,PM.criteria,(select master_name from master_settings where id=PM.criteria) as master_name");
        $checklist = (count($checklist) == 0) ? array('') : $checklist;
        $this->db->where_in('PM.id', $checklist);
        $this->db->where('PM.type', 'metrices');
        $this->db->where('criteria', '102');
        $this->db->where('subcategory', 'Ratios Concepts and Calculations');
        $query = $this->db->get('progress_master PM');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function insertanswer($innovation, $options = array())
    {
        foreach ($options as $key => $value) {
            if ($value != '') {
                $data = array('innovation' => 0,
                    'criteria' => 102,
                    'field' => $key,
                    'answer' => $value,
                    'date_type' => 2);
                $this->db->insert('progress', $data);
            }

        }

    }
    public function insertlist($label, $criteria, $value, $innovation, $datetype, $start_date, $end_date)
    {
        $query = "INSERT INTO progress(innovation,criteria,answer,field,start_date,end_date,date_type)
	       VALUES('$innovation','$criteria','$value','$label','$start_date','$end_date','$datetype')";
        $result = $this->db->query($query);
        debug_last_query();
    }

    public function activitydone($label, $innovation)
    {

        $data = array('done' => '1');
        $this->db->where('label', $label);
        $this->db->where('innovation', $innovation);
        $result = $this->db->update('progress_validation', $data);
        return $result;
    }
}
