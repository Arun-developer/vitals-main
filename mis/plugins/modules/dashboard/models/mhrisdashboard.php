<?php
class Mhrisdashboard extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->ais = $this->load->database('ais', true);

    }

    public function getCeo()
    {
        $query = $this->ais->get('approval_setting');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['ceo'];

    }

    public function gettotalEmployeeLeave($year = null)
    {
        $data = array();
        $this->hris->select("count(hs_hr_leave.leave_length_days)as totalleave,hs_hr_leave.*,hs_hr_employee.emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as emp_name", false);

        $this->hris->join('hs_hr_employee', 'hs_hr_employee.emp_number = hs_hr_leave.employee_id', 'left');
        $this->hris->where('hs_hr_employee.emp_type', 'employee');
        $this->hris->where('hs_hr_leave.leave_status', '3');
        if ($year != null) {
            $this->hris->where('(extract(YEAR from hs_hr_leave.leave_date))=', $year);
        }
        $this->hris->group_by('hs_hr_employee.emp_number');
        $this->hris->order_by("count(hs_hr_leave.leave_length_days)", "desc");
        $this->hris->limit(5);

        $query = $this->hris->get('hs_hr_leave');

        foreach ($query->result_array() as $row) {

            $data[] = $row;
        }

        return $data;
    }

    public function getemployeeLeaveType($year = null, $empid = null)
    {
        $data = array();
        $this->hris->select("hs_hr_leavetype.leave_type_name,COUNT(`hs_hr_leave`.leave_type_id) AS totalleave,hs_hr_leave.*,hs_hr_employee.emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as emp_name", false);

        $this->hris->join('hs_hr_leavetype', 'hs_hr_leavetype.leave_type_id = hs_hr_leave.leave_type_id	', 'left');
        $this->hris->join('hs_hr_employee', 'hs_hr_employee.emp_number = hs_hr_leave.employee_id', 'left');
        $this->hris->where('hs_hr_leave.leave_status', '3');
        if ($year != null) {
            $this->hris->where('(extract(YEAR from hs_hr_leave.leave_date))=', $year);
        }
        $this->hris->where('hs_hr_employee.emp_number', $empid);
        $this->hris->group_by('hs_hr_leave.leave_type_id');
        $query = $this->hris->get('hs_hr_leave');

        foreach ($query->result_array() as $row) {

            $data[] = $row;
        }

        return $data;
    }

    public function getareareport($year)
    {
        $data = array();
        $query = "SELECT te.*, sum(hour)as total,aw.area_name
						FROM (`hs_hr_time_new` te)
						JOIN `area_work` aw ON `aw`.`id` =`te`.`areaid`
						where extract(YEAR from te.date) = '" . $year . "'
						GROUP BY `te`.`areaid`
						order by sum(hour) desc ";

        $result = $this->hris->query($query);

        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getareaEmployeeHour($year, $areaid)
    {

        $data = array();
        $query = "SELECT T.*,sum(T.hour) as total,AW.area_name,HE.emp_firstname FROM hs_hr_time_new as T
			JOIN hs_hr_employee as HE ON(T.employee_id = HE.employee_id)
			JOIN area_work as AW ON(AW.id = T.areaid)
			WHERE EXTRACT(YEAR FROM T.date) = '" . $year . "'
			AND T.areaid= '" . $areaid . "' GROUP BY T.employee_id
			ORDER BY sum(T.hour) DESC ";

        $result = $this->hris->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getprojectreport($year)
    {
        $data = array();
        $query = "SELECT te.*, sum(hour)as total,pw.work_name
						FROM (`hs_hr_time_new` te)
						JOIN `project_work` pw ON `pw`.`id` =`te`.`project_id`
						where extract(YEAR from te.date) = '" . $year . "'
						GROUP BY `te`.`project_id`
						order by sum(hour) desc ";

        $result = $this->hris->query($query);

        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getprojectEmployeeHour($year, $projectid)
    {

        $data = array();
        $query = "SELECT T.*,sum(T.hour) as total,HE.emp_firstname,PW.work_name FROM hs_hr_time_new as T
			JOIN hs_hr_employee as HE ON(T.employee_id = HE.employee_id)
			JOIN project_work as PW ON(PW.id = T.project_id)
			WHERE EXTRACT(YEAR FROM T.date) = '" . $year . "'
			AND T.project_id= '" . $projectid . "' GROUP BY T.employee_id
			ORDER BY sum(T.hour) DESC ";

        $result = $this->hris->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

}
