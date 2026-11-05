<?php

class Massessment extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'assessment';
    }

    public function insert($id, $criteria, $form) {
        $data = array('innvation' => $id,
            'criteria' => $criteria,
            'title' => $form['title'],
            'description' => $form['description'],
            'link' => $form['link'],
            'documents' => $form['documents'],
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('assessment', $data);
        return true;
    }

    public function getCriteria() {
        $query = "SELECT  id,category,criteria as master_name,scaling_factor FROM grading_master where program_stage = 5";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function insertgrading($id, $criteria, $form) {
        $data = array('grading_id' => $id,
            'grading_master' => $criteria,
            'description' => $form['description'],
            'grade' => $form['score']);
        $this->db->insert('grades', $data);
        return true;
    }

    public function update($form) {
        $data = array(
            'title' => $form['title'],
            'description' => $form['description'],
            'link' => $form['link'],
            'documents' => $form['documents'],
            'modified_date' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $form['id']);
        $this->db->update('assessment', $data);
        return true;
    }

    public function deleteDetails($ass_id = null) {
        if ($ass_id != null) {
            $this->db->where('id', $ass_id);
            $this->db->delete('assessment');
        }
        return true;
    }

    public function deletegrade($id, $cri) {
        $this->db->where('grading_id', $id);
        $this->db->where('grading_master', $cri);
        $this->db->delete('grades');
        return true;
    }

    public function checkassessexist($id, $user) {
        $this->db->select("count(*) as total");
        $this->db->where('innvation', $id);
        $this->db->where('created_by', $user);
        $query = $this->db->get('assessment');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    public function getAssessDetails($id, $criteria = null, $ass_id = null, $assigned = null) {
        $data = array();
        $user = (($assigned != null)) ? $assigned : $this->session->userdata('emp_number');
        $this->db->select('A.*');
        $this->db->select('G.grade');
        $this->db->select('G.id as grading_id');
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from  hr_user_profile where id = A.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from  hr_user_profile where id = A.modified_by) as modified_emp", false);
        $this->db->select("(select master_name from master_settings where id=A.criteria) as criteria_title", false);
        $this->db->join('grades G', 'A.innvation = G.grading_id AND A.created_by = G.graded_by AND A.criteria = G.grading_master');
        $this->db->where('A.innvation', $id);
        $this->db->where('created_by', $user);
        if ($criteria != null) {
            $this->db->where('criteria', $criteria);
        }

        if ($ass_id != null) {
            $this->db->where('A.id', $ass_id);
        }

        $this->db->group_by('A.id');
        $this->db->order_by('criteria', 'asc');

        $query = $this->db->get('assessment A');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    // getting grade details
    public function getAssessGradeDetails($id, $criteria = null, $ass_id = null) {
        $data = array();
        $this->db->select('G.*');

        $this->db->where('grading_id', $id);
        if ($criteria != null) {
            $this->db->where('grading_master', $criteria);
        }

        $this->db->order_by('grading_master', 'asc');

        $query = $this->db->get('grades G');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    ////// getting file details
    public function getfiles($id) {
        $data = array();
        $this->db->select('*');
        $this->db->where('innvation', $id);
        $query = $this->db->get('assessment_doc');
        return $query->result_array();
    }

    #comments

    public function insertComments($assess_id, $form) {
        $data = array('assess_id' => $assess_id,
            'comments' => $form['comments'],
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('assessment_comments', $data);
        return true;
    }

    public function updateComments($form) {
        $data = array(
            'comments' => $form['comments'],
            'modified_date' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $form['id']);
        $this->db->update('assessment_comments', $data);
        return true;
    }

    public function deleteComments($id = null) {
        if ($id != null) {
            $this->db->where('id', $id);
            $this->db->delete('assessment_comments');
        }
        return true;
    }

    public function getAssessComments($assess_id = null) {
        $data = array();
        $this->db->select('A.*');
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = A.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = A.modified_by) as modified_emp", false);
        $this->db->where('assess_id', $assess_id);
        $query = $this->db->get('assessment_comments A');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertFormWizard($id, $form) {
        $criteria_arr = $form['criteria'];
        $ass_id = $form['ass_id'];
        $score_arr = $form['score'];
        $desc = $form['desc'];
        for ($j = 0; $j < php72_count($ass_id); $j++) {
            if ($ass_id[$j] != '' && $criteria_arr[$j] != 'upfiles') {
                $data = array('innvation' => $id,
                    'criteria' => $criteria_arr[$j],
                    'description' => $desc[$j],
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('emp_number'),
                );
                $this->db->where('id', $ass_id[$j]);
                $this->db->update('assessment', $data);
            } else {
                if (!empty($score_arr[$j])) {
                    $data = array('innvation' => $id,
                        'criteria' => $criteria_arr[$j],
                        'description' => $desc[$j],
                        'created_date' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('emp_number'),
                    );
                    $this->db->insert('assessment', $data);
                }
            }
        }
        return true;
    }

    public function insertgradingFormWizard($id, $form) {
        $criteria_arr = $form['criteria'];
        $grd_id = $form['grad_id'];
        $score_arr = $form['score'];
        $desc = $form['desc'];
        for ($j = 0; $j < php72_count($grd_id); $j++) {
            if ($grd_id[$j] != '' && $criteria_arr[$j] != 'upfiles') {
                $data = array('grading_id' => $id,
                    'grading_master' => $criteria_arr[$j],
                    'description' => $desc[$j],
                    'grade' => $score_arr[$j],
                    'graded_by' => $this->session->userdata('emp_number'),
                );
                $this->db->where('id', $grd_id[$j]);
                $this->db->update('grades', $data);
            } else {

                if (!empty($score_arr[$j])) {
                    $data = array('grading_id' => $id,
                        'grading_master' => $criteria_arr[$j],
                        'description' => $desc[$j],
                        'grade' => $score_arr[$j],
                        'graded_by' => $this->session->userdata('emp_number'),
                    );
                    $this->db->insert('grades', $data);
                }
            }
        }
        return true;
    }

    public function insertUpFiles($id, $form) {
        $criteria_arr = $form['criteria'];
        $score_arr = $form['score'];
        $desc = $form['desc'];
        $files = $form['files'];
        $documentsLink = $form['documentsLink'];
        $documentsText = $form['documentsText'];

        for ($i = 0; $i < php72_count($files); $i++) {
            $data = array(
                'innvation' => $id,
                'link' => $documentsLink[$i],
                'documents' => $files[$i],
                'doc_desc' => $documentsText[$i],
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('emp_number'),
            );
            $this->db->insert('assessment_doc', $data);
        }
        return true;
    }

    public function getlinkdoc($id) {
        $this->db->select('A.*');
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = A.created_by) as created_emp", false);
        $this->db->where('innvation', $id);
        $this->db->where('A.created_by', $this->session->userdata('emp_number'));
        $query = $this->db->get('assessment_doc A');
        return $query->result_array();
    }

    /** function check_innovation
     * param - innovation id
     * Checks whether the given innovation exist in previous assessment table
     * returns the number of records
     */
    public function check_innovation($in_id) {
        $this->db->select('*');
        $this->db->where('innvation', $in_id);
        $query = $this->db->get('assessment');
        return $query->num_rows();
    }

    /** function getArea
     * fetchs the active assestment area
     * returns the result as array
     */
    public function getArea($partner_id = '',$programid='') {
        if ($partner_id == '10') {
            $this->db->where('partner_base !=', "1");
        } else {
            $this->db->where('partner_base !=', "2");
        }
        $this->db->select('*');
        $this->db->where('status', '1');
		if($programid=='14'){
			$this->db->where_not_in('id', array(8,9,10,5));
		}else{
			$this->db->where_not_in('id', array(16));
		}
        $this->db->order_by('listing_order', 'asc');
        $query = $this->db->get('assest_area');
        return $query->result_array();
    }

    /** function getArea
     * fetchs the active assestment area
     * returns the result as array
     */
    public function getSubCategory($areaid,$program_id='') {
        $this->db->select('*');
        $this->db->where('area_id', $areaid);
        $this->db->where('status', '1');
		if($program_id=='14'){
			$this->db->where_not_in('id', array(26,27,28,29,2,3,4,5,6,7,8,9,10,11));
		}else if($program_id=='27'){
			$this->db->where_not_in('id', array(26,27,28,29,2,3,4,5,6,7,8,9,10));
		}else{
			$this->db->where_not_in('id', array(35));
		}
        $query = $this->db->get('assesst_area_sub_category');
        return $query->result_array(); 
    }

    public function insert_assesst($table, $data) {
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function assign_assciate_status($id) {
        $this->db->set('status', 0);
        $this->db->where('innovation', $id);
        $this->db->update('assign_associate');
        return true;
    }

    public function assesstExist($id, $emp_number) {
        $this->db->select('id');
        $this->db->where('innovation_id', $id);
        $this->db->where('assesst_by', $emp_number);
        $query = $this->db->get('assest_detail');
        return $query->num_rows();
    }

    public function getAssesst($id, $emp_number) {
        $this->db->select('*');
        $this->db->where('innovation_id', $id);
        $this->db->where('assesst_by', $emp_number);
        $query = $this->db->get('assest_detail');
        return $query->result_array();
    }

    public function checkScoreAssesst($id) {
        $this->db->select('score_entered');
        $this->db->where('innovation_id', $id);
        $query = $this->db->get('assest_detail');
        return $query->result_array();
    }

    public function getSubAssesst($assesst_id) {
        $this->db->select('*');
        $this->db->where('assesst_detail_id', $assesst_id);
        $query = $this->db->get('assesst_sub_cat_detail');
        return $query->result_array();
    }

    public function update_assesst($table, $data, $where) {
        $this->db->update($table, $data, $where);
        $afftectedRows = $this->db->affected_rows();
        return $afftectedRows;
    }

    public function getAssessors($inn_id) {
        $this->db->select('*');
        $this->db->where('innovation_id', $inn_id);
        $query = $this->db->get('assesst_assessors');
        return $query->result_array();
    }

    public function getEmployeeName($emp_number) {
        $name = $emp_number;
        $query = $this->db->query("select CONCAT_WS(' ',emp_first_name,emp_last_name) as emp_name from hr_user_profile where id =" . $emp_number);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $name = $row['emp_name'];
            }
        }
        return $name;
    }

    public function feedbackCheck($id) {
        $this->db->select('id');
        $this->db->where('innovation_id', $id);
        $query = $this->db->get('grading_feedback');
        return $query->num_rows();
    }

    public function getFeedback($id) {
        $this->db->select("*");
        $this->db->where('innovation_id', $id);
        $query = $this->db->get('grading_feedback');
        return $query->result_array();
    }

    public function getInnoStatus($id) {
        $status = '';
        $this->db->select('status');
        $this->db->where('id', $id);
        $query = $this->db->get('innovation_pool');
        foreach ($query->result_array() as $row) {
            $status = $row['status'];
        }
        return $status;
    }

    public function getReasons($id = null, $partner_id = '') {
        if ($id) {
            $this->db->where('id', $id);
        }
        if ($partner_id != '') {
            $this->db->where('partner_id', $partner_id);
        }
        $this->db->where('status', '1');
        $query = $this->db->get('preliminary_reasons');
        return $query->result_array();
    }

    public function getDonorFit($id = '') {
        $this->db->where('status', '1');
        $this->db->where('partner_id', $id);
        $this->db->select('*');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('donor_fit_master');
        return $query->result_array();
    }

    public function getExistDonorFit($id = '') {
        if ($id != '') {
            $cond = "id IN($id)";
            $this->db->where($cond);
        }
        $this->db->where('status', '0');
        $this->db->select('*');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('donor_fit_master');
        return $query->result_array();
    }

    public function getEmpName($id) {
        $this->db->select('emp_first_name,emp_last_name');
        $this->db->where('id', $id);
        $query = $this->db->get('hr_user_profile');
        $result = $query->result_array();
        return $result[0]['emp_first_name'] . ' ' . $result[0]['emp_last_name'];
    }

    public function getInactivePARDuser($id, $emp_id) {
        $this->db->select("*");
        $this->db->where(array('innovation' => $id, 'status' => '1'));
        $this->db->where_in('associate_employee', $emp_id);
        $this->db->group_by('associate_employee');
        $query = $this->db->get('assign_associate');
        return $query->result_array();
    }

    public function getInactiveUserScore($id, $emp_id) {
        $this->db->select("*");
        $this->db->where(array('innovation_id' => $id));
        $this->db->where_in('assesst_by', $emp_id);
        $this->db->group_by('assesst_by');
        $query = $this->db->get('assest_detail');
        return $query->result_array();
    }

}
