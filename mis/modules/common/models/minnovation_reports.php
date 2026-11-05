<?php

class Minnovation_reports extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Msource');
        $this->load->model('master/Mmaster_settings');
        $this->load->model('login/Muser');
    }

    public function getNotificationDetails($value)
    {
        $this->db->select("id,name_of_entrepreneur,stage,status,created_by");
        if ($value != '0') {
            $this->db->where('created_by', $value);
        }
        $limit = '0,5';
        $query = $this->db->get('innovation_pool', $limit);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getlatestUpdates($username)
    {

        $data = array();
        $buildqry = "SELECT * FROM comments_screening where `to` like '%" . $username . "%' ORDER BY DATE DESC LIMIT 1";
        $query = $this->db->query($buildqry);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getfundallocated()
    {
        $data = array();
        $this->db->select('sum(amount) as total');
        $query = $this->db->get('sf_activities');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;

    }
    public function getLimitReportRecords($options = array())
    {

        $data = array();

        $options['orderby'] = 'IP.id';
        $options['ordertype'] = 'desc';
        $whereQuery = $this->_searchReport($options);
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        $this->db->select("IP.*,DATEDIFF(entry_date,IP.created_date) as new_entry,DATEDIFF(lead_date,entry_date) as entry_lead,DATEDIFF(shortlist_date,lead_date) as screening_date");
        $this->db->select("SM.source_name,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");
        $this->db->select("(select master_name from master_settings where id=IP.incubation_cycle) as incubation_cycle_title");
        $this->db->select("(select master_name from master_settings where id=IP.reasons) as reasons_title");
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = IP.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = IP.modified_by) as modified_emp", false);
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        if ($query->num_rows() > 0) {
            $this->load->model('scouting/Mincharge');
            foreach ($query->result_array() as $row) {
                $asArray = array();
                $associate = $this->Mincharge->getAssociate(array('innovation' => $row['id'], 'active' => 'Active'));
                foreach ($associate as $as):
                    $asArray[] = $as['emp_name'];
                endforeach;
                $row['no_of_incharge'] = count($asArray);
                $row['associate_emp_name'] = implode(', ', $asArray);
                $row['source_name'] = ($row['source_name'] != '') ? $row['source_name'] : 'Direct Application';
                $row['reference'] = ($row['reference'] == 'Others') ? $row['reference'] . '-' . $row['other_reference'] : $row['reference'];
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function _searchReport($options = array())
    {
        $searchArray = array();

        $where = null;

        if (is_array($options['associate'])) {
            $searchArray[] = "IP.id IN ('" . php72_implode("','", $options['associate']) . "')";
        }

        if (!empty($options['source_type'])) {
            $searchArray[] = "SM.source_type = '" . $options['source_type'] . "'";
        }

        if (!empty($options['source'])) {
            $searchArray[] = "IP.source = '" . $options['source'] . "'";
        }

        if (!empty($options['instance'])) {
            $searchArray[] = "IP.instance = '" . $options['instance'] . "'";
        }

        if (@$options['source_type'] == "0") {
            $searchArray[] = "IP.source = '" . $options['source_type'] . "'";
        }

        if (!empty($options['created_by'])) {
            $searchArray[] = "IP.created_by = '" . $options['created_by'] . "'";
        }

        if (!empty($options['created_date'])) {
            $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . "'";
        }

        if (!empty($options['created_date_to'])) {
            $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . "'";
        }

        if (isset($options['stage']) && @$options['stage'] != '') {
            $searchArray[] = "IP.stage = '" . $options['stage'] . "'";
        }

        if (isset($options['grading_status']) && @$options['grading_status'] != '') {
            $searchArray[] = "IP.grading_status = '" . $options['grading_status'] . "'";
        }

        if (isset($options['status']) && @$options['status'] != '') {
            if ($options['status'] == '!3') {
                $searchArray[] = "IP.status != '3'";
            } else {
                $searchArray[] = "IP.status = '" . $options['status'] . "'";
            }

        }

        if (!empty($options['name_of_enterprise'])) {
            $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
        }

        if (!empty($options['person_incharge'])) {

            $this->load->model('scouting/Mincharge');

            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));

            $innovation = (php72_count($innovation)) ? $innovation : array();

            $searchArray[] = "IP.id IN ('" . php72_implode("','", $innovation) . "')";
        }

        if (!empty($options['reference'])) {
            $searchArray[] = "IP.reference like '%" . str_replace("'", "\'", $options['reference']) . "%'";
        }

        if (!empty($options['incubation_cycle'])) {
            $searchArray[] = "IP.incubation_cycle = '" . $options['incubation_cycle'] . "'";
        }

        if (!empty($options['reasons'])) {
            $searchArray[] = "IP.reasons = '" . $options['reasons'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function getSourceWiseReport($year, $employee = '', $type = '')
    {

        $source = array();

        if ($employee == '' && $type == '') {

            $sourceTypeList = $this->Mmaster_settings->getMasterSetting('Source Type');
            foreach ($sourceTypeList as $st):

                $s = array();

                $s['id'] = $this->Msource->getSourceByType($st['id']);
                $s['master_name'] = $st['master_name'];
                $s['source_name'] = $st['master_name'];
                $source[] = $s;

            endforeach;
        } else {

            $source = $this->Msource->getSourceList();
        }

        $totalInnovation = $this->getCountOnly();
        $records = array();

        if ($employee == '') {

            $direct = array('id' => '0', 'name' => 'Direct Applications', 'source_name' => 'Direct Applications', 'master_name' => 'Direct Applications');
            array_push($source, $direct);
        }

        foreach ($source as $row2):
            //show($row2);
            $data = array();

            $new = $this->getCountOnly(array('stage' => '0', 'source' => $row2['id'], 'employee' => $employee, 'year' => $year));
            $entry = $this->getCountOnly(array('stage' => '1', 'source' => $row2['id'], 'employee' => $employee, 'year' => $year));
            $lead = $this->getCountOnly(array('stage' => '2', 'source' => $row2['id'], 'employee' => $employee, 'year' => $year));
            $shortlist = $this->getCountOnly(array('stage' => '3', 'source' => $row2['id'], 'employee' => $employee, 'year' => $year));
            $screening = $this->getCountOnly(array('stage' => '4', 'source' => $row2['id'], 'employee' => $employee, 'year' => $year));
            $incubation = $this->getCountOnly(array('stage' => '5', 'source' => $row2['id'], 'employee' => $employee, 'year' => $year));
            $total_new = $data['total_new'] = $new + $entry + $lead;
            $total_entry = $data['total_entry'] = $entry + $lead;
            $total_lead = $data['total_lead'] = $lead;
            $screening = $data['total_screening'] = $screening;
            $incubation = $data['total_incubation'] = $incubation;

            @$data['convertion_new_entry'] = round(($total_entry / $total_new) * 100, 2);
            @$data['convertion_entry_lead'] = round(($total_lead / $total_entry) * 100, 2);
            @$data['innovation_percent'] = round(($total_new / $totalInnovation) * 100, 2);
            @$data['screening_percentage'] = round(($screening / $totalInnovation) * 100, 2);
            @$data['incubation_percentage'] = round(($incubation / $totalInnovation) * 100, 2);

            $data['name'] = $row2['master_name'];
            $data['source_name'] = $row2['source_name'];
            $data['source_type'] = $row2['master_name'];

            $records[] = $data;

        endforeach;
        //show($records);
        return $records;
    }

    public function getCountOnly($options = array())
    {

        $data = array();

        $this->db->select('count(*) as total');

        if (!empty($options['source']) || @$options['source'] == '0') {

            $this->db->where_in('source', $options['source']);
        } elseif (isset($options['source'])) {

            $options['source'] = (php72_count($options['source'])) ? $options['source'] : '4564065348593407589345734534587346584365783457';
            $this->db->where('source', $options['source']);
        }

        if (!empty($options['stage']) || @$options['stage'] == '0') {
            $this->db->where('stage', $options['stage']);
        }

        if (!empty($options['employee']) || @$options['employee'] == '0') {
            $this->db->where('created_by', $options['employee']);
        }

        if (!empty($options['year']) || @$options['year'] != '') {
            $this->db->where('EXTRACT(YEAR FROM created_date) = ', $options['year']);
        }

        $query = $this->db->get('innovation_pool');
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }
        }

        $query->free_result();

        return $data['0']['total'];
    }

    public function getEmployeeWiseReport()
    {

        $data = array();
        $this->db->select('created_by');
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = IP.created_by) as created_emp", false);

        $this->db->where('created_by !=', '');
        $this->db->where('created_by !=', '0');
        $this->db->where('source !=', '0');
        $this->db->group_by('created_by');

        $query = $this->db->get('innovation_pool IP');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['report'] = $this->getSourceWiseReport($row['created_by']);
                $data[] = $row;
            }
        }
        $query->free_result();

        return $data;
    }

    //resource Completed

    public function getInchargeWiseReport($type = '', $employee = '', $year)
    {

        $where = array();
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = AA.associate_employee and emp_type != '1') as emp_name", false);
        $this->db->select("AA.associate_employee,IP.stage,IP.status,IP.id,count(AA.associate_employee) as total");
        $this->db->where('AA.status', '1');
        $this->db->where('EXTRACT(YEAR FROM IP.created_date) = ', $year);
        $this->db->join('innovation_pool IP', 'IP.id = AA.innovation', 'left');

        if ($type == 'incubation') {
            $where[] = "(IP.stage = '5' or IP.status = '1')";
        }
        if ($type == 'screening') {
            $where[] = "(IP.stage = '4' or IP.status = '1')";
        }
        if ($type == 'completed') {
            $where[] = "(IP.stage = '2' or IP.status = '3')";
        }

        if ($type == 'pending') {
            $where[] = "(IP.stage = '1' and IP.status != '3')";
        }

        if ($type == 'lead') {
            $where[] = "(IP.stage = '2' and IP.status != '3')";
        }

        if ($type == 'entry') {
            $where[] = "(IP.stage = '1' and IP.status != '3')";
        }

        $whereQuery = '';
        if (count($where)) {
            $whereQuery = implode(' and ', $where);
        }

        if ($type == 'total') {
            $this->db->group_by('AA.associate_employee');
        }

        if ($employee != '') {
            $this->db->where('AA.associate_employee', $employee);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('assign_associate AA', $whereQuery);
        } else {
            $query = $this->db->get('assign_associate AA');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getInchargeCompleted($year)
    {

        $result = array();

        $innovationReport = $this->getInchargeWiseReport('total', '', $year);
        //show($innovationReport);
        foreach ($innovationReport as $ir):

            $val = array();

            $completed = $this->getInchargeWiseReport('completed', $ir['associate_employee'], $year);
            $pending = $this->getInchargeWiseReport('pending', $ir['associate_employee'], $year);
            $lead = $this->getInchargeWiseReport('lead', $ir['associate_employee'], $year);
            $entry = $this->getInchargeWiseReport('entry', $ir['associate_employee'], $year);
            
            $val['emp_name'] = @$ir['emp_name'];
            $val['assigned'] = $ir['total'];
            $val['completed'] = @$completed['0']['total'];
            $val['pending'] = @$pending['0']['total'];
            $val['lead'] = @$lead['0']['total'];
            $val['entry'] = @$entry['0']['total'];
            $result[] = $val;

        endforeach;

        return $result;
    }

    //Dashboard Information

    public function getInnovationCount($stage = '0', $pending = '', $year = null)
    {

        $data = array();

        $this->db->select("count(*) as total");

        $this->db->where('stage', $stage);

        if ($stage == '0') {
            $this->db->where('status', '0');
        }

        if ($stage != '0' && $pending != '') {

            $this->db->where('grading_status', '1');
        }
        if ($year != null) {
            $this->db->where('EXTRACT(YEAR FROM created_date) = ', $year);
        }

        $query = $this->db->get('innovation_pool');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }
        }

        $query->free_result();

        return $data['0']['total'];
    }

    public function getInnovationCountPeriod($value = null, $status = null, $year = '2012')
    {

        $start = date("Y-m-d", mktime(0, 0, 0, 1, 1, $year));
        $end = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year));
        $data = array();
        $this->db->select("count(*) as total");

        if ($value != null) {
            if ($status == null) {
                $this->db->where('stage', $value);
                $this->db->where('status', '1');
            } else {
                $this->db->where('status', $value);
            }

        }

        $this->db->where('created_date >=', $start);
        $this->db->where('created_date <=', $end);
        $this->db->where('EXTRACT(YEAR FROM created_date) = ', $year);
        $query = $this->db->get('innovation_pool');
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data['0']['total'];
    }

    public function getConvertionCount($type = 'entry_date')
    {

        $data = array();

        $this->db->select("count(*) as total");

        $this->db->where($type . ' >=', date("Y-m-") . '1');

        $this->db->where($type . ' <=', date("Y-m-") . '31');

        $query = $this->db->get('innovation_pool');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }
        }

        $query->free_result();

        return $data['0']['total'];
    }

    public function getConvertionAvgTime($stage = null, $year)
    {

        $data = array();

        if ($stage == '1') {$this->db->select("avg(DATEDIFF(entry_date,created_date)) as avgtime,max(DATEDIFF(entry_date,created_date)) as maxtime,min(DATEDIFF(entry_date,created_date)) as mintime", false);
        $this->db->where('stage', $stage);

    } else if ($stage == '2') {
        $this->db->select("avg(DATEDIFF(lead_date,entry_date)) as avgtime,max(DATEDIFF(lead_date,entry_date)) as maxtime,min(DATEDIFF(lead_date,entry_date)) as mintime", false);
        $this->db->where('stage', $stage);

    } else if ($stage == '4') {
        $this->db->select("avg(DATEDIFF(shortlist_date,lead_date )) as avgtime,max(DATEDIFF(shortlist_date ,lead_date )) as maxtime,min(DATEDIFF(shortlist_date ,lead_date )) as mintime", false);
        $this->db->where('stage', $stage);

    } else {
        $this->db->select("avg(DATEDIFF(created_date,lead_date)) as avgtime,max(DATEDIFF(created_date,lead_date)) as maxtime,min(DATEDIFF(created_date,lead_date))as mintime", false);
    }
    $this->db->where('EXTRACT(YEAR FROM created_date) = ', $year);
    $query = $this->db->get('innovation_pool');

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data[] = $row;
        }
    }
    $query->free_result();
    return $data['0'];
}

