<?php

/* -
 * Common Function
 * This section for Common funtion to use any where through the application
 *
 * Common Helper
 * @quadrupleindia.com
 * author - Prabakar
 */

function checkAuth() {
    $ci = &get_instance();
    $redirect_url = base_url() . 'index.php/login';
    if (!$ci->session->userdata('user_id')) {
        $ci->session->set_flashdata('warningMsg', 'Please Login to access this page!');
        redirect($redirect_url);
    }
}

function date2mysql($input) {
    $output = false;
    $d = array_filter(preg_split('#[-/:. ]#', $input));

    if (is_array($d) && count($d) == 3) {
        if (checkdate($d[1], $d[0], $d[2])) {
            $output = "$d[2]-$d[1]-$d[0]";
        }
    } else if (is_array($d) && count($d) == 2) {
        $output = "$d[1]-$d[0]";
    }
    return $output;
}

function mysql2date($input, $stringmonth = null) {
    $output = false;
    $d = array_filter(preg_split('#[-/:. ]#', $input));

    if (is_array($d) && (count($d) == 3 || count($d) == 6)) {
        if (checkdate($d[1], $d[2], $d[0])) {
            if ($stringmonth) {
                $stringmonth = date("M", mktime(0, 0, 0, ($d[1])));
                $output = "$d[2] $stringmonth $d[0]";
            } else {
                $output = "$d[2]/$d[1]/$d[0]";
            }
        }
    } else if (is_array($d) && count($d) == 2) {
        $output = "$d[1]/$d[0]";
    }
    return $output;
}

function mysqlError($e = '1451') {
    $er = array('1451' => 'Can not delete record, Its having child records');
    return $er[$e];
}

function sectorArray() {
    $sectorarr = array(1 => 'Agriculture', 2 => 'Water', 3 => 'Energy', 4 => 'Others');
    return $sectorarr;
}

function statusArr() {
    $statusarr = array(0 => 'Pending', 1 => 'Accepted', 2 => 'Rejected');
    return $statusarr;
}

function publishArr() {
    $pubarr = array(0 => 'publish', 1 => 'published');
    return $pubarr;
}

function requestStatus() {
    $reqstatus = array(0 => 'Closed', 1 => 'Open');
    return $reqstatus;
}

if (function_exists('lcfirst') === false) {

    function lcfirst($str) {
        $str[0] = strtolower($str[0]);
        return $str;
    }

}

function makecomma($input) {
    // This function is written by some anonymous person - I got it from Google
    if (strlen($input) <= 2) {
        return $input;
    }
    $length = substr($input, 0, strlen($input) - 2);
    $formatted_input = makecomma($length) . "," . substr($input, -2);
    return $formatted_input;
}

function formatnumber($num) {
    // This is my function
    if ($num == '') {
        $num = 0;
    }
    $pos = strpos((string) $num, ".");
    if ($pos === false) {
        $decimalpart = '';
    } // $decimalpart="00";}
    else {
        $decimalpart = substr($num, $pos + 1, 2);
        $num = substr($num, 0, $pos);
    }

    if (strlen($num) > 3 & strlen($num) <= 12) {
        $last3digits = substr($num, -3);
        $numexceptlastdigits = substr($num, 0, -3);
        $formatted = makecomma($numexceptlastdigits);
        $stringtoreturn = $formatted . "," . $last3digits; //.".".$decimalpart ;;
        if ($decimalpart != '') {
            $stringtoreturn .= "." . $decimalpart;
        }
    } elseif (strlen($num) <= 3) {
        $stringtoreturn = $num; //.".".$decimalpart ;
        if ($decimalpart != '') {
            $stringtoreturn .= "." . $decimalpart;
        }
    } elseif (strlen($num) > 12) {
        $stringtoreturn = number_format($num, 2);
    }

    if (substr($stringtoreturn, 0, 2) == "-,") {
        $stringtoreturn = "-" . substr($stringtoreturn, 2);
    }

    return $stringtoreturn;
}

