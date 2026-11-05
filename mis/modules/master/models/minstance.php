<?php 
#
# Model Class -  hs_quad_master_settings
#

	class Minstance extends CI_Model{
	
		function __construct()
		{
			parent::__construct();
		}
		function insert($options = array())
		{
		    $data = array( 	'source_id' => $options['source'],
							'instance_name 	' => $options['instance_name'],
							'date' => date2mysql($options['date']),
							'remarks' => $options['remarks'],
							'document' => $options['document'],
							'created_date' => date($this->config->item('mysqlDate')),
							'created_by' => $this->session->userdata('emp_number'));
			$result=$this->db->insert('instance_master',$data);
			return $result;
		}
		function update($options = array())
		{
			$data = array(  'source_id' => $options['source'],
							'instance_name 	' => $options['instance_name'],
							'date' => date2mysql($options['date']),
							'remarks' => $options['remarks'],
							'document' => $options['document'],
							'modified_date' => date($this->config->item('mysqlDate')),
							'modified_by' => $this->session->userdata('emp_number'));
			
			$this->db->where('id',$options['id']);
			$result=$this->db->update('instance_master',$data);
			return $result;
		}
		
		/**
		* Function : delete method is used for delete records by changing status to -1.
		* 
		* @param int $vendor_id
		*
		*/
		
		
		function delete($id)
		{
			$this->db->where('id',$id);
			$this->db->db_debug = FALSE;
			$result = $this->db->delete('instance_master');
			if(!$result)
			{
				$msg = $this->db->_error_message();
 			 	$num = $this->db->_error_number();
				return $num;
			}
			return '';
		}
		
		/**
		* Function : changeStatus method is used for Make active inactive.
		* $options - values
		* 	staus 
		*	vendor_id
		* 
		* @param array $options
		*
		*/
		
		function changeStatus($options = array())
		{
			$data = array( 'status' => $options['status']);
			$this->db->where('id',$options['id']);
			$this->db->update('instance_master',$data);
			return true;
		}
		
		/**
		* Function : getAllCount method is used for get count records from  vendors.
		* $options - values
		* 	orderby 
		*	ordertype
		*	vendorName
		*	contactPerson
		* 
		* @param array $options
		*
		*/
		function getAllCount($options = array())
		{
		    $data = array();
			$whereQuery = $this->_search($options);
			$this->db->select("count(*) as total");
			
			if($whereQuery != NULL)
				$query=$this->db->get_where('instance_master',$whereQuery);
			else
		 		$query=$this->db->get('instance_master');
			if($query->num_rows()>0)
			{
				foreach($query->result_array() as $row){
					$data[] = $row;					
				}
			}
			$query->free_result();
			return $data['0']['total'];			
		}
		
		/**
		* Function : getLimitRecords method is used for get Limit records from  vendors.
		* 
		* @param array $options
		*
		*/
		
		function getLimitRecords($options = array())
		{    
			$data = array();
			$whereQuery = $this->_search($options);
			if(isset($options['num'])&& isset($options['offset']))
				$this->db->limit($options['num'],$options['offset']);
				
			if(!empty($options['orderby'])&& !empty($options['ordertype']))
				$this->db->order_by($options['orderby'],$options['ordertype']);
			if(!empty($options['source']))
				$this->db->where('source_id',$options['source']);
			if(!empty($whereQuery))
				$query = $this->db->get_where('instance_master',$whereQuery);
			else
				$query = $this->db->get('instance_master');
			#echo debug_last_query();die;
			if($query->num_rows()>0)
			{
				foreach($query->result_array() as $row){
					$data[] = $row;					
				}
			}
			$query->free_result();
			return $data;				
		}
		
		/**
		* Function : _search method is used for generate Search query .
		* 
		* @param array $options
		*
		*/
		
		function _search($options = array())
		{
			$searchArray = array();
			$where = NULL;
			if(!empty($options['source_name']))
				$searchArray[] = "source_name like '%".$options['source_name']."%'";
			if(!empty($options['contact_person']))
				$searchArray[] = "contact_person like '%".$options['contact_person']."%'";
			if(!empty($options['source_type']))
				$searchArray[] = "source_type = '".$options['source_type']."'";
			if(count($searchArray))
				$where = implode(' and ',$searchArray);
			return $where; 
		}
		
		/**
		* Function : getVendorInfo method is used for get vendor details .
		* 
		* @param int $vendor_id
		*
		*/
		
		function getInstanceDetails($id)
		{
		    $data = array();
			$this->db->where("id",$id);
		 	$query=$this->db->get('instance_master');
			#echo debug_last_query();die;
			if($query->num_rows()>0)
			{
				foreach($query->result_array() as $row){
					$data[] = $row;					
				}
			}
			$query->free_result();
			return $data;			
		}
		function getInstanceCombo($source)
		{
			$data = array();
		 	$terms['source_id'] = $source;
			$this->db->select('id,instance_name');
			$query=$this->db->get_where('instance_master',$terms);
			if($query->num_rows()>0)
			{
				foreach($query->result_array() as $row){
					$data[] = $row;					
				}
			}
			return $data;
		}
		
		

	}
?>