public function getListInnovationByStatus($status)
{

    $data = array();

    $this->db->where('status', $status);

    $query = $this->db->get('innovation_pool');

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $asArray = array();

            $this->load->model('scouting/Mincharge');

            $associate = $this->Mincharge->getAssociate(array('innovation' => $row['id'], 'active' => 'Active'));

            foreach ($associate as $as):

                $asArray[] = $as['emp_name'];

            endforeach;

            $row['associate_emp_name'] = implode(', ', $asArray);

            $data[] = $row;
        }
    }

    $query->free_result();

    return $data;
}

public function getInnovationUserCount($options = array(), $stage = '')
{

    $data = array();

    $this->db->select("count(*) as total");

    $this->db->where('stage', $stage);

    $this->db->where_in('id', $options['associate']);

    $query = $this->db->get('innovation_pool');

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data[] = $row;
        }
    }

    $query->free_result();

    return $data['0']['total'];
}

    # SCOUTING REPORTS #

public function getScreeningReport_ByMONTH($options = array())
{

    $data = array();
    if (!empty($options['orderby']) && !empty($options['ordertype'])) {
        $this->db->order_by($options['orderby'], $options['ordertype']);
    }

    if (!empty($options['created_date'])) {
        $this->db->where('shortlist_date >= ', date2mysql($options['created_date']));
    }
    if (!empty($options['created_date_to'])) {

        $this->db->where('shortlist_date <= ', date2mysql($options['created_date_to']));
    }

    if (empty($options['created_date']) && empty($options['created_date_to'])) {

        $this->db->where('YEAR(shortlist_date) = ', date("Y"));
    }
    $this->db->select("(shortlist_date) as date,stage,count(stage) as userstage,status");
    $this->db->group_by('stage,YEAR(shortlist_date)');
    $query = $this->db->get('innovation_pool');
    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data[] = $row;
        }
    }
    $query->free_result();
    return $data;

}

    # MONTHLY REPORT #
