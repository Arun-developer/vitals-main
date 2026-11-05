<?php

class Leave extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $uri_string = $this->uri->segment(2);
        if ($uri_string != 'leave_cronjobs')
            $this->Mauth->isLoggedCheck();
        // $this->load->model('Empuser');
        $this->load->model('Mleave');
        $this->load->model('portfolio/Mportfolio');
        $this->load->model('approval/Mapproval');
    }

    /* common functionality */

    public function dateDiffInDays($date1, $date2) {
        // Calulating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);

        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }
	
	public function check_leave_details() { 
		
		
		/* 
		$query = "SELECT  hrlq.leave_type_id,hrlq.leave_length_days,hlt.leave_type_name FROM hr_leave_request hrlq  
		LEFT JOIN hr_leave_type hlt ON hlt.leave_type_id = hrlq.leave_type_id 
		WHERE  hrlq.employee_id = 133 AND hrlq.created_at >= '2022-01-01 00:00:00' AND hrlq.status =2 AND hrlq.leave_type_id LIKE 'LTY002'";
		$result = $this->db->query($query);
		echo'<pre>';print_r($result->result());die; */
		
		$leavetypes = $this->Mleave->getLeaveTypes();
		$emp_list = $this->Mleave->getEmployeedetail();
		$check_leave_quota = $this->Mleave->getLeaveQuota($emp_list['employee_id'], date('Y'));
		$employee_id='';
		$emp_arr = array();
		
		  foreach ($emp_list as $elist) {
			$employee_id = $elist['employee_id'];
			if($employee_id!=''){
				
				foreach ($leavetypes as $leaves) {
					$leave_type_id = $leaves['leave_type_id'];
					/* $query = "SELECT hrlq.employee_id, hrlq.employee_id as empid,SUM(hrlq.leave_length_days) AS LEAVE_LENGTH,hrlq.id AS LR_ID,hrlq.leave_type_id 
					FROM hr_leave_request  AS hrlq 
					LEFT JOIN hr_user_profile hrs ON hrs.id = hrlq.employee_id
					WHERE hrlq.leave_type_id LIKE '$leave_type_id' AND hrlq.employee_id = 133 AND hrlq.created_at >= '2022-01-01 00:00:00' AND hrlq.status =2";
					$result = $this->db->query($query);
					echo'<pre>';print_r($result->result()); */
					
					$query = "SELECT SUM(leave_length_days) AS total_leave_approved, hrlq.leave_type_id FROM hr_leave_request hrlq 
						WHERE  hrlq.employee_id = $employee_id AND hrlq.created_at >= '2022-01-01 00:00:00' AND hrlq.status =2 AND hrlq.leave_type_id LIKE '$leave_type_id'";
						$result = $this->db->query($query);
						if($result->result()[0]->leave_type_id){
							$emp_arr[][$employee_id.'='.$elist['emp_firstname'].''.$elist['emp_lastname']] = $result->result()[0];
							
						}
						
		
				}
			}
		  }
		  echo'<pre>';print_r($emp_arr);
		
	}

    public function leave_cronjobs() {
        /* $today_date = date('Y-m-d');
        $year_start = date('Y') . '01-01';
        $later_year = date('Y') - 1; */

        /* assigning leave quota for the user */
        /* $leavetypes = $this->Mleave->getLeaveTypes();
        $empid = $this->session->userdata['emp_number'];
        $emp_list = $this->Mleave->getEmployeedetail();
        foreach ($emp_list as $elist) {
            $check_leave_quota = $this->Mleave->getLeaveQuota($elist['employee_id'], date('Y'));
            $leave_types_arr = array();
            foreach ($check_leave_quota as $qlist) {
                $leave_types_arr[] = $qlist['leave_type_id'];
            }
            if (count($check_leave_quota) != count($leavetypes)) {
                foreach ($leavetypes as $leaves) {
                    if (!in_array($leaves['leave_type_id'], $leave_types_arr)) {
                        $leavedetails['year'] = date('Y');
                        $leavedetails['leave_type_id'] = $leaves['leave_type_id'];
                        $leavedetails['employee_id'] = $elist['employee_id'];
                        $leavedetails['partner_id'] = $this->session->userdata('partner_id');
                        $leavedetails['created_date'] = date("Y-m-d H:i:s");
                        $quota_query = $this->Mleave->insertLeaveDetail('hr_leave_quota', $leavedetails);
                    }
                }
            }
        } */

        /* assign annualy repeated holiday */
        /* if ($today_date = $year_start) {
            $holiday_repeat = $this->Mleave->getHolidayDetails($later_year, '', 1);
            foreach ($holiday_repeat as $repeats) {
                $holi_details['holiday_name'] = $repeats['holiday_name'];
                $holi_details['date'] = $repeats['date'];
                $holi_details['repeat_annually'] = $repeats['repeat_annually'];
                $holi_details['length'] = $repeats['length'];
                $holi_details['status'] = 1;
                $holi_details['created_at'] = date("Y-m-d H:i:s");
                $quota_query = $this->Mleave->insertLeaveDetail('hr_holidays', $holi_details);
            }
        } */

        /* updating leave taken details */
        /* $cur_date = date('Y-m-d');
        $check_leave_stat = $this->Mleave->checkLeaveStatus($cur_date);
        if (count($check_leave_stat) > 0) {
            foreach ($check_leave_stat as $stats) {
                $leaveapprove['leave_status'] = $leave_req['status'] = 2;
                $leave_req['cron_status'] = 1;
                $option['id'] = $stats['id'];
                $leave_reqoption['id'] = $stats['leave_request_id'];
                $hm_query = $this->Mleave->updateLeaveDetail('hr_leave', $option, $leaveapprove);
                if ($hm_query) {
                    $hm_query1 = $this->Mleave->updateLeaveDetail('hr_leave_request', $leave_reqoption, $leave_req);
                    $emp_leave_quota = $this->Mleave->getLeaveQuota($stats['employee_id'], $stats['year'], $stats['leave_type_id']);
                    $leavequota['leave_taken'] = $emp_leave_quota[0]['leave_taken'] + $stats['leave_length_days'];
                    $option1['year'] = $stats['year'];
                    $option1['employee_id'] = $stats['employee_id'];
                    $option1['leave_type_id'] = $stats['leave_type_id'];
                    $hm_query1 = $this->Mleave->updateLeaveQuota('hr_leave_quota', $option1, $leavequota);                    
                }
            }
        } */
        /* updating leave taken details ends */

        /* Check for cron execution */
        /* $cron_id['id'] = 1;
        $cron_data['cron_update_on'] = date('Y-m-d H:i:s');
        $cron_status = $this->Mleave->updateLeaveDetail('hr_leave_cron', $cron_id, $cron_data); */
    }

    public function cron_updateLeaveTaken() {
        /* $cur_date = date('Y-m-d');
        $check_leave_stat = $this->Mleave->checkLeaveStatus($cur_date, $emp_id);
        if (count($check_leave_stat) > 0) {
            foreach ($check_leave_stat as $stats) {
                $leaveapprove['leave_status'] = $leave_req['status'] = 2;
                $leave_req['cron_status'] = 1;
                $option['id'] = $stats['id'];
                $leave_reqoption['id'] = $stats['leave_request_id'];
                $hm_query = $this->Mleave->updateLeaveDetail('hr_leave', $option, $leaveapprove);
                if ($hm_query) {
                    $hm_query1 = $this->Mleave->updateLeaveDetail('hr_leave_request', $leave_reqoption, $leave_req);
                    $emp_leave_quota = $this->Mleave->getLeaveQuota($stats['employee_id'], $stats['year'], $stats['leave_type_id']);
                    $leavequota['leave_taken'] = $emp_leave_quota[0]['leave_taken'] + $stats['leave_length_days'];
                    $option1['year'] = $stats['year'];
                    $option1['employee_id'] = $stats['employee_id'];
                    $option1['leave_type_id'] = $stats['leave_type_id'];
                    $hm_query1 = $this->Mleave->updateLeaveQuota('hr_leave_quota', $option1, $leavequota);
                }
            }
            echo 'Leave details updated successfully..';
        } */

        /* Check for cron execution */
        /* $cron_id['id'] = 1;
        $cron_data['user_update_on'] = date('Y-m-d H:i:s');
        $cron_status = $this->Mleave->updateLeaveDetail('hr_leave_cron', $cron_id, $cron_data); */
    }

    /* end functionality */

    // ********** Request **********
    // Leave taken //
    public function leave_list() {

        if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
            redirect('leave/leave_summary');
        }

        $partner_id = $this->session->userdata('partner_id');
        $default_status = array(0, 1, 2, 3, 4);
        $data['filter_fromdate'] = $fromyear = (isset($_POST['filter_fromdate'])) ? $_POST['filter_fromdate'] : '01-01-' . date('Y');
        $data['filter_todate'] = $toyear = (isset($_POST['filter_todate'])) ? $_POST['filter_todate'] : '31-12-' . date('Y');
        $data['l_status'] = $l_status = isset($_POST['l_status']) ? $_POST['l_status'] : $default_status;

        $cond_arr[] = "t1.leave_startdate >= '" . date('Y') . "-01-01' and t1.leave_startdate <= '" . date('Y') . "-12-31'";

        $cond_arr[] = "t1.leave_status IN (0)";
        $cond_arr[] = "t2.partner_id = " . $partner_id;
        $empid = $this->session->userdata['emp_number'];

        if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            $chk_sup = $this->Mleave->getSupervisor($empid);
            if (count($chk_sup) > 0) {
                $subs_id = array();
                foreach ($chk_sup as $sups) {
                    $subs_id[] = $sups['erep_sub_emp_number'];
                }
                $sub_emp_id = implode(',', $subs_id);
                $cond_arr[] = "t2.id IN (" . $sub_emp_id . ")";
            }
        }

        $result_cond = implode(' and ', $cond_arr);
        $data['approval_count'] = $this->Mleave->getDTLeaveCount($result_cond);
        /* check if user is supervisor or not */
        $empid = $this->session->userdata['emp_number'];
        $data['chk_sup'] = $this->Mleave->getSupervisor($empid);

        $this->load->vars($data);
        $this->load->view('leave/request/leave_list');
    }

    /* fetching leave taken details for datatable serverside */

    public function DTleavelist() {
        $requestData = $_POST;
        $columns = array(
            0 => 'id',
            1 => 'leave_startdate',
            2 => 'date_applied',
            3 => 'date_approval',
            4 => 't2.emp_first_name',
            5 => 'leave_length_days',
            6 => 't3.leave_type_name',
            7 => 'leave_status',
            8 => 'leave_comments'
        );


        $data['from_date'] = $fromyear = (isset($_POST['from_date']) && $_POST['from_date'] != '') ? date('Y-m-d', strtotime($_POST['from_date'])) : '';
        $data['to_date'] = $toyear = (isset($_POST['to_date']) && $_POST['to_date'] != '') ? date('Y-m-d', strtotime($_POST['to_date'])) : '';
        $filter_status = isset($_POST['filter_status']) ? $_POST['filter_status'] : '';
        if (in_array(1, $filter_status)) {
            array_push($filter_status, 2);
        } else if (in_array(4, $filter_status)) {
            array_push($filter_status, 3);
        }
        $l_status = implode(',', $filter_status);

        if ($fromyear != '' && $toyear != '') {
            $cond_arr[] = "t1.leave_startdate >= '" . $fromyear . "' and t1.leave_startdate <= '" . $toyear . "'";
        } else if ($fromyear != '' && $toyear == '') {
            $cond_arr[] = "t1.leave_startdate >= '" . $fromyear . "'";
        }

        if ($l_status != '') {
            $cond_arr[] = "t1.leave_status IN (" . $l_status . ")";
        }

        /* check if user is supervisor or not */
        $empid = $this->session->userdata['emp_number'];
        $partner_id = $this->session->userdata('partner_id');

        if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            $cond_arr[] = "t2.id = '" . $empid . "'";
        }

        if ($this->session->userdata('user_type') != 'superadmin') {
            $cond_arr[] = "t2.partner_id = '" . $partner_id . "'";
            $cond_arr[] = "t3.partner_id = '" . $partner_id . "'";
        }
        $cond_arr[] = "t3.status = 1";
        $result_cond = implode(' and ', $cond_arr);

        $totalrows = $this->Mleave->getDTLeaveCount($result_cond, $columns, $requestData);
        $query = $this->Mleave->getDTLeaveDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);

        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            if ($row['req_status'] == 0 || ($row['employee_id'] == $row['approved_by'])) {
                $sup_name = $this->Mleave->getSupervisor('', $row['employee_id']);
            } else {
                $superadmin_chk = $this->Mleave->getchecksuperadmin($row['approved_by']);
                if (count($superadmin_chk) > 0) {
                    $superr_ad = 1;
                } else {
                    $superr_ad = 0;
                }
                $sup_name = $this->Mleave->getEmployeedetail($row['approved_by']);
            }
            $supr_arr = array();
            //     if($superr_ad == 1){
            //     $supr_arr[] = 'Super Admin';
            // } else {
            foreach ($sup_name as $sups_li) {
                $supr_arr[] = $sups_li['emp_firstname'] . ' ' . $sups_li['emp_lastname'];
            }
            // }
            $nestedData = array();

            // $nestedData[] = '';
            // if ($this->session->userdata['user_type'] == 'superadmin') {
            //     $nestedData[] = '<input type="checkbox" class="chk_box" id="holiday_chk_box" name="holiday_id[]" value="' . $row['employee_id'] . '"/>';
            // }
            // $nestedData[] = $row['id'];
            $nestedData[] = date('d-m-Y', strtotime($row['leave_startdate'])) . ' to ' . date('d-m-Y', strtotime($row['leave_enddate']));

            $nestedData[] = date('d-m-Y', strtotime($row['date_applied']));
            if ($row['leave_approval_date'] != '0000-00-00') {
                $nestedData[] = isset($row['date_approval']) && $row['date_approval'] != '0000-00-00' ? date('d-m-Y', strtotime($row['date_approval'])) : '--';
            } else {
                $nestedData[] = '--';
            }

            // $nestedData[] = $row['emp_firstname'] . ' ' . $row['emp_lastname'];

            $get_totLeave = $this->Mleave->getUserLeaveCount($row['id']);
