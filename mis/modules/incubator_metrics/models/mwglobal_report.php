<?php
/**
 *
 * Weekly Global Report Page
 *
 * @ControllerName     wglobal_report.php
 * @Author             Sanjoy Dey
 * @Created Date       09-11-2011
 * @Modified Date      12-12-2011
 * @Modified By        Sanjoy Dey
 * @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011
 * @version            CodeIgniter_2.0.3
 * @link               http://www.codeigniter.com
 * @since              File available since Release 2.0.3
 * @Warning            Any change in this file may cause abnormal behaviour of application.
 *
 */

class Mwglobal_report extends CI_Model
{

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->ais = $this->load->database('ais', true);
        $this->hris = $this->load->database('hris', true);
        $this->load->model('common/Mincubation_reports');
    }

    public function getStageDetailsByInnovation($innovation)
    {
        $this->db->select("stage");
        $this->db->where("id", $innovation);
        $query = $this->db->get("innovation_pool");
        $data = $query->result_array();
        return $data;
    }
    public function getportfolio()
    {
        $this->db->where("stage", '5');
        $query = $this->db->get("innovation_pool");
        $data = $query->result_array();
        return $data;
    }
    public function getseedfunding_report($innovation, $year = null)
    {
        $data = array();
        $query = "select IP.id as id,IP.name_of_enterprise,sum(SFA.budgetamt) as amount,SA.approval_note FROM innovation_pool as IP JOIN sf_installments as SF ON(SF.innovation = IP.id) LEFT JOIN sf_approval_note as SA ON(IP.id = SA.innovation) JOIN sf_budget as SFA ON (SF.id = SFA.installment)  where IP.id = '" . $innovation . "' AND extract(YEAR FROM SFA.created_date) = " . $year . "";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['fund_utilized'] = $this->getutilizedamounts($innovation, $year);
            $data[$i]['approved_amount'] = $this->Mincubation_reports->getapprovedamount($data[$i]['approval_note']);
        }
        return $data;
    }
    public function getutilizedamounts($innovation, $year)
    {
        $data = array();
        $query = "SELECT sum(fund_utilized) as fund_utilized from sf_monthly_report WHERE innovation = '" . $innovation . "' AND EXTRACT(YEAR FROM created_date) = " . $year . "";
        $result = $this->db->query($query);
        $data = $result->result_array();
        return $data[0]['fund_utilized'];
    }
    public function getqutilizedamounts($innovation, $year, $quarter)
    {
        $data = array();
        $query = "SELECT sum(fund_utilized) as fund_utilized from sf_monthly_report WHERE innovation = '" . $innovation . "' AND EXTRACT(YEAR FROM created_date) = " . $year . " AND extract(Quarter FROM created_date) = " . $quarter . "";
        $result = $this->db->query($query);
        $data = $result->result_array();
        return $data[0]['fund_utilized'];
    }
    public function getmutilizedamounts($innovation, $year, $month)
    {
        $data = array();
        $query = "SELECT sum(fund_utilized) as fund_utilized from sf_monthly_report WHERE innovation = '" . $innovation . "' AND EXTRACT(YEAR FROM created_date) = " . $year . " AND extract(Month FROM created_date) = " . $month . "";
        $result = $this->db->query($query);
        $data = $result->result_array();
        return $data[0]['fund_utilized'];
    }
    public function getutilizedamount($innovation, $year)
    {
        $data = array();
        $query = "SELECT sum(fund_utilized) as fund_utilized from sf_monthly_report WHERE innovation = '" . $innovation . "' ";
        $result = $this->db->query($query);
        $data = $result->result_array();
        return $data[0]['fund_utilized'];
    }
    public function getmentordetails($innovation, $year)
    {
        $sql = "SELECT IP.name_of_enterprise,M.first_name as company,AM.mentorhours,AM.mentormoney from assign_mentor as AM LEFT JOIN request_mentor as RM ON(RM.id = AM.request_id) LEFT JOIN mentor as M ON(M.id = AM.mentor_id) LEFT JOIN innovation_pool as IP ON(IP.id=AM.innovation) WHERE (extract(Year FROM AM.interview_date) = " . $year . ") AND IP.id = '" . $innovation . "'";
        $buildquery = $this->db->query($sql);
        return $buildquery->result_array();
    }
    public function getboard_service($innovation, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RB.request_status =  '1', 1, 0 ) ) AS  `accept` , SUM( IF( RB.request_status =  '0', 1, 0 ) ) AS  `reject` , COUNT( RB.id ) AS  `total`
FROM request_board_member AS RB
JOIN innovation_pool AS IP ON ( IP.id = RB.innovation ) where
IP.id = '" . $innovation . "' and (extract(Year FROM RB.request_date) = " . $year . ")";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getfundutilized_details($innovation, $year)
    {
        $data = array();
        $query = "SELECT budget,lineitem,fund_utilized from sf_monthly_report WHERE innovation = '" . $innovation . "' AND EXTRACT(YEAR FROM created_date) = " . $year;
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        for ($i = 0; $i < count($data); $i++) {
            $datas = $this->getbudgetamt($data[$i]['lineitem']);
            $data[$i]['amount_approved'] = $datas[0]['budgetamt'];
            $data[$i]['line_item'] = $datas[0]['line_item'];
        }
        return $data;
    }
    public function getbudgetamt($milestone)
    {
        $query = "SELECT lineitem as line_item,budgetamt from sf_budget WHERE id IN ($milestone)";
        $result = $this->db->query($query);
        $data = $result->result_array();
        return $data;
    }

    public function getfellow_service($innovation, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RF.status =  '0', 1, 0 ) ) AS  `accept` , SUM( IF( RF.status =  '1', 1, 0 ) ) AS
		 `reject` , COUNT( RF.id ) AS  `total`
FROM request_fellow AS RF
JOIN innovation_pool AS IP ON ( IP.id = RF.innovation ) where
IP.id = '" . $innovation . "' and (extract(Year FROM RF.request_date) = " . $year . ")";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getmedia_service($innovation, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RM.decision =  '0', 1, 0 ) ) AS  `accept` , SUM( IF( RM.decision =  '1', 1, 0 ) ) AS
		 `reject` , COUNT( RM.id ) AS  `total`
