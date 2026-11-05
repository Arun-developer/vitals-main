<?php

class Migration extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->Mauth->isLoggedCheck();
        $this->load->model('Mmigration');
    }

    public function accommodation() {
        $get_data = $this->Mmigration->get_table_details('accommodation', 'employee_id');
        foreach ($get_data as $row) {
            if ($row['employee_id'] != '' && $row['employee_id'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['employee_id']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('accommodation', 'employee_id', $get_hris_data[0]['emp_number'], $row['employee_id']);
                }
            }
        }
        $data['message'] = 'The accommodation table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function an_edit_history() {
        $get_data_1 = $this->Mmigration->get_table_details('an_edit_history', 'edited_by');
        foreach ($get_data_1 as $row_1) {
            if ($row_1['edited_by'] != '' && $row_1['edited_by'] != '0') {
                $get_hris_data_1 = $this->Mmigration->get_hris_emp_details($row_1['edited_by']);
                if ($get_hris_data_1[0]['emp_number'] != '' && $get_hris_data_1[0]['emp_number'] > '0') {
                    $update_table_1 = $this->Mmigration->update_table_details('an_edit_history', 'edited_by', $get_hris_data_1[0]['emp_number'], $row_1['edited_by']);
                }
            }
        }

        $get_data_2 = $this->Mmigration->get_table_details('an_edit_history', 'to_RO');
        foreach ($get_data_2 as $row_2) {
            if ($row_2['to_RO'] != '' && $row_2['to_RO'] != '0') {
                $get_hris_data_2 = $this->Mmigration->get_hris_emp_details($row_2['to_RO']);
                if ($get_hris_data_2[0]['emp_number'] != '' && $get_hris_data_2[0]['emp_number'] > '0') {
                    $update_table_2 = $this->Mmigration->update_table_details('an_edit_history', 'to_RO', $get_hris_data_2[0]['emp_number'], $row_2['to_RO']);
                }
            }
        }
        $data['message'] = 'The AN history table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function approval_note() {
        $get_data_1 = $this->Mmigration->get_table_details('approval_note', 'from_employee');
        foreach ($get_data_1 as $row_1) {
            if ($row_1['from_employee'] != '' && $row_1['from_employee'] != '0') {
                $get_hris_data_1 = $this->Mmigration->get_hris_emp_details($row_1['from_employee']);
                if ($get_hris_data_1[0]['emp_number'] != '' && $get_hris_data_1[0]['emp_number'] > '0') {
                    $update_table_1 = $this->Mmigration->update_table_details('approval_note', 'from_employee', $get_hris_data_1[0]['emp_number'], $row_1['from_employee']);
                }
            }
        }

        $get_data_2 = $this->Mmigration->get_table_details('approval_note', 'to_RO');
        foreach ($get_data_2 as $row_2) {
            if ($row_2['to_RO'] != '' && $row_2['to_RO'] != '0') {
                $get_hris_data_2 = $this->Mmigration->get_hris_emp_details($row_2['to_RO']);
                if ($get_hris_data_2[0]['emp_number'] != '' && $get_hris_data_2[0]['emp_number'] > '0') {
                    $update_table_2 = $this->Mmigration->update_table_details('approval_note', 'to_RO', $get_hris_data_2[0]['emp_number'], $row_2['to_RO']);
                }
            }
        }
        $data['message'] = 'The AN table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function approval_note_actionhistory() {
        $get_data_1 = $this->Mmigration->get_table_details('approval_note_actionhistory', 'from_employee');
        foreach ($get_data_1 as $row_1) {
            if ($row_1['from_employee'] != '' && $row_1['from_employee'] != '0') {
                $get_hris_data_1 = $this->Mmigration->get_hris_emp_details($row_1['from_employee']);
                if ($get_hris_data_1[0]['emp_number'] != '' && $get_hris_data_1[0]['emp_number'] > '0') {
                    $update_table_1 = $this->Mmigration->update_table_details('approval_note_actionhistory', 'from_employee', $get_hris_data_1[0]['emp_number'], $row_1['from_employee']);
                }
            }
        }

        $get_data_2 = $this->Mmigration->get_table_details('approval_note_actionhistory', 'assigned_employee');
        foreach ($get_data_2 as $row_2) {
            if ($row_2['assigned_employee'] != '' && $row_2['assigned_employee'] != '0') {
                $get_hris_data_2 = $this->Mmigration->get_hris_emp_details($row_2['assigned_employee']);
                if ($get_hris_data_2[0]['emp_number'] != '' && $get_hris_data_2[0]['emp_number'] > '0') {
                    $update_table_2 = $this->Mmigration->update_table_details('approval_note_actionhistory', 'assigned_employee', $get_hris_data_2[0]['emp_number'], $row_2['assigned_employee']);
                }
            }
        }
        $data['message'] = 'The AN action history table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function approval_note_comment() {
        $get_data = $this->Mmigration->get_table_details('approval_note_comment', 'empid');
        foreach ($get_data as $row) {
            if ($row['empid'] != '' && $row['empid'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['empid']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('approval_note_comment', 'empid', $get_hris_data[0]['emp_number'], $row['empid']);
                }
            }
        }
        $data['message'] = 'The AN comment table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function approval_setting() {
//        Have serialize emp_id
        $get_data = $this->Mmigration->get_table_details('approval_setting', 'ceo');
        foreach ($get_data as $row) {
            if ($row['ceo'] != '' && $row['ceo'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['ceo']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('approval_setting', 'ceo', $get_hris_data[0]['emp_number'], $row['ceo']);
                }
            }
        }
        $data['message'] = 'The approval setting table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function asset_payment() {
        $get_data = $this->Mmigration->get_table_details('asset_payment', 'employee_id');
        foreach ($get_data as $row) {
            if ($row['employee_id'] != '' && $row['employee_id'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['employee_id']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('asset_payment', 'employee_id', $get_hris_data[0]['emp_number'], $row['employee_id']);
                }
            }
        }
        $data['message'] = 'The asset payment table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function asset_transaction() {
        $get_data = $this->Mmigration->get_table_details('asset_transaction', 'employee_id');
        foreach ($get_data as $row) {
            if ($row['employee_id'] != '' && $row['employee_id'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['employee_id']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('asset_transaction', 'employee_id', $get_hris_data[0]['emp_number'], $row['employee_id']);
                }
            }
        }
        $data['message'] = 'The asset transaction table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function dispatch_inward() {
        $get_data_1 = $this->Mmigration->get_table_details('dispatch_inward', 'employee_id');
        foreach ($get_data_1 as $row_1) {
            if ($row_1['employee_id'] != '' && $row_1['employee_id'] != '0') {
                $get_hris_data_1 = $this->Mmigration->get_hris_emp_details($row_1['employee_id']);
                if ($get_hris_data_1[0]['emp_number'] != '' && $get_hris_data_1[0]['emp_number'] > '0') {
                    $update_table_1 = $this->Mmigration->update_table_details('dispatch_inward', 'employee_id', $get_hris_data_1[0]['emp_number'], $row_1['employee_id']);
                }
            }
        }

        $get_data_2 = $this->Mmigration->get_table_details('dispatch_inward', 'handover_to');
        foreach ($get_data_2 as $row_2) {
            if ($row_2['handover_to'] != '' && $row_2['handover_to'] != '0') {
                $get_hris_data_2 = $this->Mmigration->get_hris_emp_details($row_2['handover_to']);
                if ($get_hris_data_2[0]['emp_number'] != '' && $get_hris_data_2[0]['emp_number'] > '0') {
                    $update_table_2 = $this->Mmigration->update_table_details('dispatch_inward', 'handover_to', $get_hris_data_2[0]['emp_number'], $row_2['handover_to']);
                }
            }
        }
        $data['message'] = 'The dispatch inward table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function dispatch_outward() {
        $get_data = $this->Mmigration->get_table_details('dispatch_outward', 'employee_id');
        foreach ($get_data as $row) {
            if ($row['employee_id'] != '' && $row['employee_id'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['employee_id']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('dispatch_outward', 'employee_id', $get_hris_data[0]['emp_number'], $row['employee_id']);
                }
            }
        }
        $data['message'] = 'The dispatch outward table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function internal_note() {
        $get_data = $this->Mmigration->get_table_details('internal_note', 'from');
        foreach ($get_data as $row) {
            if ($row['from'] != '' && $row['from'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['from']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('internal_note', 'from', $get_hris_data[0]['emp_number'], $row['from']);
                }
            }
        }
        $data['message'] = 'The IN table is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function in_edit_history() {
        $get_data = $this->Mmigration->get_table_details('in_edit_history', 'edited_by');
        foreach ($get_data as $row) {
            if ($row['edited_by'] != '' && $row['edited_by'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['edited_by']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('in_edit_history', 'edited_by', $get_hris_data[0]['emp_number'], $row['edited_by']);
                }
            }
        }
        $data['message'] = 'The IN edit history is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function library_booking() {
        $get_data = $this->Mmigration->get_table_details('library_booking', 'employee_id');
        foreach ($get_data as $row) {
            if ($row['employee_id'] != '' && $row['employee_id'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['employee_id']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('library_booking', 'employee_id', $get_hris_data[0]['emp_number'], $row['employee_id']);
                }
            }
        }
        $data['message'] = 'The library booking is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function local_transport() {
        $get_data = $this->Mmigration->get_table_details('local_transport', 'employee_id');
        foreach ($get_data as $row) {
            if ($row['employee_id'] != '' && $row['employee_id'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['employee_id']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('local_transport', 'employee_id', $get_hris_data[0]['emp_number'], $row['employee_id']);
                }
            }
        }
        $data['message'] = 'The local transport is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function master_programme() {
        $get_data = $this->Mmigration->get_table_details('master_programme', 'programme_head');
        foreach ($get_data as $row) {
            if ($row['programme_head'] != '' && $row['programme_head'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['programme_head']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('master_programme', 'programme_head', $get_hris_data[0]['emp_number'], $row['programme_head']);
                }
            }
        }
        $data['message'] = 'The master programme is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function recovered_amount_detail() {
        $get_data = $this->Mmigration->get_table_details('recovered_amount_detail', 'entered_by');
        foreach ($get_data as $row) {
            if ($row['entered_by'] != '' && $row['entered_by'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['entered_by']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('recovered_amount_detail', 'entered_by', $get_hris_data[0]['emp_number'], $row['entered_by']);
                }
            }
        }
        $data['message'] = 'The recovered amount detail is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function travel_booking() {
        $get_data = $this->Mmigration->get_table_details('travel_booking', 'employee_id');
        foreach ($get_data as $row) {
            if ($row['employee_id'] != '' && $row['employee_id'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['employee_id']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('travel_booking', 'employee_id', $get_hris_data[0]['emp_number'], $row['employee_id']);
                }
            }
        }
        $data['message'] = 'The travel booking is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function visitors_log() {
        $get_data = $this->Mmigration->get_table_details('visitors_log', 'intending_to_meet');
        foreach ($get_data as $row) {
            if ($row['intending_to_meet'] != '' && $row['intending_to_meet'] != '0') {
                $get_hris_data = $this->Mmigration->get_hris_emp_details($row['intending_to_meet']);
                if ($get_hris_data[0]['emp_number'] != '' && $get_hris_data[0]['emp_number'] > '0') {
                    $update_table = $this->Mmigration->update_table_details('visitors_log', 'intending_to_meet', $get_hris_data[0]['emp_number'], $row['intending_to_meet']);
                }
            }
        }
        $data['message'] = 'The visitors log is successfully updated..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

//    HRIS Migration starts

    public function hr_user_login() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_users', 'emp_number');
        foreach ($get_data as $row) {
            $mis_data = $tab_arr = array();
            if ($row['emp_number'] != '' && $row['emp_number'] > '0') {
                $mis_data['emp_id'] = $row['emp_number'];
                $mis_data['user_name'] = $row['user_name'];
                $mis_data['password'] = $row['user_password'];
                $mis_data['user_role'] = $row['role_id'];
                $mis_data['partner_id'] = $row['partner_id'];
                $mis_data['partner_access'] = $row['other_partner'];
                $mis_data['menu_access'] = $row['menu_access'];
                $mis_data['sector_access'] = $row['sector_access'];
                $mis_data['program_access'] = $row['program_access'];
                if (isset($row['deals_from_date']) && $row['deals_from_date'] != '0000-00-00')
                    $mis_data['deals_from_date'] = $row['deals_from_date'];
                if (isset($row['deals_to_date']) && $row['deals_to_date'] != '0000-00-00')
                    $mis_data['deals_to_date'] = $row['deals_to_date'];
                $mis_data['independent_shortlist'] = $row['independent_shortlist'];
                $mis_data['graph_label'] = $row['graph_label'];

                if ($row['emp_bank'] == '1') {
                    array_push($tab_arr, '1');
                }
                if ($row['emp_dependent'] == '1') {
                    array_push($tab_arr, '2');
                }
                if ($row['emp_education'] == '1') {
                    array_push($tab_arr, '3');
                }
                if ($row['emp_immigration'] == '1') {
                    array_push($tab_arr, '4');
                }
                if ($row['emp_job'] == '1') {
                    array_push($tab_arr, '5');
                }
                if ($row['emp_reportto'] == '1') {
                    array_push($tab_arr, '6');
                }

                $tab_access = implode(',', $tab_arr);
                $mis_data['tab_access'] = $tab_access;

                if ($row['status'] == 'Enabled') {
                    $mis_data['status'] = '1';
                } else {
                    $mis_data['status'] = '2';
                }

                $insert_query = $this->Mmigration->insert_table_details('hr_user_login', $mis_data);
            }
        }
        $data['message'] = 'The employee login details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_user_profile() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_employee', 'emp_number');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['emp_number'] != '' && $row['emp_number'] > '0') {
                $mis_data['id'] = $row['emp_number'];
                $mis_data['partner_id'] = $row['emp_partner_id'];
                $mis_data['emp_first_name'] = $row['emp_firstname'];
                $mis_data['emp_last_name'] = $row['emp_lastname'];
                $mis_data['emp_middle_name'] = $row['emp_middle_name'];
                $mis_data['emp_name'] = $row['emp_firstname'] . ' ' . $row['emp_middle_name'] . ' ' . $row['emp_lastname'];
                $mis_data['emp_dob'] = $row['emp_birthday'];
                $mis_data['emp_gender'] = $row['emp_gender'] != '' ? $row['emp_gender'] : '0';
                $mis_data['emp_age'] = $row['emp_age'] != '' ? $row['emp_age'] : '';
                $mis_data['license_number'] = $row['emp_dri_lice_num'] != '' ? $row['emp_dri_lice_num'] : '';
                $mis_data['license_expiry_date'] = $row['emp_dri_lice_exp_date'];
                $mis_data['military_service'] = $row['emp_military_service'] != '' ? $row['emp_military_service'] : '';
                $mis_data['city'] = $row['city_code'] != '' ? $row['city_code'] : '';
                $mis_data['country'] = $row['coun_code'] != '' ? $row['coun_code'] : '';
                $mis_data['state'] = $row['provin_code'] != '' ? $row['provin_code'] : '';
                $mis_data['zipcode'] = $row['emp_zipcode'] != '' ? $row['emp_zipcode'] : '';
                $mis_data['home_mobile'] = $row['emp_hm_telephone'] != '' ? $row['emp_hm_telephone'] : '';
                $mis_data['personal_mobile'] = $row['emp_mobile'] != '' ? $row['emp_mobile'] : '';
                $mis_data['official_mobile'] = $row['emp_work_telephone'] != '' ? $row['emp_work_telephone'] : '';
                $mis_data['official_email'] = $row['emp_work_email'] != '' ? $row['emp_work_email'] : '';
                $mis_data['personal_email'] = $row['emp_oth_email'] != '' ? $row['emp_oth_email'] : '';
                $mis_data['address'] = $row['emp_perm_addr'] != '' ? $row['emp_perm_addr'] : '';
                $mis_data['pan_number'] = $row['emp_pan_number'] != '' ? $row['emp_pan_number'] : '';
                $mis_data['blood_group'] = $row['emp_blood_group'] != '' ? $row['emp_blood_group'] : '';
                $mis_data['hobbies'] = $row['emp_hobbies'] != '' ? $row['emp_hobbies'] : '';
                $mis_data['insurance'] = $row['emp_ins_no'] != '' ? $row['emp_ins_no'] : '';
                $mis_data['organ_donor'] = $row['emp_organ'] != '' ? $row['emp_organ'] : '';
                $mis_data['illness'] = $row['emp_illness'] != '' ? $row['emp_illness'] : '';
                $mis_data['hiring_source'] = $row['emp_hiring'] != '' ? $row['emp_hiring'] : '';
                $mis_data['experience'] = $row['emp_exp'] != '' ? $row['emp_exp'] : '';
                $mis_data['uan_number'] = $row['emp_uan'] != '' ? $row['emp_uan'] : '';
                $mis_data['admin_email'] = '';

                $mar_value = '0';
                if ($row['emp_marital_status'] == 'Married') {
                    $mar_value = '1';
                } else if ($row['emp_marital_status'] == 'Unmarried') {
                    $mar_value = '2';
                } else if ($row['emp_marital_status'] == 'Divorced') {
                    $mar_value = '3';
                }
                $mis_data['marital_status'] = $mar_value;

                if ($row['emp_type'] != '' && $row['emp_type'] == 'alumini') {
                    $mis_data['emp_type'] = '1';
                } else if ($row['emp_type'] != '' && $row['emp_type'] != 'alumini') {
                    $get_emp_data = $this->Mmigration->get_empType_details($row['emp_type']);
                    $mis_data['emp_type'] = $get_emp_data[0]['id'];
                }

                if ($row['nation_code'] != '') {
                    $get_nat_data = $this->Mmigration->get_nationality_details($row['nation_code']);
                    $mis_data['nationality'] = $get_nat_data[0]['id'];
                } else {
                    $mis_data['nationality'] = '0';
                }

                if ($row['emp_number'] != '') {
                    $get_login_data = $this->Mmigration->get_checkLogin_details($row['emp_number']);
                    if (isset($get_login_data[0]['status']) && $get_login_data[0]['status'] == '1') {
                        $mis_data['login_status'] = '1';
                    } else {
                        $mis_data['login_status'] = '2';
                    }
                }

                $insert_employees = $this->Mmigration->insert_table_details('hr_user_profile', $mis_data);
            }
        }
        $data['message'] = 'The employee details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_user_emergency_contact() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_emp_emergency_contacts', 'emp_number');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['emp_number'] != '' && $row['emp_number'] > '0') {
                $mis_data['emp_id'] = $row['emp_number'];
                $mis_data['name'] = $row['eec_name'];
                $mis_data['relationship'] = $row['eec_relationship'];
                $mis_data['home_mobile'] = $row['eec_home_no'];
                $mis_data['mobile'] = $row['eec_mobile_no'];
                $mis_data['official_mobile'] = $row['eec_office_no'];
                $mis_data['email'] = $row['EEC_EMAIL_ID'];

                $insert_query = $this->Mmigration->insert_table_details('hr_user_emergency_contact', $mis_data);
            }
        }
        $data['message'] = 'The employee emergency contact details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_user_dependents() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_emp_dependents', 'emp_number');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['emp_number'] != '' && $row['emp_number'] > '0') {
                $mis_data['emp_id'] = $row['emp_number'];
                $mis_data['name'] = $row['ed_name'];
                $mis_data['relationship'] = $row['ed_relationship'];
                $mis_data['birth_date'] = $row['ED_DATE_OF_BIRTH'];

                $insert_query = $this->Mmigration->insert_table_details('hr_user_dependents', $mis_data);
            }
        }
        $data['message'] = 'The employee dependents details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_user_bank() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_emp_bank', 'emp_number');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['emp_number'] != '' && $row['emp_number'] > '0') {
                $mis_data['emp_id'] = $row['emp_number'];
                $mis_data['bank_name'] = $row['bank_name'];
                $mis_data['branch_name'] = $row['bank_branch'];
                $mis_data['account_number'] = $row['bank_account'];
                $mis_data['ifsc_code'] = $row['bank_ifsc'];

                $insert_query = $this->Mmigration->insert_table_details('hr_user_bank', $mis_data);
            }
        }
        $data['message'] = 'The employee bank details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_user_immigration() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_emp_passport', 'emp_number');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['emp_number'] != '' && $row['emp_number'] > '0') {
                $mis_data['emp_id'] = $row['emp_number'];
                $mis_data['passport_number'] = $row['ep_passport_num'];
                $mis_data['passport_issue_date'] = $row['ep_passportissueddate'];
                $mis_data['passport_expiry_date'] = $row['ep_passportexpiredate'];
                $mis_data['img_comments'] = $row['ep_comments'];
                if ($row['cou_code'] != '' && $row['cou_code'] != '0') {
                    $get_country_data = $this->Mmigration->get_country_details($row['cou_code']);
                    $mis_data['citizenship'] = $get_country_data[0]['id'];
                }
                $mis_data['visa_type'] = $row['EP_PASSPORT_TYPE'];
                $mis_data['visa_number'] = $row['ep_visa_num'];
                $mis_data['visa_issue_date'] = $row['ep_visaissueddate'];
                $mis_data['visa_expiry_date'] = $row['ep_visaexpiredate'];

                $insert_query = $this->Mmigration->insert_table_details('hr_user_immigration', $mis_data);
            }
        }
        $data['message'] = 'The employee immigration details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_user_education() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_emp_education', 'emp_number');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['emp_number'] != '' && $row['emp_number'] > '0') {
                $mis_data['emp_id'] = $row['emp_number'];
                $mis_data['qualification'] = $row['edu_code'];
                $mis_data['year_numbers'] = $row['edu_year'];
                $mis_data['gpa_score'] = $row['edu_gpa'];
                $mis_data['year_from'] = $row['edu_start_date'];
                $mis_data['year_to'] = $row['edu_end_date'];
                $mis_data['institute_name'] = $row['EDU_INSTITUTE'];
                $mis_data['city'] = $row['edu_city'];
                $mis_data['state'] = $row['edu_state'];
                if ($row['edu_major'] != '' && $row['edu_major'] != '0') {
                    $get_edu_data = $this->Mmigration->get_education_details($row['edu_major']);
                    $mis_data['degree'] = $get_edu_data[0]['id'];
                }

                $insert_query = $this->Mmigration->insert_table_details('hr_user_education', $mis_data);
            }
        }
        $data['message'] = 'The employee education details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_user_reporting() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_emp_reportto');
        foreach ($get_data as $row) {
            $mis_data = array();
            $mis_data['report_supervisor'] = $row['erep_sub_emp_number'];
            $mis_data['report_subordinate'] = $row['erep_sup_emp_number'];
            $mis_data['report_method'] = $row['erep_reporting_mode'];

            $insert_query = $this->Mmigration->insert_table_details('hr_user_reporting', $mis_data);
        }
        $data['message'] = 'The employee reporting details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_leave_request() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_leave_requests', 'leave_request_id');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['employee_id'] != '' && $row['employee_id'] > '0') {
                $mis_data['id'] = $row['leave_request_id'];
                $mis_data['leave_type_id'] = $row['leave_type_id'];
                $mis_data['date_applied'] = $row['date_applied'];
                $mis_data['employee_id'] = $row['employee_id'];
                $mis_data['date_approval'] = $row['approval_date'] != '0000-00-00' ? $row['approval_date'] : NULL;
                $mis_data['status'] = '0';

                $insert_query = $this->Mmigration->insert_table_details('hr_leave_request', $mis_data);
            }
        }
        $data['message'] = 'The leave request details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_leave() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_leave', 'leave_id');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['employee_id'] != '' && $row['employee_id'] > '0') {
                $mis_data['leave_date'] = $row['leave_date'];
                $mis_data['leave_length_hours'] = $row['leave_length_hours'];
                $mis_data['leave_length_days'] = $row['leave_length_days'];
                $mis_data['leave_status'] = $row['leave_status'];
                $mis_data['leave_comments'] = $row['leave_comments'];
                $mis_data['leave_request_id'] = $row['leave_request_id'];
                $mis_data['leave_type_id'] = $row['leave_type_id'];
                $mis_data['employee_id'] = $row['employee_id'];
                $mis_data['leave_startdate'] = $row['leave_startdate'] != '0000-00-00' ? $row['leave_startdate'] : NULL;
                $mis_data['leave_enddate'] = $row['leave_enddate'] != '0000-00-00' ? $row['leave_enddate'] : NULL;

                if ($row['leave_request_id'] != '' && $row['leave_request_id'] != '0') {
                    $get_req_data = $this->Mmigration->get_leaveReq_details($row['leave_request_id'], $row['employee_id']);
                    $mis_data['leave_applied_date'] = $get_req_data[0]['date_applied'] != '0000-00-00' ? $get_req_data[0]['date_applied'] : NULL;
                    $mis_data['leave_approval_date'] = $get_req_data[0]['approval_date'] != '0000-00-00' ? $get_req_data[0]['approval_date'] : NULL;
                }

                $insert_query = $this->Mmigration->insert_table_details('hr_leave', $mis_data);
            }
        }
        $data['message'] = 'The leave details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function update_hr_leave_request() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_leave');
        foreach ($get_data as $row) {
            $mis_data = $mis_cond = array();
            if ($row['leave_request_id'] != '' && $row['leave_request_id'] > '0') {
                $mis_cond['id'] = $row['leave_request_id'];
                $mis_cond['employee_id'] = $row['employee_id'];
                $mis_data['leave_length_days'] = $row['leave_length_days'];
                $mis_data['status'] = $row['leave_status'];

                $insert_query = $this->Mmigration->update_mis_table_details('hr_leave_request', $mis_data, $mis_cond);
            }
        }
        $data['message'] = 'The leave request details updated successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_leave_quota() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_employee_leave_quota');
        foreach ($get_data as $row) {
            $mis_data = array();
            if ($row['employee_id'] != '' && $row['employee_id'] > '0') {
                $mis_data['year'] = $row['year'];
                $mis_data['leave_type_id'] = $row['leave_type_id'];
                $mis_data['employee_id'] = $row['employee_id'];
                $mis_data['partner_id'] = $row['partner_id'];
                $mis_data['no_of_days_allotted'] = $row['no_of_days_allotted'];
                $mis_data['leave_taken'] = $row['leave_taken'];
                $mis_data['leave_brought_forward'] = $row['leave_brought_forward'];
                $mis_data['leave_encashed'] = $row['leave_encashed'];
                $mis_data['comments'] = $row['comments'];

                if ($row['employee_id'] != '' && $row['employee_id'] != '0') {
                    $get_emp_data = $this->Mmigration->get_employee_details($row['employee_id']);
                    $mis_data['partner_id'] = $get_emp_data[0]['partner_id'] != '' ? $get_emp_data[0]['partner_id'] : '0';
                }

                $insert_query = $this->Mmigration->insert_table_details('hr_leave_quota', $mis_data);
            }
        }
        $data['message'] = 'The leave quota details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_leave_type() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_leavetype');
        foreach ($get_data as $row) {
            $mis_data = array();
            $mis_data['leave_type_id'] = $row['leave_type_id'];
            $mis_data['leave_type_name'] = $row['leave_type_name'];
            $mis_data['partner_id'] = '1';
            $mis_data['status'] = '1';

            $insert_query = $this->Mmigration->insert_table_details('hr_leave_type', $mis_data);
        }
        $data['message'] = 'The leave type details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_job_specification() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_job_spec', 'jobspec_id');
        foreach ($get_data as $row) {
            $mis_data = array();
            $mis_data['id'] = $row['jobspec_id'];
            $mis_data['specification_name'] = $row['jobspec_name'];
            $mis_data['specification_description'] = $row['jobspec_desc'];
            $mis_data['specification_duties'] = $row['jobspec_duties'];
            $mis_data['status'] = '1';

            $insert_query = $this->Mmigration->insert_table_details('hr_job_specification', $mis_data);
        }
        $data['message'] = 'The job specification details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_job_title() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_job_title');
        foreach ($get_data as $row) {
            $mis_data = array();
            $mis_data['jobtit_code'] = $row['jobtit_code'];
            $mis_data['jobtit_name'] = $row['jobtit_name'];
            $mis_data['jobtit_desc'] = $row['jobtit_desc'];
            $mis_data['jobtit_comm'] = $row['jobtit_comm'];
            $mis_data['sal_grd_code'] = $row['sal_grd_code'];
            $mis_data['jobspec_id'] = $row['jobspec_id'];
            $mis_data['job_type'] = $row['job_type'];

            $insert_query = $this->Mmigration->insert_table_details('hr_job_title', $mis_data);
        }
        $data['message'] = 'The job title details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_job_location() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_location');
        foreach ($get_data as $row) {
            $mis_data = array();
            $mis_data['location_code'] = $row['loc_code'];
            $mis_data['location_name'] = $row['loc_name'];
            $mis_data['state'] = $row['loc_state'];
            $mis_data['city'] = $row['loc_city'];
            $mis_data['address'] = $row['loc_add'];
            $mis_data['zipcode'] = $row['loc_zip'];
            $mis_data['phone'] = $row['loc_phone'];
            $mis_data['fax'] = $row['loc_fax'];
            $mis_data['comments'] = $row['loc_comments'];

            if ($row['loc_country'] != '' && $row['loc_country'] != '0') {
                $get_country_data = $this->Mmigration->get_country_details($row['loc_country']);
                $mis_data['country'] = $get_country_data[0]['id'];
            }

            $insert_query = $this->Mmigration->insert_table_details('hr_job_location', $mis_data);
        }
        $data['message'] = 'The job location details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_holidays() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_holidays', 'holiday_id');
        foreach ($get_data as $row) {
            $mis_data = array();
            $mis_data['id'] = $row['holiday_id'];
            $mis_data['holiday_name'] = $row['description'];
            $mis_data['date'] = $row['date'];
            $mis_data['repeat_annually'] = $row['recurring'];
            $mis_data['length'] = '1';
            $mis_data['partner_id'] = '1';
            $mis_data['status'] = '1';

            $insert_query = $this->Mmigration->insert_table_details('hr_holidays', $mis_data);
        }
        $data['message'] = 'The holiday details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

    public function hr_working_days() {
        $get_data = $this->Mmigration->get_hris_table_details('hs_hr_workdays', 'workday_id');
        foreach ($get_data as $row) {
            $mis_data = array();
            $mis_data['id'] = $row['workday_id'];
            $mis_data['workingday_name'] = $row['description'];
            $mis_data['date'] = $row['date'];
            $mis_data['length'] = '1';
            $mis_data['status'] = '1';

            $insert_query = $this->Mmigration->insert_table_details('hr_working_days', $mis_data);
        }
        $data['message'] = 'The working day details added successfully..!!';
        $this->load->vars($data);
        $this->load->view('migration/message');
    }

}

?>