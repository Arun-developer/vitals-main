<?php
class Mgallery extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function addvideo($options = array())
    {
        $data = array('name' => $options['name'],
            'url_link' => $options['urllink'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $result = $this->db->insert('video', $data);
        return $result;
    }
    public function videolist()
    {
        $query = "select * from video";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getAllCount($options = array())
    {
        $data = array();
        $this->db->select("count(*) as total");
        $query = $this->db->get('video');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }
}
