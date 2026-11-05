<?php 
/**
*
* Progress Model Page
*
* @ControllerName     mprogress.php
* @Author             Sanjoy Dey
* @Created Date       14-11-2011
* @Modified Date      24-11-2011
* @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011 
* @version            CodeIgniter_2.0.3
* @since              File available since Release 2.0.3
* @Warning            Any change in this file may cause abnormal behaviour of application.
*
*/
	class Mincubation_report extends CI_Model{
	
		function __construct()
		{
			parent::__construct();
		}
		function getlineitem($innovation)
		{
			$data = array();
			$this->db->select("lineitem");
			$this->db->where('innovation',$innovation);
			$query = $this->db->get('sf_monthly_report');
			if($query->num_rows()>0)
			{
				foreach($query->result_array() as $row){
					$data = explode(',',$row['lineitem']);
				}
			}
			
			return $data;
		}
		function getlineitemname($lid)
		{
			$this->db->select('lineitem');
			$this->db->where_in('id',$lid);
			$query = $this->db->get('sf_budget');
			$result = $query->row_array();
			return $result['lineitem'];
		}
		function getreport($innovation,$lineitem,$month = NULL,$year=NULL)
		{
			$data = array();
			if($month != NULL && $year != NULL)
			{
				$date = $month." ".$year;
				$where = "SF.month = '".$date."'";
			}
			else{
				$where = "SF.month LIKE '".date('F')." ".date('Y')."'";
			}
			$query = "select SF.*,SFA.progress_status,SFM.milestone,SFM.id as mid,SFG.goal from sf_monthly_report as SF JOIN sf_activities as SFA ON(SF.milestone = SFA.milestone) JOIN sf_milestone as SFM ON(SFA.milestone = SFM.id) JOIN sf_budget as SFB ON(SFB.id = SF.lineitem) JOIN sf_goal as SFG ON(SFM.goal = SFG.id) where SF.innovation = '".$innovation."' and ".$where;
			$result = $this->db->query($query);
			foreach($result->result_array() as $row)
			{
				$data[] = $row;
			}
			return $data;
			
		}
}	?>