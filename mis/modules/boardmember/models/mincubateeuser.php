<?php 
	class Mincubateeuser extends CI_Model{
		function __construct()
		{
			parent::__construct();
		}
		function loginUser($username,$password)
		{
			$data = array();
		    $this->db->where('user_name',$username);
			$this->db->where('user_password',md5($password));
		
			$query = $this->db->get('incubatee');
		
			if($query->num_rows()>0)
			{
				foreach($query->result_array() as $row){
					$data[] = $row;					
				}
			}
			$query->free_result();
			
			return $data;
		}
	
		
	}
	?>