//            $nestedData[] = $length = $row['leave_length_days'];
            $nestedData[] = $length = $get_totLeave[0]['tot_leave'];
            $nestedData[] = $row['leave_type_name'];

            $pending_select = $approve_select = $taken_select = $reject_select = $cancel_select = '';
            if ($row['leave_status'] == 0) {
                $status = 'Pending approval';
                $pending_select = 'selected';
            } else if ($row['leave_status'] == 1 || $row['leave_status'] == 2) {
                $status = 'Approved';
                $approve_select = 'selected';
            } else if ($row['leave_status'] == 4 || $row['leave_status'] == 3) {
                $status = 'Cancelled';
                $cancel_select = 'selected';
            }

            if ($row['leave_status'] == 1 || $row['leave_status'] == 2 || $row['leave_status'] == 3 || $row['leave_status'] == 4) {
                $nestedData[] = $status;
                $nestedData[] = $row['leave_comments'];
            } else if ($empid == $row['employee_id']) {
                $currdate = strtotime(date('Y-m-d'));
                $st_date = strtotime($row['leave_startdate']);
                if ($st_date > $currdate) {
                    $nestedData[] = '<select  class="form-control" name="approve_status_' . $row['id'] . '" id="approve_status_' . $row['id'] . '" onchange="save_approval(' . $row['id'] . ')">' .
                    '<option value="">' . $status . '</option>' .
                    '<option value="4"' . $cancel_select . '>Cancel</option>';
                    $nestedData[] = "<textarea class='form-control commonAlphaNum' name='approve_comments_" . $row['id'] . "' onkeyup='save_approval(" . $row['id'] . ")' id='approve_comments_" . $row['id'] . "' rows='1' >" . $row['leave_comments'] . "</textarea>";
                } else {
                    $nestedData[] = $status;
                    $nestedData[] = $row['leave_comments'];
                }
            }


            // $nestedData[] = implode(', ', $supr_arr);


            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* fetching leave details for datatable serverside for approval section */

    public function DTApproveleavelist() {

        $requestData = $_POST;
        if ($this->session->userdata['user_type'] == 'superadmin') {
            $columns = array(
                0 => 'leave_applied_date',
                1 => 'leave_applied_date',
                2 => 'date_approval',
                3 => 'emp_first_name',
                4 => 'partner_name',
                5 => 'leave_length_days',
                6 => 'leave_type_name',
                7 => 'leave_status',
                8 => 'leave_comments'
            );
        } else {
            $columns = array(
                0 => 'leave_applied_date',
                1 => 'leave_applied_date',
                2 => 'date_approval',
                3 => 'emp_first_name',
                4 => 'leave_length_days',
                5 => 'leave_type_name',
                6 => 'leave_status',
                7 => 'leave_comments'
            );
        }
        $partner_id = $this->session->userdata('partner_id');
        $today_date = date('Y-m-d');

        $data['from_date'] = $fromyear = (isset($_POST['from_date']) && $_POST['from_date'] != '') ? date('Y-m-d', strtotime($_POST['from_date'])) : '';
        $data['to_date'] = $toyear = (isset($_POST['to_date']) && $_POST['to_date'] != '') ? date('Y-m-d', strtotime($_POST['to_date'])) : '';
        $filter_status = isset($_POST['filter_status']) ? $_POST['filter_status'] : '';
        if (in_array(1, $filter_status)) {
            array_push($filter_status, 2);
        } else if (in_array(4, $filter_status)) {
            array_push($filter_status, 3);
        }
        $l_status = implode(',', $filter_status);

        $partner_search = isset($_POST['partner_search']) ? $_POST['partner_search'] : '';

        if ($fromyear != '' && $toyear != '') {
            $cond_arr[] = "t1.leave_startdate >= '" . $fromyear . "' and t1.leave_startdate <= '" . $toyear . "'";
        } else if ($fromyear != '' && $toyear == '') {
            $cond_arr[] = "t1.leave_startdate >= '" . $fromyear . "'";
        }

        if ($l_status != '') {
            $cond_arr[] = "t1.leave_status IN (" . $l_status . ")";
        }

        if ($partner_search != '') {
            $cond_arr[] = "t5.id = '" . $partner_search . "'";
        }


        /* check if user is supervisor or not */
        $empid = $this->session->userdata['emp_number'];
        $chk_sup = $this->Mleave->getSupervisor($empid);

        if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            // $empid = $this->session->userdata['emp_number'];
            if (count($chk_sup) > 0) {
                $subs_id = array();
                foreach ($chk_sup as $sups) {
                    $subs_id[] = $sups['erep_sub_emp_number'];
                }
                $sub_emp_id = implode(',', $subs_id);
                $cond_arr[] = "t2.id IN (" . $sub_emp_id . ")";
            }
        }

        if ($this->session->userdata('user_type') != 'superadmin') {
            $cond_arr[] = "t2.partner_id = '" . $partner_id . "'";
            $cond_arr[] = "t3.partner_id = '" . $partner_id . "'";
        }

        $result_cond = implode(' and ', $cond_arr);
        $totalrows = $this->Mleave->getDTLeaveCount($result_cond, $columns, $requestData);
        $query = $this->Mleave->getDTLeaveDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);

        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $sup_name = $this->Mleave->getSupervisor('', $row['employee_id']);
            $supr_arr = array();
            foreach ($sup_name as $sups_li) {
                $supr_arr[] = $sups_li['emp_firstname'] . ' ' . $sups_li['emp_lastname'];
            }
            $nestedData = array();

            // $nestedData[] = '';
            // if ($this->session->userdata['user_type'] == 'superadmin') {
            //     $nestedData[] = '<input type="checkbox" class="chk_box" id="holiday_chk_box" name="holiday_id[]" value="' . $row['employee_id'] . '"/>';
            // }
            // $nestedData[] = $row['id'];
            $nestedData[] = date('d-m-Y', strtotime($row['leave_startdate'])) . ' to ' . date('d-m-Y', strtotime($row['leave_enddate']));

            $nestedData[] = date('d-m-Y', strtotime($row['date_applied']));

            if ($row['date_approval'] != '0000-00-00') {
                $nestedData[] = isset($row['date_approval']) && $row['date_approval'] != '0000-00-00' ? date('d-m-Y', strtotime($row['date_approval'])) : '--';
            } else {
                $nestedData[] = '--';
            }


            $nestedData[] = $row['emp_firstname'] . ' ' . $row['emp_lastname'];
            if ($this->session->userdata['user_type'] == 'superadmin') {
                $nestedData[] = $row['partner_name'] != '' ? $row['partner_name'] : '-';
            }

            $nestedData[] = $length = $row['leave_length_days'];
            $nestedData[] = $row['leave_type_name'];

            $pending_select = $approve_select = $taken_select = $reject_select = $cancel_select = '';
            if ($row['leave_status'] == 0) {
                $status = 'Pending approval';
                $pending_select = 'selected';
            } else if ($row['leave_status'] == 1 || $row['leave_status'] == 2) {
                $status = 'Approved';
                $approve_select = 'selected';
            } else if ($row['leave_status'] == 4 || $row['leave_status'] == 3) {
                $status = 'Cancelled';
                $cancel_select = 'selected';
            }

            if (isset($_POST['page']) && $_POST['page'] == 'leavelist') {
                $nestedData[] = $status;
                $nestedData[] = $row['leave_comments'];
            } else if (isset($_POST['page']) && $_POST['page'] == 'approval') {
                if ($row['leave_status'] == 2 || $row['leave_status'] == 4 || $row['leave_status'] == 3) {



                    if($status=='Approved'){

                       $nestedData[] = '<select style="width: 140px;" class="form-control" name="approve_status_' . $row['id'] . '" id="approve_status_' . $row['id'] . '" onchange="save_approval(' . $row['id'] . ')">' .
                       '<option >Approved</option>' .
                       '<option value="4"' . $cancel_select . '>Cancel</option>'; 

                   }else{
                    $nestedData[] = $status;

                }
                $nestedData[] = $row['leave_comments'];

            } else {
                if ($row['leave_status'] == 0) {
                    $nestedData[] = '<select  style="width: 140px;" class="form-control" name="approve_status_' . $row['id'] . '" id="approve_status_' . $row['id'] . '" onchange="save_approval(' . $row['id'] . ')">' .
                    '<option value="0"' . $pending_select . '>Pending Approval</option>' .
                    '<option value="1"' . $approve_select . '>Approve</option>' .
                    '<option value="4"' . $cancel_select . '>Cancel</option>';
                } else {
                    $nestedData[] = '<select style="width: 140px;" class="form-control" name="approve_status_' . $row['id'] . '" id="approve_status_' . $row['id'] . '" onchange="save_approval(' . $row['id'] . ')">' .
                    '<option value="1"' . $approve_select . '>Approve</option>' .
                    '<option value="4"' . $cancel_select . '>Cancel</option>';
                }
                $nestedData[] = "<textarea class='form-control wdt_180 commonAlphaNum' name='approve_comments_" . $row['id'] . "' onkeyup='save_approval(" . $row['id'] . ")' id='approve_comments_" . $row['id'] . "' rows='1' >" . $row['leave_comments'] . "</textarea>";
            }
        }

            // $nestedData[] = implode(', ', $supr_arr);


        $data[] = $nestedData;
        $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}

/* leave archieve details of logged in user */

public function leave_archieve($year = '') {
    if ($year == '') {
        $year = date('Y');
    }
    $empid = $this->session->userdata['emp_number'];
    $partner_id = $this->session->userdata('partner_id');
    $data['emp_detail'] = $this->Mleave->getEmployeedetail($empid);
    $data['leaves_list'] = $this->Mleave->getLeavelistByreqid('', $empid, $year);
    $data['selected_yr'] = $year;
    $cond_arr[] = "t1.leave_startdate >= '" . date('Y') . "-01-01' and t1.leave_startdate <= '" . date('Y') . "-12-31'";

    $cond_arr[] = "t1.leave_status IN (0)";
    $cond_arr[] = "t2.partner_id = " . $partner_id;
    $empid = $this->session->userdata['emp_number'];

    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
        $chk_sup = $this->Mleave->getSupervisor($empid);
        if (count($chk_sup) > 0) {
            $subs_id = array();
            foreach ($chk_sup as $sups) {
                $subs_id[] = $sups['erep_sub_emp_number'];
            }
            $sub_emp_id = implode(',', $subs_id);
            $cond_arr[] = "t2.id IN (" . $sub_emp_id . ")";
        }
    }

    $result_cond = implode(' and ', $cond_arr);
    $data['approval_count'] = $this->Mleave->getDTLeaveCount($result_cond);
    /* check if user is supervisor or not */
    $data['chk_sup'] = $this->Mleave->getSupervisor($empid);
    $this->load->vars($data);
    $this->load->view('leave/request/leave_archieve');
}

/* apply leave form details */