function convertMonthYearFrom($from) {
    $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
        'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
    $fromarray = explode(' ', $from);
    if (!empty($fromarray)) {
        @list($fromMonth, $fromYear) = array_pad(explode(' ', $from, 2), 2, null);
    }
    @$fromMonth = $month[$fromMonth];
    $yearmonth1 = $fromYear . $fromMonth;
    return $yearmonth1;
}

function convertMonthYearTo($to) {
    $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
        'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
    @list($toMonth, $toYear) = array_pad(explode(' ', $to, 2), 2, null);
    if (isset($toMonth)) {
        @$toMonth = $month[$toMonth];
    }

    $yearmonth2 = $toYear . $toMonth;
    return $yearmonth2;
}

function partner_smtp() {
    $ci = &get_instance();
    $ci->load->model('login/Mlogapproval');
    $partner_smtp = $ci->Mlogapproval->get_PartnerDetails($ci->session->userdata('partner_id'));
    if ($partner_smtp['smtp_username'] == '' || $partner_smtp['smtp_protocol'] == '' || $partner_smtp['smtp_host'] == '' || $partner_smtp['smtp_port'] == '' || $partner_smtp['smtp_password'] == '') {
        $mail_details['protocol'] = 'smtp';
        $mail_details['smtp_host'] = 'ssl://smtp.gmail.com';
        $mail_details['smtp_port'] = 465;
        $mail_details['smtp_user'] = 'mis@villgro.org';
        $mail_details['smtp_pass'] = 'misvillgro';
        $mail_details['smtp_subject'] = 'Villgro Admin';
    } else {
        $mail_details['protocol'] = $partner_smtp['smtp_protocol'];
        $mail_details['smtp_host'] = $partner_smtp['smtp_host'];
        $mail_details['smtp_port'] = $partner_smtp['smtp_port'];
        $mail_details['smtp_user'] = $partner_smtp['smtp_username'];
        $mail_details['smtp_pass'] = $partner_smtp['smtp_password'];
        $mail_details['smtp_subject'] = $partner_smtp['smtp_subject'];
    }
    return $mail_details;
}

function approve_leave_list($formresult = '') {

    $ci = &get_instance();
    $ci->load->model('leave/Mleave');
    if ($ci->session->userdata('user_type') != 'admin' && $ci->session->userdata('user_type') != 'superadmin') {
        $empid = $ci->session->userdata['emp_number'];
        $data['chk_sup'] = $chk_sup = $ci->Mleave->getSupervisor($empid);
    }
    $partner_id = $ci->session->userdata('partner_id');
    $cond_arr[] = "t1.leave_status IN (0)";
    $cond_arr[] = "t2.partner_id = " . $partner_id;
    $cond_arr[] = "t1.leave_length_days > 0 ";

    if ($ci->session->userdata('user_type') != 'admin' && $ci->session->userdata('user_type') != 'superadmin') {
        if (count($chk_sup) > 0) {
            $subs_id = array();
            foreach ($chk_sup as $sups) {
                $subs_id[] = $sups['erep_sub_emp_number'];
            }
            $sub_emp_id = implode(',', $subs_id);
            $cond_arr[] = "t2.id IN (" . $sub_emp_id . ")";
        } else {
            $cond_arr[] = "t2.id IN ('0')";
        }
    }

    $financialArray = $ci->Mlogapproval->findCurrentFinancialYear();
    // $from = $ci->Mlogapproval->convertMonthYearFrom($financialArray[0]['from']);
    // $to = $ci->Mlogapproval->convertMonthYearTo($financialArray[0]['to']);
    $from = date('Y').'01';
    $to = date('Y').'12';
    $cond_arr[] = "EXTRACT(YEAR_MONTH FROM t1.leave_date) >= '$from' and EXTRACT(YEAR_MONTH FROM t1.leave_date) <= '$to'";

    $result_cond = implode(' and ', $cond_arr);
    $option['status'] = 1;

    $approval_count = $ci->Mleave->getDTLeaveCount($result_cond);
    return $approval_count;
}

function total_pending_book() {
    $ci = &get_instance();
    $ci->load->model('login/Mlogapproval');
    $pending_count = $ci->Mlogapproval->checkLibraryRequest();
    return $pending_count;
}


