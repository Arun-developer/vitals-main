<?php

class Mmaster extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
        $this->hris = $this->load->database('hris', true);
    }

    // public function getAllUserList() {
    //     $data = array();
    //     // $this->hris->distinct('hr_employee.emp_firstname');
    //     $this->hris->select("hr_users.id,CONCAT_WS(' ',emp_firstname,emp_lastname) as user_name,hr_employee.emp_number", false);
    //     $this->hris->where('hr_employee.emp_partner_id', $this->session->userdata('partner_id'));
    //     // $this->hris->where_in('emp_type', array('employee', 'fellow', 'consultant', 'student'));
    //     $this->hris->join('hr_users', 'hr_users.emp_number = hr_employee.emp_number');
    //     $this->hris->order_by('hr_employee.emp_firstname');
    //     $query = $this->hris->get('hr_employee');
    //     if ($query->num_rows() > 0) {
    //         foreach ($query->result_array() as $row) {
    //             $data[] = $row;
    //         }
    //     }
    //     $query->free_result();
    //     return $data;
    // }


    public function getAllUserList() {
        $data = array();
        // $this->hris->distinct('hr_employee.emp_firstname');
        $this->db->select("hr_user_profile.id, hr_user_profile.emp_name as user_name, hr_user_profile.id as emp_number");
        $this->db->where('hr_user_profile.partner_id', $this->session->userdata('partner_id'));
        // $this->hris->where_in('emp_type', array('employee', 'fellow', 'consultant', 'student'));
		$this->db->where('hr_user_login.status', '1');
        $this->db->join('hr_user_login', 'hr_user_login.emp_id = hr_user_profile.id');
        $this->db->order_by('hr_user_profile.emp_name');
        $query = $this->db->get('hr_user_profile');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getEmployeenameFromUserId($userid) {
        $data = array();
        $data = $this->getUserNameInfo($userid);

        if (count($data))
            return $data['0']['user_name'];
        else
            return '--';
    }

    // public function getUserNameInfo($userid) {
    //     $data = array();
    //     $this->hris->select("hr_users.emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as user_name,emp_work_email,emp_oth_email", false);
    //     $this->hris->where('id', $userid);
    //     $this->hris->join('hr_employee', 'hr_employee.emp_number = hr_users.emp_number');
    //     $query = $this->hris->get('hr_users');
    //     if ($query->num_rows() > 0) {
    //         foreach ($query->result_array() as $row) {
    //             $data[] = $row;
    //         }
    //     }
    //     return $data;
    // }

    public function getUserNameInfo($userid) {
        $data = array();
        $this->db->select("hr_user_profile.id as emp_number, hr_user_profile.emp_name as user_name, hr_user_profile.official_email as emp_work_email, hr_user_profile.personal_email as emp_oth_email");
        $this->db->where('id', $userid);
        $query = $this->db->get('hr_user_profile');
// echo debug_last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function showMaster($master_id) {
        // $ci = &get_instance();
        if ($master_id == '')
            return '-';
        $data = array();
        $this->ais->where('master_id', $master_id);
        $query = $this->ais->get_where('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data['0']['master_name'];
    }

    public function add_adminemail($email) {
        $data = array('email2' => $email);
        $this->db->where('id', 'USR001');
        $this->db->update('hr_users', $data);

        $this->load->library('session');
        $this->session->set_userdata('adminemail', $email);
        return true;
    }

    public function getAdminemail() {
        $this->db->where('id', 'USR001');
        $query = $this->db->get('hr_users');
        $rows = $query->result_array();
        return $rows;
    }

    public function getRecords($TableName = null, $Label = null, $Id = null) {
        $this->ais = $this->load->database('ais', true);
        $data = array();
        if ($Id != null && $Label != null) {
            $this->ais->where($Label, $Id);
        }

        $query = $this->ais->get($TableName);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getMasterSettings($masterType = null) {
        $data = array();
        $this->db->where('master_type', $masterType);
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getMasterSettingsDetails($id = null) {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getSouceList($sourceType = null) {
        $data = array();
        if ($sourceType != null) {
            $terms['source_type'] = $sourceType;
        }

        $query = $this->db->get_where('source_master', $terms);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getInstanceList($source) {
        $data = array();
        if ($source != null) {
            $terms['source_id'] = $source;
        }

        $query = $this->db->get_where('instance_master', $terms);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getEmpUserID($emp_id) {
        $user_id = '';
        $this->hris->select('id');
        $this->hris->where('emp_number', $emp_id);
        $query = $this->hris->get('hs_hr_users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $user_id = $row['id'];
            }
        }
        return $user_id;
    }

    public function updateUserSetup($form) {
        $form['icm'] = (isset($form['icm'])) ? $form['icm'] : array();
        $form['abi'] = (isset($form['abi'])) ? $form['abi'] : array();
        $data = array(
            'ceo' => $form['ceo'],
            'cio' => $form['cio'],
            'icm' => serialize($form['icm']),
            'abi' => serialize($form['abi']),
            'pre_ic' => $form['pre_ic'],
        );
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $this->db->update('user_setup', $data);
        $user_id = $this->getEmpUserID($form['ceo']);
        $this->ais = $this->load->database('ais', true);
        $data1 = array(
            'ceo' => $user_id,
            'finance' => serialize($form['finance']),
        );
        $this->ais->where('partner_id', $branch);
        $this->ais->update('approval_setting', $data1);
        return true;
    }

    public function getDonorTeam($table_name, $branch) {
        $this->db->select('donor_team');
        if ($branch != '') {
            $this->db->where('partner_id', $branch);
        }

        $query = $this->db->get('user_setup');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getUserSetup() {
        $data = array();
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->db->get('user_setup');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['icm'] = @unserialize($row['icm']);
                $row['abi'] = @unserialize($row['abi']);
                $data[] = $row;
            }
        }
        return array_pop($data);
    }

    public function getStageDate() {
        return array("New" => 'created_date', "Entry" => 'entry_date', "Lead" => 'lead_date', "Shortlisted" => 'shortlist_date', "Leads for Due-Diligence" => '', "Incubation" => '');
    }

    public function getStageEfficient() {

        $data = array();

        $query = $this->db->get('stagefficiency');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function findtimelimit($stage = null) {
        $data = array();
        $query = $this->db->get('stagefficiency');
        if ($id != '') {
            $this->db->where('id', '1');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getEmpIdBySetUP($type = null, $branch = '') {
        $this->db->select($type);
        if ($branch != '') {
            $this->db->where('partner_id', $branch);
        }

        $query = $this->db->get('user_setup');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return '';
    }

    public function getBranch() {
        $this->db->select('*');
        $this->db->where('status', '1');
        $query = $this->db->get('hr_partner_type');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return '';
    }

    public function getYbranch($id) {
        $this->db->select('partner_name as branch_name');
        $this->db->where('id', $id);
        $query = $this->db->get('hr_partner_type');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return '';
    }

    public function getUserSetup_branch($branch) {
        $this->db->where('partner_id', $branch);
        $query = $this->db->get('user_setup');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['icm'] = @unserialize($row['icm']);
                $row['abi'] = @unserialize($row['abi']);
            }
        }

        $this->ais = $this->load->database('ais', true);
        $this->ais->where('partner_id', $branch);
        $query2 = $this->ais->get('approval_setting');
        if ($query2->num_rows() > 0) {
            $finance_id = array();
            foreach ($query2->result_array() as $row2) {
                $row2['finance'] = @unserialize($row2['finance']);
            }
        }
        $data[] = array_merge($row, $row2);
        return array_pop($data);
    }

    public function insertUserSetup($form) {
        $this->ais = $this->load->database('ais', true);
        $branch = $form['branch'];
        $this->db->where('partner_id', $branch);
        $this->db->select('*');
        $query = $this->db->get('user_setup');
        if ($query->num_rows() == 0) {
            $data = array(
                'partner_id' => $form['branch'],
                'ceo' => $form['ceo'],
                'cio' => $form['cio'],
                'icm' => serialize($form['icm']),
                'abi' => serialize($form['abi']),
                'pre_ic' => $form['pre_ic'],
            );
            $result = $this->db->insert('user_setup', $data);
            $user_id = $this->getEmpUserID($form['ceo']);
            $data1 = array(
                'ceo' => $user_id,
                'finance' => serialize($form['finance']),
                'partner_id' => $form['branch'],
            );
            $this->ais->insert('approval_setting', $data1);
        } else {
            $data = array(
                'ceo' => $form['ceo'],
                'cio' => $form['cio'],
                'icm' => serialize($form['icm']),
                'abi' => serialize($form['abi']),
                'pre_ic' => $form['pre_ic'],
            );
            $this->db->where('partner_id', $branch);
            $result = $this->db->update('user_setup', $data);
        }

        $this->ais->where('partner_id', $branch);
        $this->ais->select('*');
        $query = $this->ais->get('approval_setting');
        if ($query->num_rows() == 0) {
            $user_id = $this->getEmpUserID($form['ceo']);
            $data1 = array(
                'ceo' => $user_id,
                'partner_id' => $branch,
                'finance' => serialize($form['finance']),
            );
            $this->ais->insert('approval_setting', $data1);
        } else {
            $user_id = $this->getEmpUserID($form['ceo']);
            $data1 = array(
                'ceo' => $user_id,
                'finance' => serialize($form['finance']),
            );
            $this->ais->where('partner_id', $form['branch']);
            $this->ais->update('approval_setting', $data1);
        }
        return $result;
    }

    public function getDTPartnerCount($search_field, $search_value, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("id,partner_name,partner_email,currency,ais_privilege,status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "(partner_name LIKE '%$search_value%')";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(partner_email LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "(currency LIKE '%$search_value%')";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('status <>', '2');
        $query = $this->db->get('hr_partner_type');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTPartnerDetails($num, $offset, $search_field, $search_value, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("id,partner_name,partner_email,currency,ais_privilege,status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "(partner_name LIKE '%$search_value%')";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(partner_email LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "(currency LIKE '%$search_value%')";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('status <>', '2');
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_partner_type');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMasterDetails($table, $cond = '', $status = '') {

        if ($cond != '') {
            $this->db->where($cond);
        }

        if ($status != '') {
            $this->db->where('status  !=', '3');
        }

        $this->db->select("*");
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getAisMasterDetails($table, $cond = '', $status = '') {

        if ($cond != '') {
            $this->ais->where($cond);
        }

        if ($status != '') {
            $this->ais->where('status  !=', '3');
        }

        $this->ais->select("*");
        $query = $this->ais->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTJobCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("id,specification_name,specification_description,specification_duties,status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->db->where($search_field);
        }

        $this->db->where(array('status !=' => '3'));
        $query = $this->db->get('hr_job_specification');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTJobDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("id,specification_name,specification_description,specification_duties,status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->db->where($search_field);
        }

        $this->db->where(array('status !=' => '3'));
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_job_specification');
        $rows = $query->result_array();
        return $rows;
    }

    /* pay grade server side datatable */

    public function getDTGradeCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("id,grade_name,status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->db->where($search_field);
        }

        $this->db->where(array('status !=' => '3'));
        $query = $this->db->get('hr_salary_grade');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTGradeDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("id,grade_name,status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->db->where($search_field);
        }

        $this->db->where(array('status !=' => '3'));
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_salary_grade');
        $rows = $query->result_array();
        return $rows;
    }

    /* Job type server side datatable */

    public function getDTJobTypeCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("id,job_name,status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->db->where($search_field);
        }

        $this->db->where(array('status !=' => '3'));
        $query = $this->db->get('hr_job_type');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTJobTypeDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("id,job_name,status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->db->where($search_field);
        }

        $this->db->where(array('status !=' => '3'));
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_job_type');
        $rows = $query->result_array();
        return $rows;
    }

    /* Job department server side datatable */

    public function getDTJobDeptCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.job_department,t1.status,t2.partner_name");
        $this->db->join('hr_partner_type t2', 't2.id =  t1.partner_id', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->db->where($search_field);
        }
        if ($this->session->userdata['user_type'] != 'superadmin') {
            $partner_id = $this->session->userdata['partner_id'];
            $this->db->where('t1.partner_id', $partner_id);
        }

        $this->db->where(array('t1.status !=' => '3'));
        $query = $this->db->get('hr_job_department t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTJobDeptDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.job_department,t1.status,t2.partner_name");
        $this->db->join('hr_partner_type t2', 't2.id =  t1.partner_id', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->db->where($search_field);
        }
        if ($this->session->userdata['user_type'] != 'superadmin') {
            $partner_id = $this->session->userdata['partner_id'];
            $this->db->where('t1.partner_id', $partner_id);
        }

        $this->db->where(array('t1.status !=' => '3'));
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_job_department t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMasterList($partner_id = '', $type = '') {
        $option = array('partner_id' => $partner_id, 'master_type' => $type, 'status' => '1');
        $this->ais->select("master_id, pid, master_type, master_name,status");
        $this->ais->where($option);
        $this->ais->order_by("master_name", "asc");
        $query = $this->ais->get('master_settings');
        // if($this->session->userdata['emp_number'] == '275' || $this->session->userdata['emp_number'] == '317') {
            // echo $this->ais->last_query(); exit;
        // }
        $rows = $query->result_array();
        return $rows;
    }

    public function getChildMasterList($pid = '', $mtype = '') {
        $option = array('pid' => $pid, 'master_type' => $mtype, 'status' => '1');
        $this->ais->select("master_id, pid, master_type, master_name,status");
        $this->ais->where($option);
        $this->ais->order_by("master_name", "asc");
        $query = $this->ais->get('master_settings');
        $rows = $query->result_array();
        return $rows;
    }

    public function getGrantByDonor($search = '') {
        $option = array('status_type' => 'open');
        $this->db->select("id, name, grant_id, grant_amount,status_type");
        if ($search != '') {
            $this->db->where($search);
        }
        $this->db->where($option);
        $this->db->order_by("name", "asc");
        $query = $this->db->get('grant_list');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDonorByProgramme($pid = '', $master_type = '') {
        
        if ($pid != '') {
            $m_cond = "master_id IN ($pid)";
            $this->ais->where($m_cond);
        }

        if ($master_type != '') {
            $this->ais->where(array('master_type' => $master_type));
        }
        $option = array('status' => '1');
        $this->ais->select("master_id, pid, master_type, master_name,status");
        $this->ais->where($option);
        $this->ais->order_by("master_name", "asc");
        $query = $this->ais->get('master_settings');
        // if($this->session->userdata('emp_number') == '275') {
        //     echo $this->ais->last_query(); die;
        // }
        $rows = $query->result_array();
        return $rows;
    }

    public function getProgramme($donor = '', $id = '') {

        $option = array('partner_id' => $this->session->userdata('partner_id'), 'status' => '1');
        if ($id != '')
            $this->ais->where('programme_id', $id);
        if ($donor != '')
            $this->ais->where('donor', $donor);

        $this->ais->select("donor, programme, programme_head, programme_id");
        $this->ais->where($option);
        $this->ais->order_by("programme", "asc");
        $query = $this->ais->get('master_programme');        
        $rows = $query->result_array();
        return $rows;
    }

    /* master server side datatable */

    public function getDTMasterCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("master_id, pid, master_type, master_name,status");
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('status !=' => '-1'));
        $query = $this->ais->get('master_settings');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTMasterDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("master_id, pid, master_type, master_name,status");
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('status !=' => '-1'));
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('master_settings');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTBudgetCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.master_id, t1.pid, t1.master_type, t1.master_name,t1.status,t2.master_name as parent_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.pid');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '-1'));
        $query = $this->ais->get('master_settings t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTBudgetDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.master_id, t1.pid, t1.master_type, t1.master_name,t1.status,t2.master_name as parent_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.pid');

        /* $draw = $this->input->post('draw');
          if($draw == 1){
          $this->ais->order_by('t1.status','desc');
          }else{
          $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
          }
         */
          if ($search_field != '') {
            $this->ais->where($search_field);
        }
        $this->ais->where(array('t1.status !=' => '-1'));

        $this->ais->order_by('t1.status', 'DESC');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $this->ais->limit($num, $offset);

        $query = $this->ais->get('master_settings t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTLineCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.master_id, t1.pid, t1.master_type, t1.master_name,t1.status, t2.master_id as budgetid, t2.master_name as budget_name, t3.master_id as donorid, t3.master_name as donor_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.pid');
        $this->ais->join('master_settings t3', 't3.master_id = t2.pid');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }
        $this->ais->where(array('t1.status !=' => '-1'));
        $query = $this->ais->get('master_settings t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTLineDetails($num, $offset, $search_field, $columns, $requestData) {
        #echo'<pre>';print_r($search_field);die;
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        /* $this->ais->select("t1.master_id, t1.pid, t1.master_type, t1.master_name,t1.status, t2.master_id as budgetid, t2.master_name as budget_name, t3.master_id as donorid, t3.master_name as donor_name");
          $this->ais->join('master_settings t2', 't2.master_id = t1.pid');
          $this->ais->join('master_settings t3', 't3.master_id = t2.pid'); */

          $this->ais->select("t1.master_id, t1.pid, t1.master_type, t1.master_name,t1.status, t2.master_id as budgetid, t2.master_name as budget_name, t3.master_id as donorid, t3.master_name as donor_name");
          $this->ais->join('master_settings t2', 't2.master_id = t1.pid');
          $this->ais->join('master_settings t3', 't3.master_id = t2.pid');

        #$search_field ="t3.master_name LIKE '%AT%' and t3.partner_id ='1'";
        #echo $search_field;die;
        #$search_field ="t1.master_name LIKE '%AT%' and t1.master_name ='AT' and t1.partner_id ='1'";
        //$this->ais->where(array('t1.status !=' => '-1'));

          $this->ais->order_by('t1.status', 'DESC');
          if ($search_field != '') {
            $this->ais->where($search_field);
        }
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $this->ais->limit($num, $offset);
        $query = $this->ais->get('master_settings t1');


        // $this->ais->debug_last_query();
        // echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    public function getMasterAisDetails($table, $condition = '', $status = '', $financial = '', $orderby = '', $column = '') {
        if ($status == '3') {
            $this->ais->where('status !=', $status);
        } else if ($status == '0' || $status == '1') {
            $this->ais->where('status', $status);
        }

        if ($financial != '') {
            $this->ais->where('financial_year', $financial);
        }
        if ($condition != '') {
            $this->ais->where($condition);
        }

        if ($column == '') {
            if ($orderby != '') {
                $this->ais->order_by('id', $orderby);
            } else {
                $this->ais->order_by('id', 'desc');
            }
        } else {
            $this->ais->order_by($column, 'desc');
        }

        $this->ais->select('*');

        $query = $this->ais->get($table);
        // echo $this->ais->last_query(); exit;
        $rows = $query->result_array();
        return $rows;
    }

    /* additional info server side datatable */

    public function getAdditoinalInfoByid($id = '') {
        $this->ais->select("t1.id,t1.programme, t1.donor, t1.budgethead, t1.lineitem,t1.status,t1.additionalinfo, t5.programme as programme_name, t4.master_name as lineitem_name, t3.master_name as budgethead_name, t2.master_name as donor_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.donor');
        $this->ais->join('master_settings t3', 't3.master_id = t1.budgethead');
        $this->ais->join('master_settings t4', 't4.master_id = t1.lineitem');
        $this->ais->join('master_programme t5', 't5.programme_id = t1.programme');
        if ($id != '') {
            $this->ais->where(array('t1.id ' => $id));
        }
        $this->ais->where(array('t1.status !=' => '-1'));
        $query = $this->ais->get('additional_info t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTAdditionalCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.id,t1.programme, t1.donor, t1.budgethead, t1.lineitem,t1.status,t1.additionalinfo, t5.programme as programme_name, t4.master_name as lineitem_name, t3.master_name as budgethead_name, t2.master_name as donor_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.donor');
        $this->ais->join('master_settings t3', 't3.master_id = t1.budgethead');
        $this->ais->join('master_settings t4', 't4.master_id = t1.lineitem');
        $this->ais->join('master_programme t5', 't5.programme_id = t1.programme');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '-1'));
        $query = $this->ais->get('additional_info t1');

        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTAdditionalDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.id,t1.programme, t1.donor, t1.budgethead, t1.lineitem,t1.status,t1.additionalinfo, t5.programme as programme_name, t4.master_name as lineitem_name, t3.master_name as budgethead_name, t2.master_name as donor_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.donor');
        $this->ais->join('master_settings t3', 't3.master_id = t1.budgethead');
        $this->ais->join('master_settings t4', 't4.master_id = t1.lineitem');
        $this->ais->join('master_programme t5', 't5.programme_id = t1.programme');

        /* $draw = $this->input->post('draw');
          if($draw == 1){
          $this->ais->order_by('t1.status','ASC');
          }else{
          $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
          }
         */
          if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '-1'));

        $this->ais->order_by('t1.status', 'DESC');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);



        $this->ais->limit($num, $offset);
        $query = $this->ais->get('additional_info t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTFinancialCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("id, from, to, status");
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('status !=' => '3'));
        $query = $this->ais->get('financial_year');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTFinancialDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("id, from, to, status");
        if($columns[$requestData['order'][0]['column']] =='id'){
         $this->ais->order_by($columns[$requestData['order'][0]['column']],'desc');
     }else{
         $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
     }


     if ($search_field != '') {
        $this->ais->where($search_field);
    }

    $this->ais->where(array('status !=' => '3'));
    $this->ais->limit($num, $offset);
    $query = $this->ais->get('financial_year');
    $rows = $query->result_array();
    return $rows;
}

public function getProgrammeDetails($id = '') {
    $this->ais->select("t1.programme_id, t1.donor, t1.programme, t1.programme_head,t1.an_assign_user,t1.an_assign_user,t1.an_request_sector,t1.status");

    if ($id != '') {
        $this->ais->where('t1.programme_id', $id);
    }
    $this->ais->where('t1.partner_id', $this->session->userdata('partner_id'));

    $this->ais->where(array('t1.status !=' => '-1'));
    $query = $this->ais->get('master_programme t1');
    $rows = $query->result_array();
    return $rows;
}

public function getDTProgrammeCount($search_field, $columns, $requestData) {

        #echo '<pre>';print_r($requestData['order'][0]['column']);die;
    $offset = (!is_numeric($offset)) ? '0' : $offset;
    $this->ais->select("t1.programme_id, t1.donor, t1.programme, t1.programme_head, t1.status");
    $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);


    if ($search_field != '') {
        $this->ais->where($search_field);
    }
    $this->ais->where(array('t1.status !=' => '-1'));
    $this->ais->where('t1.partner_id', $this->session->userdata('partner_id'));
    $query = $this->ais->get('master_programme t1');
    $rows = $query->num_rows();
    return $rows;
}

public function getDTProgrammeDetails($num, $offset, $search_field, $columns, $requestData) {
    $offset = (!is_numeric($offset)) ? '0' : $offset;
    $this->ais->select("t1.programme_id, t1.donor, t1.programme, t1.programme_head, t1.status, t1.an_request_sector");

        /* $draw = $this->input->post('draw');
          if($draw == 1){
          $this->ais->order_by('t1.status','ASC');
          }else{
          $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
          }
         */
          if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '-1'));
        $this->ais->where('t1.partner_id', $this->session->userdata('partner_id'));
        $this->ais->order_by('t1.status');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('master_programme t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function insertMasterDetail($table, $data) {
        $last_inserted = $this->ais->insert($table, $data);
        return $last_inserted;
    }

    public function updateMasterDetail($table, $condition, $fields, $status = '') {
        $this->ais->set($fields);
        if ($condition != '') {
            $this->ais->where($condition);
        }
        if ($status != '' && $status == '3') {
            $this->ais->where('status !=', $status);
        }
        $result = $this->ais->update($table);
        return $result;
    }

    public function deleteMasterDetail($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', '3');
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteMasterSetting($table, $condition, $field, $delval) {

        $option = "$field IN ($condition)";

        if ($delval != '') {
            $setval = $delval;
        } else {
            $setval = '3';
        }
        if ($table == 'master_vendor_contact') { 
            $this->ais->where($option);
            $result = $this->ais->delete('master_vendor_contact');
        } else {

            $this->ais->set('status', $setval);
            if ($condition != '') {
                $this->ais->where($option);
            }
            $result = $this->ais->update($table);
        }
        if ($table == 'financial_year') {
            $this->ais->where($option);
            $result = $this->ais->delete('financial_year');
        }
        if ($table == 'visitors_log') {
            $this->ais->where($option);
            $result = $this->ais->delete('visitors_log');
        }
        if ($table == 'master_books') {
            $this->ais->where($option);
            $result = $this->ais->delete('master_books');
        }
        return $result;
    }

    public function getAssetDetails($type = '', $editid = '', $cond = '',$export_type='') {
        #echo'<pre>';print_r($cond);die;
        $this->ais->select("t1.*, t2.master_name, t2.master_id");
        $this->ais->join('master_settings t2', 't2.master_id = t1.asset_type');
        //$this->ais->join('master_vendor t3', 't3.vendor_id = t1.vendor');
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        if ($type != '') {
            $this->ais->where('t1.type', $type);
        }

        if ($editid != '') {
            $this->ais->where('t1.asset_id', $editid);
        }
        if ($export_type != '') {
            $this->ais->where('t1.type',$export_type);
        }
        
        if ($cond != '') {
            $this->ais->where($cond);
        }

        $this->ais->where(array('t1.status !=' => '3'));
        $query = $this->ais->get('master_asset t1');
        //         echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTAssetCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.*, t2.master_name, t2.master_id");
        $this->ais->join('master_settings t2', 't2.master_id = t1.asset_type');
       # $this->ais->join('master_vendor t3', 't3.vendor_id = t1.vendor','full outer');
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '2'));
        $query = $this->ais->get('master_asset t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTAssetDetails($num, $offset, $search_field, $columns, $requestData) {

        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.*, t2.master_name, t2.master_id");
        $this->ais->join('master_settings t2', 't2.master_id = t1.asset_type');
       # $this->ais->join('master_vendor t3', 't3.vendor_id = t1.vendor','full outer');
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '2'));
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('master_asset t1');
        //$this->ais->debug_last_query();
        //echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    /* vendor details */

    public function getVendorsList($editid = '', $cond = '') {
        $data = array();
        $this->ais->select("vendor_id, vendor_name, contact_person, contact_no, vendor_email, address, website, status");
        if ($editid != '') {
            $this->ais->where('vendor_id', $editid);
        }
        if ($cond != '') {
            $this->ais->where($cond);
        }
        #$this->ais->where('status', '1');
        $this->ais->order_by('vendor_name');
        $query = $this->ais->get('master_vendor');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getVendorscontactList($editid = '') {
        $data = array();
        $this->ais->select("contact_id, vendor_id, name, email, contact_no");
        if ($editid != '') {
            $this->ais->where('vendor_id', $editid);
        }
        $query = $this->ais->get('master_vendor_contact');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getDTVendorCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("vendor_id, vendor_name, contact_person, contact_no, vendor_email, address, website, status");
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('status !=' => '3'));
        $query = $this->ais->get('master_vendor');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTVendorDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("vendor_id, vendor_name, contact_person, contact_no, vendor_email, address, website, status");
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('status !=' => '3'));
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('master_vendor');
        // $this->ais->debug_last_query();
        // echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    /* Books details */

    public function getBooksList($editid = '', $cond = '') {
        $data = array();
        $this->ais->select("t1.book_id, t1.master_id, t1.book_number, t1.book_name, t1.author, t1.available, t1.status, t2.master_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.master_id');
        if ($editid != '') {
            $this->ais->where('t1.book_id', $editid);
        }
        if ($cond != '') {
            $this->ais->where($cond);
        } else {
            $this->ais->where('t1.status', '1');
        }

        $this->ais->order_by('t1.book_name');
        $query = $this->ais->get('master_books t1');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getDTBooksCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.book_id, t1.master_id, t1.book_number, t1.book_name, t1.author, t1.available, t1.status, t2.master_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.master_id');
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '3'));
        $query = $this->ais->get('master_books t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTBooksDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.book_id, t1.master_id, t1.book_number, t1.book_name, t1.author, t1.available, t1.status, t2.master_name");
        $this->ais->join('master_settings t2', 't2.master_id = t1.master_id');
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '3'));
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('master_books t1');
        // $this->ais->debug_last_query();
        // echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    /* visitors details */

    public function getVisitorsList($editid = '', $cond = '') {
        $data = array();
        $this->ais->select("t1.log_id, t1.date, t1.name_of_visitor, t1.name_of_organization, t1.intending_to_meet, t1.purpose, t1.time_in, t1.time_out, t1.innovation, t1.status");
        $this->ais->select("(select emp_name from  " . $this->db->database . ".hr_user_profile where id = t1.intending_to_meet) as user_name", false);
        // $this->db->join('hr_user_profile t3', 't3.id = t1.intending_to_meet');
        if ($editid != '') {
            $this->ais->where('t1.log_id', $editid);
        }
        if ($cond != '') {
            $this->ais->where($cond);
        } else {
            $this->ais->where('t1.status', '1');
        }
        $this->ais->order_by('t1.name_of_visitor');
        $query = $this->ais->get('visitors_log t1');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getDTVisitorsCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.log_id, t1.date, t1.name_of_visitor, t1.name_of_organization, t1.intending_to_meet, t1.purpose, t1.time_in, t1.time_out, t1.innovation, t1.status");

        $this->ais->select("(select emp_name from  " . $this->db->database . ".hr_user_profile where id = t1.intending_to_meet) as user_name", false);
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '3'));
        $query = $this->ais->get('visitors_log t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTVisitorsDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.log_id, t1.date, t1.name_of_visitor, t1.name_of_organization, t1.intending_to_meet, t1.purpose, t1.time_in, t1.time_out, t1.innovation, t1.status");
        $this->ais->select("(select emp_name from  " . $this->db->database . ".hr_user_profile where id = t1.intending_to_meet) as user_name", false);
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->where(array('t1.status !=' => '3'));
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('visitors_log t1');
        // $this->ais->debug_last_query();
        // echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    /* dispatch inward details */

    public function getInwardList($editid = '', $status = '', $cond = '') {
        $data = array();
        $this->ais->select("t1.inward_id, t1.received_date, t1.employee_id, t1.person_name, t1.company_name, t1.content, t1.handover_to, t1.handover_date, t1.vendor, t1.status");
        if ($editid != '') {
            $this->ais->where('t1.inward_id', $editid);
        }
        if ($cond != '') {
            $this->ais->where($cond);
        }

        $this->ais->where('t1.status', $status);
        $query = $this->ais->get('dispatch_inward t1');
        // $this->ais->debug_last_query();
        // echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTInwardCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.inward_id, t1.received_date, t1.employee_id, t1.person_name, t1.company_name, t1.content, t1.handover_to, t1.handover_date, t1.vendor, t1.status");
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        // $this->ais->where(array('t1.status !=' => '3'));
        $query = $this->ais->get('dispatch_inward t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTInwardDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.inward_id, t1.received_date, t1.employee_id, t1.person_name, t1.company_name, t1.content, t1.handover_to, t1.handover_date, t1.vendor, t1.status");
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        // $this->ais->where(array('t1.status !=' => '3'));
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('dispatch_inward t1');
        // $this->ais->debug_last_query();
        // echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    /* dispatch outward details */

    public function getOutwardList($editid = '', $status = '', $cond = '') {
        $data = array();
        $this->ais->select("t1.outward_id, t1.dispatch_date, t1.employee_id, t1.person_name, t1.company_name, t1.content, t1.city, t1.state, t1.pincode, t1.consignment_no, t1.vendor, t1.status, t1.sent_date");
        if ($editid != '') {
            $this->ais->where('t1.outward_id', $editid);
        }
        if ($status != '' && $status != 'report') {
            $this->ais->where('t1.status', $status);
        }
        if ($cond != '') {
            $this->ais->where($cond);
        }

        $query = $this->ais->get('dispatch_outward t1');
        #echo'<pre>';print_r($query->result());die;
        #echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getDTOutwardCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.outward_id, t1.dispatch_date, t1.employee_id, t1.person_name, t1.company_name, t1.content, t1.city, t1.state, t1.pincode, t1.consignment_no, t1.vendor, t1.status, t1.sent_date");
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        // $this->ais->where(array('t1.status !=' => '3'));
        $query = $this->ais->get('dispatch_outward t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTOutwardDetails($num, $offset, $search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select("t1.outward_id, t1.dispatch_date, t1.employee_id, t1.person_name, t1.company_name, t1.content, t1.city, t1.state, t1.pincode, t1.consignment_no, t1.vendor, t1.status, t1.sent_date");
        // $this->ais->join('master_vendor t4', 't4.vendor_id = t1.AMC_vendor');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        // $this->ais->where(array('t1.status !=' => '3'));
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('dispatch_outward t1');
        // $this->ais->debug_last_query();
        // echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    public function getBalance($prog_search, $val = NULL, $wher, $donorid = 'NULL') {

        $data = array();
        // $this->misdb = $this->load->database('mis', TRUE);
        // $from = convertMonthYearFrom($val['from']);
        // $to = convertMonthYearFrom($val['to']);
        $this->ais->select('D1A.*,MP.programme,D.master_name,GL.name as grant_name,GL.id as grant_ids,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');
        $this->ais->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->ais->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->ais->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->ais->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->ais->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->ais->join($this->db->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');

        $this->ais->where('MP.partner_id', $this->session->userdata('partner_id'));
        $this->ais->where('D.master_type', $wher);
        if ($prog_search != '') {
            $this->ais->where("MP.programme LIKE '%$prog_search%'");
        }
        if ($donorid != 'NULL') {
            $this->ais->where('D1A.donor_id', $donorid);
        }
        $this->ais->where("D1A.amount_date  >=", $val['from']);
        $this->ais->where("D1A.amount_date  <=", $val['to']);

        $this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');

        $query = $this->ais->get('master_programme MP');
        // echo $this->ais->last_query();
        // die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getDTBalanceCount($search_field, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select('D1A.*,MP.programme,D.master_name,GL.name as grant_name,GL.id as grant_ids,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');
        $this->ais->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->ais->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->ais->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->ais->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->ais->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->ais->join($this->db->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');

        $query = $this->ais->get('master_programme MP');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTBalanceDetails($num, $offset, $search_field, $columns, $requestData, $donorid = 'NULL') {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select('D1A.*,MP.programme,D.master_name,GL.name as grant_name,GL.id as grant_ids,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');
        $this->ais->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->ais->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->ais->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->ais->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->ais->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->ais->join($this->db->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');
        $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $this->ais->order_by('D1A.programme_id', 'asc');
        $this->ais->order_by('D1A.donor_id', 'asc');
        $this->ais->order_by('D1A.grant_id', 'asc');

        if ($search_field != '') {
            $this->ais->where($search_field);
        }
        if ($donorid != 'NULL') {
            $this->ais->where('D1A.donor_id', $donorid);
        }
        $this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid,D1A.grant_id');
        #$this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');
        $this->ais->limit($num, $offset);

        $query = $this->ais->get('master_programme MP');
        // echo $this->ais->last_query();
        // die;
        $rows = $query->result_array();

        return $rows;
    }

    function getDonorLimitRecords($num, $offset, $search_field, $columns, $requestData, $donorid = 'NULL') {
		#echo'<pre>';print_r($search_field);die;
        $data = array();

        /* $from = convertMonthYearFrom($val['from']);
        $to = convertMonthYearFrom($val['to']); */
        $this->ais->select('D1A.*,MP.programme,D.master_name,GL.name as grant_name,GL.id as grant_ids,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');

        $this->ais->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->ais->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->ais->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->ais->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->ais->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->ais->join($this->db->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');
        #echo $this->misdb->database;die;
        $this->ais->where('MP.partner_id', $this->session->userdata('partner_id'));

        /* $this->ais->where('D.master_type', $wher); */
        /* if($prog_search != '') {
            $this->ais->where("MP.programme LIKE '%$prog_search%'");
        } */
        /* if($donorid != 'NULL') {
            $this->ais->where('D1A.donor_id', $donorid);
        } */

        if ($search_field != '') {
            $this->ais->where($search_field);
        }
        if ($donorid != 'NULL') {
            $this->ais->where('D1A.donor_id', $donorid);
        }

		/* $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '202104'");
		$this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '202203'"); */
        if (!empty($val['orderby']) && !empty($val['ordertype'])) {
            $this->ais->order_by($val['orderby'], $val['ordertype']);
        } else {
            $this->ais->order_by('D1A.programme_id', 'asc');
            $this->ais->order_by('D1A.donor_id', 'asc');
            $this->ais->order_by('D1A.grant_id', 'asc');
        }

        $this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid,D1A.grant_id');
        #$this->db->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');
        $this->ais->limit($num, $offset);
        $query = $this->ais->get('master_programme MP');

        #echo debug_last_query();die;
        #echo'<pre>';print_r($query->result());die;
        //if ($query->num_rows() > 0) {
		/* if($_SERVER['REMOTE_ADDR']=='172.31.21.9'){
			echo $this->ais->last_query();die;
		} */
		
        if (!empty($query)) { 
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }


    public function printBalanceDetails($search_field) {
        // $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->ais->select('D1A.*,MP.programme,D.master_name,GL.name as grant_name,GL.id as grant_ids,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');
        $this->ais->join('balance_amount D1A', 'D1A.programme_id=MP.programme_id', 'right');
        $this->ais->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
        $this->ais->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
        $this->ais->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
        $this->ais->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
        $this->ais->join($this->db->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');
        // $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($search_field != '') {
            $this->ais->where($search_field);
        }

        $this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');
        // $this->ais->limit($num, $offset);
        $query = $this->ais->get('master_programme MP');
        // $this->ais->debug_last_query();
       /*  echo $this->ais->last_query();
       die; */
       $rows = $query->result_array();
       return $rows;
   }

   public function getBalanceHistory($searchfield = '') {

    $data = array();
    $this->ais->select('t1.*,t2.programme,t3.master_name,GL.name as grant_name,GL.id as grant_ids,t4.master_name as budget_head,t5.master_name as line_item,t6.master_name as Subline_item');
    $this->ais->join('master_programme t2', 't2.programme_id=t1.programme_id', 'right');
    $this->ais->join('master_settings t3', 't3.master_id=t1.donor_id', 'left');
    $this->ais->join('master_settings t4', 't4.master_id=t1.budget_id', 'left');
    $this->ais->join('master_settings t5', 't5.master_id=t1.line_itemid', 'left');
    $this->ais->join('master_settings t6', 't6.master_id=t1.subline_itemid', 'left');
    $this->ais->join($this->db->database . '.grant_list GL', 'GL.id = t1.grant_id', 'left');

    if ($searchfield != '') {
        $this->ais->where($searchfield);
    }

    $query = $this->ais->get('masteramount_actionhistory t1');
        // echo $this->ais->last_query();
        // die;
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }
    return $data;
}

public function getEditBalance($programme_id = '', $donor_id = '', $grant_id = '') {
    $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
    $next_year = $cur_year + 1;
    $from_date = $cur_year.'04';
    $to_date = $next_year.'03';

    $data = array();
    $this->ais->select('D1A.*');
    if ($programme_id != 'NULL') {
        $this->ais->where('D1A.programme_id', $programme_id);
    }
    if ($donor_id != '') {
        $this->ais->where('D1A.donor_id', $donor_id);
    }
    if ($grant_id != '') {
        $this->ais->where('D1A.grant_id', $grant_id);
    }

    $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '".$from_date."'");
    $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '".$to_date."'");
    $query = $this->ais->get('balance_amount D1A');
    //     echo $this->ais->last_query();die;
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }
    return $data;
}

public function getDTEditbalanceCount($search_field, $columns, $requestData) {
    $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
    $next_year = $cur_year + 1;
    $from_date = $cur_year.'04';
    $to_date = $next_year.'03';

    $offset = (!is_numeric($offset)) ? '0' : $offset;
    $this->ais->select('D1A.*,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');
    $this->ais->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
    $this->ais->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
    $this->ais->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
    $this->ais->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
    $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

    if ($search_field != '') {
        $this->ais->where($search_field);
    }
    $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '".$from_date."'");
    $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '".$to_date."'");
    $this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');

    $query = $this->ais->get('balance_amount D1A');
    $rows = $query->num_rows();
    return $rows;
}

public function getDTEditbalanceDetails($num, $offset, $search_field, $columns, $requestData) {
	
	$cur_year = current_FYstartYear($this->session->userdata('partner_id'));
    $next_year = $cur_year + 1;
    $from_date = $cur_year.'04';
    $to_date = $next_year.'03';

    $offset = (!is_numeric($offset)) ? '0' : $offset;
    $this->ais->select('D1A.*,D2A.master_name as budget_head,D3A.master_name as line_item,D4A.master_name as Subline_item,sum(D1A.amount) as amount');
    $this->ais->join('master_settings D', 'D.master_id=D1A.donor_id', 'left');
    $this->ais->join('master_settings D2A', 'D2A.master_id=D1A.budget_id', 'left');
    $this->ais->join('master_settings D3A', 'D3A.master_id=D1A.line_itemid', 'left');
    $this->ais->join('master_settings D4A', 'D4A.master_id=D1A.subline_itemid', 'left');
    $this->ais->join($this->db->database . '.grant_list GL', 'GL.id = D1A.grant_id', 'left');
    $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);



    if ($search_field != '') {
        $this->ais->where($search_field);
    }

    $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '".$from_date."'");
    $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '".$to_date."'");
    #$this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid');
    $this->ais->group_by('D1A.programme_id,D1A.donor_id,D1A.line_itemid,D1A.subline_itemid,D1A.grant_id');
    $this->ais->limit($num, $offset);
    $query = $this->ais->get('balance_amount D1A');
        //echo $this->ais->debug_last_query();die;
        // echo $this->ais->last_query();die;
		/* if($_SERVER['REMOTE_ADDR']=='172.31.21.9'){
		echo $this->ais->last_query();die;
	} */
    $rows = $query->result_array();
    return $rows;
}

public function getAdditionalInfo($programme, $donor, $budgethead, $lineitem = 'NULL', $sublineitem = 'NULL') {
    $data = array();
    $this->ais->select('additionalinfo');
    $this->ais->where('programme', $programme);
    $this->ais->where('donor', $donor);
    $this->ais->where('budgethead', $budgethead);
    $this->ais->where('lineitem', $lineitem);
    $this->ais->where('subitem', $sublineitem);
    $this->ais->where('status', '1');
    $query = $this->ais->get('additional_info');
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

public function getDonoramounts($donorid = '', $search_field = '') {
    if ($donorid != '') {
        $this->ais->where('id', $donorid);
    }
    if ($search_field != '') {
        $this->ais->where($search_field);
    }

    $query = $this->ais->get('donors_amount');
        // echo $this->ais->last_query();
        // die;
    $rows = $query->result_array();
    return $rows;
}

public function getDonorhistory($search_field = '') {
    $this->ais->select('t2.*,t1.master_name');
    $this->ais->join('master_settings t1', 't1.master_id=t2.donor_id', 'left');
    if ($search_field != '') {
        $this->ais->where($search_field);
    }

    $query = $this->ais->get('donoramount_actionhistory t2');
        // echo $this->ais->last_query();
        // die;
    $rows = $query->result_array();
    return $rows;
}

public function getDTDonoramtCount($search_field, $columns, $requestData, $bydonor) {
    $offset = (!is_numeric($offset)) ? '0' : $offset;
    if ($bydonor == 1) {
        $this->ais->select('t2.*,t1.master_name');
    } else {
        $this->ais->select('t2.*,t1.master_name,sum(t2.amount) as amount');
    }
    $this->ais->join('master_settings t1', 't1.master_id=t2.donor_id', 'left');
    $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

    if ($search_field != '') {
        $this->ais->where($search_field);
    }
    if ($bydonor != 1) {
        $this->ais->group_by('t2.donor_id');
    }
    $query = $this->ais->get('donors_amount t2');
    $rows = $query->num_rows();
    return $rows;
}

public function getDTDonoramtDetails($num, $offset, $search_field, $columns, $requestData, $bydonor) {
    $offset = (!is_numeric($offset)) ? '0' : $offset;
    if ($bydonor == 1) {
        $this->ais->select('t2.*,t1.master_name');
    } else {
        $this->ais->select('t2.*,t1.master_name,sum(t2.amount) as amount');
    }
    $this->ais->join('master_settings t1', 't1.master_id=t2.donor_id', 'left');
    $this->ais->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

    if ($search_field != '') {
        $this->ais->where($search_field);
    }
    if ($bydonor != 1) {
        $this->ais->group_by('t2.donor_id');
    }
    $this->ais->limit($num, $offset);
    $query = $this->ais->get('donors_amount t2');
        // $this->ais->debug_last_query();
        // echo $this->ais->last_query();
        // die;
    $rows = $query->result_array();
    return $rows;
}

/*     * *** For checking approval amount *** */

public function checkApprovalNoteAmount($programme, $donor, $budgethead, $lineitem = 'NULL', $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {
    $data = array();
    $this->ais->select('sum(amt_required)as totalamount');
    $this->ais->join('approval_note AN', 'AN.approval_id=ANDO.approval_id');
    if ($programme != "") {
        $this->ais->where('AN.programme', $programme);
    }
    if ($donor != "") {
        $this->ais->where('ANDO.donor', $donor);
    }
    if ($budgethead != "") {
        $this->ais->where('ANDO.budget_head', $budgethead);
    }
    if ($lineitem != '') {
        $this->ais->where('ANDO.line_item', $lineitem);
    }
    if ($grant_id != '') {
        $this->ais->where('ANDO.grant_id', $grant_id);
    }
        $this->ais->where('AN.status !=', 'cancelled');  // newly added on 29/5/14
        $this->ais->where("date_of_request  >= '$from'");
        $this->ais->where("date_of_request  <= '$to'");
        $query = $this->ais->get('approval_note_donors ANDO');

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

    public function checkInternalAmtManual($programme, $donor, $grant_id) {
        $data = array();
        $this->ais->distinct();
        $this->ais->select('sum(amount_toapprove)as totalamount');
        $this->ais->join('approval_note AN', 'AN.approval_id=INTER.approval_id', 'left');
        if ($programme != "") {
            $this->ais->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->ais->where('INTER.donor', $donor);
        }
        if ($grant_id != "") {
            $this->ais->where('INTER.grant_id', $grant_id);
        }

        $this->ais->where('INTER.status !=', 'cancelled');
        $query = $this->ais->get('internal_note INTER');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['totalamount'];
    }

    public function checkApprovalNoteAmtManual($programme = '', $donor = '', $grant_id = '') {

        $data = array();
        $this->ais->select('sum(amt_required)as totalamount');
        #$this->ais->select('*');
        $this->ais->join('approval_note AN', 'AN.approval_id=ANDO.approval_id');
        if ($programme != "") {
            $this->ais->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->ais->where('ANDO.donor', $donor);
        }
        if ($grant_id != '') {
            $this->ais->where('ANDO.grant_id', $grant_id);
        }
        $this->ais->where('AN.status !=', 'cancelled');
        $query = $this->ais->get('approval_note_donors ANDO');
        // echo $this->ais->last_query(); exit;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['totalamount'];
    }

    public function checkInternalAmount($programme, $donor, $budgethead, $lineitem, $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {
        $data = array();
        $this->ais->distinct();
        $this->ais->select('sum(amount_toapprove)as totalamount');
        $this->ais->join('approval_note AN', 'AN.approval_id=INTER.approval_id', 'left');
        if ($programme != "") {
            $this->ais->where('AN.programme', $programme);
        }
        if ($donor != "") {
            $this->ais->where('INTER.donor', $donor);
        }
        if ($budgethead != "") {
            $this->ais->where('INTER.budget_head', $budgethead);
        }
        if ($lineitem != "") {
            $this->ais->where('INTER.line_item', $lineitem);
        }
        if ($sublineitem != "") {
            $this->ais->where('INTER.cost_centre', $sublineitem);
        }
        if ($grant_id != "") {
            $this->ais->where('INTER.grant_id', $grant_id);
        }

        $this->ais->where('INTER.status !=', 'cancelled');  // newly added on 29/5/14
        $this->ais->where("AN.date_of_request >= '$from'");
        $this->ais->where("AN.date_of_request <= '$to'");
        $query = $this->ais->get('internal_note INTER');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['totalamount'];
    }

    /*     * * End ** */

    public function checkRecoveredAmount($programme, $donor, $budgethead, $lineitem, $sublineitem = 'NULL', $from = 'NULL', $to = 'NULL', $grant_id = '') {

        $data = array();
        $this->ais->select('sum(AD.amount_recovered)as sumamount');
        $this->ais->join('recovered_amount RA', 'RA.id=AD.recover_id', 'left');
        if ($programme != "") {
            $this->ais->where('RA.programme', $programme);
        }
        if ($donor != "") {
            $this->ais->where('RA.donor', $donor);
        }
        if ($budgethead != "") {
            $this->ais->where('RA.budget_head', $budgethead);
        }
        if ($lineitem != "") {
            $this->ais->where('RA.line_item', $lineitem);
        }
        if ($sublineitem != "") {
            $this->ais->where('RA.sub_line_item', $sublineitem);
        }

        if ($grant_id != "") {
            $this->ais->where('RA.grant_id', $grant_id);
        }

        $this->ais->where("AD.recovered_date >= '$from'");
        $this->ais->where("AD.recovered_date <= '$to'");
        $query = $this->ais->get('recovered_amount_detail AD');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['sumamount'];
    }

    public function getLibraryDues($employee) {
        $data = array();
        $this->ais->where('library_booking.employee_id', $employee);
        $this->ais->where('library_booking.status', 'confirmed');
        $this->ais->select('master_settings.master_name,master_books.book_name,master_books.author,master_books.book_number,library_booking.*');
        $this->ais->join('master_books', 'library_booking.book_id=master_books.book_id', 'left');
        $this->ais->join('master_settings', 'master_books.master_id=master_settings.master_id', 'left');
        $query = $this->ais->get('library_booking');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getAssetDues($employee) {
        $data = array();
        $this->ais->where('employee_id', $employee);
        $this->ais->where('asset_transaction.transfer_status', 'using');
        $this->ais->join('master_asset', 'asset_transaction.asset_id=master_asset.asset_id', 'left');
        $query = $this->ais->get('asset_transaction');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