public function getMonthlyReport($options = array())
{

    $data = array();
    if (!empty($options['orderby']) && !empty($options['ordertype'])) {
        $this->db->order_by($options['orderby'], $options['ordertype']);
    }

    if (!empty($options['created_date'])) {
        $this->db->where('created_date >= ', date2mysql($options['created_date']));
    }
    if (!empty($options['created_date_to'])) {

        $this->db->where('created_date <= ', date2mysql($options['created_date_to']));
    }

    if (empty($options['created_date']) && empty($options['created_date_to'])) {

        $this->db->where('YEAR(created_date) = ', date("Y"));
    }
    $this->db->select("COUNT(id) as total,(created_date) as date,status");
    $this->db->group_by('MONTH(created_date),YEAR(created_date)');
    $query = $this->db->get('innovation_pool');
    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data[] = $row;
        }
    }

    $query->free_result();
    return $data;
}

    # WEEKLY REPORT #

public function getWeeklyReport($options = array())
{

    $data = array();

    if (!empty($options['orderby']) && !empty($options['ordertype'])) {
        $this->db->order_by($options['orderby'], $options['ordertype']);
    } else {
        $this->db->order_by('created_date', 'asc');
    }

    if (!empty($options['created_date'])) {

        $this->db->where('created_date >=', date2mysql($options['created_date']));
    }

    if (!empty($options['created_date_to'])) {

        $this->db->where('created_date <=', date2mysql($options['created_date_to']));
    }

    if (empty($options['created_date']) && empty($options['created_date_to'])) {

        $this->db->where('MONTH(created_date) =', date("m"));
    }

    $this->db->select("COUNT(id) as total,created_date,WEEK(created_date,0) as year_week,WEEK(created_date, 0) -

        WEEK(DATE_SUB(created_date, INTERVAL DAYOFMONTH(created_date) - 1 DAY), 0) + 1 as month_week", false);

    $this->db->group_by('WEEK(created_date),MONTH(created_date),YEAR(created_date)');

    $query = $this->db->get('innovation_pool');

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data[] = $row;
        }
    }

    $query->free_result();

    return $data;
}

    # RESOURCE REPORT #

