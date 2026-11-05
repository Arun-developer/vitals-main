<?php
class Eventcalender extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['cpagetitle'] = "Event Calender";
        $data['cpage'] = "eventcalender_view";
        $this->load->view('../template_ajax', $data);
    }
}