public function apply_leave() {

    if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
        redirect('leave/leave_list');
    }

    $empid = $this->session->userdata['emp_number'];
    $partner_id = $this->session->userdata('partner_id');

    $emp_id = $this->session->userdata('emp_number');
    $year = date('Y');
    $data['leave_quotas'] = $this->Mleave->getLeaveQuota($emp_id, $year, '', $partner_id);

    $data['optional_leave_quotas'] = $this->Mleave->getLeaveQuotaoptional($emp_id, $year, '', $partner_id);
    //echo "<pre>";
   // print_r($data['optional_leave_quotas']);die;

    $data['leave_quotaswfh'] = $this->Mleave->getLeaveQuotawfh($emp_id, $year, '', $partner_id);

    $cond_arr[] = "t1.leave_startdate >= '" . date('Y') . "-01-01' and t1.leave_startdate <= '" . date('Y') . "-12-31'";

    $cond_arr[] = "t1.leave_status IN (0)";
    $cond_arr[] = "t2.partner_id = " . $partner_id;

    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
        $chk_sup = $this->Mleave->getSupervisor($empid);
        if (count($chk_sup) > 0) {
            $subs_id = array();
            foreach ($chk_sup as $sups) {
                $subs_id[] = $sups['erep_sub_emp_number'];
            }
            $sub_emp_id = implode(',', $subs_id);
            $cond_arr[] = "t2.id IN (" . $sub_emp_id . ")";
        }
    }


    $result_cond = implode(' and ', $cond_arr);
    $data['approval_count'] = $this->Mleave->getDTLeaveCount($result_cond);
    $data['chk_sup'] = $this->Mleave->getSupervisor($empid);

    $holi_list = array();
    $get_repeat_holiday = $this->Mleave->checkHolidaysview('', '1');
    $year = date('Y') + 1;
    foreach ($get_repeat_holiday as $list) {
        for ($i = 2010; $i <= $year; $i++) {
            $days = $list['date'];
            $repeat_date = date("n/d", strtotime($days)) . '/' . $i;
            array_push($holi_list, $repeat_date);
        }
    }

    $get_holiday_list = $this->Mleave->checkHolidaysview('', '2');
    foreach ($get_holiday_list as $holi) {
        $holi_date = date("n/d/Y", strtotime($holi['date']));
        array_push($holi_list, $holi_date);
    }

    $get_holiday_lists = $this->Mleave->checkHolidaysview('', '0');
    foreach ($get_holiday_lists as $holis) {
        $holi_dates = date("n/d/Y", strtotime($holis['date']));
        array_push($holi_list, $holi_dates);
    }

  // echo "<pre>"; print_r($holi_list);die;
    $data['holiday_list'] = "'" . implode("','", $holi_list) . "'";

    $this->load->vars($data);
    $this->load->view('leave/request/apply_leave');
}

/* apply leave form details insertion */

public function addApplyleave() {
	
	//Casual Leave Validation 3 days continous
	$casualLeaveStatus=0;
	$casualLeaveContiousStatus=0;
	$checkPreviousLeave = 0;
	if(isset($_POST['leave_type']) && $_POST['leave_type']!=''){
		if($_POST['leave_type'] =='LTY001'){
			$clStartDate = $_POST['leave_from_date'];
			$clEndDate = $_POST['leave_to_date'];
			if(isset($clStartDate) && $clStartDate!=''){
				$timestamp = strtotime($clStartDate);
				$previousDate = date("d-m-Y", $timestamp - 86400);
				if($previousDate!=''){
					$result = $this->Mleave->checkCasualLeave(date("Y-m-d", strtotime($previousDate)) ,date("Y-m-d", strtotime($clEndDate)));
					if(!empty($result)){
						$casualLeaveStatus=1;
						$checkPreviousLeave = 1;
					}
				}
				
				//CHECK HOLIDAY
				$checkHolidaycl = 0;
				$getWeekEndResult = $this->Mleave->getWeekEnd();
				$dayCount = 0;
				$totalDayCount = 0;
				$clCount = 0;
				if(!empty($getWeekEndResult)){
					$daysWithValue3 = [];
					$daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
					foreach ($daysOfWeek as $day) {
						if ($getWeekEndResult[0][$day] == 3) {
							$daysWithValue3[] = $day;
						}
					}
					$startDateObj = DateTime::createFromFormat('d-m-Y', $clStartDate);
					$endDateObj = DateTime::createFromFormat('d-m-Y', $clEndDate);

					$currentDate = clone $startDateObj;
					while ($currentDate <= $endDateObj) {
						
						$getLoopDate = $currentDate->format('l');
						if (in_array(strtolower($getLoopDate), $daysWithValue3)) {
							$dayCount++;
						}
						$totalDayCount++;
						$currentDate->add(new DateInterval('P1D'));
					}
				}
				if($totalDayCount >3){
					$clCount = $totalDayCount -  $dayCount;
					if($clCount > 3){
						if($checkPreviousLeave==0){
							$casualLeaveStatus=1;
							$casualLeaveContiousStatus=1;
						}
					}
				}
			
				//Check continous leave of 3 days
				/* $getStartDate = DateTime::createFromFormat('d-m-Y', $clStartDate)->format('Y-m-d');
				$getendDate = DateTime::createFromFormat('d-m-Y', $clEndDate)->format('Y-m-d');
				$CheckstartDate = new DateTime($getStartDate);
				$CheckendDate = new DateTime($getendDate);
				$interval = $CheckstartDate->diff($CheckendDate);
				$dayCount = $interval->days;
				if($dayCount>2){
					$casualLeaveStatus=1;
					$casualLeaveContiousStatus=1;
				} */
			}
			
		}
	}
	
	#echo $casualLeaveStatus; echo'=';echo $casualLeaveContiousStatus;die;
	//Casual Leave Validation
	
	

  // echo "<pre>"; print_r($_POST);die;
    $leave_length = isset($_POST['leave_length']) ? $_POST['leave_length'] : 1;
    
    $leavedetails['employee_id'] = $leavereq['employee_id'] = $empid = $this->session->userdata('emp_number');
    $leavedetails['leave_type_id'] = $leavereq['leave_type_id'] = $_POST['leave_type'];
    $leavedetails['leave_startdate'] = $fromdate = date('Y-m-d', strtotime($_POST['leave_from_date']));
     $leavetypec=$_POST['leave_type'];
    if($leavetypec=='LTY014'){

        $leavedetails['leave_startdate'] = $fromdate = date('Y-m-d', strtotime($_POST['leave_from_date_1']));

        $leavedetails['leave_enddate'] = $todate = date('Y-m-d', strtotime($_POST['leave_from_date_1']));

    }else{
        $leavedetails['leave_enddate'] = $todate = date('Y-m-d', strtotime($_POST['leave_to_date']));
    }
    
    $leavedetails['leave_applied_date'] = $leavereq['date_applied'] = date('Y-m-d');
    $emp_id = $this->session->userdata('emp_number');
    $leave_type_name = $_POST['level_type_name'];
    if ($leave_type_name == "Work From Home") {
        $leavereq['date_approval']=date('Y-m-d');
        $leavereq['approved_by']=$emp_id;
    }
    $leavedetails['created_at'] = $leavereq['created_at'] = date("Y-m-d H:i:s");
    $leavedetails['leave_comments'] = $_POST['comments'];
    $leavereq['status'] = 0;
    $leave_type_name = $_POST['level_type_name'];

    if ($leave_type_name == "Work From Home") {
        $leavereq['status'] = 1;
    }

   

    $emptype = $_POST['leave_type'];
    $partner_id = $this->session->userdata('partner_id');

    $emp_id = $this->session->userdata('emp_number');
    $year = date('Y');
    $dataleave_request = $this->Mleave->getLeaveQuotawfhdata($emp_id, $year, $emptype, $partner_id);
    $remaining_days=0;
    $leave_taken=0;
    if(!empty($dataleave_request)){
        $no_of_days_alloted=$dataleave_request[0]['no_of_days_allotted']+$dataleave_request[0]['leave_brought_forward'];
        $leave_taken=$dataleave_request[0]['leave_taken'];
        $remaining_days=$no_of_days_alloted-$leave_taken;

    }
    /* checking holidays in between leave dates */
        // Declare an empty array
    $dates_array = array();
        // Use strtotime function
    $chk_fromdate = strtotime($_POST['leave_from_date']);

    if($leavetypec=='LTY014'){
    $chk_fromdate = strtotime($_POST['leave_from_date_1']);    
    $chk_todate = strtotime($_POST['leave_from_date_1']);
    }else{
    $chk_todate = strtotime($_POST['leave_to_date']);
    }

     $today_date = date('d-m-Y');
     $currentDate = strtotime($today_date);


        // Use for loop to store dates into array
        // 86400 sec = 24 hrs = 60*60*24 = 1 day
    for ($currentDate = $chk_fromdate; $currentDate <= $chk_todate; $currentDate += (86400)) {

        $leave_Store = date('Y-m-d', $currentDate);
        $dates_array[] = $leave_Store;
    }


    $req_length_new=0;

        //Leave date length check with hoildays and weekends.
    foreach ($dates_array as $ldates) {

        $leavedetails['leave_date'] = date('Y-m-d', strtotime($ldates));
        /* check with holiday details */
        $chk_holidays = $this->Mleave->checkHolidays($ldates);
        $chk_workingdays = $this->Mleave->checkWorkingdays($ldates);
                    // print_r($chk_holidays);
        /* check with holiday details */
        $days = date('l', strtotime($ldates));
        $chk_weekends = $this->Mleave->checkWeekends($days);




        if (count($chk_weekends) > 0) {
            if($leavetypec=='LTY014'){

            $leavedetails['leave_length_days'] = $length = 1;
            $leavedetails['leave_status'] = 0;
            }else{

            $leavedetails['leave_length_days'] = $length = 0;
            $leavedetails['leave_status'] = 4;
            }
        } else {
            $leavedetails['leave_length_days'] = $length = 1;
            $leavedetails['leave_status'] = 0;
        }
//echo "<pre>";  print_r($chk_workingdays);die;

        if ($length == 1) {
            if (count($chk_holidays) > 0) {
                $leavedetails['leave_length_days'] = $length = 0;
                $leavedetails['leave_status'] = 4;
            } else {
                $leavedetails['leave_length_days'] = $length = 1;
                $leavedetails['leave_status'] = 0;
            }
        }

        if (count($chk_workingdays) > 0) {
            $leavedetails['leave_length_days'] = $length = 1;
            $leavedetails['leave_status'] = 0;
        }


                    // $leavedetails['leave_length_days'] = $length = count($leave_len_days);
        if ($leave_length == 1 || $leavetypec=='LTY014') {
            $leavedetails['leave_length_hours'] = 24.0 * $length;
        } else {
            $leavedetails['leave_length_days'] = $length = $leavedetails['leave_length_days'] / 2;
            $leavedetails['leave_length_hours'] = 12.0;
        }
        if ($leave_type_name == "Work From Home") {
            $leavedetails['leave_status'] = 1;
        }

        $req_length_new += $length;
    }

    if($remaining_days >= $req_length_new || $leave_type_name == "Work From Home"){

        $leaverequest = count($dataleave_request);
        if ($leaverequest == 0) {
            $new_allocate['year'] = $year;
            $new_allocate['employee_id'] = $emp_id;
            $new_allocate['leave_type_id'] = $emptype;
            $new_allocate['partner_id'] = $partner_id;
            $new_allocate['no_of_days_allotted'] = 0.0;
            $new_allocate['comments'] = '';
            $new_allocate['leave_brought_forward'] = 0.0;
            $new_allocate['leave_encashed'] = 0.0;
            $new_allocate['created_date'] = date('Y-m-d H:i:s');

            $query_quota = $this->Mleave->insertLeaveDetail('hr_leave_quota', $new_allocate);
        }

        $hm_query = $this->Mleave->insertLeaveDetail('hr_leave_request', $leavereq);
        $leavedetails['leave_request_id'] = $request_id = $this->db->insert_id();

        /* checking leave date already exist */

        $chk_leavedates = $this->Mleave->checkLeavedates($fromdate, $empid);
        if (count($chk_leavedates) == 0) {

            $applieddate = date('Y-m-d', strtotime($_POST['leave_from_date']));
            if (date('Y-m-d') == $applieddate) {
                $time = date('H');
            } else {
                $time = '';
            }

            $posted_leavetype = $this->Mleave->getLeaveTypes($_POST['leave_type']);
            if ($posted_leavetype[0]['no_restrictions'] == 1 && ($time != '' && $time > 8.30)) {
                $this->session->set_flashdata('errorMsg', "You can't apply " . strtotime($posted_leavetype[0]['leave_type_name']) . " for today");
                redirect('leave/apply_leave');
            } else {

                $req_length = 0;
                foreach ($dates_array as $ldates) {
                    $leavedetails['leave_date'] = date('Y-m-d', strtotime($ldates));
                    /* check with holiday details */
                    $chk_holidays = $this->Mleave->checkHolidays($ldates);
                    $chk_workingdays = $this->Mleave->checkWorkingdays($ldates);
                    // print_r($chk_holidays);

                    /* check with holiday details */
                    $days = date('l', strtotime($ldates));
                    $chk_weekends = $this->Mleave->checkWeekends($days);
                    if (count($chk_weekends) > 0) {
                        if($leavetypec=='LTY014'){

            $leavedetails['leave_length_days'] = $length = 1;
            $leavedetails['leave_status'] = 0;
            }else{
                $leavedetails['leave_length_days'] = $length = 0;
                        $leavedetails['leave_status'] = 4;

            }
                        
                    } else {
                        $leavedetails['leave_length_days'] = $length = 1;
                        $leavedetails['leave_status'] = 0;
                    }

                    if ($length == 1) {
                        if (count($chk_holidays) > 0) {
                            $leavedetails['leave_length_days'] = $length = 0;
                            $leavedetails['leave_status'] = 4;
                        } else {
                            $leavedetails['leave_length_days'] = $length = 1;
                            $leavedetails['leave_status'] = 0;
                        }
                    }

                    if (count($chk_workingdays) > 0) {
                        $leavedetails['leave_length_days'] = $length = 1;
                        $leavedetails['leave_status'] = 0;
                    }


                    // $leavedetails['leave_length_days'] = $length = count($leave_len_days);
                    if ($leave_length == 1 || $leavetypec=='LTY014') {
                        $leavedetails['leave_length_hours'] = 24.0 * $length;
                    }else {
                        $leavedetails['leave_length_days'] = $length = $leavedetails['leave_length_days'] / 2;
                        $leavedetails['leave_length_hours'] = 12.0;
                    }
                    if ($leave_type_name == "Work From Home") {
                        $leavedetails['leave_status'] = 1;
                    }

                    $req_length += $length;
                    $hm_query = $this->Mleave->insertLeaveDetail('hr_leave', $leavedetails);
                }
                $requpdate['leave_length_days'] = $req_length;
                $option['id'] = $request_id;
                $hm_queryupdate = $this->Mleave->updateLeaveDetail('hr_leave_request', $option, $requpdate);

                if ($hm_queryupdate) {
                    $posted_supervisor = $this->Mleave->getSupervisor('', $this->session->userdata('emp_number'));
                    $posted_employee = $this->Mleave->getEmployeedetail($this->session->userdata('emp_number'));
                    $mail_startdate = date('d-m-Y', strtotime($fromdate));
                    $mail_enddate = date('d-m-Y', strtotime($todate));
                    $mail_comments = $_POST['comments'];
                    $mail_type = $posted_leavetype[0]['leave_type_name'];
                    $mail_employee = $posted_employee[0]['emp_firstname'] . ' ' . $posted_employee[0]['emp_lastname'];
                    // $this->Memail->send('aravind.p@claritaz.com', 'vivek.t@claritaz.com', 'testing subject', 'testing', '1', $attach = array(), 'apply@villgro.org');

                    $mail_config = partner_smtp();
                    $config = array(
                        'protocol' => $mail_config['protocol'],
                        'smtp_host' => $mail_config['smtp_host'],
                        'smtp_port' => $mail_config['smtp_port'],
                        'smtp_user' => $mail_config['smtp_user'],
                        'smtp_pass' => $mail_config['smtp_pass'],
                        'newline' => '\r\n',
                    );

                    $this->load->library('email', $config);
                    $this->email->clear(true);
                    $this->email->set_newline("\r\n");
                    $this->email->from($mail_config['smtp_user'], $mail_config['smtp_subject']);

                    if ($posted_leavetype[0]['no_restrictions'] == 1) {
                        $mail_subject = ucfirst($mail_type) . " request from Employee";
                    } else {
                        $mail_subject = ucfirst($mail_type) . " Leave from Employee";
                    }
                    foreach ($posted_supervisor as $reportto) {
                        $reportto_name[] = $reportto['emp_firstname'] . ' ' . $reportto['emp_lastname'];
                        $tomails[] = $reportto['emp_work_email'];
                    }

                    if ($leave_type_name == "Work From Home") {
                        $reportto_name[] = "Vijitha Panikkar";
                       $tomails[] = "vijitha@villgro.org";
//                        $tomails[] = "hr@villgro.org";
                       // $tomails[] = "aravindhan.p@claritaz.com";

                   /*$new_allocate['year'] = $year;
                     $new_allocate['employee_id'] = $emp_id;
                     $new_allocate['leave_type_id'] = $emptype;
                     $new_allocate['partner_id'] = $partner_id;
                     */
                   $leavequota['leave_taken'] = $leave_taken+1+$req_length;
                    $option1['year'] = $year;
                    $option1['employee_id'] = $emp_id;
                    $option1['leave_type_id'] = $emptype;
                    $hm_query1 = $this->Mleave->updateLeaveQuota('hr_leave_quota', $option1, $leavequota);

                    }else{
						//UPDATE LEAVE TAKEN 
							$leavequotaS['leave_taken'] = $leave_taken+$req_length;
							$conditions['year'] = $year;
							$conditions['employee_id'] = $emp_id;
							$conditions['leave_type_id'] = $emptype;
							$this->Mleave->updateLeaveQuota('hr_leave_quota', $conditions, $leavequotaS);  
						//UPDATE LEAVE TAKEN 
					}


                    $reporting = implode(', ', $reportto_name);
                    array_push($reportto_name, $mail_employee);
                    array_push($tomails, $posted_employee[0]['official_email']);
                    $mi = 0;

                    foreach ($tomails as $mails) {
                        if ($mails != '') {
                            $mail_message = "<p>Hi " . $reportto_name[$mi] . ",</p><p>Following request has been raised<br/></p><p>From Employee: " . $mail_employee . "<br/> Reporting Manager: " . $reporting . "<br/> Request: " . $mail_type . "<br/> Start Date: " . $mail_startdate . "<br/> End Date: " . $mail_enddate . "<br/> Reason: " . $mail_comments . "<br/></p>
                            <p>Thanks,<br/>Villgro</p>";

                            $this->email->to($mails);
                            // $this->email->to('vivek.t@claritaz.com');
                            $this->email->subject($mail_subject);

                            $this->email->message($mail_message);

                            if ($this->email->send()) {
                                echo "mail sent successfully";
                            } else {
                                echo $this->email->print_debugger();
                            }
                            $mi++;
                        }
                    }

                    $this->session->set_flashdata('successMsg', "Leave request details saved successfully");
                    // redirect('leave/apply_leave');
                    redirect('leave/leave_list');
                } else {
                    $this->session->set_flashdata('errorMsg', 'Value Missing');
                    redirect('leave/apply_leave');
                }
            }
        } else {
            $this->session->set_flashdata('errorMsg', 'Your have already requested leave on the same day as the current leave request.');
            redirect('leave/apply_leave');
        }
    }else{
        $this->session->set_flashdata('errorMsg', 'Your remaining holiday leave is less than the current leave request.');
        redirect('leave/apply_leave');
    }

}

