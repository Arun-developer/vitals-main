<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * Repayment Model Page
 *
 * @ControllerName     mexitdetails.php
 * @Author             Sanjoy Dey
 * @Created Date       1-12-2011
 * @Modified Date      4-12-2011
 * @Modified By        Sanjoy Dey
 * @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011
 * @version            CodeIgniter_2.0.3
 * @link               http://www.codeigniter.com
 * @since              File available since Release 2.0.3
 * @Warning            Any change in this file may cause abnormal behaviour of application.
 *
 */

class Mexitdetails extends CI_Model
{

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->ais = $this->load->database('ais', true);
    }

    /*
     * getInnovationName function is used to get Innovation Details
     */
    public function getInnovationName($innovationID)
    {

        $this->db->select("id,name_of_entrepreneur,email_id");
        if ($innovationID != "") {
            $this->db->where('id', $innovationID);
        }
        $query = $this->db->get("innovation_pool");
        $value = $query->result_array();
        $data = $value[0];
        return $data;
    }

    /*
     * getBudgetDetails function is used to get sum of Amount Approval Details
     */
    public function getBudgetDetails($innovationID)
    {
        $this->db->select("approval_note,installment");
        $this->db->where('innovation', $innovationID);
        $query = $this->db->get('sf_approval_note');
        $approvalNote = $query->result_array();

        $this->ais->select("sum(amt_required) as amt_required");
        $this->ais->where('approval_id ', $approvalNote[0]['approval_note']);
        $aisQuery = $this->ais->get('approval_note_donors');
        $aisAmount = $aisQuery->result_array();

        return $aisAmount;

    }

    /*
     * getApprovalDate function is used to get Approval Date By Innovation ID
     */
    public function getApprovalDate($innovationID)
    {

        $this->db->select("approval_note,installment");
        $this->db->where('innovation', $innovationID);
        $query = $this->db->get('sf_approval_note');
        $approvalNote = $query->result_array();
        $this->ais->select("date_payment_required");
        $this->ais->where('approval_id', $approvalNote[0]['approval_note']);
        $aisDateQuery = $this->ais->get('approval_note');
        $aisDate = $aisDateQuery->result_array();

        return $aisDate;

    }

    /*
     * getfundUtilized function is used to get fund utilized details By Innovation ID
     */
    public function getfundUtilized($innovationID)
    {

        $this->db->select("sum(amount) as amount");
        $this->db->where('innovation', $innovationID);
        $query = $this->db->get('sf_fund_utilization');
        $fundUtilized = $query->result_array();

        return $fundUtilized[0]['amount'];
    }

    /*
     * getfunddisbursed function is used to get fund disbursed details By Innovation ID
     */
    public function getfunddisbursed($innovationID)
    {
        $query = "SELECT sum(SI.vfunded) as amount from sf_activity_amount as SI JOIN sf_installments as SF ON(SF.id = SI.installment) WHERE SF.innovation = $innovationID";
        $result = $this->db->query($query);
        $funddisbursed = $result->result_array();
        return $funddisbursed[0]['amount'];
    }
    /*
     * insert function is used to insert Exit Details
     */
    public function insert($data, $innovationID)
    {

        /*show($data);*/
        $datas = array(
            'innovation' => $innovationID,
            'fund_released' => $data['exit']['fund_released'],
            'fund_utilized' => $data['exit']['fund_utilized'],
            'exitstatus' => $data['exit']['exitstatus'],
            'exit_date' => date2mysql($data['exit']['exit_date']),
            'exit_reason' => $data['exit']['exit_reason'],
            'exit_description' => $data['exit']['exitwork_description'],
            'documents' => $data['exit']['document_path'],
        );

        $this->db->insert('exit_details', $datas);
        return true;

    }
    public function checkDuplicate($innovation)
    {

        $this->db->select("*");
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('exit_details');
        $value = $query->result_array();

        return $value;
    }

    public function getGradeDetails($activityID)
    {

        $this->db->select("*");
        $this->db->where('activity', $activityID);
        $query = $this->db->get('grading_feedback');
        $value = $query->result_array();
        return $value;
    }

    public function updateliststatus($options = array())
    {
        $dataup = array('ceo_status' => $options['decision'], 'ceo_comments' => $options['comments']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('exit_details', $dataup);
        return $result;
    }

    public function changestatus($id)
    {
        $table = 'innovation_pool';
        $where = array('id' => $id);
        $data = array('status' => '9');
        $this->db->update($table, $data, $where);

        return true;
    }

    public function getGradingDetails($innovationID)
    {

        $data = array();
        $this->db->select("id,activity");
        $this->db->where('innovation', $innovationID);
        $query = $this->db->get('activities');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        foreach ($data as $val) {
            $values = $this->getGrading($val['id']);

        }
        $query->free_result();
        return $values;
    }

    public function getCurrentStage($stage)
    {
        $this->db->select('program_stage');
        $this->db->where('stage', $stage);
        $query = $this->db->get('stage_map');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['program_stage'];
    }

    public function getActivityForGrading($innovation, $stage = '5', $grading = '29')
    {
        $data = array();
        $this->db->select("ACT.id");
        $this->db->where('ACT.innovation', $innovation);
        $this->db->where('ACT.program_stage', $stage);
        $this->db->where('MAS.activity_type', $grading);

        $this->db->join('activity_master MAS', 'MAS.id = ACT.activity');
        $this->db->join('master_settings MS', 'MAS.activity_type = MS.id');
        $query = $this->db->get('activities ACT');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getGrading($activity)
    {
        $this->db->select("*");
        $this->db->where('activity', $activity);
        $query = $this->db->get('grading_feedback');
        $value = $query->result_array();

        return $value;
    }

    /*
     * getDetailsByLastID function is used to get Details if insert id exists
     */
    public function getDetailsByLastID($queryArray = array())
    {

        $this->db->select($queryArray['select']);
        $this->db->where($queryArray['where']);
        $query = $this->db->get('exit_details');
        $data = $query->row_array();
        return $data;

    }

    public function getDetails()
    {

        $query = $this->db->get('exit_details');
        $data = $query->result_array();
        $value = $data;
        return $value;
    }

    public function getenterprisename($id)
    {
        $this->db->select('name_of_enterprise');
        $this->db->where('id', $id);
        $query = $this->db->get('innovation_pool');
        $result = $query->result_array();
        return $result[0]['name_of_enterprise'];

    }

    /*
     * Update function is used to Update Exit Details
     */
    public function update($data, $path, $id, $innovationID)
    {
        $data = array(
            'innovation' => $innovationID,
            'fundapproved_amount' => $data['fundapproved_amount'],
            'fundapproved_date' => $data['fundapproved_date'],
            'signed_date' => date2mysql($data['signed_date']),
            'fund_released' => $data['fund_released'],
            'fund_utilized' => $data['fund_utilized'],
            'exitstatus' => $data['exitstatus'],
            'exit_date' => date2mysql($data['exit_date']),
            'exit_reason' => $data['exit_reason'],
            'exitwork_description' => $data['exitwork_description'],
            'document_name' => $path['filename'],
            'document_path' => $path['upload_path'],
            'created_date' => date("Y-m-d"),
        );

        if ($id != null) {
            $this->db->where('id', $id);
        }
        $this->db->update('exit_details', $data);
        return true;

    }
}
