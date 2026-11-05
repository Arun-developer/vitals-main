<?php

class Mincubation_reports extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->ais = $this->load->database('ais', true);
        $this->load->model('master/Msource');
        $this->load->model('master/Mmaster_settings');
        $this->load->model('Memail');
    }
    public function getmentordetails($from = null, $to = null)
    {
        if ($from != null) {
            $where = 'where extract(month from created_date)>=' . $from . ' AND extract(month from created_date)<=' . $to;
        } else {
            $where = '';
        }
        $buildqry = "SELECT IP.id as innovation,IP.name_of_enterprise,M.first_name as company,AM.mentorhours,AM.mentormoney from assign_mentor as AM LEFT JOIN request_mentor as RM ON(RM.id = AM.request_id) LEFT JOIN mentor as M ON(M.id = AM.mentor_id) LEFT JOIN innovation_pool as IP ON(IP.id=AM.innovation) " . $where . " GROUP BY AM.innovation";
        $query = $this->db->query($buildqry);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getraiseinvestment($from = null, $to = null)
    {
        if ($from != null) {
            $where = 'where extract(month from created_date)>=' . $from . ' AND extract(month from created_date)<=' . $to;
        } else {
            $where = '';
        }
        $buildqry = "SELECT AI.amount_approved,RI.amount,IP.name_of_enterprise from assign_invester as AI LEFT JOIN request_invester as RI ON(AI.request_id=RI.id) JOIN innovation_pool as IP ON(IP.id=AI.innovation)" . $where . " GROUP BY IP.id";
        $query = $this->db->query($buildqry);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getExitboard()
    {

        $buildqry = "SELECT count(AM.board_id) as count,IP.name_of_enterprise from assign_board_member as AM LEFT JOIN innovation_pool as IP ON(IP.id=AM.innovation) WHERE incubatee_status = 1 and villgro_status=1";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }

    public function getExitCriteria()
    {

        $buildqry = "SELECT IP.name_of_enterprise,BM.innovation,BM.id,extract(year from BM.created_date) as exitDate from
						boardmeeting_manager as BM LEFT JOIN innovation_pool as IP ON(IP.id=BM.innovation) WHERE
						 extract(year from BM.created_date) = year(CURRENT_DATE)
                        ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }
    public function getFundUTDetails($from, $to)
    {

        $data = array();
        if ($from != null) {
            $where = 'extract(year from SF.created_date)>=' . $from . ' AND extract(year from SF.created_date)<=' . $to;
        } else {
            $where = '1=1';
        }
        $buildqry = "SELECT IP.name_of_enterprise,SF.innovation,SF.amount,SF.date,installment from sf_fund_utilization as SF LEFT JOIN innovation_pool as IP ON(IP.id = SF.innovation) where " . $where . " GROUP BY SF.innovation";
        $value = $this->db->query($buildqry);
        if ($value->num_rows() > 0) {
            foreach ($value->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function green($innovationid, $field)
    {
        $query = "select EM.value as answer,PM.label as label,PG.field from exit_details_master as EM JOIN progress as PG ON(PG.innovation = EM.innovation) JOIN progress_master as PM ON(PG.field = PM.id) WHERE PG.innovation = '" . $innovationid . "'  AND PM.label = '" . $field . "'";
        $value = $this->db->query($query);
        $result = $value->result_array();
        return $result[0];

    }
    public function getapplicantDetails()
    {
        $query = "select RA.jobtitle,RA.education,RA.sector,RA.experience,AA.interview_date,AA.interview_status from request_applicant as RA LEFT JOIN assign_applicant as AA ON(RA.id = AA.id)";
        $value = $this->db->query($query);
        foreach ($value->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getfellowDetail()
    {

        $query = "select RF.innovator_name as innovation,RF.job_description as job,RF.request_date as request_date,FA.applicant_name as applicant_name,FA.area as area from request_fellow as RF JOIN fellow_applicant as FA ON(FA.applicant_id = RF.id)";
        $value = $this->db->query($query);
        foreach ($value->result_array() as $row) {
            $data[] = $row;

        }
        return $data;
    }
    public function gettrainingDetailss($from = null, $to = null)
    {
        if ($from != null) {
            $where = "extract(year from start_date) = " . $from . " AND extract(year from end_date) = " . $to;
        } else {
            $where = '1=1';
        }
        $query = "select TP.participant_type,TP.participant_name,TP.participant_status,TP.participant_organization from training_participant as TP LEFT JOIN request_training as RT ON(RT.program_type = TP.program_type) where " . $where;
        $value = $this->db->query($query);
        foreach ($value->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getfunddisbursed($from = null, $to = null)
    {

        $data = array();
        $this->db->select("sum(vfunded) as total");
        $query = $this->db->get('sf_activity_amount');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        $query->free_result();
        return $data['0']['total'];
    }
    public function getMonthDetails($innovation)
    {
        $buildqry = "SELECT PG.answer as answer,extract(Month FROM PG.start_date) as progress_date,PM.label,PG.field as field
                       FROM progress as PG
                       LEFT JOIN progress_master as PM
                       ON (PG.field = PM.id) WHERE
                       PM.type = 'metrices'
                       ";
        $value = $this->db->query($buildqry);
        foreach ($value->result_array() as $rows) {
            $temp = $rows['label'];
            $fieldvalues[$temp] = $rows['answer'];
        }
        if (isset($fieldvalues)) {
            foreach ($fieldvalues as $key => $value) {
                if (!is_numeric($value)) {
                    $result = $this->splitformula($value, $fieldvalues);
                    $valresult = @eval("return $result;");
                    $fieldvalues[$key] = $valresult;
                }
            }
        }

        $query = "SELECT PG.answer as answer,extract(Month FROM PG.start_date) as progress_date,PM.label,PG.field as field
                       FROM progress as PG
                       LEFT JOIN progress_master as PM
                       ON (PG.field = PM.id) WHERE
                       PM.type = 'metrices' GROUP BY PG.start_date
                       ";
        $result = $this->db->query($query);
        $listvalue = $result->result_array();
        for ($i = 0; $i < count($listvalue); $i++) {
            if (isset($fieldvalues)) {
                foreach ($fieldvalues as $key => $value) {
                    if ($key == $listvalue[$i]['label']) {
                        $listvalue[$i]['answer'] = $value;
                    }
                }
            }
        }

        return $listvalue;

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

    public function getallfunddisbursed($from = null, $to = null)
    {

        $this->load->model('incubator_metrics/mwglobal_report');
        if ($from != null) {
            $where = 'extract(year from IP.created_date)>=' . $from . ' AND extract(year from IP.created_date)<=' . $to;
        } else {
            $where = '1=1';
        }
        $query = "select IP.id as id,IP.name_of_enterprise,sum(SFA.budgetamt) as amount,SA.approval_note FROM innovation_pool as IP JOIN sf_installments as SF ON(SF.innovation = IP.id) LEFT JOIN sf_approval_note as SA ON(IP.id = SA.innovation) JOIN sf_budget as SFA ON (SF.id = SFA.installment) GROUP BY IP.id";

        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
            for ($i = 0; $i < php72_count($data); $i++) {
                $data[$i]['approved_amount'] = $this->getapprovedamount($data[$i]['approval_note']);
                $data[$i]['fund_utilized'] = $this->mwglobal_report->getutilizedamount($data[$i]['id']);
            }
        }
        return $data;
    }
    public function getapprovedamount($approval_no)
    {
        $sql = "SELECT sum(amt_required) as approved_amount from approval_note_donors WHERE approval_id = '" . $approval_no . "'";
        $query = $this->ais->query($sql);
        $result = $query->result_array();
        return $result[0]['approved_amount'];
    }
    public function getsfunddisbursed($innovation)
    {
        $query = "select IP.*,sum(SFA.vfunded) as amount,SF.id  FROM innovation_pool as IP JOIN sf_installments as SF ON(SF.innovation = IP.id) JOIN sf_activity_amount as SFA ON (SF.id = SFA.installment) WHERE SF.innovation='" . $innovation . "' GROUP BY SF.innovation";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getprogress($from = null, $to = null)
    {
        $data = array();

        $query = "SELECT PG.answer as answer,Month(PG.start_date) as progress_date,PM.label,PG.field as field
                       FROM progress as PG
                       LEFT JOIN progress_master as PM
                       ON (PG.field = PM.id) WHERE
					   PM.type = 'metrices'  GROUP BY PG.start_date";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }
    public function getBoardDetails($from = null, $to = null)
    {

        if ($from != null) {
            $where = 'extract(year from RB.request_date)>=' . $from . ' AND extract(year from RB.request_date)<=' . $to;
        } else {
            $where = '1=1';
        }
        $buildqry = "SELECT IP.name_of_enterprise, SUM( IF( RB.request_status =  '1', 1, 0 ) ) AS  `accept` , SUM( IF( RB.request_status =  '0', 1, 0 ) ) AS  `reject` , COUNT( RB.id ) AS  `total`
			FROM request_board_member AS RB
			JOIN innovation_pool AS IP ON ( IP.id = RB.innovation ) where
			" . $where . "
			GROUP BY RB.innovation";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        // show($data);
        return $data;
    }
    public function getinvesterDetails($from = null, $to = null)
    {

        if ($from != null) {
            $where = ' extract(year from RI.request_date)>=' . $from . '  AND extract(year from RI.request_date)<=' . $to;
        } else {
            $where = '1=1';
        }
        $buildqry = "SELECT IP.name_of_enterprise,I.first_name,AI.amount_approved,AI.villgro_status as status from assign_invester as AI JOIN invester as I ON(I.id = AI.invester_id) JOIN request_invester as RI ON(RI.id = AI.request_id) JOIN innovation_pool as IP ON(AI.innovation = IP.id)";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }
    public function getappDetails($from = null, $to = null)
    {

        if ($from != null) {
            $where = ' extract(year from RA.request_date)>=' . $from . '  AND extract(year from RA.request_date)<=' . $to;
        } else {
            $where = '1=1';
        }
        $buildqry = "SELECT IP.name_of_enterprise, SUM( IF( RA.status =  '0', 1, 0 ) ) AS  `accept` , SUM( IF( RA.status =  '1', 1, 0 ) ) AS
		 `reject` , COUNT( RA.id ) AS  `total`
			FROM request_applicant AS RA
			JOIN innovation_pool AS IP ON ( IP.id = RA.innovation ) where
			" . $where . "
			GROUP BY RA.innovation";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }
    public function getfellowdetails($from = null, $to = null)
    {
        if ($from != null) {
            $where = 'extract(year from RF.request_date)>=' . $from . ' AND extract(year from RF.request_date)<=' . $to;
        } else {
            $where = '1=1';
        }
        $buildqry = "SELECT IP.name_of_enterprise,AF.applicant_id,AF.status from innovation_pool as IP JOIN assign_fellow as AF ON(IP.id = AF.innovation) JOIN request_fellow as RF ON(RF.id = AF.request_id) GROUP BY IP.id ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        $data[0]['applicant_name'] = $this->getapplicantname($data[0]['applicant_id']);
        return $data;
    }
    public function getapplicantname($appid)
    {
        $sql = "SELECT CONCAT(firstname,lastname) as applicant_name from hs_hr_job_application WHERE application_id = '" . $appid . "'";
        $query = $this->hris->query($sql);
        $result = $query->result_array();
        return $result[0]['applicant_name'];
    }
    public function getmediaDetails($from = null, $to = null)
    {
        if ($from != null) {
            $where = 'extract(year from RM.requested_on)>=' . $from . ' AND extract(year from RM.requested_on)<=' . $to;
        } else {
            $where = '1=1';
        }
        $buildqry = "SELECT IP.name_of_enterprise, SUM( IF( RM.decision =  '0', 1, 0 ) ) AS  `accept` , SUM( IF( RM.decision =  '1', 1, 0 ) ) AS
		 `reject` , COUNT( RM.id ) AS  `total`
			FROM request_media AS RM
			JOIN innovation_pool AS IP ON ( IP.id = RM.innovation ) where
			" . $where . "
			GROUP BY RM.innovation";

        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }
    public function getsprogress($innovation)
    {
        $data = array();
        $query = "SELECT PG.answer,PM.label,PG.innovation,IL.name_of_enterprise from progress as PG LEFT JOIN progress_master as PM ON(PG.field = PM.id) LEFT JOIN innovation_pool as IL ON(PG.innovation=IL.id) where PM.type='metrices' and PG.innovation = '" . $innovation . "'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getfundutilized($from = null, $to = null)
    {

        $data = array();
        $this->db->select("sum(amount) as total");
        if ($from != null) {
            $this->db->where('extract(year from date)>=', $from);
            $this->db->where('extract(year from date)<=', $to);
        }
        $query = $this->db->get('sf_fund_utilization');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }
    public function getallfundutilized($from = null, $to = null)
    {
        if ($from != null) {
            $where = 'extract(year from IP.created_date)>=' . $from . ' AND extract(year from IP.created_date)<=' . $to;
        } else {
            $where = '1=1';
        }
        $query = "select IP.name_of_enterprise,IP.summary_of_business as description,sum(SF.amount) as amount FROM innovation_pool as IP
		JOIN sf_fund_utilization as SF ON(SF.innovation = IP.id) WHERE " . $where . " GROUP BY SF.innovation";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getsfundutilized($innovation)
    {
        $query = "select IP.*,IP.summary_of_business as description,sum(SF.amount) as amount FROM innovation_pool as IP JOIN sf_fund_utilization as SF ON(SF.innovation = IP.id) WHERE SF.innovation ='" . $innovation . "'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getallrepayment($from = null, $to = null)
    {
        $data = array();
        if ($from != null) {
            $where = 'extract(year from RP.from_date)>=' . $from . ' AND extract(year from RP.to_date)<=' . $to;
        } else {
            $where = '1=1';
        }
        $query = "select sum(RP.repayment_amount) as amount,RP.from_date,RP.to_date,RP.description,IP.name_of_entrepreneur,IP.stage,IP.name_of_enterprise,IP.created_date,IP.id  FROM repayment_details as RP JOIN innovation_pool as IP ON(RP.innovation = IP.id) where  " . $where . " GROUP BY IP.id";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getsrepayment($innovation)
    {
        $data = array();
        $query = "select sum(RP.repayment_amount) as amount,RP.from_date,RP.to_date,RP.description,IP.name_of_entrepreneur,IP.stage,IP.name_of_enterprise,IP.created_date,IP.id  FROM repayment_details as RP JOIN innovation_pool as IP ON(RP.innovation = IP.id)where RP.innovation ='" . $innovation . "' GROUP BY IP.id";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getrepayment($from = null, $to = null)
    {
        $data = array();
        $this->db->select('sum(repayment_amount) as total');
        if ($from != null) {
            $this->db->where('extract(Year from from_date)>=', $from);
            $this->db->where('extract(Year from to_date)<=', $to);
        }
        $result = $this->db->get('repayment_details');
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;

            }
        }
        return $data;
    }
    public function getmailhistory()
    {
        $query = "select hrisvill_orangehrm.HE.emp_number,hrisvill_orangehrm.HE.emp_firstname,misvillg_mis.IM.from,misvillg_mis.IM.to,misvillg_mis.IM.subject,misvillg_mis.IM.body,misvillg_mis.IM.sent_date,misvillg_mis.SIM.from,misvillg_mis.SIM.to from hris.hs_hr_employee as HE JOIN misvillg_mis.innovation_mail_history as IM ON ((hrisvill_orangehrm.HE.emp_work_email = misvillg_mis.IM.to) OR(hris.HE.emp_work_email = misvillg_mis.IM.from)) JOIN misvillg_mis.sf_mail_history as SIM ON ((hris.HE.emp_work_email = misvillg_mis.SIM.to) OR(hris.HE.emp_work_email = misvillg_mis.SIM.from))";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getemployeemail($emp_number)
    {
        $query = "select hrisvill_orangehrm.HE.emp_number,hrisvill_orangehrm.HE.emp_firstname,misvillg_mis.IM.from as ifrom,misvillg_mis.IM.to as ito,misvillg_mis.IM.subject as isubject,misvillg_mis.IM.body as ibody,misvillg_mis.IM.sent_date,misvillg_mis.IM.mail_type from hrisvill_orangehrm.hs_hr_employee as HE JOIN misvillg_mis.innovation_mail_history as IM ON (hrisvill_orangehrm.HE.emp_work_email = misvillg_mis.IM.to) where hrisvill_orangehrm.HE.emp_number = '" . $emp_number . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getmail($emp_number)
    {
        $data = array();
        $this->hris->select('emp_work_email');
        $this->hris->where('emp_number', $emp_number);
        $query = $this->hris->get('hr_employee');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function insertreply($options = array())
    {
        $data = array('from' => $options['from'],
            'to' => $options['to'],
            'sent_date' => NOW(),
            'subject' => $options['subject'],
            'body' => $options['body'],
            'send_by' => $this->session->userdata('emp_number'),
        );
        $result = $this->db->insert('innovation_mail_history', $data);

        $options['body'] = $this->imgUrl($options['body']);
        $this->Memail->send($options['from'], $options['to'], $options['subject'], $options['body']);
        return $result;
    }
}
