<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      ExpressionEngine Dev Team
 * @copyright   Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since       Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Database Utility Class
 *
 * @category    Database
 * @author      ExpressionEngine Dev Team
 * @link        http://codeigniter.com/user_guide/database/
 */
class CI_DB_utility extends CI_DB_forge {

    var $db;
    var $data_cache = array();

    /**
     * Constructor
     *
     * Grabs the CI super object instance so we can access it.
     *
     */
    function __construct() {
        // Assign the main database object to $this->db
        $CI = & get_instance();
        $this->db = & $CI->db;
        $this->hris = & $CI->hris;

        log_message('debug', "Database Utility Class Initialized");
    }

    // --------------------------------------------------------------------

    /**
     * List databases
     *
     * @access  public
     * @return  bool
     */
    function list_databases() {
        // Is there a cached result?
        if (isset($this->data_cache['db_names'])) {
            return $this->data_cache['db_names'];
        }

        $query = $this->db->query($this->_list_databases());
        $dbs = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dbs[] = current($row);
            }
        }

        $this->data_cache['db_names'] = $dbs;
        return $this->data_cache['db_names'];
    }

    // --------------------------------------------------------------------

    /**
     * Determine if a particular database exists
     *
     * @access  public
     * @param   string
     * @return  boolean
     */
    function database_exists($database_name) {
        // Some databases won't have access to the list_databases() function, so
        // this is intended to allow them to override with their own functions as
        // defined in $driver_utility.php
        if (method_exists($this, '_database_exists')) {
            return $this->_database_exists($database_name);
        } else {
            return (!in_array($database_name, $this->list_databases())) ? FALSE : TRUE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Optimize Table
     *
     * @access  public
     * @param   string  the table name
     * @return  bool
     */
    function optimize_table($table_name) {
        $sql = $this->_optimize_table($table_name);

        if (is_bool($sql)) {
            show_error('db_must_use_set');
        }

        $query = $this->db->query($sql);
        $res = $query->result_array();

        // Note: Due to a bug in current() that affects some versions
        // of PHP we can not pass function call directly into it
        return current($res);
    }

    // --------------------------------------------------------------------

    /**
     * Optimize Database
     *
     * @access  public
     * @return  array
     */
    function optimize_database() {
        $result = array();
        foreach ($this->db->list_tables() as $table_name) {
            $sql = $this->_optimize_table($table_name);

            if (is_bool($sql)) {
                return $sql;
            }

            $query = $this->db->query($sql);

            // Build the result array...
            // Note: Due to a bug in current() that affects some versions
            // of PHP we can not pass function call directly into it
            $res = $query->result_array();
            $res = current($res);
            $key = str_replace($this->db->database . '.', '', current($res));
            $keys = array_keys($res);
            unset($res[$keys[0]]);

            $result[$key] = $res;
        }

        return $result;
    }

    // --------------------------------------------------------------------

    /**
     * Repair Table
     *
     * @access  public
     * @param   string  the table name
     * @return  bool
     */
    function repair_table($table_name) {
        $sql = $this->_repair_table($table_name);

        if (is_bool($sql)) {
            return $sql;
        }

        $query = $this->db->query($sql);

        // Note: Due to a bug in current() that affects some versions
        // of PHP we can not pass function call directly into it
        $res = $query->result_array();
        return current($res);
    }

    // --------------------------------------------------------------------

    /**
     * Generate CSV from a query result object
     *
     * @access  public
     * @param   object  The query result object
     * @param   string  The delimiter - comma by default
     * @param   string  The newline character - \n by default
     * @param   string  The enclosure - double quote by default
     * @return  string
     */
    function csv_from_result($query, $delim = ",", $newline = "\n", $enclosure = '"') {
        if (!is_object($query) OR ! method_exists($query, 'list_fields')) {
            show_error('You must submit a valid result object');
        }

        $out = '';

        // First generate the headings from the table column names
        foreach ($query->list_fields() as $name) {
            $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $name) . $enclosure . $delim;
        }

        $out = rtrim($out);
        $out .= $newline;

        // Next blast through the result array and build out the rows
        foreach ($query->result_array() as $row) {
            foreach ($row as $item) {
                $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $item) . $enclosure . $delim;
            }
            $out = rtrim($out);
            $out .= $newline;
        }

        return $out;
    }

    /* function csv_from_result_deals($query, $roleid, $independent_shortlist, $userid, $delim = ",", $newline = "\n", $enclosure = '"') {
         // echo '<pre>';print_r($query->result_array());exit;
        //$stage = array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation',"6" => 'Exited Innovation');
        //$status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed',"4" => 'Draft');
        $stage = array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "6" => 'Exited Innovation', "Pre-Product" => "Pre-Product", "Pre-Revenue" => "Pre-Revenue", "Pre-Scale" => "Pre-Scale", "7" => 'Application', "8" => 'PA/RD', "9" => 'Detailed Diligence', "10" => 'Final Negotiations', "11" => 'Incubation', '12' => 'Portfolio');
        $status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed', "4" => 'Draft', "5" => 'Pending', "6" => 'Decision Pending', "7" => 'Lead', "8" => 'Incubation', "9" => 'Exited', "10" => 'Registered', "11" => 'Deleted', "12" => 'Open', "13" => 'Open - IIC Approved', "14" => 'Closed - IIC Rejected', "15" => 'User Accepted', "16" => 'User Rejected', "17" => 'EIC Approved', "18" => 'EIC Rejected', "19" => 'Re-Opened', "20" => 'Final Negotiation', "23" => 'Company Graduated', "24" => 'Open-Banked', "25" => 'Shortlisted', "26" => 'Selected');

        if (!is_object($query) OR ! method_exists($query, 'list_fields')) {
            show_error('You must submit a valid result object');
        }

        if ($roleid == 4 && $independent_shortlist == 1) {
            $log_title = array('PA/RD_Date', 'Accept_for_IIC_Date', 'IIC_Accept_Date', 'IIC_Reject_Date', 'EIC_Accept_Date', 'EIC_Reject_Date', 'Close_Date', 'Rejection_Mail_Sent_Date', 'Language', 'User Name', 'Status', 'Comments');
        } else {
            $log_title = array('PA/RD_Date', 'Accept_for_IIC_Date', 'IIC_Accept_Date', 'IIC_Reject_Date', 'EIC_Accept_Date', 'EIC_Reject_Date', 'Close_Date', 'Rejection_Mail_Sent_Date', 'Language');
        }
        $title = array_merge($query->list_fields(), $log_title);

        $out = '';

        // First generate the headings from the table column names
        foreach ($title as $name) {
            if ($name != 'id' && $name != 'pitch_id')
                $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $name) . $enclosure . $delim;
        }

        $out = rtrim($out);
        $out .= $newline;

        // Next blast through the result array and build out the rows
        foreach ($query->result_array() as $row) {
            $inv_id = explode('_', $row['Innovation_id']);
            $get_id = $inv_id[0];
            $logData = $this->getLogValue($get_id);
			
			if($row['Program'] =='Tvaran'){
				 $row['Sub_Sector'] =  $this->getSectorName($row['Sub_Sector']);
			}
            if (count($logData) > 0) {
                foreach ($logData as $log) {
                    if ($log['id'] != '') {
                        if ($log['stage'] == '8' && $log['status'] == '12' && $row['PA/RD_Date'] == '') {
                            $row['PA/RD_Date'] = $log['modified_date'];
                        } else if ($row['PA/RD_Date'] != '') {
                            $row['PA/RD_Date'] = $row['PA/RD_Date'];
                        } else {
                            $row['PA/RD_Date'] = '';
                        }

                        if ($log['stage'] == '8' && $log['status'] == '15' && $row['Accept_for_IIC_Date'] == '') {
                            $row['Accept_for_IIC_Date'] = $log['modified_date'];
                        } else if ($row['Accept_for_IIC_Date'] != '') {
                            $row['Accept_for_IIC_Date'] = $row['Accept_for_IIC_Date'];
                        } else {
                            $row['Accept_for_IIC_Date'] = '';
                        }

                        if ($log['stage'] == '9' && ($log['status'] == '12' || $log['status'] == '13') && $row['IIC_Accept_Date'] == '') {
                            $row['IIC_Accept_Date'] = $log['modified_date'];
                        } else if ($row['IIC_Accept_Date'] != '') {
                            $row['IIC_Accept_Date'] = $row['IIC_Accept_Date'];
                        } else {
                            $row['IIC_Accept_Date'] = '';
                        }

                        if ($log['stage'] == '8' && $log['status'] == '14' && $row['IIC_Reject_Date'] == '') {
                            $row['IIC_Reject_Date'] = $log['modified_date'];
                        } else if ($row['IIC_Reject_Date'] != '') {
                            $row['IIC_Reject_Date'] = $row['IIC_Reject_Date'];
                        } else {
                            $row['IIC_Reject_Date'] = '';
                        }

                        if ($log['stage'] == '9' && $log['status'] == '17' && $row['EIC_Accept_Date'] == '') {
                            $row['EIC_Accept_Date'] = $log['modified_date'];
                        } else if ($row['EIC_Accept_Date'] != '') {
                            $row['EIC_Accept_Date'] = $row['EIC_Accept_Date'];
                        } else {
                            $row['EIC_Accept_Date'] = '';
                        }

                        if ($log['stage'] == '9' && $log['status'] == '18' && $row['EIC_Reject_Date'] == '') {
                            $row['EIC_Reject_Date'] = $log['modified_date'];
                        } else if ($row['EIC_Reject_Date'] != '') {
                            $row['EIC_Reject_Date'] = $row['EIC_Reject_Date'];
                        } else {
                            $row['EIC_Reject_Date'] = '';
                        }

                        if ($log['status'] == '3' && $row['Close_Date'] == '' && $row['Status'] == '3') {
                            $row['Close_Date'] = $log['modified_date'];
                        } else if ($row['Close_Date'] != '' && $row['Status'] == '3') {
                            $row['Close_Date'] = $row['Close_Date'];
                        } else {
                            $row['Close_Date'] = '';
                        }
                    }
                }
            } else {
                $row['PA/RD_Date'] = '';
                $row['Accept_for_IIC_Date'] = '';
                $row['IIC_Accept_Date'] = '';
                $row['IIC_Reject_Date'] = '';
                $row['EIC_Accept_Date'] = '';
                $row['EIC_Reject_Date'] = '';
                $row['Close_Date'] = '';
            }

            $rejectionDate = $this->getRejectionMail($get_id);
            if (count($rejectionDate) > 0) {
                $row['Rejection_Mail_Sent_Date'] = $rejectionDate[0]['sent_date'];
            } else {
                $row['Rejection_Mail_Sent_Date'] = '';
            }

            $pitch_language = isset($row['lang_code']) && $row['lang_code'] != '' ? $row['lang_code'] : 'en';
            if ($pitch_language == 'hi') {
                $row['Language'] = 'Hindi';
            } else {
                $row['Language'] = 'English';
            }

            if ($roleid == 4 && $independent_shortlist == 1) {

                $shortlist_comment = $this->getShortlistComments($get_id, $userid);

                $users_name = $this->getUsername($userid);
                if (count($shortlist_comment) > 0) {
                    if ($shortlist_comment[0]['application_status'] == 12) {
                        $app_status = 'Open';
                    } else if ($shortlist_comment[0]['application_status'] == 3) {
                        $app_status = 'Closed';
                    } else if ($shortlist_comment[0]['application_status'] == 2) {
                        $app_status = 'On Hold';
                    } else if ($shortlist_comment[0]['application_status'] == 25) {
                        $app_status = 'Shortlisted';
                    } else if ($shortlist_comment[0]['application_status'] == 26) {
                        $app_status = 'Selected';
                    } else {
                        $app_status = '--';
                    }
                    $app_comment = $shortlist_comment[0]['comments'];
                } else {
                    $app_status = '--';
                    $app_comment = '--';
                }

                $row['user name'] = $users_name[0]['emp_first_name'];
                $row['status'] = $app_status;
                $row['comments'] = $app_comment;
            }

            if ($row['Stage'] != '') {
                $row['Stage'] = $stage[$row['Stage']];
            }
            if ($row['Status'] != '') {
                $row['Status'] = $status[$row['Status']];
            }
            if ($row['Source_Type'] == '125') {
                $row['Source_Type'] = 'Pitch';
            } else {
                $source_type = $row['Source_Type'];
            }
            //if($row['Source'] == '' || $row['Source'] =="0")
            //     $row['Source'] = "Others";
            if ($row['Source'] == 'Website' || $row['Source'] == '123') {
                $row['Source'] = 'Website';
            } else if ($row['Source'] == 'Imported') {
                $row['Source'] = 'Imported';
            } else {
                $row['Source'] = "Added by" . " " . $row['Source'];
            }

            if (strpos($row['Phone_No'], '+') !== FALSE && strlen($row['Phone_No']) > 10)
                $row['Phone_No'] = substr($row['Phone_No'], -10);
            if (strlen($row['Mobile_No']) > 10)
                $row['Mobile_No'] = substr($row['Mobile_No'], -10);

            if ($row['Applied_to_Partners'] != '') {
                $other_partners = $row['Applied_to_Partners'];
                $partnersList = $get_partner_id = array();
                if ($other_partners != '') {
                    $explode_partners = explode(',', $other_partners);
                    for ($i = 0; $i < count($explode_partners); $i++) {
                        $individual_id = $explode_partners[$i];
                        $this->db->select('t1.partner_id');
                        $this->db->where("t2.id", $individual_id);
                        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
                        $query = $this->db->get('innovation_pool t1');
                        if ($query->num_rows() > 0) {
                            foreach ($query->result_array() as $partner_row) {
                                if ($partner_row['partner_id'] == '01') {
                                    $partner_nam = 'Villgro India';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($searchPartners == '02') {
                                    $partnersList = 'Villgro Kenya';
                                } else if ($searchPartners == '03') {
                                    $partnersList = 'Menterra';
                                } else if ($partner_row['partner_id'] == '04') {
                                    $partner_nam = 'Startup Oasis';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '05') {
                                    $partner_nam = 'IIMC';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '06') {
                                    $partner_nam = 'KIIT';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '07') {
                                    $partner_nam = 'SIIC';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '08') {
                                    $partner_nam = 'External Vendors';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '10') {
                                    $partner_nam = 'Powering Livelihoods';
                                    array_push($get_partner_id, $partner_nam);
                                }
                            }
                        }
                    }
                }
                $row['Applied_to_Partners'] = implode(',', array_unique($get_partner_id));
            }

            if ($row['Sector'] == 'MCH') {
                $sector = 'Maternal & child health';
            } else if ($row['Sector'] > 0) {
                $sector = $this->getNewSectorDetails($row['Sector']);
            } else if ($row['Sector'] == '' && $row['Program'] == 'Unc Pitch') {
                $sector = $this->getSectorName($row['pitch_id']);
            } else {
                $sector = $row['Sector'];
            }
            $row['Sector'] = $sector;

            foreach ($row as $key => $item) {
                if ($key != 'id' && $key != 'pitch_id')
                    $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $item) . $enclosure . $delim;
            }
            $out = rtrim($out);
            $out .= $newline;
        }

        return $out;
    }
 */
 
  function csv_from_result_deals($query, $roleid, $independent_shortlist, $userid, $delim = ",", $newline = "\n", $enclosure = '"') {
         // echo '<pre>';print_r($query->result_array());exit;
        //$stage = array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation',"6" => 'Exited Innovation');
        //$status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed',"4" => 'Draft');
        $stage = array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "6" => 'Exited Innovation', "Pre-Product" => "Pre-Product", "Pre-Revenue" => "Pre-Revenue", "Pre-Scale" => "Pre-Scale", "7" => 'Application', "8" => 'PA/RD', "9" => 'Detailed Diligence', "10" => 'Final Negotiations', "11" => 'Incubation', '12' => 'Portfolio');
        $status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed', "4" => 'Draft', "5" => 'Pending', "6" => 'Decision Pending', "7" => 'Lead', "8" => 'Incubation', "9" => 'Exited', "10" => 'Registered', "11" => 'Deleted', "12" => 'Open', "13" => 'Open - IIC Approved', "14" => 'Closed - IIC Rejected', "15" => 'User Accepted', "16" => 'User Rejected', "17" => 'EIC Approved', "18" => 'EIC Rejected', "19" => 'Re-Opened', "20" => 'Final Negotiation', "23" => 'Company Graduated', "24" => 'Open-Banked', "25" => 'Shortlisted', "26" => 'Selected');

        if (!is_object($query) OR ! method_exists($query, 'list_fields')) {
            show_error('You must submit a valid result object');
        }

        if ($roleid == 4 && $independent_shortlist == 1) {
            $log_title = array('PA/RD_Date', 'Accept_for_IIC_Date', 'IIC_Accept_Date', 'IIC_Reject_Date', 'EIC_Accept_Date', 'EIC_Reject_Date', 'Close_Date', 'Rejection_Mail_Sent_Date', 'Language', 'User Name', 'Status', 'Comments');
        } else {
            $log_title = array('PA/RD_Date', 'Accept_for_IIC_Date', 'IIC_Accept_Date', 'IIC_Reject_Date', 'EIC_Accept_Date', 'EIC_Reject_Date', 'Close_Date', 'Rejection_Mail_Sent_Date', 'Language');
        }
        $title = array_merge($query->list_fields(), $log_title);

        $out = '';

        // First generate the headings from the table column names
        foreach ($title as $name) {
            if ($name != 'id' && $name != 'pitch_id')
                $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $name) . $enclosure . $delim;
        }

        $out = rtrim($out);
        $out .= $newline;

        // Next blast through the result array and build out the rows
        foreach ($query->result_array() as $row) {
            $inv_id = explode('_', $row['Innovation_id']);
            $get_id = $inv_id[0];
            $logData = $this->getLogValue($get_id);
			
			
			 if($row['Program'] =='Tvaran' || $row['Program'] =='Empower' || $row['Program'] =='Working Capital Loans for Social Enterprise'){
				 $row['Sub_Sector'] =  $this->getSectorName($row['Sub_Sector']);
			 }
			 
            if (count($logData) > 0) {
                foreach ($logData as $log) {
                    if ($log['id'] != '') {
                        if ($log['stage'] == '8' && $log['status'] == '12' && $row['PA/RD_Date'] == '') {
                            $row['PA/RD_Date'] = $log['modified_date'];
                        } else if ($row['PA/RD_Date'] != '') {
                            $row['PA/RD_Date'] = $row['PA/RD_Date'];
                        } else {
                            $row['PA/RD_Date'] = '';
                        }

                        if ($log['stage'] == '8' && $log['status'] == '15' && $row['Accept_for_IIC_Date'] == '') {
                            $row['Accept_for_IIC_Date'] = $log['modified_date'];
                        } else if ($row['Accept_for_IIC_Date'] != '') {
                            $row['Accept_for_IIC_Date'] = $row['Accept_for_IIC_Date'];
                        } else {
                            $row['Accept_for_IIC_Date'] = '';
                        }

                        if ($log['stage'] == '9' && ($log['status'] == '12' || $log['status'] == '13') && $row['IIC_Accept_Date'] == '') {
                            $row['IIC_Accept_Date'] = $log['modified_date'];
                        } else if ($row['IIC_Accept_Date'] != '') {
                            $row['IIC_Accept_Date'] = $row['IIC_Accept_Date'];
                        } else {
                            $row['IIC_Accept_Date'] = '';
                        }

                        if ($log['stage'] == '8' && $log['status'] == '14' && $row['IIC_Reject_Date'] == '') {
                            $row['IIC_Reject_Date'] = $log['modified_date'];
                        } else if ($row['IIC_Reject_Date'] != '') {
                            $row['IIC_Reject_Date'] = $row['IIC_Reject_Date'];
                        } else {
                            $row['IIC_Reject_Date'] = '';
                        }

                        if ($log['stage'] == '9' && $log['status'] == '17' && $row['EIC_Accept_Date'] == '') {
                            $row['EIC_Accept_Date'] = $log['modified_date'];
                        } else if ($row['EIC_Accept_Date'] != '') {
                            $row['EIC_Accept_Date'] = $row['EIC_Accept_Date'];
                        } else {
                            $row['EIC_Accept_Date'] = '';
                        }

                        if ($log['stage'] == '9' && $log['status'] == '18' && $row['EIC_Reject_Date'] == '') {
                            $row['EIC_Reject_Date'] = $log['modified_date'];
                        } else if ($row['EIC_Reject_Date'] != '') {
                            $row['EIC_Reject_Date'] = $row['EIC_Reject_Date'];
                        } else {
                            $row['EIC_Reject_Date'] = '';
                        }

                        if ($log['status'] == '3' && $row['Close_Date'] == '' && $row['Status'] == '3') {
                            $row['Close_Date'] = $log['modified_date'];
                        } else if ($row['Close_Date'] != '' && $row['Status'] == '3') {
                            $row['Close_Date'] = $row['Close_Date'];
                        } else {
                            $row['Close_Date'] = '';
                        }
                    }
                }
            } else {
                $row['PA/RD_Date'] = '';
                $row['Accept_for_IIC_Date'] = '';
                $row['IIC_Accept_Date'] = '';
                $row['IIC_Reject_Date'] = '';
                $row['EIC_Accept_Date'] = '';
                $row['EIC_Reject_Date'] = '';
                $row['Close_Date'] = '';
            }

            $rejectionDate = $this->getRejectionMail($get_id);
            if (count($rejectionDate) > 0) {
                $row['Rejection_Mail_Sent_Date'] = $rejectionDate[0]['sent_date'];
            } else {
                $row['Rejection_Mail_Sent_Date'] = '';
            }

            $pitch_language = isset($row['lang_code']) && $row['lang_code'] != '' ? $row['lang_code'] : 'en';
            if ($pitch_language == 'hi') {
                $row['Language'] = 'Hindi';
            } else {
                $row['Language'] = 'English';
            }

            if ($roleid == 4 && $independent_shortlist == 1) {

                $shortlist_comment = $this->getShortlistComments($get_id, $userid);

                $users_name = $this->getUsername($userid);
                if (count($shortlist_comment) > 0) {
                    if ($shortlist_comment[0]['application_status'] == 12) {
                        $app_status = 'Open';
                    } else if ($shortlist_comment[0]['application_status'] == 3) {
                        $app_status = 'Closed';
                    } else if ($shortlist_comment[0]['application_status'] == 2) {
                        $app_status = 'On Hold';
                    } else if ($shortlist_comment[0]['application_status'] == 25) {
                        $app_status = 'Shortlisted';
                    } else if ($shortlist_comment[0]['application_status'] == 26) {
                        $app_status = 'Selected';
                    } else {
                        $app_status = '--';
                    }
                    $app_comment = $shortlist_comment[0]['comments'];
                } else {
                    $app_status = '--';
                    $app_comment = '--';
                }

                $row['user name'] = $users_name[0]['emp_first_name'];
                $row['status'] = $app_status;
                $row['comments'] = $app_comment;
            }

            if ($row['Stage'] != '') {
                $row['Stage'] = $stage[$row['Stage']];
            }
            if ($row['Status'] != '') {
                $row['Status'] = $status[$row['Status']];
            }
            if ($row['Source_Type'] == '125') {
                $row['Source_Type'] = 'Pitch';
            } else {
                $source_type = $row['Source_Type'];
            }
            //if($row['Source'] == '' || $row['Source'] =="0")
            //     $row['Source'] = "Others";
	
            if ($row['Source'] == 'Website' || $row['Source'] == '123') {
                $row['Source'] = 'Website';
            } else if ($row['Source'] == 'Imported') {
                $row['Source'] = 'Imported';
            } else {
                $row['Source'] = "Added by" . " " . $row['Source'];
            }
				
            if (strpos($row['Phone_No'], '+') !== FALSE && strlen($row['Phone_No']) > 10)
                $row['Phone_No'] = substr($row['Phone_No'], -10);
            if (strlen($row['Mobile_No']) > 10)
                $row['Mobile_No'] = substr($row['Mobile_No'], -10);

            if ($row['Applied_to_Partners'] != '') {
                $other_partners = $row['Applied_to_Partners'];
                $partnersList = $get_partner_id = array();
                if ($other_partners != '') {
                    $explode_partners = explode(',', $other_partners);
                    for ($i = 0; $i < count($explode_partners); $i++) {
                        $individual_id = $explode_partners[$i];
                        $this->db->select('t1.partner_id');
                        $this->db->where("t2.id", $individual_id);
                        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
                        $query = $this->db->get('innovation_pool t1');
                        if ($query->num_rows() > 0) {
                            foreach ($query->result_array() as $partner_row) {
                                if ($partner_row['partner_id'] == '01') {
                                    $partner_nam = 'Villgro India';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($searchPartners == '02') {
                                    $partnersList = 'Villgro Kenya';
                                } else if ($searchPartners == '03') {
                                    $partnersList = 'Menterra';
                                } else if ($partner_row['partner_id'] == '04') {
                                    $partner_nam = 'Startup Oasis';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '05') {
                                    $partner_nam = 'IIMC';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '06') {
                                    $partner_nam = 'KIIT';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '07') {
                                    $partner_nam = 'SIIC';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '08') {
                                    $partner_nam = 'External Vendors';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '10') {
                                    $partner_nam = 'Powering Livelihoods';
                                    array_push($get_partner_id, $partner_nam);
                                }
                            }
                        }
                    }
                }
                $row['Applied_to_Partners'] = implode(',', array_unique($get_partner_id));
            }
			#echo $row['Program'];die;
            if ($row['Sector'] == 'MCH') {
                $sector = 'Maternal & child health';
            } else if ($row['Sector'] > 0) {
                $sector = $this->getNewSectorDetails($row['Sector']);
            } else if ($row['Sector'] == '' && $row['Program'] == 'Unc Pitch') {
                $sector = $this->getSectorName($row['pitch_id']);
            } else {
                $sector = $row['Sector'];
            }
            $row['Sector'] = $sector;

            foreach ($row as $key => $item) {
                if ($key != 'id' && $key != 'pitch_id')
                    $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $item) . $enclosure . $delim;
            }
            $out = rtrim($out);
            $out .= $newline;
        }

        return $out;
    }

  
  
  
    function csv_from_result_deals_export($query, $prgm_type, $roleid, $independent_shortlist, $userid, $delim = ",", $newline = "\n", $enclosure = '"') {
        //$stage = array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation',"6" => 'Exited Innovation');
        //$status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed',"4" => 'Draft');
        $stage = array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "6" => 'Exited Innovation', "Pre-Product" => "Pre-Product", "Pre-Revenue" => "Pre-Revenue", "Pre-Scale" => "Pre-Scale", "7" => 'Application', "8" => 'PA/RD', "9" => 'Detailed Diligence', "10" => 'Final Negotiations', "11" => 'Incubation', '12' => 'Portfolio');
        $status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed', "4" => 'Draft', "5" => 'Pending', "6" => 'Decision Pending', "7" => 'Lead', "8" => 'Incubation', "9" => 'Exited', "10" => 'Registered', "11" => 'Deleted', "12" => 'Open', "13" => 'Open - IIC Approved', "14" => 'Closed - IIC Rejected', "15" => 'User Accepted', "16" => 'User Rejected', "17" => 'EIC Approved', "18" => 'EIC Rejected', "19" => 'Re-Opened', "20" => 'Final Negotiation', "23" => 'Company Graduated', "24" => 'Open-Banked', "25" => 'Shortlisted', "26" => 'Selected');

        if (!is_object($query) OR ! method_exists($query, 'list_fields')) {
            show_error('You must submit a valid result object');
        }

        $out = '';

        // First generate the headings from the table column names
        $get_fields = $query->list_fields();
        if ($prgm_type == 'Water Lab'  || $prgm_type == 'Incubation'  || $prgm_type == 'Climate Tech Incubator: Fueling Innovation for a Greener Tomorrow'  || $prgm_type == 'Rural Access to Impact Innovations (RAIIn)' || $prgm_type == 'Innovators for Bharat' || $prgm_type == 'SISFS' || $prgm_type == 'Sustainable Mobility Challenge' || $prgm_type == 'MAPHealth (Market Access Partners for Healthcare)' || $prgm_type == 'Powering Livelihoods II' || $prgm_type == 'EcoSakhi' || $prgm_type == 'MAPHealth (Market Access Partnership Healthcare)') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_occupation_1', 2 => 'Team_member_organisation_1', 3 => 'Team_member_email_1', 4 => 'Team_member_mobile_1', 5 => 'Team_member_name_2', 6 => 'Team_member_occupation_2', 7 => 'Team_member_organisation_2', 8 => 'Team_member_email_2', 9 => 'Team_member_mobile_2', 10 => 'Team_member_name_3', 11 => 'Team_Member_Occupation_3', 12 => 'Team_member_organisation_3', 13 => 'Team_member_email_3', 14 => 'Team_member_mobile_3', 15 => 'Team_member_name_4', 16 => 'Team_Member_Occupation_4', 17 => 'Team_member_organisation_4', 18 => 'Team_member_email_4', 19 => 'Team_member_mobile_4');
        } else if ($prgm_type == 'Nidhi') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_occupation_1', 2 => 'Team_member_organisation_1', 3 => 'Team_member_email_1', 4 => 'Team_member_mobile_1', 5 => 'Team_member_gender_1', 6 => 'Team_member_name_2', 7 => 'Team_member_occupation_2', 8 => 'Team_member_organisation_2', 9 => 'Team_member_email_2', 10 => 'Team_member_mobile_2', 11 => 'Team_member_gender_2', 12 => 'Team_member_name_3', 13 => 'Team_Member_Occupation_3', 14 => 'Team_member_organisation_3', 15 => 'Team_member_email_3', 16 => 'Team_member_mobile_3', 17 => 'Team_member_gender_3', 18 => 'Team_member_name_4', 19 => 'Team_Member_Occupation_4', 20 => 'Team_member_organisation_4', 21 => 'Team_member_email_4', 22 => 'Team_member_mobile_4', 23 => 'Team_member_gender_4',);
        } else if ($prgm_type == 'Unc Pitch') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_title_1', 2 => 'Team_member_email_1', 3 => 'Team_member_age_1', 4 => 'Team_member_mobile_1', 5 => 'Team_member_gender_1', 6 => 'Team_member_edu_qualify_1', 7 => 'Team_member_linkedin_1', 8 => 'Team_member_name_2', 9 => 'Team_member_title_2', 10 => 'Team_member_email_2', 11 => 'Team_member_age_2', 12 => 'Team_member_mobile_2', 13 => 'Team_member_gender_2', 14 => 'Team_member_edu_qualify_2', 15 => 'Team_member_linkedin_2', 16 => 'Team_member_name_3', 17 => 'Team_member_title_3', 18 => 'Team_member_email_3', 19 => 'Team_member_age_3', 20 => 'Team_member_mobile_3', 21 => 'Team_member_gender_3', 22 => 'Team_member_edu_qualify_3', 23 => 'Team_member_linkedin_3');
        } else if ($prgm_type == 'FPAI - IC') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_title_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_linkedin_1', 5 => 'Team_member_name_2', 6 => 'Team_member_title_2', 7 => 'Team_member_email_2', 8 => 'Team_member_mobile_2', 9 => 'Team_member_linkedin_2', 10 => 'Team_member_name_3', 11 => 'Team_member_title_3', 12 => 'Team_member_email_3', 13 => 'Team_member_mobile_3', 14 => 'Team_member_linkedin_3');
        } else if ($prgm_type == 'Livelihoods' || $prgm_type == 'UBS Challenge') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_title_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_gender_1', 5 => 'Team_member_linkedin_1', 6 => 'Team_member_name_2', 7 => 'Team_member_title_2', 8 => 'Team_member_email_2', 9 => 'Team_member_mobile_2', 10 => 'Team_member_gender_2', 11 => 'Team_member_linkedin_2', 12 => 'Team_member_name_3', 13 => 'Team_member_title_3', 14 => 'Team_member_email_3', 15 => 'Team_member_mobile_3', 16 => 'Team_member_gender_3', 17 => 'Team_member_linkedin_3');
        } else if ($prgm_type == 'YSVF') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_title_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_designation_1', 5 => 'Team_member_age_1', 6 => 'Team_member_linkedin_1', 7 => 'Team_member_institution_1', 8 => 'Team_member_institution_type_1', 9 => 'Team_member_institution_link_1', 10 => 'Team_member_name_2', 11 => 'Team_member_title_2', 12 => 'Team_member_email_2', 13 => 'Team_member_mobile_2', 14 => 'Team_member_designation_2', 15 => 'Team_member_age_2', 16 => 'Team_member_linkedin_2', 17 => 'Team_member_institution_2', 18 => 'Team_member_institution_type_2', 19 => 'Team_member_institution_link_2', 20 => 'Team_member_name_3', 21 => 'Team_member_title_3', 22 => 'Team_member_email_3', 23 => 'Team_member_mobile_3', 24 => 'Team_member_designation_3', 25 => 'Team_member_age_3', 26 => 'Team_member_linkedin_3', 27 => 'Team_member_institution_3', 28 => 'Team_member_institution_type_3', 29 => 'Team_member_institution_link_3', 30 => 'Young_team_member_name', 31 => 'Young_team_member_title', 32 => 'Young_team_member_email', 33 => 'Young_team_member_mobile', 34 => 'Young_team_member_designation', 35 => 'Young_team_member_age', 36 => 'Young_team_member_linkedin');
        } else if ($prgm_type == 'Swachhata Startup Challenge' || $prgm_type == 'TANSEED' || $prgm_type == 'YASH Entrepreneurs') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_designation_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_gender_1', 5 => 'Team_member_linkedin_1', 6 => 'Team_member_name_2', 7 => 'Team_member_designation_2', 8 => 'Team_member_email_2', 9 => 'Team_member_mobile_2', 10 => 'Team_member_gender_2', 11 => 'Team_member_linkedin_2', 12 => 'Team_member_name_3', 13 => 'Team_member_designation_3', 14 => 'Team_member_email_3', 15 => 'Team_member_mobile_3', 16 => 'Team_member_gender_3', 17 => 'Team_member_linkedin_3');
        }else if ($prgm_type == 'Tvaran' || $prgm_type == 'Tvaran2.0') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_designation_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_gender_1', 5 => 'Team_member_linkedin_1', 6 => 'Team_member_name_2', 7 => 'Team_member_designation_2', 8 => 'Team_member_email_2', 9 => 'Team_member_mobile_2', 10 => 'Team_member_gender_2', 11 => 'Team_member_linkedin_2', 12 => 'Team_member_name_3', 13 => 'Team_member_designation_3', 14 => 'Team_member_email_3', 15 => 'Team_member_mobile_3', 16 => 'Team_member_gender_3', 17 => 'Team_member_linkedin_3');
        }else if ($prgm_type == 'Empower') {
            $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_designation_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_gender_1', 5 => 'Team_member_linkedin_1', 6 => 'Team_member_name_2', 7 => 'Team_member_designation_2', 8 => 'Team_member_email_2', 9 => 'Team_member_mobile_2', 10 => 'Team_member_gender_2', 11 => 'Team_member_linkedin_2', 12 => 'Team_member_name_3', 13 => 'Team_member_designation_3', 14 => 'Team_member_email_3', 15 => 'Team_member_mobile_3', 16 => 'Team_member_gender_3', 17 => 'Team_member_linkedin_3');
        }else if ($prgm_type == 'Working Capital Loans for Social Enterprise') {
		     $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_designation_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_gender_1', 5 => 'Team_member_linkedin_1', 6 => 'Team_member_name_2', 7 => 'Team_member_designation_2', 8 => 'Team_member_email_2', 9 => 'Team_member_mobile_2', 10 => 'Team_member_gender_2', 11 => 'Team_member_linkedin_2');
       }else if ($prgm_type == 'Shelter Tech' || $prgm_type == 'Enroute: A Mobility-as-a-Service Challenge') {
		     $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_designation_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_gender_1', 5 => 'Team_member_linkedin_1', 6 => 'Team_member_name_2', 7 => 'Team_member_designation_2', 8 => 'Team_member_email_2', 9 => 'Team_member_mobile_2', 10 => 'Team_member_gender_2', 11 => 'Team_member_linkedin_2');
       }else if ($prgm_type == 'Villgro Debt Access Program') {
		     $get_fields1 = array(0 => 'Team_member_name_1', 1 => 'Team_member_designation_1', 2 => 'Team_member_email_1', 3 => 'Team_member_mobile_1', 4 => 'Team_member_gender_1', 5 => 'Team_member_linkedin_1', 6 => 'Team_member_name_2', 7 => 'Team_member_designation_2', 8 => 'Team_member_email_2', 9 => 'Team_member_mobile_2', 10 => 'Team_member_gender_2', 11 => 'Team_member_linkedin_2');
       }else  if ($prgm_type == 'Tvaran3.0') {
		$get_fields1 = [
			'Team_member_name_1',
			'Team_member_occupation_1',
			'Team_member_organisation_1',
			'Team_member_email_1',
			'Team_member_mobile_1',
			'Team_member_gender_1',
			'Team_member_Linkedin_1',
			'Team_member_Upload_1',
			'Team_member_name_2',
			'Team_member_occupation_2',
			'Team_member_organisation_2',
			'Team_member_email_2',
			'Team_member_mobile_2',
			'Team_member_gender_2',
			'Team_member_Linkedin_2',
			'Team_member_Upload_2',
			'Team_member_name_3',
			'Team_member_occupation_3',
			'Team_member_organisation_3',
			'Team_member_email_3',
			'Team_member_mobile_3',
			'Team_member_gender_3',
			'Team_member_Linkedin_3',
			'Team_member_Upload_3',
			'Team_member_name_4',
			'Team_member_occupation_4',
			'Team_member_organisation_4',
			'Team_member_email_4',
			'Team_member_mobile_4',
			'Team_member_gender_4',
			'Team_member_Linkedin_4',
			'Team_member_Upload_4'
		];
 }
	  

        if ($roleid == 4 && $independent_shortlist == 1) {
            $log_title = array('User Name', 'Status', 'Comments');
            $get_fields1 = array_merge($get_fields1, $log_title);
        }
        $merge_values = array_merge($get_fields, $get_fields1);

        foreach ($merge_values as $name) {
            if ($name != 'created_by' && $name != 'id' && $name != 'pitch_id')
                $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $name) . $enclosure . $delim;
        }

        $out = rtrim($out);
        $out .= $newline;

        // Next blast through the result array and build out the rows
		
	
        foreach ($query->result_array() as $row) {
		
			if ($prgm_type == 'Empower' && date('Y-m-d', strtotime($row['created_date'])) >= date('2024-01-01')) {
				unset($row['What_was_the_motivation_for_you_to_start_your_business_or_why_is_this_enterprise_important_to_you']);
				unset($row['How_do_you_measure_the_qualitative_and_quantitative_impact_of_your_business']);
				$row['One_session_will_be_scheduled_every_week_starting_from_January_25th_to_February_28th_2024_from_4_to_5_30_pm'] = $row['One_session_will_be_scheduled_every_week_starting_from_November_30th_2023_to_January_11_2024_from_4_to_5'] ;
				unset($data['One_session_will_be_scheduled_every_week_starting_from_November_30th_2023_to_January_11_2024_from_4_to_5']);
			}
			
			
			$sectorNameStr = '';
			if( $prgm_type == 'Powering Livelihoods II'){
				if($row['Sector_for_your_enterprise'] =='Education & Employability'){
					$sectorNameStr =  'Agri and Agri-allied '; 
				}if($row['Sector_for_your_enterprise'] =='Agri-business'){
					$sectorNameStr = 'Dairy'; 
				}else if($row['Sector_for_your_enterprise'] =='Climate Action'){
					$sectorNameStr =  'Textile'; 
				}else if($row['Sector_for_your_enterprise'] =='Health'){
					$sectorNameStr =  'Crafts'; 
				}else if($row['Sector_for_your_enterprise'] =='Others'){
					$sectorNameStr = $row['Sector_for_your_enterprise']; 
				}							
				$row['Sector_for_your_enterprise'] = $sectorNameStr;
				$row['impact_of_your_productservice_include_below_mentioned']= implode(',',unserialize($row['impact_of_your_productservice_include_below_mentioned']));
			}

			
			
           if ($row['Stage'] != '') {
            $row['Stage'] = $stage[$row['Stage']];
        }
        if ($row['Status'] != '') {
            $row['Status'] = $status[$row['Status']];
        }

            // if($row['Source_Type'] == '125'){
            //  $row['Source_Type']  = 'Pitch';
            // }else{
            //  $source_type = $row['Source_Type'];
            // }
            //    $row['Who_will_be_the_beneficiaries_of_your_product'] = unserialize($row['Who_will_be_the_beneficiaries_of_your_product']);
            // $row['Who_will_be_the_beneficiaries_of_your_product'] = implode(',',$row['Who_will_be_the_beneficiaries_of_your_product']);
            // if($row['Program'] == 'Unc Pitch'){
            //              $row['Sector'] = $this->getSectorName($row['pitch_id']);
            //              //$row['Sector_Other'] = $this->getSectorOthers($row['pitch_id']);
            //          }

		if ($prgm_type == 'Tvaran' ||$prgm_type == 'Tvaran2.0' ||  $prgm_type == 'Tvaran3.0') { 
            $team_member = $this->getTeamMembers($row['id']);
			if (count($team_member) > 1) {
                $j = 1;
                foreach ($team_member as $key) {
                    $row['Team_member_name_' . $j] = $key['mem_name'];
                    $row['Team_Member_Desgination_' . $j] = $key['mem_occupation'];
					if($prgm_type == 'Tvaran3.0'){
						 $row['Team_member_organisation_' . $j] = $key['mem_org'];
						 $row['Team_member_email_' . $j] = $key['mem_email'];
					}
                    $row['Team_member_mobile_' . $j] = $key['mem_mobile'];
					$row['Team_member_gender_' . $j] = ucfirst($key['mem_gender']);
					$row['Team_member_Linkedine_' . $j] = $key['linkedin_profile'];
					if($prgm_type == 'Tvaran3.0'){
						 $row['Team_member_Upload_' . $j] = $key['mem_resume'];
					}
                    $j++;
                }
            }
			 $row['Beneficiaries_of_product_service'] = $this->getBeneficiary($row['id']);
			 
			  $states_lists ='';
			 if($row['States_plan_to_operate']!=''){
				 $states_lists = $this->getStateName($row['States_plan_to_operate']);
				 $row['States_plan_to_operate'] = $states_lists;
			 }
			 if($row['state']!=''){
				  $stateName = $this->getStateName($row['state']);
				  $row['state'] = $stateName;
			}  
			if (!empty($row['What_type_of_impact_will_your_product'])) {
				 $row['What_type_of_impact_will_your_product'] = implode(', ', unserialize($row['What_type_of_impact_will_your_product']));
			}
			if (!empty($row['Do_you_have_any_formal_engagement'])) {
				 $row['Do_you_have_any_formal_engagement'] = implode(', ', unserialize($row['Do_you_have_any_formal_engagement']));
			}
			 
			 
		}
		 #echo'<pre>';print_r($row['Do_you_have_any_formal_engagement']);die;
		
		//WaterLab
		if ($prgm_type == 'Water Lab'){
				if($row['Beneficiaries_of_product_service']!=''){
					$row['Beneficiaries_of_product_service'] = implode(', ', unserialize($row['Beneficiaries_of_product_service']));
				}
				if($row['How_will_you_define_the_primary_clients_of_your_innovation']!=''){
					$row['How_will_you_define_the_primary_clients_of_your_innovation'] = implode(', ', unserialize($row['How_will_you_define_the_primary_clients_of_your_innovation']));
				}
				if($row['Which_solutions_does_your_project_align_with']!=''){
					$row['Which_solutions_does_your_project_align_with'] = implode(', ', unserialize($row['Which_solutions_does_your_project_align_with']));
				}
				if($row['Which_stages_of_the_water_value_chain_does_your_enterprise_operate']!=''){
					$row['Which_stages_of_the_water_value_chain_does_your_enterprise_operate'] = implode(', ', unserialize($row['Which_stages_of_the_water_value_chain_does_your_enterprise_operate']));
				}
				if($row['Do_you_currently_have_any_formal_engagements']!=''){
					$row['Do_you_currently_have_any_formal_engagements'] = implode(', ', unserialize($row['Do_you_currently_have_any_formal_engagements']));
				}
				if($row['if_your_solution_is_currently_active_in_any_of_the_following']!=''){
					$row['if_your_solution_is_currently_active_in_any_of_the_following'] = implode(', ', unserialize($row['if_your_solution_is_currently_active_in_any_of_the_following']));
				}
				if($row['Which_solutions_does_your_project_align_with']!=''){
					$row['Which_solutions_does_your_project_align_with'] = implode(', ', unserialize($row['Which_solutions_does_your_project_align_with']));
				}
				#echo'<pre>';print_r($row);die;
		}
		

        if ($prgm_type == 'EcoSakhi' || $prgm_type == 'Incubation' || $prgm_type == 'Water Lab' || $prgm_type == 'Climate Tech Incubator: Fueling Innovation for a Greener Tomorrow' || $prgm_type == 'Innovators for Bharat'|| $prgm_type == 'Rural Access to Impact Innovations (RAIIn)' || $prgm_type == 'Sustainable Mobility Challenge' || $prgm_type == 'SISFS' || $prgm_type == 'Nidhi'  || $prgm_type == 'MAPHealth (Market Access Partnership Healthcare)' ) {
            		
			if ($row['States_plan_to_operate'] != '') {
                $row['States_plan_to_operate'] = $this->getStateName($row['States_plan_to_operate']);
            }
            $row['Beneficiaries_of_product_service'] = $this->getBeneficiary($row['id']);
            if($prgm_type == 'Nidhi'){
                $row['Country'] = $this->getCountryName($row['Country']);
                $row['Program'] = 'Nidhi';
            } else {
                $row['Program'] = $row['Program'];
            }
            $team_member = $this->getTeamMembers($row['id']);
			
			$setConCount = 1;
			if($prgm_type == 'Rural Access to Impact Innovations (RAIIn)'){
				$setConCount = 0;
			}
			
            if (count($team_member) > $setConCount) {
                $j = 1;
                foreach ($team_member as $key) {
                    $row['Team_member_name_' . $j] = $key['mem_name'];
                    $row['Team_Member_Occupation_' . $j] = $key['mem_occupation'];
					$row['Team_member_organisation_' . $j] = $key['mem_org'];
					
                    $row['Team_member_email_' . $j] = $key['mem_email'];
                    $row['Team_member_mobile_' . $j] = $key['mem_mobile'];
                    if($prgm_type == 'Nidhi'){
                        $row['Team_member_gender_' . $j] = ucfirst($key['mem_gender']);
                    }
					#echo'<pre>';print_r($row);die;
                    $j++;
                }
            }
            if ($row['link1'] != '') {
                $row['link1'] = site_url('export/incubation_export/1/' . $row['copy_id']);
            } else {
                $row['link1'] = '';
            }
            if ($row['link2'] != '') {
                $row['link2'] = site_url('export/incubation_export/2/' . $row['copy_id']);
            } else {
                $row['link2'] = '';
            }
        }
		
		
		
		if ($prgm_type == 'Working Capital Loans for Social Enterprise' ||$prgm_type == 'Shelter Tech' ||$prgm_type == 'Enroute: A Mobility-as-a-Service Challenge' || $prgm_type == 'Empower') {
            $team_member = $this->getTeamMembers($row['id']);
			
            if (count($team_member) > 0) {
                $j = 1;
                foreach ($team_member as $key) {
                    $row['Team_member_name_' . $j] = $key['mem_name'];
                    $row['Team_member_designation_' . $j] = $key['mem_occupation'];
					$row['Team_member_email_' . $j] = $key['mem_email'];
                    $row['Team_member_mobile_' . $j] = $key['mem_mobile'];
                    $row['Team_member_gender_' . $j] = $key['mem_gender'];
					$row['Team_member_linkedin_' . $j] = $key['linkedin_profile'];
                    $j++;
                }
            }
        }
		if ($prgm_type == 'Villgro Debt Access Program'){
			$team_member = $this->getTeamMembers($row['id']);
            if (count($team_member) > 0) {
                $j = 1;
                foreach ($team_member as $key) {
                    $row['Team_member_name_' . $j] = $key['mem_name'];
                    $row['Team_member_designation_' . $j] = $key['mem_occupation'];
                    $row['Team_member_organisation__' . $j] = $key['mem_org'];
					$row['Team_member_email_' . $j] = $key['mem_email'];
                    $row['Team_member_mobile_' . $j] = $key['mem_mobile'];
                    $row['Team_member_gender_' . $j] = $key['mem_gender'];
                    $j++;
                }
            }
		}
		
		

        if ($prgm_type == 'Unc Pitch') {
            $team_pitch_member = $this->getPitchMembers($row['pitch_id']);
            if (count($team_pitch_member) > 1) {
                $k = 1;
                foreach ($team_pitch_member as $key) {
                    $row['Team_member_name_' . $k] = $key['name'];
                    if ($key['other_title'] != '') {
                        $row['Team_member_title_' . $k] = $key['cur_title'] . ' - ' . $key['other_title'];
                    } else {
                        $row['Team_member_title_' . $k] = $key['cur_title'];
                    }
                    $row['Team_member_email_' . $k] = $key['email'];
                    $row['Team_member_age_' . $k] = $key['age'];
                    $row['Team_member_mobile_' . $k] = $key['phone'];
                    $row['Team_member_gender_' . $k] = ucfirst($key['gender']);
                    $row['Team_member_edu_qualify_' . $k] = $key['education_qualify'];
                    $row['Team_member_linkedin_' . $k] = $key['linkedin'];
                    $k++;
                }
            }

            if ($row['Attachment_1'] != '') {
                $row['Attachment_1'] = site_url('export/pitch_export/1/' . $row['copy_id']);
            } else {
                $row['Attachment_1'] = '';
            }
            if ($row['Attachment_2'] != '') {
                $row['Attachment_2'] = site_url('export/pitch_export/2/' . $row['copy_id']);
            } else {
                $row['Attachment_2'] = '';
            }
        }

        if ($prgm_type == 'FPAI - IC') {
            $row['Gender'] = ucfirst($row['Gender']);
            $row['Company_Register'] = ucfirst($row['Company_Register']);
            $row['Prize_Recognition'] = ucfirst($row['Prize_Recognition']);

            $ent_org = $apply_value = '';

            if ($row['Applying_Type'] == 'Profit') {
                $ent_org = 'For-profit Organization';
            } else if ($row['Applying_Type'] == 'Nonprofit') {
                $ent_org = 'Non-profit Organization';
            } else if ($row['Applying_Type'] == 'Notapplicable') {
                $ent_org = 'Applying as an individual';
            }
            $row['Applying_Type'] = $ent_org;

            if ($row['Applying_operation'] == '1') {
                $apply_value = 'Affordable, easy to use solutions for early diagnosis of pregnancy';
            } else if ($row['Applying_operation'] == '2') {
                $apply_value = 'Affordable and multi-parameter, ovulation monitoring and management solutions';
            } else if ($row['Applying_operation'] == '3') {
                $apply_value = 'Easy and non-invasive diagnosis of Polycystic Ovary Syndrome (PCOS) among young girls';
            } else if ($row['Applying_operation'] == '4') {
                $apply_value = 'Low cost, eco-friendly, easy to use solutions for dispensing and disposing of sanitary napkins';
            } else if ($row['Applying_operation'] == '5') {
                $apply_value = 'Technology-driven solutions for providing multilingual comprehensive sexual education to youth';
            } else if ($row['Applying_operation'] == '6') {
                $apply_value = 'Other';
            }
            $row['Applying_operation'] = $apply_value;

            $team_pitch_member = $this->getPitchMembers($row['pitch_id']);
            if (count($team_pitch_member) > 1) {
                $k = 1;
                foreach ($team_pitch_member as $key) {
                    $row['Team_member_name_' . $k] = $key['name'];
                    $row['Team_member_title_' . $k] = $key['cur_title'];
                    $row['Team_member_email_' . $k] = $key['email'];
                    $row['Team_member_mobile_' . $k] = $key['phone'];
                    $row['Team_member_linkedin_' . $k] = $key['linkedin'];
                    $k++;
                }
            }


            if ($row['Attachment_1'] != '') {
                $row['Attachment_1'] = site_url('export/pitch_export/1/' . $row['copy_id']);
            } else {
                $row['Attachment_1'] = '';
            }
            if ($row['Attachment_2'] != '') {
                $row['Attachment_2'] = site_url('export/pitch_export/2/' . $row['copy_id']);
            } else {
                $row['Attachment_2'] = '';
            }

        }

        if ($prgm_type == 'Livelihoods') {
            if ($row['Product_components'] != '') {
                $split_component = unserialize($row['Product_components']);
                $component_value = implode(', ', $split_component);
                $row['Product_components'] = $component_value;
            }
            if ($row['Product_beneficiary'] != '') {
                $row['Product_beneficiaryv'] = $beneficiary_value;
                $split_beneficiary = unserialize($row['beneficiary']);
                $beneficiary_value = implode(', ', $split_beneficiary);
                $row['Product_beneficiary'] = $beneficiary_value;
            }
            $team_pitch_member = $this->getPitchMembers($row['pitch_id']);
            if (count($team_pitch_member) > 1) {
                $k = 1;
                foreach ($team_pitch_member as $key) {
                    $row['Team_member_name_' . $k] = $key['name'];
                    $row['Team_member_title_' . $k] = $key['cur_title'];
                    $row['Team_member_email_' . $k] = $key['email'];
                    $row['Team_member_mobile_' . $k] = $key['phone'];
                    $row['Team_member_gender_' . $k] = ucfirst($key['gender']);
                    $row['Team_member_linkedin_' . $k] = $key['linkedin'];
                    $k++;
                }
            }

            if ($row['link1'] != '') {
                $row['link1'] = site_url('export/liveli_export/1/' . $row['copy_id']);
            } else {
                $row['link1'] = '';
            }
            if ($row['link2'] != '') {
                $row['link2'] = site_url('export/liveli_export/2/' . $row['copy_id']);
            } else {
                $row['link2'] = '';
            }
        }

        if ($prgm_type == 'UBS Challenge') {
            if ($row['How_did_you_hear_about_us'] != '') {
                $split_component = explode('*|*', $row['How_did_you_hear_about_us']);
                $component_value = implode(', ', $split_component);
                $row['How_did_you_hear_about_us'] = $component_value;
            }

            $team_pitch_member = $this->getPitchMembers($row['pitch_id']);
            if (count($team_pitch_member) > 1) {
                $k = 1;
                foreach ($team_pitch_member as $key) {
                    $row['Team_member_name_' . $k] = $key['name'];
                    $row['Team_member_title_' . $k] = $key['cur_title'];
                    $row['Team_member_email_' . $k] = $key['email'];
                    $row['Team_member_mobile_' . $k] = $key['phone'];
                    $row['Team_member_gender_' . $k] = ucfirst($key['gender']);
                    $row['Team_member_linkedin_' . $k] = $key['linkedin'];
                    $k++;
                }
            }

            if ($row['Attachment'] != '') {
                $row['Attachment'] = site_url('export/pitch_export/1/' . $row['copy_id']);
            } else {
                $row['Attachment'] = '';
            }
        }

        if ($prgm_type == 'YSVF') {
            $team_pitch_member = $this->getPitchMembers($row['pitch_id']);
            if (count($team_pitch_member) > 1) {
                $k = 1;
                foreach ($team_pitch_member as $key) {
                    $row['Team_member_name_' . $k] = $key['name'];
                    $row['Team_member_title_' . $k] = $key['cur_title'];
                    $row['Team_member_email_' . $k] = $key['email'];
                    $row['Team_member_mobile_' . $k] = $key['phone'];
                    $row['Team_member_designation_' . $k] = $key['cur_org'];
                    $row['Team_member_age_' . $k] = $key['age'];
                    $row['Team_member_linkedin_' . $k] = $key['linkedin'];
                    $row['Team_member_institution_' . $k] = $key['institute'];
                    $row['Team_member_institution_type_' . $k] = $key['institute_type'];
                    $row['Team_member_institution_link_' . $k] = $key['institute_link'];
                    $k++;
                }
            }

            if ($row['Attachment_1'] != '') {
                $row['Attachment_1'] = site_url('export/pitch_export/1/' . $row['copy_id']);
            } else {
                $row['Attachment_1'] = '';
            }
        }

        if ($prgm_type == 'Swachhata Startup Challenge') {
            $team_member = $this->getTeamMembers($row['id']);
            if (count($team_member) > 1) {
                $j = 1;
                foreach ($team_member as $key) {
                    $row['Team_member_name_' . $j] = $key['mem_name'];
                    $row['Team_Member_designation_' . $j] = $key['mem_occupation'];
                    $row['Team_member_email_' . $j] = $key['mem_email'];
                    $row['Team_member_mobile_' . $j] = $key['mem_mobile'];
                    $row['Team_member_gender_' . $j] = $key['mem_gender'];
                    $row['Team_member_linkedin_' . $j] = $key['linkedin_profile'];
                    $j++;
                }
            }
            if ($row['link1'] != '') {
                $row['link1'] = site_url('export/incubation_export/1/' . $row['copy_id']);
            } else {
                $row['link1'] = '';
            }
            if ($row['link2'] != '') {
                $row['link2'] = site_url('export/incubation_export/2/' . $row['copy_id']);
            } else {
                $row['link2'] = '';
            }
        }

        if ($prgm_type == 'TANSEED') {
            $team_member = $this->getTeamMembers($row['id']);
            if (count($team_member) > 1) {
                $j = 1;
                foreach ($team_member as $key) {
                    $row['Team_member_name_' . $j] = $key['mem_name'];
                    $row['Team_Member_designation_' . $j] = $key['mem_occupation'];
                    $row['Team_member_email_' . $j] = $key['mem_email'];
                    $row['Team_member_mobile_' . $j] = $key['mem_mobile'];
                    $row['Team_member_gender_' . $j] = $key['mem_gender'];
                    $row['Team_member_linkedin_' . $j] = $key['linkedin_profile'];
                    $j++;
                }
            }
            if ($row['link1'] != '') {
                $row['link1'] = site_url('export/incubation_export/1/' . $row['copy_id']);
            } else {
                $row['link1'] = '';
            }
            if ($row['link2'] != '') {
                $row['link2'] = site_url('export/incubation_export/2/' . $row['copy_id']);
            } else {
                $row['link2'] = '';
            }
            if ($row['link3'] != '') {
                $row['link3'] = site_url('export/incubation_export/3/' . $row['copy_id']);
            } else {
                $row['link3'] = '';
            }
        }

        if ($prgm_type == 'YASH Entrepreneurs') {
            $team_member = $this->getTeamMembers($row['id']);
            if (count($team_member) > 1) {
                $j = 1;
                foreach ($team_member as $key) {
                    $row['Team_member_name_' . $j] = $key['mem_name'];
                    $row['Team_Member_designation_' . $j] = $key['mem_occupation'];
                    $row['Team_member_email_' . $j] = $key['mem_email'];
                    $row['Team_member_mobile_' . $j] = $key['mem_mobile'];
                    $row['Team_member_gender_' . $j] = $key['mem_gender'];
                    $row['Team_member_linkedin_' . $j] = $key['linkedin_profile'];
                    $j++;
                }
            }
            if ($row['link1'] != '') {
                $row['link1'] = site_url('export/incubation_export/1/' . $row['copy_id']);
            } else {
                $row['link1'] = '';
            }
        }

        if ($roleid == 4 && $independent_shortlist == 1) {
            $shortlist_comment = $this->getShortlistComments($row['copy_id'], $userid);
            $users_name = $this->getUsername($userid);
            if (count($shortlist_comment) > 0) {
                if ($shortlist_comment[0]['application_status'] == 12) {
                    $app_status = 'Open';
                } else if ($shortlist_comment[0]['application_status'] == 3) {
                    $app_status = 'Closed';
                } else if ($shortlist_comment[0]['application_status'] == 2) {
                    $app_status = 'On Hold';
                } else if ($shortlist_comment[0]['application_status'] == 25) {
                    $app_status = 'Shortlisted';
                } else if ($shortlist_comment[0]['application_status'] == 26) {
                    $app_status = 'Selected';
                } else {
                    $app_status = '--';
                }
                $app_comment = $shortlist_comment[0]['comments'];
            } else {
                $app_status = '--';
                $app_comment = '--';
            }

            $row['user name'] = $users_name[0]['emp_first_name'];
            $row['status'] = $app_status;
            $row['comments'] = $app_comment;
        }
		#if($this->session->userdata('emp_number') == '135') {
			
		#}

        foreach ($row as $key => $item) {
            if ($key != 'created_by' && $key != 'id' && $key != 'pitch_id')
                $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $item) . $enclosure . $delim;
        }
        $out = rtrim($out);
        $out .= $newline;
    }
	#echo'<pre>';print_r($out);die;
    return $out;
}

    // --------------------------------------------------------------------

    /**
     * Generate XML data from a query result object
     *
     * @access  public
     * @param   object  The query result object
     * @param   array   Any preferences
     * @return  string
     */

    public function getCountryName($id) {
        $this->db->select("country_name");
        $this->db->where('id', $id);
        $query = $this->db->get('seed_countries');
        $data = $query->result_array();
        $row = $data[0]['country_name'];
        return $row;
    }

    public function getStateName($val) {
        $cond = "id IN($val)";
        $this->db->select("state_name");
        $this->db->where($cond);
        $query = $this->db->get('eir_state');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['state_name'];
            }
        }
        $state_name = implode(', ', $data);
        return $state_name;
    }

    public function getBeneficiary($id) {
        $this->db->select("benificiary");
        $this->db->where('id', $id);
        $query = $this->db->get('inv_user');
        $getResult = $query->result_array();
        $data = array();
        foreach ($getResult as $ben) {
            $data = unserialize($ben['benificiary']);
        }
        $benificiary = implode(', ', $data);
        return $benificiary;
    }

    public function getTeamMembers($inv_id) {
        $cond = "inv_user_id IN($inv_id)";
        $this->db->select(array("mem_name", "mem_occupation", "mem_org", "mem_email", "mem_mobile", "mem_gender", "linkedin_profile", "mem_resume"));
        $this->db->where($cond);
        $query = $this->db->get('inv_member');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getPitchMembers($pitch_id) {
        $cond = "pitch_id IN($pitch_id)";
        $this->db->select(array("name", "cur_title", "other_title", "email", "age", "phone", "gender", "education_qualify", "linkedin"));
        $this->db->where($cond);
        $query = $this->db->get('pitch_step1_members');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getSectorName($pitch_id) {

        $this->db->select("sector");
        $this->db->where('pitch_id', $pitch_id);
        $query = $this->db->get('pitch_step2');
        $data = $query->result_array();
        $sector = unserialize($data[0]['sector']);
        $row = ucfirst($sector[0]);

        return $row;
    }

    function getStageName($pitch_id) {

        $this->db->select("stage");
        $this->db->where('pitch_id', $pitch_id);
        $query = $this->db->get('pitch_step2');
        $data = $query->result_array();
        $sector = unserialize($data[0]['stage']);
        $row = ucfirst($sector[0]);

        return $row;
    }

    public function getLogValue($inv_id) {
        $cond = "innovation_id = $inv_id";
        $this->db->select(array("id", "stage", "status", "DATE_FORMAT(MAX(modified_date), '%d-%b-%Y') as modified_date"));
        if ($inv_id != '')
            $this->db->where($cond);
        $this->db->group_by(array("stage", "status"));
        $query = $this->db->get('application_status_log');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getRejectionMail($inv_id) {
        $cond = "innovation = $inv_id and mail_type = 'Rejection'";
        $this->db->select(array("id", "DATE_FORMAT(sent_date, '%d-%b-%Y') as sent_date"));
        if ($inv_id != '')
            $this->db->where($cond);
        $this->db->group_by(array("innovation", "mail_type"));
        $query = $this->db->get('innovation_mail_history');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getNewSectorDetails($id) {

        $this->db->select("sector");
        $this->db->where('id', $id);
        $query = $this->db->get('sector_category');
        $data = $query->result_array();
        // $sector = unserialize($data[0]['sector']);
        $row = ucfirst($data[0]['sector']);
        return $row;
    }

    function getUsername($id) {
        $this->db->select("emp_first_name");
        $this->db->where('id', $id);
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    function getShortlistComments($invid = '', $userid = '') {
        if ($invid != "") {
            $this->db->where('inv_id', $invid);
        }
        if ($userid != '') {
            $this->db->where('created_by', $userid);
        }
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('shortlist_comments');
        return $result->result_array();
    }

    function xml_from_result($query, $params = array()) {
        if (!is_object($query) OR ! method_exists($query, 'list_fields')) {
            show_error('You must submit a valid result object');
        }

        // Set our default values
        foreach (array('root' => 'root', 'element' => 'element', 'newline' => "\n", 'tab' => "\t") as $key => $val) {
            if (!isset($params[$key])) {
                $params[$key] = $val;
            }
        }

        // Create variables for convenience
        extract($params);

        // Load the xml helper
        $CI = & get_instance();
        $CI->load->helper('xml');

        // Generate the result
        $xml = "<{$root}>" . $newline;
        foreach ($query->result_array() as $row) {
            $xml .= $tab . "<{$element}>" . $newline;

            foreach ($row as $key => $val) {
                $xml .= $tab . $tab . "<{$key}>" . xml_convert($val) . "</{$key}>" . $newline;
            }
            $xml .= $tab . "</{$element}>" . $newline;
        }
        $xml .= "</$root>" . $newline;

        return $xml;
    }

    // --------------------------------------------------------------------

    /**
     * Database Backup
     *
     * @access  public
     * @return  void
     */
    function backup($params = array()) {
        // If the parameters have not been submitted as an
        // array then we know that it is simply the table
        // name, which is a valid short cut.
        if (is_string($params)) {
            $params = array('tables' => $params);
        }

        // ------------------------------------------------------
        // Set up our default preferences
        $prefs = array(
            'tables' => array(),
            'ignore' => array(),
            'filename' => '',
            'format' => 'gzip', // gzip, zip, txt
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        );

        // Did the user submit any preferences? If so set them....
        if (count($params) > 0) {
            foreach ($prefs as $key => $val) {
                if (isset($params[$key])) {
                    $prefs[$key] = $params[$key];
                }
            }
        }

        // ------------------------------------------------------
        // Are we backing up a complete database or individual tables?
        // If no table names were submitted we'll fetch the entire table list
        if (count($prefs['tables']) == 0) {
            $prefs['tables'] = $this->db->list_tables();
        }

        // ------------------------------------------------------
        // Validate the format
        if (!in_array($prefs['format'], array('gzip', 'zip', 'txt'), TRUE)) {
            $prefs['format'] = 'txt';
        }

        // ------------------------------------------------------
        // Is the encoder supported?  If not, we'll either issue an
        // error or use plain text depending on the debug settings
        if (($prefs['format'] == 'gzip' AND ! @function_exists('gzencode'))
            OR ( $prefs['format'] == 'zip' AND ! @function_exists('gzcompress'))) {
            if ($this->db->db_debug) {
                return $this->db->display_error('db_unsuported_compression');
            }

            $prefs['format'] = 'txt';
        }

        // ------------------------------------------------------
        // Set the filename if not provided - Only needed with Zip files
        if ($prefs['filename'] == '' AND $prefs['format'] == 'zip') {
            $prefs['filename'] = (count($prefs['tables']) == 1) ? $prefs['tables'] : $this->db->database;
            $prefs['filename'] .= '_' . date('Y-m-d_H-i', time());
        }

        // ------------------------------------------------------
        // Was a Gzip file requested?
        if ($prefs['format'] == 'gzip') {
            return gzencode($this->_backup($prefs));
        }

        // ------------------------------------------------------
        // Was a text file requested?
        if ($prefs['format'] == 'txt') {
            return $this->_backup($prefs);
        }

        // ------------------------------------------------------
        // Was a Zip file requested?
        if ($prefs['format'] == 'zip') {
            // If they included the .zip file extension we'll remove it
            if (preg_match("|.+?\.zip$|", $prefs['filename'])) {
                $prefs['filename'] = str_replace('.zip', '', $prefs['filename']);
            }

            // Tack on the ".sql" file extension if needed
            if (!preg_match("|.+?\.sql$|", $prefs['filename'])) {
                $prefs['filename'] .= '.sql';
            }

            // Load the Zip class and output it

            $CI = & get_instance();
            $CI->load->library('zip');
            $CI->zip->add_data($prefs['filename'], $this->_backup($prefs));
            return $CI->zip->get_zip();
        }
    }

}

/* End of file DB_utility.php */
/* Location: ./system/database/DB_utility.php */
