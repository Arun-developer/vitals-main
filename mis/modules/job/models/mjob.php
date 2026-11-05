<?php

class Mjob extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function last_employee_id() {

        $this->db->select('id');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('hr_user_profile');
        $rows = $query->result_array();
        return $rows;
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

    public function getDTJobCount($search_field, $search_value, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.job_title,t2.specification_name,t3.grade_name,t4.partner_name");
        $this->db->join('hr_job_specification t2', 't2.id =  t1.specification_id', 'left');
        $this->db->join('hr_salary_grade t3', 't3.id =  t1.pay_grade', 'left');
        $this->db->join('hr_partner_type t4', 't4.id =  t1.partner_id', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "t1.id = '$search_value'";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(t1.job_title LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "(t2.specification_name LIKE '%$search_value%')";
        } else if ($search_field == '4' && $search_value != '') {
            $cond = "(t3.grade_name LIKE '%$search_value%')";
        } else if ($search_field == '5' && $search_value != '') {
            $cond = "t4.partner_name LIKE '%$search_value%'";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        if ($this->session->userdata['user_type'] != 'superadmin') {
            $partner_id = $this->session->userdata['partner_id'];
            $this->db->where('t1.partner_id', $partner_id);
        }

        $this->db->where('t1.status', '1');
        $query = $this->db->get('hr_job_designation t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTJobDetails($num, $offset, $search_field, $search_value, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.job_title,t2.specification_name,t3.grade_name,t4.partner_name");
        $this->db->join('hr_job_specification t2', 't2.id =  t1.specification_id', 'left');
        $this->db->join('hr_salary_grade t3', 't3.id =  t1.pay_grade', 'left');
        $this->db->join('hr_partner_type t4', 't4.id =  t1.partner_id', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "t1.id = '$search_value'";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(t1.job_title LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "(t2.specification_name LIKE '%$search_value%')";
        } else if ($search_field == '4' && $search_value != '') {
            $cond = "(t3.grade_name LIKE '%$search_value%')";
        } else if ($search_field == '5' && $search_value != '') {
            $cond = "t4.partner_name LIKE '%$search_value%'";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        if ($this->session->userdata['user_type'] != 'superadmin') {
            $partner_id = $this->session->userdata['partner_id'];
            $this->db->where('t1.partner_id', $partner_id);
        }

        $this->db->where('t1.status', '1');
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_job_designation t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function deleteJobDetail($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', '2');
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteCommonDetail($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', '2');
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function getDTJobLocationCount($search_field, $search_value, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.location_name,t2.country_name,t1.city,t1.zipcode");
        $this->db->join('hr_country t2', 't2.id =  t1.country', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "t1.id = '$search_value'";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(t1.location_name LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "(t2.country_name LIKE '%$search_value%')";
        } else if ($search_field == '4' && $search_value != '') {
            $cond = "(t1.city LIKE '%$search_value%')";
        } else if ($search_field == '5' && $search_value != '') {
            $cond = "(t1.zipcode LIKE '%$search_value%')";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $query = $this->db->get('hr_job_location t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTJobLocationDetails($num, $offset, $search_field, $search_value, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.location_name,t2.country_name,t1.city,t1.zipcode");
        $this->db->join('hr_country t2', 't2.id =  t1.country', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "t1.id = '$search_value'";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(t1.location_name LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "(t2.country_name LIKE '%$search_value%')";
        } else if ($search_field == '4' && $search_value != '') {
            $cond = "(t1.city LIKE '%$search_value%')";
        } else if ($search_field == '5' && $search_value != '') {
            $cond = "(t1.zipcode LIKE '%$search_value%')";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_job_location t1');
        $rows = $query->result_array();
        return $rows;
    }

}
