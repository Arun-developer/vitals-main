<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Database Utility Class
 *
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_utility extends CI_DB_forge {

	var $db;
	var $data_cache		= array();

	/**
	 * Constructor
	 *
	 * Grabs the CI super object instance so we can access it.
	 *
	 */
	function CI_DB_utility()
	{
		// Assign the main database object to $this->db
		$CI =& get_instance();
		$this->db =& $CI->db;

		log_message('debug', "Database Utility Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * List databases
	 *
	 * @access	public
	 * @return	bool
	 */
	function list_databases()
	{
		// Is there a cached result?
		if (isset($this->data_cache['db_names']))
		{
			return $this->data_cache['db_names'];
		}

		$query = $this->db->query($this->_list_databases());
		$dbs = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
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
	 * @access	public
	 * @param	string
	 * @return	boolean
	 */
	function database_exists($database_name)
	{
		// Some databases won't have access to the list_databases() function, so
		// this is intended to allow them to override with their own functions as
		// defined in $driver_utility.php
		if (method_exists($this, '_database_exists'))
		{
			return $this->_database_exists($database_name);
		}
		else
		{
			return ( ! in_array($database_name, $this->list_databases())) ? FALSE : TRUE;
		}
	}


	// --------------------------------------------------------------------

	/**
	 * Optimize Table
	 *
	 * @access	public
	 * @param	string	the table name
	 * @return	bool
	 */
	function optimize_table($table_name)
	{
		$sql = $this->_optimize_table($table_name);

		if (is_bool($sql))
		{
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
	 * @access	public
	 * @return	array
	 */
	function optimize_database()
	{
		$result = array();
		foreach ($this->db->list_tables() as $table_name)
		{
			$sql = $this->_optimize_table($table_name);

			if (is_bool($sql))
			{
				return $sql;
			}

			$query = $this->db->query($sql);

			// Build the result array...
			// Note: Due to a bug in current() that affects some versions
			// of PHP we can not pass function call directly into it
			$res = $query->result_array();
			$res = current($res);
			$key = str_replace($this->db->database.'.', '', current($res));
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
	 * @access	public
	 * @param	string	the table name
	 * @return	bool
	 */
	function repair_table($table_name)
	{
		$sql = $this->_repair_table($table_name);

		if (is_bool($sql))
		{
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
	 * @access	public
	 * @param	object	The query result object
	 * @param	string	The delimiter - comma by default
	 * @param	string	The newline character - \n by default
	 * @param	string	The enclosure - double quote by default
	 * @return	string
	 */
	function csv_from_result($query, $delim = ",", $newline = "\n", $enclosure = '"')
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('You must submit a valid result object');
		}

		$out = '';

		// First generate the headings from the table column names
		foreach ($query->list_fields() as $name)
		{
			$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $name).$enclosure.$delim;
		}

		$out = rtrim($out);
		$out .= $newline;

		// Next blast through the result array and build out the rows
		foreach ($query->result_array() as $row)
		{
			foreach ($row as $item)
			{
				$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item).$enclosure.$delim;
			}
			$out = rtrim($out);
			$out .= $newline;
		}

		return $out;
	}

        function csv_from_result_deals($query, $delim = ",", $newline = "\n", $enclosure = '"')
	{
		//$stage = array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation',"6" => 'Exited Innovation');
		//$status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed',"4" => 'Draft');
                $stage = array("0" => '', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation',"6" => 'Exited Innovation',"Pre-Product" => "Pre-Product","Pre-Revenue" => "Pre-Revenue","Pre-Scale" =>"Pre-Scale");
		$status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed',"4"=> 'Draft', "5" => 'Pending', "6" => 'Decision Pending', "7" => 'Lead' , "8" => 'Incubation',"9"=>'Exited',"10"=>'Registered',"11"=>'Deleted');

		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('You must submit a valid result object');
		}

		$out = '';

		// First generate the headings from the table column names
		foreach ($query->list_fields() as $name)
		{

			if($name != 'created_by')
			$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $name).$enclosure.$delim;
		}

		$out = rtrim($out);
		$out .= $newline;

		// Next blast through the result array and build out the rows
		foreach ($query->result_array() as $row)
		{
			//echo "<pre>";print_r($row);exit;
			
		//	$row['stage'] = $stage[$row['stage']];
			$row['status'] = $status[$row['status']];
			if($row['Source_Type'] == '125'){
				$row['Source_Type']  = 'Pitch';
			}else{
				$source_type = $row['Source_Type'];
			}
                        //if($row['Source'] == '' || $row['Source'] =="0")
            	          //     $row['Source'] = "Others";
		        if($row['Source'] == 'Website' || $row['Source'] == '123'){
                        $row['Source'] 	= 'Website';
                        }else if($row['Source'] == 'Imported'){
                        	$row['Source'] = 'Imported';
                        }else {
                        	 $row['Source'] = "Added by". " ".$row['Source'];
                        }	
                        if($row['program'] == 'Unc Pitch'){
                        	//echo "ee";exit;
                        	$row['Sector'] = $this->getSectorName($row['pitch_id']);
                        	//$row['Sector_Other'] = $this->getSectorOthers($row['pitch_id']);
                        } 
                        if($row['program'] == 'Unc Pitch'){
                        	//echo "ee";exit;

                        	$row['Enterprise_Stage'] = $this->getStageName($row['pitch_id']);
                        	//$row['Sector_Other'] = $this->getSectorOthers($row['pitch_id']);
                        }		
                        if($row['created_by'] == "0" || $row['created_by'] == '' )
                               $row['Created_By'] = "Administrator";
                        if(strpos($row['Phone_No'],'+') !== FALSE && strlen($row['Phone_No']) > 10)
				$row['Phone_No'] = substr($row['Phone_No'],-10);	
			if(strlen($row['Mobile_No']) > 10)
				$row['Mobile_No'] = substr($row['Mobile_No'],-10);

			if ($row['Other_Partners'] != '') {
                $other_partners = $row['Other_Partners'];
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
                                }
                            }
                        }
                    }
                }
                $row['Other_Partners'] = implode(',', $get_partner_id);
            }
			
			foreach ($row as $key=>$item)
			{
			    if($key != 'created_by')
				$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item).$enclosure.$delim;
			}
			$out = rtrim($out);
			$out .= $newline;
			
		}

		return $out;
	}

    function csv_from_result_deals_export($query, $delim = ",", $newline = "\n", $enclosure = '"')
	{
		//print_r($query);exit;
		//$stage = array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation',"6" => 'Exited Innovation');
		//$status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed',"4" => 'Draft');
                $stage = array("0" => '', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "5" => 'Incubation',"6" => 'Exited Innovation',"Pre-Product" => "Pre-Product","Pre-Revenue" => "Pre-Revenue","Pre-Scale" =>"Pre-Scale");
		$status = array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed',"4"=> 'Draft', "5" => 'Pending', "6" => 'Desicion Pending', "7" => 'Lead' , "8" => 'Incubation',"9"=>'Exited',"10"=>'Registered',"11"=>'Deleted');

		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('You must submit a valid result object');
		}

		$out = '';

		// First generate the headings from the table column names
		foreach ($query->list_fields() as $name)
		{

			if($name != 'created_by')
			$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $name).$enclosure.$delim;
		}

		$out = rtrim($out);
		$out .= $newline;

		// Next blast through the result array and build out the rows
		foreach ($query->result_array() as $row)
		{
			//echo "<pre>";print_r($row);exit;
			$row['stage'] = $stage[$row['stage']];
			$row['status'] = $status[$row['status']];
			if($row['Source_Type'] == '125'){
				$row['Source_Type']  = 'Pitch';
			}else{
				$source_type = $row['Source_Type'];
			}
		     
		    $row['Who_will_be_the_beneficiaries_of_your_product'] = unserialize($row['Who_will_be_the_beneficiaries_of_your_product']);
			$row['Who_will_be_the_beneficiaries_of_your_product'] = implode(',',$row['Who_will_be_the_beneficiaries_of_your_product']); 
			if($row['Program'] == 'Unc Pitch'){
            	$row['Sector'] = $this->getSectorName($row['pitch_id']);
            	//$row['Sector_Other'] = $this->getSectorOthers($row['pitch_id']);
            } 
            if($row['Program'] == 'Unc Pitch'){

            	$row['Enterprise_Stage'] = $this->getStageName($row['pitch_id']);
            	//$row['Sector_Other'] = $this->getSectorOthers($row['pitch_id']);
            }
			foreach ($row as $key=>$item)
			{
			    if($key != 'created_by')
				$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item).$enclosure.$delim;
			}
			$out = rtrim($out);
			$out .= $newline;
			
		}