public function getResourceData($type = '', $employee = '', $options = array())
{

    $where = array();
    $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = AA.associate_employee) as emp_name", false);

    $this->db->select("AA.associate_employee,count(AA.associate_employee) as total");
    $this->db->where('AA.status', '1');
    $this->db->join('innovation_pool IP', 'IP.id = AA.innovation', 'left');
    if (!empty($options['created_date'])) {

        $this->db->where('IP.created_date >= ', date2mysql($options['created_date']));
    }

    if (!empty($options['created_date_to'])) {

        $this->db->where('IP.created_date <= ', date2mysql($options['created_date_to']));
    }

    if ($type == 'completed') {

        $where[] = "(IP.stage >= '2' or IP.status = '3')";
    }

    if ($type == 'lead') {

        $where[] = "(IP.stage >= '2')";
    }

    if ($type == 'entry') {

        $where[] = "(IP.stage >= '1')";
    }

    if ($type == 'screening') {

        $where[] = "(IP.stage >= '4')";
    }
    if ($type == 'incubation') {

        $where[] = "(IP.stage >= '5')";
    }
    if ($type == 'entry_pending') {

        $where[] = "(IP.stage = '1' and IP.status != '3')";
    }

    $whereQuery = '';

    if (count($where)) {
        $whereQuery = implode(' and ', $where);
    }

    if ($type == 'total') {
        $this->db->group_by('AA.associate_employee');
    }

    if ($employee != '') {
        $this->db->where('AA.associate_employee', $employee);
    }

    if (!empty($whereQuery)) {
        $query = $this->db->get_where('assign_associate AA', $whereQuery);
    } else {
        $query = $this->db->get('assign_associate AA');
    }

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data[] = $row;
        }
    }
    $query->free_result();

    return $data;
}

