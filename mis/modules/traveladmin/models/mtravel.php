<?php

class Mtravel extends CI_Model {
    /* function Mtravel() {
      parent::Model();
      $this->load->model('Mlogin');
      $this->load->model('Mcommon');
  } */

  public function __construct() {
    parent::__construct();
    $this->ais = $this->load->database('ais', TRUE);
    $this->hris = $this->load->database('hris', TRUE);
}

function getPersonsCount($id) {
    $data = array();
    $this->ais->select('count(*) as total');
    $this->ais->where('travel_request_id', $id);
    $query = $this->ais->get('persons_details');
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }
    $query->free_result();
    return $data['0']['total'];
}

function reportingUser($type, $field, $empNumber = NULL) {
    $subUserArray = array();
    if ($empNumber == NULL) {
        $employees = $this->getReportingUser($this->session->userdata('user'), $type);
    } else {
        $employees = $this->getReportingUser($empNumber, $type);
    }

    foreach ($employees as $row) {
        $subUserArray[] = $row['id'];
    }
    if ($field == 'userId')
        return $subUserArray;
    else
        return $employees;
}

public function getROlist($emp_id) {
    $this->db->select('t1.report_subordinate as emp_id,t2.emp_name');
    $this->db->join('hr_user_profile t2', 't2.id = t1.report_subordinate', 'left');
    $this->db->where(array('t1.report_supervisor' => $emp_id, 't1.report_method' => '1', 't1.status' => '1', 't2.status' => '1'));
    $this->db->order_by('t2.emp_name', 'asc');
    $query = $this->db->get('hr_user_reporting t1');
    $rows = $query->result_array();
    return $rows;
}

function getReportingUser($employeeId, $option) {
    $data = array();
    if ($option == 'subUser') {
        $lable1 = 'report_subordinate';
        $lable2 = 'report_supervisor';
    } elseif ($option == 'supUser') {
        $lable1 = 'report_supervisor';
        $lable2 = 'report_subordinate';
    }
    $this->db->where($lable1, $employeeId);
    $this->db->select($lable2 . ",CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id,emp_name,official_email,personal_email", false);
    $this->db->join("hr_user_profile", 'hr_user_profile.id=hr_user_reporting.' . $lable2);
    $query = $this->db->get('hr_user_reporting');

    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }
    $query->free_result();
    return $data;
}

function getTravelRequestDetails($travel_request_id) {
    $data = array();
    $this->ais->where('travel_request_id', $travel_request_id);
    $query = $this->ais->get('travel_booking');
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }

    $query->free_result();
    return $data;
}

