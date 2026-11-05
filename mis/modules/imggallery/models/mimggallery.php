<?php
class Mimggallery extends CI_Model
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
}