/* approve leave list view page */

public function approve_leave_list($formresult = '') {
    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
        $empid = $this->session->userdata['emp_number'];
        $data['chk_sup'] = $chk_sup = $this->Mleave->getSupervisor($empid);
        if (count($chk_sup) == 0) {
            redirect('leave/leave_list/');
        }
    }
    $partner_id = $this->session->userdata('partner_id');
    $data['formresult'] = isset($formresult) && $formresult != '' ? $formresult : '';
    $default_status = array(0);
    $data['filter_fromdate'] = $fromyear = (isset($_POST['filter_fromdate'])) ? $_POST['filter_fromdate'] : '01-01-' . date('Y');
    $data['filter_todate'] = $toyear = (isset($_POST['filter_todate'])) ? $_POST['filter_todate'] : '31-12-' . date('Y');
    $data['l_status'] = $l_status = isset($_POST['l_status']) ? $_POST['l_status'] : $default_status;
    $data['filter_partner'] = $filter_partner = isset($_POST['filter_partner']) ? $_POST['filter_partner'] : '';

        // $cond_arr[] = "t1.leave_startdate >= '" . date('Y') ."-01-01' and t1.leave_startdate <= '" . date('Y') . "-12-31'";

    $cond_arr[] = "t1.leave_status IN (0)";
    $cond_arr[] = "t2.partner_id = " . $partner_id;

    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            // $chk_sup = $this->Mleave->getSupervisor($empid);
        if (count($chk_sup) > 0) {
            $subs_id = array();
            foreach ($chk_sup as $sups) {
                $subs_id[] = $sups['erep_sub_emp_number'];
            }
            $sub_emp_id = implode(',', $subs_id);
            $cond_arr[] = "t2.id IN (" . $sub_emp_id . ")";
        }
    }
    $result_cond = implode(' and ', $cond_arr);

    $option['status'] = 1;
    $data['partner_types'] = $this->Mportfolio->getDetails('hr_partner_type', $option);

    $data['approval_count'] = $this->Mleave->getDTLeaveCount($result_cond);
    
    /* approval count */

    $data['an_approval_count'] = total_apppending_count();


    $this->load->vars($data);
    $this->load->view('leave/request/approve_leave_list');
}

/* approval functionality from leave approve page */

public function leavereq_approve() {

	//UPDATE LEAVE TAKEN STATUS//
	$pre_post_status = $_POST['status'];
	if(isset($_POST['status']) && $_POST['status']!=''){
		if($_POST['status']=='1'){
			$_POST['status']=2;
		}
	}	
	//UPDATE LEAVE TAKEN STATUS//
	
	//check leave request status is 2 to update taken leave
	$condition['id'] = $_POST['leave_id'];
	$get_leave_req = $this->Mleave->getLeaveCommonDetails('hr_leave_request', $condition); 
	$get_leave_request_satus = '';
	if(!empty($get_leave_req)){
		$get_leave_request_satus = $get_leave_req[0]['status'];
	}
    //echo "<pre>"; print_r($_POST);die;
    $leaveapprove['leave_status'] = $leavereq['status'] = $_POST['status'];
    $leaveapprove['leave_comments'] = $_POST['comments'];
    $leaveapprove['leave_approval_date'] = $leavereq['date_approval'] = date("Y-m-d");
    $option['id'] = $leaveoption['leave_request_id'] = $_POST['leave_id'];
    $leavereq['approved_by'] = $this->session->userdata['emp_number'];
    $hm_query = $this->Mleave->updateLeaveDetail('hr_leave_request', $option, $leavereq);
    if ($hm_query) {
        $hm_query1 = $this->Mleave->updateLeaveDetail('hr_leave', $leaveoption, $leaveapprove);
        /* email notification */
        if ($_POST['status'] != '') {
            $posted_employee = $this->Mleave->getLeavelistByreqid($_POST['leave_id']);
            $posted_supervisor = $this->Mleave->getSupervisor('', $posted_employee[0]['employee_id']);

            $mail_startdate = date('d-m-Y', strtotime($posted_employee[0]['leave_startdate']));
            $mail_enddate = date('d-m-Y', strtotime($posted_employee[0]['leave_enddate']));
            $mail_comments = $_POST['comments'];
            $mail_type = $posted_employee[0]['leave_type_name'];
            $mail_employee = $posted_employee[0]['emp_firstname'] . ' ' . $posted_employee[0]['emp_lastname'];
                // $this->Memail->send('aravind.p@claritaz.com', 'vivek.t@claritaz.com', 'testing subject', 'testing', '1', $attach = array(), 'apply@villgro.org');

            $mail_config = partner_smtp();
            $config = array(
                'protocol' => $mail_config['protocol'],
                'smtp_host' => $mail_config['smtp_host'],
                'smtp_port' => $mail_config['smtp_port'],
                'smtp_user' => $mail_config['smtp_user'],
                'smtp_pass' => $mail_config['smtp_pass'],
                'newline' => '\r\n',
            );

            $this->load->library('email', $config);
            $this->email->clear(true);
            $this->email->set_newline("\r\n");
            $this->email->from($mail_config['smtp_user'], $mail_config['smtp_subject']);


            if ($pre_post_status == 1) {
                if ($posted_employee[0]['no_restrictions'] == 1) {
                    $mail_subject = ucfirst($mail_type) . " request approved by RO";
                } else {
                    $mail_subject = ucfirst($mail_type) . " Leave approved by RO";
                }
                $following = "Following request has been approved";

                /* updating taken in leave quota */
                $today_date = date('d-m-Y');
                $curdate = strtotime($today_date);
                $le_date = strtotime($mail_startdate);

                if ($le_date <= $curdate) {
                   // if($mail_startdate <= $today_date){

                    $leaveapprovetk['leave_status'] = $leavereqtk['status'] = 2;
                    $optiontk['id'] = $leaveoptiontk['leave_request_id'] = $_POST['leave_id'];
                    $hm_querytk = $this->Mleave->updateLeaveDetail('hr_leave_request', $optiontk, $leavereqtk);

                    $hm_querytk = $this->Mleave->updateLeaveDetail('hr_leave', $leaveoptiontk, $leaveapprovetk);

                    $emp_leave_quota = $this->Mleave->getLeaveQuota($posted_employee[0]['employee_id'], $posted_employee[0]['year'], $posted_employee[0]['leave_type_id']);
					
					if($get_leave_request_satus =='2'){
						$leavequota['leave_taken'] = $emp_leave_quota[0]['leave_taken'] + $posted_employee[0]['leave_length_days'];
						$option1['year'] = $posted_employee[0]['year'];
						$option1['employee_id'] = $posted_employee[0]['employee_id'];
						$option1['leave_type_id'] = $posted_employee[0]['leave_type_id'];
						//$hm_query1 = $this->Mleave->updateLeaveQuota('hr_leave_quota', $option1, $leavequota);
					}
                }

                /* updating leave taken details ends */
            } else if ($_POST['status'] == 3) {
                if ($posted_employee[0]['leave_type_name'] == 1) {
                    $mail_subject = ucfirst($mail_type) . " request cancelled by RO";
                } else {
                    $mail_subject = ucfirst($mail_type) . " Leave cancelled by RO";
                }
                $following = "Following request has been cancelled";
            } else if($_POST['status'] == 4){

                if ($posted_employee[0]['leave_type_name'] == 1) {
                    $mail_subject = ucfirst($mail_type) . " request cancelled by RO";
                } else {
                    $mail_subject = ucfirst($mail_type) . " Leave cancelled by RO";
                }
                $following = "Following request has been cancelled";

                $leaveapprovetk['leave_status'] = $leavereqtk['status'] = 2;
                $optiontk['id'] = $leaveoptiontk['leave_request_id'] = $_POST['leave_id'];
                       // $hm_querytk = $this->Mleave->updateLeaveDetail('hr_leave_request', $optiontk, $leavereqtk);

                       // $hm_querytk = $this->Mleave->updateLeaveDetail('hr_leave', $leaveoptiontk, $leaveapprovetk);

                $emp_leave_quota = $this->Mleave->getLeaveQuota($posted_employee[0]['employee_id'], $posted_employee[0]['year'], $posted_employee[0]['leave_type_id']);
                $leavequota['leave_taken'] = $emp_leave_quota[0]['leave_taken'] - $posted_employee[0]['leave_count'];
                $option1['year'] = $posted_employee[0]['year'];
                $option1['employee_id'] = $posted_employee[0]['employee_id'];
                $option1['leave_type_id'] = $posted_employee[0]['leave_type_id'];
                //$hm_query1 = $this->Mleave->updateLeaveQuota('hr_leave_quota', $option1, $leavequota);
				
				//UPDATE LEAVE TAKEN//
				if(isset($_POST['status']) && $_POST['status']!=''){
					if($_POST['status']=='4'){
						$posted_employee = $this->Mleave->getLeavelistByreqid($_POST['leave_id']);
						$leave_count_days =  $posted_employee[0]['leave_count'];
						if($posted_employee[0]['employee_id']!='' && $posted_employee[0]['year']!='' && $posted_employee[0]['leave_type_id']!=''){
							$emp_leave_quota = $this->Mleave->getLeaveQuota($posted_employee[0]['employee_id'], $posted_employee[0]['year'], $posted_employee[0]['leave_type_id']);
							$leave_taken = $emp_leave_quota[0]['leave_taken'];
							$set_leaveTaken = 0;
							if($leave_count_days <= $leave_taken){
								$set_leaveTaken = $leave_taken-$leave_count_days;
							}
						
							$leavequota['leave_taken'] = $set_leaveTaken;
							$option1['year'] = $posted_employee[0]['year'];
							$option1['employee_id'] = $posted_employee[0]['employee_id'];
							$option1['leave_type_id'] = $posted_employee[0]['leave_type_id'];
							$this->Mleave->updateLeaveQuota('hr_leave_quota', $option1, $leavequota);
						
						}
					}
				}
				//UPDATE LEAVE TAKEN//
				
            }

            foreach ($posted_supervisor as $reportto) {
                $reportto_name[] = $reportto['emp_firstname'] . ' ' . $reportto['emp_lastname'];
            }
            $reporting = implode(',', $reportto_name);
            $mail_message = "<p>Hi " . $mail_employee . ",</p><p>" . $following . "<br/></p><p>From Employee: " . $mail_employee . "<br/> Reporting Manager: " . $reporting . "<br/> Request: " . $mail_type . "<br/> Start Date: " . $mail_startdate . "<br/> End Date: " . $mail_enddate . "<br/> Reason: " . $mail_comments . "<br/></p>
            <p>Thanks,<br/>Villgro</p>";

            $this->email->to($posted_employee[0]['emp_work_email']);
                // $this->email->to('vivek.t@claritaz.com');
            $this->email->subject($mail_subject);

            $this->email->message($mail_message);

            $this->email->send();
        }
        /* end email notification */

        $this->session->set_flashdata('successMsg', 'Leave status changed successfully');
        echo '1';
    } else {
        $this->session->set_flashdata('errorMsg', 'Value Missing');
        echo '0';
    }
}

