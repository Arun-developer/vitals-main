<?php

class Mlibrary extends My_Model {

    /* function Mlibrary() {
        parent::Model();
        $this->orange = $this->load->database('hris', TRUE);
        $this->load->model('Mlogin');
    }  */
	
	/* public function __construct(){
        parent::Model();
		$this->load->model('Mlogin');
		$this->ais = $this->load->database('ais', TRUE);
		$this->orange = $this->load->database('hris', TRUE);
    } */
	
	public function __construct(){
        parent::__construct();
		$this->ais = $this->load->database('ais', TRUE);
		$this->hris = $this->load->database('hris', TRUE);
    }
	
	
	

    function updateLibrarySettings(){
        $data = array('days_for_return' => $this->input->post('days_for_return'),
            'booking_request_mail' => php72_implode(",", $this->input->post('booking_request_mail')),
            'booking_confirm_mail' => php72_implode(",", $this->input->post('booking_confirm_mail')),
            'days_before_reminder' => $this->input->post('days_before_reminder'),
            'days_between_reminders' => $this->input->post('days_between_reminders'),
            'reminder_mail' => php72_implode(",", $this->input->post('reminder_mail')),
            'days_valid_for_renewal' => $this->input->post('days_valid_for_renewal'),
            'no_of_renewals' => $this->input->post('no_of_renewals'),
            'book_serial_format' => $this->input->post('book_serial_format'),
            'book_serial_position' => $this->input->post('book_serial_position'),
            'no_of_reminders' => $this->input->post('no_of_reminders')
        );

        $this->db->where('library_setting_id', $this->input->post('library_setting_id'));
        $result = $this->db->update('library_settings', $data);
        return $result;
    }

