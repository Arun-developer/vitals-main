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
class Mprogress extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'innovation_pool';
    }

    public function getStartandEndDate($period_type, $progress_date)
    {
        $start_date = "00-00-0000";
        $end_date = "00-00-0000";
        $data = array();
        if ($period_type == '1') {
            $start_date = substr($progress_date, 0, 11);
            $end_date = substr($progress_date, 13);
        }
        /* Start & End date of the Month */
        if ($period_type == '2') {
            $start_date = date('01-m-Y', strtotime($progress_date));
            $end_date = date('t-m-Y', strtotime($progress_date));
        }
        /* Start & End Date of the Year  */
        if ($period_type == '4') {
            $start_date = date('01-m-Y', strtotime('January' . $progress_date));
            $end_date = date('t-m-Y', strtotime('December' . $progress_date));
        }
        $data = array(
            'start_date' => $start_date,
            'end_date' => $end_date,
        );
        return $data;

    }
    /* Insert Function is used for inserting and Updating Data in Database  */
    public function insert($form = array())
    {
        $criteria = $form['criteria'];
        $innovation = $form['innovation'];
        $progress_date = null;

        if (isset($form['datevalue'])) {
            $progress_date = $form['datevalue'];
        }

        $period_type = $form['listPeriod'];

        if (isset($form['txtQuater']) && isset($form['txtQuater_Year'])) {

            $progress_date = null;
            $period_Quarter = $form['txtQuater'];
            $period_quarterYear = $form['txtQuater_Year'];
        }

        $dateValues = $this->getStartandEndDate($period_type, $progress_date);
        unset($form['txtSubmit'], $form['progress_date'], $form['innovation'], $form['txtQuater'], $form['txtQuater_Year'], $form['criteria'], $form['datevalue'], $form['txtDate'], $form['listPeriod']);

        foreach ($form as $field => $answer):
            if ($field == 'services') {
                $this->insertInnovationServices($innovation, $answer);
            } else {
                $answer = is_array($answer) ? implode(',', $answer) : $answer;

                $data = array('criteria' => $criteria,
                    'innovation' => $innovation,
                    'field' => $field,
                    'answer' => $answer,
                    'date_type' => $period_type,
                );
                if ($dateValues['start_date'] != null) {
                    $data['start_date'] = date2mysql($dateValues['start_date']);
                }
                if ($dateValues['end_date'] != null) {
                    $data['end_date'] = date2mysql($dateValues['end_date']);
                }
                if (isset($period_Quarter) and isset($period_quarterYear)) {

                    if ($period_Quarter == '001') {
                        $start_date = date('01-m-Y', strtotime('January' . $period_quarterYear));
                        $end_date = date('t-m-Y', strtotime('March' . $period_quarterYear));
                    }
                    if ($period_Quarter == '002') {
                        $start_date = date('01-m-Y', strtotime('April' . $period_quarterYear));
                        $end_date = date('t-m-Y', strtotime('June' . $period_quarterYear));
                    }
                    if ($period_Quarter == '003') {
                        $start_date = date('01-m-Y', strtotime('July' . $period_quarterYear));
                        $end_date = date('t-m-Y', strtotime('September' . $period_quarterYear));
                    }
                    if ($period_Quarter == '004') {
                        $start_date = date('01-m-Y', strtotime('October' . $period_quarterYear));
                        $end_date = date('t-m-Y', strtotime('December' . $period_quarterYear));
                    }

                    $data['start_date'] = date2mysql($start_date);
                    $data['end_date'] = date2mysql($end_date);
                }

                // Checking for Duplicate values
                if ($this->checkDuplicate($innovation, $criteria, $field, $data)) {
                    $this->db->insert('progress', $data);
                } else {
                    $this->db->where('criteria', $criteria);
                    $this->db->where('innovation', $innovation);
                    $this->db->where('field', $field);

                    if ($dateValues['start_date'] != null) {
                        $data['start_date'] = date2mysql($dateValues['start_date']);
                        $this->db->where('start_date', $data['start_date']);
                    }
                    if ($dateValues['end_date'] != null) {
                        $data['end_date'] = date2mysql($dateValues['end_date']);
                        $this->db->where('end_date', $data['end_date']);
                    }
                    $this->db->update('progress', $data);
                }
            }
        endforeach;
    }

    //checkDuplicate Function is used to check duplicate values
    public function checkDuplicate($innovation, $criteria, $field = '', $data = null)
    {
        $this->db->select('id');
        $this->db->where('criteria', $criteria);
        $this->db->where('innovation', $innovation);
        if (isset($data['start_date']) && isset($data['end_date'])) {
            $this->db->where('start_date', $data['start_date']);
            $this->db->where('end_date', $data['end_date']);
        }

        if ($field != '') {
            $this->db->where('field', $field);
        }

        if (isset($data['date_type'])) {
            $this->db->where('date_type', $data['date_type']);
        }
        $result = $this->db->get('progress');
        if ($result->num_rows() > 0) {

            return false;
        } else {
            return true;
        }

    }
    public function getFiledsAnswerList($innovation = null, $criteria = null, $pid = '0', $subfield = null, $period = null, $calDate = null)
    {
        $data = array();

        $this->db->select("SM.*");
        $this->db->select("answer");
        $this->db->select("(select count(id) from progress_master SF where SF.pid=SM.id and SF.parent_value = '') as assess_field");
        $this->db->select("(select count(id) from progress_master SF1 where SF1.pid=SM.id and SF1.parent_value != '') as sub_field");

        $this->db->where('SM.status', '1');
        $this->db->where('SM.criteria', $criteria);

        if ($innovation != "") {
            $this->db->where('innovation', $innovation);
        }

        if ($calDate != "") {
            $this->db->where('progress_date', $calDate);
        }
        $this->db->join('progress', 'field = SM.id');

        // CHECK FOR THE PID, IF NULL CHANGE IT ZERO
        if ($pid == null) {
            $pid = 0;
        }

        $this->db->where('SM.pid', $pid);

        if ($period != null) {
            $this->db->where('period', $period);
        }

        if ($subfield == null and $pid != '0') {
            $this->db->where('parent_value', '');
        } elseif ($subfield != null) {
            $this->db->where('parent_value', $subfield);
        }

        $this->db->order_by('SM.order', 'asc');

        $query = $this->db->get('progress_master SM');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['value'] = unserialize($row['value']);
                $data[] = $row;
            }
        }

        debug_last_query();
        $query->free_result();

        return $data;
    }

    // Checking Data is already exist for given date or not
    public function ajxgetTabDetails($ajxValue = null, $criteria = null, $code = null, $dateValue = null)
    {
        $dateValues = $this->getStartandEndDate($ajxValue, $dateValue);
        $this->db->from('progress as P');

        if ($ajxValue != '4' && $ajxValue != '3') {
            $dateValues = $this->getStartandEndDate($ajxValue, $dateValue);
            if ($dateValues['start_date'] != null) {
                $this->db->where('P.start_date', date2mysql($dateValues['start_date']));
            }

            if ($dateValues['end_date'] != null) {
                $this->db->where('P.end_date', date2mysql($dateValues['end_date']));
            }

        }

        if ($ajxValue == '3') {
            if ($dateValue['txtQuater'] != null && $dateValue['txtQuater_Year'] != null) {
                $start_date = substr($dateValue, 0, 3);
                $yearData = substr($dateValue, 3);
                switch ($start_date) {
                    case "001":
                        $start_date = date('01-m-Y', strtotime('January' . $yearData));
                        $end_date = date('t-m-Y', strtotime('March' . $yearData));
                        $this->db->where('P.start_date', date2mysql($start_date));
                        $this->db->where('P.end_date', date2mysql($end_date));
                        break;
                    case "002":
                        $start_date = date('01-m-Y', strtotime('April' . $yearData));
                        $end_date = date('t-m-Y', strtotime('June' . $yearData));
                        $this->db->where('P.start_date', date2mysql($start_date));
                        $this->db->where('P.end_date', date2mysql($end_date));
                        break;
                    case "003":

                        $start_date = date('01-m-Y', strtotime('July' . $yearData));
                        $end_date = date('t-m-Y', strtotime('September' . $yearData));
                        $this->db->where('P.start_date', date2mysql($start_date));
                        $this->db->where('P.end_date', date2mysql($end_date));
                        break;
                    case "004":
                        $start_date = date('01-m-Y', strtotime('October' . $yearData));
                        $end_date = date('t-m-Y', strtotime('December' . $yearData));
                        $this->db->where('P.start_date', date2mysql($start_date));
                        $this->db->where('P.end_date', date2mysql($end_date));
                        break;
                }
            }

        }
        if ($ajxValue == '4') {

            $this->db->where('P.start_date', date2mysql($dateValues['start_date']));
            $this->db->where('P.end_date', date2mysql($dateValues['end_date']));
        }

        $this->db->where('P.criteria', $criteria);
        $this->db->order_by('P.field');

        $data = $this->db->get()->result_array();
        return $data;
    }

    public function ajaxForm($innovation, $criteria, $pid, $parent_value, $option = '', $periodValue)
    {
        if ($this->Mprogress->checkDuplicate($innovation, $criteria)) {
            $data['fieldsList'] = $this->Mprogress_master->getFiledsList($criteria, $pid, $parent_value);
        } else {
            $data['fieldsList'] = $this->Mprogress->getFiledsAnswerList($innovation, $criteria, $pid, $parent_value);
        }

        $data['innovation'] = $innovation;
        $data['criteria'] = $criteria;
        $data['periodValue'] = $periodValue;
        $data['option'] = $option;
        $this->load->vars($data);
        if (count($data['fieldsList'])) {
            if ($option == 'view') {
                $page = 'ajax_view';
            } else {
                echo $periodValue;
            }

            $page = 'ajax_form';
            echo $content = $this->load->view($page, true);
        }

    }

    #services
    public function insertInnovationServices($innovation, $services)
    {
        $data = array('innovation' => $innovation,
            'services' => implode(",", $services));
        if ($this->checkDuplicateService($innovation)) {
            $this->db->insert('innovation_services', $data);
        } else {
            $this->db->where('innovation', $innovation);
            $this->db->update('innovation_services', $data);
        }
    }
    public function checkDuplicateService($innovation)
    {
        $this->db->select('id');
        $this->db->where('innovation', $innovation);
        $result = $this->db->get('innovation_services');
        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }

    }
    public function getInnovationService($innovation)
    {
        $data = array();
        $this->db->select('services');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('innovation_services');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = explode(',', $row['services']);
            }
        }
        return $data;
    }
    public function getlabelsList()
    {
        $data = array();
        $this->db->select('label');
        $query = $this->db->get('progress_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }
    public function add_incubatee_report($options)
    {
        for ($i = 0; $i < count($options['document']); $i++) {
            $data = array('innovation' => $options['innovation'],
                'document_description' => $options['description'],
                'documents' => $options['document'][$i],
                'month' => $options['month'],
                'year' => $options['year']);
            $this->db->insert('incubatee_report', $data);
        }
        return true;
    }
    public function getincubatee_report($innovation, $month, $year)
    {
        $query = "select * from incubatee_report WHERE innovation = '" . $innovation . "' AND month = '" . $month . "' AND year = '" . $year . "'";
        $data = $this->db->query($query);
        return $data->result_array();

    }
    #agreement
}
