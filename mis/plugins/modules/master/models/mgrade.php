<?php
#
# Model Class -  hs_quad_master_settings
#

class Mgrade extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($options = array())
    {
        $data = array(
            'program_stage' => $options['program_stage'],
            'category' => $options['category'],
            'criteria' => $options['criteria'],
            'waitage' => $options['waitage'],
            'scale' => $options['scale'],
            'scaling_factor' => serialize($options['scaling_factor']),
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $result = $this->db->insert('grading_master', $data);
        $id = $this->db->insert_id();
        return $id;

    }
    public function update($options = array())
    {
        $data = array(
            'category' => $options['category'],
            'criteria' => $options['criteria'],
            'waitage' => $options['waitage'],
            'scale' => $options['scale'],
            'scaling_factor' => serialize($options['scaling_factor']),
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'));
        $this->db->where('id', $options['id']);
        $result = $this->db->update('grading_master', $data);
        return true;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('grading_master');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }
    /**
     * Function : changeStatus method is used for Make active inactive.
     * $options - values
     *     staus
     *    vendor_id
     *
     * @param array $options
     *
     */

    public function changeStatus($options = array())
    {
        $data = array('status' => $options['status']);
        $this->db->where('id', $options['id']);
        $this->db->update('quad_mailtemplate', $data);
        return true;
    }

    /**
     * Function : getVendorInfo method is used for get vendor details.
     *
     * @param int $vendor_id
     *
     */
    public function getGradeListByStage($program_stage)
    {
        $data = array();
        $this->db->select("grading_master.*,(select master_name from master_settings where id=grading_master.category) as category_name");
        $this->db->order_by('category', 'asc');
        $this->db->where('program_stage', '5');
        $query = $this->db->get('grading_master');
		#echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getGrades()
    {
        $data = array();
        $this->db->select("grading_master.*,(select master_name from master_settings where id=grading_master.category) as category_name");
        $this->db->order_by('category', 'asc');
        $query = $this->db->get('grading_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getGradeDetails($id)
    {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('grading_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function findGradefield($programstage = null)
    {
        $this->db->select('ps.title as programtype,ps.program_service_offering as programserviceid,pso.program_type as programtypeid,pso.title as programservice,ms.master_name as programstage');
        $this->db->from('program_stage ps');
        $this->db->join('program_service_offering  pso', 'pso.id =program_service_offering');
        $this->db->join('master_settings ms', 'ms.id =pso.program_type', 'left');
        $this->db->where('ps.id', $programstage);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data[0];

    }

}