FROM request_media AS RM
JOIN innovation_pool AS IP ON ( IP.id = RM.innovation ) where IP.id ='" . $innovation . "' and (extract(Year FROM RM.requested_on) = " . $year . ")";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getmeeting_service($innovation, $year = null)
    {
        $query = "SELECT count(id) as id from boardmeeting_manager where innovation = '" . $innovation . "' and YEAR(created_date) = " . $year . "";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getrevenue($innovation, $year = null)
    {
        $query = "SELECT sum(answer) as answer from progress where field = '251' and innovation = '" . $innovation . "' and (extract(Year FROM start_date) = " . $year . ")";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;

    }
    //quarterly incuabtee dashboard
    public function getqseedfunding_report($innovation, $quarter = null, $year = null)
    {
        $query = "select IP.id as id,IP.name_of_enterprise,sum(SFA.budgetamt) as amount,SA.approval_note FROM innovation_pool as IP JOIN sf_installments as SF ON(SF.innovation = IP.id) LEFT JOIN sf_approval_note as SA ON(IP.id = SA.innovation) JOIN sf_budget as SFA ON (SF.id = SFA.installment)  where IP.id = '" . $innovation . "' AND extract(YEAR FROM SFA.created_date) = " . $year . " and (extract(Quarter FROM SFA.created_date) = '" . $quarter . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        for ($i = 0; $i < php72_count($data); $i++) {
            $data[$i]['fund_utilized'] = $this->getqutilizedamounts($innovation, $year, $quarter);
            $data[$i]['approved_amount'] = $this->Mincubation_reports->getapprovedamount($data[$i]['approval_note']);
        }
        return $data;
    }
    public function getqboard_service($innovation, $quarter = null, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RB.request_status =  '1', 1, 0 ) ) AS  `accept` , SUM( IF( RB.request_status =  '0', 1, 0 ) ) AS  `reject` , COUNT( RB.id ) AS  `total`
FROM request_board_member AS RB
JOIN innovation_pool AS IP ON ( IP.id = RB.innovation ) where
IP.id = '" . $innovation . "' and (extract(Year FROM RB.request_date) = " . $year . ") and (extract(Quarter FROM RB.request_date) = '" . $quarter . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getqmentordetails($innovation, $quarter = null, $year = null)
    {
        $sql = "SELECT IP.name_of_enterprise,M.first_name as company,AM.mentorhours,AM.mentormoney from assign_mentor as AM LEFT JOIN request_mentor as RM ON(RM.id = AM.request_id) LEFT JOIN mentor as M ON(M.id = AM.mentor_id) LEFT JOIN innovation_pool as IP ON(IP.id=AM.innovation) WHERE (extract(Year FROM AM.interview_date) = " . $year . ") AND (extract(Quarter FROM AM.interview_date) = " . $quarter . ") AND IP.id = '" . $innovation . "'";
        $buildquery = $this->db->query($sql);
        return $buildquery->result_array();
    }
    public function getqfellow_service($innovation, $quarter = null, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RF.status =  '0', 1, 0 ) ) AS  `accept` , SUM( IF( RF.status =  '1', 1, 0 ) ) AS
		 `reject` , COUNT( RF.id ) AS  `total`