public function leave_approve() {
    $leaveapprove['leave_status'] = $leavereq['status'] = $_POST['status'];
    $leaveapprove['leave_comments'] = $_POST['comments'];
    $leaveapprove['leave_approval_date'] = $leavereq['date_approval'] = date("Y-m-d");
    $option['id'] = $_POST['leave_id'];
    $hm_query1 = $this->Mleave->updateLeaveDetail('hr_leave', $option, $leaveapprove);
    if ($hm_query) {

        echo '1';
    } else {
        echo '0';
    }
}

/* leave summary view page */

public function leave_summary($formresult = '') {
    $data['formresult'] = isset($formresult) && $formresult != '' ? $formresult : '';
    $partner_id = $option['partner_id'] = $this->session->userdata('partner_id');
    $data['filter_year'] = $filter_year = (isset($_POST['filter_year'])) ? $_POST['filter_year'] : '';
    $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
    $data['user_types'] = $this->Mleave->getUserType();
    $data['leave_types'] = $this->Mleave->getLeaveTypes();
    $data['users_list'] = $this->Mleave->getUsers();

    if ($filter_year == '') {
        if (isset($data['fin_year'][0]['fin_year']) && $data['fin_year'][0]['fin_year'] != '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $data['current_fy'] = $fy['fin_year'];
                }
            }
        } else {
            $data['current_fy'] = date('Y');
        }
    } else {
        $data['current_fy'] = $filter_year;
    }
	if($this->session->userdata('user') == 135){
		#echo'<pre>';print_r($data['fin_year']);die;
	}
	
    $fromyear = '01-01-' . date('Y');
    $toyear = '31-12-' . date('Y');

    $cond_arr[] = "t1.leave_startdate >= '" . date('Y') . "-01-01' and t1.leave_startdate <= '" . date('Y') . "-12-31'";

    $cond_arr[] = "t1.leave_status IN (0)";
    $cond_arr[] = "t2.partner_id = " . $partner_id;
    $empid = $this->session->userdata['emp_number'];

    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
        $chk_sup = $this->Mleave->getSupervisor($empid);
        if (count($chk_sup) > 0) {
            $subs_id = array();
            foreach ($chk_sup as $sups) {
                $subs_id[] = $sups['erep_sub_emp_number'];
            }
            $sub_emp_id = implode(',', $subs_id);
            $cond_arr[] = "t2.id IN (" . $sub_emp_id . ")";
        }
    }

    $result_cond = implode(' and ', $cond_arr);
    $data['approval_count'] = $this->Mleave->getDTLeaveCount($result_cond);
    $data['chk_sup'] = $this->Mleave->getSupervisor($empid);
    $this->load->vars($data);
    $this->load->view('leave/request/leave_summary');
}

/* load employee names in leave summary filter */

public function load_employee() {
    $usertype = $this->input->post('usertype');
    if ($usertype == 'all') {
        $usercond = '';
    } else {
        $usercond = $usertype;
    }
    $userlist = $this->Mleave->getUsers('', $usercond);
    $useroption = '<option value="">Select Employee Name</option>';
    foreach ($userlist as $list) {
        $useroption .= '<option value=' . $list['employee_id'] . '>' . $list['emp_firstname'] . ' ' . $list['emp_lastname'] . '</option>';
    }

    echo $useroption;
}

/* fetching leave summary details for datatable serverside */

public function DTleavesummary() {
    $requestData = $_POST;
    $columns = array(
        0 => 'id',
        1 => 'emp_first_name',
        2 => 'emp_last_name'
    );

    $data['filter_year'] = $filter_year = (isset($_POST['filter_year']) && $_POST['filter_year'] != '') ? $_POST['filter_year'] : '';
    $data['filter_leavetype'] = $filter_leavetype = (isset($_POST['filter_leavetype']) && $_POST['filter_leavetype'] != '') ? $_POST['filter_leavetype'] : '';
    $filter_usertype = isset($_POST['filter_usertype']) ? $_POST['filter_usertype'] : '';
    $filter_empname = isset($_POST['filter_empname']) ? $_POST['filter_empname'] : '';

    if ($filter_year != '') {
        $cond_arr[] = "year = '" . $filter_year . "'";
    } else {
        $cond_arr[] = "year = '" . date('Y') . "'";
    }

    if ($filter_leavetype != '' && $filter_leavetype != 'all') {
        $cond_arr[] = "t1.leave_type_id = '" . $filter_leavetype . "'";
        $l_types = $this->Mleave->getLeaveTypes($filter_leavetype);
    } else {
        $l_types = $this->Mleave->getLeaveTypes();
    }

   // print_r($l_types);die;

    if ($filter_usertype != '' && $filter_usertype != 'all') {
        $user_cond[] = "emp_type = '" . $filter_usertype . "'";
        if ($filter_empname != '') {
            $user_cond[] = "id ='" . $filter_empname . "'";
        }
    } else {
        if ($filter_empname != '') {
            $user_cond[] = "id ='" . $filter_empname . "'";
        }
    }

    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
        $empid = $this->session->userdata['emp_number'];
        $user_cond[] = "id = '" . $empid . "'";
    }

    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner = $this->session->userdata('partner_id');
        $cond_arr[] = "t2.partner_id = '" . $partner . "'";
        $user_cond[] = "partner_id = '" . $partner . "'";
    }
    $cond_arr[] = $user_cond[] = "status = '1'";

    $result_quota = implode(' and ', $cond_arr);
    $result_user = implode(' and ', $user_cond);

    $totalrows = $this->Mleave->getDTuserDetails('', '', $result_user, $columns, $requestData);
    $query = $this->Mleave->getDTuserDetails($requestData['length'], $requestData['start'], $result_user, $columns, $requestData);

    //echo "<pre>";print_r($query);die;

    $totalFiltered = count($totalrows);
    $totalData = count($query);
    $data = array();

    $get_lastQuota = $this->Mleave->getLastQuotaID();
    $i = $requestData['start'] + 1;
    $j = $get_lastQuota + 1;

    foreach ($query as $row) {
        foreach ($l_types as $leave) {
            $quota_result = $result_quota . " and t1.leave_type_id = '" . $leave['leave_type_id'] . "'";
            $get_existQuota = $this->Mleave->getUserQuotaDetails($quota_result, $row['id']);
            if (count($get_existQuota) > 0) {
                $schd_arr = array();
                $schd_curdate = date('Y-m-d');
                $schd_arr[] = "employee_id = '" . $get_existQuota[0]['employee_id'] . "'";
                $schd_arr[] = "leave_startdate >= '" . $schd_curdate . "'";
                $schd_arr[] = "leave_type_id = '" . $get_existQuota[0]['leave_type_id'] . "'";
                $schd_cond = implode(' and ', $schd_arr);
                $check_leave_schd = $this->Mleave->checkscheduledLeave($schd_cond);
                $leave_remaining = ($get_existQuota[0]['no_of_days_allotted'] + $get_existQuota[0]['leave_brought_forward']) - ($get_existQuota[0]['leave_taken'] + $get_existQuota[0]['leave_encashed']);
                $nestedData = array();
                if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
                    $nestedData[] = $row['emp_firstname'] . ' ' . $row['emp_lastname'] . '<input type="hidden" id="leave_employee_' . $get_existQuota[0]['id'] . '" value="' . $row['id'] . '">';
                }
                $nestedData[] = $get_existQuota[0]['leave_type_name'] . '<input type="hidden" id="leave_type_' . $get_existQuota[0]['id'] . '" value="' . $get_existQuota[0]['leave_type_id'] . '">';
                $nestedData[] = '<input class="form-control leave_decimal" name="leave_entitled" id="leave_entitled_' . $get_existQuota[0]['id'] . '" type="text" value="' . $get_existQuota[0]['no_of_days_allotted'] . '"  onclick="save_summary(' . $get_existQuota[0]['id'] . ')" disabled>';
                $nestedData[] = $check_leave_schd[0]['scheduled'];
                $nestedData[] = $get_existQuota[0]['leave_taken'];
                $nestedData[] = '<input class="form-control leave_decimal" name="leave_brought_forward" id="leave_brought_forward_' . $get_existQuota[0]['id'] . '" type="text" value="' . $get_existQuota[0]['leave_brought_forward'] . '" onclick="save_summary(' . $get_existQuota[0]['id'] . ')" disabled>';
                $nestedData[] = '<input class="form-control leave_decimal" name="leave_encashed" id="leave_encashed_' . $get_existQuota[0]['id'] . '" type="text" value="' . $get_existQuota[0]['leave_encashed'] . '"  onclick="save_summary(' . $get_existQuota[0]['id'] . ')" disabled>';
                if ($get_existQuota[0]['no_restrictions'] == 1) {
                    $nestedData[] = '0';
                } else {
                    $nestedData[] = $leave_remaining;
                }
                $nestedData[] = '<input class="form-control commonAlphaNum" name="leave_summary_comments" id="leave_summary_comments_' . $get_existQuota[0]['id'] . '" type="text" value="' . $get_existQuota[0]['comments'] . '" onclick="save_summary(' . $get_existQuota[0]['id'] . ')" disabled="disabled">';
                $data[] = $nestedData;
                $i++;
            } else {
                $nestedData = array();
                if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
                    $nestedData[] = $row['emp_firstname'] . ' ' . $row['emp_lastname'] . '<input type="hidden" id="leave_employee_' . $j . '" value="' . $row['id'] . '">';
                }
                $nestedData[] = $leave['leave_type_name'] . '<input type="hidden" id="leave_type_' . $j . '" value="' . $leave['leave_type_id'] . '">';
                $nestedData[] = '<input class="form-control leave_decimal" name="leave_entitled" id="leave_entitled_' . $j . '" type="text" value="0.0"  onclick="save_summary(' . $j . ')" disabled>';
                $nestedData[] = '';
                $nestedData[] = '0.0';
                $nestedData[] = '<input class="form-control leave_decimal" name="leave_brought_forward" id="leave_brought_forward_' . $j . '" type="text" value="0.0" onclick="save_summary(' . $j . ')" disabled>';
                $nestedData[] = '<input class="form-control leave_decimal" name="leave_encashed" id="leave_encashed_' . $j . '" type="text" value="0.0"  onclick="save_summary(' . $j . ')" disabled>';
                $nestedData[] = '0';
                $nestedData[] = '<input class="form-control commonAlphaNum" name="leave_summary_comments" id="leave_summary_comments_' . $j . '" type="text" value="" onclick="save_summary(' . $j . ')" disabled="disabled">';
                $data[] = $nestedData;
                $j++;
            }
        }
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}

