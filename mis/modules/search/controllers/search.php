<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * Search Controller Page
 *
 * @ControllerName     search.php
 * @Author             Sanjoy Dey
 * @Created Date       9-02-2012
 * @Modified Date      9-02-2012
 * @Modified By        Sanjoy Dey
 * @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011
 * @version            CodeIgniter_2.0.3
 * @link               http://www.codeigniter.com
 * @since              File available since Release 2.0.3
 * @Warning            Any change in this file may cause abnormal behaviour of application.
 *
 */
class Search extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->Mauth->isLoggedCheck(); //Check user logged in or not

    }
    public function index()
    {
        $data['cpagetitle'] = "Search Anything";
        $data['cpage'] = "anywhere";
        $this->load->view('dashboard_template', $data);
    }

}
