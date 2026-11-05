<?php

/* -
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
  modified - Animesh
 */

class Master_settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mmaster_settings');
        $this->load->model('Mmaster');
        $this->load->model('master/Sector_model');
        $this->load->model('portfolio/Mportfolio');
        $this->Mauth->isLoggedCheck();
        $this->items_perpage = '5';
    }

    public function index() {
        redirect('master/master_settings/view_list');
    }

    //start master settings
    public function view_list($currentTab = 'source_type') {
        if ($this->session->userdata('user_type') != 'superadmin' && $currentTab != 'reject_reasons' && $currentTab != 'portfolio_list') {
            redirect('master/master_settings/sector_details');
        } else {
            $options = array();
            $options = $_POST;
            $options['currentTab'] = $currentTab;
            $options['num'] = $this->items_perpage;
            $options['offset'] = $this->uri->segment(5);

            #Pagination Scripts Starts
            $config['base_url'] = site_url('master/master_settings/view_list/' . $currentTab);
            $config['total_rows'] = $this->Mmaster_settings->getAllCount($options);
            $config['per_page'] = $this->items_perpage;
            $config['num_links'] = 20;
            $config['uri_segment'] = "5";
            $this->pagination->initialize($config);
            #Pagination Scripts Ends

            $data['currentTab'] = $currentTab;
            $data['masterType'] = $this->config->item('masterType');
            $data['site_name'] = $this->config->item('site_name');

            $data['masterList'] = $this->Mmaster_settings->getLimitRecords($options);
            $data['ordertype'] = $this->input->post('ordertype');
            $data['orderby'] = $this->input->post('orderby');
            $data['cpagetitle'] = "Master Settings";
            $data['cpage'] = "master_settings/listMaster";

            $data['left_box'] = array('master');
            $data['custom_js'] = array('list_page');

            $this->load->vars($data);
            $this->load->view('../template');
        }
    }

    public function portfolio_list($currentTab = 'designation') {
        $title = $table = $cpage = '';

        if ($currentTab == 'designation') {
            $title = 'Designation';
            $table = 'port_team_designations';
            $cpage = 'designation_list';
        } else if ($currentTab == 'partnership_type') {
            $title = 'Non TAP';
            $table = 'port_ttm_partnership_master';
            $cpage = 'partnership_list';
        } else if ($currentTab == 'units') {
            $title = 'Units';
            $table = 'port_units';
            $cpage = 'unit_list';
        } else if ($currentTab == 'donor') {
            $title = 'Donor';
            $table = 'port_donor_masters';
            $cpage = 'donor_list';
        } else if ($currentTab == 'service') {
            $title = 'TAP Service';
            $table = 'port_service_providers';
            $cpage = 'service_provider_list';
        } else if ($currentTab == 'company_target') {
            $title = 'Sector Target';
            $table = 'port_dashboard_master';
            $cpage = 'company_target_list';
        }

        $partner_id = $this->session->userdata['partner_id'];
        $data['currentTab'] = $currentTab;
        $data['protoType'] = $this->config->item('protoType');
        $data['jobList'] = $this->Mmaster_settings->getPortfolioSettings($table, $partner_id);
        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');
        $data['cpagetitle'] = "Portfolio - $title settings";
        $data['cpage'] = "master_settings/$cpage";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function portfolio_status($currentTab = '', $master_id = '', $status = '') {
        $table = $name = '';
        if ($currentTab == 'designation') {
            $table = 'port_team_designations';
            $name = 'Designation';
        } else if ($currentTab == 'partnership_type') {
            $table = 'port_ttm_partnership_master';
            $name = 'Non TAP';
        } else if ($currentTab == 'units') {
            $table = 'port_units';
            $name = 'Units';
        } else if ($currentTab == 'donor') {
            $table = 'port_donor_masters';
            $name = 'Donor';
        } else if ($currentTab == 'service') {
            $table = 'port_service_providers';
            $name = 'TAP';
        } else if ($currentTab == 'company_target') {
            $table = 'port_dashboard_master';
            $name = 'Sector Target';
        }

        if ($master_id != '' && $status != '') {
            $options = array('id' => $master_id, 'status' => $status);
            $this->Mmaster_settings->portfolioStatus($options, $table);
            $this->session->set_flashdata('successMsg', "$name status updated successfuly");
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/portfolio_list/' . $currentTab);
    }

    public function portfolio_add($page = '') {
        $data['protoType'] = $masterType = $this->config->item('protoType');
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['master_type'] == 'Sector Target') {
                $result = $this->Mmaster_settings->portfolioInsertCompany($_POST);
            } else {
                $result = $this->Mmaster_settings->portfolioInsert($_POST);
            }
            if (!$result) {
                $data['errormsg'] = "Already exist!";
            }
            if ($result) {
                $this->session->set_flashdata('successMsg', 'Record inserted.!');
                redirect('master/master_settings/portfolio_list/' . array_search($this->input->post('master_type'), $masterType));
            }
        }

        $partner_id = $option['partner_id'] = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);

        $data['add_page'] = $page;
        $data['sector_details'] = $this->Sector_model->getPitchSectors();
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = "Add Portfolio Master";
        $data['cpage'] = "master_settings/add_portfolio_master";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }

    public function portfolio_edit($currentTab, $id) {
        $data['protoType'] = $masterType = $this->config->item('protoType');
        if (isset($_POST['txtSubmit'])) {
            $result = $this->Mmaster_settings->portfolioUpdate();
            if ($result) {
                $this->session->set_flashdata('successMsg', 'Record Updated !');
                redirect('master/master_settings/portfolio_list/' . array_search($this->input->post('master_type'), $masterType));
            }
        }

        if ($currentTab == 'designation') {
            $table = 'port_team_designations';
        } else if ($currentTab == 'partnership_type') {
            $table = 'port_ttm_partnership_master';
        } else if ($currentTab == 'units') {
            $table = 'port_units';
        } else if ($currentTab == 'donor') {
            $table = 'port_donor_masters';
        } else if ($currentTab == 'service') {
            $table = 'port_service_providers';
        } else if ($currentTab == 'company_target') {
            $table = 'port_dashboard_master';
        }

        #Loading View and data
        if ($id != '') {
            if ($currentTab == 'company_target') {
                $data['portfolio'] = $this->Mmaster_settings->portfolioEdit($id, $table);
                $data['sector_name'] = $data['portfolio'][0]['sector'];
                $data['fy_year'] = $data['portfolio'][0]['financial_year'];
                $data['app_q1'] = $data['portfolio'][0]['app_q1'];
                $data['app_q2'] = $data['portfolio'][0]['app_q2'];
                $data['app_q3'] = $data['portfolio'][0]['app_q3'];
                $data['app_q4'] = $data['portfolio'][0]['app_q4'];
                $data['app_annual'] = $data['portfolio'][0]['app_annual'];
                $data['pard_q1'] = $data['portfolio'][0]['pard_q1'];
                $data['pard_q2'] = $data['portfolio'][0]['pard_q2'];
                $data['pard_q3'] = $data['portfolio'][0]['pard_q3'];
                $data['pard_q4'] = $data['portfolio'][0]['pard_q4'];
                $data['pard_annual'] = $data['portfolio'][0]['pard_annual'];
                $data['iic_q1'] = $data['portfolio'][0]['iic_q1'];
                $data['iic_q2'] = $data['portfolio'][0]['iic_q2'];
                $data['iic_q3'] = $data['portfolio'][0]['iic_q3'];
                $data['iic_q4'] = $data['portfolio'][0]['iic_q4'];
                $data['iic_annual'] = $data['portfolio'][0]['iic_annual'];
                $data['eic_q1'] = $data['portfolio'][0]['eic_q1'];
                $data['eic_q2'] = $data['portfolio'][0]['eic_q2'];
                $data['eic_q3'] = $data['portfolio'][0]['eic_q3'];
                $data['eic_q4'] = $data['portfolio'][0]['eic_q4'];
                $data['eic_annual'] = $data['portfolio'][0]['eic_annual'];
                $data['inc_q1'] = $data['portfolio'][0]['inc_q1'];
                $data['inc_q2'] = $data['portfolio'][0]['inc_q2'];
                $data['inc_q3'] = $data['portfolio'][0]['inc_q3'];
                $data['inc_q4'] = $data['portfolio'][0]['inc_q4'];
                $data['inc_annual'] = $data['portfolio'][0]['inc_annual'];
                $data['tot_q1'] = $data['portfolio'][0]['tot_q1'];
                $data['tot_q2'] = $data['portfolio'][0]['tot_q2'];
                $data['tot_q3'] = $data['portfolio'][0]['tot_q3'];
                $data['tot_q4'] = $data['portfolio'][0]['tot_q4'];
                $data['tot_annual'] = $data['portfolio'][0]['tot_annual'];
                $data['new_q1'] = $data['portfolio'][0]['new_q1'];
                $data['new_q2'] = $data['portfolio'][0]['new_q2'];
                $data['new_q3'] = $data['portfolio'][0]['new_q3'];
                $data['new_q4'] = $data['portfolio'][0]['new_q4'];
                $data['new_annual'] = $data['portfolio'][0]['new_annual'];
                $data['ext_q1'] = $data['portfolio'][0]['ext_q1'];
                $data['ext_q2'] = $data['portfolio'][0]['ext_q2'];
                $data['ext_q3'] = $data['portfolio'][0]['ext_q3'];
                $data['ext_q4'] = $data['portfolio'][0]['ext_q4'];
                $data['ext_annual'] = $data['portfolio'][0]['ext_annual'];
                $data['partner_branch'] = $data['portfolio'][0]['partner_id'];
            } else {
                $data['portfolio'] = $this->Mmaster_settings->portfolioEdit($id, $table);
                $data['master_portfolio'] = $data['portfolio'][0]['name'];
                $data['partner_branch'] = $data['portfolio'][0]['partner_id'];
            }
        }
        $data['currentTab'] = $data['add_page'] = $currentTab;
        $data['protoType'] = $this->config->item('protoType');
        $master = $data['masterDetails'][0]['master_type'];

        $partner_id = $option['partner_id'] = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);

        $data['sector_details'] = $this->Sector_model->getPitchSectors();

        $data['branch'] = $this->Mmaster->getBranch();
        $data['masterPage'] = array_search($master, $masterType);
        $data['cpagetitle'] = "Edit Portfolio Master";
        $data['cpage'] = "master_settings/add_portfolio_master";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }

    public function portfolio_delete($currentTab = '', $master_id = '') {

        if ($currentTab == 'designation') {
            $table = 'port_team_designations';
        } else if ($currentTab == 'partnership_type') {
            $table = 'port_ttm_partnership_master';
        } else if ($currentTab == 'units') {
            $table = 'port_units';
        } else if ($currentTab == 'donor') {
            $table = 'port_donor_masters';
        } else if ($currentTab == 'service') {
            $table = 'port_service_providers';
        } else if ($currentTab == 'company_target') {
            $table = 'port_dashboard_master';
        }

        if ($master_id != '') {
            $this->Mmaster_settings->portfolioDelete($master_id, $table);
            redirect('master/master_settings/portfolio_list/' . $currentTab);
        }
    }

    public function add() {
        $data['masterType'] = $masterType = $this->config->item('masterType');
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $result = $this->Mmaster_settings->insert($_POST);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record inserted !');
                    redirect('master/master_settings/view_list/' . array_search($this->input->post('master_type'), $masterType));
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['cpagetitle'] = "Add Master";
        $data['cpage'] = "master_settings/addMaster";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }

    public function edit($id) {
        $data['masterType'] = $masterType = $this->config->item('masterType');
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                //insert reportss
                $result = $this->Mmaster_settings->update($_POST);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record Updated !');
                    redirect('master/master_settings/view_list/' . array_search($this->input->post('master_type'), $masterType));
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }

        #Loading View and data
        $data['masterDetails'] = $this->Mmaster_settings->getMasterSettings($id);

        $master = $data['masterDetails'][0]['master_type'];

        $data['masterPage'] = array_search($master, $masterType);
        $data['cpagetitle'] = "Edit Master";
        $data['cpage'] = "master_settings/editMaster";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }

    public function delete($currentTab = '', $master_id = '') {
        if ($master_id != '') {
            $result = $this->Mmaster_settings->delete($master_id);
            if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Master deleted Successfully');
            }
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }
        redirect('master/master_settings/view_list/' . $currentTab);
    }

    public function changestatus($currentTab = '', $master_id = '', $status = '') {
        if ($master_id != '' && $status != '') {
            $options = array('id' => $master_id, 'status' => $status);
            $this->Mmaster_settings->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Master Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/view_list/' . $currentTab);
    }

    /**
     * Function : _validation method is used for validation before add, edit reports.
     *
     * Function called by:
     * ---------------
     * $this->add()
     * $this->edit()
     *
     * @param null
     */
    public function _validation() {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('master_type', 'Master Type', 'required');
        $this->form_validation->set_rules('master_name', 'Master Name', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

    public function donor_fit_list($search = null) {
        $where = '';
        $offset = 4;

        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];
        if ($search == 'search') {
            $offset = 5;
            if (empty($_POST['fit_name']) && (!empty($partner))) {
                $where = array('partner_id' => $partner);
            } else if (empty($partner) && !empty($_POST['fit_name'])) {
                $where = array('name' => $this->input->post('fit_name'));
            } else if (!empty($_POST['fit_name']) && !empty($partner)) {
                $where = array('name' => $this->input->post('fit_name'), 'partner_id' => $partner);
            }
        } else {
            $search = '';
        }

        $options['num'] = 10;
        $options['offset'] = $this->uri->segment($offset);

        $this->load->library('pagination');
        #Pagination Scripts Starts
        $config['base_url'] = site_url('master/master_settings/donor_fit_list/' . $search);
        $config['total_rows'] = count($this->Mmaster_settings->fetchDonorFit($where));
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = $offset;
        $this->pagination->initialize($config);
        #Pagination Scripts Ends
        $data['donors'] = $this->Mmaster_settings->fetchDonorFit($where, $options);
        $data['branch'] = $this->Mmaster->getBranch();

        $data['ordertype'] = $this->input->post('ordertype');
        $data['orderby'] = $this->input->post('orderby');

        $data['form_name'] = "searchform";
        $data['cpagetitle'] = "Donor Fit Settings";
        $data['cpage'] = "master_settings/donorfit_list";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function reject_reasons($search = null) {

        $where = '';
        $offset = 4;

        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];
        if ($search == 'search') {
            $offset = 5;
            // print_r($_POST['reason_name']);exit;
            if (empty($_POST['reason_name']) && (!empty($partner))) {
                $where = array('partner_id' => $partner);
            } else if (empty($partner) && !empty($_POST['reason_name'])) {
                $where = array('master_name' => $this->input->post('reason_name'));
            } else if (!empty($_POST['reason_name']) && !empty($partner)) {
                $where = array('master_name' => $this->input->post('reason_name'), 'partner_id' => $partner);
            }
        } else {
            $search = '';
        }

        $options = array();
        $options = $_POST;
        $options['currentTab'] = 'reject_reasons';
        $options['num'] = '10';
        $options['offset'] = $this->uri->segment($offset);

        $this->load->library('pagination');
        #Pagination Scripts Starts
        $config['base_url'] = site_url('master/master_settings/reject_reasons/' . $search);
        $config['total_rows'] = $this->Mmaster_settings->getAllCount($options);
        // print_r($config['total_rows'].' aaaa');exit;
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = $offset;
        $this->pagination->initialize($config);
        #Pagination Scripts Ends
        $data['reject_reasons'] = $this->Mmaster_settings->getLimitRecords($options, $where);
        $data['branch'] = $this->Mmaster->getBranch();

        $data['ordertype'] = $this->input->post('ordertype');
        $data['orderby'] = $this->input->post('orderby');

        $data['form_name'] = "searchform";
        $data['cpagetitle'] = "Reject Reasons Settings";
        $data['cpage'] = "master_settings/reject_reasons_list";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function reject_reasons_add() {
        if (isset($_POST['txtSubmit'])) {
            if ($this->session->userdata('user_type') == 'superadmin') {
                $this->form_validation->set_rules('branch', 'Partner', 'required');
            }
            $this->form_validation->set_rules('reject_name', 'Reject Name', 'required');
            if ($this->form_validation->run() != false) {
                $partner_id = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : ($this->session->userdata('partner_id'));
                $insert = array('master_name' => $_POST['reject_name'], 'status' => '1', 'partner_id' => $partner_id, 'master_type' => 'Reject Reasons');
                $result = $this->Mmaster_settings->insertRejectReasons($insert);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record inserted !');
                    redirect('master/master_settings/reject_reasons/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = "Add Reject Reasons";
        $data['cpage'] = "master_settings/add_reject_reasons";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function reject_reason_edit($id = null) {
        if ($id != null) {
            $data['reject_reason'] = $this->Mmaster_settings->getRejectReasons($id);
        }
        if (isset($_POST['txtSubmit'])) {
            if ($this->session->userdata('usertype') == 'superadmin') {
                $this->form_validation->set_rules('branch', 'Partner', 'required');
            }
            $this->form_validation->set_rules('reject_name', 'Reject Name', 'required');
            if ($this->form_validation->run() != false) {
                $partner_id = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : ($this->session->userdata('partner_id'));
                $update = array('master_name' => $_POST['reject_name'], 'partner_id' => $partner_id);
                $where = array('id' => $id);
                $result = $this->Mmaster_settings->updateRejectReason($update, $where);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record updated Successfully !');
                    redirect('master/master_settings/reject_reasons/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = ($id != null) ? "Edit Reject Reason" : "Add Reject Reason";
        $data['cpage'] = "master_settings/add_reject_reasons";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function preliminary_reason($search = null) {
        $where = '';
        $offset = 4;
        if ($search == 'search') {
            $offset = 5;
            $where = array('name' => $this->input->post('prelim_name'));
        } else {
            $search = '';
        }

        $options['num'] = 10;
        $options['offset'] = $this->uri->segment($offset);

        $this->load->library('pagination');
        #Pagination Scripts Starts
        $config['base_url'] = site_url('master/master_settings/preliminary_reason/' . $search);
        $config['total_rows'] = count($this->Mmaster_settings->fetchPreliminaryReasons($where));
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = $offset;
        $this->pagination->initialize($config);
        #Pagination Scripts Ends
        $data['reasons'] = $this->Mmaster_settings->fetchPreliminaryReasons($where, $options);

        foreach ($data['reasons'] as $key => $val) {
            $partner_data = $this->Mmaster_settings->getPartnerName($val['partner_id']);
            $data['reasons'][$key]['partner_name'] = $partner_data[0]['branch_name'];
        }
        $data['branch'] = $this->Mmaster->getBranch();

        $data['ordertype'] = $this->input->post('ordertype');
        $data['orderby'] = $this->input->post('orderby');

        $data['form_name'] = "searchform";
        $data['cpagetitle'] = "Preliminary Reason Settings";
        $data['cpage'] = "master_settings/preliminary_reason";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function getSectorIncharges() {
        $id = $this->input->post('id');
        $this->load->model('scouting/Mincharge');
        $data['inchargeList'] = $this->Mincharge->getSectors($id);
        echo json_encode($data['inchargeList']);
    }

    public function sector_details() {
        $branch_id = $this->session->userdata('partner_id');
        $data['sector_details'] = $this->Sector_model->getSectors();
        $this->load->model('master/Mmaster');
        $this->load->model('login/Muser');

        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
        $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

        $data['employee_lists'] = $this->Sector_model->getEmployeePartner($branch_id);
        $count = count($data['employee_lists']);
        $response = array();
        foreach ($data['sector_details'] as $key => $value) {

            foreach ($data['employee_lists'] as $k => $val) {

                if ($value['id'] == $val['sector_id']) {

                    $dd = $this->Sector_model->getEmployeeNameByID($val['associate_employee']);
                    $empmail = $this->Sector_model->getEmployeeMailByID($val['associate_employee']);

                    if (array_key_exists($value['id'], $response)) {
                        $response[$value['id']]['emp_name'] = $response[$value['id']]['emp_name'] . '<br/> ' . $dd['emp_name'];
                        $response[$value['id']]['emp_work_email'] = $response[$value['id']]['emp_work_email'] . '<br/> ' . $empmail['emp_work_email'];
                    } else {
                        $response[$value['id']]['emp_name'] = $dd['emp_name'];
                        $response[$value['id']]['emp_work_email'] = $empmail['emp_work_email'];
                    }
                }
                if (array_key_exists($value['id'], $response)) {
                    $data['sector_details'][$key]['emp_name'] = $response[$value['id']]['emp_name'];
                    $data['sector_details'][$key]['emp_work_email'] = $response[$value['id']]['emp_work_email'];
                }
            }
        }

        $data['cpage'] = "master_settings/sector_details";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function addSectorIncharge() {
        $data['partner_id'] = $this->session->userdata('partner_id');
        $data['sector_id'] = $_POST['sector_value'];
        $data['employee_number'] = $_POST['associate_employee'];
        $id = $this->Sector_model->addSectorIncharge($data);
        redirect('master/master_settings/sector_details/');
    }

    public function sector_leads() {
        $branch_id = $this->session->userdata('partner_id');
        $data['sector_details'] = $this->Sector_model->getSectors();

        $this->load->model('master/Mmaster');
        $this->load->model('login/Muser');

        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
        $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

        $data['employee_lists'] = $this->Sector_model->getEmployeePartner($branch_id, 'assign_sector_lead');
        $count = count($data['employee_lists']);
        $response = array();

        foreach ($data['sector_details'] as $key => $value) {

            foreach ($data['employee_lists'] as $k => $val) {

                if ($value['id'] == $val['sector_id']) {

                    $dd = $this->Sector_model->getEmployeeNameByID($val['employee_id']);
                    $empmail = $this->Sector_model->getEmployeeMailByID($val['employee_id']);

                    if (array_key_exists($value['id'], $response)) {
                        $response[$value['id']]['emp_name'] = $response[$value['id']]['emp_name'] . '<br/> ' . $dd['emp_name'];
                        $response[$value['id']]['emp_work_email'] = $response[$value['id']]['emp_work_email'] . '<br/> ' . $empmail['emp_work_email'];
                    } else {
                        $response[$value['id']]['emp_name'] = $dd['emp_name'];
                        $response[$value['id']]['emp_work_email'] = $empmail['emp_work_email'];
                    }
                }
                if (array_key_exists($value['id'], $response)) {
                    $data['sector_details'][$key]['emp_name'] = $response[$value['id']]['emp_name'];
                    $data['sector_details'][$key]['emp_work_email'] = $response[$value['id']]['emp_work_email'];
                }
            }
        }

        $data['cpage'] = "master_settings/sector_leads";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function addSectorLeads() {
        $data['partner_id'] = $this->session->userdata('partner_id');
        $data['sector_id'] = $_POST['sector_value'];
        $data['employee_number'] = $_POST['associate_employee'];
        $id = $this->Sector_model->addSectorIncharge($data, 'assign_sector_lead');

        redirect('master/master_settings/sector_leads/');
    }

    public function getSectorLeads() {
        $id = $this->input->post('id');
        $this->load->model('scouting/Mincharge');
        $data['inchargeList'] = $this->Mincharge->getSectorLeads($id);
        echo json_encode($data['inchargeList']);
    }

    public function donor_fit_add() {
        if (isset($_POST['txtSubmit'])) {
            if ($this->session->userdata('user_type') == 'superadmin') {
                $this->form_validation->set_rules('branch', 'Partner', 'required');
            }
            $this->form_validation->set_rules('donor_fit', 'Donor Fit', 'required');
            if ($this->form_validation->run() != false) {
                $partner_id = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : ($this->session->userdata('partner_id'));
                $insert = array('name' => $_POST['donor_fit'], 'status' => '1', 'partner_id' => $partner_id);
                $result = $this->Mmaster_settings->insertDonorFit($insert);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record inserted !');
                    redirect('master/master_settings/donor_fit_list/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = "Add Donor Fit";
        $data['cpage'] = "master_settings/add_donorfit";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function preliminary_reason_add() {
        if (isset($_POST['prelim'])) {
            $this->form_validation->set_rules('prelim', 'Preliminary Reason', 'required');
            if (!isset($_POST['branch_user'])) {
                $this->form_validation->set_rules('branch', 'Partner', 'required');
            }
            if ($this->form_validation->run() != false) {
                if (isset($_POST['branch']) && $_POST['branch'] != '') {
                    $partner_id = $_POST['branch'];
                } else {
                    $partner_id = $this->session->userdata('partner_id');
                }
                $insert = array('name' => $_POST['prelim'], 'partner_id' => $partner_id, 'status' => '1');
                $result = $this->Mmaster_settings->insertPreliminaryReason($insert);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record inserted !');
                    redirect('master/master_settings/preliminary_reason/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = "Add Preliminary Reason";
        $data['cpage'] = "master_settings/add_prelim";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function DonorFit_changestatus($id = null, $status = null) {
        if ($id != '' && $status != '') {
            $where = array('id' => $id);
            $update = array('status' => $status);
            $this->Mmaster_settings->updateDonorFit($update, $where);
            $this->session->set_flashdata('successMsg', 'Donor Fit Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/donor_fit_list/');
    }

    public function reject_reason_changestatus($id = null, $status = null) {
        if ($id != '' && $status != '') {
            $where = array('id' => $id);
            $update = array('status' => $status);
            $this->Mmaster_settings->updateRejectReason($update, $where);
            $this->session->set_flashdata('successMsg', 'Reject Name Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/reject_reasons/');
    }

    public function Prelim_changestatus($id = null, $status = null) {
        if ($id != '' && $status != '') {
            $where = array('id' => $id);
            $update = array('status' => $status);
            $this->Mmaster_settings->updatePrelim($update, $where);
            $this->session->set_flashdata('successMsg', 'Preliminary reason updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/preliminary_reason/');
    }

    public function DonorFit_edit($id = null) {
        if ($id != null) {
            $data['donor'] = $this->Mmaster_settings->getDonorFit($id);
        }
        if (isset($_POST['txtSubmit'])) {
            if ($this->session->userdata('usertype') == 'superadmin') {
                $this->form_validation->set_rules('branch', 'Partner', 'required');
            }
            $this->form_validation->set_rules('donor_fit', 'Donor Fit', 'required');
            if ($this->form_validation->run() != false) {
                $partner_id = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : ($this->session->userdata('partner_id'));
                $update = array('name' => $_POST['donor_fit'], 'partner_id' => $partner_id);
                $where = array('id' => $id);
                $result = $this->Mmaster_settings->updateDonorFit($update, $where);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record updated Successfully !');
                    redirect('master/master_settings/donor_fit_list/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = ($id != null) ? "Edit Donor Fit" : "Add Donor Fit";
        $data['cpage'] = "master_settings/add_donorfit";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function Prelim_edit($id = null) {
        if ($id != null) {
            $data['reasons'] = $this->Mmaster_settings->getPrelim($id);
        }
        if (isset($_POST['prelim'])) {
            $this->form_validation->set_rules('prelim', 'Preliminary Reasons', 'required');
            if ($this->form_validation->run() != false) {
                $update = array('name' => $_POST['prelim']);
                $where = array('id' => $id);
                $result = $this->Mmaster_settings->updatePrelim($update, $where);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record updated Successfully !');
                    redirect('master/master_settings/preliminary_reason/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }

        $data['cpagetitle'] = ($id != null) ? "Edit Preliminary Reason" : "Add Preliminary Reason";
        $data['cpage'] = "master_settings/add_prelim";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function donor_exist_check($value = null, $id = null) {
        $donor = $value;
        $count = $this->Mmaster_settings->donorFitExist($donor, $id);
        echo $count;
        exit;
    }

    public function prelim_exist_check($value = null, $id = null) {
        $donor = $value;
        $count = $this->Mmaster_settings->PreliminaryExist($donor, $id);
        echo $count;
        exit;
    }

    public function DonorFit_delete($id = null) {

        if ($id != '') {
            $result = $this->Mmaster_settings->deleteDonorFit($id);

            if ($result == 'Exist') {
                $this->session->set_flashdata('successMsg', 'Donor Fit cannot be deleted. It was assigned to innovation');
            } else if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Donor Fit deleted Successfully');
            }
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/donor_fit_list/');
    }

    public function reject_reason_delete($id = null) {

        if ($id != '') {
            $result = $this->Mmaster_settings->deleteRejectReasons($id);

            if ($result == 'Exist') {
                $this->session->set_flashdata('successMsg', 'Reject Name cannot be deleted. It was assigned to innovation');
            } else if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Reject Name deleted Successfully');
            }
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/reject_reasons/');
    }

    public function Prelim_delete($id = null) {
        if ($id != '') {
            $result = $this->Mmaster_settings->deletePrelim($id);

            if ($result == 'Exist') {
                $this->session->set_flashdata('successMsg', 'Reason cannot be deleted. It was assigned to innovation');
            } else if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Reason deleted Successfully');
            }
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/master_settings/preliminary_reason/');
    }

    public function document_type() {
        $data['type_list'] = $this->Mmaster_settings->fetchListType('diligence_document_types');

        $data['cpagetitle'] = "Document Type Listing";
        $data['cpage'] = "master_settings/document_type";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function document_type_add() {
        if (isset($_POST['formsubmit']) && $_POST['formsubmit'] == 1) {
            $this->form_validation->set_rules('doc_type', 'Document Name', 'required');
            if ($this->form_validation->run() != false) {
                $insert = array('type' => '1', 'name' => $_POST['doc_type'], 'status' => '1');
                $result = $this->Mmaster_settings->insertUploadTypes('diligence_document_types', $insert);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'New document type inserted!');
                    redirect('master/master_settings/document_type/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['cpagetitle'] = "Add Document Type";
        $data['cpage'] = "master_settings/add_document_type";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function document_type_edit($id = null) {
        if ($id != null) {
            $data['type_list'] = $this->Mmaster_settings->fetchListType('diligence_document_types', $id);
        }
        if (isset($_POST['formsubmit']) && $_POST['formsubmit'] == 1) {
            $this->form_validation->set_rules('doc_type', 'Document Name', 'required');
            if ($this->form_validation->run() != false) {
                $update = array('type' => '1', 'name' => $_POST['doc_type'], 'status' => '1');
                $where = array('id' => $id);
                $result = $this->Mmaster_settings->updateDocType('diligence_document_types', $update, $where);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record updated Successfully!');
                    redirect('master/master_settings/document_type/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = ($id != null) ? "Edit Document Type" : "Add Document Type";
        $data['cpage'] = "master_settings/add_document_type";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function docType_changeStatus($id = null, $status = null) {
        if ($id != '' && $status != '') {
            $where = array('id' => $id);
            $update = array('status' => $status);
            $this->Mmaster_settings->updateDocType('diligence_document_types', $update, $where);
            $this->session->set_flashdata('successMsg', 'Document type status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/document_type');
    }

    public function check_existingDocument() {
        $value = $_POST['name'];
        $id = $_POST['id'];
        $count = $this->Mmaster_settings->type_checkExist('diligence_document_types', $value, $id);
        echo $count;
        exit;
    }

    public function meeting_type() {
        $data['type_list'] = $this->Mmaster_settings->fetchListType('diligence_meeting_type');

        $data['cpagetitle'] = "Meeting Type Listing";
        $data['cpage'] = "master_settings/meeting_type";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function partner_currency() {
        $data['type_list'] = $this->Mmaster_settings->fetchListType('partner_currency');

        $data['cpagetitle'] = "Currency Master";
        $data['cpage'] = "master_settings/partner_currency";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function meeting_type_add() {
        if (isset($_POST['formsubmit']) && $_POST['formsubmit'] == 1) {
            $this->form_validation->set_rules('doc_type', 'Meeting Name', 'required');
            if ($this->form_validation->run() != false) {
                $insert = array('name' => $_POST['doc_type'], 'status' => '1');
                $result = $this->Mmaster_settings->insertUploadTypes('diligence_meeting_type', $insert);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'New meeting type inserted!');
                    redirect('master/master_settings/meeting_type/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['cpagetitle'] = "Add Meeting Type";
        $data['cpage'] = "master_settings/add_meeting_type";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function currency_add() {
        if (isset($_POST['formsubmit']) && $_POST['formsubmit'] == 1) {
            $this->form_validation->set_rules('name', 'Currency Name', 'required');
            $this->form_validation->set_rules('currency_code', 'Currency Code', 'required');
            if ($this->form_validation->run() != false) {
                $insert = array('name' => $_POST['name'], 'currency_code' => strtoupper($_POST['currency_code']), 'currency_symbol' => $_POST['currency_symbol'], 'prefix' => $_POST['prefix'], 'status' => '1');

                $result = $this->Mmaster_settings->insertUploadTypes('partner_currency', $insert);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'New Currency inserted!');
                    redirect('master/master_settings/partner_currency');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['cpagetitle'] = "Add Meeting Type";
        $data['cpage'] = "master_settings/add_currency";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function meeting_type_edit($id = null) {
        if ($id != null) {
            $data['type_list'] = $this->Mmaster_settings->fetchListType('diligence_meeting_type', $id);
        }
        if (isset($_POST['formsubmit']) && $_POST['formsubmit'] == 1) {
            $this->form_validation->set_rules('doc_type', 'Meeting Name', 'required');
            if ($this->form_validation->run() != false) {
                $update = array('name' => $_POST['doc_type'], 'status' => '1');
                $where = array('id' => $id);
                $result = $this->Mmaster_settings->updateDocType('diligence_meeting_type', $update, $where);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record updated Successfully!');
                    redirect('master/master_settings/meeting_type/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = ($id != null) ? "Edit Meeting Type" : "Add Meeting Type";
        $data['cpage'] = "master_settings/add_meeting_type";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function currency_edit($id = null) {
        if ($id != null) {
            $data['type_list'] = $this->Mmaster_settings->fetchListType('partner_currency', $id);
        }
        if (isset($_POST['formsubmit']) && $_POST['formsubmit'] == 1) {
            $this->form_validation->set_rules('name', 'Currency Name', 'required');
            $this->form_validation->set_rules('currency_code', 'Currency Code', 'required');
            if ($this->form_validation->run() != false) {
                $update = array('name' => $_POST['name'], 'currency_code' => strtoupper($_POST['currency_code']), 'currency_symbol' => $_POST['currency_symbol'], 'prefix' => $_POST['prefix'], 'status' => '1');
                $where = array('id' => $id);
                $result = $this->Mmaster_settings->updateDocType('partner_currency', $update, $where);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record updated Successfully!');
                    redirect('master/master_settings/partner_currency/');
                }
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['cpagetitle'] = ($id != null) ? "Edit Currency" : "Currency";
        $data['cpage'] = "master_settings/add_currency";

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function meetType_changeStatus($id = null, $status = null) {
        if ($id != '' && $status != '') {
            $where = array('id' => $id);
            $update = array('status' => $status);
            $this->Mmaster_settings->updateDocType('diligence_meeting_type', $update, $where);
            $this->session->set_flashdata('successMsg', 'Meeting type status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/master_settings/meeting_type');
    }

    public function check_existingMeeting($value, $id = null) {
        $value = $_POST['name'];
        $id = $_POST['id'];
        $count = $this->Mmaster_settings->type_checkExist('diligence_meeting_type', $value, $id);
        echo $count;
        exit;
    }

    public function currency_changeStatus($id = null, $status = null) {
        if ($id != '' && $status != '') {
            $where = array('id' => $id);
            $update = array('status' => $status);
            $this->Mmaster_settings->updateDocType('partner_currency', $update, $where);
            $this->session->set_flashdata('successMsg', 'Currency status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Something went wrong');
        }

        redirect('master/master_settings/partner_currency');
    }

    public function check_existingCurrency($value, $id = null) {
        $value = $_POST['name'];
        $id = $_POST['id'];
        $count = $this->Mmaster_settings->type_checkExist('partner_currency', $value, $id);
        echo $count;
        exit;
    }

}