//print_r($out); exit;
		return $out;
	}
	// --------------------------------------------------------------------

	/**
	 * Generate XML data from a query result object
	 *
	 * @access	public
	 * @param	object	The query result object
	 * @param	array	Any preferences
	 * @return	string
	 */

	function getSectorName($pitch_id)
		{
		
			$this->db->select("sector");
			$this->db->where('pitch_id',$pitch_id);
			$query = $this->db->get('pitch_step2');
			$data = $query->result_array();
			$sector = unserialize($data[0]['sector']);
			$row = ucfirst($sector[0]);
			
			return $row;		
	}

	function getStageName($pitch_id)
		{
		
			$this->db->select("stage");
			$this->db->where('pitch_id',$pitch_id);
			$query = $this->db->get('pitch_step2');
			$data = $query->result_array();
			$sector = unserialize($data[0]['stage']);
			$row = ucfirst($sector[0]);
			
			return $row;		
	}
	function xml_from_result($query, $params = array())
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('You must submit a valid result object');
		}

		// Set our default values
		foreach (array('root' => 'root', 'element' => 'element', 'newline' => "\n", 'tab' => "\t") as $key => $val)
		{
			if ( ! isset($params[$key]))
			{
				$params[$key] = $val;
			}
		}

		// Create variables for convenience
		extract($params);

		// Load the xml helper
		$CI =& get_instance();
		$CI->load->helper('xml');

		// Generate the result
		$xml = "<{$root}>".$newline;
		foreach ($query->result_array() as $row)
		{
			$xml .= $tab."<{$element}>".$newline;

			foreach ($row as $key => $val)
			{
				$xml .= $tab.$tab."<{$key}>".xml_convert($val)."</{$key}>".$newline;
			}
			$xml .= $tab."</{$element}>".$newline;
		}
		$xml .= "</$root>".$newline;

		return $xml;
	}

	// --------------------------------------------------------------------

	/**
	 * Database Backup
	 *
	 * @access	public
	 * @return	void
	 */
	function backup($params = array())
	{
		// If the parameters have not been submitted as an
		// array then we know that it is simply the table
		// name, which is a valid short cut.
		if (is_string($params))
		{
			$params = array('tables' => $params);
		}

		// ------------------------------------------------------

		// Set up our default preferences
		$prefs = array(
							'tables'		=> array(),
							'ignore'		=> array(),
							'filename'		=> '',
							'format'		=> 'gzip', // gzip, zip, txt
							'add_drop'		=> TRUE,
							'add_insert'	=> TRUE,
							'newline'		=> "\n"
						);

		// Did the user submit any preferences? If so set them....
		if (count($params) > 0)
		{
			foreach ($prefs as $key => $val)
			{
				if (isset($params[$key]))
				{
					$prefs[$key] = $params[$key];
				}
			}
		}

		// ------------------------------------------------------

		// Are we backing up a complete database or individual tables?
		// If no table names were submitted we'll fetch the entire table list
		if (count($prefs['tables']) == 0)
		{
			$prefs['tables'] = $this->db->list_tables();
		}

		// ------------------------------------------------------

		// Validate the format
		if ( ! in_array($prefs['format'], array('gzip', 'zip', 'txt'), TRUE))
		{
			$prefs['format'] = 'txt';
		}

		// ------------------------------------------------------

		// Is the encoder supported?  If not, we'll either issue an
		// error or use plain text depending on the debug settings
		if (($prefs['format'] == 'gzip' AND ! @function_exists('gzencode'))
		OR ($prefs['format'] == 'zip'  AND ! @function_exists('gzcompress')))
		{
			if ($this->db->db_debug)
			{
				return $this->db->display_error('db_unsuported_compression');
			}

			$prefs['format'] = 'txt';
		}

		// ------------------------------------------------------

		// Set the filename if not provided - Only needed with Zip files
		if ($prefs['filename'] == '' AND $prefs['format'] == 'zip')
		{
			$prefs['filename'] = (count($prefs['tables']) == 1) ? $prefs['tables'] : $this->db->database;
			$prefs['filename'] .= '_'.date('Y-m-d_H-i', time());
		}

		// ------------------------------------------------------

		// Was a Gzip file requested?
		if ($prefs['format'] == 'gzip')
		{
			return gzencode($this->_backup($prefs));
		}

		// ------------------------------------------------------

		// Was a text file requested?
		if ($prefs['format'] == 'txt')
		{
			return $this->_backup($prefs);
		}

		// ------------------------------------------------------

		// Was a Zip file requested?
		if ($prefs['format'] == 'zip')
		{
			// If they included the .zip file extension we'll remove it
			if (preg_match("|.+?\.zip$|", $prefs['filename']))
			{
				$prefs['filename'] = str_replace('.zip', '', $prefs['filename']);
			}

			// Tack on the ".sql" file extension if needed
			if ( ! preg_match("|.+?\.sql$|", $prefs['filename']))
			{
				$prefs['filename'] .= '.sql';
			}

			// Load the Zip class and output it

			$CI =& get_instance();
			$CI->load->library('zip');
			$CI->zip->add_data($prefs['filename'], $this->_backup($prefs));
			return $CI->zip->get_zip();
		}

	}

}


/* End of file DB_utility.php */
/* Location: ./system/database/DB_utility.php */