/* leave summary edited details insertion */

public function add_leave_summary() {
    $new_allocate['year'] = $_POST['leave_year'];
    $new_allocate['employee_id'] = $_POST['leave_employee'];
    $new_allocate['leave_type_id'] = $_POST['leave_type'];
    $new_allocate['partner_id'] = $this->session->userdata('partner_id');
    $new_allocate['no_of_days_allotted'] = $leavesummary['no_of_days_allotted'] = $_POST['leave_entitled'];
    $new_allocate['comments'] = $leavesummary['comments'] = $_POST['leave_summary_comments'];
    $new_allocate['leave_brought_forward'] = $leavesummary['leave_brought_forward'] = $_POST['leave_brought_forward'];
    $new_allocate['leave_encashed'] = $leavesummary['leave_encashed'] = $_POST['leave_encashed'];
    $new_allocate['created_date'] = date('Y-m-d H:i:s');

    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner = $this->session->userdata('partner_id');
        $option['partner_id'] = $partner;
    }
    $option['id'] = $_POST['leave_summary_id'];
    $check_exist = $this->Mleave->getLeaveCommonDetails('hr_leave_quota', $option);
    if (isset($check_exist) && $check_exist[0]['id'] != '') {
        $hm_query = $this->Mleave->updateLeaveDetail('hr_leave_quota', $option, $leavesummary);
    } else {
        $hm_query = $this->Mleave->insertLeaveDetail('hr_leave_quota', $new_allocate);
    }

    if ($hm_query) {
        $this->session->set_flashdata('successMsg', 'Leave details saved successfully');
        echo '1';
    } else {
        $this->session->set_flashdata('errorMsg', 'Value Missing');
        echo '0';
    }
}

/* Request section ends here */

/* Master section starts */

/* Holiday list for current year */

public function current_holiday_calendar() {
    $year = date('Y');
    $data['holiday_detail'] = $this->Mleave->getHolidayDetails($year);

    $data['partner_id'] = $this->session->userdata('partner_id');
    $this->load->vars($data);
    $this->load->view('leave/current_holiday_calendar');
}

/* copy holiday data to other partners */

public function copy_holiday() {
    $option['status'] = 1;
    $option['partner_id'] = 1;
    $holiday_list = $this->Mleave->getLeaveCommonDetails('hr_holidays', $option, 'asc', 'holiday_name');
    foreach ($holiday_list as $holi) {
        $data['partner_id'] = $this->session->userdata['partner_id'];
        $data['holiday_name'] = $holi['holiday_name'];
        $data['date'] = $holi['date'];
        $data['repeat_annually'] = $holi['repeat_annually'];
        $data['length'] = $holi['length'];
        $data['created_by'] = $this->session->userdata['user_id'];
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['status'] = 1;
        $query = $this->Mportfolio->insertPortfolioDetail('hr_holidays', $data);
    }
    if ($query) {
        $this->session->set_flashdata('successMsg', "Master data copied successfully");
    } else {
        $this->session->set_flashdata('errorMsg', 'Value Missing');
    }
    redirect('leave/current_holiday_calendar');
}

/* add holiday form page */

public function add_holiday($holiday_id = '') {
    if ($holiday_id != '') {
        $data['holiday_detail'] = $this->Mleave->getHolidayDetails('', $holiday_id);
        $this->load->vars($data);
    }
    $this->load->view('leave/add_holiday');
}

/* insert holiday details to db */

public function addHolidays() {

   
    for ($i = 0; $i < count($_POST['holiday_name']); $i++) {
        if ($_POST['holiday_name'][$i] != '') {
            $option['id'] = $_POST['holiday_edit_id'][$i];
            $holidaydata['holiday_name'] = $_POST['holiday_name'][$i];
            $holidaydata['date'] = $_POST['holiday_date'][$i] != '' ? date('Y-m-d', strtotime($_POST['holiday_date'][$i])) : '';
            $holidaydata['repeat_annually'] = $_POST['holiday_repeat'][$i];
            $holidaydata['length'] = $_POST['holiday_type'][$i];

            $holidaydata['partner_id'] = $this->session->userdata['partner_id'];
            $holidaydata['status'] = 1;
                // $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';

            $checkExist = $this->Mportfolio->getDetails('hr_holidays', $option);
            if (count($checkExist) > 0) {
                $holidaydata['updated_by'] = $this->session->userdata('emp_number');
                $hm_query = $this->Mleave->updateLeaveDetail('hr_holidays', $option, $holidaydata);
            } else {
                 $existing_date_check = $this->Mleave->getholidaybydate($holidaydata['date']);
                 if(count($existing_date_check)>0){
                
                 $this->session->set_flashdata('errorMsg', "Mentioned date is already added in holiday list.");

                 redirect('leave/current_holiday_calendar');

                 }else{

                $holidaydata['created_by'] = $this->session->userdata('emp_number');
                $holidaydata['created_at'] = date("Y-m-d H:i:s");
                $hm_query = $this->Mleave->insertLeaveDetail('hr_holidays', $holidaydata);
                 }

               //echo "<pre>";  print_r($existing_date_check);die;
                
            }
        }
    }

    if ($hm_query) {

        $this->session->set_flashdata('successMsg', "Holiday details saved successfully");
    } else {
        $this->session->set_flashdata('errorMsg', 'Value Missing');
    }

    if (!isset($_POST['postype'])) {
        if ($edit_id != '') {
            redirect('leave/add_holiday/' . $edit_id);
        } else {
            redirect('leave/current_holiday_calendar');
        }
    } else {

        if ($hm_query) {
            echo '1';
        } else {
            echo '0';
        }
    }
}

/* fetching holiday details for datatable serverside */

public function DTholiday() {

    $requestData = $_POST;

    $columns = array(
        0 => 'id',
        1 => 'holiday_name',
        2 => 'date',
        3 => 'length',
        4 => 'repeat_annually'
    );


    $data['year'] = $year = (isset($_POST['year'])) ? $_POST['year'] : date('Y');


    $totalrows = $this->Mleave->getDTHolidayCount($year, $columns, $requestData);
    $query = $this->Mleave->getDTHolidayDetails($requestData['length'], $requestData['start'], $year, $columns, $requestData);

    $totalFiltered = $totalrows;
    $totalData = count($query);
    $data = array();
    $i = $requestData['start'] + 1;
    foreach ($query as $row) {
        $nestedData = array();
        $len_selected = $len_selected2 = $len_selected3 = $rep_selected = $rep_selected2 = '';
        if ($row['length'] == 1) {
            $len_selected = 'selected';
        } else if ($row['length'] == 2) {
            $len_selected2 = 'selected';
        }
        else if ($row['length'] == 3) {
            $len_selected3 = 'selected';
        }

        if ($row['repeat_annually'] == 1) {
            $rep_selected = 'selected';
        } else if ($row['repeat_annually'] == 2) {
            $rep_selected2 = 'selected';
        }

        $nestedData[] = "<input type='hidden' name='holiday_edit_id[]' id='holiday_edit_id_" . $i . "' value='" . $row['id'] . "'><input class='form-control holi_check' type='checkbox'  name='holidays_check' id='holidays_check_" . $i . "' onchange='deleteids(this.value);' value='" . $i . "' >";

        $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['id'] . ' opacity5 none-pointer" name="holiday_name[]" id="holiday_name_' . $i . '" readonly value="' . $row['holiday_name'] . '" placeholder="Enter name" />';
        $nestedData[] = '<div class="position-relative"><input type="text" name="holiday_date[]" id="holiday_date_' . $i . '" readonly="" class="form-control holiday_date inline_field_' . $row['id'] . ' opacity5 none-pointer" value="' . date('d-m-Y', strtotime($row['date'])) . '" placeholder="dd-mm-yyyy" /><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div>';
        $nestedData[] = '<select class="form-control inline_field_' . $row['id'] . ' opacity5 none-pointer" name="holiday_type[]" id="holiday_type_' . $i . '" readonly >
        <option value="">--Select--</option>
        <option value="1" ' . $len_selected . '>Full Day</option>
        <option value="2" ' . $len_selected2 . '>Half Day</option>
        <option value="3" ' . $len_selected3 . '>Optional Holiday</option>
        </select>';
        $nestedData[] = '<select class="form-control inline_field_' . $row['id'] . ' opacity5 none-pointer" name="holiday_repeat[]" id="holiday_repeat_' . $i . '" readonly >
        <option value="">--Select--</option>
        <option value="1" ' . $rep_selected . '>Yes</option>
        <option value="2" ' . $rep_selected2 . '>No</option>
        </select>';

        $data[] = $nestedData;
        $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}

/* fetching holiday details for datatable serverside */

public function DTholidayarchieve() {

    $requestData = $_POST;

    $columns = array(
        0 => 'holiday_name',
        1 => 'date',
        2 => 'repeat_annually',
        3 => 'length'
    );


    $data['year'] = $year = (isset($_POST['year'])) ? $_POST['year'] : date('Y');


    $totalrows = $this->Mleave->getDTHolidayCount($year, $columns, $requestData);
    $query = $this->Mleave->getDTHolidayDetails($requestData['length'], $requestData['start'], $year, $columns, $requestData);

    $totalFiltered = $totalrows;
    $totalData = count($query);
    $data = array();
    $i = $requestData['start'] + 1;
    foreach ($query as $row) {
        $nestedData = array();
        $len_selected = $len_selected2 = $rep_selected = $rep_selected2 = '';
        if ($row['length'] == 1) {
            $length_day = 'Full Day';
        } else if ($row['length'] == 2) {
            $length_day = 'Half Day';
        }

        if ($row['repeat_annually'] == 1) {
            $rep_annual = 'Yes';
        } else if ($row['repeat_annually'] == 2) {
            $rep_annual = 'No';
        }


        $nestedData[] = $row['holiday_name'];
        $nestedData[] = isset($row['date']) && $row['date'] != '' ? date('d-m-Y', strtotime($row['date'])) : '';
        $nestedData[] = $length_day;
        $nestedData[] = $rep_annual;

        $data[] = $nestedData;
        $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}

/* delete particular holiday detail */

public function deleteLeave() {
    $id = $_POST['id'];
    $condition = explode(',', $id);
    $ids = implode(',', $condition);
        // $condition = "'" . implode("', '", $id) . "'";
    $trimmed_ids = ltrim($ids, ',');
    $table = $_POST['table'];
    $query = $this->Mleave->deleteHolidayDetail($table, $trimmed_ids);

    if ($query) {
        echo '1';
        $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
    } else {
        echo '0';
    }
}

/* holiday list archieve (previous years) by filter */

public function archive_holiday_calendar() {
    $partner_id = $option['partner_id'] = $this->session->userdata('partner_id');
    $data['filter_year'] = $filter_year = (isset($_POST['filter_year'])) ? $_POST['filter_year'] : '';
    $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);

    if ($filter_year == '') {
        if (isset($data['fin_year'][0]['fin_year']) && $data['fin_year'][0]['fin_year'] != '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $data['current_fy'] = $fy['fin_year'];
                }
            }
        } else {
            $data['current_fy'] = date('Y');
        }
    } else {
        $data['current_fy'] = $filter_year;
    }
    $this->load->vars($data);
    $this->load->view('leave/archive_holiday_calendar');
}

/* view calendar page  */

public function view_calendar() {
    $year = date('Y');
    $data['weekdays'] = $this->Mleave->getWeekDays($year);
    $data['holiday_detail'] = $this->Mleave->getHolidayDetails($year);
    $this->load->vars($data);
    $this->load->view('leave/view_calendar');
}

/* working days listing page */

public function working_days() {
    $data['working_days'] = $this->Mleave->getWorkingDays();
    $this->load->vars($data);
    $this->load->view('leave/working_days');
}

/* add working days form */

public function add_working_days($id) {
    $data['page'] = 'working days';
    if ($id != '') {
        $data['working_days'] = $this->Mleave->getWorkingDays($id);
    }
    $this->load->vars($data);
    $this->load->view('leave/add_working_days');
}

/* fetching holiday details for datatable serverside */