public function getResourceWiseReport($options = array())
{

    $result = array();
    $resourceData = $this->getResourceData('total');

    foreach ($resourceData as $ir):

        $val = array();
        $completed = $this->getResourceData('completed', $ir['associate_employee'], $options);
        $lead = $this->getResourceData('lead', $ir['associate_employee'], $options);
        $entry = $this->getResourceData('entry', $ir['associate_employee'], $options);
        $entry_pending = $this->getResourceData('entry_pending', $ir['associate_employee'], $options);
        $screening_stage = $this->getResourceData('screening', $ir['associate_employee'], $options);
        $incubation_stage = $this->getResourceData('incubation', $ir['associate_employee'], $options);

        $val['emp_name'] = $ir['emp_name'];
        $val['assigned'] = $ir['total'];
        $val['completed'] = @$completed['0']['total'];
        $val['lead'] = @$lead['0']['total'];
        $val['entry'] = @$entry['0']['total'];
        $val['screening_stage'] = @$screening_stage['0']['total'];
        $val['incubation_stage'] = @$incubation_stage['0']['total'];
        $val['entry_pending'] = @$entry_pending['0']['total'];

        $result[] = $val;

    endforeach;

    return $result;
}

    # SCREENING REPORTS #

public function getScreeningReport()
{

    $data = array();

    $this->db->select("(select value from screening_master SF1 where SF1.id='" . $question . "') as value");

    $this->db->select("(select count(id) from screening_master SF1 where SF1.pid='" . $question . "' and SF1.parent_value != '') as sub_field");

    $this->db->select('answer,count(answer) as total');

    $this->db->where('field', $question);

    $this->db->group_by('answer');
    $query = $this->db->get("screening");

    if ($query->num_rows() > 0) {

        $f = array();

        foreach ($query->result_array() as $row) {

            $allValue = unserialize($row['value']);

            $f[$row['answer']] = $row['total'];
        }

        foreach ($allValue as $key => $val) {

            if (!isset($f[$val])) {

                $f[$val] = '0';
            }
        }

        $data = $f;
    }

    $query->free_result();

    return $data;
}

    #REPORT BY PROGRAMSERVICE#