function getPersonsList($travel_request_id) {
    $data = array();
    $this->ais->where('travel_request_id', $travel_request_id);
    $query = $this->ais->get('persons_details');
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }

    $query->free_result();
    return $data;
}

    function mailContant($requestId, $touser = NULL) { #echo'<pre>';print_r(print_r($this->session->all_userdata()));
    $requestListInfo = $this->getTravelRequestDetails($requestId);
    $personsList = $this->getPersonsList($requestId);
    $journeyList = $this->getJourneyList($requestId);
    $employeeDetails = $this->Mlogin->getEmployeeFromUserId($requestListInfo['0']['employee_id']);
        #echo'<pre>';print_r($journeyList);die;
    $empEmail = ($employeeDetails['0']['official_email'] != '') ? $employeeDetails['0']['official_email'] : $employeeDetails['0']['official_email'];

        //reporting authority
    $reportingAuth = $this->getROlist($employeeDetails['0']['id']);
    $roArr = $roname_Arr = array();
    $ro_name = '';
    foreach ($reportingAuth as $val) {
        $roArr[$val['emp_id']] = $val['official_email'];
        $roname_Arr[$val['emp_id']] = $val['emp_name'];
    }
    $ro_name = $roname_Arr[$requestListInfo['0']['ro_id']];
    if (php72_count($reportingAuth))
        # $reportAuthEmail = ($reportingAuth['0']['official_email'] != '') ? $reportingAuth['0']['official_email'] : $reportingAuth['0']['official_email'];
        $reportAuthEmail = $roArr[$requestListInfo[0]['ro_id']];
    else
        $reportAuthEmail = '';
    $adminEmail = $this->session->userdata('adminEmail');

    switch ($touser) {
        case('report'):
        $toName = @$ro_name;
        break;
        case('admin'):
        $toName = 'Admin';
        break;
        case('employee'):
        $toName = $employeeDetails['0']['emp_name'];
        break;
    }

    $toEmail = array($adminEmail, $reportAuthEmail, $empEmail);
    $e_tickets = array();
    $tickets = '<table cellspacing="1"  cellpadding="2" width="700" border="0"  >
    <tr>
    <td bgcolor="#666666"><strong>Bill No</strong></td>
    <td bgcolor="#666666"><strong>Bill Date</strong></td>
    <td bgcolor="#666666"><strong>Amount</strong></td>
    <td bgcolor="#666666"><strong>Vendor</strong></td>
    <td bgcolor="#666666"><strong>e-Ticket</strong></td>
    </tr>';
    foreach ($journeyList as $rows_ticket) {
        $tickets .='<tr bgcolor="#F0F0F0">
        <td>' . $rows_ticket["bill_no"] . '</td>
        <td>' . mysql2ddmmyyyy($rows_ticket["bill_date"]) . '</td>
        <td>' . $rows_ticket["amount"] . '</td>
        <td>' . $rows_ticket["vendor_name"] . '</td>
        <td> ' . $rows_ticket["e_ticket"] . '</td>
        </tr>';

        $e_tickets[] = $rows_ticket["e_ticket"];
    }
    $tickets .='</table>';
    $journey = '<table cellspacing="1" width="100%"  cellpadding="2" border="0"  >
    <tr>
    <td bgcolor="#666666"><strong>Date of Travel</strong></td>
    <td bgcolor="#666666"><strong>Destination From:</strong></td>
    <td bgcolor="#666666"><strong>To: </strong></td>
    <td bgcolor="#666666"><strong>Time </strong></td>
    <td bgcolor="#666666"><strong>Train/Flight/Cab/Bus</strong></td>
    <td bgcolor="#666666"><strong>Any preferred Train/Flight</strong></td>
    <td bgcolor="#666666"><strong>Date of Accomodation</strong></td>
    <td bgcolor="#666666"><strong>Location Preference</strong></td>
    </tr>';

    foreach ($journeyList as $row_jur) {
        $date_of_accomodation = '';
        if ($row_jur['date_of_accomodation'] != '' && $row_jur['date_of_accomodation'] != '1970-01-01 00:00:00') {
            $date_of_accomodation = date('d/m/Y', strtotime($row_jur['date_of_accomodation']));
        }
        $journey .= '<tr bgcolor="#F0F0F0">
        <td>' . mysql2ddmmyyyy($row_jur["date_of_travel"]) . '</td>
        <td>' . $row_jur["destination_from"] . '</td>
        <td>' . $row_jur["destination_to"] . '</td>
        <td>' . $row_jur["travel_time"] . '</td>
        <td>' . $this->showMaster($row_jur["travel_mode"]) . '</td>
        <td>' . $row_jur["preferred_train_flight"] . '</td>
        <td>' . $date_of_accomodation . '</td>
        <td>' . $row_jur["location_preference"] . '</td>
        </tr>';
    }
    $journey .='</table>';
    $personsData = '<table width="100%" cellspacing="5" cellpadding="10">';
    foreach ($personsList as $row1) {
        $sex_gender = '';
        if ($row1['sex'] == '1' && $row1['sex'] != '') {
            $sex_gender = 'Male';
        } else {
            $sex_gender = 'Female';
        }
        $personsData .='<tr><td><strong>Name</strong> : ';
        $personsData .=$this->getEmployeeName($row1['name']);
        $personsData .='</td><td><strong>Age</strong> : ';
        $personsData .=$row1['age'];
        $personsData .='</td><td><strong>Sex</strong> : ';
        $personsData .=$sex_gender;
        $personsData .='</td></tr>';
    }

    $personsData .='</table>';
    $org = array('#employee#', '#travel_request_id#', '#date_of_requisition#', '#compliance_with_hr_manual#', '#prior_booking#', '#personsList#', '#purpose#', '#budget_head#', '#donor#', '#cost_centre#', '#programme#', '#innovation#', '#cancel_request_date#', '#cancel_reasons#', '#cancel_reasons_RO#', '#cancel_reasons_admin#', '#cancel_date#', '#journey_type#', '#journey#', '#tickets#', '#From#', '#To#', '#RO_date#', '#admin_date#');
    $replace = array($this->getEmployeeName($requestListInfo['0']['employee_id']),
        $requestListInfo['0']['travel_request_id'],
        mysql2ddmmyyyy($requestListInfo['0']['date_of_requisition']),
        $requestListInfo['0']['compliance_with_hr_manual'],
        $requestListInfo['0']['prior_booking'] . "," . $requestListInfo['0']['if_not_prior_booking'],
        $personsData,
        $requestListInfo['0']['purpose'],
        ($requestListInfo['0']['budget_head'] == 0) ? $requestListInfo['0']['other_budget_head'] : $this->showMaster($requestListInfo['0']['budget_head']),
        ($requestListInfo['0']['donor'] == 0) ? $requestListInfo['0']['other_donor'] : $this->showMaster($requestListInfo['0']['donor']),
        ($requestListInfo['0']['cost_centre'] == 0) ? $requestListInfo['0']['other_cost_centre'] : $this->showMaster($requestListInfo['0']['cost_centre']),
        $requestListInfo['0']['programme'],
        $requestListInfo['0']['innovation'],
        mysql2ddmmyyyy($requestListInfo['0']['cancel_request_date']),
        $requestListInfo['0']['cancel_reason'],
        $requestListInfo['0']['cancel_reason_RO'],
        $requestListInfo['0']['cancel_reason_admin'],
        mysql2ddmmyyyy($requestListInfo['0']['cancel_date']),
        $requestListInfo['0']['journey_type'],
        $journey,
        $tickets,
        $this->session->userdata('username'),
        $toName,
        mysql2ddmmyyyy($requestListInfo['0']['RO_date']),
        mysql2ddmmyyyy($requestListInfo['0']['confirmed_date']));

    $data = array('org' => $org,
        'replace' => $replace,
        'employeeEmail' => $empEmail,
        'ticket' => $e_tickets,
        'adminEmail' => $adminEmail,
        'reportAuthEmail' => $reportAuthEmail,
        'toEmail' => $toEmail);
    return $data;
}

function showMaster($master_id) {
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
    return @$data['0']['master_name'];
}

function getJourneyList($travel_booking_id, $journey_id = NULL) {
    $data = array();
    if ($journey_id == NULL)
        $this->ais->where('travel_booking_id', $travel_booking_id);
    else
        $this->ais->where('travel_journey.journey_id', $journey_id);

    $this->ais->select('master_vendor.vendor_name,travel_journey.*,travel_tickets.ticket_id,travel_tickets.bill_no,travel_tickets.amount,travel_tickets.bill_date,travel_tickets.e_ticket,travel_tickets.credit_note_no,travel_tickets.credit_amount');
    $this->ais->join('master_vendor', 'travel_journey.vendor=master_vendor.vendor_id', 'left');
    $this->ais->join('travel_tickets', 'travel_journey.journey_id=travel_tickets.journey_id', 'left');
    $query = $this->ais->get('travel_journey');
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }

    $query->free_result();
    return $data;
}

