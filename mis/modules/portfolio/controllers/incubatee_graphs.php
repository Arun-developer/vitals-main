<?php

class Incubatee_graphs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('Mportfolio');
        $this->load->model('Sectorplan');
        $this->load->model('scouting/Mincharge');
        $this->load->model('scouting/Minnovation');
        $this->load->model('login/Muser');
        $this->load->model('login/Mdiligence');
        $this->load->model('master/Mmaster');
        $this->load->model('master/Mmaster_settings');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->library('upload');

        if ($this->session->userdata['emp_number'] == '') {
            redirect('login/icon_menu');
        }

        $allowed_partner = array("1", "2", "9");
        if (!in_array($this->session->userdata['partner_id'], $allowed_partner)) {
            redirect('login/icon_menu');
        }
    }

    public function month() {
        $start_month = current_FYstartMonth($this->session->userdata('partner_id'));
        $end_month = current_FYendMonth($this->session->userdata('partner_id'));
        $start_year = current_FYstartYear($this->session->userdata('partner_id'));
        $end_year = current_FYendYear($this->session->userdata('partner_id'));

        $date_sMonth = date_parse($start_month);
        $date_eMonth = date_parse($end_month);

        $date1 = $start_year . "-" . $date_sMonth['month'] . "-01";
        $date2 = $end_year . "-" . $date_eMonth['month'] . "-30";

        $time1 = strtotime($date1);
        $time2 = strtotime($date2);
        $my = date('mY', $time2);

        $months = array(date('M', $time1));
        $f = '';

        while ($time1 < $time2) {
            $time1 = strtotime((date('Y-m-d', $time1) . ' +1 month'));
            if (date('M', $time1) != $f) {
                $f = date('M', $time1);
                if (date('mY', $time1) != $my && ($time1 < $time2))
                    $months[] = date('M', $time1);
            }
        }

        $months[] = date('M', $time2);
        return $months;
    }

    public function actual_month() {
        return array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
    }

    public function quarter1() {
        $fy_months = $this->month();
        $quart_1 = php72_array_slice($fy_months, 0, 3);
        $q1_arr = array();
        foreach ($quart_1 as $key => $value) {
            $set_key = date('n', strtotime("$value 1 2020"));
            $q1_arr[$set_key] = $value;
        }
        $q1_arr['13'] = 'qone';
        return $q1_arr;
    }

    public function quarter2() {
        $fy_months = $this->month();
        $quart_2 = php72_array_slice($fy_months, 3, 3);
        $q2_arr = array();
        foreach ($quart_2 as $key => $value) {
            $set_key = date('n', strtotime("$value 1 2020"));
            $q2_arr[$set_key] = $value;
        }
        $q2_arr['14'] = 'qtwo';
        return $q2_arr;
    }

    public function quarter3() {
        $fy_months = $this->month();
        $quart_3 = php72_array_slice($fy_months, 6, 3);
        $q3_arr = array();
        foreach ($quart_3 as $key => $value) {
            $set_key = date('n', strtotime("$value 1 2020"));
            $q3_arr[$set_key] = $value;
        }
        $q3_arr['15'] = 'qthree';
        return $q3_arr;
    }

    public function quarter4() {
        $fy_months = $this->month();
        $quart_4 = php72_array_slice($fy_months, 9, 3);
        $q4_arr = array();
        foreach ($quart_4 as $key => $value) {
            $set_key = date('n', strtotime("$value 1 2020"));
            $q4_arr[$set_key] = $value;
        }
        $q4_arr['16'] = 'qfour';
        return $q4_arr;
    }

    public function allQuarter() {
        $fy_months = $this->month();
        $quart_1 = php72_array_slice($fy_months, 0, 3);
        $quart_2 = php72_array_slice($fy_months, 3, 3);
        $quart_3 = php72_array_slice($fy_months, 6, 3);
        $quart_4 = php72_array_slice($fy_months, 9, 3);
        $q1_arr = $q2_arr = $q3_arr = $q4_arr = array();
        foreach ($quart_1 as $q1) {
            $q1_arr['Q1'] = $q1;
        }
        foreach ($quart_2 as $q2) {
            $q2_arr['Q2'] = $q2;
        }
        foreach ($quart_3 as $q3) {
            $q3_arr['Q3'] = $q3;
        }
        foreach ($quart_4 as $q4) {
            $q4_arr['Q4'] = $q4;
        }
        return php72_array_merge($q1_arr, $q2_arr, $q3_arr, $q4_arr);
    }

    public function get_months($date1, $date2) {
        $time1 = strtotime($date1);
        $time2 = strtotime($date2);
        $my = date('mY', $time2);

        $months = array(date('M-Y', $time1));

        while ($time1 < $time2) {
            $time1 = strtotime(date('Y-m-d', $time1) . ' +1 month');
            if (date('mY', $time1) != $my && ($time1 < $time2))
                $months[] = date('M-Y', $time1);
        }
        $end_date = date('M-Y', $time2);
        if (!in_array($end_date, $months)) {
            $months[] = date('M-Y', $time2);
        }
        return $months;
    }

    public function qualitativeFilters() {
        $inv_id = $this->input->post('inv_id');
        $data['fin_year'] = $fin_year = $this->input->post('f_year');

        $qtr = $this->input->post('quarter');
        $type = $this->input->post('type');
        $actual_table = $this->input->post('actual_table') != '' ? $this->input->post('actual_table') : 'plan_qualitative_data';
        $column_name = $this->input->post('actual_field') != '' ? $this->input->post('actual_field') : 'description';

        $module_id = $this->input->post('module_id');

        $fields = array('financial_year', 'month', 'created_at');
        array_push($fields, $column_name . ' as description');
        $actual_fields = implode(',', $fields);

        $fy_months = $this->month();
        $quart_1 = php72_array_slice($fy_months, 0, 3);
        $quart_2 = php72_array_slice($fy_months, 3, 3);
        $quart_3 = php72_array_slice($fy_months, 6, 3);
        $quart_4 = php72_array_slice($fy_months, 9, 3);
        $q1_arr = $q2_arr = $q3_arr = $q4_arr = array();
        $q1_arr_desc = $q2_arr_desc = $q3_arr_desc = $q4_arr_desc = array();
        $q1_arr_month = $q2_arr_month = $q3_arr_month = $q4_arr_month = array();

        if ($qtr != 5) {
            if ($qtr == 1) {
                foreach ($quart_1 as $key => $value) {
                    $set_key = date('n', strtotime("$value 1 2020"));
                    $q1_arr[$set_key] = $value;
                    $q1_arr_desc[] = strtolower($value) . '_desc';
                    $q1_arr_month[strtolower($value) . '_desc'] = $set_key;
                    $q1_arr_month_num[] = $set_key;
                }
                $setQtr_fields = array('q_one_desc', 'created_at');
                $qtr_fields = php72_array_merge($setQtr_fields, $q1_arr_desc);
                $month = $q1_arr_month_num;
                $setQtr_loop = array('q_one_desc' => 0);
                $data['qtr_loop'] = php72_array_merge($setQtr_loop, $q1_arr_month);
                $data['month_title'] = $q1_arr;
            } else if ($qtr == 2) {
                foreach ($quart_2 as $key => $value) {
                    $set_key = date('n', strtotime("$value 1 2020"));
                    $q2_arr[$set_key] = $value;
                    $q2_arr_desc[] = strtolower($value) . '_desc';
                    $q2_arr_month[strtolower($value) . '_desc'] = $set_key;
                    $q2_arr_month_num[] = $set_key;
                }
                $setQtr_fields = array('q_two_desc', 'created_at');
                $qtr_fields = php72_array_merge($setQtr_fields, $q2_arr_desc);
                $month = $q2_arr_month_num;
                $setQtr_loop = array('q_two_desc' => 0);
                $data['qtr_loop'] = php72_array_merge($setQtr_loop, $q2_arr_month);
                $data['month_title'] = $q2_arr;
            } else if ($qtr == 3) {
                foreach ($quart_3 as $key => $value) {
                    $set_key = date('n', strtotime("$value 1 2020"));
                    $q3_arr[$set_key] = $value;
                    $q3_arr_desc[] = strtolower($value) . '_desc';
                    $q3_arr_month[strtolower($value) . '_desc'] = $set_key;
                    $q3_arr_month_num[] = $set_key;
                }
                $setQtr_fields = array('q_three_desc', 'created_at');
                $qtr_fields = php72_array_merge($setQtr_fields, $q3_arr_desc);
                $month = $q3_arr_month_num;
                $setQtr_loop = array('q_three_desc' => 0);
                $data['qtr_loop'] = php72_array_merge($setQtr_loop, $q3_arr_month);
                $data['month_title'] = $q3_arr;
            } else if ($qtr == 4) {
                foreach ($quart_4 as $key => $value) {
                    $set_key = date('n', strtotime("$value 1 2020"));
                    $q4_arr[$set_key] = $value;
                    $q4_arr_desc[] = strtolower($value) . '_desc';
                    $q4_arr_month[strtolower($value) . '_desc'] = $set_key;
                    $q4_arr_month_num[] = $set_key;
                }
                $setQtr_fields = array('q_four_desc', 'created_at');
                $qtr_fields = array_merge($setQtr_fields, $q4_arr_desc);
                $month = $q4_arr_month_num;
                $setQtr_loop = array('q_four_desc' => 0);
                $data['qtr_loop'] = array_merge($setQtr_loop, $q4_arr_month);
                $data['month_title'] = $q4_arr;
            }

            $plan_qual_fields = implode(',', $qtr_fields);
            $actual_qual_fields = php72_implode(',', $month);

            if ($module_id != '') {
                $conds = "inv_id = '" . $inv_id . "' and financial_year = '" . $fin_year . "' and module_id = '" . $module_id . "'";
            } else {
                $conds = "inv_id = '" . $inv_id . "' and financial_year = '" . $fin_year . "'";
            }

            $data['plan_qual'] = $this->Mportfolio->getQualitativeChart('port_qualitative_data', $conds, $qtr_fields, 1);

            if ($module_id != '' && $actual_table == 'plan_qualitative_data') {
                $actualconds = "inv_id = '" . $inv_id . "' and financial_year = '" . $fin_year . "' and module_id = '" . $module_id . "'";
            } else {
                $actualconds = "inv_id = '" . $inv_id . "' and financial_year = '" . $fin_year . "'";
            }

            $i = 1;
            $actual_qual = array();
            foreach ($month as $mon) {
                $month_cond = "month = " . $mon;
                $data['actual_qual'][$mon] = $this->Mportfolio->getQualitativeActualChart($actual_table, $actual_fields, $actualconds, $month_cond, 3);
                $i++;
            }
        } else {
            $data['qtr_fields'] = $qtr_fields = array('q_one_desc', 'apr_desc', 'may_desc', 'jun_desc', 'q_two_desc', 'jul_desc', 'aug_desc', 'sep_desc', 'q_three_desc', 'oct_desc', 'nov_desc', 'dec_desc', 'q_four_desc', 'jan_desc', 'feb_desc', 'mar_desc', 'created_at');
            $data['month'] = $month = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');

            $quarter_align = array();
            foreach ($quart_1 as $key => $value) {
                $set_key = date('n', strtotime("$value 1 2020"));
                $quarter_align['q_one_desc'] = 0;
                $quarter_align[strtolower($value) . '_desc'] = $set_key;
            }
            foreach ($quart_2 as $key => $value) {
                $set_key = date('n', strtotime("$value 1 2020"));
                $quarter_align['q_two_desc'] = 0;
                $quarter_align[strtolower($value) . '_desc'] = $set_key;
            }
            foreach ($quart_3 as $key => $value) {
                $set_key = date('n', strtotime("$value 1 2020"));
                $quarter_align['q_three_desc'] = 0;
                $quarter_align[strtolower($value) . '_desc'] = $set_key;
            }
            foreach ($quart_4 as $key => $value) {
                $set_key = date('n', strtotime("$value 1 2020"));
                $quarter_align['q_four_desc'] = 0;
                $quarter_align[strtolower($value) . '_desc'] = $set_key;
            }

//            $data['qtr_loop'] = array('q_one_desc' => 0, 'jan_desc' => 1, 'feb_desc' => 2, 'mar_desc' => 3, 'q_two_desc' => 0, 'jul_desc' => 7, 'aug_desc' => 8, 'sep_desc' => 9, 'q_three_desc' => 0, 'oct_desc' => 10, 'nov_desc' => 11, 'dec_desc' => 12, 'q_four_desc' => 0, 'jan_desc' => 1, 'feb_desc' => 2, 'mar_desc' => 3);
            $data['qtr_loop'] = $quarter_align;
            $data['month_title'] = array(4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec', 1 => 'Jan', 2 => 'Feb', 3 => 'Mar');
            $plan_qual_fields = implode(',', $qtr_fields);
            $actual_qual_fields = php72_implode(',', $month);

            if ($module_id != '') {
                $conds = "inv_id = '" . $inv_id . "' and financial_year = '" . $fin_year . "' and module_id = '" . $module_id . "'";
            } else {
                $conds = "inv_id = '" . $inv_id . "' and financial_year = '" . $fin_year . "'";
            }

            $data['plan_qual'] = $this->Mportfolio->getQualitativeChart('port_qualitative_data', $conds, $qtr_fields, 1);

            if ($module_id != '' && $actual_table == 'plan_qualitative_data') {
                $actualconds = "inv_id = '" . $inv_id . "' and financial_year = '" . $fin_year . "' and module_id = '" . $module_id . "'";
            } else {
                $actualconds = "inv_id = '" . $inv_id . "' and financial_year = '" . $fin_year . "'";
            }

            $i = 1;
            $actual_qual = array();
            foreach ($month as $mon) {
                $month_cond = "month = " . $mon;
                $data['actual_qual'][$mon] = $this->Mportfolio->getQualitativeActualChart($actual_table, $actual_fields, $actualconds, $month_cond, 3);
                $i++;
            }
        }

        $data['get_month_list'] = $this->month();
        $this->load->vars($data);
        if ($module_id == '' || $module_id == 1 || $module_id == 2) {
            $this->load->view('portfolio/dashboard_qualitative/product_qualitative');
        } else if ($module_id == 5 || $module_id == 6 || $module_id == 8) {
            $this->load->view('portfolio/dashboard_qualitative/finance_fundraise');
        } else if ($module_id == 14) {
            $this->load->view('portfolio/dashboard_qualitative/impact_qualitative');
        } else if ($module_id == 15 || $module_id == 13) {
            $this->load->view('portfolio/dashboard_qualitative/team_qualitative');
        } else if ($module_id == 9 || $module_id == 10 || $module_id == 11) {
            $this->load->view('portfolio/dashboard_qualitative/mentor_qualitative');
        } else if ($module_id == 12) {
            $this->load->view('portfolio/dashboard_qualitative/diagnostic_qualitative');
        } else if ($module_id == 7) {
            $this->load->view('portfolio/dashboard_qualitative/seed_qualitative');
        }
    }

    public function allCompanySales() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
//        $g_quarter = '1';

        $inv_id = $this->input->post('inv_id');
        $ajax_sales_id = $this->input->post('sales_id');
        $sales_id = isset($ajax_sales_id) && $ajax_sales_id != '' ? $ajax_sales_id : '';
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $g_quarter = $this->input->post('quarter');
        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
			#CR CHANGE
            #$search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
			$dynamicConditions = "(FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$search_where[] = $search_month[] = $search_quarter[] = $dynamicConditions;
			#CR CHANGE
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

//            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $nxt_year";
            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if ($type == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);

            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $month_where = php72_implode(" and ", $search_month);
            $monthly_target = $this->Mportfolio->getTargetSales($month_where, $sales_id,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualSales($month_where, $sales_id,$g_sector);
			 
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            if ($sales_id == '') {
                                $target_column = $value['value'];
                            } else {
                                $target_column = $value['volume'];
                            }
                            $datavalues = json_decode($target_column, TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $cost;
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($sales_id == '') {
                                $actual_column = $value['value'];
                            } else {
                                $actual_column = $value['volume'];
                            }
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $actual_column);
                                $rev_cost = str_replace(',', '', $result['value']);
                                $hc_actual[$m] += $actual_cost;
                            } else {
                                $hc_actual[$m] = isset($actual_column) && $actual_column != '' ? str_replace(',', '', $actual_column) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if ($type == 20) {
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            if ($from_quarter == 4) {
                $nxt_from_yr = $from_year + 1;
            } else {
                $nxt_from_yr = $from_year;
            }

            if ($to_quarter == 4) {
                $nxt_to_yr = $getTo_year + 1;
            } else {
                $nxt_to_yr = $getTo_year;
            }

            $q_StartDate = $nxt_from_yr . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);
            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $getTo_year";
            $quarter_where = implode(" and ", $search_quarter);
            $repeat_arr = array();

            $monthly_target = $this->Mportfolio->getTargetSales($quarter_where, $sales_id,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualSales($quarter_where, $sales_id,$g_sector);

            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            if ($sales_id == '') {
                                $target_column = $value['value'];
                            } else {
                                $target_column = $value['volume'];
                            }
                            $datavalues = json_decode($target_column, TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $cost;
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }
            $m = 0;
            foreach ($search_array as $k => $name) {
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($sales_id == '') {
                                $actual_column = $value['value'];
                            } else {
                                $actual_column = $value['volume'];
                            }
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $actual_column);
                                $rev_cost = str_replace(',', '', $result['value']);
                                $fetch_target[$m]['actual'] += $actual_cost;
// $repeat_arr[$value['month']] += $actual_cost;
                            } else {
                                $fetch_target[$m]['actual'] = isset($actual_column) && $actual_column != '' ? str_replace(',', '', $actual_column) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }

            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);

            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] += $value['target'];
                    $hc_actual[$q] += $value['actual'];
                }
            }
        } else {
            $sales_target = $this->Mportfolio->getTargetSales($default_where, $sales_id,$g_sector);
		
            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($sales_target) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    $categories[0] = 'Q1';
                    $categories[1] = 'Q2';
                    $categories[2] = 'Q3';
                    $categories[3] = 'Q4';
                    $categories[4] = 'Annual';
                    $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
                    $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';

                    foreach ($sales_target as $target) {
                        if ($sales_id == '') {
                            $target_column = $target['value'];
                        } else {
                            $target_column = $target['volume'];
                        }
                        $get_data = json_decode($target_column);
                        foreach ($get_data as $key => $value) {
                            if (php72_in_array($key, $q1)) {
                                $q1_val += str_replace(',', '', $value);
                                $hc_target[0] = $q1_val;
                            }
                            if (php72_in_array($key, $q2)) {
                                $q2_val += str_replace(',', '', $value);
                                $hc_target[1] = $q2_val;
                            }
                            if (php72_in_array($key, $q3)) {
                                $q3_val += str_replace(',', '', $value);
                                $hc_target[2] = $q3_val;
                            }
                            if (php72_in_array($key, $q4)) {
                                $q4_val += str_replace(',', '', $value);
                                $hc_target[3] = $q4_val;
                            }
                        }
                    }

                    $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
                    $categories[4] = 'Annual';
                    $hc_target[4] = $annual_target;
                } else {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($sales_target as $target) {
                        if ($sales_id == '') {
                            $target_column = $target['value'];
                        } else {
                            $target_column = $target['volume'];
                        }
                        $get_data = json_decode($target_column);
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $target_month_value[$value] += str_replace(',', '', $get_data->$value);
                            $categories[$k] = $value;
                            $hc_actual[$k] = '0';
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && $g_quarter != 5) {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $sales_actual = $this->Mportfolio->getActualSales($default_where, $sales_id,$g_sector);
            $actual_month_value = array();
            if (php72_count($sales_actual) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    foreach ($sales_actual as $actual) {
                        if ($sales_id == '') {
                            $actual_column = $actual['value'];
                        } else {
                            $actual_column = $actual['volume'];
                        }
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_val += str_replace(',', '', $actual_column);
                            $hc_actual[0] = $a1_val;
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_val += str_replace(',', '', $actual_column);
                            $hc_actual[1] = $a2_val;
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_val += str_replace(',', '', $actual_column);
                            $hc_actual[2] = $a3_val;
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_val += str_replace(',', '', $actual_column);
                            $hc_actual[3] = $a4_val;
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    foreach ($sales_actual as $actual) {
                        if ($sales_id == '') {
                            $actual_column = $actual['value'];
                        } else {
                            $actual_column = $actual['volume'];
                        }
                        foreach ($main_quarter as $key => $value) {
                            if ($key == $actual['month']) {
                                $actual_month_value[$value] += str_replace(',', '', $actual_column);
                            }
                        }
                    }
                    $k = 0;
                    foreach ($actual_month_value as $mv => $mv_amt) {
                        $hc_actual[$k] = $mv_amt;
                        $k++;
                    }
                    $hc_actual[3] = array_sum($actual_month_value);
                }
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        if ($sales_id == '') {
            $sales_title = $this->input->post('graph_title');
            $cur_val = $this->session->userdata['currency'];
            if ($cur_val == 'INR') {
                $sales_yaxis = "INR (In Lakhs)";
            } else {
                $sales_yaxis = "USD (In '000's)";
            }
        } else {
            $sales_cond['id'] = $sales_id;
            $get_unit = $this->Mportfolio->getSalesMaster('port_sales_data', $sales_cond);
            if ($get_unit[0]['unit'] != '') {
                $sales_yaxis = "Sales SKUs (" . trim($get_unit[0]['unit']) . ")";
            } else {
                $sales_yaxis = 'Sales SKUs';
            }
            $sales_title = 'Sales - ' . $this->input->post('graph_title');
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'salesDiv_' . $id;
        $data['heading'] = $sales_title;
        $data['yaxis_text'] = $sales_yaxis;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $data['current_year'] = $g_year;
        $data['current_quarter'] = $g_quarter;
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allSales_HC');
//        $this->load->view('portfolio/dashboard_chart/sales_combo');
    }

    public function sales_sku_list() {
        $sales_cond['inv_id'] = $this->input->post('inv_id');
        $sales_fyear = $this->input->post('f_year');
        $get_unit = $this->Mportfolio->getSalesMaster('port_sales_data', $sales_cond, $sales_fyear, 1);
        echo json_encode($get_unit);
    }

    public function allRevenue() {
		#echo'<pre>';print_r($_POST);die;
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            #$search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
			#$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0))";
			$dynamicConditions = "(FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$search_where[] = $search_month[] = $search_quarter[] = $dynamicConditions;
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();
	   
        if ($type == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);
			
			// $search_month[] = "t2.sector = '$g_sector'";
            
			$search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $month_where = php72_implode(" and ", $search_month);

            $monthly_target = $this->Mportfolio->getTargetRevenue($month_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualRevenue($month_where,$g_sector);
			//$this->session->userdata('portfolio_summary_year')
			
			//echo'<pre>';print_r($month_where);
			//echo'<pre>';print_r($monthly_target);die;
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = ($search_array[$values] + $cost)/2;
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
//                        if (is_array($value) && !isset($hc_actual[$m])) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['revenue']);
                                $rev_cost = str_replace(',', '', $result['revenue']);
                                #$hc_actual[$m] += $actual_cost;
								$hc_actual[$m] = $actual_cost;
                            } else {
                                $hc_actual[$m] = isset($value['revenue']) && $value['revenue'] != '' ? str_replace(',', '', $value['revenue']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
//                            $hc_actual[$m] = isset($value['revenue']) && $value['revenue'] != '' ? str_replace(',', '', $value['revenue']) : 0;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if ($type == 20) {
            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $getTo_year";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetRevenue($quarter_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualRevenue($quarter_where,$g_sector);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $cost;
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['revenue']);
                                $rev_cost = str_replace(',', '', $result['revenue']);
                                $fetch_target[$m]['actual'] += $actual_cost;
                            } else {
                                $fetch_target[$m]['actual'] = isset($value['revenue']) && $value['revenue'] != '' ? str_replace(',', '', $value['revenue']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }

            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);

            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] += $value['target'];
                    $hc_actual[$q] += $value['actual'];
                }
            }
        } else {
			
            $revenue_target = $this->Mportfolio->getTargetRevenue($default_where,$g_sector);
			$target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
			
            if (php72_count($revenue_target) > 0) {
			
					/* echo'<pre>';print_r($g_quarter);
					echo'<pre>';print_r($revenue_target);die; */
                if ($g_quarter == '' || $g_quarter == 5) {
						
				
                    foreach ($revenue_target as $target) {
                        $get_data = json_decode($target['data']);
                        foreach ($get_data as $key => $value) { 
                            if (php72_in_array($key, $q1)) { 
                                $q1_val += str_replace(',', '', $value);
                                #$hc_target[0] = $q1_val;
								$hc_target[0] = ($q1_val/2);
                            }
                            if (php72_in_array($key, $q2)) {
                                $q2_val += str_replace(',', '', $value);
                                #$hc_target[1] = $q2_val;
                                $hc_target[1] = ($q2_val/2);
                            }
                            if (php72_in_array($key, $q3)) {
                                $q3_val += str_replace(',', '', $value);
                                #$hc_target[2] = $q3_val;
                                $hc_target[2] = ($q3_val/2);
                            }
                            if (php72_in_array($key, $q4)) {
                                $q4_val += str_replace(',', '', $value);
                                #$hc_target[3] = $q4_val;
								$hc_target[3] =($q4_val/2);
                            }
                        }
                    }
					 #echo'<pre>';print_r($q1_val);
                    $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
                    $categories[4] = 'Annual';
                    #$hc_target[4] = $annual_target;
                    $hc_target[4] = ($annual_target/2);
                } else {
					
            
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($revenue_target as $target) {
                        $get_data = json_decode($target['data']);
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $target_month_value[$value] += str_replace(',', '', $get_data->$value);
                            $categories[$k] = $value;
                            $hc_actual[$k] = '0';
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && $g_quarter != 5) {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $revenue_actual = $this->Mportfolio->getActualRevenue($default_where,$g_sector);
			//echo'<pre>';print_r($revenue_actual);die;
			
            $actual_month_value = array();
            if (php72_count($revenue_actual) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    foreach ($revenue_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_val += str_replace(',', '', $actual['revenue']);
                            $hc_actual[0] = $a1_val;
							#$hc_actual[0] = ($a1_val/2);
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_val += str_replace(',', '', $actual['revenue']);
                            $hc_actual[1] = $a2_val;
                            #$hc_actual[1] = ($a2_val/2);
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_val += str_replace(',', '', $actual['revenue']);
                            $hc_actual[2] = $a3_val;
                            #$hc_actual[2] = ($a3_val/2);
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_val += str_replace(',', '', $actual['revenue']);
                            $hc_actual[3] = $a4_val;
                            #$hc_actual[3] =($a4_val/2);
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                    #$hc_actual[4] = ($annual_acheive/2);
                } else {
                    foreach ($revenue_actual as $actual) {
                        foreach ($main_quarter as $key => $value) {
                            if ($key == $actual['month']) {
                                $actual_month_value[$value] += str_replace(',', '', $actual['revenue']);
                            }
                        }
                    }
                    $k = 0;
                    foreach ($actual_month_value as $mv => $mv_amt) {
                        $hc_actual[$k] = $mv_amt;
                        $k++;
                    }
                    $hc_actual[3] = array_sum($actual_month_value);
                }
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'revenueDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
//        $this->load->view('portfolio/dashboard_chart/revenue_combo');
    }

    public function allProfit() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            #$search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
			$dynamicConditions = "(FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$search_where[] = $search_month[] = $search_quarter[] = $dynamicConditions;
           
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if ($type == 1) {

            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);

            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $month_where = php72_implode(" and ", $search_month);
            $monthly_target = $this->Mportfolio->getTargetProfit($month_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualProfit($month_where,$g_sector);
			#ECHO'<pre>';print_r($monthly_actual);die;
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $cost;
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }
            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['net_profit']);
                                $rev_cost = str_replace(',', '', $result['net_profit']);
                                #$hc_actual[$m] += $actual_cost;
								$hc_actual[$m] = $actual_cost;
                            } else {
                                $hc_actual[$m] = str_replace(',', '', $value['net_profit']);
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if ($type == 20) {
            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $getTo_year";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetProfit($quarter_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualProfit($quarter_where,$g_sector);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $cost;
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
			// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['net_profit']);
                                $rev_cost = str_replace(',', '', $result['net_profit']);
                                $fetch_target[$m]['actual'] += $actual_cost;
                            } else {
                                $fetch_target[$m]['actual'] = str_replace(',', '', $value['net_profit']);
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }

            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);

            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] += $value['target'];
                    $hc_actual[$q] += $value['actual'];
                }
            }
        } else {
            $profit_target = $this->Mportfolio->getTargetProfit($default_where,$g_sector);
            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($profit_target) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    foreach ($profit_target as $target) {
                        $get_data = json_decode($target['data']);
                        foreach ($get_data as $key => $value) {
                            if (php72_in_array($key, $q1)) {
                                $q1_val += str_replace(',', '', $value);
                                #$hc_target[0] = round($q1_val, 2);
								$hc_target[0] = round(($q1_val/2), 2);
                            }
                            if (php72_in_array($key, $q2)) {
                                $q2_val += str_replace(',', '', $value);
                                #$hc_target[1] = round($q2_val, 2);
                                $hc_target[1] = round(($q2_val/2), 2);
                            }
                            if (php72_in_array($key, $q3)) {
                                $q3_val += str_replace(',', '', $value);
                                #$hc_target[2] = round($q3_val, 2);
								 $hc_target[2] = round(($q3_val/2), 2);
                            }
                            if (php72_in_array($key, $q4)) {
                                $q4_val += str_replace(',', '', $value);
                                #$hc_target[3] = round($q4_val, 2);
                                $hc_target[3] = round(($q4_val/2), 2);
                            }
                        }
                    }

                    $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
                    $categories[4] = 'Annual';
                    $hc_target[4] = $annual_target;
                } else {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($profit_target as $target) {
                        $get_data = json_decode($target['data']);
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $target_month_value[$value] += str_replace(',', '', $get_data->$value);
                            $categories[$k] = $value;
                            $hc_actual[$k] = '0';
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && $g_quarter != 5) {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $profit_actual = $this->Mportfolio->getActualProfit($default_where,$g_sector);
            $actual_month_value = array();
            if (php72_count($profit_actual) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    foreach ($profit_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_val += str_replace(',', '', $actual['net_profit']);
                            #$hc_actual[0] = $a1_val;
                            $hc_actual[0] = ($a1_val/2);
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_val += str_replace(',', '', $actual['net_profit']);
                            #$hc_actual[1] = $a2_val;
                            $hc_actual[1] = ($a2_val/2);
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_val += str_replace(',', '', $actual['net_profit']);
                            #$hc_actual[2] = $a3_val;
                            $hc_actual[2] = ($a3_val/2);
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_val += str_replace(',', '', $actual['net_profit']);
                            #$hc_actual[3] = $a4_val;
							$hc_actual[3] = ($a4_val/2);
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    foreach ($profit_actual as $actual) {
                        foreach ($main_quarter as $key => $value) {
                            if ($key == $actual['month']) {
                                $actual_month_value[$value] += str_replace(',', '', $actual['net_profit']);
                            }
                        }
                    }
                    $k = 0;
                    foreach ($actual_month_value as $mv => $mv_amt) {
                        $hc_actual[$k] = $mv_amt;
                        $k++;
                    }
                    $hc_actual[3] = array_sum($actual_month_value);
                }
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'profitDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allProfit_HC');
    }

    public function allCapital() {
		#echo'<pre>';print_r(print_r($this->session->all_userdata()));die;
		
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;
        $a1_equity = $a2_equity = $a3_equity = $a4_equity = 0;
        $a1_short = $a2_short = $a3_short = $a4_short = 0;
        $a1_long = $a2_long = $a3_long = $a4_long = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            #$search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
			#CR CHANGE			
			$dynamicConditions = "(FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$search_where[] = $search_month[] = $search_quarter[] = $dynamicConditions;
			#CR CHANGE		
			
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();
	
			
			
        if ($type == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);

            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $month_where = php72_implode(" and ", $search_month);

            $monthly_target = $this->Mportfolio->getTargetCapital($month_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualCapital_graph($month_where,$g_sector);
			
			 
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
					
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $cost;
                                } else {
                                    $search_array[$values] = $cost;
                                }
								
                            } else {
                                /* for new changes  - datemodified - 12/12/2019 */
                                $fund_mons = explode('-', $values);
                                if ($fund_mons[0] == $get_fy_month[2]) {
                                    if (php72_array_key_exists($values, $search_array)) {
                                        $search_array[$values] = $search_array[$values] + str_replace(',', '', $datavalues['qone']);
                                    } else {
                                        $search_array[$values] = str_replace(',', '', $datavalues['qone']);
                                    }
									
								
                                }
                                if ($fund_mons[0] == $get_fy_month[5]) {
                                    if (php72_array_key_exists($values, $search_array)) {
                                        $search_array[$values] = $search_array[$values] + str_replace(',', '', $datavalues['qtwo']);
                                    } else {
                                        $search_array[$values] = str_replace(',', '', $datavalues['qtwo']);
                                    }
                                }
                                if ($fund_mons[0] == $get_fy_month[8]) {
                                    if (php72_array_key_exists($values, $search_array)) {
                                        #$search_array[$values] = $search_array[$values] + str_replace(',', '', $datavalues['qthree']);
										$search_array[$values] = ($search_array[$values] + str_replace(',', '', $datavalues['qthree']))/2;
                                    } else {
                                        $search_array[$values] = str_replace(',', '', $datavalues['qthree']);
                                    }
									
                                }
                                if ($fund_mons[0] == $get_fy_month[11]) {
                                    if (php72_array_key_exists($values, $search_array)) {
                                       # $search_array[$values] = $search_array[$values] + str_replace(',', '', $datavalues['qfour']);
                                        $search_array[$values] = ($search_array[$values] + str_replace(',', '', $datavalues['qfour']))/2;
										
                                    } else {
                                        $search_array[$values] = str_replace(',', '', $datavalues['qfour']);
                                    }
									
                                }
                                /* end of changes */
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
					
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }
			
            $m = 0;
			
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;

                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
				
				if($this->session->userdata('user_id') ==135){
					#echo'<pre>';print_r($new_m);
					/*  foreach ($new_m as $key => $value) {
						  if (is_array($value)) {
								if (is_array($value)) {
									if ($result['month'] == $value['month']) {
										
										} else {
										
									}
									$result[$key] = $value;
								}
							  echo'<pre>';print_r($value['month']);die;
						  }
						 
					 } */
				}
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_equity = str_replace(',', '', $value['equity_total']);
                                $actual_grand = str_replace(',', '', $value['grand_total']);
                                $actual_short = str_replace(',', '', $value['short_total']);
                                $actual_long = str_replace(',', '', $value['long_total']);
                                $actual_totval = str_replace(',', '', $value['total_value']);
//                                $actual_cost = $actual_equity + $actual_grand + $actual_short + $actual_long;
                                $actual_cost = $actual_totval;
                                $rev_equity = str_replace(',', '', $result['equity_total']);
                                $rev_grand = str_replace(',', '', $result['grand_total']);
                                $rev_short = str_replace(',', '', $result['short_total']);
                                $rev_long = str_replace(',', '', $result['long_total']);
                                $rev_cost = $rev_equity + $rev_grand + $rev_short + $rev_long;
                               $hc_actual[$m] += $actual_cost;
                            } else {
                                $actual_equity = str_replace(',', '', $value['equity_total']);
                                $actual_grand = str_replace(',', '', $value['grand_total']);
                                $actual_short = str_replace(',', '', $value['short_total']);
                                $actual_long = str_replace(',', '', $value['long_total']);
                                $actual_totval = str_replace(',', '', $value['total_value']);
//                                $actual_cost = $actual_equity + $actual_grand + $actual_short + $actual_long;
                                $actual_cost = $actual_totval;
                                #$hc_actual[$m] = $actual_cost;
                                $hc_actual[$m] = $actual_cost;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
			/* if($this->session->userdata('user_id') ==135){
				# echo'<pre>';print_r($hc_actual);die;
			} */
        } else if ($type == 20) {
            $quarter_qone = $quarter_qtwo = $quarter_qthree = $quarter_qfour = array();

            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $getTo_year";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetCapital($quarter_where,$g_sector);
            #$monthly_actual = $this->Mportfolio->getActualCapital($quarter_where,$g_sector);
			$monthly_actual = $this->Mportfolio->getActualCapital_graph($quarter_where,$g_sector);
            $mr = 0;

            if (php72_count($monthly_target) > 0) {

                foreach ($monthly_target as $key => $value) {
                    foreach ($date_diff as $keys => $values) {

                        $yearvalues = explode('-', $values);
                        if (php72_in_array($yearvalues[0], $q4)) {
                            if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                                $yearvalues[1] = $yearvalues[1] - 1;
                            }
                        } else {
                            $yearvalues[1] = $yearvalues[1];
                        }
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {

                            } else {
                                if (php72_in_array($yearvalues[0], $q1)) {
                                    $cost = str_replace(',', '', $datavalues['qone']);
                                    if (isset($quarter_qone[$mr])) {
                                        $ss = isset($quarter_qone[$mr]) && $quarter_qone[$mr] != '' ? $quarter_qone[$mr] : ($cost != '' ? $cost : 0);
                                        $search_array[$values] = php72_array_sum($quarter_qone);
                                    } else {
                                        $quarter_qone[$mr] = $cost;
                                        $search_array[$values] = php72_array_sum($quarter_qone);
                                    }
                                } else if (php72_in_array($yearvalues[0], $q2)) {
                                    $cost = str_replace(',', '', $datavalues['qtwo']);
                                    if (isset($quarter_qtwo[$mr])) {
                                        $ss = isset($quarter_qtwo[$mr]) && $quarter_qtwo[$mr] != '' ? $quarter_qtwo[$mr] : ($cost != '' ? $cost : 0);
                                        $search_array[$values] = php72_array_sum($quarter_qtwo);
                                    } else {
                                        $quarter_qtwo[$mr] = $cost;
                                        $search_array[$values] = php72_array_sum($quarter_qtwo);
                                    }
                                } else if (php72_in_array($yearvalues[0], $q3)) {
                                    $cost = str_replace(',', '', $datavalues['qthree']);
                                    if (isset($quarter_qthree[$mr])) {
                                        $ss = isset($quarter_qthree[$mr]) && $quarter_qthree[$mr] != '' ? $quarter_qthree[$mr] : ($cost != '' ? $cost : 0);
                                        $search_array[$values] = php72_array_sum($quarter_qthree);
                                    } else {
                                        $quarter_qthree[$mr] = $cost;
                                        $search_array[$values] = php72_array_sum($quarter_qthree);
                                    }
                                } else if (php72_in_array($yearvalues[0], $q4)) {
                                    $cost = str_replace(',', '', $datavalues['qfour']);
                                    if (isset($quarter_qfour[$mr])) {
                                        $ss = isset($quarter_qfour[$mr]) && $quarter_qfour[$mr] != '' ? $quarter_qfour[$mr] : ($cost != '' ? $cost : 0);
                                        $search_array[$values] = array_sum($quarter_qfour);
                                    } else {
                                        $quarter_qfour[$mr] = $cost;
                                        $search_array[$values] = array_sum($quarter_qfour);
                                    }
                                }
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                    $mr++;
                }
            } else {
                foreach ($date_diff as $keys => $values) {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value) && !isset($fetch_target[$m])) {
                            if ($result['month'] == $value['month']) {
                                $actual_equity = str_replace(',', '', $value['equity_total']);
                                $actual_grand = str_replace(',', '', $value['grand_total']);
                                $actual_short = str_replace(',', '', $value['short_total']);
                                $actual_long = str_replace(',', '', $value['long_total']);
                                $actual_totval = str_replace(',', '', $value['total_value']);
//                                $actual_cost = $actual_equity + $actual_grand + $actual_short + $actual_long;
                                $actual_cost = $actual_totval;
                                $rev_equity = str_replace(',', '', $result['equity_total']);
                                $rev_grand = str_replace(',', '', $result['grand_total']);
                                $rev_short = str_replace(',', '', $result['short_total']);
                                $rev_long = str_replace(',', '', $result['long_total']);
                                $rev_cost = $rev_equity + $rev_grand + $rev_short + $rev_long;
                                $fetch_target[$m]['actual'] += $actual_cost;
                            } else {
                                $actual_equity = str_replace(',', '', $value['equity_total']);
                                $actual_grand = str_replace(',', '', $value['grand_total']);
                                $actual_short = str_replace(',', '', $value['short_total']);
                                $actual_long = str_replace(',', '', $value['long_total']);
                                $actual_totval = str_replace(',', '', $value['total_value']);
//                                $actual_cost = $actual_equity + $actual_grand + $actual_short + $actual_long;
                                $actual_cost = $actual_totval;
                                $fetch_target[$m]['actual'] = $actual_cost;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }

            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);
            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] = $value['target'];
                    $hc_actual[$q] += $value['actual'];
                }
            }
        } else {
            $capital_target = $this->Mportfolio->getTargetCapital($default_where,$g_sector);
            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($capital_target) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    foreach ($capital_target as $target) {
                        $get_data = json_decode($target['data']);
                        foreach ($get_data as $key => $value) {
                            if (php72_in_array($key, $q1)) {
                                $q1_val += str_replace(',', '', $value);
                               # $hc_target[0] = $q1_val;
                                $hc_target[0] = ($q1_val/2);
                            }
                            if (php72_in_array($key, $q2)) {
                                $q2_val += str_replace(',', '', $value);
                                #$hc_target[1] = $q2_val;
                                $hc_target[1] = ($q2_val/2);
                            }
                            if (php72_in_array($key, $q3)) {
                                $q3_val += str_replace(',', '', $value);
                                #$hc_target[2] = $q3_val;
                                $hc_target[2] = ($q3_val/2);
                            }
                            if (php72_in_array($key, $q4)) {
                                $q4_val += str_replace(',', '', $value);
                                #$hc_target[3] = $q4_val;
                                $hc_target[3] = ($q4_val/2);
                            }
                        }
                    }

                    $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
                    $categories[4] = 'Annual';
                    #$hc_target[4] = $annual_target;
                    $hc_target[4] = ($annual_target/2);
                } else {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($capital_target as $target) {
                        $get_data = json_decode($target['data']);
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $target_month_value[$value] += str_replace(',', '', $get_data->$value);
                            $categories[$k] = $value;
                            $hc_actual[$k] = '0';
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && $g_quarter != 5) {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $capital_actual = $this->Mportfolio->getActualCapital_graph($default_where,$g_sector);
			#$capital_actual = $this->Mportfolio->getActualCapital($default_where,$g_sector);
            $actual_month_value = $actual_month_equity = $actual_month_short = $actual_month_long = array();
            if (php72_count($capital_actual) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    foreach ($capital_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_equity += str_replace(',', '', $actual['equity_total']);
                            $a1_grand += str_replace(',', '', $actual['grand_total']);
                            $a1_short += str_replace(',', '', $actual['short_total']);
                            $a1_long += str_replace(',', '', $actual['long_total']);
                            $a1_totval = str_replace(',', '', $actual['total_value']);
//                            $a1_val = $a1_equity + $a1_grand + $a1_short + $a1_long;
                            $a1_val = $a1_totval;
                            $hc_actual[0] = $a1_val;
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_equity += str_replace(',', '', $actual['equity_total']);
                            $a2_grand += str_replace(',', '', $actual['grand_total']);
                            $a2_short += str_replace(',', '', $actual['short_total']);
                            $a2_long += str_replace(',', '', $actual['long_total']);
                            $a2_totval = str_replace(',', '', $actual['total_value']);
//                            $a2_val = $a2_equity + $a2_grand + $a2_short + $a2_long;
                            $a2_val = $a2_totval;
                            $hc_actual[1] = $a2_val;
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_equity += str_replace(',', '', $actual['equity_total']);
                            $a3_grand += str_replace(',', '', $actual['grand_total']);
                            $a3_short += str_replace(',', '', $actual['short_total']);
                            $a3_long += str_replace(',', '', $actual['long_total']);
                            $a3_totval = str_replace(',', '', $actual['total_value']);
//                            $a3_val = $a3_equity + $a3_grand + $a3_short + $a3_long;
                            $a3_val = $a3_totval;
                            $hc_actual[2] = $a3_val;
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_equity += str_replace(',', '', $actual['equity_total']);
                            $a4_grand += str_replace(',', '', $actual['grand_total']);
                            $a4_short += str_replace(',', '', $actual['short_total']);
                            $a4_long += str_replace(',', '', $actual['long_total']);
                            $a4_totval = str_replace(',', '', $actual['total_value']);
//                            $a4_val = $a4_equity + $a4_grand + $a4_short + $a4_long;
                            $a4_val = $a4_totval;
                            $hc_actual[3] = $a4_val;
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    foreach ($capital_actual as $actual) {
                        foreach ($main_quarter as $key => $value) {
                            if ($key == $actual['month']) {
                                $actual_month_equity[$value] += str_replace(',', '', $actual['equity_total']);
                                $actual_month_grand[$value] += str_replace(',', '', $actual['grand_total']);
                                $actual_month_short[$value] += str_replace(',', '', $actual['short_total']);
                                $actual_month_long[$value] += str_replace(',', '', $actual['long_total']);
                                $actual_month_total[$value] += str_replace(',', '', $actual['total_value']);
//                            $actual_month_value[$value] += $actual_month_equity[$value] + $actual_month_grand[$value] + $actual_month_short[$value] + $actual_month_long[$value];
                                $actual_month_value[$value] += $actual_month_total[$value];
                            }
                        }
                    }
                    $k = 0;
                    foreach ($actual_month_value as $mv => $mv_amt) {
                        $hc_actual[$k] = $mv_amt;
                        $k++;
                    }
                    $hc_actual[3] = php72_array_sum($actual_month_value);
                }
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            #array_push($derive_actual, round($hc_actual[$m], 2));
            array_push($derive_actual, round(($hc_actual[$m]/2), 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'capitalDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allCapital_HC');
    }

    public function allRecruitment() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');
//        $g_quarter = '1';

        $inv_id = $this->input->post('inv_id');
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $g_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $startDate = $get_fy_month[0] . ', ' . $g_year;
        $endDate = $get_fy_month[11] . ', ' . $nxt_year;

        $searchArray = array();
        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);
        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);

            if ($startDate != '' && $endDate != '') {
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));
                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                if (in_array($fin_smonth, $q4_key)) {
                    if ($fin_smonth == 1 || $fin_smonth == 2 || $fin_smonth == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if ($fin_emonth == 1 || $fin_emonth == 2 || $fin_emonth == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }

//            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_year";
        }
        if ($startDate != '') {
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if ($sdatefmt == 1 || $sdatefmt == 2 || $sdatefmt == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if ($edatefmt == 1 || $edatefmt == 2 || $edatefmt == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }

            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $st_year";
//                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $end_yr";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $to_date = date("Y-m-d", strtotime($endDate));
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y-m-d");
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }
		#CR CHANGE
        if ($g_sector != '') {
            #$searchArray[] = "t2.sector = '$g_sector'";
			#$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)) AND ";
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";

			$dynamicConditions = rtrim($dynamicConditions, " AND ");
			$searchArray[] = $dynamicConditions;	
        }
		#CR CHANGE

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }
        $where = implode(" and ", $searchArray);
		
        $q1_val = $q2_val = $q3_val = $q4_val = 0;
        $master_list = $this->Mportfolio->getTargetTeamHiring($where, $startDate, '', '1', 'new_employee');
		
        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();
		
        if ($ftype != 1) {
            $total_list = $this->Mportfolio->getActualTeamHiring($where, $startDate, '', '1', '1');
			#echo'<pre>';print_r($total_list);die;
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            foreach ($master_list as $rec) {
                $getdata = json_decode($rec['new_employee']);
                foreach ($getdata as $key => $value) {
                    if ($key == 'q1') {
                        $q1_val += str_replace(',', '', $value);
                        $target[0] = $q1_val;
                        $actual[0] = '0';
                    }
                    if ($key == 'q2') {
                        $q2_val += str_replace(',', '', $value);
                        $target[1] = $q2_val;
                        $actual[1] = '0';
                    }
                    if ($key == 'q3') {
                        $q3_val += str_replace(',', '', $value);
                        $target[2] = $q3_val;
                        $actual[2] = '0';
                    }
                    if ($key == 'q4') {
                        $q4_val += str_replace(',', '', $value);
                        $target[3] = $q4_val;
                        $actual[3] = '0';
                    }
                }
            }

            $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
            $categories[4] = 'Annual';
            $target[4] = $annual_target;

            $actual[0] = $total_list[0]['q1'];
            $actual[1] = $total_list[0]['q2'];
            $actual[2] = $total_list[0]['q3'];
            $actual[3] = $total_list[0]['q4'];
            $actual[4] = $total_list[0]['annual'];
        } else {
            $recs_act = array();
            $total_list = $this->Mportfolio->getMonthlyActualTeamHiring($where, $startDate, '', '1', '1');
			#echo'<pre>';print_r($total_list);die;
            if (php72_count($total_list) > 0) {
                foreach ($total_list as $tot) {
                    $t = 0;
                    foreach ($date_diff as $values) {
                        $categories[$t] = $values;
                        if (isset($recs_act[$values])) {
                            $rec_actquat[$values] = $rec_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            $finyr = $datavalues . '-' . $tot['financial_year'];

                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $check_month = $expmonth[0] . '-' . $expmonth[1];
                            if ($datavalues == $expmonth[0] && $finyr == $check_month) {
                                $rec_actquat[$values] = $tot['t_count'];
                                $recs_act[$values] = 1;
                            }
                        }
                        $t++;
                    }
                }
            } else {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }
            $ac = 0;
            foreach ($categories as $cate) {
                $actual[$ac] = $rec_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }
                if (php72_count($master_list) > 0) {
                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            $getdata = json_decode($mas_tar['new_employee']);

                            foreach ($getdata as $key => $value) {
                                if ($key == 'q1') {
                                    $q1_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q2') {
                                    $q2_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q3') {
                                    $q3_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q4') {
                                    $q4_val = str_replace(',', '', $value);
                                }
                            }

                            /* changed to last month of quarter - datemodified - 12/12/2019 */
                            if ($tar_mnths[0] == $get_fy_month[2]) {
                                $target[$ac] += $q1_val;
                            } else if ($tar_mnths[0] == $get_fy_month[5]) {
                                $target[$ac] += $q2_val;
                            } else if ($tar_mnths[0] == $get_fy_month[8]) {
                                $target[$ac] += $q3_val;
                            } else if ($tar_mnths[0] == $get_fy_month[11]) {
                                $target[$ac] += $q4_val;
                            } else {
                                $target[$ac] = 0;
                            }
                            /* end of changes */
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }
                $ac++;
            }
        }
        $id = $this->input->post('id');
        $data['div_id'] = 'recruitment_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allRecruitment_HC.php');
    }

    public function allAttrition() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $g_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $startDate = $get_fy_month[0] . ', ' . $g_year;
        $endDate = $get_fy_month[11] . ', ' . $nxt_year;

        $searchArray = array();
        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);
        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);

            if ($startDate != '' && $endDate != '') {
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));
                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                if (in_array($fin_smonth, $q4_key)) {
                    if ($fin_smonth == 1 || $fin_smonth == 2 || $fin_smonth == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if ($fin_emonth == 1 || $fin_emonth == 2 || $fin_emonth == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }

            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_year";
        }
        if ($startDate != '') {
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if ($sdatefmt == 1 || $sdatefmt == 2 || $sdatefmt == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if ($edatefmt == 1 || $edatefmt == 2 || $edatefmt == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }
            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $st_year";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $to_date = date("Y-m-d", strtotime($endDate));
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y-m-d");
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($g_sector != '') {
            #$searchArray[] = "t2.sector = '$g_sector'";
			$dynamicConditions = "(FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$searchArray[] = $dynamicConditions;
        }

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }
        $where = implode(" and ", $searchArray);

        $q1_val = $q2_val = $q3_val = $q4_val = 0;
        $master_list = $this->Mportfolio->getTargetTeamHiring($where, $startDate, '', '1', 'exit_employee');
        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();
		#echo'<pre>';print_r($master_list);die;
        if ($ftype != 1) {
            $total_list = $this->Mportfolio->getActualTeamHiring($where, $startDate, '', '1', '2');
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            foreach ($master_list as $rec) {
                $getdata = json_decode($rec['exit_employee']);
                foreach ($getdata as $key => $value) {
                    if ($key == 'q1') {
                        $q1_val += str_replace(',', '', $value);
                        $target[0] = $q1_val;
                        $actual[0] = '0';
                    }
                    if ($key == 'q2') {
                        $q2_val += str_replace(',', '', $value);
                        $target[1] = $q2_val;
                        $actual[1] = '0';
                    }
                    if ($key == 'q3') {
                        $q3_val += str_replace(',', '', $value);
                        $target[2] = $q3_val;
                        $actual[2] = '0';
                    }
                    if ($key == 'q4') {
                        $q4_val += str_replace(',', '', $value);
                        $target[3] = $q4_val;
                        $actual[3] = '0';
                    }
                }
            }

            $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
            $categories[4] = 'Annual';
            $target[4] = $annual_target;

            $actual[0] = $total_list[0]['q1'];
            $actual[1] = $total_list[0]['q2'];
            $actual[2] = $total_list[0]['q3'];
            $actual[3] = $total_list[0]['q4'];
            $actual[4] = $total_list[0]['annual'];
        } else {
            $recs_act = array();
            $total_list = $this->Mportfolio->getMonthlyActualTeamHiring($where, $startDate, '', '1', '2');
            if (php72_count($total_list) > 0) {
                foreach ($total_list as $tot) {
                    $t = 0;
                    foreach ($date_diff as $values) {
                        $categories[$t] = $values;
                        if (isset($recs_act[$values])) {
                            $rec_actquat[$values] = $rec_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            $finyr = $datavalues . '-' . $tot['financial_year'];

                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $check_month = $expmonth[0] . '-' . $expmonth[1];
                            if ($datavalues == $expmonth[0] && $finyr == $check_month) {
                                $rec_actquat[$values] = $tot['t_count'];
                                $recs_act[$values] = 1;
                            }
                        }
                        $t++;
                    }
                }
            } else {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }
            $ac = 0;
            foreach ($categories as $cate) {
                $actual[$ac] = $rec_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }
                if (php72_count($master_list) > 0) {
                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            $getdata = json_decode($mas_tar['exit_employee']);

                            foreach ($getdata as $key => $value) {
                                if ($key == 'q1') {
                                    $q1_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q2') {
                                    $q2_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q3') {
                                    $q3_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q4') {
                                    $q4_val = str_replace(',', '', $value);
                                }
                            }

                            /* changed to last month of quarter - datemodified - 12/12/2019 */
                            if ($tar_mnths[0] == $get_fy_month[2]) {
                                $target[$ac] += $q1_val;
                            } else if ($tar_mnths[0] == $get_fy_month[5]) {
                                $target[$ac] += $q2_val;
                            } else if ($tar_mnths[0] == $get_fy_month[8]) {
                                $target[$ac] += $q3_val;
                            } else if ($tar_mnths[0] == $get_fy_month[11]) {
                                $target[$ac] += $q4_val;
                            } else {
                                $target[$ac] = 0;
                            }
                            /* end of changes */
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }
                $ac++;
            }
        }
        $id = $this->input->post('id');
        $data['div_id'] = 'attrition_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allAttrition_HC.php');
    }

    public function allBoardMeeting() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $g_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $startDate = $get_fy_month[0] . ', ' . $g_year;
        $endDate = $get_fy_month[11] . ', ' . $nxt_year;

        $searchArray = array();
        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);
        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);

            if ($startDate != '' && $endDate != '') {
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));
                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                if (in_array($fin_smonth, $q4_key)) {
                    if ($fin_smonth == 1 || $fin_smonth == 2 || $fin_smonth == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if ($fin_emonth == 1 || $fin_emonth == 2 || $fin_emonth == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }

            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }
        if ($startDate != '') {
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if ($sdatefmt == 1 || $sdatefmt == 2 || $sdatefmt == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if ($edatefmt == 1 || $edatefmt == 2 || $edatefmt == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }
            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $end_yr";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $to_date = date("Y-m-d", strtotime($endDate));
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y-m-d");
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($g_sector != '') {
			#CR CHANGES
            #$searchArray[] = "t2.sector = '$g_sector'";
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 AND (t1.financial_year =".$g_year." AND B.year = ".$g_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$searchArray[] = $dynamicConditions;
			#CR CHANGES
        }

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }
        $where = implode(" and ", $searchArray);

        $q1_val = $q2_val = $q3_val = $q4_val = 0;
        $master_list = $this->Mportfolio->getTargetBoardMeeting($where, $startDate, '', '1',$g_sector);
        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();
		
        if ($ftype != 1) {
            $total_list = $this->Mportfolio->getActualBoardMeeting($where, $startDate, '', '1',$g_sector);
			/* echo'<pre>';print_r($where);
			echo'<pre>';print_r($total_list);die; */
		
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            foreach ($master_list as $bm) {
                $getdata = json_decode($bm['meeting_plan']);
                foreach ($getdata as $key => $value) {
                    if ($key == 'q1') {
                        $q1_val += str_replace(',', '', $value);
                        $target[0] = $q1_val;
                        $actual[0] = '0';
                    }
                    if ($key == 'q2') {
                        $q2_val += str_replace(',', '', $value);
                        $target[1] = $q2_val;
                        $actual[1] = '0';
                    }
                    if ($key == 'q3') {
                        $q3_val += str_replace(',', '', $value);
                        $target[2] = $q3_val;
                        $actual[2] = '0';
                    }
                    if ($key == 'q4') {
                        $q4_val += str_replace(',', '', $value);
                        $target[3] = $q4_val;
                        $actual[3] = '0';
                    }
                }
            }

            $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
            $categories[4] = 'Annual';
            $target[4] = $annual_target;

            $actual[0] = $total_list[0]['q1'];
            $actual[1] = $total_list[0]['q2'];
            $actual[2] = $total_list[0]['q3'];
            $actual[3] = $total_list[0]['q4'];
            $actual[4] = $total_list[0]['annual'];
        } else {
            $board_act = array();
            $total_list = $this->Mportfolio->getMonthlyActualBoardMeeting($where, $startDate, '', '1',$g_sector);
			
            if (php72_count($total_list) > 0) {
                foreach ($total_list as $tot) {
                    $t = 0;
                    foreach ($date_diff as $values) {
                        $categories[$t] = $values;
                        if (isset($board_act[$values])) {
                            $board_actquat[$values] = $board_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            $finyr = $datavalues . '-' . $tot['financial_year'];

                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $check_month = $expmonth[0] . '-' . $expmonth[1];
                            if ($datavalues == $expmonth[0] && $finyr == $check_month) {
                                $board_actquat[$values] = $tot['board'];
                                $board_act[$values] = 1;
                            }
                        }
                        $t++;
                    }
                }
            } else {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }
            $ac = 0;
            foreach ($categories as $cate) {
                $actual[$ac] = $board_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }
                if (php72_count($master_list) > 0) {
                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            $getdata = json_decode($mas_tar['meeting_plan']);

                            foreach ($getdata as $key => $value) {
                                if ($key == 'q1') {
                                    $q1_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q2') {
                                    $q2_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q3') {
                                    $q3_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q4') {
                                    $q4_val = str_replace(',', '', $value);
                                }
                            }

                            /* changed to last month of quarter - datemodified - 12/12/2019 */
                            if ($tar_mnths[0] == $get_fy_month[2]) {
                                $target[$ac] += $q1_val;
                            } else if ($tar_mnths[0] == $get_fy_month[5]) {
                                $target[$ac] += $q2_val;
                            } else if ($tar_mnths[0] == $get_fy_month[8]) {
                                $target[$ac] += $q3_val;
                            } else if ($tar_mnths[0] == $get_fy_month[11]) {
                                $target[$ac] += $q4_val;
                            } else {
                                $target[$ac] = 0;
                            }
                            /* end of changes */
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }
                $ac++;
            }
        }
        $id = $this->input->post('id');
        $data['div_id'] = 'boardMeeting_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $this->load->vars($data);
		
        $this->load->view('portfolio/dashboard_chart/allBoardMeeting_HC.php');
    }

    public function allMentorHour() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $g_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $startDate = $get_fy_month[0] . ', ' . $g_year;
        $endDate = $get_fy_month[11] . ', ' . $nxt_year;

        $searchArray = array();
        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);
        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);

            if ($startDate != '' && $endDate != '') {
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));

                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                if (in_array($fin_smonth, $q4_key)) {
                    if ($fin_smonth == 1 || $fin_smonth == 2 || $fin_smonth == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if ($fin_emonth == 1 || $fin_emonth == 2 || $fin_emonth == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }
            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }
        if ($startDate != '') {
            $searchArray = array();
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if ($sdatefmt == 1 || $sdatefmt == 2 || $sdatefmt == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if ($edatefmt == 1 || $edatefmt == 2 || $edatefmt == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }
            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $end_yr";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $edate = explode(', ', $endDate);
            $to_date = date("Y-m-t", strtotime($edate[0] . ' ' . $edate[1]));
//            $searchArray[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y");
//            $searchArray[] = "t1.financial_year = $start_year[1]";
        }
		
		#CR CHANGE
        if ($g_sector != '') {
           # $searchArray[] = "t2.sector = '$g_sector'";
			/* $dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)) AND ";
			$dynamicConditions = rtrim($dynamicConditions, " AND "); */
			#CR CHANGE
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			#CR CHANGE   
			
			$searchArray[] = $dynamicConditions;	
        }
		#CR CHANGE

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }
		

        $where = implode(" and ", $searchArray);
        $master_list = $this->Mportfolio->getTargetMentorHours($where, $startDate, '', '1',$g_sector);
		#echo'<pre>';print_r($master_list);die;
        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();

        if ($ftype != 1) {
            $total_list = $this->Mportfolio->getActualMentorHours($where, $startDate, '', '1',$g_sector);
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $target[0] = $master_list[0]['q1'];
            $target[1] = $master_list[0]['q2'];
            $target[2] = $master_list[0]['q3'];
            $target[3] = $master_list[0]['q4'];
            $target[4] = $master_list[0]['q1'] + $master_list[0]['q2'] + $master_list[0]['q3'] + $master_list[0]['q4'];

            $actual[0] = isset($total_list[0]['q1']) && $total_list[0]['q1'] != '' ? $total_list[0]['q1'] : 0;
            $actual[1] = isset($total_list[0]['q2']) && $total_list[0]['q2'] != '' ? $total_list[0]['q2'] : 0;
            $actual[2] = isset($total_list[0]['q3']) && $total_list[0]['q3'] != '' ? $total_list[0]['q3'] : 0;
            $actual[3] = isset($total_list[0]['q4']) && $total_list[0]['q4'] != '' ? $total_list[0]['q4'] : 0;
            $actual[4] = $total_list[0]['q1'] + $total_list[0]['q2'] + $total_list[0]['q3'] + $total_list[0]['q4'];
        } else {
            $ment_act = array();
            $total_list = $this->Mportfolio->getMonthlyActualMentorHours($where, $startDate, '', '1',$g_sector);
            if (php72_count($total_list) > 0) {
                foreach ($total_list as $tot) {
                    $t = 0;
                    foreach ($date_diff as $values) {

                        $categories[$t] = $values;
                        if (isset($ment_act[$values])) {
                            $ment_actquat[$values] = $ment_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            $finyr = $datavalues . '-' . $tot['financial_year'];
                            if ($datavalues == $expmonth[0] && $tot['financial_year'] == $expmonth[1]) {
                                $ment_actquat[$values] = $tot['hours'];
                                $ment_act[$values] = 1;
                            }
                        }
                        $t++;
                    }
                }
            } else {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }

            $ac = 0;
            foreach ($categories as $cate) {
                $actual[$ac] = $ment_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }
                if (php72_count($master_list) > 0) {

                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            if (php72_in_array($tar_mnths[0], $q1)) {
                                $target[$ac] = round(($mas_tar['q1'] / 3), 2);
                            } else if (php72_in_array($tar_mnths[0], $q2)) {
                                $target[$ac] = round(($mas_tar['q2'] / 3), 2);
                            } else if (php72_in_array($tar_mnths[0], $q3)) {
                                $target[$ac] = round(($mas_tar['q3'] / 3), 2);
                            } else if (php72_in_array($tar_mnths[0], $q4)) {
                                $target[$ac] = round(($mas_tar['q4'] / 3), 2);
                            }
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }
                $ac++;
            }
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'mentorHour_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $data['ftype'] = $ftype;
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allMentorHour_HC.php');
    }

    public function allMentorNumber() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $g_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $startDate = $get_fy_month[0] . ', ' . $g_year;
        $endDate = $get_fy_month[11] . ', ' . $nxt_year;

        $searchArray = array();

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);

            if ($startDate != '' && $endDate != '') {
                $start_year = explode(', ', $startDate);
                $end_year = explode(', ', $endDate);
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));

                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                if (in_array($fin_smonth, $q4_key)) {
                    if ($fin_smonth == 1 || $fin_smonth == 2 || $fin_smonth == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if ($fin_emonth == 1 || $fin_emonth == 2 || $fin_emonth == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }
            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }
        if ($startDate != '') {
            $searchArray = array();
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if ($sdatefmt == 1 || $sdatefmt == 2 || $sdatefmt == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if ($edatefmt == 1 || $edatefmt == 2 || $edatefmt == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }
            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $end_yr";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $edate = explode(', ', $endDate);
            $to_date = date("Y-m-t", strtotime($edate[0] . ' ' . $edate[1]));
//            $searchArray[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y");
//            $searchArray[] = "t1.financial_year = $start_year[1]";
        }

        if ($g_sector != '') {
            #$searchArray[] = "t2.sector = '$g_sector'";
			#CR CHANGE
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$searchArray[] = $dynamicConditions;
			#CR CHANGE   
			
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }

        $where = implode(" and ", $searchArray);

        $master_list = $this->Mportfolio->getTargetMentorHours($where, $startDate, '', '1',$g_sector);
        $diffmon = array();
        $fin_quarters['Q1'] = 0;
        $fin_quarters['Q2'] = 0;
        $fin_quarters['Q3'] = 0;
        $fin_quarters['Q4'] = 0;

        foreach ($diffmon as $cnts) {
            $count[] = php72_count($cnts);
        }

        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();
        $ment_act = array();
        $ment_actquat['q1'] = 0;
        $ment_actquat['q2'] = 0;
        $ment_actquat['q3'] = 0;
        $ment_actquat['q4'] = 0;

        $total_list = $this->Mportfolio->getActualMentorNumber($where, $startDate, '', '1',$g_sector);
        $get_unique_mentor = array();

        foreach ($total_list as $tot) {
            if (!isset($ment_act[$tot['inv_id']][$tot['month']][$tot['assigned_to']])) {
                if ($ftype != 1) {
                    if (in_array($tot['month'], $q1_key)) {
                        if (isset($ment_act['q1'][$tot['assigned_to']])) {
                            $ment_actquat['q1'] = $ment_actquat['q1'];
                        } else {
                            $ment_actquat['q1'] += 1;

                            $ment_act['q1'][$tot['assigned_to']] = 1;
                        }
                    }
                    if (in_array($tot['month'], $q2_key)) {
                        if (isset($ment_act['q2'][$tot['assigned_to']])) {
                            $ment_actquat['q2'] = $ment_actquat['q2'];
                        } else {
                            $ment_actquat['q2'] += 1;
                            $ment_act['q2'][$tot['assigned_to']] = 1;
                        }
                    }
                    if (in_array($tot['month'], $q3_key)) {
                        if (isset($ment_act['q3'][$tot['assigned_to']])) {
                            $ment_actquat['q3'] = $ment_actquat['q3'];
                        } else {
                            $ment_actquat['q3'] += 1;
                            $ment_act['q3'][$tot['assigned_to']] = 1;
                        }
                    }
                    if (in_array($tot['month'], $q4_key)) {
                        if (isset($ment_act['q4'][$tot['assigned_to']])) {
                            $ment_actquat['q4'] = $ment_actquat['q4'];
                        } else {
                            $ment_actquat['q4'] += 1;
                            $ment_act['q4'][$tot['assigned_to']] = 1;
                        }
                    }

                    // $ment_act[$tot['inv_id']][$tot['month']][$tot['assigned_to']] = 1;
                    $get_unique_mentor[] = $tot['assigned_to'];
                } else {
                    $t = 0;
                    foreach ($date_diff as $values) {

                        $categories[$t] = $values;
                        if (isset($ment_act[$values][$tot['assigned_to']])) {
                            $ment_actquat[$values] = $ment_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            if ($datavalues == $expmonth[0] && $expmonth[1] == $tot['financial_year']) {
                                $ment_actquat[$values] += 1;
                                $ment_act[$values][$tot['assigned_to']] = 1;
                            }
                        }
                        $t++;
                    }
                }
            }
        }


//        $target[0] = $fin_quarters['Q1'];
//        $target[1] = $fin_quarters['Q2'];
//        $target[2] = $fin_quarters['Q3'];
//        $target[3] = $fin_quarters['Q4'];
//        $target[4] = $fin_quarters['Q1'] + $fin_quarters['Q2'] + $fin_quarters['Q3'] + $fin_quarters['Q4'];

        if ($ftype != 1) {
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $target[0] = $master_list[0]['mentorq1'];
            $target[1] = $master_list[0]['mentorq2'];
            $target[2] = $master_list[0]['mentorq3'];
            $target[3] = $master_list[0]['mentorq4'];
//            $target[4] = $master_list[0]['mentorq1'] + $master_list[0]['mentorq2'] + $master_list[0]['mentorq3'] + $master_list[0]['mentorq4'];
            $target[4] = max($target);

            $actual[0] = $ment_actquat['q1'];
            $actual[1] = $ment_actquat['q2'];
            $actual[2] = $ment_actquat['q3'];
            $actual[3] = $ment_actquat['q4'];
            $actual[4] = count(array_unique($get_unique_mentor));
//            $actual[4] = $ment_actquat['q1'] + $ment_actquat['q2'] + $ment_actquat['q3'] + $ment_actquat['q4'];
        } else {
            $t = 0;
            foreach ($date_diff as $values) {
                $categories[$t] = $values;
                $t++;
            }
            $ac = 0;
            foreach ($categories as $cate) {

                $actual[$ac] = $ment_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }

                if (php72_count($master_list) > 0) {
                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            if (php72_in_array($tar_mnths[0], $q1)) {
                                $target[$ac] = $mas_tar['mentorq1'];
                            } else if (php72_in_array($tar_mnths[0], $q2)) {
                                $target[$ac] = $mas_tar['mentorq2'];
                            } else if (php72_in_array($tar_mnths[0], $q3)) {
                                $target[$ac] = $mas_tar['mentorq3'];
                            } else if (php72_in_array($tar_mnths[0], $q4)) {
                                $target[$ac] = $mas_tar['mentorq4'];
                            }
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }

                $ac++;
            }
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'mentorNumber_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $data['ftype'] = $ftype;
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allMentorNumber_HC.php');
    }

    public function allEndbeneficiaries() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);


            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }
        $defimpact_where = "t1.field_type = 1";

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if ($type == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);
//            $search_month[] = "t2.sector = '$g_sector'";
            $search_month[] = "t1.financial_year >= $from_year and t1.financial_year <= $from_year";
            $impact_where = "t1.field_type = 1";
            $month_where = php72_implode(" and ", $search_month);


            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($month_where, $impact_where);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($month_where);

            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {

                    foreach ($monthly_target as $key => $value) {

                        if ($yearvalues[1] == $value['financial_year']) {
                            $yearvalues[0] = strtolower($yearvalues[0]);
                            if (isset($value[$yearvalues[0]])) {
                                $nums = str_replace(',', '', $value[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $nums;
                                } else {
                                    $search_array[$values] = $nums;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            $end_male = str_replace(',', '', $value['end_male']);
                            $end_female = str_replace(',', '', $value['end_female']);
                            $end_other = str_replace(',', '', $value['end_other']);
                            $end_unknown = str_replace(',', '', $value['end_unknown']);
                            $endBeneficiaries = $end_male + $end_female + $end_other + $end_unknown;
                            if ($result['month'] == $value['month']) {

                                $actual_cost = $endBeneficiaries;
                                $rev_cost = $endBeneficiaries;
                                $hc_actual[$m] += $actual_cost;
                            } else {
                                $hc_actual[$m] = isset($value['end_male']) && isset($value['end_female']) && isset($value['end_other']) && isset($value['end_unknown']) && $endBeneficiaries != '' ? $endBeneficiaries : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if ($type == 2) {

            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $from_year";
            $impact_where = "t1.field_type = 1";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($quarter_where, $impact_where);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($quarter_where);

            $impt_act = array();
            $impt_tarquat['q1'] = 0;
            $impt_tarquat['q2'] = 0;
            $impt_tarquat['q3'] = 0;
            $impt_tarquat['q4'] = 0;
            $impt_actquat['q1'] = 0;
            $impt_actquat['q2'] = 0;
            $impt_actquat['q3'] = 0;
            $impt_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                $targ_apr = str_replace(',', '', $targs[strtolower($get_fy_month[0])]);
                $targ_may = str_replace(',', '', $targs[strtolower($get_fy_month[1])]);
                $targ_jun = str_replace(',', '', $targs[strtolower($get_fy_month[2])]);
                $targ_jul = str_replace(',', '', $targs[strtolower($get_fy_month[3])]);
                $targ_aug = str_replace(',', '', $targs[strtolower($get_fy_month[4])]);
                $targ_sep = str_replace(',', '', $targs[strtolower($get_fy_month[5])]);
                $targ_oct = str_replace(',', '', $targs[strtolower($get_fy_month[6])]);
                $targ_nov = str_replace(',', '', $targs[strtolower($get_fy_month[7])]);
                $targ_dec = str_replace(',', '', $targs[strtolower($get_fy_month[8])]);
                $targ_jan = str_replace(',', '', $targs[strtolower($get_fy_month[9])]);
                $targ_feb = str_replace(',', '', $targs[strtolower($get_fy_month[10])]);
                $targ_mar = str_replace(',', '', $targs[strtolower($get_fy_month[11])]);

                $impt_tarquat['q1'] += $targ_apr + $targ_may + $targ_jun;
                $impt_tarquat['q2'] += $targ_jul + $targ_aug + $targ_sep;
                $impt_tarquat['q3'] += $targ_oct + $targ_nov + $targ_dec;
                $impt_tarquat['q4'] += $targ_jan + $targ_feb + $targ_mar;
            }

            foreach ($monthly_actual as $acts) {
                $end_male = str_replace(',', '', $acts['end_male']);
                $end_female = str_replace(',', '', $acts['end_female']);
                $end_other = str_replace(',', '', $acts['end_other']);
                $end_unknown = str_replace(',', '', $acts['end_unknown']);
                $endBeneficiaries = $end_male + $end_female + $end_other + $end_unknown;
                if (in_array($acts['month'], $q1_key)) {
                    $impt_actquat['q1'] += $endBeneficiaries;
                }
                if (in_array($acts['month'], $q2_key)) {
                    $impt_actquat['q2'] += $endBeneficiaries;
                }
                if (in_array($acts['month'], $q3_key)) {
                    $impt_actquat['q3'] += $endBeneficiaries;
                }
                if (in_array($acts['month'], $q4_key)) {
                    $impt_actquat['q4'] += $endBeneficiaries;
                }
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $impt_tarquat['q1'];
            $hc_target[1] = $impt_tarquat['q2'];
            $hc_target[2] = $impt_tarquat['q3'];
            $hc_target[3] = $impt_tarquat['q4'];
            $hc_target[4] = $impt_tarquat['q1'] + $impt_tarqua['q2'] + $impt_tarquat['q3'] + $impt_tarquat['q4'];

            $hc_actual[0] = $impt_actquat['q1'];
            $hc_actual[1] = $impt_actquat['q2'];
            $hc_actual[2] = $impt_actquat['q3'];
            $hc_actual[3] = $impt_actquat['q4'];
            $hc_actual[4] = $impt_actquat['q1'] + $impt_actquat['q2'] + $impt_actquat['q3'] + $impt_actquat['q4'];
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'impactDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/impact_combo');
    }

    public function allTechnicalAssistance() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $sector = $this->input->post('sector');
        $sector_id = $this->input->post('sector_id');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $startDate = $get_fy_month[0] . ', ' . $from_year;
        $endDate = $get_fy_month[11] . ', ' . $nxt_year;

        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $searchArray = array();
        $search_target_where = $search_actual_where = $search_month = $search_actual = $search_quarter = array();

        if ($sector_id != '') {
            #$searchArray[] = "t2.sector IN ($sector_id)";
			 #CR CHANGE
			$dynamicConditions = "(FIND_IN_SET('$sector_id', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$sector_id', REPLACE(t2.sector, ' ', '')) > 0)";
			$searchArray = $dynamicConditions;
			#CR CHANGE   
			 
        } else if ($sector != '') {
            #$searchArray[] = "t2.sector IN ($sector)";
			 #CR CHANGE
			$dynamicConditions = "(FIND_IN_SET('$sector_id', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$sector_id', REPLACE(t2.sector, ' ', '')) > 0)";
			$searchArray = $dynamicConditions;
			#CR CHANGE  
        }

        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }

        $where = php72_implode(" and ", $searchArray);
		
        $StartDate = date("Y-m-01", strtotime($start_year[1] . '-' . date('m', strtotime($start_year[0]))));
        $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
        $date_diff = $this->get_months($StartDate, $StopDate);
        $categories = $target = $actual = array();
        $tap_act = $tap_tar = array();
        $tap_tarquat['q1'] = 0;
        $tap_tarquat['q2'] = 0;
        $tap_tarquat['q3'] = 0;
        $tap_tarquat['q4'] = 0;
        $tap_actquat['q1'] = 0;
        $tap_actquat['q2'] = 0;
        $tap_actquat['q3'] = 0;
        $tap_actquat['q4'] = 0;

        $search_month = "t1.need_by >= '$StartDate 00:00:00' and t1.need_by <= '$StopDate 23:59:59'";
        $search_actual = "t1.month_engaged >= '$StartDate 00:00:00' and t1.month_engaged <= '$StopDate 23:59:59'";
		
        if ($type == 1) {
            $targetlist = $this->Mportfolio->getTargetTap($where, '', $search_month,$sector_id);
            $actuallist = $this->Mportfolio->getActualTap($where, $g_year, $search_actual,$sector_id);
			
			$act_month = $this->actual_month();
            foreach ($targetlist as $list) {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $expmonth = explode('-', $values);
                    if (php72_in_array($expmonth[0], $q4)) {
                        if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                            $expmonth[1] = $expmonth[1] - 1;
                        }
                    } else {
                        $expmonth[1] = $expmonth[1];
                    }
                    if (isset($tap_tar[$values][$expmonth[1]])) {
                        $tap_tarquat[$values] = $tap_tarquat[$values];
                    } else {
                        // if ($expmonth[1] == $tapyear) {
                        if ($expmonth[0] == 'Dec') {
                            $expmonth[0] = 'dec';
                        }
                        $tap_tarquat[$values] = $list[strtolower($expmonth[0])];

                        $tap_tar[$values][$expmonth[1]] = 1;
                        // }
                    }
                    $t++;
                }
            }
            foreach ($actuallist as $actlist) {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
//                     if (isset($tap_act[$values][$actlist['financial_year']])) {
// //                        $tap_actquat[$values] = $tap_actquat[$values];
//                         $tap_actquat[$values] += 1;
//                     } else {
                        $expmonth = explode('-', $values);
                        if (php72_in_array($expmonth[0], $q4)) {
                            if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                $expmonth[1] = $expmonth[1] - 1;
                            }
                        } else {
                            $expmonth[1] = $expmonth[1];
                        }
                        if ($expmonth[1] == $actlist['financial_year']) {
                            if ($expmonth[0] == 'Dec') {
                                $expmonth[0] = 'dec';
                            }
                            if ($expmonth[0] == $act_month[$actlist['month']]) {
                                $tap_actquat[$values] += 1;
                                $tap_act[$values][$actlist['financial_year']] = 1;
                            }
                        }
                    // }
                    $t++;
                }
            }

            if (php72_count($targetlist) == 0 && php72_count($actuallist) == 0) {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }
        } else {
            $targetlist = $this->Mportfolio->getTargetTap($where, '', $search_month, $g_year);
            $actuallist = $this->Mportfolio->getActualTap($where, $g_year);

            foreach ($targetlist as $list) {
                $tap_tarquat['q1'] += $list[strtolower($get_fy_month[0])] + $list[strtolower($get_fy_month[1])] + $list[strtolower($get_fy_month[2])];
                $tap_tarquat['q2'] += $list[strtolower($get_fy_month[3])] + $list[strtolower($get_fy_month[4])] + $list[strtolower($get_fy_month[5])];
                $tap_tarquat['q3'] += $list[strtolower($get_fy_month[6])] + $list[strtolower($get_fy_month[7])] + $list[strtolower($get_fy_month[8])];
                $tap_tarquat['q4'] += $list[strtolower($get_fy_month[9])] + $list[strtolower($get_fy_month[10])] + $list[strtolower($get_fy_month[11])];
            }
            foreach ($actuallist as $actlist) {
                if (in_array($actlist['month'], $q1_key)) {
                    $tap_actquat['q1'] += 1;
                }
                if (in_array($actlist['month'], $q2_key)) {
                    $tap_actquat['q2'] += 1;
                }
                if (in_array($actlist['month'], $q3_key)) {
                    $tap_actquat['q3'] += 1;
                }
                if (in_array($actlist['month'], $q4_key)) {
                    $tap_actquat['q4'] += 1;
                }
            }
        }

        if ($type == 1) {
            $ac = 0;
            foreach ($categories as $cate) {
                $target[$ac] = $tap_tarquat[$cate];
                $actual[$ac] = $tap_actquat[$cate];
                $ac++;
            }
        } else {
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $target[0] = $tap_tarquat['q1'];
            $target[1] = $tap_tarquat['q2'];
            $target[2] = $tap_tarquat['q3'];
            $target[3] = $tap_tarquat['q4'];
            $target[4] = $tap_tarquat['q1'] + $tap_tarquat['q2'] + $tap_tarquat['q3'] + $tap_tarquat['q4'];

            $actual[0] = $tap_actquat['q1'];
            $actual[1] = $tap_actquat['q2'];
            $actual[2] = $tap_actquat['q3'];
            $actual[3] = $tap_actquat['q4'];
            $actual[4] = $tap_actquat['q1'] + $tap_actquat['q2'] + $tap_actquat['q3'] + $tap_actquat['q4'];
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'tapChartDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allTap_HC');
    }

    public function allPartnerships() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $sector = $this->input->post('sector');
        $sector_id = $this->input->post('sector_id');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $startDate = $get_fy_month[0] . ', ' . $from_year;
        $endDate = $get_fy_month[11] . ', ' . $nxt_year;

        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $searchArray = array();
        $search_target_where = $search_actual_where = $search_month = $search_actual = $search_quarter = array();
		#echo'<pre>';print_r( $_POST);die;
        if ($sector_id != '') {
            $searchArray[] = "t2.sector IN ($sector_id)";
			#$dynamicConditions = "(FIND_IN_SET('$sector_id', REPLACE(B.sector, ' ', '')) > 0  ) OR (B.sector IS NULL AND FIND_IN_SET('$sector_id', REPLACE(t2.sector, ' ', '')) > 0)";
			$dynamicConditions = "(FIND_IN_SET('$sector_id', REPLACE(B.sector, ' ', '')) > 0 AND (t1.financial_year =".$g_year." AND B.year = ".$g_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$sector_id', REPLACE(t2.sector, ' ', '')) > 0)";
			$searchArray[] = $dynamicConditions;
			
        } else if ($sector != '') { 
            $searchArray[] = "t2.sector IN ($sector)";
			#$dynamicConditions = "(FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0) OR (B.sector IS NULL AND FIND_IN_SET('$sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$dynamicConditions = "(FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0 AND (t1.financial_year =".$g_year." AND B.year = ".$g_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$searchArray[] = $dynamicConditions;
		}
		
        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id" ;
        }

        $where = implode(" and ", $searchArray);
		
        $StartDate = date("Y-m-01", strtotime($start_year[1] . '-' . date('m', strtotime($start_year[0]))));
        $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
        $date_diff = $this->get_months($StartDate, $StopDate);
        $categories = $target = $actual = array();
        $tap_act = $tap_tar = array();


        $search_month = "t1.need_by >= '$StartDate 00:00:00' and t1.need_by <= '$StopDate 23:59:59' AND t1.financial_year=$g_year";
        $search_actual = "t1.need_by >= '$StartDate 00:00:00' and t1.need_by <= '$StopDate 23:59:59' AND t1.financial_year=$g_year";
		
        if ($type == 1) {
			#CR CHANGE
            $targetlist = $this->Mportfolio->getTargetPartnerships($where, '', $search_month,$g_year);
            $actuallist = $this->Mportfolio->getActualPartnerships($where, $g_year, $search_actual);
			
			#echo'<pre>';print_r($search_month);
			#echo'<pre>';print_r($targetlist);die;
            foreach ($targetlist as $list) {

                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    if (isset($tap_tar[$values][$list['financial_year']])) {
                        $tap_tarquat[$values] = $tap_tarquat[$values];
                    } else {
                        $expmonth = explode('-', $values);
                        $diff_yr = $expmonth[1];
                        $diff_mont = $expmonth[0];
                        if (php72_in_array($diff_mont, $q4)) {
                            if ($diff_mont == 'Jan' || $diff_mont == 'Feb' || $diff_mont == 'Mar') {
                                $diff_yr = $diff_yr - 1;
                            }
                        } else {
                            $diff_yr = $diff_yr;
                        }
                        // if ($diff_yr == $list['financial_year']) {
                        if ($diff_mont == 'Dec') {
                            $diff_mont = 'dec';
                        }

                        $tap_tarquat[$values] = $list[strtolower($diff_mont)];
                        $tap_tar[$values][$list['financial_year']] = 1;
                        // }
                    }
                    $t++;
                }
            }

            foreach ($actuallist as $actlist) {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    if (isset($tap_act[$values][$actlist['financial_year']])) {
                        $tap_actquat[$values] = $tap_actquat[$values];
                    } else {
                        $expmonth = explode('-', $values);
                        if (php72_in_array($expmonth[0], $q4)) {
                            if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                $expmonth[1] = $expmonth[1] - 1;
                            }
                        } else {
                            $expmonth[1] = $expmonth[1];
                        }
                        // if ($expmonth[1] == $actlist['financial_year']) {
                        if ($expmonth[0] == 'Dec') {
                            $expmonth[0] = 'dec';
                        }
                        $tap_actquat[$values] = $actlist[strtolower($expmonth[0])];
                        $tap_act[$values][$actlist['financial_year']] = 1;
                        // }
                    }
                    $t++;
                }
            }

            if (php72_count($targetlist) == 0 && php72_count($actuallist) == 0) {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }
        } else {
            $tap_tarquat['q1'] = 0;
            $tap_tarquat['q2'] = 0;
            $tap_tarquat['q3'] = 0;
            $tap_tarquat['q4'] = 0;
            $tap_actquat['q1'] = 0;
            $tap_actquat['q2'] = 0;
            $tap_actquat['q3'] = 0;
            $tap_actquat['q4'] = 0;
			#CR CHANGE
            $targetlist = $this->Mportfolio->getTargetPartnerships($where, '', $search_month,$g_year);
            $actuallist = $this->Mportfolio->getActualPartnerships($where, $g_year);
            foreach ($targetlist as $list) {
                $tap_tarquat['q1'] += $list[strtolower($get_fy_month[0])] + $list[strtolower($get_fy_month[1])] + $list[strtolower($get_fy_month[2])];
                $tap_tarquat['q2'] += $list[strtolower($get_fy_month[3])] + $list[strtolower($get_fy_month[4])] + $list[strtolower($get_fy_month[5])];
                $tap_tarquat['q3'] += $list[strtolower($get_fy_month[6])] + $list[strtolower($get_fy_month[7])] + $list[strtolower($get_fy_month[8])];
                $tap_tarquat['q4'] += $list[strtolower($get_fy_month[9])] + $list[strtolower($get_fy_month[10])] + $list[strtolower($get_fy_month[11])];
            }
            foreach ($actuallist as $actlist) {
                $tap_actquat['q1'] += $actlist[strtolower($get_fy_month[0])] + $actlist[strtolower($get_fy_month[1])] + $actlist[strtolower($get_fy_month[2])];
                $tap_actquat['q2'] += $actlist[strtolower($get_fy_month[3])] + $actlist[strtolower($get_fy_month[4])] + $actlist[strtolower($get_fy_month[5])];
                $tap_actquat['q3'] += $actlist[strtolower($get_fy_month[6])] + $actlist[strtolower($get_fy_month[7])] + $actlist[strtolower($get_fy_month[8])];
                $tap_actquat['q4'] += $actlist[strtolower($get_fy_month[9])] + $actlist[strtolower($get_fy_month[10])] + $actlist[strtolower($get_fy_month[11])];
            }
        }

        if ($type == 1) {
            $ac = 0;
            foreach ($categories as $cate) {
                $target[$ac] = $tap_tarquat[$cate];
                $actual[$ac] = $tap_actquat[$cate];
                $ac++;
            }
        } else {
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $target[0] = $tap_tarquat['q1'];
            $target[1] = $tap_tarquat['q2'];
            $target[2] = $tap_tarquat['q3'];
            $target[3] = $tap_tarquat['q4'];
            $target[4] = $tap_tarquat['q1'] + $tap_tarquat['q2'] + $tap_tarquat['q3'] + $tap_tarquat['q4'];

            $actual[0] = $tap_actquat['q1'];
            $actual[1] = $tap_actquat['q2'];
            $actual[2] = $tap_actquat['q3'];
            $actual[3] = $tap_actquat['q4'];
            $actual[4] = $tap_actquat['q1'] + $tap_actquat['q2'] + $tap_actquat['q3'] + $tap_actquat['q4'];
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'tapChartDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allPartnerships_HC');
    }

    public function allDiagnosticPanels() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $g_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $startDate = $get_fy_month[0] . ', ' . $g_year;
        $endDate = $get_fy_month[11] . ', ' . $nxt_year;

        $searchArray = array();
        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);
        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);

            if ($startDate != '' && $endDate != '') {
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));
                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                if (in_array($fin_smonth, $q4_key)) {
                    if ($fin_smonth == 1 || $fin_smonth == 2 || $fin_smonth == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if ($fin_emonth == 1 || $fin_emonth == 2 || $fin_emonth == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }

            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }
        if ($startDate != '') {
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if ($sdatefmt == 1 || $sdatefmt == 2 || $sdatefmt == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if ($edatefmt == 1 || $edatefmt == 2 || $edatefmt == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }
            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $end_yr";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $to_date = date("Y-m-d", strtotime($endDate));
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y-m-d");
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($g_sector != '') {
            #$searchArray[] = "t2.sector = '$g_sector'";
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)) ";
			$dynamicConditions = rtrim($dynamicConditions, " AND ");
			$searchArray[] = $dynamicConditions;
        }

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }
        $where = implode(" and ", $searchArray);

        $q1_val = $q2_val = $q3_val = $q4_val = 0;
        $master_list = $this->Mportfolio->getTargetDpMeeting($where, $startDate, '', '1');
        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();
		#echo '<pre>';print_r($master_list);die;
        if ($ftype != 1) {
            $total_list = $this->Mportfolio->getActualDpMeeting($where, $startDate, '', '1');
			#echo '<pre>';print_r($where);
			#echo '<pre>';print_r($total_list);die;
			
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            foreach ($master_list as $dp) {
                $getdata = json_decode($dp['dp_plan']);
                foreach ($getdata as $key => $value) {
                    if ($key == 'q1') {
                        $q1_val += str_replace(',', '', $value);
                        $target[0] = $q1_val;
                        $actual[0] = '0';
                    }
                    if ($key == 'q2') {
                        $q2_val += str_replace(',', '', $value);
                        $target[1] = $q2_val;
                        $actual[1] = '0';
                    }
                    if ($key == 'q3') {
                        $q3_val += str_replace(',', '', $value);
                        $target[2] = $q3_val;
                        $actual[2] = '0';
                    }
                    if ($key == 'q4') {
                        $q4_val += str_replace(',', '', $value);
                        $target[3] = $q4_val;
                        $actual[3] = '0';
                    }
                }
            }

            $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
            $categories[4] = 'Annual';
            $target[4] = $annual_target;

            $actual[0] = $total_list[0]['q1'];
            $actual[1] = $total_list[0]['q2'];
            $actual[2] = $total_list[0]['q3'];
            $actual[3] = $total_list[0]['q4'];
            $actual[4] = $total_list[0]['annual'];
        } else {
            $dps_act = array();
            $total_list = $this->Mportfolio->getMonthlyActualDpMeeting($where, $startDate, '', '1');
			#echo '<pre>';print_r($total_list);die;
            if (php72_count($total_list) > 0) {
                foreach ($total_list as $tot) {
                    $t = 0;
                    foreach ($date_diff as $values) {
                        $categories[$t] = $values;
                        if (isset($dps_act[$values])) {
                            $dp_actquat[$values] = $dp_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            $finyr = $datavalues . '-' . $tot['financial_year'];

                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $check_month = $expmonth[0] . '-' . $expmonth[1];
                            if ($datavalues == $expmonth[0] && $finyr == $check_month) {
                                $dp_actquat[$values] = $tot['dps'];
                                $dps_act[$values] = 1;
                            }
                        }
                        $t++;
                    }
                }
            } else {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }
            $ac = 0;
            foreach ($categories as $cate) {
                $actual[$ac] = $dp_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }
                if (php72_count($master_list) > 0) {
                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            $getdata = json_decode($mas_tar['dp_plan']);

                            foreach ($getdata as $key => $value) {
                                if ($key == 'q1') {
                                    $q1_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q2') {
                                    $q2_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q3') {
                                    $q3_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q4') {
                                    $q4_val = str_replace(',', '', $value);
                                }
                            }

                            /* changed to last month of quarter - datemodified - 12/12/2019 */
                            if ($tar_mnths[0] == $get_fy_month[2]) {
                                $target[$ac] += $q1_val;
                            } else if ($tar_mnths[0] == $get_fy_month[5]) {
                                $target[$ac] += $q2_val;
                            } else if ($tar_mnths[0] == $get_fy_month[8]) {
                                $target[$ac] += $q3_val;
                            } else if ($tar_mnths[0] == $get_fy_month[11]) {
                                $target[$ac] += $q4_val;
                            } else {
                                $target[$ac] = 0;
                            }
                            /* end of changes */
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }
                $ac++;
            }
        }
        $id = $this->input->post('id');
        $data['div_id'] = 'dpMeeting_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allDpMeeting_HC.php');
    }

    public function allSeedFunding() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_target_where = $search_actual_where = $search_month = $search_actual = $search_quarter = array();

        if ($g_sector != '') {
			#CR CHANGE
            #$search_target_where[] = $search_actual_where[] = $search_month[] = $search_actual[] = $search_quarter[] = $search_quarter_target[] = $search_quarter_actual[] = "t2.sector = '$g_sector'";
           
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0))";
			$dynamicConditions = rtrim($dynamicConditions, " AND ");
			#$searchArray[] = $dynamicConditions;
			
			$search_target_where[] = $search_actual_where[] = $search_month[] = $search_actual[] = $search_quarter[] = $search_quarter_target[] = $search_quarter_actual[] = $dynamicConditions;

			
			#CR CHANGE
			$sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }
        if ($g_year != '' || $g_quarter != '') {
            $g_getFrom_year = $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
                $g_getTo_year = $nxt_year;
            } else {
                $g_start_month = reset($q1);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
                $g_getTo_year = $nxt_year;
            }

            $g_StartDate = $g_getFrom_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_target_where[] = "t1.month >= '" . $g_StartDate . " 00:00:00' and t1.month <= '" . $g_StopDate . " 23:59:59'";
            $search_actual_where[] = "t1.disburse_date >= '" . $g_StartDate . " 00:00:00' and t1.disburse_date <= '" . $g_StopDate . " 23:59:59'";
        }
		#ECHO'<pre>';print_r($search_target_where);die;
           
        if ($inv_id != '') {
            $search_target_where[] = $search_actual_where[] = $search_quarter_target[] = $search_quarter_actual[] = $search_month[] = $search_actual[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_target_where = php72_implode(" and ", $search_target_where);
        $default_actual_where = php72_implode(" and ", $search_actual_where);
		
        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if ($type == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);
 
            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);

            $search_month[] = "t1.month >= '$StartDate' and t1.month <= '$StopDate'";
            $search_actual[] = "t1.disburse_date >= '$StartDate 00:00:00' and t1.disburse_date <= '$StopDate 23:59:59'";
            $month_where = php72_implode(" and ", $search_month);
            $month_actual = php72_implode(" and ", $search_actual);
			// $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";

            $monthly_target = $this->Mportfolio->getTargetSeedFund($month_where);
            $monthly_actual = $this->Mportfolio->getActualSeedFund($month_actual);
		

            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }

                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $value) {
                        if (in_array($value['month'], $q4_key)) {
                            if ($value['month'] == 1 || $value['month'] == 2 || $value['month'] == 3) {
                                $value['year'] = $value['year'] - 1;
                            }
                        } else {
                            $value['year'] = $value['year'];
                        }
                        // echo $Year_mon = date("Y", strtotime($value['month']));
                        if ($yearvalues[1] == $value['year']) {
                            $datavalues = date("M", mktime(0, 0, 0, $value['month'], 1));
                            if ($yearvalues[0] == $datavalues) {
                                $cost = str_replace(',', '', $value['amount']);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $cost;
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }
            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
//                if ($plan_month == 1 || $plan_month == 2 || $plan_month == 3) {
//                    $split_year = $split_year - 1;
//                } else {
//                    $split_year = $split_year;
//                }

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year;
                            return ($var['year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['disburse_amount']);
                                $rev_cost = str_replace(',', '', $result['disburse_amount']);
                                $hc_actual[$m] += $actual_cost;
                            } else {
                                $hc_actual[$m] = isset($value['disburse_amount']) && $value['disburse_amount'] != '' ? str_replace(',', '', $value['disburse_amount']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if ($type == 20) {
            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter_target[] = "t1.month >= '" . $q_StartDate . "' and t1.month <= '" . $q_StopDate . "'";
            $search_quarter_actual[] = "t1.disburse_date >= '" . $q_StartDate . "' and t1.disburse_date <= '" . $q_StopDate . "'";

            $quarter_target = php72_implode(" and ", $search_quarter_target);
            $quarter_actual = php72_implode(" and ", $search_quarter_actual);

            $monthly_target = $this->Mportfolio->getTargetSeedFund($quarter_target);
            $monthly_actual = $this->Mportfolio->getActualSeedFund($quarter_actual);
			
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if (php72_in_array($value['month'], $q4)) {
                            if ($value['month'] == 1 || $value['month'] == 2 || $value['month'] == 3) {
                                $value['year'] = $value['year'] - 1;
                            }
                        } else {
                            $value['year'] = $value['year'];
                        }
                        if ($yearvalues[1] == $value['year']) {
                            $datavalues = date("M", mktime(0, 0, 0, $value['month'], 1));
                            if ($yearvalues[0] == $datavalues) {
                                $cost = str_replace(',', '', $value['amount']);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $cost;
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    if (php72_in_array($var['month'], $q4)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year;
                            return ($var['year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['disburse_amount']);
                                $rev_cost = str_replace(',', '', $result['disburse_amount']);
                                $fetch_target[$m]['actual'] += $actual_cost;
                            } else {
                                $fetch_target[$m]['actual'] = isset($value['disburse_amount']) && $value['disburse_amount'] != '' ? str_replace(',', '', $value['disburse_amount']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }
            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);

            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] += $value['target'];
                    $hc_actual[$q] += $value['actual'];
                }
            }
        } else {
            $seed_target = $this->Mportfolio->getTargetSeedFund($default_target_where);
		/* 	echo '<pre>';print_r($default_target_where);
			echo '<pre>';print_r($seed_target);die; */
            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($seed_target) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    foreach ($seed_target as $target) {
                        $value = $target['amount'];
                        if (in_array($target['month'], $q1_key)) {
                            $q1_val += str_replace(',', '', $value);
                            $hc_target[0] = $q1_val;
                        }
                        if (in_array($target['month'], $q2_key)) {
                            $q2_val += str_replace(',', '', $value);
                            $hc_target[1] = $q2_val;
                        }
                        if (in_array($target['month'], $q3_key)) {
                            $q3_val += str_replace(',', '', $value);
                            $hc_target[2] = $q3_val;
                        }
                        if (in_array($target['month'], $q4_key)) {
                            $q4_val += str_replace(',', '', $value);
                            $hc_target[3] = $q4_val;
                        }
                    }

                    $annual_target = $q1_val + $q2_val + $q3_val + $q4_val;
                    $categories[4] = 'Annual';
                    $hc_target[4] = $annual_target;
                } else {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($seed_target as $target) {
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $categories[$k] = $value;
                            if ($target['month'] == $key) {
                                $target_month_value[$value] += str_replace(',', '', $target['amount']);
                                $hc_actual[$k] = '0';
                            }
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && $g_quarter != 5) {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $seed_actual = $this->Mportfolio->getActualSeedFund($default_actual_where);
            $actual_month_value = array();
            if (php72_count($seed_actual) > 0) {
                if ($g_quarter == '' || $g_quarter == 5) {
                    foreach ($seed_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_val += str_replace(',', '', $actual['disburse_amount']);
                            $hc_actual[0] = $a1_val;
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_val += str_replace(',', '', $actual['disburse_amount']);
                            $hc_actual[1] = $a2_val;
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_val += str_replace(',', '', $actual['disburse_amount']);
                            $hc_actual[2] = $a3_val;
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_val += str_replace(',', '', $actual['disburse_amount']);
                            $hc_actual[3] = $a4_val;
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    if ($g_quarter == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if ($g_quarter == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if ($g_quarter == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if ($g_quarter == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($seed_actual as $actual) {
                        $k = 0;

                        foreach ($main_quarter as $key => $value) {
                            if ($actual['month'] == $key) {
                                $actual_month_value[$value] += str_replace(',', '', $actual['disburse_amount']);
                                $categories[$k] = $value;
                                $hc_actual[$k] = '0';
                            }
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($actual_month_value as $tv => $tv_amt) {
                        $hc_actual[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_actual[3] = array_sum($actual_month_value);
                }
            } else {
                foreach ($seed_actual as $actual) {
                    foreach ($main_quarter as $key => $value) {
                        if ($key == $actual['month']) {
                            $actual_month_value[$value] += str_replace(',', '', $actual['disburse_amount']);
                        }
                    }
                }
                $k = 0;
                foreach ($actual_month_value as $mv => $mv_amt) {
                    $hc_actual[$k] = $mv_amt;
                    $k++;
                }
                $hc_actual[3] = array_sum($actual_month_value);
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        ksort($categories);
        $id = $this->input->post('id');
        $data['div_id'] = 'fundingDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allSeedFund_HC.php');
    }

    // sector dashboard

    public function sectorqualitativeFilters() {
        $sector_id = $this->input->post('sector_id');
        $data['fin_year'] = $fin_year = $this->input->post('f_year');

        $qtr = $this->input->post('quarter');
        $type = $this->input->post('type');
        $actual_table = $this->input->post('actual_table') != '' ? $this->input->post('actual_table') : 'plan_qualitative_data';
        $column_name = $this->input->post('actual_field') != '' ? $this->input->post('actual_field') : 'description';

        // if ($actual_table == 'plan_qualitative_data')
        $module_id = $this->input->post('module_id');

        $fields = array('financial_year', 'month', 'created_at');
        array_push($fields, $column_name . ' as description');
        $actual_fields = implode(',', $fields);

        if ($qtr != 5) {
            if ($qtr == 1) {
                $qtr_fields = array('q_one_desc', 'apr_desc', 'may_desc', 'jun_desc', 'created_at');
                $month = array('4', '5', '6');
                $data['qtr_loop'] = array('q_one_desc' => 0, 'apr_desc' => 4, 'may_desc' => 5, 'jun_desc' => 6);
                $data['month_title'] = array(4 => 'Apr', 5 => 'May', 6 => 'Jun');
            } else if ($qtr == 2) {
                $qtr_fields = array('q_two_desc', 'jul_desc', 'aug_desc', 'sep_desc', 'created_at');
                $month = array('7', '8', '9');
                $data['qtr_loop'] = array('q_two_desc' => 0, 'jul_desc' => 7, 'aug_desc' => 8, 'sep_desc' => 9);
                $data['month_title'] = array(7 => 'Jul', 8 => 'Aug', 9 => 'Sep');
            } else if ($qtr == 3) {
                $qtr_fields = array('q_three_desc', 'oct_desc', 'nov_desc', 'dec_desc', 'created_at');
                $month = array('10', '11', '12');
                $data['qtr_loop'] = array('q_three_desc' => 0, 'oct_desc' => 10, 'nov_desc' => 11, 'dec_desc' => 12);
                $data['month_title'] = array(10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
            } else if ($qtr == 4) {
                $qtr_fields = array('q_four_desc', 'jan_desc', 'feb_desc', 'mar_desc', 'created_at');
                $month = array('1', '2', '3');
                $data['qtr_loop'] = array('q_four_desc' => 0, 'jan_desc' => 1, 'feb_desc' => 2, 'mar_desc' => 3);
                $data['month_title'] = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar');
            }

            $plan_qual_fields = implode(',', $qtr_fields);
            $actual_qual_fields = implode(',', $month);

            if ($module_id != '') {
                $conds = "sector_id = '" . $sector_id . "' and financial_year = '" . $fin_year . "' and module_id = '" . $module_id . "'";
            } else {
                $conds = "sector_id = '" . $sector_id . "' and financial_year = '" . $fin_year . "'";
            }

            $data['plan_qual'] = $this->Mportfolio->getQualitativeChart('sectorplan_qualitative_data', $conds, $qtr_fields, 1);

            if ($module_id != '' && $actual_table == 'sector_actual_qualitative_data') {
                $actualconds = "sector_id = '" . $sector_id . "' and financial_year = '" . $fin_year . "' and module_id = '" . $module_id . "'";
            } else {
                $actualconds = "sector_id = '" . $sector_id . "' and financial_year = '" . $fin_year . "'";
            }

            $i = 1;
            $actual_qual = array();
            foreach ($month as $mon) {
                $month_cond = "month = " . $mon;
                $data['actual_qual'][$mon] = $this->Mportfolio->getQualitativeActualChart($actual_table, $actual_fields, $actualconds, $month_cond, 3);
                $i++;
            }
        } else {
            $data['qtr_fields'] = $qtr_fields = array('q_one_desc', 'apr_desc', 'may_desc', 'jun_desc', 'q_two_desc', 'jul_desc', 'aug_desc', 'sep_desc', 'q_three_desc', 'oct_desc', 'nov_desc', 'dec_desc', 'q_four_desc', 'jan_desc', 'feb_desc', 'mar_desc', 'created_at');
            $data['month'] = $month = array('4', '5', '6', '7', '8', '9', '10', '11', '12', '1', '2', '3');
            $data['qtr_loop'] = array('q_one_desc' => 0, 'apr_desc' => 4, 'may_desc' => 5, 'jun_desc' => 6, 'q_two_desc' => 0, 'jul_desc' => 7, 'aug_desc' => 8, 'sep_desc' => 9, 'q_three_desc' => 0, 'oct_desc' => 10, 'nov_desc' => 11, 'dec_desc' => 12, 'q_four_desc' => 0, 'jan_desc' => 1, 'feb_desc' => 2, 'mar_desc' => 3);
            $data['month_title'] = array(4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec', 1 => 'Jan', 2 => 'Feb', 3 => 'Mar');
            $plan_qual_fields = implode(',', $qtr_fields);
            $actual_qual_fields = implode(',', $month);

            if ($module_id != '') {
                $conds = "sector_id = '" . $sector_id . "' and financial_year = '" . $fin_year . "' and module_id = '" . $module_id . "'";
            } else {
                $conds = "sector_id = '" . $sector_id . "' and financial_year = '" . $fin_year . "'";
            }

            $data['plan_qual'] = $this->Mportfolio->getQualitativeChart('sectorplan_qualitative_data', $conds, $qtr_fields, 1);

            if ($module_id != '' && $actual_table == 'sector_actual_qualitative_data') {
                $actualconds = "sector_id = '" . $sector_id . "' and financial_year = '" . $fin_year . "' and module_id = '" . $module_id . "'";
            } else {
                $actualconds = "sector_id = '" . $sector_id . "' and financial_year = '" . $fin_year . "'";
            }

            $i = 1;
            $actual_qual = array();
            foreach ($month as $mon) {
                $month_cond = "month = " . $mon;
                $data['actual_qual'][$mon] = $this->Mportfolio->getQualitativeActualChart($actual_table, $actual_fields, $actualconds, $month_cond, 3);
                $i++;
            }
        }

        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_qualitative/product_qualitative');
    }

    public function alldiscovery() {
        $partner_id = $this->session->userdata('partner_id');
        $sector = $this->input->post('sector');
        $sel_year = $this->input->post('f_year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

//        $g_sector = $this->input->post('sector');
        $g_sector = isset($sector) && $sector != '' ? $sector : '';
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : 0;
        $g_quarter = $this->input->post('quarter');

        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            // $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            // $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            // $data['sector_name'] = $sector_details[0]['sector'];
        }

        $month_arr = array(4 => 'Apr-' . $from_year, 5 => 'May-' . $from_year, 6 => 'Jun-' . $from_year, 7 => 'Jul-' . $from_year, 8 => 'Aug-' . $from_year, 9 => 'Sep-' . $from_year, 10 => 'Oct-' . $from_year, 11 => 'Nov-' . $from_year, 12 => 'Dec-' . $from_year, 1 => 'Jan-' . $nxt_year, 2 => 'Feb-' . $nxt_year, 3 => 'Mar-' . $nxt_year);

        $categories = $hc_target = $hc_actual = array();

        if ($type == 1) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);


            $monthly_target = $this->Sectorplan->getTargetDiscovery($month_where);
            $m = 0;
            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';
                $categories[$m] = $values;
                $hc_target[$m] = 0;
                if ($keys == 6) {
                    foreach ($monthly_target as $q1) {
                        $q1_tot += $q1['total_applications_q1'];
                    }
                    $hc_target[$m] = $q1_tot;
                }
                if ($keys == 9) {
                    foreach ($monthly_target as $q2) {
                        $q2_tot += $q2['total_applications_q2'];
                    }
                    $hc_target[$m] = $q2_tot;
                }
                if ($keys == 12) {
                    foreach ($monthly_target as $q3) {
                        $q3_tot += $q3['total_applications_q3'];
                    }
                    $hc_target[$m] = $q3_tot;
                }
                if ($keys == 3) {
                    foreach ($monthly_target as $q4) {
                        $q4_tot += $q4['total_applications_q4'];
                    }
                    $hc_target[$m] = $q4_tot;
                }

                $monthly_actual = $this->Sectorplan->companyApplicationCount($g_sector, '', $from_year, $keys);
                if ($monthly_actual != '') {
                    $hc_actual[$m] = $monthly_actual[0]['inc_app'] + $monthly_actual[0]['eir_app'] + $monthly_actual[0]['seed_app'] + $monthly_actual[0]['pitch_app'] + $monthly_actual[0]['liveli_app'];
                } else {
                    $hc_actual[$m] = 0;
                }
                $m++;
            }
        } else if ($type == 2) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);


            $monthly_target = $this->Sectorplan->getTargetDiscovery($month_where);

            $impt_act = array();
            $disc_tarqaut['q1'] = 0;
            $disc_tarqaut['q2'] = 0;
            $disc_tarqaut['q3'] = 0;
            $disc_tarqaut['q4'] = 0;
            $disc_actquat['q1'] = 0;
            $disc_actquat['q2'] = 0;
            $disc_actquat['q3'] = 0;
            $disc_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {

                $disc_tarqaut['q1'] += $targs['total_applications_q1'];
                $disc_tarqaut['q2'] += $targs['total_applications_q2'];
                $disc_tarqaut['q3'] += $targs['total_applications_q3'];
                $disc_tarqaut['q4'] += $targs['total_applications_q4'];
            }

            $m = 0;
            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';

                $monthly_actual = $this->Sectorplan->companyApplicationCount($g_sector, '', $from_year, $keys);

                if ($keys == 4 || $keys == 5 || $keys == 6) {
                    $d = 'q1';
                } else if ($keys == 7 || $keys == 8 || $keys == 9) {
                    $d = 'q2';
                } else if ($keys == 10 || $keys == 11 || $keys == 12) {
                    $d = 'q3';
                } else if ($keys == 1 || $keys == 2 || $keys == 3) {
                    $d = 'q4';
                }
                if ($monthly_actual != '') {
                    $disc_actquat[$d] += $monthly_actual[0]['inc_app'] + $monthly_actual[0]['eir_app'] + $monthly_actual[0]['seed_app'] + $monthly_actual[0]['pitch_app'] + $monthly_actual[0]['liveli_app'];
                } else {
                    $disc_actquat[$d] += 0;
                }
                $m++;
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $disc_tarqaut['q1'];
            $hc_target[1] = $disc_tarqaut['q2'];
            $hc_target[2] = $disc_tarqaut['q3'];
            $hc_target[3] = $disc_tarqaut['q4'];
            $hc_target[4] = $disc_tarqaut['q1'] + $disc_tarqaut['q2'] + $disc_tarqaut['q3'] + $disc_tarqaut['q4'];

            $hc_actual[0] = $disc_actquat['q1'];
            $hc_actual[1] = $disc_actquat['q2'];
            $hc_actual[2] = $disc_actquat['q3'];
            $hc_actual[3] = $disc_actquat['q4'];
            $hc_actual[4] = $disc_actquat['q1'] + $disc_actquat['q2'] + $disc_actquat['q3'] + $disc_actquat['q4'];
        }


        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $data['div_id'] = 'discoveryDiv_' . $id;
        $data['text'] = 'Total no. of Applications';
        $data['yaxis'] = "Total no. of Applications";
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/sector_graph');
    }

    public function alldiligence() {
        $partner_id = $this->session->userdata('partner_id');
        $sector = $this->input->post('sector');
        $sel_year = $this->input->post('f_year');
        $module = $this->input->post('module');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = isset($sector) && $sector != '' ? $sector : '';
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : 0;
        $g_quarter = $this->input->post('quarter');

        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            // $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            // $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            // $data['sector_name'] = $sector_details[0]['sector'];
        }

        $month_arr = array(4 => 'Apr-' . $from_year, 5 => 'May-' . $from_year, 6 => 'Jun-' . $from_year, 7 => 'Jul-' . $from_year, 8 => 'Aug-' . $from_year, 9 => 'Sep-' . $from_year, 10 => 'Oct-' . $from_year, 11 => 'Nov-' . $from_year, 12 => 'Dec-' . $from_year, 1 => 'Jan-' . $nxt_year, 2 => 'Feb-' . $nxt_year, 3 => 'Mar-' . $nxt_year);

        $categories = $hc_target = $hc_actual = array();

        if ($type == 1) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);


            $monthly_target = $this->Sectorplan->getTargetDiligence($month_where);
            $m = 0;
            $pard_count = array();
            $iic_count = array();
            $eic_count = array();
            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';
                $categories[$m] = $values;
                $hc_target[$m] = 0;
                $hc_actual[$m] = 0;

                if ($module == 1) {

                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_pard'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_pard'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_pard'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_pard'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }

                    $pard_allcount = $this->Sectorplan->pard_allCount($g_sector, $from_year, $keys);
                    if (php72_count($pard_allcount) != 0) {
                        foreach ($pard_allcount as $pards) {
                            if (!isset($pard_count[$pards['id']])) {
                                $pard_count[$pards['id']] = 1;
                                $hc_actual[$m] += 1;
                            } else {
                                $hc_actual[$m] = $hc_actual[$m];
                            }
                        }
                    } else {
                        $hc_actual[$m] = 0;
                    }
                } else if ($module == 2) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_iic'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_iic'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_iic'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_iic'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }

                    $IIC_allCount = $this->Sectorplan->IIC_allCount($g_sector, $from_year, $keys);

                    if (php72_count($IIC_allCount) != 0) {
                        foreach ($IIC_allCount as $iics) {
                            if (!isset($iic_count[$iics['id']])) {
                                $iic_count[$iics['id']] = 1;
                                $hc_actual[$m] += 1;
                            } else {
                                $hc_actual[$m] = $hc_actual[$m];
                            }
                        }
                    } else {
                        $hc_actual[$m] = 0;
                    }
                } else if ($module == 3) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_eic'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_eic'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_eic'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_eic'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }

                    $EIC_allcount = $this->Sectorplan->EIC_allcount($g_sector, $from_year, $keys);
                    if (php72_count($EIC_allcount) != 0) {
                        foreach ($EIC_allcount as $eics) {
                            if (!isset($eic_count[$eics['id']])) {
                                $eic_count[$eics['id']] = 1;
                                $hc_actual[$m] += 1;
                            } else {
                                $hc_actual[$m] = $hc_actual[$m];
                            }
                        }
                    } else {
                        $hc_actual[$m] = 0;
                    }
                }


                $m++;
            }
        } else if ($type == 2) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);


            $monthly_target = $this->Sectorplan->getTargetDiligence($month_where);

            $impt_act = array();
            $dilig_tarqaut['q1'] = 0;
            $dilig_tarqaut['q2'] = 0;
            $dilig_tarqaut['q3'] = 0;
            $dilig_tarqaut['q4'] = 0;
            $dilig_actquat['q1'] = 0;
            $dilig_actquat['q2'] = 0;
            $dilig_actquat['q3'] = 0;
            $dilig_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                if ($module == 1) {
                    $nm = 'pard';
                } else if ($module == 2) {
                    $nm = 'iic';
                } else if ($module == 3) {
                    $nm = 'eic';
                }
                $dilig_tarqaut['q1'] += $targs['q1_' . $nm];
                $dilig_tarqaut['q2'] += $targs['q2_' . $nm];
                $dilig_tarqaut['q3'] += $targs['q3_' . $nm];
                $dilig_tarqaut['q4'] += $targs['q4_' . $nm];
            }

            $m = 0;
            $pard_count = array();
            $iic_count = array();
            $eic_count = array();
            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';

                if ($keys == 4 || $keys == 5 || $keys == 6) {
                    $d = 'q1';
                } else if ($keys == 7 || $keys == 8 || $keys == 9) {
                    $d = 'q2';
                } else if ($keys == 10 || $keys == 11 || $keys == 12) {
                    $d = 'q3';
                } else if ($keys == 1 || $keys == 2 || $keys == 3) {
                    $d = 'q4';
                }
                if ($module == 1) {
                    $pard_allcount = $this->Sectorplan->pard_allCount($g_sector, $from_year, $keys);
                    if (php72_count($pard_allcount) != 0) {
                        foreach ($pard_allcount as $pards) {
                            if (!isset($pard_count[$pards['id']])) {
                                $pard_count[$pards['id']] = 1;
                                $dilig_actquat[$d] += 1;
                            } else {
                                $dilig_actquat[$d] = $dilig_actquat[$d];
                            }
                        }
                    } else {
                        $dilig_actquat[$d] = $dilig_actquat[$d];
                    }
                } else if ($module == 2) {
                    $IIC_allCount = $this->Sectorplan->IIC_allCount($g_sector, $from_year, $keys);

                    if (php72_count($IIC_allCount) != 0) {
                        foreach ($IIC_allCount as $iics) {
                            if (!isset($iic_count[$iics['id']])) {
                                $iic_count[$iics['id']] = 1;
                                $dilig_actquat[$d] += 1;
                            } else {
                                $dilig_actquat[$d] = $dilig_actquat[$d];
                            }
                        }
                    } else {
                        $dilig_actquat[$d] = $dilig_actquat[$d];
                    }
                } else if ($module == 3) {
                    $EIC_allcount = $this->Sectorplan->EIC_allcount($g_sector, $from_year, $keys);
                    if (php72_count($EIC_allcount) != 0) {
                        foreach ($EIC_allcount as $eics) {
                            if (!isset($eic_count[$eics['id']])) {
                                $eic_count[$eics['id']] = 1;
                                $dilig_actquat[$d] += 1;
                            } else {
                                $dilig_actquat[$d] = $dilig_actquat[$d];
                            }
                        }
                    } else {
                        $dilig_actquat[$d] = $dilig_actquat[$d];
                    }
                }


                $m++;
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $dilig_tarqaut['q1'];
            $hc_target[1] = $dilig_tarqaut['q2'];
            $hc_target[2] = $dilig_tarqaut['q3'];
            $hc_target[3] = $dilig_tarqaut['q4'];
            $hc_target[4] = $dilig_tarqaut['q1'] + $dilig_tarqaut['q2'] + $dilig_tarqaut['q3'] + $dilig_tarqaut['q4'];

            $hc_actual[0] = $dilig_actquat['q1'];
            $hc_actual[1] = $dilig_actquat['q2'];
            $hc_actual[2] = $dilig_actquat['q3'];
            $hc_actual[3] = $dilig_actquat['q4'];
            $hc_actual[4] = $dilig_actquat['q1'] + $dilig_actquat['q2'] + $dilig_actquat['q3'] + $dilig_actquat['q4'];
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $data['div_id'] = 'diligenceDiv_' . $id;

        if ($module == 1) {
            $data['yaxis'] = "No. of Deals at PA/RD";
            $data['text'] = 'No. of Deals at PA/RD';
        } else if ($module == 2) {
            $data['yaxis'] = "No. of Deals brought to IIC";
            $data['text'] = 'No. of Deals brought to IIC';
        } else {
            $data['yaxis'] = "No. of Deals brought to EIC";
            $data['text'] = 'No. of Deals brought to EIC';
        }
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/sector_graph');
    }

    public function allselection() {
        $partner_id = $this->session->userdata('partner_id');
        $sector = $this->input->post('sector');
        $sel_year = $this->input->post('f_year');
        $module = $this->input->post('module');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = isset($sector) && $sector != '' ? $sector : '';
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : 0;
        $g_quarter = $this->input->post('quarter');

        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            // $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            // $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            // $data['sector_name'] = $sector_details[0]['sector'];
        }

        $month_arr = array(4 => 'Apr-' . $from_year, 5 => 'May-' . $from_year, 6 => 'Jun-' . $from_year, 7 => 'Jul-' . $from_year, 8 => 'Aug-' . $from_year, 9 => 'Sep-' . $from_year, 10 => 'Oct-' . $from_year, 11 => 'Nov-' . $from_year, 12 => 'Dec-' . $from_year, 1 => 'Jan-' . $nxt_year, 2 => 'Feb-' . $nxt_year, 3 => 'Mar-' . $nxt_year);

        $categories = $hc_target = $hc_actual = array();
		
		
        if ($type == 1) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);


            $monthly_target = $this->Sectorplan->getTargetSelection($month_where);
            $m = 0;
			
            foreach ($month_arr as $keys => $values) {
                $yr = explode('-', $values);
                $monthly_actual = '';
                $categories[$m] = $values;
                $hc_target[$m] = 0;

                if ($g_sector != '') {
                    $total_condition = "BN.sector IN($g_sector)";
                }

                if ($module == 1) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_new_companies'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_new_companies'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_new_companies'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_new_companies'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }
                    $cur_date = date('Y-m');
                    $filter_date = date('Y-m', strtotime($yr[1] . '-' . $keys));
                    if ($filter_date <= $cur_date) {
                        $new_companies = $this->Sectorplan->getNewCompany($total_condition, $from_year, $keys);
                        if ($new_companies != '') {
                            $hc_actual[$m] = $new_companies[0]['new_company'];
                        } else {
                            $hc_actual[$m] = 0;
                        }
                    } else {
                        $hc_actual[$m] = 0;
                    }
                } else if ($module == 2) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_companies_in_portfolio'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_companies_in_portfolio'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_companies_in_portfolio'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_companies_in_portfolio'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }
                    $cur_date = date('Y-m');
                    $filter_date = date('Y-m', strtotime($yr[1] . '-' . $keys));
                    if ($filter_date <= $cur_date) {
                        $total_companies = $this->Sectorplan->getTotalCompany($total_condition, $from_year, $keys);
                        if ($total_companies != '') {
                            $hc_actual[$m] = $total_companies[0]['total_company'];
                        } else {
                            $hc_actual[$m] = 0;
                        }
                    } else {
                        $hc_actual[$m] = 0;
                    }
                }


                $m++;
            }
        } else if ($type == 2) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);

            $monthly_target = $this->Sectorplan->getTargetSelection($month_where);
            $impt_act = array();
            $selec_tarqaut['q1'] = 0;
            $selec_tarqaut['q2'] = 0;
            $selec_tarqaut['q3'] = 0;
            $selec_tarqaut['q4'] = 0;
            $selec_actquat['q1'] = 0;
            $selec_actquat['q2'] = 0;
            $selec_actquat['q3'] = 0;
            $selec_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                if ($module == 1) {
                    $nm = 'new_companies';
                } else if ($module == 2) {
                    $nm = 'companies_in_portfolio';
                }
                $selec_tarqaut['q1'] += $targs['q1_' . $nm];
                $selec_tarqaut['q2'] += $targs['q2_' . $nm];
                $selec_tarqaut['q3'] += $targs['q3_' . $nm];
                $selec_tarqaut['q4'] += $targs['q4_' . $nm];
            }

            $m = 0;
            $compan = $selec_actquat1 = array();
            foreach ($month_arr as $keys => $values) {
                $yr = explode('-', $values);
                $digits = (int) (log($keys, 10) + 1);
                if ($digits > 1) {
                    $monthkey = $keys;
                } else {
                    $monthkey = 0 . $keys;
                }
                $monthly_actual = '';

                if ($g_sector != '') {
					
					#CR CHANGE
					
                    #$total_condition = "BN.sector IN($g_sector)";
					$dynamicConditions = "(FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0 OR (B.sector IS NULL AND FIND_IN_SET('$sector', REPLACE(BN.sector, ' ', '')) > 0)) AND ";
					$dynamicConditions = rtrim($dynamicConditions, " AND ");
					$total_condition = $dynamicConditions;
					#CR CHANGE
                }

                if ($keys == 4 || $keys == 5 || $keys == 6) {
                    $d = 'q1';
                } else if ($keys == 7 || $keys == 8 || $keys == 9) {
                    $d = 'q2';
                } else if ($keys == 10 || $keys == 11 || $keys == 12) {
                    $d = 'q3';
                } else if ($keys == 1 || $keys == 2 || $keys == 3) {
                    $d = 'q4';
                }
                if ($module == 1) {
                    $cur_date = date('Y-m');
                    $filter_date = date('Y-m', strtotime($yr[1] . '-' . $keys));
                    if ($filter_date <= $cur_date) {
						
                        $new_companies = $this->Sectorplan->getQuarterwiseNewCompany($total_condition, $from_year, $keys);
						#echo'<pre>';print_r($new_companies);die;
						
                        if ($filter_date == $cur_date) {
                            $final_mn = $keys;
                            if ($keys == 4 || $keys == 5 || $keys == 6) {
                                $final_qt = 0;
                            } else if ($keys == 7 || $keys == 8 || $keys == 9) {
                                $final_qt = 1;
                            } else if ($keys == 10 || $keys == 11 || $keys == 12) {
                                $final_qt = 2;
                            } else if ($keys == 1 || $keys == 2 || $keys == 3) {
                                $final_qt = 3;
                            }
                        }
                        if ($new_companies != '' && php72_count($new_companies) > 0) {
                            foreach ($new_companies as $list) {
                                // if(!isset($compan[$d][$list['inv_id']])){
                                $compan[$d][$list['inv_id']] = 1;
                                $selec_actquat1[$keys] += 1;
                                // }
                                $selec_actquat1[$d] += 1;
                            }
                        } else {
                            $selec_actquat1[$keys] = 0;
                            $selec_actquat1[$d] = $selec_actquat1[$d];
                        }
                    } else {
                        $selec_actquat1[$keys] = 0;
                        $selec_actquat1[$d] = $selec_actquat1[$d];
                    }
                } else if ($module == 2) {
                    $cur_date = date('Y-m');
                    $filter_date = date('Y-m', strtotime($yr[1] . '-' . $keys));
                    if ($filter_date <= $cur_date) {
                        $total_companies = $this->Sectorplan->getQuarterwiseTotalCompany($total_condition, $from_year, $keys);
                        if ($filter_date == $cur_date) {
                            $final_mn = $keys;
                            if ($keys == 4 || $keys == 5 || $keys == 6) {
                                $final_qt = 0;
                            } else if ($keys == 7 || $keys == 8 || $keys == 9) {
                                $final_qt = 1;
                            } else if ($keys == 10 || $keys == 11 || $keys == 12) {
                                $final_qt = 2;
                            } else if ($keys == 1 || $keys == 2 || $keys == 3) {
                                $final_qt = 3;
                            }
                        }
// $selec_actquat[$d] = 0;
                        if ($total_companies != '') {
                            foreach ($total_companies as $list) {
                                $sys_date = date('Y-m', strtotime($yr[1] . '-' . $keys));
                                $db_date = date('Y-m', strtotime($list['exityear'] . '-' . $list['exitmonth']));
                                // if(!isset($compan[$d][$list['inv_id']])){
                                $compan[$d][$list['inv_id']] = 1;
                                $selec_actquat1[$keys] += 1;
                                // }
                            }
                        } else {
                            $selec_actquat1[$keys] += $selec_actquat1[$keys];
                        }
                    } else {
                        $selec_actquat1[$keys] = $selec_actquat1[$keys];
                    }
                }


                $m++;
            }