public function _getProgramServiceReport($id)
{
    $data = array();

    $this->db->select("count(id) as total");

    $this->db->where('services like', '%' . $id . ',%');

    $query = $this->db->get('innovation_services');

    if ($query->num_rows() > 0) {

        foreach ($query->result_array() as $row) {

            $data = $row;
        }
    }

    $query->free_result();
    return $data['total'];
}

public function due_diligence($options = null)
{
    $data = array();
    $query = "select * from innovation_pool where 1=1";
    if ($options['gender'] != "") {
        $query .= " AND gender = '" . $options['gender'] . "'";
    }
    if ($options['status'] != "") {
        $query .= " and status = '" . $options['status'] . "'";
    }
    if ($options['stage'] != "") {
        $query .= " AND stage = '" . $options['stage'] . "'";

    }
    if ($options['year'] != "") {
        $query .= " AND extract(year from created_date) = '" . $options['year'] . "'";
    }
    if ($options['types'] != "") {
        $query = $query;
    }
    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data;
}
public function incubationreport($options = null)
{
    $data = array();
    $sql = "SELECT IP.*,IS.services as service FROM innovation_pool as IP";
    $result = $this->db->query($sql);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data;
}
public function getservicereport($options = null)
{

    $data = array();
    if ($options['incubation'] == 'services') {
        $query = "select IP.*,IP.summary_of_business as description,sum(SF.amount) as amount FROM innovation_pool as IP JOIN sf_activities as SF ON(SF.innovation = IP.id) WHERE 1=1";
        if ($options['year'] != "") {
            $query .= " AND extract(year from created_date) = '" . $options['year'] . "'";
        }
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
    }
    if (isset($options['status'])) {
        $query = "select IP.*,IP.summary_of_business,sum(SF.amount) as amount FROM innovation_pool as IP JOIN sf_activities as SF ON(SF.innovation = IP.id) where IP.status = '" . $options['status'] . "'";
        if ($options['year'] != "") {
            $query .= " AND extract(year from created_date) = '" . $options['year'] . "'";
        }
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
    }
    if ($options['incubation'] == 'repayment') {
        $query = "select RP.repayment_amount as amount,RP.from_date,RP.to_date,RP.description,IP.name_of_entrepreneur,IP.stage,IP.name_of_enterprise,IP.created_date  FROM repayment_details as RP JOIN innovation_pool as IP ON(RP.innovation = IP.id)";
        if ($options['year'] != "") {
            $query .= " AND extract(year from created_date) = '" . $options['year'] . "'";
        }
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
    }

    return $data;
}

public function getInnovationIdentifiedByReport($options = array())
{

    $data = array();

    $this->db->select('created_by');
    $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = IP.created_by) as created_emp", false);

    $this->db->where('created_by !=', '');
    $this->db->where('created_by !=', '0');
    $this->db->where('source !=', '0');
    $this->db->group_by('created_by');

    $query = $this->db->get('innovation_pool IP');
    if ($query->num_rows() > 0 && empty($_POST['created_by'])) {
        foreach ($query->result_array() as $row) {
            $row['report'] = $this->getLimitReportRecords($options);
            $data[] = $row;
        }
    }
    if (!empty($_POST['created_by'])) {
        $options['created_by'] = $_POST['created_by'];
        $row['created_by'] = $options['created_by'];
        $emp_name_arr = $this->Muser->getUsersList($options['created_by']);
        $row['created_emp'] = $emp_name_arr[0]['emp_name'];
        $row['report'] = $this->getLimitReportRecords($options);
        $data[] = $row;

    }

    $query->free_result();

    return $data;
}

public function getCXO()
{

    $this->load->model('login/Muser');
    $this->db->select('CIO');
    $query = $this->db->get('user_setup');
    foreach ($query->result_array() as $row) {
        $data[] = $this->getUsersList($row['CIO']);
    }
    return $data;

}

}