function getEmployeeName($userId) {
    $result = $this->getUserInfo($userId);
    return $result['0']['user_name'];
}

function getLimitTravelReport($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL, $export = NULL) {
        #echo'<pre>';print_r($where);die;
    $data = array();
    $whereArray = array();
    $q = "select ";
    $q .= "PD.name,";
    $q .= "TB.travel_request_id,TB.donor,TB.budget_head,TB.line_item,TB.other_line_item,TB.cost_centre,TB.other_donor,TB.other_budget_head,TB.other_cost_centre,TB.purpose,";
    $q .= "TJ.date_of_travel,TJ.destination_from,TJ.destination_to,TJ.travel_mode,";
    $q .= "TT.bill_no,IF(TJ.ticket='confirmed',TT.amount,(TT.amount-TT.credit_amount)) as amount,";
    $q .= "MV.vendor_name";
    $q .= " from travel_booking TB";
    $q .= " left join persons_details PD on PD.travel_request_id = TB.travel_request_id";
    $q .= " left join travel_journey TJ on TJ.travel_booking_id = TB.travel_request_id";
    $q .= " left join master_vendor MV on MV.vendor_id = TJ.vendor";
    $q .= " left join travel_tickets TT on TT.journey_id = TJ.journey_id";

    $offset = (!is_numeric($offset)) ? '0' : $offset;
    if ($admin == NULL)
        $whereArray[] = "TB.employee_id = '" . $this->session->userdata('user') . "'";

    if ($where != NULL)
        $whereArray[] = $where;

    $whereCond = implode(' and ', $whereArray);
    if ($whereCond != '')
        $q .= " where " . $whereCond;

    if ($orderby != NULL && $ordertype != NULL)
        $q .= " order by " . $orderby . " " . $ordertype;

    if ($export == NULL)
        $q .= " LIMIT " . $offset . "," . $num;
    $query = $this->ais->query($q);
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $persons_count = $this->getPersonsCount($row["travel_request_id"]);
            $row['amount'] = round($row["amount"] / $persons_count, 2);
            $data[] = $row;
        }
    }
    $query->free_result();
    return $data;
}

function getLimitTravelReport_count($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL, $export = NULL) {

    $data = array();
    $whereArray = array();
    $q = "select ";
    $q .= "PD.name,";
    $q .= "TB.travel_request_id,TB.donor,TB.budget_head,TB.line_item,TB.other_line_item,TB.cost_centre,TB.other_donor,TB.other_budget_head,TB.other_cost_centre,TB.purpose,";
    $q .= "TJ.date_of_travel,TJ.destination_from,TJ.destination_to,TJ.travel_mode,";
    $q .= "TT.bill_no,IF(TJ.ticket='confirmed',TT.amount,(TT.amount-TT.credit_amount)) as amount,";
    $q .= "MV.vendor_name";
    $q .= " from travel_booking TB";
    $q .= " left join persons_details PD on PD.travel_request_id = TB.travel_request_id";
    $q .= " left join travel_journey TJ on TJ.travel_booking_id = TB.travel_request_id";
    $q .= " left join master_vendor MV on MV.vendor_id = TJ.vendor";
    $q .= " left join travel_tickets TT on TT.journey_id = TJ.journey_id";

    $offset = (!is_numeric($offset)) ? '0' : $offset;
    if ($admin == NULL)
        $whereArray[] = "TB.employee_id = '" . $this->session->userdata('user') . "'";

    if ($where != NULL)
        $whereArray[] = $where;

    $whereCond = implode(' and ', $whereArray);
    if ($whereCond != '')
        $q .= " where " . $whereCond;

    if ($orderby != NULL && $ordertype != NULL)
        $q .= " order by " . $orderby . " " . $ordertype;

    $query = $this->ais->query($q);
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $persons_count = $this->getPersonsCount($row["travel_request_id"]);
            $row['amount'] = round($row["amount"] / $persons_count, 2);
            $data[] = $row;
        }
    }
    $query->free_result();
    return $data;
}

function getUserInfo($userId) {

        #$data = $dataArr = array();
    $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,emp_gender,official_mobile", false);
    $this->db->where('hr_user_login.emp_id', $userId);
    $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
    $this->db->group_by('hr_user_login.user_name');
    $query = $this->db->get('hr_user_login');
    if ($query->num_rows() > 0) {
        $dataArr = json_decode(json_encode($query->result()), true);
    }
    return $dataArr;
}