public function DTworkingday() {

    $requestData = $_POST;

    $columns = array(
        0 => 'id',
        1 => 'workingday_name',
        2 => 'date',
        3 => 'length'
    );


    $data['year'] = $year = (isset($_POST['year'])) ? $_POST['year'] : date('Y');


    $totalrows = $this->Mleave->getDTWorkingCount($year, $columns, $requestData);
    $query = $this->Mleave->getDTWorkingdayDetails($requestData['length'], $requestData['start'], $year, $columns, $requestData);

    $totalFiltered = $totalrows;
    $totalData = count($query);
    $data = array();
    $i = $requestData['start'] + 1;
    foreach ($query as $row) {
        $nestedData = array();
        $len_selected = $len_selected2 = $rep_selected = $rep_selected2 = '';
        if ($row['length'] == 1) {
            $len_selected = 'selected';
        } else if ($row['length'] == 2) {
            $len_selected2 = 'selected';
        }


        $nestedData[] = "<input type='hidden' name='workingday_edit_id[]' id='workingday_edit_id_" . $i . "' value='" . $row['id'] . "'><input class='form-control typecheck' type='checkbox'  name='working_days_check' id='working_days_check_" . $i . "' onchange='deleteids(this.value);' value='" . $i . "' >";

        $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['id'] . ' opacity5 none-pointer" name="working_days_name[]" id="working_days_name_' . $i . '" readonly value="' . $row['workingday_name'] . '" placeholder="Enter name" />';
        $nestedData[] = '<div class="position-relative"><input type="text" name="working_date[]" id="working_date_' . $i . '" readonly="" class="form-control working_date inline_field_' . $row['id'] . ' opacity5 none-pointer" value="' . date('d-m-Y', strtotime($row['date'])) . '" placeholder="dd-mm-yyyy" /><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div>';
        $nestedData[] = '<select class="form-control inline_field_' . $row['id'] . ' opacity5 none-pointer" name="working_day_type[]" id="working_day_type_' . $i . '" readonly >
        <option value="">--Select--</option>
        <option value="1" ' . $len_selected . '>Full Day</option>
        <option value="2" ' . $len_selected2 . '>Half Day</option>
        </select>';

        $data[] = $nestedData;
        $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}

/* insert working days details to db */

public function addWorkingdays() {

    for ($i = 0; $i < count($_POST['working_days_name']); $i++) {
        $workingdaydata = array();
        if ($_POST['working_days_name'][$i] != '') {
            $option['id'] = $_POST['workingday_edit_id'][$i];
            $workingdaydata['workingday_name'] = $_POST['working_days_name'][$i];
            $workingdaydata['date'] = $_POST['working_date'][$i] != '' ? date('Y-m-d', strtotime($_POST['working_date'][$i])) : '';
            $workingdaydata['length'] = $_POST['working_day_type'][$i];
            $workingdaydata['status'] = 1;

            $checkExist = $this->Mportfolio->getDetails('hr_working_days', $option);
            if (count($checkExist) > 0) {
                $hm_query = $this->Mleave->updateLeaveDetail('hr_working_days', $option, $workingdaydata);
            } else {
                $workingdaydata['created_by'] = $this->session->userdata('emp_number');
                $workingdaydata['created_at'] = date("Y-m-d H:i:s");
                $hm_query = $this->Mleave->insertLeaveDetail('hr_working_days', $workingdaydata);
            }
        }
    }
    if ($hm_query) {

        $this->session->set_flashdata('successMsg', "Working day details saved successfully");
    } else {
        $this->session->set_flashdata('errorMsg', 'Value Missing');
    }

    if (!isset($_POST['postype'])) {
        redirect('leave/working_days');
    } else {
        if ($hm_query) {
            echo '1';
        } else {
            echo '0';
        }
    }
}

/* for week setup page */

public function week_setup() {
    $year = date('Y');
    $data['weekdays'] = $this->Mleave->getWeekDays($year);
    $this->load->vars($data);
    $this->load->view('leave/week_setup');
}

/* insert leave type details to db */

public function addWeekdays() {

    $weekdaydata['monday'] = $_POST['monday_values'];
    $weekdaydata['tuesday'] = $_POST['tuesday_values'];
    $weekdaydata['wednesday'] = $_POST['wednesday_values'];
    $weekdaydata['thursday'] = $_POST['thursday_values'];
    $weekdaydata['friday'] = $_POST['friday_values'];
    $weekdaydata['saturday'] = $_POST['saturday_values'];
    $weekdaydata['sunday'] = $_POST['sunday_values'];
    $weekdaydata['year'] = date('Y');
    $weekdaydata['created_by'] = $this->session->userdata('emp_number');
    $weekdaydata['created_at'] = date("Y-m-d H:i:s");
    $weekdaydata['status'] = 1;

    if ($_POST['edit_id'] != '') {
        $option['id'] = $_POST['edit_id'];
        $option['year'] = $_POST['edit_year'];
        $hm_query = $this->Mleave->updateLeaveDetail('hr_weekdays', $option, $weekdaydata);
    } else {
        $hm_query = $this->Mleave->insertLeaveDetail('hr_weekdays', $weekdaydata);
    }
    if ($hm_query) {

        $this->session->set_flashdata('successMsg', "Week setup details saved successfully");
    } else {
        $this->session->set_flashdata('errorMsg', 'Value Missing');
    }
    redirect('leave/week_setup');
}

/* leave type listing page */

public function leave_type() {
    $data['leave_types'] = $leavetypes = $this->Mleave->getLeaveTypes();

    $data['partner_id'] = $partner_id = $this->session->userdata('partner_id');
    $count_type = count($leavetypes);
    if ($count_type > 0) {
        $arr = $count_type - 1;
        $typename = $leavetypes[$arr]['leave_type_id'];
        $data['count_types'] = $count = substr($typename, 3);
        $count += 1;
        $data['code'] = 'LTY' . str_pad($count, 3, '0', STR_PAD_LEFT);
    } else {
        $data['count_types'] = 1;
        $data['code'] = 'LTY001';
    }

    /* for restriction */
    $norest_options['partner_id'] = $partner_id;
    $norest_options['no_restrictions'] = 1;
    $restriction_list = $this->Mportfolio->getDetails('hr_leave_type', $norest_options);
    foreach ($restriction_list as $rests) {
        $restrict[] = $rests['leave_type_id'];
    }
    $data['restrictids'] = implode(',', $restrict);
    $this->load->vars($data);
    $this->load->view('leave/leave_type');
}

public function DTLeavetype() {
    $requestData = $_POST;

    $columns = array(
        0 => 'id',
        1 => 'leave_type_id',
        2 => 'leave_type_name'
    );
    $leavetypes = $this->Mleave->getLeaveTypes();

    $count_type = count($leavetypes);
    if ($count_type > 0) {
        $arr = $count_type - 1;
        $typename = $leavetypes[$arr]['leave_type_id'];
        $count = substr($typename, 3);
        $count += 1;
        $code = 'LTY' . str_pad($count, 3, '0', STR_PAD_LEFT);
    } else {
        $code = 'LTY001';
    }

    $totalrows = $this->Mleave->getDTLeavetypeCount('', $columns, $requestData);
    $query = $this->Mleave->getDTLeavetypeDetails($requestData['length'], $requestData['start'], '', $columns, $requestData);
    $totalFiltered = $totalrows;
    $totalData = count($query);
    $data = array();
    $i = $requestData['start'] + 1;
    foreach ($query as $row) {
        if ($row['no_restrictions'] == 1) {
            $checked_type = 'checked';
        } else {
            $checked_type = '';
        }
        $nestedData = array();

        $nestedData[] = '<input type="hidden" name="leavetype_edit_id[]" id="leavetype_edit_id_' . $i . '" value="' . $row['id'] . '"><input class="form-control typecheck" type="checkbox" name="leave_type_check[]" id="leave_type_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
        $nestedData[] = '<input type="text" class="form-control opacity5 none-pointer " name="leave_type_id[]" id="leave_type_id_' . $i . '" readonly value="' . $row['leave_type_id'] . '" placeholder="Enter type id" />';
        $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['id'] . '" name="leave_type_name[]" id="leave_type_name_' . $i . '" readonly placeholder="Enter name" value="' . $row['leave_type_name'] . '"/>';
        $nestedData[] = '<input class="form-control check_field_' . $row['id'] . '" type="checkbox" ' . $checked_type . '   name="leave_restrictions[]" id="leave_restrictions_' . $i . '" readonly disabled onchange="check_restrict(' . $i . ');" value="' . $row['leave_type_id'] . '">';

        $nestedData[] = '';

        $data[] = $nestedData;
        $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}

/* leave type form page */

public function add_leave_type($id) {
    $data['page'] = 'leave type';
    if ($id != '') {
        $data['leave_types'] = $this->Mleave->getLeaveTypes('', $id);
    }
    $this->load->vars($data);
    $this->load->view('leave/add_leave_type');
}

/* insert leave type details to db */

public function addLeavetype() {
    $partner_id = $this->session->userdata('partner_id');
    if ($_POST['leave_type_name'][0] != '') {
        for ($i = 0; $i < count($_POST['leave_type_name']); $i++) {
            $leavedata = array();


            $option['id'] = $_POST['leavetype_edit_id'][$i];
            $leavedata['leave_type_id'] = $leave_type_id = $_POST['leave_type_id'][$i];
            $leavedata['leave_type_name'] = $_POST['leave_type_name'][$i];
            $leavedata['status'] = 1;

            $checkExist = $this->Mportfolio->getDetails('hr_leave_type', $option);
            if (count($checkExist) > 0) {
                $hm_query = $this->Mleave->updateLeaveDetail('hr_leave_type', $option, $leavedata);
            } else {
                $leavedata['partner_id'] = $partner_id;
                $leavedata['created_by'] = $this->session->userdata('emp_number');
                $leavedata['created_at'] = date("Y-m-d H:i:s");
                $hm_query = $this->Mleave->insertLeaveDetail('hr_leave_type', $leavedata);
                $ltype_id = $this->db->insert_id();
                $emp_data = "partner_id = " . $partner_id;
                if ($ltype_id != '') {
                    $emps_list = $this->Mleave->getEmployeedetail('', $emp_data);
                    foreach ($emps_list as $emps) {
                        $leavequota = array();
                        $leavequota['year'] = date('Y');
                        $leavequota['leave_type_id'] = $leave_type_id;
                        $leavequota['employee_id'] = $emps['employee_id'];
                        $leavequota['partner_id'] = $partner_id;
                        $leavequota['created_date'] = date("Y-m-d H:i:s");
                        $quota_query = $this->Mleave->insertLeaveDetail('hr_leave_quota', $leavequota);
                    }
                }
            }
        }


        if ($hm_query) {
            $leave_restrictions = isset($_POST['restrict_ids']) && $_POST['restrict_ids'] != '' ? explode(',', $_POST['restrict_ids']) : '';
            if ($leave_restrictions != '') {
                $norest_options['partner_id'] = $partner_id;

                $restriction_list = $this->Mportfolio->getDetails('hr_leave_type', $norest_options);
                foreach ($restriction_list as $restricts) {
                    if (in_array($restricts['leave_type_id'], $leave_restrictions)) {

                        $norest_data['no_restrictions'] = 1;
                    } else {
                        $norest_data['no_restrictions'] = 0;
                    }
                    $norest_options['id'] = $restricts['id'];

                    $hm3_query = $this->Mleave->updateLeaveDetail('hr_leave_type', $norest_options, $norest_data);
                }
            }

            $this->session->set_flashdata('successMsg', "Leave type details saved successfully");
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }
    }
    if (!isset($_POST['postype'])) {
        redirect('leave/leave_type');
    } else {
        if ($hm_query) {
            echo '1';
        } else {
            echo '0';
        }
    }
}

public function copy_leavetype() {
    $option['status'] = $type_option['status'] = 1;

    $option['partner_id'] = 1;
    $leavetype_list = $this->Mleave->getLeaveCommonDetails('hr_leave_type', $option, 'asc', 'leave_type_name');


    foreach ($leavetype_list as $leavelist) {
        $leave_typeid = $this->Mleave->getLeaveCommonDetails('hr_leave_type', $type_option, 'desc', 'id');
        $split_leavetype = substr($leave_typeid[0]['leave_type_id'], 3);
        $incre_typeid = $split_leavetype + 1;
        $digit_type = str_pad($incre_typeid, 3, '0', STR_PAD_LEFT);
        $typeids = 'LTY' . $digit_type;
        $data['partner_id'] = $this->session->userdata['partner_id'];
        $data['leave_type_id'] = $typeids;
        $data['leave_type_name'] = $leavelist['leave_type_name'];
        $data['created_by'] = $this->session->userdata['user_id'];
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['status'] = 1;
        $query = $this->Mportfolio->insertPortfolioDetail('hr_leave_type', $data);

        $ltype_id = $this->db->insert_id();
        if ($ltype_id != '') {
            $emps_list = $this->Mleave->getEmployeedetail('', $emp_data);
            foreach ($emps_list as $emps) {
                $leavequota = array();
                $leavequota['year'] = date('Y');
                $leavequota['leave_type_id'] = $typeids;
                $leavequota['employee_id'] = $emps['employee_id'];
                $leavequota['partner_id'] = $this->session->userdata['partner_id'];
                $leavequota['created_date'] = date("Y-m-d H:i:s");
                $quota_query = $this->Mleave->insertLeaveDetail('hr_leave_quota', $leavequota);
            }
        }
    }
    if ($query) {
        $this->session->set_flashdata('successMsg', "Master data copied successfully");
    } else {
        $this->session->set_flashdata('errorMsg', 'Value Missing');
    }
    redirect('leave/leave_type');
}

/* Leave listing export export */

function leave_export($fromdate, $todate, $multifilter, $page = '') {

    $this->load->library('Excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Vitals")
    ->setLastModifiedBy("Vitals")
    ->setTitle("Documents Leave List")
    ->setSubject("Documents Leave List")
    ->setDescription("Documents Leave List")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Documents Leave List");
    $currmonth = date('M');

    $partner_id = $this->session->userdata('partner_id');
    $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
    $f_year = date('Y');
    foreach ($data['fin_year'] as $fy) {
        if ($fy['status'] == 1) {
            $f_year = $fy['fin_year'];
        }
    }
    $from_year = $year;
    $to_year = $from_year;
    $nxt_year = $from_year + 1;
    $start_date = 'Apr, ' . $from_year;
    $end_date = 'Mar, ' . $nxt_year;


    $g_year = isset($year) && $year != '' ? $year : $f_year;

    $styletitle = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '000000'),
            'size' => 11,
            'name' => 'Times New Roman',
        )
    );


    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Data');


    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Leave Start Date');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Leave End Date');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Applied Date');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Approval Date');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Employee Name');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'No. Of Days');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Leave Type');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Leave Status');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Leave Comments');
    $objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->applyFromArray($styletitle);

    $data['from_date'] = $fromyear = (isset($fromdate) && $fromdate != '') ? date('Y-m-d', strtotime($fromdate)) : '';
    $data['to_date'] = $toyear = (isset($todate) && $todate != '') ? date('Y-m-d', strtotime($todate)) : '';
    $filter_status = isset($multifilter) ? $multifilter : '';

    $multi_status = explode('_', $filter_status);
    if (in_array(1, $multi_status)) {
        array_push($multi_status, 2);
    }
    $l_status = implode(',', $multi_status);

    if ($fromyear != '' && $toyear != '') {
        $cond_arr[] = "t1.leave_startdate >= '" . $fromyear . "' and t1.leave_startdate <= '" . $toyear . "'";
    } else if ($fromyear != '' && $toyear == '') {
        $cond_arr[] = "t1.leave_startdate >= '" . $fromyear . "'";
    }

    if ($l_status != '') {
        $cond_arr[] = "t1.leave_status IN (" . $l_status . ")";
    }

    if ($this->session->userdata['user_type'] != 'superadmin') {
        $cond_arr[] = "t2.partner_id = " . $partner_id;
    }
    /* check if user is supervisor or not */
    $empid = $this->session->userdata['emp_number'];
    $chk_sup = $this->Mleave->getSupervisor($empid);
    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
        if (!isset($page) || $page == '') {
            $cond_arr[] = "t2.id = '" . $empid . "'";
        } else if (isset($page) && $page != '') {
            if (count($chk_sup) > 0) {
                $subs_id = array();
                foreach ($chk_sup as $sups) {
                    $subs_id[] = $sups['erep_sub_emp_number'];
                }
                $sub_emp_id = implode(',', $subs_id);
                $cond_arr[] = "t2.id IN (" . $sub_emp_id . ")";
            }
        }
    }
    $result_cond = implode(' and ', $cond_arr);


    $query = $this->Mleave->getDTLeaveDetails('', '', $result_cond);

    $i = 2;
    foreach ($query as $list) {
        $leave_startdate = $list['leave_startdate'] != 0 ? date('d-M-y', strtotime($list['leave_startdate'])) : '--';
        $leave_enddate = $list['leave_enddate'] != 0 ? date('d-M-y', strtotime($list['leave_enddate'])) : '--';
        $leave_applieddate = $list['date_applied'] != 0 ? date('d-M-y', strtotime($list['date_applied'])) : '--';
        $leave_approvaldate = $list['date_approval'] != 0 ? date('d-M-y', strtotime($list['date_approval'])) : '--';
        $emp_name = $list['emp_firstname'] . ' ' . $list['emp_lastname'];

        if ($list['leave_status'] == 0) {
            $leave_status = 'Pending Approval';
        } else if ($list['leave_status'] == 1 || $list['leave_status'] == 2) {
            $leave_status = 'Approved';
        } else if ($list['leave_status'] == 4 || $list['leave_status'] == 3) {
            $leave_status = 'Cancelled';
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $leave_startdate);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $leave_enddate);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $leave_applieddate);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $leave_approvaldate);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $emp_name);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $list['leave_length_days']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $list['leave_type_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $leave_status);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $list['leave_comments']);
        $i++;
    }
        // if ($sector_id != 'all') {
        //     $sname = (str_replace(' ', '_', strtolower($sector_ct[0]['sector'])));
        // } else {
        //     $sname = 'Allsector';
        // }
    $file_name = preg_replace('/[^A-Za-z0-9\_]/', '', 'Leave summary') . '.xlsx';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file_name . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');

    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();

    $objWriter->save('php://output');
    exit;
}

