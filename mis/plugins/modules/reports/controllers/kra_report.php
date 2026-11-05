<?php
/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */
class Kra_report extends CI_Controller
{

    public function __constrcut()
    {
        parent::__construct();

        $this->load->helper('url');
    }

    public function view_report($innovation, $year = null, $month = null)
    {

        $this->load->model('mprogress_report');

        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');

        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);

        if (empty($month)) {
            $month = date('m');
        }

        if (empty($year)) {
            $year = date('Y');
        }

        $data['defaultmonth'] = $month;

        $data['innovation'] = $innovation;

        $data['defaultyear'] = $year;

        $data['kra_details'] = $this->mprogress_report->getkra_details($month, $year);

        $data['cpage'] = 'kra_report';

        $data['cpagetitle'] = 'KRA Report';

        $this->load->vars($data);

        $this->load->view('../template');
    }

    public function add_report()
    {

        if (isset($_POST['txtsubmit'])) {

            $this->load->model('mprogress_report');

            $month = date("F", mktime(0, 0, 0, $_POST['month'], 1, 2000));

            $_POST['date'] = $month . ' ' . $_POST['year'];

            $this->mprogress_report->addkra_details($_POST);

            $this->session->set_flashdata('successMsg', 'Details Added Successfully');

            redirect('reports/kra_report/view_report/' . $_POST['innovation'] . '/' . $_POST['year'] . '/' . $_POST['month'] . '');

        }
    }

    public function list_report($innovation = null, $year = null, $month = null)
    {

        $this->load->model('mprogress_report');

        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');

        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);

        if (empty($month)) {
            $month = date('m');
        }

        if (empty($year)) {
            $year = date('Y');
        }

        $data['defaultmonth'] = $month;

        $data['defaultyear'] = $year;

        $this->load->model('mprogress_report');

        $data['report_list'] = $this->mprogress_report->get_listreport($month, $year);

        $data['cpage'] = 'list_report';

        $data['cpagetitle'] = 'List Report';

        $this->load->view('../template', $data);

    }

    public function month_report($id)
    {

        $this->load->model('mprogress_report');

        $data['month_report'] = $this->mprogress_report->get_monthreport($id);

        $data['cpage'] = 'monthreport';

        $this->load->view('../template_iframe', $data);

    }

}