function getUserInfo_details($userId) {

        #$data = $dataArr = array();
    $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,emp_gender,official_mobile,official_email,personal_email", false);
    $this->db->where('hr_user_login.emp_id', $userId);
    $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
    $this->db->group_by('hr_user_login.user_name');
    $query = $this->db->get('hr_user_login');
    if ($query->num_rows() > 0) {
        $dataArr = json_decode(json_encode($query->result()), true);
    }
    return $dataArr;
}

    function requestTravelBooking() {  #echo'asd';die;
    $data = array('employee_id' => $this->session->userdata('user'),
        'date_of_requisition' => date('Y-m-d'),
        'if_not_prior_booking' => $this->input->post('prior_booking_reason'),
        'compliance_with_hr_manual' => $this->input->post('compliance_with_hr_manual'),
        'prior_booking' => $this->input->post('prior_booking'),
        'purpose' => $this->input->post('purpose'),
        'budget_head' => $this->input->post('budget_head'),
        'donor' => $this->input->post('donor'),
        'other_budget_head' => $this->input->post('other_budget_head'),
        'other_donor' => $this->input->post('other_donor'),
        'line_item' => $this->input->post('line_item'),
        'other_line_item' => $this->input->post('other_line_item'),
        'cost_centre' => $this->input->post('cost_centre'),
        'other_cost_centre' => $this->input->post('other_cost_centre'),
        'journey_type' => $this->input->post('journey_type'),
        'programme' => $this->input->post('programme'),
        'approval_id' => $this->input->post('approval_id'));

    $this->ais->insert('travel_booking', $data);
    $travel_booking_id = $this->ais->insert_id();
    $this->insertPersonsDetails($travel_booking_id);
    $this->insertMultipleJourney($travel_booking_id);
    return $travel_booking_id;
}

function insertPersonsDetails($travel_booking_id) {
    $name = $this->input->post('name');
    $age = $this->input->post('age');
    $sex = $this->input->post('sex');
    $mobile = $this->input->post('mobile');
    $j = 0;
    foreach ($name as $key => $value) {
        if ($value != "") {
            $data = array('travel_request_id' => $travel_booking_id,
                'name' => $value,
                'age' => $age[$j],
                'sex' => $sex[$j],
                'mobile' => $mobile[$j]);
            $this->ais->insert('persons_details', $data);
        }
        $j++;
    }
    return $this->ais->insert_id();
}