FROM request_fellow AS RF
JOIN innovation_pool AS IP ON ( IP.id = RF.innovation ) where
IP.id = '" . $innovation . "' and (extract(Year FROM RF.request_date) = " . $year . ") and (extract(Quarter FROM RF.request_date) = '" . $quarter . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getqmedia_service($innovation, $quarter = null, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RM.decision =  '0', 1, 0 ) ) AS  `accept` , SUM( IF( RM.decision =  '1', 1, 0 ) ) AS
		 `reject` , COUNT( RM.id ) AS  `total`
FROM request_media AS RM
JOIN innovation_pool AS IP ON ( IP.id = RM.innovation ) where IP.id ='" . $innovation . "' and (extract(Year FROM RM.requested_on) = " . $year . ") and (extract(Quarter FROM RM.requested_on) = '" . $quarter . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getqmeeting_service($innovation, $quarter = null, $year = null)
    {
        $query = "SELECT count(id) as id from boardmeeting_manager where innovation = '" . $innovation . "' and Year(created_date) = " . $year . " and Quarter(created_date) = '" . $quarter . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getqrevenue($innovation, $quarter = null, $year = null)
    {
        $query = "SELECT sum(answer) as answer from progress where field = '251' and innovation = '" . $innovation . "' and (extract(Year FROM start_date) = " . $year . ") and (extract(Quarter FROM start_date) = '" . $quarter . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    //month on month report for incuabtee dashboard
    public function getmseedfunding_report($innovation, $month = null, $year = null)
    {
        $query = "select IP.id as id,IP.name_of_enterprise,sum(SFA.budgetamt) as amount,SA.approval_note FROM innovation_pool as IP JOIN sf_installments as SF ON(SF.innovation = IP.id) LEFT JOIN sf_approval_note as SA ON(IP.id = SA.innovation) JOIN sf_budget as SFA ON (SF.id = SFA.installment)  where IP.id = '" . $innovation . "' AND extract(YEAR FROM SFA.created_date) = " . $year . " and (extract(Month FROM SFA.created_date) = '" . $month . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        for ($i = 0; $i < php72_count($data); $i++) {
            $data[$i]['fund_utilized'] = $this->getmutilizedamounts($innovation, $year, $month);
            $data[$i]['approved_amount'] = $this->Mincubation_reports->getapprovedamount($data[$i]['approval_note']);
        }
        return $data;
    }
    public function getmboard_service($innovation, $month = null, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RB.request_status =  '1', 1, 0 ) ) AS  `accept` , SUM( IF( RB.request_status =  '0', 1, 0 ) ) AS  `reject` , COUNT( RB.id ) AS  `total`
FROM request_board_member AS RB
JOIN innovation_pool AS IP ON ( IP.id = RB.innovation ) where
IP.id = '" . $innovation . "' and (extract(Year FROM RB.request_date) = " . $year . ") and (extract(Month FROM RB.request_date) = '" . $month . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getmmentordetails($innovation, $month = null, $year = null)
    {
        $sql = "SELECT IP.name_of_enterprise,M.first_name as company,AM.mentorhours,AM.mentormoney from assign_mentor as AM LEFT JOIN request_mentor as RM ON(RM.id = AM.request_id) LEFT JOIN mentor as M ON(M.id = AM.mentor_id) LEFT JOIN innovation_pool as IP ON(IP.id=AM.innovation) WHERE (extract(Year FROM AM.interview_date) = " . $year . ") AND (extract(Month FROM AM.interview_date) = " . $month . ") AND IP.id = '" . $innovation . "'";
        $buildquery = $this->db->query($sql);
        return $buildquery->result_array();
    }
    public function getmfellow_service($innovation, $month = null, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RF.status =  '0', 1, 0 ) ) AS  `accept` , SUM( IF( RF.status =  '1', 1, 0 ) ) AS
		 `reject` , COUNT( RF.id ) AS  `total`
FROM request_fellow AS RF
JOIN innovation_pool AS IP ON ( IP.id = RF.innovation ) where
IP.id = '" . $innovation . "' and (extract(Year FROM RF.request_date) = " . $year . ") and (extract(Month FROM RF.request_date) = '" . $month . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getmmedia_service($innovation, $month = null, $year = null)
    {
        $query = "SELECT IP.name_of_enterprise, SUM( IF( RM.decision =  '0', 1, 0 ) ) AS  `accept` , SUM( IF( RM.decision =  '1', 1, 0 ) ) AS
		 `reject` , COUNT( RM.id ) AS  `total`
FROM request_media AS RM
JOIN innovation_pool AS IP ON ( IP.id = RM.innovation ) where IP.id ='" . $innovation . "' and (extract(Year FROM RM.requested_on) = " . $year . ") and (extract(Month FROM RM.requested_on) = '" . $month . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getmmeeting_service($innovation, $month = null, $year = null)
    {
        $query = "SELECT count(id) as id from boardmeeting_manager where innovation = '" . $innovation . "' and Year (created_date) = " . $year . " and Month(created_date) = '" . $month . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getmrevenue($innovation, $month = null, $year = null)
    {
        $query = "SELECT sum(answer) as answer from progress where field = '251' and innovation = '" . $innovation . "' and (extract(Year FROM start_date) = " . $year . ") and (extract(Month FROM start_date) = " . $month . ")";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;

    }
    public function getprogress_report($innovation, $year)
    {
        $query = "SELECT P.answer,PM.label,P.start_date as year from progress as P JOIN progress_master as PM ON (P.field = PM.id) where PM.type='metrices' and PM.id = '251' and P.innovation = '" . $innovation . "' ORDER BY P.start_date DESC";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }
    /**
     * Function : getMentorByInovationID method is used to featch data from db
     *
     */
    public function getmentordetailsbyinnovation($innovation)
    {
        $buildqry = "SELECT AM.company,AM.mentorhours,AM.mentormoney from assign_mentor as AM LEFT JOIN request_mentor as RM ON(RM.id = AM.request_id) where AM.innovation = $innovation GROUP BY AM.innovation";
        $query = $this->db->query($buildqry);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getinstallments($innovation)
    {
        $data = array();
        $this->db->select('id');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('sf_installments');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;

    }
    public function getmraiseinvestment($innovation, $year, $month = null)
    {
        $buildqry = "SELECT AI.amount_approved from assign_invester as AI JOIN
		request_invester as RI ON(AI.request_id=RI.id)
	    where AI.innovation = '" . $innovation . "' and YEAR(RI.request_date) = " . $year . " and extract(month from RI.request_date) = '" . $month . "'";
        $query = $this->db->query($buildqry);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }
    public function getqraiseinvestment($innovation, $year, $quarter = null)
    {
        $buildqry = "SELECT AI.amount_approved from assign_invester as AI JOIN
		request_invester as RI ON(AI.request_id=RI.id)
	    where AI.innovation = '" . $innovation . "' and YEAR(RI.request_date) = " . $year . " and extract(quarter from RI.request_date) = '" . $quarter . "'";
        $query = $this->db->query($buildqry);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }
    public function getraiseinvestment($innovation, $year)
    {
        $buildqry = "SELECT AI.amount_approved from assign_invester as AI JOIN
		request_invester as RI ON(AI.request_id=RI.id)
	    where AI.innovation = '" . $innovation . "' and YEAR(RI.request_date) = " . $year . "";
        $query = $this->db->query($buildqry);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }
    public function getMentorByInovationID($innovationID)
    {

        $buildqry = "SELECT count(request_id) as target,no_mentor as actual
                        FROM request_mentor as RM
                        LEFT JOIN assign_mentor as AM
                        ON (RM.innovation = AM.innovation) WHERE AM.innovation='$innovationID'";
        $value = $this->db->query($buildqry);
        $values = $value->result_array();
        $values = $values[0];
        return $values;
    }

    public function getactivityList()
    {

        $data = array();
        $query = "SELECT PM.label,PG.field,PG.answer,MS.master_name as master_name,PM.period as date_type,PG.villgro_answer,PG.answerby,PG.villgro_answerby,extract(month from PG.start_date) as start_date,extract(year from PG.end_date) as end_date,PG.criteria FROM progress as PG
					LEFT JOIN master_settings as MS ON (MS.id = PG.criteria)
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) where type = 'activity' GROUP BY PG.start_date";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[] = $row;
            }
        }

        return $data;

    }

    //getcriteriaList is used to save period values in array
    public function getcriteriaList()
    {
        $list = array(
            "2" => 'Monthly Report',
            "3" => 'Quarterly Report',
            "4" => 'Yearly Report',
        );
        return $list;
    }

    public function getMentorBy_Year($postData = null)
    {
        $startDate = $postData['year']['fromYear'];
        $endDate = $postData['year']['toYear'];
        $query = "SELECT count(request_id) as target,no_mentor as actual
				  FROM request_mentor as RM
		          LEFT JOIN assign_mentor as AM
		          ON (RM.innovation = AM.innovation)
		          where YEAR(RM.request_date)
		          between $startDate AND $endDate";
        $value = $this->db->query($query);
        $data = $value->result_array();
        $values = $data[0];
        return $values;
    }

    /**
     * Function : getFundDetailsByDate method is used to featch data from db
     *
     */
    public function getFundDetailsByDate()
    {
        $build_qry = "Select sum(amt_required) from approval_note_donors";
        $value = $this->ais->query($build_qry);
        $data = $value->result_array();
        $data = $data['0'];

        return $data;
    }

    public function getFundUTDetailsBy_InovationID($innovationID)
    {
        $buildqry = "SELECT amount from sf_fund_utilization WHERE innovation='$innovationID'";
        $value = $this->db->query($buildqry);
        $values = $value->result_array();

        return $values;
    }
    public function getFundUTDetailsBy_Year($postdata = null)
    {
        $start_Date = $postdata['year']['fromYear'];
        $end_Date = $postdata['year']['toYear'];
        $innovation = $this->uri->segment('4');
        $buildqry = "SELECT amount from sf_fund_utilization WHERE innovation='.$innovation.' AND YEAR(date) between '$start_Date' AND '$end_Date'";
        $value = $this->db->query($buildqry);
        $values = $value->result_array();

        return $values;
    }

    public function getPartnerDetails($innovation)
    {
        $buildqry = "SELECT (decision) as actual,COUNT(innovation) as target from connecting_partner WHERE innovation='$innovation'";
        $value = $this->db->query($buildqry);
        $values = $value->result_array();
        $data = $values[0];
        return $data;
    }

    /**
     * Function : getQuaterlyDetails method is used to fetch Quarter details from array.
     *
     */
    public function getQuaterlyDetails()
    {

        $quaterList = array(
            "001" => 'First Quater',
            "002" => 'Second Quater',
            "003" => 'Third Quater',
            "004" => 'Fourth Quater',
        );
        return $quaterList;
    }

    public function getQuarterDefaultDetails($data)
    {

        $buildqry = "SELECT PG.answer as answer,extract(Month FROM PG.start_date) as progress_date,PM.label,PG.field as field
					FROM progress as PG
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) WHERE
					PG.innovation= '$data[urlcode]' AND
					PG.date_type = '$data[tabKey]'
					";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }

    //configuration for weekly report
    public function getconfigWeeklyreport($option)
    {

        $build_qry = "select PG.answer as answer,PG.field,PM.label,PG.start_date,PG.end_date,PG.start_date as progress_date from progress as PG JOIN progress_master as PM ON(PG.field = PM.id)";
        $value = $this->db->query($build_qry);
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

        $query = "SELECT PG.field as field,PG.answer as answer,PG.start_date,PG.end_date,PM.label,extract(year FROM PG.start_date) as progress_date
					FROM progress as PG
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) WHERE PG.field IN ('" . php72_implode("','", $option) . "')";
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

    //configuration for monthly report
    public function getconfigMonthlyreport($option)
    {

        $build_qry = "select PG.answer as answer,PG.field,PM.label,extract(Month FROM PG.start_date) as progress_date from progress as PG JOIN progress_master as PM ON(PG.field = PM.id)";
        $value = $this->db->query($build_qry);
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

        $query = "SELECT PG.field as field,PG.answer as answer,PM.label,extract(year FROM PG.start_date) as progress_date
					FROM progress as PG
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) WHERE PG.field IN ('" . php72_implode("','", $option) . "')";
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
    //configuration for quarterly report
    public function getconfigQuarterreport($option)
    {

        $build_qry = "SELECT PG.field as field,PG.answer as answer,PM.label,extract(year FROM PG.start_date) as progress_date
					FROM progress as PG
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) WHERE PG.field IN ('" . php72_implode("','", $option) . "')";
        $value = $this->db->query($build_qry);
        $data = $value->result_array();
        return $data;
    }

    //getting the quarterly details by date
    public function getQuarterDetailsByDate($postDate, $value)
    {
        $this->db->select('P.answer as answer,PM.label,extract(Month FROM P.start_date) as progress_date');
        $this->db->from('progress as P');
        $this->db->join('progress_master as PM', 'P.field = PM.id', 'left');
        switch ($postDate['quaterDetails']) {

            case "001":
                $start_date = date('01-m-Y', strtotime('January' . $postDate['yearDetails']));
                $end_date = date('t-m-Y', strtotime('March' . $postDate['yearDetails']));
                $this->db->where('P.start_date >=', date2mysql($start_date));
                $this->db->where('P.end_date <=', date2mysql($end_date));
                break;
            case "002":
                $start_date = date('01-m-Y', strtotime('April' . $postDate['yearDetails']));
                $end_date = date('t-m-Y', strtotime('June' . $postDate['yearDetails']));
                $this->db->where('P.start_date >=', date2mysql($start_date));
                $this->db->where('P.end_date <=', date2mysql($end_date));
                break;
            case "003":

                $start_date = date('01-m-Y', strtotime('July' . $postDate['yearDetails']));
                $end_date = date('t-m-Y', strtotime('September' . $postDate['yearDetails']));
                $this->db->where('P.start_date >=', date2mysql($start_date));
                $this->db->where('P.end_date <=', date2mysql($end_date));
                break;
            case "004":
                $start_date = date('01-m-Y', strtotime('October' . $postDate['yearDetails']));
                $end_date = date('t-m-Y', strtotime('December' . $postDate['yearDetails']));
                $this->db->where('P.start_date >=', date2mysql($start_date));
                $this->db->where('P.end_date <=', date2mysql($end_date));
                break;
        }

        $this->db->where('P.innovation', $value['urlcode']);
        $this->db->where('P.date_type', $value['tabKey']);
        $data = $this->db->get()->result_array();

        return $data;

    }
    public function getqmediaDetailsByInnovation($options, $postDate = null)
    {

        $start_date = date('01-m-Y', strtotime('January' . $postDate['yearDetails']));
        $end_date = date('t-m-Y', strtotime('December' . $postDate['yearDetails']));
        $buildqry = "SELECT 'total',count(id) from `request_media` WHERE innovation = '" . $options['urlcode'] . " and request_on >= ''$start_date UNION SELECT 'accept',count(id) FROM `request_media` WHERE decision= 0 AND innovation = '" . $options['urlcode'] . " and request_on >= $start_date' UNION SELECT 'reject',count(id) FROM `request_media` WHERE decision=1  AND innovation = '" . $options['urlcode'] . "' and request_on >= $start_date";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }
    public function getqfelowDetailsByInnovation($options, $postDate = null)
    {

        $buildqry = "SELECT 'total',count(id) from `request_fellow` WHERE innovation = '" . $options['urlcode'] . "' UNION SELECT 'accept',count(id) FROM `request_fellow` WHERE status= 0 AND innovation = '" . $options['urlcode'] . "' UNION SELECT 'reject',count(id) FROM `request_fellow` WHERE status=1 AND innovation = '" . $options['urlcode'] . "'";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function getqBoardDetailsByInnovation($options, $postDate = null)
    {

        $start_date = date('01-m-Y', strtotime('January' . $postDate['yearDetails']));
        $end_date = date('t-m-Y', strtotime('December' . $postDate['yearDetails']));
        $buildqry = "Select id,request_status from request_board_member where innovation='$options[urlcode]' and  request_date >= '$start_date'";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function getqinvesterDetailsByInnovation($options, $postDate = null)
    {

        $start_date = date('01-m-Y', strtotime('January' . $postDate['yearDetails']));
        $end_date = date('t-m-Y', strtotime('December' . $postDate['yearDetails']));
        $buildqry = "Select id,status from request_invester where innovation='$options[urlcode]' and  request_date >= '$start_date'";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }
    //getting task details by quarter date
    public function getTaskDetails_ByQuarterDate($postData = null)
    {

        $this->db->select('AT.task_name as label,AT.target as actual,extract(month FROM AT.start_date) as month,extract(year FROM AT.end_date) as year');
        $this->db->from('assign_task as AT');
        if (isset($postDate['quaterDetails'])) {
            switch ($postDate['quaterDetails']) {

                case "001":
                    $start_date = date('01-m-Y', strtotime('January' . $postDate['yearDetails']));
                    $end_date = date('t-m-Y', strtotime('March' . $postDate['yearDetails']));
                    $this->db->where('AT.start_date >=', date2mysql($start_date));
                    $this->db->where('AT.end_date <=', date2mysql($end_date));
                    break;
                case "002":
                    $start_date = date('01-m-Y', strtotime('April' . $postDate['yearDetails']));
                    $end_date = date('t-m-Y', strtotime('June' . $postDate['yearDetails']));
                    $this->db->where('AT.start_date >=', date2mysql($start_date));
                    $this->db->where('AT.end_date <=', date2mysql($end_date));
                    break;
                case "003":

                    $start_date = date('01-m-Y', strtotime('July' . $postDate['yearDetails']));
                    $end_date = date('t-m-Y', strtotime('September' . $postDate['yearDetails']));
                    $this->db->where('AT.start_date >=', date2mysql($start_date));
                    $this->db->where('AT.end_date <=', date2mysql($end_date));
                    break;
                case "004":
                    $start_date = date('01-m-Y', strtotime('October' . $postDate['yearDetails']));
                    $end_date = date('t-m-Y', strtotime('December' . $postDate['yearDetails']));
                    $this->db->where('AT.start_date >=', date2mysql($start_date));
                    $this->db->where('AT.end_date <=', date2mysql($end_date));
                    break;
            }
        }
        $data = $this->db->get()->result_array();

        return $data;

    }
    public function green($innovationid, $field)
    {
        $query = "select EM.value as answer,PM.label as label,PG.field from exit_details_master as EM
				  JOIN progress as PG ON(PG.innovation = EM.innovation) JOIN progress_master as PM ON(PG.field = PM.id)
				  WHERE PG.innovation = '" . $innovationid . "'  AND PM.label IN ('" . $field . "')";
        $value = $this->db->query($query);
        $result = $value->result_array();

        return $result;

    }
    public function getWeekDetails($data)
    {

        $buildqry = "SELECT PG.answer as answer,PM.label,PG.field as field
                        FROM progress as PG
                        LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
                        PG.innovation= '$data[urlcode]'	AND
						PM.type = 'metrices'
                        ";
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

        $query = "select PG.field,PM.label,PG.start_date,PG.end_date,PG.start_date as progress_date from progress as PG JOIN progress_master as PM 		ON(PG.field = PM.id) WHERE PG.date_type =1";
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
    public function getweeklymediaDetails()
    {
        $query = "select count(RM.id),count(MD.media_id) from request_media  as RM LEFT JOIN media_details as MD ON(RM.id = MD.media_id)";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getweeklyapplicantDetails()
    {
        $query = "select count(RA.id),count(AA.id) from request_applicant as RA LEFT JOIN assign_applicant as AA ON(RA.id = AA.id)";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getweeklymediaDetails_bydate($postData = null)
    {
        $startDate = date2mysql($postData['fromWeek']);
        $endDate = date2mysql($postData['toWeek']);
        $query = "select count(RM.id),count(MD.media_id) from request_media  as RM LEFT JOIN media_details as MD ON(RM.id = MD.media_id) where RM.requested_on >= '" . $startDate . 'AND RM.requested_on <="' . $endDate . "'";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getweeklyapplicantDetails_bydate($postData = null)
    {
        $startDate = date2mysql($postData['fromWeek']);
        $endDate = date2mysql($postData['toWeek']);
        $query = "select count(RA.id),count(AA.id) from request_applicant as RA LEFT JOIN assign_applicant as AA ON(RA.id = AA.id) where RA.request_date >= '" . $startDate . 'AND RA.request_date <="' . $endDate . "'";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getWeekDetailsByDate($postData, $value)
    {

        $startDate = date2mysql($postData['fromWeek']);
        $endDate = date2mysql($postData['toWeek']);

        $buildqry = "SELECT PG.answer as answer,extract(month FROM PG.start_date) as progress_date,PG.start_date,PG.end_date,PM.label
                        FROM progress as PG
                        LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
                        PG.innovation= '$value[urlcode]' AND
                        PG.date_type = '$value[tabKey]' AND
                        PG.start_date >= '$startDate' AND
                        PG.end_date <= '$endDate'
			";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function insertConfigureDetailsBYID($option)
    {

        $data = array(
            'innovation' => $option['urlcode'],
            'configure_type' => $option['title'],
            'label' => serialize(php72_array_filter($option['label'])),
            'chart_type' => $option['showtype'],
            'frequency' => $option['tabkey'],
            'created_date' => date("Y-m-d"),
        );

        if ($this->checkConfigureDuplicate($option['urlcode'])) {
            $this->db->insert("dashboard_configure", $data);
        } else {
            unset($data['created_date']);
            $this->db->where('innovation', $option['urlcode']);
            $this->db->update('dashboard_configure', $data);
        }
        return true;
    }

    public function checkConfigureDuplicate($innovation)
    {
        $this->db->select("id,innovation,chart_type");
        $this->db->where_in("innovation", $innovation);
        $result = $this->db->get('dashboard_configure');
        $data = $result->result_array();
        if ($result->num_rows() > 0) {

            return false;
        } else {

            return true;
        }
    }

    public function getConfigureDetailsByInnovation($innovation)
    {
        $data = array();
        $this->db->select("configure_type,innovation,label,chart_type,frequency");
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('dashboard_configure');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row["value"] = unserialize($row["label"]);
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getconfigMonthyreport($option)
    {
        $build_qry = "SELECT PG.field as field,PG.answer as answer,PM.label,extract(month FROM PG.start_date) as progress_date
					FROM progress as PG
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) WHERE PG.field IN ('" . php72_implode("','", $option) . "') ";
        $value = $this->db->query($build_qry);
        $data = $value->result_array();

        return $data;
    }


    public function getexitCriteriaReportDetails($innovation)
    {

        $buildqry = "SELECT sum(PG.answer) as answer,extract(YEAR FROM PG.start_date) as progress_date,PM.label,PG.field as field
                        FROM progress as PG
                        LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
                        PG.innovation= '$innovation'	AND
						PM.type = 'metrices'
                        ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function getConfigListByInnovation($option)
    {
        $buildqry = "SELECT distinct(PM.label),PG.field as field
                        FROM progress as PG
                        LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
                        PG.innovation= '$option[urlcode]' AND
						PM.type = 'metrices'
                        ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function getmediaDetailsByInnovation($options, $postData = null)
    {
        $buildqry = "SELECT 'total',count(id) from `request_media` WHERE innovation = '" . $options['urlcode'] . "' UNION SELECT 'accept',count(id) FROM `request_media` WHERE decision= 0 AND innovation = '" . $options['urlcode'] . "' UNION SELECT 'reject',count(id) FROM `request_media` WHERE decision=1  AND innovation = '" . $options['urlcode'] . "'";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }
    public function getfelowDetailsByInnovation($options, $postData = null)
    {
        $where = "";
        if ($postData != null) {
            $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
            $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
            $startDate = date2mysql($start_Date);
            $endDate = date2mysql($end_Date);
            $where = "AND from_period >= '" . $startDate . "' AND to_period <= '" . $endDate . "'";
        }

        $buildqry = "SELECT 'total',count(id) from `request_fellow`
									WHERE innovation = '" . $options['urlcode'] . "' UNION SELECT 'accept',count(id) FROM `request_fellow`
									WHERE status= 0 AND innovation = '" . $options['urlcode'] . "' UNION SELECT 'reject',count(id) FROM `request_fellow`
 									WHERE status=1 AND innovation = '" . $options['urlcode'] . "' $where";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function getBoardDetailsByInnovation($innovation, $postData = null)
    {
        $this->db->select("id,request_status");
        $this->db->where("innovation", $innovation);
        if ($postData != null) {
            $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
            $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
            $startDate = date2mysql($start_Date);
            $endDate = date2mysql($end_Date);
            $this->db->where("request_date", $startDate);
            $this->db->where("accept_date", $endDate);
        }
        $value = $this->db->get("request_board_member");
        $data = $value->result_array();

        return $data;
    }

    public function getinvesterDetailsByInnovation($options, $postDate = null)
    {
        $where = "";
        if ($postDate != null) {
            $start_Date = date('01-m-Y', strtotime(@$postDate['fromMonth']));
            $end_Date = date('t-m-Y', strtotime(@$postDate['toMonth']));
            $startDate = date2mysql($start_Date);
            $endDate = date2mysql($end_Date);
            $where = "AND request_date >= '" . $startDate . "' AND accept_date <= '" . $endDate . "'";
        }

        $buildqry = "Select id,status from request_invester where innovation='$options[urlcode]' $where ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }

    public function getConfigureList($data)
    {
        $buildqry = "SELECT * FROM progress_master";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }

    public function getFundingDetailsBYMONTH($postData, $innovation)
    {

        $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
        $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
        $startDate = date2mysql($start_Date);
        $endDate = date2mysql($end_Date);

        $buildqry = "SELECT sum(AM.vfunded) as totalamount,extract(year from SA.created_date) as date
                        FROM sf_activity_amount as AM
                        LEFT JOIN sf_activities as SA
                        ON (SA.id = AM.id) WHERE
                        SA.innovation= '$innovation' AND
						SA.created_date >= '$startDate' AND
						SA.modified_date <= '$endDate'
						";

        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }

    public function getApprovalNoteBYMONTH($postData, $innovation, $installment)
    {

        $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
        $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
        $startDate = date2mysql($start_Date);
        $endDate = date2mysql($end_Date);
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where('installment', $installment);
        $query = $this->db->get('sf_approval_note');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['approval_note'];
            }
        }
        $query->free_result();
        if (count($data)) {
            return $this->getApprovalList($data);
        } else {
            return array();
        }

    }

    public function getApprovalList($approval_note = array())
    {
        $data = array();
        $q = "select IF(AN.donor=0,AN.other_donor,D.master_name) as donor,
							IF(line_item=0,other_line_item,LI.master_name) as line_item,
							IF(budget_head=0,other_budget_head,BH.master_name) as budget_head,
							AN.amt_available,
							AN.amt_required ,
							MP.programme as programme_name,MP.programme_head,AP.* from approval_note AP";
        $q .= " left join master_programme MP on AP.programme= MP.programme_id";
        $q .= " left join approval_note_donors AN on AP.approval_id= AN.approval_id";
        $q .= " left join master_settings D on D.master_id= AN.donor";
        $q .= " left join master_settings BH on BH.master_id= AN.budget_head";
        $q .= " left join master_settings LI on LI.master_id= AN.line_item";
        $q .= " where AP.approval_id IN (" . php72_implode(',', $approval_note) . ")";
        $q .= " group by AP.approval_id";
        $query = $this->ais->query($q);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getFundingDetails($tabID, $innovation)
    {

        if ($tabID == 'month') {
            $buildqry = "SELECT sum(AM.vfunded) as totalamount,	extract(year from SA.created_date) as date
                        FROM sf_activity_amount as AM
                        LEFT JOIN sf_activities as SA
                        ON (SA.id = AM.id) WHERE
                        SA.innovation= '$innovation' AND
						extract(month from SA.created_date) = month(SA.created_date)  AND
						extract(year from SA.created_date) = year(CURRENT_DATE)
						";
        } else {
            $buildqry = "SELECT sum(AM.vfunded) as totalamount ,	extract(year from SA.created_date) as date
                        FROM sf_activity_amount as AM
                        LEFT JOIN sf_activities as SA
                        ON (SA.id = AM.id) WHERE
                        SA.innovation= '$innovation' AND
						extract(year from SA.created_date) = year(CURRENT_DATE)
						"; //SA.created_date
        }

        $value = $this->db->query($buildqry);
        $data = $value->result_array();
        return $data;
    }
    public function getFundUtilizedDetailsBYMonth($postData, $innovation)
    {

        $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
        $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
        $startDate = date2mysql($start_Date);
        $endDate = date2mysql($end_Date);

        $buildqry = "SELECT sum(amount) as utilized_amount,extract(year from sf.created_date) as date
                        FROM sf_fund_utilization as sf WHERE
                        innovation= '$innovation' AND
						date >= '$startDate' AND
						created_date <= '$endDate'
                        ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function getFundUtilizedDetails($tabID, $innovation)
    {
        if ($tabID == 'month') {
            $buildqry = "SELECT sum(amount) as utilized_amount,extract(year from sf.created_date) as date
                        FROM sf_fund_utilization as sf WHERE
                        innovation= '$innovation' AND
						extract(month from sf.created_date) = month(CURRENT_DATE)  AND
						extract(year from sf.created_date) = year(CURRENT_DATE)
                        ";
        } else {

            $buildqry = "SELECT sum(amount) as utilized_amount,extract(year from sf.created_date) as date
                        FROM sf_fund_utilization  as sf WHERE
                        innovation= '$innovation' AND
						extract(year from sf.created_date) = year(CURRENT_DATE)
                        ";

        }
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function getMonthDetails($innovation)
    {
        $build_qry = "SELECT PG.answer as answer,extract(Month FROM PG.start_date) as progress_date,PM.label,PG.field as field
                       FROM progress as PG
                       LEFT JOIN progress_master as PM
                       ON (PG.field = PM.id) WHERE
                       PG.innovation= '$innovation' AND
                       PM.type = 'metrices'";
        $value = $this->db->query($build_qry);

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

        $query = "SELECT extract(Month FROM PG.start_date) as progress_date,PM.label,PG.field as field
                       FROM progress as PG
                       LEFT JOIN progress_master as PM
                       ON (PG.field = PM.id) WHERE
                       PG.innovation= '$innovation' AND
                       PM.type = 'metrices' AND  PG.date_type=2 ORDER BY PG.start_date";
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
    /**
     * Function : getMonthDetailsByDate method is used to function is used to get details from assign task by date.
     *
     * @param array $postData & $data
     */
    public function getMonthDetailsByDate($postData, $data)
    {

        $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
        $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
        $startDate = date2mysql($start_Date);
        $endDate = date2mysql($end_Date);

        $buildqry = "SELECT PG.answer as answer,extract(month FROM PG.start_date) as progress_date,PM.label
                            FROM progress as PG
                            LEFT JOIN progress_master as PM
                            ON (PG.field = PM.id) WHERE
                            PG.innovation= '$data[urlcode]'
					";
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

        $query = "select PG.field,PM.label,extract(month FROM PG.start_date) as progress_date from progress as PG JOIN progress_master as PM ON(PG.field = PM.id)  WHERE
                            PG.innovation = '$data[urlcode]' AND
                            PG.date_type = '$data[tabKey]' AND
                            PG.start_date >= '$startDate' AND
                            PG.end_date <= '$endDate'";
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
    public function getmonthlymediaDetails_bydate($postData)
    {
        $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
        $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
        $startDate = date2mysql($start_Date);
        $endDate = date2mysql($end_Date);
        $query = "select count(RM.id),count(MD.media_id) from request_media  as RM LEFT JOIN media_details as MD ON(RM.id = MD.media_id) where RM.requested_on >= '" . $start_Date . "' AND RM.requested_on <='" . $end_Date . "'";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getmonthlyapplicantDetails_bydate($postData)
    {
        $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
        $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
        $start_Date = date2mysql($start_Date);
        $end_Date = date2mysql($end_Date);
        $query = "select count(RA.id),count(AA.id) from request_applicant as RA LEFT JOIN assign_applicant as AA ON(RA.id = AA.id) where RA.request_date >= '" . $start_Date . "'AND RA.request_date <='" . $end_Date . "'";
        $value = $this->db->query($query);
        $data = $value->result_array();
        return $data;

    }
    public function getmonthlymediaDetails()
    {
        $query = "select count(RM.id),count(MD.media_id) from request_media  as RM LEFT JOIN media_details as MD ON(RM.id = MD.media_id)";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getmonthlyapplicantDetails()
    {
        $query = "select count(RA.id),count(AA.id) from request_applicant as RA LEFT JOIN assign_applicant as AA ON(RA.id = AA.id)";
        $value = $this->db->query($query);
        $data = $value->result_array();
        return $data;

    }
    /**
     * Function : getyear_ReportByDate method is used to display yearly data in dashboard based on given year.
     *
     * @param array $reportData
     */
    public function getyear_ReportByDate($data, $reportData)
    {

        $start_Date = date('01-m-Y', strtotime('January' . $reportData['year']['fromYear']));
        $end_Date = date('t-m-Y', strtotime('December' . $reportData['year']['toYear']));
        $startDate = date2mysql($start_Date);
        $endDate = date2mysql($end_Date);

        $build_qry = "SELECT PG.field as field,PG.answer as answer,extract(year FROM PG.start_date) as progress_date,PM.label
					FROM progress as PG
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id)";

        $value = $this->db->query($build_qry);
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

        $query = "select PG.field,PM.label,extract(year FROM PG.start_date) as progress_date from progress as PG JOIN progress_master as PM ON(PG.field = PM.id)  WHERE
                            PG.innovation = '$data[urlcode]' AND
                            PG.date_type = '$data[tabKey]' AND
                            PG.start_date >= '$startDate' AND
                            PG.end_date <= '$endDate'";
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
    /**
     * Function : getyear_Report method is used to display yearly data in dashboard.
     *
     * @param array $reportData
     */
    public function getyearlymediaDetails()
    {
        $query = "select count(RM.id),count(MD.media_id) from request_media  as RM LEFT JOIN media_details as MD ON(RM.id = MD.media_id)";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getyearlymediaDetailsbyinnovation()
    {
        $query = "select count(id) from request_media UNION select count(id) from request_media where decision=0 UNION select count(id) from request_media where decision=1";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getyearlyapplicantDetails()
    {
        $query = "select count(RA.id),count(AA.id) from request_applicant  as RA LEFT JOIN assign_applicant as AA ON(RA.id = AA.id)";
        $value = $this->db->query($query);
        $data = $value->result_array();
        return $data;

    }
    public function getyearlymediaDetails_bydateinnovation($reportData)
    {
        $start_Date = date('01-m-Y', strtotime('January' . $reportData['year']['fromYear']));
        $end_Date = date('t-m-Y', strtotime('December' . $reportData['year']['toYear']));
        $start_Date = date2mysql($start_Date);
        $end_Date = date2mysql($end_Date);
        $query = "select count(id) from request_media where requested_on >= '" . $start_Date . "' AND requested_on <='" . $end_Date . "' UNION select count(id) from request_media where decision =0 AND requested_on >= '" . $start_Date . "' AND requested_on <='" . $end_Date . "' UNION select count(id) from request_media where decision = 1 AND requested_on >= '" . $start_Date . "' AND requested_on <='" . $end_Date . "'";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getyearlymediaDetails_bydate($reportData)
    {
        $start_Date = date('01-m-Y', strtotime('January' . $reportData['year']['fromYear']));
        $end_Date = date('t-m-Y', strtotime('December' . $reportData['year']['toYear']));
        $start_Date = date2mysql($start_Date);
        $end_Date = date2mysql($end_Date);
        $query = "select count(RM.id),count(MD.media_id) from request_media  as RM LEFT JOIN media_details as MD ON(RM.id = MD.media_id) where RM.requested_on >= '" . $start_Date . "' AND RM.requested_on <='" . $end_Date . "'";
        $value = $this->db->query($query);
        $data = $value->result_array();

        return $data;

    }
    public function getyearlyapplicantDetails_bydate($reportData)
    {
        $start_Date = date('01-m-Y', strtotime('January' . $reportData['year']['fromYear']));
        $end_Date = date('t-m-Y', strtotime('December' . $reportData['year']['toYear']));
        $start_Date = date2mysql($start_Date);
        $end_Date = date2mysql($end_Date);
        $query = "select count(RA.id),count(AA.id) from request_applicant  as RA LEFT JOIN assign_applicant as AA ON(RA.id = AA.id) where RA.requested_on >= '" . $start_Date . "' AND RA.requested_on <='" . $end_Date . "'";
        $value = $this->db->query($query);
        $data = $value->result_array();
        return $data;

    }

    public function getYearMatricsDetails($data)
    {

        $buildqry = "SELECT PG.answer as answer,extract(year FROM PG.start_date) as progress_date,PM.label,PG.field as field
                        FROM progress as PG
                        LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
                        PG.innovation= '$data[urlcode]'	AND
						PM.type = 'metrices'
                        ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    public function getExitMatricsDetails($data)
    {

        $buildqry = "select EM.value as answer,PM.label as label,PG.start_date as progress_date,PG.field from exit_details_master as EM
				  JOIN progress as PG ON(PG.innovation = EM.innovation) JOIN progress_master as PM ON(PG.field = PM.id)
				  WHERE PG.innovation = '" . $data['urlcode'] . "' AND PM.type='metrices' Group By PG.start_date";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }
    public function getExitboard($innovation)
    {

        $buildqry = "SELECT count(board_id) from assign_board_member WHERE
                        innovation= '$innovation' and incubatee_status = 1 and villgro_status=1";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;

    }

    public function getExitCriteria($innovation)
    {

        $buildqry = "SELECT innovation,id,extract(year from created_date) as exitDate from
						boardmeeting_manager WHERE
                        innovation= '$innovation' AND
						 extract(year from created_date) = year(CURRENT_DATE)
                        ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;

    }

    public function getyear_Report($reportData)
    {
        $build_qry = "SELECT PG.field as field,extract(year FROM PG.start_date) as progress_date,PG.answer as answer,PM.label
                        FROM progress as PG
                        LEFT JOIN progress_master as PM
                        ON (PG.field = PM.id) WHERE
                        PG.innovation= $reportData[urlcode]
						";
        $value = $this->db->query($build_qry);

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

        $query = "select PG.field,PM.label,extract(year FROM PG.start_date) as progress_date from progress as PG JOIN
		progress_master as PM
		ON(PG.field = PM.id) WHERE PG.date_type=4";
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

    public function getconfigYearReportByLabel($option)
    {

        $build_qry = "SELECT PG.field as field,PG.answer as answer,PM.label,extract(year FROM PG.start_date) as progress_date
					FROM progress as PG
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) WHERE PG.field IN ('" . php72_implode("','", $option) . "')";
        $value = $this->db->query($build_qry);
        $data = $value->result_array();

        return $data;
    }

    //adding the config the year report
    public function getconfigyearreport($option)
    {
        $build_qry = "select PG.answer as answer ,PG.field,PM.label,extract(year FROM PG.start_date) as progress_date from progress as PG JOIN progress_master as PM ON(PG.field = PM.id) WHERE PG.date_type=4";
        $value = $this->db->query($build_qry);
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

        $query = "SELECT PG.field as field,PG.answer as answer,PM.label,extract(year FROM PG.start_date) as progress_date
					FROM progress as PG
					LEFT JOIN progress_master as PM
					ON (PG.field = PM.id) WHERE PG.field IN ('" . php72_implode("','", $option) . "')";
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
    /**
     * Function : getTaskDetails method is used to task Details to display data in dashboard.
     *
     *
     */
    public function getTaskDetails()
    {

        $buildqry = "SELECT task_name as label,target as actual,extract(month FROM assign_task.start_date) as month,
                         extract(year FROM assign_task.end_date) as year from assign_task";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;
    }

    /**
     * Function : getTaskDetails_ByDate method is used to get records by Date.
     *
     * @param array $postData
     *
     */
    public function getTaskDetails_ByDate($postData)
    {

        $start_Date = date('01-m-Y', strtotime($postData['fromMonth']));
        $end_Date = date('t-m-Y', strtotime($postData['toMonth']));
        $startDate = date2mysql($start_Date);
        $endDate = date2mysql($end_Date);

        $buildqry = "SELECT task_name as label,target as actual,extract(month FROM assign_task.start_date) as month,extract(year FROM assign_task.end_date) as year
		            FROM assign_task WHERE
                            start_date >= '$startDate' AND
                            start_date <= '$endDate'
                            ";
        $value = $this->db->query($buildqry);
        $data = $value->result_array();

        return $data;

    }

    /**
     * Function : getLimitRecords method is used for get Limit records from  vendors.
     *
     * @param array $options
     *
     */

    public function getLimitRecords($options = array())
    {
        $data = array();
        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        } else {
            $this->db->select("id,task_name,target,extract(month FROM assign_task.start_date) as month,extract(year FROM assign_task.end_date) as year,comments");
        }

        $query = $this->db->get('assign_task');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /**
     * Function : insert method is used to add task Details.
     *
     * @param array $options
     *
     */
    public function insert($options = array())
    {

        $start_date = date('01-m-Y', strtotime($options['period']));
        $end_date = date('t-m-Y', strtotime($options['period']));
        $data = array(
            'task_name' => $options['task_name'],
            'target' => $options['target'],
            'start_date' => date2mysql($start_date),
            'end_date' => date2mysql($end_date),
            'comments' => $options['comments'],
        );
        $result = $this->db->insert('assign_task', $data);
        return $result;
    }
    /**
     * Function : update method is used to update task Details.
     *
     * @param int $id
     *
     */

    public function update($options = array(), $id)
    {

        $start_date = date('01-m-Y', strtotime($options['period']));
        $end_date = date('t-m-Y', strtotime($options['period']));
        $editData = array(
            'task_name' => $options['task_name'],
            'target' => $options['target'],
            'start_date' => date2mysql($start_date),
            'end_date' => date2mysql($end_date),
            'comments' => $options['comments'],
        );

        $this->db->where('id', $id);
        $result = $this->db->update('assign_task', $editData);
        return $result;
    }

    /**
     * Function : getTaskInfo method is used for get task details .
     *
     * @param int $id
     *
     */
    public function getTaskInfo($id)
    {

        $data = array();
        $this->db->where("id", $id);
        $this->db->select("task_name,target,extract(month FROM assign_task.start_date) as month,extract(year FROM assign_task.end_date) as year,comments");
        $query = $this->db->get('assign_task');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data['period'] = date('F', mktime(0, 0, 0, $row['month'])) . ' ' . $row['year'];
                $data[] = $row;
            }
        }
        $data['month'] = "";
        $data['year'] = "";
        $query->free_result();
        return $data;
    }

    public function changestatus($id)
    {
        $query = "UPDATE innovation_pool SET stage = '6' WHERE id = $id";
        $result = $this->db->query($query);
        return true;
    }

    /**
     * Function : delete method is used for delete records.
     *
     * @param int $id
     *
     */
    public function delete($id)
    {

        $this->db->where('id', $id);
        $this->db->delete('assign_task');
        return true;
    }
}