/* Leave summary export */

function leavesummary_export($filter_year = '', $filter_leavetype = '', $filter_usertype = '', $filter_empname = '') {

    $this->load->library('Excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Vitals")
    ->setLastModifiedBy("Vitals")
    ->setTitle("Documents Leave List")
    ->setSubject("Documents Leave List")
    ->setDescription("Documents Leave List")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Documents Leave List");
    $currmonth = date('M');

    $partner_id = $this->session->userdata('partner_id');
    $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
    $f_year = date('Y');
    foreach ($data['fin_year'] as $fy) {
        if ($fy['status'] == 1) {
            $f_year = $fy['fin_year'];
        }
    }
    $from_year = $year;
    $to_year = $from_year;
    $nxt_year = $from_year + 1;
    $start_date = 'Apr, ' . $from_year;
    $end_date = 'Mar, ' . $nxt_year;


    $g_year = isset($year) && $year != '' ? $year : $f_year;

    $styletitle = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '000000'),
            'size' => 11,
            'name' => 'Times New Roman',
        )
    );


    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Data');


    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Employee Name');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Type');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Entitled');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Scheduled');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Taken');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Carry Forward');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Encashed');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Remaining');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Comments');
    $objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->applyFromArray($styletitle);


    $data['filter_year'] = (isset($filter_year) && $filter_year != '') ? $filter_year : '';
    $data['filter_leavetype'] = (isset($filter_leavetype) && $filter_leavetype != '') ? $filter_leavetype : '';
    $filter_usertype = isset($filter_usertype) ? $filter_usertype : '';
    $filter_empname = isset($filter_empname) ? $filter_empname : '';
        // $l_status = implode(',', $filter_status);

    if ($filter_year != '') {
        $cond_arr[] = "t1.year = '" . $filter_year . "'";
    } else {
        $cond_arr[] = "t1.year = '" . date('Y') . "'";
    }

    if ($filter_leavetype != '' && $filter_leavetype != 'all') {
        $cond_arr[] = "t1.leave_type_id = '" . $filter_leavetype . "'";
    }

    if ($filter_usertype != '' && $filter_usertype != 'all') {
        $cond_arr[] = "t3.emp_type = '" . $filter_usertype . "'";
        if ($filter_empname != '') {
            $cond_arr[] = "t3.id ='" . $filter_empname . "'";
        }
    } else {
        if ($filter_empname != '') {
            $cond_arr[] = "t3.id ='" . $filter_empname . "'";
        }
    }

    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
        $empid = $this->session->userdata['emp_number'];
        $cond_arr[] = "t3.id = '" . $empid . "'";
    }

    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner = $this->session->userdata('partner_id');
        $cond_arr[] = "t2.partner_id = '" . $partner . "'";
    }
    $cond_arr[] = "t2.status = '1'";

    $result_cond = implode(' and ', $cond_arr);

    $query = $this->Mleave->getDTLeavesummaryDetails('', '', $result_cond);

    $i = 2;

    foreach ($query as $row) {
        $schd_arr = array();
        $schd_curdate = date('Y-m-d');
        $schd_arr[] = "employee_id = '" . $row['employee_id'] . "'";
        $schd_arr[] = "leave_startdate >= '" . $schd_curdate . "'";
        $schd_arr[] = "leave_type_id = '" . $row['leave_type_id'] . "'";
        $schd_cond = implode(' and ', $schd_arr);
        $check_leave_schd = $this->Mleave->checkscheduledLeave($schd_cond);
        $nestedData = array();
        $leave_remaining = ($row['no_of_days_allotted'] + $row['leave_brought_forward']) - ($row['leave_taken'] + $row['leave_encashed']);

        $emp_name = $row['emp_firstname'] . ' ' . $row['emp_lastname'];
        $leave_type_name = $row['leave_type_name'];
        $entitled_days = $row['no_of_days_allotted'] != '' ? $row['no_of_days_allotted'] : 0;
        $scheduled_days = $check_leave_schd[0]['scheduled'] != '' ? $check_leave_schd[0]['scheduled'] : 0;
        $taken_days = $row['leave_taken'];
        $brought_forward_days = $row['leave_brought_forward'];
        $encashed_days = $row['leave_encashed'];
            // if($row['leave_type_name'] == 'Work From Home'){
        if ($row['no_restrictions'] == 1) {
            $remaining_days = '0';
        } else {
            $remaining_days = $leave_remaining;
        }
        $comments_summary = $row['comments'];

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $emp_name);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $leave_type_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $entitled_days);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $scheduled_days);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $taken_days);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $brought_forward_days);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $encashed_days);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $remaining_days);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $comments_summary);
        $i++;
    }
        // if ($sector_id != 'all') {
        //     $sname = (str_replace(' ', '_', strtolower($sector_ct[0]['sector'])));
        // } else {
        //     $sname = 'Allsector';
        // }
    $file_name = preg_replace('/[^A-Za-z0-9\_]/', '', 'Leave summary') . '.xlsx';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file_name . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');

    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();

    $objWriter->save('php://output');
    exit;
}

public function getCasualLeaveAjax() {
	 
	$fromDate = $this->input->post('fromDate');
	$toDate = $this->input->post('toDate');
	$getWeekEndResult = $this->Mleave->getWeekEnd();
	$dayCount = 0;
	$totalDayCount = 0;
	$clCount = 0;
	$result['status']='1';
	if(!empty($getWeekEndResult)){
		$daysWithValue3 = [];
		$daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
		foreach ($daysOfWeek as $day) {
			if ($getWeekEndResult[0][$day] == 3) {
				$daysWithValue3[] = $day;
			}
		}
		$startDate =  $fromDate;
		$endDate = $toDate;
		$startDateObj = DateTime::createFromFormat('d-m-Y', $startDate);
		$endDateObj = DateTime::createFromFormat('d-m-Y', $endDate);

		$currentDate = clone $startDateObj;
		while ($currentDate <= $endDateObj) {
			
			$getLoopDate = $currentDate->format('l');
			if (in_array(strtolower($getLoopDate), $daysWithValue3)) {
				$dayCount++;
			}
			$totalDayCount++;
			$currentDate->add(new DateInterval('P1D'));
		}
	}
	if($totalDayCount >3){
		$clCount = $totalDayCount -  $dayCount;
		if($clCount > 3){
			$result['status']='0';
		}
	}
	$result['totalDayCount']=$totalDayCount;
	$result['dayCount']=$dayCount;
	$result['clCount']=$clCount;
	echo json_encode($result);
	
	
}


/* Master section ends */

function leave_FYreport_export() {
    $query = $this->Mleave->getLeaveFYquota();

    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=\"Leave_summary_report" . date('m-d-Y') . ".csv\"");
    header("Pragma: no-cache");
    header("Expires: 0");
    $handle = fopen('php://output', 'w');
    fputcsv($handle, array(
        'S.No',
        'Employee ID',
        'Employee Name',
        'Employee Type',
        'Partner',
        'Leave Type',
        'Leave Applied',
        'Leave Requested',
        'Leave Taken'
    ));

    $i = 2;
    $j = 0;
    foreach ($query as $list) {
        $s_no = $j + 1;
        $emp_query = $this->Mleave->getLeaveFYEmployee($list['employee_id']);

        $req_cond['leave_type_id'] = $list['leave_type_id'];
        $req_cond['employee_id'] = $list['employee_id'];
        $req_query = $this->Mleave->getLeaveFYrequest($req_cond);

        $leav_cond['leave_type_id'] = $list['leave_type_id'];
        $leav_cond['employee_id'] = $list['employee_id'];
        $leav_query = $this->Mleave->getLeaveFYleave($leav_cond);

        fputcsv($handle, array(
            $s_no,
            $list['employee_id'],
            $emp_query[0]['emp_first_name'] . ' ' . $emp_query[0]['emp_last_name'],
            $emp_query[0]['user_type'],
            $emp_query[0]['partner_name'],
            $list['leave_type_name'],
            $leav_query[0]['applied_leave'],
            $req_query[0]['tot_leave'],
            $list['leave_taken']
        ));

        $i++;
        $j++;
    }

    fclose($handle);
    exit;
}
}


?>