<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_details($table_name = '', $condition = array(), $fields = array(), $limit = '', $start = '', $order_by = '', $change_db = false, $db_name = '', $join = '', $groupby = '', $sum = '', $like = array()) {


        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }

        if (!empty($join)) {
            for ($i = 0; $i < count($join); $i++) {
                $db_var->select($join[$i]['select']);
                $db_var->join($join[$i]['table'], $join [$i]['condition'], $join [$i] ['type']);
            }
        }

        if ($sum != '') {
            $this->db->select_sum($sum);
        }

        $db_var->select($fields);
        if (!empty($condition)) {
            $db_var->where($condition);
        }

//        if ($table_name != 'hr_user_reporting') {
        if ($groupby) {
            $db_var->group_by($groupby);
        }
//        }

        if (!empty($order_by)) {
            $db_var->order_by(array_keys($order_by)[0], array_values($order_by)[0]);
        }

        if ($limit != '') {
            $db_var->limit($limit, $start);
        }
        if (!empty($like)) {
            $db_var->like($like);
        }
        if ($table_name != '') {
            $query = $db_var->get($table_name);
        }

        return $rows = $query->result();
    }

    public function get_all_details_win($table_name = '', $condition = array(), $fields = array(), $limit = '', $start = '', $order_by = '', $change_db = false, $db_name = '') {
        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        $db_var->select($fields);
        if (!empty($condition)) {
            foreach ($condition as $key => $val) {
                $db_var->where_in($key, $val);
            }
        }
        if (!empty($order_by)) {
            $db_var->order_by(array_keys($order_by)[0], array_values($order_by)[0]);
        }

        if ($limit != '') {
            $db_var->limit($limit, $start);
        }

        if ($table_name != '') {
            $query = $db_var->get($table_name);
        }
        return $rows = $query->result();
    }

    public function insert_data($table_name = '', $data = array(), $change_db = false, $db_name = '') {
        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        $db_var->insert($table_name, $data);
    }

    public function insert_batch($table_name = '', $data = array(), $change_db = false, $db_name = '') {
        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        $db_var->insert_batch($table_name, $data);
    }

    public function delete_data($table_name = '', $condition = array(), $change_db = false, $db_name = '') {
        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        $db_var->where($condition);
        $db_var->delete($table_name);
    }

    public function delete_data_in($table_name = '', $condition = array(), $change_db = false, $db_name = '') {
        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        if (!empty($condition)) {
            foreach ($condition as $key => $val) {
                $db_var->where_in($key, $val);
            }
        }
        $db_var->delete($table_name);
    }

    public function update_data($table_name = '', $condition = array(), $data = array(), $change_db = false, $db_name = '') {
        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        $db_var->where($condition);
        $query = $db_var->update($table_name, $data);
    }

}