function total_pending_count_dashboard($type = "") { 
    $ci = &get_instance();
    $ci->load->model('login/Mlogapproval');
    $apn_count = 0;
    $int_count = 0;
    $finance = unserialize($ci->Mlogapproval->getApprovalSetting('finance'));
    $ceo = $ci->Mlogapproval->getApprovalSetting('ceo');
    $financeteam = $finance;
    $ceoteam = array($ceo);
    if ($ci->session->userdata('isAdmin') != 'Yes' && ($ci->session->userdata('user_type') != 'superadmin')) {

       /*  $apn_count += $ci->Mlogapproval->getApprovalDashboard_test('mylist', 'pending');
        $apn_count += $ci->Mlogapproval->getApprovalDashboard_test('rolist', 'pending');
        $apn_count += $ci->Mlogapproval->getApprovalDashboard_test('phlist', 'pending'); */
        $int_count += $ci->Mlogapproval->getInternalDashboard('mylist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('rolist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('phlist', 'pending');

        if (in_array($ci->session->userdata('user_id'), $ceoteam)) {
            #$apn_count += $ci->Mlogapproval->getApprovalDashboard('ceolist', 'pending');
        }
        if (in_array($ci->session->userdata('user_id'), $financeteam)) {
            $int_count += $ci->Mlogapproval->getInternalDashboard('finance', 'pending');
        }
    } else {
        $apn_count += $ci->Mlogapproval->getApprovalDashboard('admin', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('admin', 'pending');
    }

//  $leave_count = $ci->Mlogapproval->leavecount();
    $leave_count = approve_leave_list();
    $library_count = $ci->Mlogapproval->librarycount();
	if (($ci->session->userdata('user_type') == 'admin' || $ci->session->userdata('user_type') == 'superadmin')) {
		$travel_count = $ci->Mlogapproval->travelcount();
	}
		#echo $library_count;die;
    if ($ci->session->userdata('partner_id') != 1) {
        $total_count = $apn_count + $int_count;
    } else {
        $total_count = $apn_count + $int_count + $leave_count + $library_count + $travel_count;
    }
    if ($type != "" && $type == "travel") {
        $total_count = $travel_count;
    }
    return $total_count;
}



function total_pending_count_test($type = "") { 
    $ci = &get_instance();
    $ci->load->model('login/Mlogapproval');
    $apn_count = 0;
    $int_count = 0;
    $finance = unserialize($ci->Mlogapproval->getApprovalSetting('finance'));
    $ceo = $ci->Mlogapproval->getApprovalSetting('ceo');
    $financeteam = $finance;
    $ceoteam = array($ceo);
    if ($ci->session->userdata('isAdmin') != 'Yes' && ($ci->session->userdata('user_type') != 'superadmin')) {

       /*  $apn_count += $ci->Mlogapproval->getApprovalDashboard_test('mylist', 'pending');
        $apn_count += $ci->Mlogapproval->getApprovalDashboard_test('rolist', 'pending');
        $apn_count += $ci->Mlogapproval->getApprovalDashboard_test('phlist', 'pending'); */
        $int_count += $ci->Mlogapproval->getInternalDashboard('mylist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('rolist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('phlist', 'pending');

        if (in_array($ci->session->userdata('user_id'), $ceoteam)) {
            #$apn_count += $ci->Mlogapproval->getApprovalDashboard('ceolist', 'pending');
        }
        if (in_array($ci->session->userdata('user_id'), $financeteam)) {
            $int_count += $ci->Mlogapproval->getInternalDashboard('finance', 'pending');
        }
    } else {
        $apn_count += $ci->Mlogapproval->getApprovalDashboard('admin', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('admin', 'pending');
    }
//  $leave_count = $ci->Mlogapproval->leavecount();
    $leave_count = approve_leave_list();
    $library_count = $ci->Mlogapproval->librarycount();
    $travel_count = $ci->Mlogapproval->travelcount();
    if ($ci->session->userdata('partner_id') != 1) {
        $total_count = $apn_count + $int_count;
    } else {
        $total_count = $apn_count + $int_count + $leave_count + $library_count + $travel_count;
    }
    if ($type != "" && $type == "travel") {
        $total_count = $travel_count;
    }
    return $total_count;
}

function total_pending_count_test_dash($type = "") {
    $ci = &get_instance();
    $ci->load->model('login/Mlogapproval');
    $apn_count = 0;
    $int_count = 0;
    $finance = unserialize($ci->Mlogapproval->getApprovalSetting('finance'));
    $ceo = $ci->Mlogapproval->getApprovalSetting('ceo');
    $financeteam = $finance;
    $ceoteam = array($ceo);
    if ($ci->session->userdata('isAdmin') != 'Yes' && ($ci->session->userdata('user_type') != 'superadmin')) {
        $apn_count += $ci->Mlogapproval->getApprovalDashboard('mylist', 'pending');
        $apn_count += $ci->Mlogapproval->getApprovalDashboard('rolist', 'pending');
        $apn_count += $ci->Mlogapproval->getApprovalDashboard_test('phlist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('mylist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('rolist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('phlist', 'pending');

        if (in_array($ci->session->userdata('user_id'), $ceoteam)) {
            $apn_count += $ci->Mlogapproval->getApprovalDashboard('ceolist', 'pending');
        }
        if (in_array($ci->session->userdata('user_id'), $financeteam)) {
            $int_count += $ci->Mlogapproval->getInternalDashboard('finance', 'pending');
        }
    } else {
        $apn_count += $ci->Mlogapproval->getApprovalDashboard('admin', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('admin', 'pending');
    }
//  $leave_count = $ci->Mlogapproval->leavecount();
    $leave_count = approve_leave_list();
    $library_count = $ci->Mlogapproval->librarycount();
    $travel_count = $ci->Mlogapproval->travelcount();
    if ($ci->session->userdata('partner_id') != 1) {
        $total_count = $apn_count + $int_count;
    } else {
        $total_count = $apn_count + $int_count + $leave_count + $library_count + $travel_count;
    }
    if ($type != "" && $type == "travel") {
        $total_count = $travel_count;
    }
    return $total_count;
}


function total_pending_count($type = "") {
    $ci = &get_instance();
    $ci->load->model('login/Mlogapproval');
    $apn_count = 0;
    $int_count = 0;
    $finance = unserialize($ci->Mlogapproval->getApprovalSetting('finance'));
    $ceo = $ci->Mlogapproval->getApprovalSetting('ceo');
    $financeteam = $finance;
    $ceoteam = array($ceo);
    if ($ci->session->userdata('isAdmin') != 'Yes' && ($ci->session->userdata('user_type') != 'superadmin')) {
        $apn_count += $ci->Mlogapproval->getApprovalDashboard('mylist', 'pending');
        $apn_count += $ci->Mlogapproval->getApprovalDashboard('rolist', 'pending');
        #$apn_count += $ci->Mlogapproval->getApprovalDashboard('phlist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('mylist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('rolist', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('phlist', 'pending');

        if (in_array($ci->session->userdata('user_id'), $ceoteam)) {
            $apn_count += $ci->Mlogapproval->getApprovalDashboard('ceolist', 'pending');
        }
        if (in_array($ci->session->userdata('user_id'), $financeteam)) {
            $int_count += $ci->Mlogapproval->getInternalDashboard('finance', 'pending');
        }
    } else {
        $apn_count += $ci->Mlogapproval->getApprovalDashboard('admin', 'pending');
        $int_count += $ci->Mlogapproval->getInternalDashboard('admin', 'pending');
    }
//  $leave_count = $ci->Mlogapproval->leavecount();
    $leave_count = approve_leave_list();
    $library_count = $ci->Mlogapproval->librarycount();
	
    $travel_count = $ci->Mlogapproval->travelcount();
    if ($ci->session->userdata('partner_id') != 1) {
        $total_count = $apn_count + $int_count;
    } else {
        $total_count = $apn_count + $int_count + $leave_count + $library_count + $travel_count;
    }
    if ($type != "" && $type == "travel") {
        $total_count = $travel_count;
    }
    return $total_count;
}

function total_apppending_count() {
    $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $apn_count = 0;
    $searchArray[] = "AP.status = 'pending'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes($where, '', '', 'AP.approval_no', 'asc', 'show All');
    $apn_count = count($approvalCount);
    return $apn_count;
}

function total_an_ceo_count() {
    $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $where = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' ) and AP.status = 'pending'";
    $columnSortOrder = 'asc';
    $admin = 'Show all';
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, $admin);
    $getAll_count = count($approvalCount);
    return $getAll_count;
}

function total_ropending_count($empid) {
    /* $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $apn_count = 0;

    $searchArray[] = "AP.from_employee ='" . $empid . "'"; 
	#$searchArray[] = "AP.assigned_user ='" . $empid . "'";
	$searchArray[] = "AP.RO_status = 'confirmed'";
    $searchArray[] = "AP.status = 'pending'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes($where, '', '', 'AP.approval_no', 'asc', 'show All');
	#echo'<pre>';print_r($approvalCount);die;
    $apn_count = count($approvalCount);
    return $apn_count; */
	
	$ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $apn_count = 0;
    $searchArray[] = "AP.to_RO ='" . $empid . "'"; 
	$searchArray[] = "AP.RO_status = 'Pending'";
    $searchArray[] = "AP.status = 'pending'";
	$searchArray[] = "(AP.PH_status = 'pending' OR AP.PH_status = 'confirmed')"; 
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes($where, '', '', 'AP.approval_no', 'asc', 'show All');
    $apn_count = count($approvalCount);
    return $apn_count;
	
}


function total_phpending_count_assign($empid) {
    $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $apn_count = 0;
    #$searchArray[] = "MP.programme_head = '" . $empid . "'";
	$searchArray[] = "AP.from_employee != '" . $empid . "'";
	$searchArray[] = "AP.assigned_user = '" . $empid . "'";
    $searchArray[] = "AP.RO_status = 'confirmed'";
    $searchArray[] = "AP.PH_status = 'pending' AND AP.status = 'pending'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes($where, '', '', 'AP.approval_no', 'asc', 'show All');
	#echo'<pre>';print_r($approvalCount);die;
    $apn_count = count($approvalCount);
    return $apn_count;
}

function total_phpending_count($empid) {
    /* $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $apn_count = 0;
    #$searchArray[] = "MP.programme_head = '" . $empid . "'";
	$searchArray[] = "AP.assigned_user = '" . $empid . "'";
    $searchArray[] = "AP.RO_status = 'confirmed'";
    $searchArray[] = "AP.PH_status = 'pending' AND AP.status = 'pending'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes($where, '', '', 'AP.approval_no', 'asc', 'show All');
	#echo'<pre>';print_r($approvalCount);die;
    $apn_count = count($approvalCount);
    return $apn_count; */
	
	$ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $apn_count = 0;
	$searchArray[] = "AP.assigned_user = '" . $empid . "'";
    $searchArray[] = "AP.RO_status = 'confirmed'";
    $searchArray[] = "AP.PH_status = 'pending' AND AP.status = 'pending'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes($where, '', '', 'AP.approval_no', 'asc', 'show All');
	#echo'<pre>';print_r($approvalCount);die;
    $apn_count = count($approvalCount);
    return $apn_count;
	
}

function total_ropending_count_test($empid) {
    $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $apn_count = 0;

    $searchArray[] = "AP.from_employee ='" . $empid . "'";
    $searchArray[] = "AP.status = 'pending'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes_test($where, '', '', 'AP.approval_no', 'asc', 'show All');
	#echo'<pre>';print_r($approvalCount);die;
    $apn_count = count($approvalCount);
    return $apn_count;
}



function total_roOnlypending_count($empid) {
    $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $apn_count = 0;
    #$searchArray[] = "MP.programme_head = '" . $empid . "'";
	$searchArray[] = "AP.to_RO = '" . $empid . "'";
    $searchArray[] = "AP.RO_status = 'pending'";
    $searchArray[] = "AP.status = 'pending'";
    $where = implode(" and ", $searchArray); 
    $approvalCount = $ci->Mapproval->getLimitApprovalNotes($where, '', '', 'AP.approval_no', 'asc', 'show All');
    $apn_count = count($approvalCount);
    return $apn_count;
}




function totalin_apppending_count($empid = '') {
    $ci = &get_instance();
    $ci->load->model('internal/Minternal');
    $apn_count = 0;
    if ($empid == '') {
        $admin = 'show_all';
    } else {
        $admin = '';
    }
    $partner_id = $ci->session->userdata('partner_id');
    $searchArray[] = "INTER.status = 'pending' and INTER.partner_id ='$partner_id'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Minternal->getLimitInternalNotes('1', $where, '', '', 'INTER.internal_no', 'asc', $admin);
    $apn_count = count($approvalCount);
    return $apn_count;
}

function totalin_ropending_count($empid) {
    $ci = &get_instance();
    $ci->load->model('internal/Minternal');
    $apn_count = 0;
    $partner_id = $ci->session->userdata('partner_id');
    $searchArray[] = "((INTER.to IN ('" . $empid . "')) or (AN.to_RO ='" . $empid . "'))";
    $searchArray[] = "INTER.status = 'pending' and INTER.partner_id ='$partner_id'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Minternal->getLimitInternalNotes('1', $where, '', '', 'INTER.internal_no', 'asc', 'show All');
    $apn_count = count($approvalCount);
	#echo'<pre>';print_r( $approvalCount);die;
    return $apn_count;
}

function totalin_finpending_count() {
    $ci = &get_instance();
    $ci->load->model('internal/Minternal');
    $apn_count = 0;
    $partner_id = $ci->session->userdata('partner_id');
    $searchArray[] = "INTER.status ='confirmed' and INTER.finance_status ='inprogress'";
    $searchArray[] = "INTER.partner_id ='$partner_id'";
    $where = implode(" and ", $searchArray);
    $approvalCount = $ci->Minternal->getLimitInternalNotes('1', $where, '', '', 'INTER.internal_no', 'asc', 'show All');
    $apn_count = count($approvalCount);
    return $apn_count;
}

function financeuser_count($empid) {
    $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $finance = unserialize($ci->Mapproval->getApprovalSetting('finance'));
    if (in_array($empid, $finance)) {
        $fin_usercount = '1';
        return $fin_usercount;
    }
}

function configStatus($inv_id) {
    $ci = &get_instance();
    $ci->load->model('portfolio/mportfolio');
    $appoption['inv_id'] = $inv_id;
    $data['approvals'] = $approvals = $ci->Mportfolio->getDetails('port_config_approval', $appoption);
    $cnt = count($approvals);
    for ($i = 0; $i < $cnt; $i++) {
        if (($approvals[$i]['sales_approvals'] || $approvals[$i]['channel_approval'] || $approvals[0]['pipeline_approval'] || $approvals[0]['revenue_approval'] || $approvals[0]['netprofit_approval'] || $approvals[0]['vif_approval'] || $approvals[0]['fundraise_approval'] || $approvals[0]['mentor_approval'] || $approvals[0]['tap_approval'] || $approvals[0]['nontap_approval'] || $approvals[0]['board_approval'] || $approvals[0]['impact_approval'] || $approvals[0]['project_approval']) == 1) {

        } else if (($approvals[0]['sales_approvals'] || $approvals[0]['channel_approval'] || $approvals[0]['pipeline_approval'] || $approvals[0]['revenue_approval'] || $approvals[0]['netprofit_approval'] || $approvals[0]['vif_approval'] || $approvals[0]['fundraise_approval'] || $approvals[0]['mentor_approval'] || $approvals[0]['tap_approval'] || $approvals[0]['nontap_approval'] || $approvals[0]['board_approval'] || $approvals[0]['impact_approval'] || $approvals[0]['project_approval']) == 2) {

        }
    }
}

function check_partner_privilege($inv_id) {
    $ci = &get_instance();
    $get_partner = $ci->Mportfolio->find_application_partner($inv_id);
    $redirect_url = base_url() . 'index.php/login/icon_menu';
    if ($get_partner[0]['partner_id'] != $ci->session->userdata('partner_id')) {
        redirect($redirect_url);
    }
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

//common mail function sending with mail template
function sendMail($from = NULL, $to = array(), $tamplate = NULL, $mailContant = NULL, $attach = NULL, $ccEmail = NULL) {

    $ci = &get_instance();
    $ci->load->model('approval/Mapproval');
    $mailTemplate = $ci->Mapproval->getMailTemplate($tamplate);

    $messageSubject = $mailTemplate['0']['messagesubject'];
    $messageBody = str_replace($mailContant['org'], $mailContant['replace'], $mailTemplate['0']['messagebody']);
    $ci->load->library('email');
    $ci->email->clear(TRUE);
    $ci->email->from('mis@villgro.org', 'Villgro Admin');
    $ci->email->to($to);

    if (!empty($attach)) {
        foreach ($attach as $key => $value):
            $ci->email->attach($value);
        endforeach;
    }
    $ci->email->subject($messageSubject);
    $ci->email->message($messageBody);
    $ci->email->send();
    return true;
}

//Status of books
function bookStatus($bookId, $employee) {
    $ci = &get_instance();
    $result = $ci->Mlibrary->getbookAvailabelStatus($bookId, $employee);
    if (count($result)) {
        return $result['0']['status'];
    } else {
        return 'no';
    }
}

//check for user login
function isLogged() {
    $ci = &get_instance();
    if (($ci->session->userdata('user')) == '') {
        $ci->session->set_flashdata('warningMsg', 'Please Login to access this page!');
        redirect('login');
    }
}

//check for Admin login
function isAdmin() {
    isLogged();
    $ci = &get_instance();
    if (($ci->session->userdata('isAdmin')) != 'Yes') {
        $ci->session->set_flashdata('warningMsg', 'Access Denied!');
        redirect('main');
    }
}

//function to convert Mtysql to normal date
function mysql2ddmmyyyy($input, $stringmonth = NULL) {
    $output = false;
    $d = preg_split('#[-/:. ]#', $input);
    if (is_array($d) && (count($d) == 3 || count($d) == 6)) {
        if (checkdate($d[1], $d[2], $d[0])) {
            if ($stringmonth) {
                $stringmonth = date("M", mktime(0, 0, 0, ($d[1])));
                $output = "$d[2] $stringmonth $d[0]";
            } else
            $output = "$d[2]/$d[1]/$d[0]";
        }
    }
    else if (is_array($d) && count($d) == 2) {
        $output = "$d[1]/$d[0]";
    }
    return $output;
}

function addDays($current, $days) {
    $split = explode("/", $current);
    $next = mktime(0, 0, 0, $split[1], $split[0] + $days, $split[2]);
    $ex = date("d/m/Y", $next);
    return $ex;
}

function current_FYstartMonth($partner_id) {
    $ci = &get_instance();
    $ci->load->model('portfolio/mportfolio');
    $fy_startMonth = $ci->Mportfolio->getFinancialYearMonth($partner_id);
    return $fy_startMonth[0]['fin_from_month'];
}

function current_FYendMonth($partner_id) {
    $ci = &get_instance();
    $ci->load->model('portfolio/mportfolio');
    $fy_endMonth = $ci->Mportfolio->getFinancialYearMonth($partner_id);
    return $fy_endMonth[0]['fin_to_month'];
}

function current_FYstartYear($partner_id) {
    $ci = &get_instance();
    $ci->load->model('portfolio/mportfolio');
    $fy_startYear = $ci->Mportfolio->getFinancialYearMonth($partner_id);
    return $fy_startYear[0]['fin_from_year'];
}

function current_FYendYear($partner_id) {
    $ci = &get_instance();
    $ci->load->model('portfolio/mportfolio');
    $fy_endYear = $ci->Mportfolio->getFinancialYearMonth($partner_id);
    return $fy_endYear[0]['fin_to_year'];
}
function total_travel_request_count() {
    $ci = &get_instance();
    $ci->load->model('travel/Mtravel');
	$getTravelRequestCount = $ci->Mtravel->getTravelRequestDataCount();
    return $getTravelRequestCount;
}