// $selec_tarqaut['q1'] = $selec_actquat1[6];
// $selec_tarqaut['q2'] = $selec_actquat1[9];
// $selec_tarqaut['q3'] = $selec_actquat1[12];
// $selec_tarqaut['q4'] = $selec_actquat1[3];

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            // $categories[4] = 'Annual';

            $hc_target[0] = $selec_tarqaut['q1'];
            $hc_target[1] = $selec_tarqaut['q2'];
            $hc_target[2] = $selec_tarqaut['q3'];
            $hc_target[3] = $selec_tarqaut['q4'];
            // $hc_target[4] = $selec_tarqaut['q1'] + $selec_tarqaut['q2'] + $selec_tarqaut['q3'] + $selec_tarqaut['q4'];
// print_r($selec_actquat1[q2]);
// die;
            if ($module == 2) {
                $hc_actual[0] = $selec_actquat1[6];
                $hc_actual[1] = $selec_actquat1[9];
                $hc_actual[2] = $selec_actquat1[12];
                $hc_actual[3] = $selec_actquat1[3];
            } else {
                $hc_actual[0] = $selec_actquat1[q1];
                $hc_actual[1] = $selec_actquat1[q2];
                $hc_actual[2] = $selec_actquat1[q3];
                $hc_actual[3] = $selec_actquat1[q4];
            }

