<?php

class Mprofile extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	

	public function insert($table, $data) {
		$last_inserted = $this->db->insert($table, $data);
		return $last_inserted;
	}

	public function update($table, $data, $emp_id) {
		//echo'<pre>';print_r('hi');die;
        if ($emp_id != '') {
            $this->db->where('id',$emp_id);
        }

        $result = $this->db->update($table, $data);

        return $result;
    }

    public function getpersonalType($emp_id) {

    $query = "SELECT  *,ut.user_type FROM hr_user_profile AS up
			  LEFT JOIN hr_user_type AS ut ON ut.id = up.emp_type
 			  where up.id = $emp_id";
    $result = $this->db->query($query);
    return $result->result_array();
    }

    public function getCommonDetails($table, $condition = '', $orderby = '', $column = '') {

        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($column == '') {
            if ($orderby != '') {
                $this->db->order_by('id', $orderby);
            } else {
                $this->db->order_by('id', 'desc');
            }
        } else {
            if ($orderby != '') {
                $this->db->order_by($column, $orderby);
            } else {
                $this->db->order_by($column, 'desc');
            }
        }

        $this->db->select('*');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    function getReportingEmployee($id) {
        $cond = "emp_type IN(2,3)";
        $this->db->where($cond);
        $this->db->select("id,emp_name");
        $this->db->where(array("id <>" => "$id", 'status' => 1));
        $this->db->order_by('emp_name', 'asc');
        $query = $this->db->get("hr_user_profile");
        $rows = $query->result_array();
        return $rows;
    }

    function getReportingList($table, $id, $field, $column) {
        $this->db->select("t1.id,t1.report_supervisor,t1.report_subordinate,t1.report_method,t2.emp_name");
        $this->db->join("hr_user_profile t2", "t2.id =  t1.$field", 'left');
        $this->db->where(array("t1.$column" => "$id", 't1.status' => 1, 't2.status' => 1));
        $query = $this->db->get("$table t1");
        $rows = $query->result_array();
        return $rows;
    }

    public function last_employee_id() {

        $this->db->select('id');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('hr_user_profile');
        $rows = $query->result_array();
        return $rows;
    }
	

}