    function getLibrarySettings($field) {
        $data = array();
        $this->ais->select($field);
        $this->ais->where('library_setting_id', '1');
        $query = $this->ais->get('library_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }
        return $data[$field];
    }

    function getAllBooktoRequest($where = NULL) {
        $data = array();
        $this->db->where('master_books.status', '1');
        $this->db->select('master_settings.master_name, master_books.*');
        $this->db->join('master_settings', 'master_books.master_id=master_settings.master_id', 'left');

        if ($where != NULL)
            $query = $this->db->get_where('master_books', $where);
        else
            $query = $this->db->get('master_books');
		#echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
		#echo'<pre>';print_r($data);die;
        $query->free_result();
        return $data;
    }

    function getLimitBooktoRequest($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL) {
        $data = array();
        $this->db->limit($num, $offset);
        $this->db->where('master_books.status', '1');
        $this->db->select('master_settings.master_name, master_books.*');
        $this->db->join('master_settings', 'master_books.master_id=master_settings.master_id', 'left');

        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('master_books', $where);
        else
            $query = $this->db->get('master_books');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
	
        $query->free_result();
		
        return $data;
    }

    function bookRequestForm($bookId, $userId) {
        $data = array('employee_id' => $userId,
            'book_id' => $bookId,
            'request_date' => date("Y-m-d H:i:s"));
		
        $this->ais->insert('library_booking', $data);
        return $this->ais->insert_id();
    }

    function checkRequest($bookId, $userId) {
        $data = array();
        $this->ais->where('book_id', $bookId);
        $this->ais->where('employee_id', $userId);
        $this->ais->where('status', 'pending');
        $query = $this->ais->get('library_booking');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getAllLibraryRequest($where = NULL, $admin = NULL) {
        $data = array();
        if ($admin == NULL)
            $this->db->where('library_booking.employee_id', $this->session->userdata('user'));

        $this->db->select('master_settings.master_name,master_books.book_name,master_books.author,master_books.book_number,library_booking.*');
        $this->db->join('master_books', 'library_booking.book_id=master_books.book_id', 'left');
        $this->db->join('master_settings', 'master_books.master_id=master_settings.master_id', 'left');

        if ($where != NULL)
            $query = $this->db->get_where('library_booking', $where);
        else
            $query = $this->db->get('library_booking');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getLimitLibraryRequest($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL) {
		#echo $this->session->userdata('user');die;
        $data = array();
        $this->db->limit($num, $offset);
        if ($admin == NULL)
            $this->db->where('library_booking.employee_id !=', $this->session->userdata('user'));
        $this->db->select('master_settings.master_name,master_books.book_name,master_books.author,master_books.available,master_books.book_number,library_booking.*');
        $this->db->join('master_books', 'library_booking.book_id=master_books.book_id', 'left');
        $this->db->join('master_settings', 'master_books.master_id=master_settings.master_id', 'left');
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('library_booking', $where);
        else
            $query = $this->db->get('library_booking');
		#echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getExportLibraryRequest($where = NULL, $orderby = NULL, $ordertype = NULL, $admin = NULL) {
        $data = array();

        if ($admin == NULL)
            $this->db->where('library_booking.employee_id', $this->session->userdata('user'));
        $this->db->select('master_settings.master_name,master_books.book_name,master_books.author,master_books.available,master_books.book_number,library_booking.*');
        $this->db->join('master_books', 'library_booking.book_id=master_books.book_id', 'left');
        $this->db->join('master_settings', 'master_books.master_id=master_settings.master_id', 'left');
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('library_booking', $where);
        else
            $query = $this->db->get('library_booking');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getLibraryRequestDetails($libraryBookingId) {
        $data = array();
		$this->ais ->where('library_booking.library_booking_id', $libraryBookingId);
        $this->ais ->select('master_settings.master_name,master_books.book_name,master_books.author,master_books.book_number,library_booking.*');
		$this->ais ->join('master_books', 'library_booking.book_id=master_books.book_id', 'left');
        $this->ais ->join('master_settings', 'master_books.master_id=master_settings.master_id', 'left');
        $query = $this->ais->get('library_booking');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function checkLibraryBookingStatus($requestId) {
        $data = array();
        $this->ais->select('status');
        $this->ais->where('library_booking_id', $requestId);
        $query = $this->ais->get('library_booking');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function cancelLibraryRequest($requestID) {
        $this->ais->where('library_booking_id', $requestID);
        $this->ais->set('status', 'cancelled');
        $this->ais->set('cancel_date', date("Y/m/d"));
        $this->ais->update('library_booking');
        return $this->ais->affected_rows();
    }

    function confirmLibraryRequest($requestID, $expectedReturnDate, $issueDate, $bookId) {
        $result = $this->updateBookStatus($bookId, '0');
        $this->ais->where('library_booking_id', $requestID);
        $this->ais->set('status', 'confirmed');
        $this->ais->set('expected_return_date', date("Y-m-d", strtotime($expectedReturnDate)));
        $this->ais->set('issue_date', date("Y-m-d", strtotime($issueDate)));
        $this->ais->update('library_booking');
        return $this->ais->affected_rows();
    }

    function updateBookStatus($bookId, $status) {
        $this->ais->where('book_id', $bookId);
        $this->ais->set('available', $status);
        $this->ais->update('master_books');
        return $this->ais->affected_rows();
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

    function getAllUserList() {
        $data = array();
        $this->db->distinct('hr_user_profile.emp_first_name');
        $this->db->select("hr_user_login.id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id", false);
        $this->db->where('hr_user_profile.partner_id', $this->session->userdata('partner_id'));
        $this->db->where_in('emp_type', array('3', '7', '2', '10'));
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

    function returnLibraryBook($requestId, $bookId,$return_date) {
        $result = $this->updateBookStatus($bookId, '1');
        $this->ais->where('library_booking_id', $requestId);
        $this->ais->set('status', 'returned');
        $this->ais->set('return_date', date("Y-m-d", strtotime($return_date)));
        $this->ais->update('library_booking');
        return $this->ais->affected_rows();
    }

    function renewLibraryRequest($requestId, $expectedReturnDate, $renewDate, $noOfRenew) {
        $this->db->where('library_booking_id', $requestId);
        $this->db->set('renew', $noOfRenew);
        $this->db->set('expected_return_date', date("Y-m-d", strtotime($expectedReturnDate)));
        $this->db->set('renew_date',date("Y-m-d", strtotime($renewDate)));
        $this->db->set('renew_status', 'confirmed');
        $this->db->update('library_booking');
        return $this->db->affected_rows();
    }

    function renewRequest($requestId) {
        $this->ais->where('library_booking_id', $requestId);
        $this->ais->set('renew_status', 'pending');
        $this->ais->set('renew_request_date',date("Y-m-d"));
        $this->ais->update('library_booking');
        return $this->ais->affected_rows();
    }

    function renewReject($requestId) {
        $this->db->where('library_booking_id', $requestId);
        $this->db->set('renew_status', 'rejected');
        $this->db->set('renew_reject_reason', $this->input->post('renew_reject_reason'));
        $this->db->update('library_booking');
        return $this->db->affected_rows();
    }
	
	function bookStatus($bookId, $employee) {
		$result = $this->getbookAvailabelStatus($bookId, $employee);
		if (php72_count($result)) {
			return $result['0']['status'];
		} else {
			return 'no';
		}
	}

    function getbookAvailabelStatus($bookId, $employee = NULL) {
		
        $data = array();
        $this->ais->where('book_id', $bookId);
        if ($employee == NULL)
            $this->ais->where('status', 'confirmed');
        else {
            $this->ais->where('employee_id', $employee);
            $this->ais->where('status', 'pending');
        }
        $this->ais->select('employee_id,status');
        $query = $this->ais->get('library_booking');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
		#echo debug_last_query();die;

        $query->free_result();
        return $data;
    }
	 function getUserInfo($userId) {
        #$data = $dataArr = array();
        $dataArr = '';
        $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,emp_gender,official_mobile,hr_user_profile.id as emp_number, official_email, personal_email, emp_name", false);
        $this->db->where('hr_user_login.emp_id', $userId);
        $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
        $this->db->group_by('hr_user_login.user_name');
        $query = $this->db->get('hr_user_login');
        if ($query->num_rows() > 0) {
            $dataArr = json_decode(json_encode($query->result()), true);
        }

        return $dataArr;
    }

	
	function employeeDetails($employeeId) {
        $data = array();
        $this->db->where('id', $employeeId);
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getEmployeeFromUserId($userId) { 
        $data = $this->getUserInfo($userId);
        if (php72_count($data)) {
            return $this->employeeDetails($data['0']['emp_number']);
        } else
            return true;
    }
	

    function libraryMailContant($requestId, $from = NULL) { #echo'asdasd';die;
		#error_reporting(-1);
        $mailSettingsArray = array();
        $requestDateils = $this->getLibraryRequestDetails($requestId);  
			
        $employeeDetails = $this->getEmployeeFromUserId($requestDateils['0']['employee_id']);
		
		$empEmail = ($employeeDetails['0']['official_email'] != '') ? $employeeDetails['0']['official_email'] : $employeeDetails['0']['official_email'];
        $adminEmail = $this->session->userdata('adminEmail');

        $toEmail = array($adminEmail, $empEmail);
        $employeeName = $employeeDetails['0']['emp_name'];
        if (strtolower($from) == 'admin') {
            $from = 'Admin';
            $to = $employeeName;
        } else {
            $from = $employeeName;
            $to = 'Admin';
        }

        $org = array('#From#', '#To#', '#employeeName#', '#requestNumber#', '#requestDate#', '#bookNumber#', '#bookName#', '#author#', '#cancelDate#', '#issueDate#', '#expectReturnDate#', '#noOfRenwals#', '#renewDate#', '#returnedDate#', '#renewRequestDate#', '#renew_reject_reason#');
		
		$expected_return_date_str ='';
		if($requestDateils['0']['expected_return_date']!='' && $requestDateils['0']['expected_return_date']!='1970-01-01 00:00:00'){
			$expected_return_date_str = $requestDateils['0']['expected_return_date'];
		}
        $replace = array($from,
            $to,
            $employeeName,
            $requestDateils['0']['library_booking_id'],
            $this->mysql2ddmmyyyy($requestDateils['0']['request_date']),
            $requestDateils['0']['book_number'],
            $requestDateils['0']['book_name'],
            $requestDateils['0']['author'],
            $this->mysql2ddmmyyyy($requestDateils['0']['cancel_date']),
            $this->mysql2ddmmyyyy($requestDateils['0']['issue_date']),
            $this->mysql2ddmmyyyy($expected_return_date_str),
            $requestDateils['0']['renew'],
            $this->mysql2ddmmyyyy($requestDateils['0']['renew_date']),
            $this->mysql2ddmmyyyy($requestDateils['0']['return_date']),
            $this->mysql2ddmmyyyy($requestDateils['0']['renew_request_date']),
            $requestDateils['0']['renew_reject_reason']);
        $data = array('org' => $org,
            'replace' => $replace,
            'employeeEmail' => $empEmail,
            'adminEmail' => $adminEmail,
            'toEmail' => $toEmail);
			#echo'<pre>';print_r($data);die;
        return $data;
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



    function libraryInfo($admin = NULL) {
        $data = array();
        if ($admin == NULL)
            $this->db->where('library_booking.employee_id', $this->session->userdata('user'));

        $this->db->where('status', 'confirmed');
        $query = $this->db->get('library_booking');
        $data['usingBooks'] = $query->num_rows();
        $query->free_result();

        if ($admin == NULL)
            $this->db->where('library_booking.employee_id', $this->session->userdata('user'));
        $this->db->where('status', 'pending');
        $query = $this->db->get('library_booking');
        $data['pendingBooks'] = $query->num_rows();
        $query->free_result();
        $this->db->where('available', '1');
        $query = $this->db->get('master_books');
        $data['availableBooks'] = $query->num_rows();
        $query->free_result();

        if ($admin == NULL)
            $this->db->where('library_booking.employee_id', $this->session->userdata('user'));
        $where = "expected_return_date < '" . ddmmyyyy2mysql(date("d/m/Y")) . "' and status='confirmed'";
        $query = $this->db->get_where('library_booking', $where);
        $data['dueBooks'] = $query->num_rows();
        $query->free_result();
        return $data;
    }

    function getDueList() {
        $data = array();
        $this->db->where('status', 'confirmed');
        $query = $this->db->get('library_booking');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getAllBookPayCount($where = NULL) {
        $data = array();
        $this->db->select("count(*) as total, sum(amount) as total_amount");
        if ($where != NULL)
            $query = $this->db->get_where('book_payment', $where);
        else
            $query = $this->db->get('book_payment');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return array_pop($data);
    }

    function getLimitBookPay($where = NULL, $num = NULL, $offset = NULL, $orderby = NULL, $ordertype = NULL) {
        $data = array();
        $this->db->limit($num, $offset);
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('book_payment', $where);
        else
            $query = $this->db->get('book_payment');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getExportBookPay($where = NULL, $orderby = NULL, $ordertype = NULL) {
        $data = array();
        if ($orderby != NULL && $ordertype != NULL)
            $this->db->order_by($orderby, $ordertype);
        if ($where != NULL)
            $query = $this->db->get_where('book_payment', $where);
        else
            $query = $this->db->get('book_payment');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function insertBookPay() {
        $data = array('book_name' => $this->input->post('book_name'),
            'author' => $this->input->post('author'),
            'donor' => $this->input->post('donor'),
            'other_donor' => $this->input->post('other_donor'),
            'budget_head' => $this->input->post('budget_head'),
            'other_budget_head' => $this->input->post('other_budget_head'),
            'bill_no' => $this->input->post('bill_no'),
            'bill_date' => ddmmyyyy2mysql($this->input->post('bill_date')),
            'amount' => $this->input->post('amount'),
            'date_of_purchase' => ddmmyyyy2mysql($this->input->post('date_of_purchase')),
            'vendor' => $this->input->post('vendor'));
        $this->db->insert('book_payment', $data);
        return $this->db->insert_id();
    }

    function updateBookPay() {
        $data = array('book_name' => $this->input->post('book_name'),
            'author' => $this->input->post('author'),
            'donor' => $this->input->post('donor'),
            'other_donor' => $this->input->post('other_donor'),
            'budget_head' => $this->input->post('budget_head'),
            'other_budget_head' => $this->input->post('other_budget_head'),
            'bill_no' => $this->input->post('bill_no'),
            'bill_date' => ddmmyyyy2mysql($this->input->post('bill_date')),
            'amount' => $this->input->post('amount'),
            'date_of_purchase' => ddmmyyyy2mysql($this->input->post('date_of_purchase')),
            'vendor' => $this->input->post('vendor'));
        $this->db->where('lib_id', $this->input->post('lib_id'));
        $this->db->update('book_payment', $data);
        return $this->db->affected_rows();
    }

}

?>