//     $hc_actual[0] = $selec_actquat1[4] + $selec_actquat1[5] + $selec_actquat1[6];
// $hc_actual[1] = $selec_actquat1[7] + $selec_actquat1[8] + $selec_actquat1[9];
// $hc_actual[2] = $selec_actquat1[10] + $selec_actquat1[11] + $selec_actquat1[12];
// $hc_actual[3] = $selec_actquat1[1] + $selec_actquat1[2] + $selec_actquat1[3];
// if(isset($final_mn) && $final_mn != ''){
//     $hc_actual[$final_qt] = $selec_actquat1[$final_mn];
// }
            // $hc_actual[4] = $selec_actquat['q1'] + $selec_actquat['q2'] + $selec_actquat['q3'] + $selec_actquat['q4'];
        }


        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $data['div_id'] = 'selectionDiv_' . $id;

        if ($module == 1) {
            $data['yaxis'] = "No. of new companies";
            $data['text'] = 'No. of new companies';
        } else if ($module == 2) {
            $data['yaxis'] = "Total no. of companies in portfolio";
            $data['text'] = 'Total no. of companies in portfolio';
        }
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/sector_graph');
    }

    public function allgraduates_exits() {
        $partner_id = $this->session->userdata('partner_id');
        $sector = $this->input->post('sector');
        $sel_year = $this->input->post('f_year');
        $module = $this->input->post('module');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = isset($sector) && $sector != '' ? $sector : '';
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : 0;
        $g_quarter = $this->input->post('quarter');

        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            // $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            // $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            // $data['sector_name'] = $sector_details[0]['sector'];
        }

        $month_arr = array(4 => 'Apr-' . $from_year, 5 => 'May-' . $from_year, 6 => 'Jun-' . $from_year, 7 => 'Jul-' . $from_year, 8 => 'Aug-' . $from_year, 9 => 'Sep-' . $from_year, 10 => 'Oct-' . $from_year, 11 => 'Nov-' . $from_year, 12 => 'Dec-' . $from_year, 1 => 'Jan-' . $nxt_year, 2 => 'Feb-' . $nxt_year, 3 => 'Mar-' . $nxt_year);

        $categories = $hc_target = $hc_actual = array();
		
        if ($type == 1) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);

            $year_qry = $from_year;

            if ($module == 1) {
                $monthly_target = $this->Sectorplan->getTargetGraduates($month_where);
            } else if ($module == 2) {
                $monthly_target = $this->Sectorplan->getTargetExits($month_where);
            }
            $m = 0;
		
			
            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';
                $categories[$m] = $values;
                $hc_target[$m] = 0;

                if ($module == 1) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_graduates'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_graduates'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_graduates'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_graduates'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }
                    if ($keys == 1 || $keys == 2 || $keys == 3) {
                        $year_qry = $nxt_year;
                    }

                    $graduates_companies = $this->Sectorplan->getCompanies($g_sector, $year_qry, $keys, 2);
                    if ($graduates_companies != '') {
                        $hc_actual[$m] = php72_count($graduates_companies);
                    } else {
                        $hc_actual[$m] = 0;
                    }
                } else if ($module == 2) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_exits'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_exits'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_exits'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_exits'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }
                    if ($keys == 1 || $keys == 2 || $keys == 3) {
                        $year_qry = $nxt_year;
                    }

                    $exited_companies = $this->Sectorplan->getCompanies($g_sector, $year_qry, $keys, 3);
                    if ($exited_companies != '') {
                        $hc_actual[$m] = php72_count($exited_companies);
                    } else {
                        $hc_actual[$m] = 0;
                    }
                }


                $m++;
            }
        } else if ($type == 2) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);

            $year_qry = $from_year;
            if ($module == 1) {
                $monthly_target = $this->Sectorplan->getTargetGraduates($month_where);
            } else if ($module == 2) {
                $monthly_target = $this->Sectorplan->getTargetExits($month_where);
            }

            $impt_act = array();
            $grad_tarqaut['q1'] = 0;
            $grad_tarqaut['q2'] = 0;
            $grad_tarqaut['q3'] = 0;
            $grad_tarqaut['q4'] = 0;
            $grad_actquat['q1'] = 0;
            $grad_actquat['q2'] = 0;
            $grad_actquat['q3'] = 0;
            $grad_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                if ($module == 1) {
                    $nm = 'graduates';
                } else if ($module == 2) {
                    $nm = 'exits';
                }
                $grad_tarqaut['q1'] += $targs['q1_' . $nm];
                $grad_tarqaut['q2'] += $targs['q2_' . $nm];
                $grad_tarqaut['q3'] += $targs['q3_' . $nm];
                $grad_tarqaut['q4'] += $targs['q4_' . $nm];
            }

            $m = 0;
			
            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';

                if ($keys == 4 || $keys == 5 || $keys == 6) {
                    $d = 'q1';
                } else if ($keys == 7 || $keys == 8 || $keys == 9) {
                    $d = 'q2';
                } else if ($keys == 10 || $keys == 11 || $keys == 12) {
                    $d = 'q3';
                } else if ($keys == 1 || $keys == 2 || $keys == 3) {
                    $d = 'q4';
                    $year_qry = $nxt_year;
                }
                if ($module == 1) {
                    $graduates_companies = $this->Sectorplan->getCompanies($g_sector, $year_qry, $keys, 2);
                    if ($graduates_companies != '') {
                        $grad_actquat[$d] += php72_count($graduates_companies);
                    } else {
                        $grad_actquat[$d] += 0;
                    }
					#echo'<pre>';print_r($graduates_companies);die;
                } else if ($module == 2) {
                    $exited_companies = $this->Sectorplan->getCompanies($g_sector, $year_qry, $keys, 3);
                    if ($exited_companies != '') {
                        $grad_actquat[$d] += php72_count($exited_companies);
                    } else {
                        $grad_actquat[$d] += 0;
                    }
                }


                $m++;
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $grad_tarqaut['q1'];
            $hc_target[1] = $grad_tarqaut['q2'];
            $hc_target[2] = $grad_tarqaut['q3'];
            $hc_target[3] = $grad_tarqaut['q4'];
            $hc_target[4] = $grad_tarqaut['q1'] + $grad_tarqaut['q2'] + $grad_tarqaut['q3'] + $grad_tarqaut['q4'];

            $hc_actual[0] = $grad_actquat['q1'];
            $hc_actual[1] = $grad_actquat['q2'];
            $hc_actual[2] = $grad_actquat['q3'];
            $hc_actual[3] = $grad_actquat['q4'];
            $hc_actual[4] = $grad_actquat['q1'] + $grad_actquat['q2'] + $grad_actquat['q3'] + $grad_actquat['q4'];
        }


        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $data['div_id'] = 'graduates_exitsDiv_' . $id;

        if ($module == 1) {
            $data['yaxis'] = "Graduates (Non-Financial)";
            $data['text'] = 'Graduates (Non-Financial)';
        } else if ($module == 2) {
            $data['yaxis'] = "Exits (With Equity)";
            $data['text'] = 'Exits (With Equity)';
        }
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/sector_graph');
    }

    public function allsectorfundraise() {
        $partner_id = $this->session->userdata('partner_id');
        $sector = $this->input->post('sector');
        $sel_year = $this->input->post('f_year');
        $module = $this->input->post('module');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = isset($sector) && $sector != '' ? $sector : '';
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : 0;
        $g_quarter = $this->input->post('quarter');

        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            // $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            // $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            // $data['sector_name'] = $sector_details[0]['sector'];
        }

        $month_arr = array(4 => 'Apr-' . $from_year, 5 => 'May-' . $from_year, 6 => 'Jun-' . $from_year, 7 => 'Jul-' . $from_year, 8 => 'Aug-' . $from_year, 9 => 'Sep-' . $from_year, 10 => 'Oct-' . $from_year, 11 => 'Nov-' . $from_year, 12 => 'Dec-' . $from_year, 1 => 'Jan-' . $nxt_year, 2 => 'Feb-' . $nxt_year, 3 => 'Mar-' . $nxt_year);

        $categories = $hc_target = $hc_actual = array();

        if ($type == 1) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);

            if ($module == 1) {
                $monthly_target = $this->Sectorplan->getTargetRenewalagreement($month_where);
            } else if ($module == 2) {
                $monthly_target = $this->Sectorplan->getTargetNewagreement($month_where);
            }
            $m = 0;
            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';
                $categories[$m] = $values;
                $hc_target[$m] = 0;

                if ($module == 1) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_renewal_agreements'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_renewal_agreements'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_renewal_agreements'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_renewal_agreements'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }

                    $renewalsum = $this->Sectorplan->getSumrenewalagreement($g_sector);
                    if ($renewalsum != '') {

                        foreach ($renewalsum as $renewdata) {
                            if ($renewdata['renewalmonth'] == 1 || $renewdata['renewalmonth'] == 2 || $renewdata['renewalmonth'] == 3) {
                                $renewyear = $renewdata['renewalyear'] - 1;
                            } else {
                                $renewyear = $renewdata['renewalyear'];
                            }
                            if ($from_year == $renewyear && $keys == $renewdata['renewalmonth']) {
                                $hc_actual[$m] += $renewdata['amount'];
                            } else {
                                $hc_actual[$m] += 0;
                            }
                        }
                    } else {
                        $hc_actual[$m] = 0;
                    }
                } else if ($module == 2) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_new_agreements'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_new_agreements'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_new_agreements'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_new_agreements'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }

                    $newsum = $this->Sectorplan->getSumnewagreement($g_sector);
                    if ($newsum != '') {
                        foreach ($newsum as $newdata) {
                            if ($newdata['newagreemonth'] == 1 || $newdata['newagreemonth'] == 2 || $newdata['newagreemonth'] == 3) {
                                $newagreeyear = $newdata['newagreeyear'] - 1;
                            } else {
                                $newagreeyear = $newdata['newagreeyear'];
                            }
                            if ($from_year == $newagreeyear && $keys == $newdata['newagreemonth']) {
                                $hc_actual[$m] += $newdata['amount'];
                            } else {
                                $hc_actual[$m] += 0;
                            }
                        }
                    } else {
                        $hc_actual[$m] = 0;
                    }
                }
                $m++;
            }
        } else if ($type == 2) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);


            if ($module == 1) {
                $monthly_target = $this->Sectorplan->getTargetRenewalagreement($month_where);
            } else if ($module == 2) {
                $monthly_target = $this->Sectorplan->getTargetNewagreement($month_where);
            }

            $impt_act = array();
            $fund_tarqaut['q1'] = 0;
            $fund_tarqaut['q2'] = 0;
            $fund_tarqaut['q3'] = 0;
            $fund_tarqaut['q4'] = 0;
            $fund_actquat['q1'] = 0;
            $fund_actquat['q2'] = 0;
            $fund_actquat['q3'] = 0;
            $fund_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                if ($module == 1) {
                    $nm = 'renewal_agreements';
                } else if ($module == 2) {
                    $nm = 'new_agreements';
                }
                $fund_tarqaut['q1'] += $targs['q1_' . $nm];
                $fund_tarqaut['q2'] += $targs['q2_' . $nm];
                $fund_tarqaut['q3'] += $targs['q3_' . $nm];
                $fund_tarqaut['q4'] += $targs['q4_' . $nm];
            }

            $m = 0;

            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';

                if ($keys == 4 || $keys == 5 || $keys == 6) {
                    $d = 'q1';
                } else if ($keys == 7 || $keys == 8 || $keys == 9) {
                    $d = 'q2';
                } else if ($keys == 10 || $keys == 11 || $keys == 12) {
                    $d = 'q3';
                } else if ($keys == 1 || $keys == 2 || $keys == 3) {
                    $d = 'q4';
                }
                if ($module == 1) {
                    $renewalsum = $this->Sectorplan->getSumrenewalagreement($g_sector);
                    if ($renewalsum != '') {

                        foreach ($renewalsum as $renewdata) {
                            if ($renewdata['renewalmonth'] == 1 || $renewdata['renewalmonth'] == 2 || $renewdata['renewalmonth'] == 3) {
                                $renewyear = $renewdata['renewalyear'] - 1;
                            } else {
                                $renewyear = $renewdata['renewalyear'];
                            }
                            if ($from_year == $renewyear && $keys == $renewdata['renewalmonth']) {
                                $fund_actquat[$d] += $renewdata['amount'];
                            } else {
                                $fund_actquat[$d] += 0;
                            }
                        }
                    } else {
                        $fund_actquat[$d] = 0;
                    }
                } else if ($module == 2) {
                    $newsum = $this->Sectorplan->getSumnewagreement($g_sector);
                    if ($newsum != '') {
                        foreach ($newsum as $newdata) {
                            if ($newdata['newagreemonth'] == 1 || $newdata['newagreemonth'] == 2 || $newdata['newagreemonth'] == 3) {
                                $newagreeyear = $newdata['newagreeyear'] - 1;
                            } else {
                                $newagreeyear = $newdata['newagreeyear'];
                            }
                            if ($from_year == $newagreeyear && $keys == $newdata['newagreemonth']) {
                                $fund_actquat[$d] += $newdata['amount'];
                            } else {
                                $fund_actquat[$d] += 0;
                            }
                        }
                    } else {
                        $fund_actquat[$d] = 0;
                    }
                }
                $m++;
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $fund_tarqaut['q1'];
            $hc_target[1] = $fund_tarqaut['q2'];
            $hc_target[2] = $fund_tarqaut['q3'];
            $hc_target[3] = $fund_tarqaut['q4'];
            $hc_target[4] = $fund_tarqaut['q1'] + $fund_tarqaut['q2'] + $fund_tarqaut['q3'] + $fund_tarqaut['q4'];

            $hc_actual[0] = $fund_actquat['q1'];
            $hc_actual[1] = $fund_actquat['q2'];
            $hc_actual[2] = $fund_actquat['q3'];
            $hc_actual[3] = $fund_actquat['q4'];
            $hc_actual[4] = $fund_actquat['q1'] + $fund_actquat['q2'] + $fund_actquat['q3'] + $fund_actquat['q4'];
        }


        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            $hc_actual_sum = $hc_actual[$m] / 100000;
            $hc_actual_comma = number_format($hc_actual_sum, 2);
            $hc_actual[$m] = str_replace(',', '', $hc_actual_comma);
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $data['div_id'] = 'fundraiseDiv_' . $id;

        if ($module == 1) {
            $data['yaxis'] = "Renewal Agreements";
            $data['text'] = 'Renewal Agreements';
        } else if ($module == 2) {
            $data['yaxis'] = "New Agreements";
            $data['text'] = 'New Agreements';
        }
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/sector_graph');
    }

    public function allfinancialstability() {
        $partner_id = $this->session->userdata('partner_id');
        $sector = $this->input->post('sector');
        $sel_year = $this->input->post('f_year');
        $module = $this->input->post('module');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = isset($sector) && $sector != '' ? $sector : '';
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : 0;
        $g_quarter = $this->input->post('quarter');

        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            // $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            // $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            // $data['sector_name'] = $sector_details[0]['sector'];
        }

        $month_arr = array(4 => 'Apr-' . $from_year, 5 => 'May-' . $from_year, 6 => 'Jun-' . $from_year, 7 => 'Jul-' . $from_year, 8 => 'Aug-' . $from_year, 9 => 'Sep-' . $from_year, 10 => 'Oct-' . $from_year, 11 => 'Nov-' . $from_year, 12 => 'Dec-' . $from_year, 1 => 'Jan-' . $nxt_year, 2 => 'Feb-' . $nxt_year, 3 => 'Mar-' . $nxt_year);

        $categories = $hc_target = $hc_actual = array();
		
        if ($type == 1) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);

            if ($module == 1) {
                $monthly_target = $this->Sectorplan->getTargetEquity($month_where);
            } else if ($module == 2) {
                $monthly_target = $this->Sectorplan->getTargetConsultingengagement($month_where);
            }
            $m = 0;
			
            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';
                $categories[$m] = $values;
                $hc_target[$m] = 0;

                if ($module == 1) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_equity'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_equity'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_equity'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_equity'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }

                    $equity_companies = $this->Sectorplan->getActualEquityCompanies($g_sector, $keys, $from_year);
                    if ($equity_companies != '') {
                        $hc_actual[$m] = $equity_companies[0]['equitycount'];
                    } else {
                        $hc_actual[$m] = 0;
                    }
                } else if ($module == 2) {
                    if ($keys == 6) {
                        foreach ($monthly_target as $q1) {
                            $q1_tot += $q1['q1_portfolioreturns'];
                        }
                        $hc_target[$m] = $q1_tot;
                    }
                    if ($keys == 9) {
                        foreach ($monthly_target as $q2) {
                            $q2_tot += $q2['q2_portfolioreturns'];
                        }
                        $hc_target[$m] = $q2_tot;
                    }
                    if ($keys == 12) {
                        foreach ($monthly_target as $q3) {
                            $q3_tot += $q3['q3_portfolioreturns'];
                        }
                        $hc_target[$m] = $q3_tot;
                    }
                    if ($keys == 3) {
                        foreach ($monthly_target as $q4) {
                            $q4_tot += $q4['q4_portfolioreturns'];
                        }
                        $hc_target[$m] = $q4_tot;
                    }

                    $consulting_data = $this->Sectorplan->getActualConsultingengagement($g_sector, $keys, $from_year);
                    if ($consulting_data != '') {
                        $hc_actual[$m] = $consulting_data[0]['consultingcount'];
                    } else {
                        $hc_actual[$m] = 0;
                    }
                }


                $m++;
            }
        } else if ($type == 2) {
            if ($g_sector != '') {
                $search_month[] = "t1.sector_id = '$g_sector'";
            }
            $search_month[] = "t1.financial_year = $from_year";
            $month_where = php72_implode(" and ", $search_month);


            if ($module == 1) {
                $monthly_target = $this->Sectorplan->getTargetEquity($month_where);
            } else if ($module == 2) {
                $monthly_target = $this->Sectorplan->getTargetConsultingengagement($month_where);
            }

            $impt_act = array();
            $finan_tarqaut['q1'] = 0;
            $finan_tarqaut['q2'] = 0;
            $finan_tarqaut['q3'] = 0;
            $finan_tarqaut['q4'] = 0;
            $finan_actquat['q1'] = 0;
            $finan_actquat['q2'] = 0;
            $finan_actquat['q3'] = 0;
            $finan_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                if ($module == 1) {
                    $nm = 'equity';
                } else if ($module == 2) {
                    $nm = 'portfolioreturns';
                }
                $finan_tarqaut['q1'] += $targs['q1_' . $nm];
                $finan_tarqaut['q2'] += $targs['q2_' . $nm];
                $finan_tarqaut['q3'] += $targs['q3_' . $nm];
                $finan_tarqaut['q4'] += $targs['q4_' . $nm];
            }

            $m = 0;

            foreach ($month_arr as $keys => $values) {
                $monthly_actual = '';

                if ($keys == 4 || $keys == 5 || $keys == 6) {
                    $d = 'q1';
                } else if ($keys == 7 || $keys == 8 || $keys == 9) {
                    $d = 'q2';
                } else if ($keys == 10 || $keys == 11 || $keys == 12) {
                    $d = 'q3';
                } else if ($keys == 1 || $keys == 2 || $keys == 3) {
                    $d = 'q4';
                }
                if ($module == 1) {
                    $equity_companies = $this->Sectorplan->getActualEquityCompanies($g_sector, $keys, $from_year);
					#echo'<pre>';print_r($equity_companies);die;
                    if ($equity_companies != '') {
                        $finan_actquat[$d] += $equity_companies[0]['equitycount'];
                    } else {
                        $finan_actquat[$d] += 0;
                    }
                } else if ($module == 2) {
                    $consulting_data = $this->Sectorplan->getActualConsultingengagement($g_sector, $keys, $from_year);
                    if ($consulting_data != '') {
                        $finan_actquat[$d] += $consulting_data[0]['consultingcount'];
                    } else {
                        $finan_actquat[$d] += 0;
                    }
                }


                $m++;
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $finan_tarqaut['q1'];
            $hc_target[1] = $finan_tarqaut['q2'];
            $hc_target[2] = $finan_tarqaut['q3'];
            $hc_target[3] = $finan_tarqaut['q4'];
            $hc_target[4] = $finan_tarqaut['q1'] + $finan_tarqaut['q2'] + $finan_tarqaut['q3'] + $finan_tarqaut['q4'];

            $hc_actual[0] = $finan_actquat['q1'];
            $hc_actual[1] = $finan_actquat['q2'];
            $hc_actual[2] = $finan_actquat['q3'];
            $hc_actual[3] = $finan_actquat['q4'];
            $hc_actual[4] = $finan_actquat['q1'] + $finan_actquat['q2'] + $finan_actquat['q3'] + $finan_actquat['q4'];
        }


        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $data['div_id'] = 'financialDiv_' . $id;

        if ($module == 1) {
            $data['yaxis'] = "Equity Investments";
            $data['text'] = 'Equity Investments';
        } else if ($module == 2) {
            $data['yaxis'] = "Service Agreements";
            $data['text'] = 'Service Agreements';
        }
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/sector_graph');
    }

}
