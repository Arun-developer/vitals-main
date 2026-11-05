<?php
class Mstructure extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function getstructure()
    {
        $data = array();
        $query = "select HC.*,CONCAT(HE.emp_firstname ,HE.emp_lastname) as emp_name from " . $this->hris->database . ".hs_hr_compstructtree as HC LEFT OUTER JOIN hrisvill_orangehrm.hs_hr_employee as HE ON(HC.id = HE.work_station)";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

}