function insertMultipleJourney($travel_booking_id) {
    if ($this->input->post('journey_type') == 'round') {
        foreach ($_POST['date_of_travel'] as $key => $value) {
            if ($_POST['date_of_travel'][$key] != '') {
                $data = array(
                    'travel_booking_id' => $travel_booking_id,
                    'date_of_travel' => date('Y-m-d', strtotime($_POST['date_of_travel'][$key])),
                    'destination_from' => $_POST['destination_from'][$key],
                    'destination_to' => $_POST['destination_to'][$key],
                    'travel_time' => $_POST['travel_time_start'][$key] . "-" . $_POST['travel_time_end'][$key],
                    'travel_mode' => $_POST['travel_mode'][$key],
                    'preferred_train_flight' => $_POST['preferred_train_flight'][$key],
                    'date_of_accomodation' => date('Y-m-d', strtotime($_POST['date_of_accomodation'][$key])),
                    'date_of_accomodation_to' => date('Y-m-d', strtotime($_POST['date_of_accomodation_to'][$key])),
                    'location_preference' => $_POST['location_preference'][$key],
                    'date_of_travel_return' => date('Y-m-d', strtotime($_POST['date_of_return'][$key])),
                    'travel_time_return' => $_POST['travel_time_start_return'][$key] . "-" . $_POST['travel_time_end_return'][$key],
                    'travel_mode_return' => $_POST['travel_mode_return'][$key],
                    'preferred_train_flight_return' => $_POST['preferred_train_flight_return'][$key]
                );

                $this->ais->insert('travel_journey', $data);
                    /* $data = array(
                      'travel_booking_id' => $travel_booking_id,
                      'date_of_travel' => date('Y-m-d',strtotime($_POST['date_of_return'][$key])),
                      'destination_from' => $_POST['destination_to'][$key],
                      'destination_to' => $_POST['destination_from'][$key],
                      'travel_time' => $_POST['travel_time_start_return'][$key] . "-" . $_POST['travel_time_end_return'][$key],
                      'travel_mode' => $_POST['travel_mode_return'][$key],
                      'preferred_train_flight' => $_POST['preferred_train_flight_return'][$key],
                      'date_of_accomodation' => '',
                      'date_of_accomodation_to' => '',
                      'location_preference' => '');

                      $this->ais->insert('travel_journey', $data); */
                  }
              }
          } else {
            foreach ($_POST['date_of_travel'] as $key => $value) {
                if ($_POST['date_of_travel'][$key] != '') {
                    $data = array(
                        'travel_booking_id' => $travel_booking_id,
                        'date_of_travel' => date('Y-m-d', strtotime($_POST['date_of_travel'][$key])),
                        'destination_from' => $_POST['destination_from'][$key],
                        'destination_to' => $_POST['destination_to'][$key],
                        'travel_time' => $_POST['travel_time_start'][$key] . "-" . $_POST['travel_time_end'][$key],
                        'travel_mode' => $_POST['travel_mode'][$key],
                        'preferred_train_flight' => $_POST['preferred_train_flight'][$key],
                        'date_of_accomodation' => date('Y-m-d', strtotime($_POST['date_of_accomodation'][$key])),
                        'date_of_accomodation_to' => date('Y-m-d', strtotime($_POST['date_of_accomodation_to'][$key])),
                        'location_preference' => $_POST['location_preference'][$key]);

                    $this->ais->insert('travel_journey', $data);
                }
            }
        }
    }

    function requestTravelBookingUpdate($requestId) {
        $data = array(
            'date_of_requisition' => date('Y-m-d'),
            'compliance_with_hr_manual' => $this->input->post('compliance_with_hr_manual'),
            'prior_booking' => $this->input->post('prior_booking'),
            'if_not_prior_booking' => $this->input->post('prior_booking_reason'),
            'purpose' => $this->input->post('purpose'),
            'budget_head' => $this->input->post('budget_head'),
            'donor' => $this->input->post('donor'),
            'other_budget_head' => $this->input->post('other_budget_head'),
            'other_donor' => $this->input->post('other_donor'),
            'line_item' => $this->input->post('line_item'),
            'other_line_item' => $this->input->post('other_line_item'),
            'cost_centre' => $this->input->post('cost_centre'),
            'other_cost_centre' => $this->input->post('other_cost_centre'),
            'programme' => $this->input->post('programme'));

        $this->ais->where('travel_request_id', $requestId);
        $query = $this->ais->update('travel_booking', $data);
        $this->delete_recored('persons_details', 'travel_request_id', $requestId);
        $this->insertPersonsDetails($requestId);
        $this->updateMultipleJourney($requestId);
        return $this->ais->affected_rows();
    }

    function delete_recored($TableName = NULL, $Label = NULL, $Id = NULL) {
        $data = array();
        $this->ais->where($Label, $Id);
        $data = $this->ais->delete($TableName);
        return $data;
    }

    function updateMultipleJourney($travel_booking_id) {
        foreach ($_POST['date_of_travel'] as $key => $value) {
            $data = array(
                'travel_booking_id' => $travel_booking_id,
                'date_of_travel' => date('Y-m-d', strtotime($_POST['date_of_travel'][$key])),
                'destination_from' => $_POST['destination_from'][$key],
                'destination_to' => $_POST['destination_to'][$key],
                'travel_time' => $_POST['travel_time_start'][$key] . "-" . $_POST['travel_time_end'][$key],
                'travel_mode' => $_POST['travel_mode'][$key],
                'preferred_train_flight' => $_POST['preferred_train_flight'][$key],
                'date_of_accomodation' => date('Y-m-d', strtotime($_POST['date_of_accomodation'][$key])),
                'date_of_accomodation_to' => date('Y-m-d', strtotime($_POST['date_of_accomodation_to'][$key])),
                'location_preference' => $_POST['location_preference'][$key],
                'date_of_travel_return' => date('Y-m-d', strtotime($_POST['date_of_return'][$key])),
                'travel_time_return' => $_POST['travel_time_start_return'][$key] . "-" . $_POST['travel_time_end_return'][$key],
                'travel_mode_return' => $_POST['travel_mode_return'][$key],
                'preferred_train_flight_return' => $_POST['preferred_train_flight_return'][$key]
            );

            if (@$_POST['journey_id'][$key] == '') {
                $this->ais->insert('travel_journey', $data);
            } else {
                $this->ais->where('journey_id', $_POST['journey_id'][$key]);
                $this->ais->update('travel_journey', $data);
            }
        }
        return true;
    }

    function tot_amt_in($an_id, $an_don, $an_bh, $an_li, $an_details) {
        if ($an_details == NULL || $an_details == '') {
            $an_details = 0;
        }
        $details = array(
            'approval_id' => $an_id,
            'donor' => $an_don,
            'budget_head' => $an_bh,
            'line_item' => $an_li,
            'additionalinfo' => $an_details
        );
        $this->ais->select_sum('amount_toapprove');
        $this->ais->where($details);
        $query = $this->ais->get('internal_note');
        return $query->result_array();
    }

    function insertapprovaldraft() {

        $fNameArray = array();
        $file_name = $_FILES['meet_doc']['name'];
        $file_tmp_name = $_FILES['meet_doc']['tmp_name'];
        $arr_key = '';

        foreach ($file_name as $key => $value):
            $arr_key = php72_array_keys($value)[$key];

            if ($value[$arr_key] != '') {
                $fName = rand() . "_" . str_replace(" ", "_", $value[$arr_key]);
                @copy($file_tmp_name[$key][$arr_key], "uploads/support_docs/" . $fName);
                $fNameArray[] = $fName;
            }
        endforeach;

        $work_plan = 'yes';
        $amount = 0;
        foreach ($this->input->post('amt_required') as $key => $value):
            $amount += $value;
        endforeach;
        if ($this->session->userdata('currency') == 'INR' && $amount > 50000) {
            $above = 'yes';
        } else if ($this->session->userdata('currency') != 'INR' && $amount > 1500) {
            $above = 'yes';
        } else {
            $above = 'no';
        }

//        $get_date = date('d');
//        if ($get_date != 30)
//            $financial_date = date("2019-03-31");
//        else
//            $financial_date = date("Y:m:d");
        #$supporting_documents = implode(',', $this->input->post('supporting_documents'));
        $supporting_documents = php72_implode(',', $this->input->post('meet_desc'));

        $data = array(
            'approval_no' => $this->approvalNumber(),
            'date_of_request' => date("Y:m:d"),
            'date_of_seeking_approval' => date('Y-m-d', strtotime($this->input->post('date_of_seeking_approval'))),
//      	    'date_of_request' => "2020-03-31",
//	            'date_of_seeking_approval' => "2020-03-31",
            'from_employee' => $this->session->userdata('user_id'),
//	            'date_payment_required' => ddmmyyyy2mysql($this->input->post('date_payment_required')),
            'to_RO' => $this->input->post('to_RO'),
            'purpose' => $this->input->post('purpose'),
            'programme' => $this->input->post('programme'),
            'UCID' => $this->input->post('UCID'),
            'supporting_documents' => $supporting_documents,
            'above_50000' => $above,
            'status' => 'draft',
            'comments_RO' => '',
            'comments_PH' => '',
            'partner_id' => $this->session->userdata('partner_id'),
            'attachment' => serialize($fNameArray)
        );
        $this->ais->insert('approval_note', $data);
        $id = $this->ais->insert_id();
        $this->insertDonors($id);

        return true;
    }

    function approvalNumber() {
        $data = array();
        $text = "APN/";
        $position = "front";
        $this->ais->order_by('approval_id', 'desc');
        $this->ais->limit('1', '0');
        $query = $this->ais->get('approval_note');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();

        if (count($data))
            $id = str_pad((int) $data['0']['approval_id'] + 1, 4, "0", STR_PAD_LEFT);
        else
            $id = '0001';

        return $approvalNo = $text . $id;
    }

    function insertDonors($id) {
        $donor = $this->input->post('donor');
        $grant_list = $this->input->post('grant_list');
        $other_donor = $this->input->post('other_donor');
        $budget_head = $this->input->post('budget_head');
        $other_budget_head = $this->input->post('other_budget_head');
        $line_item = $this->input->post('line_item');
        $other_line_item = $this->input->post('other_line_item');
        $cost_centre = $this->input->post('cost_centre');
        $other_cost_centre = $this->input->post('other_cost_centre');
        $additional_info = $this->input->post('additional_info');
        $amt_available = $this->input->post('amt_available');
        $amt_required = $this->input->post('amt_required');
        foreach ($donor as $key => $value):
            $data = array('approval_id' => $id,
                'budget_head' => $budget_head[$key],
                'grant_id' => $grant_list[$key],
                'donor' => $donor[$key],
                'line_item' => $line_item[$key],
                'other_budget_head' => $other_budget_head[$key],
                'other_donor' => $other_donor[$key],
                'other_line_item' => $other_line_item[$key],
                'cost_centre' => $cost_centre[$key],
                'other_cost_centre' => $other_cost_centre[$key],
                'additionalinfo' => $additional_info[$key],
                'amt_available' => $amt_available[$key],
                'amt_required' => $amt_required[$key]);
            $this->ais->insert('approval_note_donors', $data);
        endforeach;
    }

    function getMasterProgramme($id = NULL) {
        $data = array();
        $this->ais->where('status', '1');
        if ($id != NULL)
            $this->ais->where('programme_id', $id);

        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $this->ais->order_by('programme', 'asc');
        $query = $this->ais->get('master_programme');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function cancelBooking($requestId) {
        $data = array();
        $this->ais->where('travel_request_id', $requestId);
        $this->ais->set('cancel_request', 'pending');
        $this->ais->set('cancel_reason', $this->input->post('reasons'));
        $this->ais->set('cancel_request_date', date("Y-m-d"));
        $query = $this->ais->update('travel_booking');
        return $this->ais->affected_rows();
    }

    function reportingAuthorityAction($requestId, $status) {
        $data = array();
        $this->ais->where('travel_request_id', $requestId);
        $this->ais->set('reporting_approval', $status);
        if ($status == 'cancelled') {
            $this->ais->set('cancel_reason_RO', $this->input->post('reasons'));
            $this->ais->set('status', $status);
            $this->ais->set('cancel_date', date("Y-m-d"));
        }
        $this->ais->set('RO_date', date("Y-m-d"));
        $query = $this->ais->update('travel_booking');
        return $this->ais->affected_rows();
    }

    function deferedAction($requestId, $status) {
        $data = array();
        $query = "UPDATE travel_booking SET status = '" . $status . "', reporting_approval = '" . $status . "' WHERE travel_request_id = '" . $requestId . "'";
        $result = $this->ais->query($query);
        return true;
    }

    function insertdeferedcomments($id, $comments, $user) {
        $data = array('travel_id' => $id,
            'question' => $comments,
            'from_employee' => $user,
            'question_date' => NOW());
        $this->ais->insert('tdefered_comments', $data);
        return true;
    }

    function getarchiveTravelrequest($from, $to, $num = NULL, $offset = NULL, $where = NULL, $admin = NULL) {
        $data = array();
        $this->ais->limit($num, $offset);
        if ($admin == NULL)
            $this->ais->where('employee_id', $this->session->userdata('user'));

        $this->ais->select('master_vendor.vendor_name,travel_booking.*,travel_journey.*,travel_tickets.bill_no,travel_tickets.amount');
        $this->ais->join('travel_journey', 'travel_booking.travel_request_id=travel_journey.travel_booking_id', 'left');
        $this->ais->join('master_vendor', 'travel_journey.vendor=master_vendor.vendor_id', 'left');
        $this->ais->join('travel_tickets', 'travel_journey.journey_id=travel_tickets.journey_id', 'left');
        $dateRange = "date_of_requisition BETWEEN '$from%' AND '$to%'";
        $this->ais->where($dateRange, NULL, FALSE);
        if ($where != NULL)
            $query = $this->ais->get_where('travel_booking', $where);
        else
            $query = $this->ais->get('travel_booking');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getfinanciallist() {
        $data = array();
        $query = "select * from financial_year where status = '0'";
        $result = $this->ais->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function getUserNameInfo($userid) {
        $data = array();
        $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,admin_email,personal_email,official_email", false);
        $this->db->where('hr_user_profile.id', $userid);
        $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
        $query = $this->db->get('hr_user_login');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function adminAction($requestId, $status) {
        $data = array();
        $this->ais->where('travel_request_id', $requestId);
        $this->ais->set('status', $status);
        if ($status == 'cancelled') {
            $this->ais->set('cancel_reason_admin', $this->input->post('reasons'));
            $this->ais->set('status', $status);
            $this->ais->set('cancel_date', date("Y-m-d"));
            $this->ais->set('cancel_request', 'confirmed');
        }

        $this->ais->set('confirmed_date', date("Y-m-d"));
        $query = $this->ais->update('travel_booking');
        return $this->ais->affected_rows();
    }

    function sentToVendor($requestId, $value) {
        $data = array();
        $this->ais->where('travel_request_id', $requestId);
        $this->ais->set('send_tovendor', 'sent');
        $query = $this->ais->update('travel_booking');
        $this->ais->where('journey_id', $value);
        $this->ais->set('vendor', $this->input->post('vendor'));
        $this->ais->set('send_tovendor', 'sent');
        $query = $this->ais->update('travel_journey');
        return $this->ais->affected_rows();
    }

    function uploadTickets($requestId) {
        $ext = explode('.', $_FILES['e_ticket']['name']);
        $ticket_name = $requestId . "_" . rand() . "." . $ext[count($ext) - 1];

        @copy($_FILES['e_ticket']['tmp_name'], 'uploads/tickets/' . $ticket_name);
        $data = array('travel_request_id' => $this->input->post('travel_request_id'),
            'journey_id' => $this->input->post('journey_id'),
            'bill_no' => $this->input->post('bill_no'),
            'amount' => str_replace(',', '', $this->input->post('amount')),
            'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
            'vendor' => $this->input->post('vendor'),
            'e_ticket' => $ticket_name);
        $this->ais->insert('travel_tickets', $data);

        //request

        $this->ais->where('travel_request_id', $this->input->post('travel_request_id'));
        $this->ais->set('ticket_status', 'confirmed');
        $this->ais->update('travel_booking');

        //journey

        $this->ais->where('journey_id', $this->input->post('journey_id'));
        $this->ais->set('ticket', 'confirmed');
        $this->ais->update('travel_journey');
        return $this->ais->insert_id();
    }

    function reuploadTickets($requestId) {
        $ext = explode('.', $_FILES['e_ticket']['name']);
        $ticket_name = $requestId . "_" . rand() . "." . $ext[count($ext) - 1];
        @copy($_FILES['e_ticket']['tmp_name'], 'uploads/tickets/' . $ticket_name);
        $data = array(
            'bill_no' => $this->input->post('bill_no'),
            'amount' => str_replace(',', '', $this->input->post('amount')),
            'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
            'vendor' => $this->input->post('vendor'),
            'e_ticket' => $ticket_name);

        $this->ais->where('ticket_id', $this->input->post('ticket_id'));
        $this->ais->update('travel_tickets', $data);
    }

    function cancelTickets($id) {
        $data = array('credit_amount' => str_replace(',', '', $this->input->post('credit_amount')),
            'credit_note_no' => $this->input->post('credit_note_no'));
        $this->ais->where('ticket_id', $this->input->post('ticket_id'));
        $this->ais->update('travel_tickets', $data);
        //request
        $this->ais->where('travel_request_id', $this->input->post('travel_request_id'));
        $this->ais->set('ticket_status', 'cancelled');
        $this->ais->update('travel_booking');
        //journey
        $this->ais->where('journey_id', $this->input->post('journey_id'));
        $this->ais->set('ticket', 'cancelled');
        $this->ais->update('travel_journey');
        return true;
    }
	
	 function getLineItemList($program = '', $donor = '', $budget = '') {
        $financialArray = $this->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);
        $this->ais->distinct();
        $this->ais->select('MS.master_name, BA.line_itemid');
        $this->ais->join('master_settings MS', 'MS.master_id=BA.line_itemid');
        $this->ais->where(array('BA.programme_id' => $program, 'BA.donor_id' => $donor,  'BA.budget_id' => $budget));
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
        $this->ais->order_by('MS.master_name', 'asc');
        $query = $this->ais->get('balance_amount BA');
        $rows = $query->result_array();
        return $rows;
    }
	
	function insertTravelRequest($table='',$insertData=array()) {
		$this->ais->insert($table, $insertData);
		return $this->ais->insert_id();
	}
	
	function insertBatchTravelRequest($table='',$insertData=array()) {
		$this->ais->insert_batch($table, $insertData);
		return true;
	}
	
	
	function getTravelRequestCount($user_id='',$date_from='',$date_to='') {
		$data = array();
		#$q = "SELECT * FROM travel_request TR WHERE admin_id='" . $this->session->userdata('user_id') . "'";
		$q = "SELECT * FROM travel_request TR WHERE 1=1";
		if ($date_from !='') {
			 $date_from_mysql = date('Y-m-d', strtotime(str_replace('/', '-', $date_from)));
			$q .= " AND TR.created_at >= '" . $date_from_mysql . "'";
		}
		if ($date_to !='') {
			 $date_to_mysql = date('Y-m-d', strtotime(str_replace('/', '-', $date_to)));
			$q .= " AND TR.created_at <= '" . $date_to_mysql . "'";
		}
		
		$query = $this->ais->query($q);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}
		
	
	function getTravelRequestData($user_id='',$date_from='',$date_to='',$num='',$offset='') {
		$data = array();
		#$q = "SELECT * FROM travel_request TR WHERE admin_id='" . $this->session->userdata('user_id') . "'";
		$q = "SELECT * FROM travel_request TR WHERE 1=1";
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		
		if ($date_from !='') {
			 $date_from_mysql = date('Y-m-d', strtotime(str_replace('/', '-', $date_from)));
			$q .= " AND TR.created_at >= '" . $date_from_mysql . "'";
		}
		if ($date_to !='') {
			 $date_to_mysql = date('Y-m-d', strtotime(str_replace('/', '-', $date_to)));
			$q .= " AND TR.created_at <= '" . $date_to_mysql . "'";
		}
	
		$q .= " ORDER BY TR.created_at DESC";
		if (is_numeric($num)) {
			$q .= " LIMIT " . (int)$num . " OFFSET " . (int)$offset;
		}
		
		
		
		$query = $this->ais->query($q);
		#echo '<pre>';print_r($query->result_array());die;
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}
	
	function getTravelRequestDataCount() {
		$q = "SELECT COUNT(*) as request_count FROM travel_request";
		$q .= " where status=1";
		$query = $this->ais->query($q);

		if ($query) {
			$result = $query->row();
			$count = $result->request_count;
			$query->free_result();
			return $count;
		} else {
			return 0;
		}
	}
	
	
	function getAllEmployeeUserList() {
        $data = array();
        $this->db->distinct('hr_user_profile.emp_first_name');
        $this->db->select("hr_user_login.id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id", false);
        $this->db->where('hr_user_profile.partner_id', $this->session->userdata('partner_id'));
        $this->db->where_in('emp_type', array(3));
        $this->db->join('hr_user_login', 'hr_user_login.emp_id = hr_user_profile.id');
        $this->db->order_by('hr_user_profile.emp_first_name');
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
	
	
	
	
	function getPersonalData($travel_request_id='') {
		$this->ais->select('*');
        $this->ais->where('travel_request_id', $travel_request_id);
        $query = $this->ais->get('travel_request_personal_details');
        return $query;
    }
	
	function getTravelData($table='',$condition=array()) {
		
		$data = array();
		$this->ais->select('*');
		$this->ais->where($condition);
		$this->ais->order_by('id', 'DESC'); 
		$query = $this->ais->get($table);
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		return $data;
    }
	
	
	function updateBatchTravelRequest($table = '', $updateData = array(), $condition = array()) {
		if (empty($updateData) || empty($condition)) {
			return false;
		}
		$this->ais->where($condition);
		$this->ais->update($table, $updateData);
		return true;
	}
	
	
	function getUserMisData($table='',$condition=array()) {
		$data = array();
		$this->db->select('*');
		$this->db->where($condition);
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		return $data;
    }
	
	function getAdminUserDetails() { 
		$this->db->select("t1.id, t2.emp_name, t2.official_email");
        $this->db->join("hr_user_profile t2", "t2.id =  t1.emp_id", 'left');
        $this->db->where(array('t1.status' => 1,'t1.partner_id' => 1, 't1.user_role' => 2));
        $query = $this->db->get("hr_user_login t1");
        $rows = $query->result_array();
        return $rows;
		
    }
	
	function getBudgetList($program = '', $donor = '') {
		
        $financialArray = $this->findCurrentFinancialYear();
		$from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);
        $this->ais->distinct();
        $this->ais->select('MS.master_name, BA.budget_id');
        $this->ais->join('master_settings MS', 'MS.master_id=BA.budget_id');
        $this->ais->where(array('BA.programme_id' => $program, 'BA.donor_id' => $donor));
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  >= '$from'");
        $this->ais->where("EXTRACT(YEAR_MONTH FROM amount_date)  <= '$to'");
		$this->ais->like('MS.master_name', 'travel');
        $this->ais->order_by('MS.master_name', 'asc');
        $query = $this->ais->get('balance_amount BA');
        $rows = $query->result_array();
        return $rows;
    }
	
    function findCurrentFinancialYear() {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('status', '1');
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->ais->get('financial_year');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
	
	 public function getDonorList($id = '') {
		
        $data = array();
        $financial = $this->findCurrentFinancialYear();
        $from = converttodate($financial[0]['from']);
        $to = converttodate($financial[0]['to']);
		//$this->ais->select('MS.master_name, BA.donor_id,user.emp_name');
        $this->ais->select('MS.master_name, BA.donor_id');
        $this->ais->select("(select emp_name from  " . $this->db->database . ".hr_user_profile where id = MP.programme_head) as emp_name");
        $this->ais->join('master_settings MS', 'MS.master_id=BA.donor_id');
        $this->ais->join('master_programme MP', 'MP.programme_id=BA.programme_id');
		//$this->db->join('hr_user_profile user', 'user.id=MP.programme_head');
        if ($id != '')
            $this->ais->where('BA.programme_id', $id);
        $this->ais->where(array('BA.amount_date >=' => $from, 'BA.amount_date <=' => $to));
        $this->ais->order_by('MS.master_name', 'asc');
        $this->ais->group_by(array("BA.programme_id", "BA.donor_id"));
        $query = $this->ais->get('balance_amount BA');
        #echo debug_last_query();die;
        $rows = $query->result_array();
        return $rows;
    }
	
	function converttodate($data) {
        $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
            'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
        @list($Month, $Year) = array_pad(explode(' ', $data, 2), 2, null);
        if (isset($Month))
            @$Month = $month[$Month];
        $day = '01';
        if ($Month == '03')
            $day = '31';
        $date = $Year . '-' . $Month . '-' . $day;
        return $date;
    }
	
	
	
	public function getProgrammeList($id = '') {
        $data = array();
        $financial = $this->findCurrentFinancialYear();
        $from = converttodate($financial[0]['from']);
        $to = converttodate($financial[0]['to']);

        $this->ais->select('MP.*');
        $this->ais->join('balance_amount BA', 'BA.programme_id=MP.programme_id');
        if ($id != '')
            $this->ais->where('MP.programme_id', $id);
        $this->ais->where(array('MP.partner_id' => $this->session->userdata('partner_id'), 'BA.amount_date >=' => $from, 'BA.amount_date <=' => $to, 'MP.status' => '1'));
        $this->ais->order_by('MP.programme', 'asc');
        $this->ais->group_by('BA.programme_id');
        $query = $this->ais->get('master_programme MP');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
	
	
	
	

}

?>
