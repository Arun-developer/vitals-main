<?php

class Incubation_master extends CI_Controller {

    function __construct() {

        #error_reporting(-1);
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->Mauth->isAdminCheck();
        #$this->Mauth->loginUser();
        $this->load->model('incubation_master/Mmaster');
        $this->load->model('incubation_master/Common_model');
//        $this->load->model('incubation_master/sector_model');
        $this->load->model('master/Sector_model');
    }

    public function sectors() {
        $this->load->view('incubation_masters/sector');
    }
	
	 public function program_master_list() {
        $this->load->view('incubation_masters/program_master_list');
    }
	
	
	
    public function reason() {
        $condition = array('id' => $this->session->userdata('partner_id'));
        $getBranchName = $this->Common_model->get_all_details('hr_branch', $condition, array('branch_name'), '', '', '', true, 'hris');
        $data['branch_name'] = $getBranchName[0]->branch_name;
        $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_lists = '<option value="" >--Select--</option>';
        foreach ($getBranch_records as $list) {
            $select_pid = '';
            if ($list->id == $branchId) {
                $select_pid = 'selected';
            }
            $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
        }
        $data['options'] = $option_lists;
        $data['admin_type'] = 0;
        if ($this->session->userdata('user_type') != 'superadmin') {
            $data['admin_type'] = 1;
        }
        $this->load->view('incubation_masters/reason', $data);
    }

    public function preliminary_reason() {


        $condition = array('id' => $this->session->userdata('partner_id'));
        $getBranchName = $this->Common_model->get_all_details('hr_branch', $condition, array('branch_name'), '', '', '', true, 'hris');
        $data['branch_name'] = $getBranchName[0]->branch_name;
        $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_lists = '<option value="" >--Select--</option>';
        foreach ($getBranch_records as $list) {
            $select_pid = '';
            if ($list->id == $branchId) {
                $select_pid = 'selected';
            }
            $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
        }
        $data['options'] = $option_lists;
        $data['admin_type'] = 0;
        if ($this->session->userdata('user_type') != 'superadmin') {
            $data['admin_type'] = 1;
        }
        $this->load->view('incubation_masters/preliminary_reason', $data);
    }

    public function donor_fit() {
        $condition = array('id' => $this->session->userdata('partner_id'));
        $getBranchName = $this->Common_model->get_all_details('hr_branch', $condition, array('branch_name'), '', '', '', true, 'hris');
        $data['branch_name'] = $getBranchName[0]->branch_name;
        $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_lists = '<option value="" >--Select--</option>';
        foreach ($getBranch_records as $list) {
            $select_pid = '';
            if ($list->id == $branchId) {
                $select_pid = 'selected';
            }
            $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
        }
        $data['options'] = $option_lists;
        $data['admin_type'] = 0;
        if ($this->session->userdata('user_type') != 'superadmin') {
            $data['admin_type'] = 1;
        }
        $this->load->view('incubation_masters/donor_fit', $data);
    }

    public function master_settings() {

        if ($this->session->userdata('user_type') != 'superadmin' && $currentTab != 'reject_reasons' && $currentTab != 'portfolio_list') {
            redirect('portfolio/dashboard');
        } else {
            $getBranchName = $this->Common_model->get_all_details('hr_branch', $condition, array('branch_name'), '', '', '', true, 'hris');
            $data['branch_name'] = $getBranchName[0]->branch_name;
            $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
            $option_lists = '<option value="" >--Select--</option>';
            foreach ($getBranch_records as $list) {
                $select_pid = '';
                if ($list->id == $branchId) {
                    $select_pid = 'selected';
                }
                $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
            }
            $data['options'] = $option_lists;
            $data['admin_type'] = 0;
            if ($this->session->userdata('user_type') != 'superadmin') {
                $data['admin_type'] = 1;
            }
            $this->load->view('incubation_masters/master_settings', $data);
        }
    }

    public function portfolio_settings() { #echo $this->session->flashdata('successMsg');die;
    $currentTab = $this->uri->segment(3);
    $title = $table = $cpage = '';

    if ($currentTab == 'designation') {
        $title = 'Designation';
        $table = 'port_team_designations';
    } else if ($currentTab == 'partnership_type') {
        $title = 'Non-TAP';
        $table = 'port_ttm_partnership_master';
    } else if ($currentTab == 'units') {
        $title = 'Units';
        $table = 'port_units';
    } else if ($currentTab == 'donor') {
        $title = 'Donors';
        $table = 'port_donor_masters';
    } else if ($currentTab == 'service') {
        $title = 'Technical Asst. Services';
        $table = 'port_service_providers';
    } else if ($currentTab == 'company_target') {
        $title = 'Sector Target';
        $table = 'port_dashboard_master';
    } else if ($currentTab == 'mentor_area') {
        $title = 'Mentor Focus Area';
        $table = 'port_mentor_focus_area';
    } else if ($currentTab == 'technical_area') {
        $title = 'Technical Asst. Focus Area';
        $table = 'port_tap_focus_area';
    }
    $data['titles'] = $title;
    $data['table'] = $table;

    $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
    $option_lists = '<option value="" >--Select--</option>';
    foreach ($getBranch_records as $list) {
        $select_pid = '';
        if ($list->id == $branchId) {
            $select_pid = 'selected';
        }
        $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
    }
    $data['options'] = $option_lists;
    $data['admin_type'] = 0;
    if ($this->session->userdata('user_type') != 'superadmin') {
        $data['admin_type'] = 1;
    }
    if ($currentTab != 'company_target') {
        $this->load->view('incubation_masters/portfolio_settings', $data);
    } else {
        $this->load->view('incubation_masters/company_target', $data);
    }
}

public function incubation_progress() {
    $currentTab = $this->uri->segment(3);
    $data['criteria_list'] = $this->Common_model->get_all_details('master_settings', array('iris_tab' => 'standard'), array('master_name', 'id'));
    $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
    $option_lists = '<option value="" >--Select--</option>';
    foreach ($getBranch_records as $list) {
        $select_pid = '';
        if ($list->id == $branchId) {
            $select_pid = 'selected';
        }
        $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
    }
    $data['options'] = $option_lists;
    $data['admin_type'] = 0;
    if ($this->session->userdata('user_type') != 'superadmin') {
        $data['admin_type'] = 1;
    }
    $this->load->view('incubation_masters/incubation_progress', $data);
}

public function incubation_subfield() {
    $currentTab = $this->uri->segment(3);
    $data['criteria_list'] = $this->Common_model->get_all_details('master_settings', array('iris_tab' => 'standard'), array('master_name', 'id'));
    $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
    $option_lists = '<option value="" >--Select--</option>';
    foreach ($getBranch_records as $list) {
        $select_pid = '';
        if ($list->id == $branchId) {
            $select_pid = 'selected';
        }
        $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
    }
    $data['options'] = $option_lists;
    $data['admin_type'] = 0;
    if ($this->session->userdata('user_type') != 'superadmin') {
        $data['admin_type'] = 1;
    }

    $this->load->view('incubation_masters/incubation_subfield', $data);
}

public function screening_master() {

    $data['criteriaList'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Grading Category'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
    $this->load->view('incubation_masters/screening_master', $data);
}

public function screening_subfields() {

    $currentTab = $this->uri->segment(3);
    $data['criteria_list'] = $this->Common_model->get_all_details('master_settings', array('iris_tab' => 'standard'), array('master_name', 'id'));
    $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
    $option_lists = '<option value="" >--Select--</option>';
    foreach ($getBranch_records as $list) {
        $select_pid = '';
        if ($list->id == $branchId) {
            $select_pid = 'selected';
        }
        $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
    }
    $data['options'] = $option_lists;
    $data['admin_type'] = 0;
    if ($this->session->userdata('user_type') != 'superadmin') {
        $data['admin_type'] = 1;
    }

    $this->load->view('incubation_masters/screening_subfields', $data);
}

public function assessment() {

    $currentTab = $this->uri->segment(3);
    $data['criteria_list'] = $this->Common_model->get_all_details('master_settings', array('iris_tab' => 'standard'), array('master_name', 'id'));
    $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
    $option_lists = '<option value="" >--Select--</option>';
    foreach ($getBranch_records as $list) {
        $select_pid = '';
        if ($list->id == $branchId) {
            $select_pid = 'selected';
        }
        $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
    }
    $data['options'] = $option_lists;
    $data['admin_type'] = 0;
    if ($this->session->userdata('user_type') != 'superadmin') {
        $data['admin_type'] = 1;
    }

    $this->load->view('incubation_masters/assessment', $data);
}

public function means_validation() {

    $data['criteriaList'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Grading Category'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
    $this->load->view('incubation_masters/means_validation', $data);
}

public function checklist() {

    $data['area_origin'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Area/Origin'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));

    $this->load->view('incubation_masters/checklist', $data);
}

public function program_service_master() {
    $data['get_source_type'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Program Type'), array(), '', '', array('master_name' => 'asc'));
    $this->load->view('incubation_masters/program_service_master', $data);
}

public function program_stage_master() {
    $data['get_source_type'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Program Type'), array(), '', '', array('master_name' => 'asc'));
    $this->load->view('incubation_masters/program_stage_master', $data);
}

public function grading_master() {
    $data['get_source_type'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Program Type'), array(), '', '', array('master_name' => 'asc'));
    $this->load->view('incubation_masters/grading_master', $data);
}

public function addEdit_program_service() {
    $id = $this->uri->segment(3);
    $data['get_source_type'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Program Type'), array(), '', '', array('master_name' => 'asc'));
    $data['program_service'] = array();
    if ($id != '') {
        $program_service = $this->Common_model->get_all_details('program_service_offering', array('id' => $id));
        $data['program_service'] = $program_service[0];
    }
    $this->load->view('incubation_masters/addEdit_program_service', $data);
}

public function addEdit_program_stage() {
    $id = $this->uri->segment(3);
    $data['get_source_type'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Program Type'), array(), '', '', array('master_name' => 'asc'));
    $data['program_service'] = array();
    if ($id != '') {
        $program_stage = $this->Common_model->getProgramStageInfo($id);
        $data['program_stage'] = $program_stage[0];
    }
    $this->load->view('incubation_masters/addEdit_program_stage', $data);
}

public function addEdit_grading_master() {
    $id = $this->uri->segment(3);
    if ($id != '') {
        $get_grade = $this->Common_model->get_all_details('grading_master', array('id' => $id), array());
        $data['get_grade'] = $get_grade[0];
    }

    $data['program_stage'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Grading Category'), array(), '', '', array('master_name' => 'asc'));
    $data['category'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Grading Category'), array(), '', '', array('master_name' => 'asc'));
    $this->load->view('incubation_masters/addEdit_grading_master', $data);
}

public function addEdit_validation() {
    $id = $this->uri->segment(3);
    if ($id != '') {
        $get_validation = $this->Common_model->get_all_details('means_validation', array('id' => $id), array());
        $data['get_validation'] = $get_validation[0];
    }
    $data['criteriaList'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Grading Category'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
    $this->load->view('incubation_masters/addEdit_validation', $data);
}

public function addEdit_checklist() {
    $id = $this->uri->segment(3);
    if ($id != '') {
        $get_checklist = $this->Common_model->get_all_details('checklist_master', array('id' => $id), array());
        $data['get_checklist'] = $get_checklist[0];
    }
    $data['areaList'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Area/Origin'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
    $this->load->view('incubation_masters/addEdit_checklist', $data);
}

public function insertEdit_validation() {

    $id = $this->input->post('id');
    $criteria = $this->input->post('criteria');
    $validation = $this->input->post('validation');
    $status = $this->input->post('status');
    if ($id != '') {
        $condition = array('id' => $id);
        $updateData = array('criteria' => $criteria, 'validation' => $validation, 'status' => $status);
        $this->Common_model->update_data('means_validation', $condition, $updateData);
        $this->session->set_flashdata('successMsg', "Record saved successfully");
    } else {
        $insertData = array('criteria' => $criteria, 'validation' => $validation, 'status' => $status);
        $this->Common_model->insert_data('means_validation', $insertData);
        $this->session->set_flashdata('successMsg', "Record saved successfully");
    }

    redirect('incubation_master/means_validation');
}

public function insertEdit_checklist() {

    $id = $this->input->post('id');
    $area = $this->input->post('area');
    $document_description = $this->input->post('document_description');
    $status = $this->input->post('status');
    if ($id != '') {
        $condition = array('id' => $id);
        $updateData = array('area' => $area, 'document_description' => $document_description, 'status' => $status);
        $this->Common_model->update_data('checklist_master', $condition, $updateData);
    } else {
        $insertData = array('area' => $area, 'document_description' => $document_description, 'status' => $status);
        $this->Common_model->insert_data('checklist_master', $insertData);
    }
    $this->session->set_flashdata('successMsg', "Record saved successfully");
    redirect('incubation_master/checklist');
}

public function view_sectors($res) {
    $sector_id = $this->uri->segment('3');
    $branch_id = $this->session->userdata('partner_id');
    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $condition = array('pitch' => $pitch_id, 'parent_id' => 0);
    } else {
        $condition = array('parent_id' => 0);
    }

    if ($sector_id != '') {
        $condition['id'] = $sector_id;
    }
    $get_sectorDetails = $this->Common_model->get_all_details('sector_category', $condition, array());
    $data['sector_name'] = '';
    $data['sector_id'] = '';
    if ($get_sectorDetails[0]->sector != '') {
        $data['sector_name'] = $get_sectorDetails[0]->sector;
        $data['sector_id'] = $get_sectorDetails[0]->id;
    }
    $this->load->view('incubation_masters/view_sectors', $data);
}

public function view_program($programId=null) {  
	
    $sector_id = $this->uri->segment('3');
    $branch_id = $this->session->userdata('partner_id');
    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $condition = array('pitch' => $pitch_id, 'parent_id' => 0);
    } else {
        $condition = array('parent_id' => 0);
    }

    if ($sector_id != '') {
        $condition['id'] = $sector_id;
    }
    $get_programDetails = $this->Common_model->get_all_details('program_type',array('id'=>$programId), array());
    $data['program_name'] = '';
    $data['program_id'] =  $programId;
   if ($get_programDetails[0]->program_name != '') {
        $data['program_name'] = $get_programDetails[0]->program_name;
    }
    $this->load->view('incubation_masters/view_program', $data);
}

	
public function addSectors() {
	$sector_id = $this->uri->segment('3');
    $branch_id = $this->session->userdata('partner_id');
    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $condition = array('pitch' => $pitch_id, 'parent_id' => 0);
    } else {
        $condition = array('parent_id' => 0);
    }

    if ($sector_id != '') {
        $condition['id'] = $sector_id;
    }
    #$get_sectorDetails = $this->Common_model->get_all_details('sector_category', $condition, array());
    $data['sector_name'] = '';
    $data['sector_id'] = '';
    if ($get_sectorDetails[0]->sector != '') {
        #$data['sector_name'] = $get_sectorDetails[0]->sector;
        #$data['sector_id'] = $get_sectorDetails[0]->id;
    }
	#echo'<pre>';print_r($get_sectorDetails);die;
    $this->load->view('incubation_masters/add_sectors', $data);
}


public function addProgram() {
	
	$sector_id = $this->uri->segment('3');
    $branch_id = $this->session->userdata('partner_id');
    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $condition = array('pitch' => $pitch_id, 'parent_id' => 0);
    } else {
        $condition = array('parent_id' => 0);
    }

    if ($sector_id != '') {
        $condition['id'] = $sector_id;
    }
    $get_programDetails = $this->Common_model->get_all_details('program_type',array(), array());
    $data['program_name'] = '';
   
    $this->load->view('incubation_masters/add_program', $data);
	
}


public function stage_efficiency() {
    if ($this->session->userdata('user_type') != 'superadmin') {
        redirect('portfolio/dashboard');
    } else {
        $data['stage_efficiency'] = $this->Common_model->get_all_details('stagefficiency', array(), array());
        $this->load->view('incubation_masters/stage_efficiency', $data);
    }
}

public function user_setup() {

    $data['usersList'] = array();
    if ($this->session->userdata('user_type') == 'superadmin') {
        $data['admin_status'] = false;
    } else {
        $data['admin_status'] = true;
        $data['partner_id'] = $this->session->userdata('partner_id');
            #$data['usersList'] = $usersList = $this->Common_model->getUsersList_sa($this->session->userdata('partner_id'));
        $data['userSetup'] = $this->Common_model->getUserSetup($this->session->userdata('partner_id'));
    }
    $data['branch'] = $this->Common_model->get_all_details('hr_branch', array('status' => 'active'), array());
        #echo'<pre>';print_r($data['userSetup']);die;
    $data['stage_efficiency'] = $this->Common_model->get_all_details('stagefficiency', array(), array());

    $this->load->view('incubation_masters/user_setup', $data);
}

public function insertEdit_usersetup() {
        #echo'<pre>';print_r($_POST);die;
    $result = $this->Common_model->insertUserSetup($_POST);
    $this->session->set_flashdata('successMsg', "Record saved successfully");
    redirect('incubation_master/user_setup');
}

public function document_type() {
    if ($this->session->userdata('user_type') != 'superadmin') {
        redirect('portfolio/dashboard');
    } else {
        $this->load->view('incubation_masters/document_type', $data);
    }
}



public function master_metrics() {
/* 	
	$HistoricMetrics = array('Geo-TS'=>'Geo - Telengana',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Land Indirectly Controlled: Sustainably Managed: Area being monitored via drones through hyperspectral imaging (acres)'=> 'Land sustainably managed  - Indirectly controlled : Area being monitored via drones through hyperspectral imaging - Acres',
'Setting distribution-Code'=> 'Others - Setting Distribution - Code',
'Client Individuals: Smallholder: Total No of farmers in network receiving agri advisory inputs from BR'=> 'Client Individuals - Farmers: Smallholders',
'Smallholder Supplier Individuals: Smallholder No of farmers BR has procured from'=> 'Supplier Individuals - Farmers : Smallholders',
'Amount of energy saved (KW) by all products sold/installed in the period specified'=> 'Energy - Amount of energy saved (KW) by all products sold/installed in the period specified - KwH',
'Amount of water saved (ltrs) by all products sold/installed in the period specified'=> 'Water conserved - Total - Ltrs',
'Total No of units sold/installed of the product or service'=> 'Units Sold - Total',
'Total Land Indirectly Controlled: Sustainably Managed (acres)'=> 'Land sustainably managed - Indirectly Controlled - Acres',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-AP'=> 'Geo - Andhra Pradesh',
'Client Organizations: Total no of enterprises or organisations who were clients'=> 'Client organisations - Total',
'Client Individuals: Total No of Smallholder clients'=> 'Client Individuals - Farmers : Smallholders',
'Setting distribution-Code'=> 'Others - Setting Distribution - Code',
'Greenhouse Gas Emissions Avoided'=> 'GHG avoided - Total - KgCo2e',
'Geo-RJ'=> 'Geo - Rajasthan ',
'Total No of farmers who bought Krimanshi products'=> 'Client Individuals - Farmers',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Geo-UK'=> 'Geo - Uttar Pradesh',
'Geo-HR'=> 'Geo - Haryana',
'Geo-AP'=> 'Geo - Andhra Pradesh',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Amount of water saved (liters)'=> 'Water conserved - Total - Ltrs',
'Setting distribution-Code'=> 'Others - Setting Distribution - Code',
'Total No of organisations using Kritsnam s products/services to enable access to smallholder farmers'=> 'Client organisations - Total',
'Client Individuals: Smallholder: Total No of smallholder farmers using/receiving Kritsnam services or products (No of end beneficiaries)'=> 'Client Individuals - Farmers : Smallholders',
'Land Indirectly Controlled: Total- No of acres transplanters are used on'=> 'Land sustainably managed - Indirectly Controlled : area of transplantors used on  - Acres',
'Number of transplanters sold'=> 'Units Sold - Number of transplanters sold',
'Number of transplanters rented'=> 'Others - Number of transplanters rented',
'Volume of water saved per acre (liters)'=> 'Water conserved - Volume of water saved per acre  - Ltrs',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-TS'=> 'Geo - Telengana',
'Organisations partnered with for testing and trials'=> 'Partnerships - Organisations partnered with for testing and trials',
'Geo-DL'=> 'Geo - Delhi',
'No of batches geo-tagged and quality tested'=> 'Others - No of batches geo-tagged and quality tested',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Amt of potential water recharged by the total no of borewells installations done'=> 'Water recharged - Amt of water recharged through borewell installations - Ltrs',
'Total No of borewells which saw an increased water re-charge'=> 'Water recharged - Total no. of borewells which saw an increase in water recharged - Nos',
'Geo-MH'=> 'Geo - Maharashtra',
'Individuals Trained: Total'=> 'Individuals Trained - Total',
'Client Organizations: Total'=> 'Client organisations - Total',
'Geo-OR'=> 'Geo - Odisha',
'Total No of free and paid student users'=> 'Client Individuals - Students : Free & Paid users',
'Total low-income student users using app for free'=> 'Client Individuals - Students : Total low-income student users using app for free',
'Hours spent by student users on the app'=> 'Usage - Hours spent by student users on the app',
'Engagement Time on Task via Practice'=> 'Usage - Engagement Time on Task via Practice',
'Engagement Time on Task via Feedback received'=> 'Usage - Engagement Time on Task via Feedback received',
'Metric denoting success/proficiency of English of'=> 'Others - Metric denoting success/proficiency of English of',
'No of courses purchased'=> 'Units Sold - No of courses purchased',
'No of monthly Active Users'=> 'Client Individuals - No of monthly Active Users',
'Full Time Maids (10 hours)'=> 'Direct Jobs  - Full Time Maids (10 hours)',
'Part Time Maids'=> 'Direct Jobs  - Part Time Maids',
'24 hour maids'=> 'Direct Jobs  - 24 hour maids',
'No of domestic workers coming back to be placed again by BMB'=> 'Direct Jobs  - No of domestic workers coming back to be placed again by BMB',
'Average Wage Enhancement'=> 'Income Increase - Average Wage Enhancement',
'DH placed in Bombay'=> 'Others - DH placed in Bombay',
'DH placed in Bangalore'=> 'Others - DH placed in Bangalore',
'Amount paid to secondary vendors (individuals)'=> 'Income  - Amount paid to secondary vendors (individuals)',
'Amount paid to primary vendors (individuals)'=> 'Income  - Amount paid to primary vendors (individuals)',
'Amount paid to plus vendors'=> 'Income  - Amount paid to plus vendors',
'Proportion of female users'=> 'Client Individuals - Female',
'Proportion of male users'=> 'Client Individuals - Male',
'No of users with monthly income<INR 20,000'=> 'Income  - No of users with monthly income<INR 20,000',
'No of Courses Purchased'=> 'Units Sold - No of courses purchased',
'No of active users per month'=> 'Client Individuals - No of monthly Active Users',
'Metric denoting success of language proficiency'=> 'Usage - Metric denoting success of language proficiency',
'Proportion of female users'=> 'Client Individuals - Female',
'Proportion of male users'=> 'Client Individuals - Male',
'Course completion rate'=> 'Usage - Course completion rate',
'Amount of crop wastage saved (MT)'=> 'Waste Avoided - Amount of crop wastage saved - MT',
'Amount of produce stored in the utilities (MT)'=> 'Usage - Amount of produce stored in the utilities - MT',
'Geographic distribution - GEO-BR'=> 'Geo - Bihar',
'Geographic distribution - GEO-GJ'=> 'Geo - Gujarat',
'Geographic distribution - GEO-KA'=> 'Geo - Karnataka',
'Geographic distribution - GEO-WB'=> 'Gep - West Bengal',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of client enterprises - Market Linkage Companies'=> 'Partnerships - Market linkage companies',
'Number of products sold'=> 'Units Sold - Total',
'Greenhouse Gas Emissions Avoided'=> 'GHG avoided - Total - KgCo2e',
'Energy Savings from Products Sold/Installed'=> 'Energy - Energy Savings from Products Sold/Installed - KwH',
'Renewable energy used by product sold'=> 'Energy - Renewable energy used by product sold - KwH',
'Number of user trials conducted'=> 'User trials - Total',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'No of bracelets sold in India'=> 'Units Sold - No of bracelets sold in India',
'No of bracelets sold Internationally'=> 'Units Sold - No of bracelets sold Internationally',
'Number of end beneficiaries  (FlexmoClassic)'=> 'Patients - FlexmoClassic',
'Number of end beneficiaries  (FlexmoComposite)'=> 'Patients - FlexmoComposite',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Geographic distribution-State1'=> 'Geo - ',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of products sold (FlexmoClassic)'=> 'Units Sold - FlexmoClassic',
'Number of products sold (FlexmoComposite)'=> 'Units Sold - FlexmoComposite',
'Number of user trials conducted'=> 'User trials - Total',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Geographic distribution-State1'=> 'Geo - ',
'Number of end beneficiaries  (Keyar)'=> 'Client  Individuals - Keyar',
'Number of end beneficiaries  (Daksh)'=> 'Client  Individuals - Daksh',
'Number of end beneficiaries'=> 'End Beneficiaries - Number of end beneficiaries',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of intermediaries impacted'=> 'Individuals trained - Total',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of products sold (Keyar)'=> 'Units Sold - Keyar',
'Number of products sold (Daksh)'=> 'Units Sold - Daksh',
'Number of user trials conducted'=> 'User trials - Total',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'No of units sold in Tier I cities'=> 'Units Sold - Tier 1 Cities',
'No of units sold in Tier II and III cities'=> 'Units Sold - Tier II and III cities',
'No of slides scanned per unit/total slides scanned'=> 'Usage - No of slides scanned per unit/total slides scanned',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of end beneficiaries  (NeoCushion)'=> 'Client Individuals - Neocushion',
'Number of end beneficiaries  (NeoBolt)'=> 'Client Individuals - Neobolt',
'Number of end beneficiaries  (NeoFly)'=> 'Client Individuals - NeoFly',
'Number of end beneficiaries'=> 'End Beneficiaries - Number of end beneficiaries',
'Geographic distribution-State1*'=> 'Geo - ',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of products sold (NeoFly)'=> 'Units Sold - NeoFly',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of products sold (NeoCushion)'=> 'Units Sold - NeoCushion',
'Number of products sold (NeoBolt)'=> 'Units Sold - NeoBolt',
'Number of user trials conducted'=> 'User trials - Total',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of user trials conducted'=> 'User trials - Total',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of products sold (NeuroTouch)'=> 'Units Sold - NeuroTouch',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted  (Kadam)'=> 'User trials - Kadam',
'Number of end beneficiaries'=> 'End Beneficiaries - Number of end beneficiaries',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Geo-RAJ'=> 'Geo - Rajasthan',
'Geo-TS'=> 'Geo - Telengana',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Land Indirectly Controlled: Sustainably Managed: Area being monitored via drones through hyperspectral imaging (acres)'=> 'Land sustainably managed  - Indirectly controlled : Area being monitored via drones through hyperspectral imaging - Acres',
'Setting distribution-Code'=> 'Others - Setting distribution-Code',
'Client Individuals: Smallholder: Total No of farmers in network receiving agri advisory inputs from BR'=> 'Client Individuals - Farmers: Smallholders',
'Smallholder Supplier Individuals: Smallholder No of farmers BR has procured from'=> 'Supplier Individuals - Farmers : Smallholders',
'Geo-PB'=> 'Geo - Punjab',
'Amount of energy saved (KWh) by all products sold/installed in the period specified'=> 'Energy - Amount of energy saved (KWh) by all products sold/installed in the period specified - KwH',
'Amount of water saved (ltrs) by all products sold/installed in the period specified'=> 'Water conserved - Amount of water saved (ltrs) by all products sold/installed in the period specified - Ltrs',
'Total No of units sold/installed of the product or service'=> 'Units Sold - Total',
'Total Land Indirectly Controlled: Sustainably Managed (acres)'=> 'Land sustainably managed - Indirectly Controlled - Acres',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-AP'=> 'Geo - Andhra Pradesh',
'Client Organizations: Total no of enterprises or organisations who were clients'=> 'Client organisations - Total',
'Client Individuals: Total No of Smallholder clients'=> 'Client Individuals - Farmers : Smallholders',
'Setting distribution-Code'=> 'Others - Setting distribution-Code',
'Greenhouse Gas Emissions Avoided'=> 'GHG avoided - Total - KgCo2e',
'Geo-RJ'=> 'Geo - Rajasthan ',
'Total No of farmers who bought Krimanshi products'=> 'Client Individuals - Farmers',
'Geo-TS'=> 'Geo - Telengana',
'Geo-MAHA'=> 'Geo - Maharashtra',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Geo-UK'=> 'Geo - Uttar Pradesh',
'Geo-HR'=> 'Geo - Haryana',
'Geo-AP'=> 'Geo - Andhra Pradesh',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Amount of water saved (liters)'=> 'Water conserved - Total - Ltrs',
'Setting distribution-Code'=> 'Others - Setting distribution-Code',
'Total No of organisations using Kritsnam s products/services to enable access to smallholder farmers'=> 'Client organisations - Total',
'Client Individuals: Smallholder: Total No of smallholder farmers using/receiving Kritsnam services or products (No of end beneficiaries)'=> 'Client Individuals - Farmers : Smallholders',
'Number of beneficiaries in Chattisgarh'=> 'Geo - Chhatisgarh',
'Number of beneficiaries in Assam'=> 'Geo - Assam',
'Number of beneficiaries from West Bengal'=> 'Geo - West Bengal',
'Number of smallholder farmer suppliers via FPO partnerships'=> 'Client Individuals - Farmers : Number of smallholder farmer suppliers via FPO partnerships',
'Number of farmers certified organic (NPOP)'=> 'Client Individuals - Farmers : Number of farmers certified organic (NPOP)',
'Land Indirectly Controlled: Total- No of acres transplanters are used on'=> 'Land sustainably managed - Indirectly Controlled : area of transplantors used on  - Acres',
'Number of transplanters sold'=> 'Units Sold - Number of transplanters Sold',
'Number of transplanters rented'=> 'Others - Number of transplanters rented',
'Volume of water saved per acre (liters)'=> 'Water conserved - Volume of water saved per acre  - Ltrs',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-TS'=> 'Geo - Telengana',
'Organisations partnered with for testing and trials'=> 'Partnerships - Organisations partnered with for testing and trials',
'Geo-DL'=> 'Geo - Delhi',
'No of batches geo-tagged and quality tested'=> 'Others - No of batches geo-tagged and quality tested',
'Geo-GJ'=> 'Geo - Gujarat',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Amt of potential water recharged by the total no of borewells installations done'=> 'Water recharged - Amt of water recharged through borewell installations - Ltrs',
'Total No of borewells which saw an increased water re-charge'=> 'Water recharged - Total no. of borewells which saw an increase in water recharged - Nos',
'Geo-MH'=> 'Geo - Maharashtra',
'Individuals Trained: Total'=> 'Individuals trained - Total',
'Client Organizations: Total'=> 'Client organisations - Total',
'Geo-OR'=> 'Geo - Odisha',
'Engagement Time on Task via Feedback received'=> 'Usage - Engagement Time on Task via Feedback received',
'Engagement Time on Task via Practice'=> 'Usage - Engagement Time on Task via Practice',
'Hours spent by student users on the app'=> 'Usage - Hours spent by student users on the app',
'Total low-income student users using app for free'=> 'Client Individuals - Students : Total low-income student users using app for free',
'Total No of paid users (subscriptions)'=> 'Client Individuals - Total No of paid users (subscriptions)',
'Total No of free & paid users (subscriptions)'=> 'Client Individuals - Total No of free & paid users (subscriptions)',
'Full Day (10 hour maids)'=> 'Direct Jobs - Full Day (10 hour maids)',
'Part Time Maids'=> 'Direct Jobs  - Part Time Maids',
'24 hour maids'=> 'Direct Jobs  - 24 hour maids',
'DH placed in Bangalore'=> 'Others- DH placed in Bangalore',
'DH placed in Bombay'=> 'Others - DH placed in Bombay',
'No of DH returning to BMB'=> 'Others - No of DH returning to BMB',
'Average Wage Enhancement'=> 'Income Increase - Average Wage Enhancement',
'Renewable energy used by product sold'=> 'Energy - Renewable energy used by product sold - KwH',
'Energy Savings from Products Sold/Installed'=> 'Energy - Energy Savings from Products Sold/Installed - KwH',
'Greenhouse Gas Emissions Avoided'=> 'GHG avoided - Total - KgCo2e',
'Number of products sold'=> 'Units Sold - Total',
'Number of client enterprises - Market Linkage Companies'=> 'Partnerships - Market linkage companies',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Geographic distribution - GEO-WB'=> 'Gep - West Bengal',
'Geographic distribution - GEO-KA'=> 'Geo - Karnataka',
'Geographic distribution - GEO-GJ'=> 'Geo - Gujarat',
'Geographic distribution - GEO-BR'=> 'Geo - Bihar',
'Amount of produce stored in the utilities (MT)'=> 'Usage - Amount of produce stored in the utilities - MT',
'Amount of crop wastage saved (MT)'=> 'Waste Avoided - Amount of crop wastage saved - MT',
'Geo-TS'=> 'Geo - Telengana',
'Geo-AS'=> 'Geo - Assam',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Geo-MH'=> 'Geo - Maharashtra',
'Geo-OD'=> 'Geo - Orissa',
'Geo-RJ'=> 'Geo - Rajasthan ',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Geo-KA'=> 'Geo - Karnataka',
'Amount of energy savings (over the lifetime of the product for those products that were sold/installed)'=> 'Energy - Amount of energy savings (over the lifetime of the product for those products that were sold/installed) - KwH',
'Total amount of potential  lifetime greenhouse gas (GHG) emissions avoided'=> 'GHG avoided - Total amount of potential lifetime greenhouse gas (GHG) emissions avoided - KgCo2e',
'Number of products sold'=> 'Units Sold - Total',
'Number of client organisation serviced'=> 'Client organisations - Total',
'Number of Client Individual Unknown (B2C end beneficiaries Unknown)'=> 'Client Individuals - Unknown',
'Number of Client Individual female (B2C female end beneficiaries)'=> 'Client Individuals - Female',
'Number of Client Individuals  (Number of B2C end beneficiaries)'=> 'Client Individuals - Total',
'Amount of energy savings over the lifetime of the product for those products that were sold/installed by the organization during the reporting period [Number of units of product installed'=> 'Energy - Amount of energy savings over the lifetime of the product for those products that were sold/installed by the organization during the reporting period [Number of units of product installed - KwH',
'Total amount of greenhouse gas (GHG) emissions avoided due to the installations in the reporting period'=> 'GHG avoided - Total amount of greenhouse gas (GHG) emissions avoided due to the installations in the reporting period - KgCo2e',
'Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'Number of stitching units intalled in the reporting period'=> 'Units Sold - Number of stitching units intalled in the reporting period',
'Number of weaving units,intalled in the reporting period'=> 'Units Sold - Number of weaving units,intalled in the reporting period',
'Geographic distribution- BH'=> 'Geo - Bihar',
'Geographic distribution- UP'=> 'Geo - Uttar Pradesh',
'Geo MP'=> 'Geo - Madhya Pradesh',
'Geo OD'=> 'Geo - Odisha',
'Geo ML'=> 'Geo - Meghalaya',
'Geo RJ'=> 'Geo - Rajasthan',
'Geo AP'=> 'Geo - Andhra Pradesh',
'Geo KA'=> 'Geo - Karnataka',
'Revenue Increase for End usersa'=> 'Income Increase - Revenue Increase for End usersa',
'Milk Yield Increase'=> 'Yield Increase - Milk Yield Increase',
'Litres of Water Saved'=> 'Water conserved - Total - Ltrs',
'Geo-MP'=> 'Geo - Madhya Pradesh',
'Geo-OD'=> 'Geo - Orissa',
'Geo-AS'=> 'Geo - Assam',
'Geo-JH'=> 'Geo - Jharkhand',
'Number of Client Individuals (Total)'=> 'Client Individuals - Total',
'Amount of energy savings'=> 'Energy - Amount of energy savings - KwH',
'Total amount of GHG emissions avoided'=> 'GHG avoided - Total - KgCo2e',
'Number of products sold'=> 'Units Sold - Total',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of Client Individuals Unknown'=> 'Client Individuals - Unknown',
'Number of Client Individuals female'=> 'Client Individuals - Female',
'Geographic distribution- AS'=> 'Geo - Assam',
'Geographic distribution-OD'=> 'Geo - Orissa',
'Geographic distribution-CG'=> 'Geo - Chhattisgarh',
'Geographic distribution- JH'=> 'Geo - Jharkhand',
'Geographic distribution - KA'=> 'Geo - Karnataka',
'Amount of energy savings over the lifetime of the product for those products that were sold/installed by the organisation during the reporting period [Number of units of product installed in the repor'=> 'Energy - Amount of energy savings over the lifetime of the product for those products that were sold/installed by the organisation during the reporting period [Number of units of product installed in the repor - KwH',
'Total amount of greenhouse gas (GHG) emissions avoided due to the installations in the reporting period'=> 'GHG avoided - Total amount of greenhouse gas (GHG) emissions avoided due to the installations in the reporting period - KgCo2e',
'Number of units of the product sold in the reporting period'=> 'Units Sold - Total',
'Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'Total number of paid full time and part time jobs created directly by the company.'=> 'Direct Jobs - Total number of paid full time and part time jobs created directly by the company.',
'Organisations partnered with for the trials like hospitals, PHCs, clinics'=> 'Partnerships - Organisations partnered with for testing and trials',
'Number of user trials conducted'=> 'User trials - Total',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of products sold (FlexmoComposite)'=> 'Units Sold - FlexmoComposite',
'Number of products sold (FlexmoClassic)'=> 'Units Sold - FlexmoClassic',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Geographic distribution-State1'=> 'Geo - ',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of end beneficiaries  (FlexmoComposite)'=> 'Patients - FlexmoComposite',
'Number of end beneficiaries  (FlexmoClassic)'=> 'Patients - FlexmoClassic',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of intermediaries impacted'=> 'Individuals Trained - Total',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of products sold (Keyar)'=> 'Units Sold - Keyar',
'Number of products sold (Daksh)'=> 'Units Sold - Daksh',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of end beneficiaries'=> 'End Beneficiaries - Number of end beneficiaries',
'Number of end beneficiaries  (Daksh)'=> 'Client  Individuals - Daksh',
'Number of end beneficiaries  (Keyar)'=> 'Client  Individuals - Keyar',
'Geographic distribution-State1'=> 'Geo - ',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of products sold (NeoCushion)'=> 'Units Sold - NeoCushion',
'Number of products sold (NeoBolt)'=> 'Units Sold - NeoBolt',
'Number of products sold (NeoFly)'=> 'Units Sold - NeoFly',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Geographic distribution-State1*'=> 'Geo - ',
' Number of end beneficiaries'=> 'End Beneficiaries -  Number of end beneficiaries',
'Number of end beneficiaries  (NeoFly)'=> 'Client Individuals - NeoFly',
'Number of end beneficiaries  (NeoBolt)'=> 'Client Individuals - Neobolt',
'Number of end beneficiaries  (NeoCushion)'=> 'Client Individuals - Neocushion',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted'=> 'User trials - Total',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of direct jobs created'=> 'Direct Jobs  - Number of direct jobs created',
'Number of user trials conducted  (Kadam)'=> 'User trials - Kadam',
'Number of end beneficiaries'=> 'End Beneficiaries - Number of end beneficiaries',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of products sold (NeuroTouch)'=> 'Units Sold - NeuroTouch',
'Geo-RAJ'=> 'Geo - Rajasthan',
'Smallholder Supplier Individuals: Smallholder No of farmers BR has procured from'=> 'Supplier Individuals - Farmers : Smallholders',
'Client Individuals: Smallholder: Total No of farmers in network receiving agri advisory inputs from BR'=> 'Client Individuals - Farmers: Smallholders',
'Land Indirectly Controlled: Sustainably Managed: Area being monitored via drones through hyperspectral imaging (acres)'=> 'Land sustainably managed  - Indirectly controlled : Area being monitored via drones through hyperspectral imaging - Acres',
'Water saved'=> 'Water conserved - Total - Ltrs',
'Client Individuals: Total No of Smallholder clients'=> 'Client Individuals - Farmers : Smallholders',
'Geo-PB'=> 'Geo - Punjab',
'Total amount of energy saved by the products/services during the reporting period'=> 'Energy - Total amount of energy saved by the products/services during the reporting period - KwH',
'Total no of units sold/installed of the product or service'=> 'Units Sold - Total',
'Area of land indirectly controlled by the organization and under sustainable cultivation or sustainable stewardship.'=> 'Land sustainably managed - Indirectly controlled : sustainable cultivation/stewardship - Acres',
'Number of enterprises or organisations that were clients of the organization during the reporting period'=> 'Client organisations - Total',
'Increase in ground water level'=> 'Water recharged - Increase in ground water level - Ltrs',
'Water savings'=> 'Water conserved - Total - Ltrs',
'Number of app users'=> 'Usage - Number of app users',
'Number of client organisations Total number of dug wells/pumping wells monitored in a month in implementaion versus control villages'=> 'Client organisations - Total',
'Number of groundwater wells being monitored'=> 'Water monitored - Groundwells - Nos',
'Number of states Ekatvam has implemented their solution in.'=> 'Geo - ',
'Number of villages being impacted'=> 'Geo covered - villages',
'Number of end beneficiaries from Bihar'=> 'Geo - Bihar',
'Number of farmers advised on water saving practises'=> 'Client Individuals - Farmers : Number of farmers advised on water saving practises',
'Geo - Kerala'=> 'Geo - Kerala',
'Geo - Assam'=> 'Geo - Assam',
'Geo - RJ'=> 'Geo - Rajasthan',
'Geo - MP'=> 'Geo - Madhya Pradesh',
'Geo- Del'=> 'Geo - Delhi',
'Geo-GJ'=> 'Geo - Gujarat',
'Client Individuals: Smallholder: Total No of smallholder farmers using/receiving Kritsnam services or products (No of end beneficiaries)'=> 'Client Individuals - Farmers : Smallholders',
'Amount of water saved (liters)'=> 'Water conserved - Total - Ltrs',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Geo-AP'=> 'Geo - Andhra Pradesh',
'Geo-HR'=> 'Geo - Haryana',
'Geo-UK'=> 'Geo - Uttar Pradesh',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-MAHA'=> 'Geo - Maharashtra',
'Geo-TS'=> 'Geo - Telengana',
'Client organization'=> 'Client organisations - Total',
'No. of farmers reached in Karnataka'=> 'Geo - Karnataka',
'No. of farmers reached in Tamil Nadu'=> 'Geo - Tamil Nadu',
'No. of smallholder farmers reached through FPOs'=> 'Client Individuals - Farmers : No. of smallholder farmers reached through FPOs',
'No. of FPO partnerships for procurement'=> 'Partnerships - No. of FPO partnerships for procurement',
'No. of smallholder farmers from whom they buy 90% of produce'=> 'Client Individuals - Farmers : No. of smallholder farmers from whom they buy 90% of produce',
'Total number of FPOs benefitted'=> 'Client organisations - FPO',
'Land sustainably managed'=> 'Land sustainably managed - Total - Acres',
'Number of farmers certified organic (NPOP)'=> 'Client Individuals - Farmers : Number of farmers certified organic (NPOP)',
'Number of smallholder farmer suppliers via FPO partnerships'=> 'Supplier Individuals - Farmers : Number of smallholder farmer suppliers via FPO partnerships',
'Number of beneficiaries from West Bengal'=> 'Geo - West Bengal',
'Number of beneficiaries in Assam'=> 'Geo - Assam',
'Number of beneficiaries in Chattisgarh'=> 'Geo - Chhatisgarh',
'Geo-Rural'=> 'Geo - Rural',
'Geo-Urban'=> 'Geo - Urban',
'Geo-KA'=> 'Geo - Karnataka',
'Geo- MH'=> 'Geo - Maharashtra',
'Total client organizations'=> 'Client organisations - Total',
'Total individuals trained'=> 'Individuals trained - Total individuals trained',
'Total no. of borewells which saw an increase in water recharged'=> 'Water recharged - Total no. of borewells which saw an increase in water recharged - Nos',
'Amt of water recharged through borewell installations'=> 'Water recharged - Amt of water recharged through borewell installations - Ltrs',
'Avg increase in revenue for small businesses'=> 'Income Increase - Avg increase in revenue for small businesses',
'Number of small businesses impacted'=> 'Client organisations - Small businesses',
'Geo-AS'=> 'Geo - Assam',
'Geo-MN'=> 'Geo - Manipur',
'Geo-MZ'=> 'Geo - Mizoram',
'Geo-MH'=> 'Geo - Maharashtra',
'Geo-OD'=> 'Geo - Orissa',
'Geo-RJ'=> 'Geo - Rajasthan ',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Geo-AS'=> 'Geo - Assam',
'Geo-KA'=> 'Geo - Karnataka',
'Number of products sold'=> 'Units Sold - Total',
'Amount of energy savings (over the lifetime of the product for those products that were sold/installed)'=> 'Energy - Amount of energy savings (over the lifetime of the product for those products that were sold/installed) - KwH',
'Total amount of potential  lifetime greenhouse gas (GHG) emissions avoided'=> 'GHG avoided - Total amount of potential lifetime greenhouse gas (GHG) emissions avoided - KgCo2e',
'Number of client organisation serviced (unique)'=> 'Client organisations - New',
'Number of Client Individual Unknown (B2C end beneficiaries Unknown)'=> 'Client Individuals - Unknown',
'Number of Client Individual female (B2C female end beneficiaries)'=> 'Client Individuals - Female',
'Total Number of Client Individuals  (Number of B2C end beneficiaries)'=> 'Client Individuals - Total',
'Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'No of unique individual trained (women)'=> 'Individuals trained - Female',
'No of unique individual trained (all gender)'=> 'Individuals trained - Total',
'Total amount of greenhouse gas (GHG) emissions avoided in the  reporting period'=> 'GHG avoided - Total amount of greenhouse gas (GHG) emissions avoided in the  reporting period - KgCo2e',
'Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'Geographic distribution- BH'=> 'Geo - Bihar',
'Geographic distribution- UP'=> 'Geo - Uttar Pradesh',
'Water conserved'=> 'Water conserved - Total - Ltrs',
'Energy Savings'=> 'Energy - Energy Savings - KwH',
'Green house gas emissions avoided'=> 'GHG avoided - Total - KgCo2e',
'Geo-MP'=> 'Geo - Madhya Pradesh',
'Geo- MH'=> 'Geo - Maharashtra',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Geo-AP'=> 'Geo - Andhra Pradesh',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-OD'=> 'Geo - Orissa',
'Geo-AS'=> 'Geo - Assam',
'Geo-JH'=> 'Geo - Jharkhand',
'Total amount of GHG emissions avoided'=> 'GHG avoided - Total - KgCo2e',
'Total amount of GHG emissions avoided'=> 'GHG avoided - Total - KgCo2e',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of client enterprises unique  serviced'=> 'Client organisations - New',
'Number of Client Individuals Unknown'=> 'Client Individuals - Unknown',
'Number of Client Individuals female'=> 'Client Individuals - Female',
'Number of Client Individuals (Total)'=> 'Client Individuals - Total',
'Number of units of the product installed in the reporting period'=> 'Units Sold - Total',
'Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'Target Stakeholder Geography - Any other state'=> 'Geo - ',
'Target Stakeholder Geography - PJ'=> 'Geo - Punjab',
'Target Stakeholder Geography - UP'=> 'Geo - Uttar Pradesh',
'Target Stakeholder Geography - UK'=> 'Geo - Uttarakhand',
'Target Stakeholder Geography - MH'=> 'Geo - Maharashtra',
'Target Stakeholder Geography - HP'=> 'Geo - Himachal Pradesh',
'Geo-MS'=> 'Geo - Maharashtra',
'Geo-RS'=> 'Geo - Rajasthan',
'GHG Emission Reduction'=> 'GHG avoided - Total - KgCo2e',
'Waste to Wealth Creation'=> 'Waste Recovered - Waste to Wealth - Kgs',
'Total amount of greenhouse gas (GHG) emissions avoided due to the installations in the reporting period'=> 'GHG avoided - Total amount of greenhouse gas (GHG) emissions avoided due to the installations in the reporting period - KgCo2e',
'Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'Number of units of the product sold in the reporting period'=> 'Units Sold - Total',
'Geographic distribution - Any Other states'=> 'Geo - ',
'Geographic distribution - MP'=> 'Geo - Madhya Pradesh',
'Geographic distribution - KA'=> 'Geo - Karnataka',
'Geographic distribution- JH'=> 'Geo - Jharkhand',
'Geographic distribution-CG'=> 'Geo - Chhattisgarh',
'Geographic distribution-OD'=> 'Geo - Orissa',
'Geographic distribution- North East'=> 'Geo - ',
'Avg income increase of franchises'=> 'Income Increase - Avg income increase of franchises',
'Avg income increase for drivers'=> 'Income Increase - Avg income increase for drivers',
'Green house gas emission avoided or reduced'=> 'GHG avoided - Total - KgCo2e',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Increase in Farmer Income'=> 'Income Increase - Increase in Farmer Income',
'GHG Emission Reduction'=> 'GHG avoided - Total - KgCo2e',
'Life Transformed'=> 'End Beneficiaries  - Life Transformed',
'Income increase'=> 'Income Increase - Income increase',
'Carbon savings'=> 'GHG reduced - Carbon savings - KgCo2e',
'Target Stakeholder Geography'=> 'Geo - ',
'Organisations partnered with'=> 'Partnerships - Total',
'Number of user trials conducted'=> 'User trials - Total',
'Geographic distribution - Goa'=> 'Geo - Goa',
'Geographic distribution - Chandigarh'=> 'Geo - Chandigarh',
'Geographic distribution - Assam'=> 'Geo - Assam',
'Geographic distribution- Arunachal Pradesh'=> 'Geo - Arunachal Pradesh',
'Geographic distribution- Chattisgarh'=> 'Geo - Chhattisgarh',
'Geographic distribution- Meghalaya'=> 'Geo - Meghalaya',
'Geographic distribution- Gujarat'=> 'Geo - Gujarat',
'Geographic distribution- Rajasthan'=> 'Geo - Rajasthan',
'Geographic distribution- Tamil Nadu'=> 'Geo - Tamil Nadu',
'Geographic distribution- West Bengal'=> 'Geo - West Bengal',
'Geographic distribution- Giyon, Ethiopia'=> 'Geo - Giyon, Ethiopia',
'Geographic distribution- Ghana'=> 'Geo - Ghana',
'Geographic distribution- Nigeria'=> 'Geo - Nigeria',
'Geographic distribution- Madhya Pradesh'=> 'Geo - Madhya Pradesh',
'Geographic distribution- Kerala'=> 'Geo - Kerala',
'Geographic distribution- Andhra Pradesh'=> 'Geo - Andhra Pradesh',
'Geographic distribution - Eastern Cape, South Africa'=> 'Geo - Eastern Cape, South Africa',
'Number of intermediaries impacted'=> 'Individuals trained - Total',
'Number of user trials conducted'=> 'User trials - Total',
'Number of Integrated Product sold (KEYAR+DAKSH)'=> 'Units Sold - Keyar + Daksh',
'Number of products sold (Keyar)'=> 'Units Sold - Keyar',
'Number of products sold (Daksh)'=> 'Units Sold - Daksh',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Geographic distribution- Maharastra'=> 'Geo - Maharashtra',
'Geographic distribution- Karnataka'=> 'Geo - Karnataka',
'Geographic distribution- Delhi'=> 'Geo - Delhi',
'Number of end beneficiaries  (Keyar)'=> 'Client  Individuals - Keyar',
'Number of end beneficiaries  (Daksh)'=> 'Client  Individuals - Daksh',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of end beneficiaries (Unknown)'=> 'End Beneficiaries - Number of end beneficiaries (Unknown)',
'Number of female end beneficiaries'=> 'End Beneficiaries - Number of female end beneficiaries',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'Number of user trials conducted'=> 'User trials - Total',
'Number of lives of unknown gender reached'=> 'End Beneficiaries - Number of lives of unknown gender reached',
'Number of male lives reached'=> 'End Beneficiaries - Number of male lives reached',
'Number of female lives reached'=> 'End Beneficiaries - Number of female lives reached',
'Total individual lives reached'=> 'End Beneficiaries - Total individual lives reached',
'Total government clients'=> 'Client organisations - Government',
'Total private client organisations - corporate and other clients'=> 'Client organisations - Private : corporate and other clients',
'Total private client organisations - affordable access clinics'=> 'Client organisations - Private : affordable accesss clinics',
'Total client organisations'=> 'Client organisations - Total',
'Number of products sold (Velox)'=> 'Units Sold - Velox',
'Number of user trials conducted  (Kadam)'=> 'User trials - Kadam',
'Number of products sold (NEURO TOUCH)'=> 'Units Sold - NeuroTouch',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Number of beneficiaries in Tamil Nadu'=> 'Geo - Tamil Nadu',
'Client Individuals: Smallholder'=> 'Client Individuals - Farmers : Smallholders',
'Water saved'=> 'Water conserved - Total - Ltrs',
'Land sustainably managed - Acres under BAMINI nursery'=> 'Land sustainably managed - Acres under Bamini nursery - Acres',
'Litres of water saved'=> 'Water conserved - Total - Ltrs',
'Land Indirectly Controlled: Sustainably Managed: Area being monitored via drones through hyperspectral imaging (acres)'=> 'Land sustainably managed  - Indirectly controlled : Area being monitored via drones through hyperspectral imaging - Acres',
'Client Individuals: Smallholder: Total No of farmers in network receiving agri advisory inputs from BR'=> 'Client Individuals - Farmers: Smallholders',
'Smallholder Supplier Individuals: Smallholder No of farmers BR has procured from'=> 'Supplier Individuals - Farmers : Smallholders',
'Geo-RAJ'=> 'Geo - Rajasthan',
'Geo - Jhakhand'=> 'Geo - Jharkhand',
'Geo - Maharashtra'=> 'Geo - Maharashtra',
'Geo - Telangana'=> 'Geo - Telangana ',
'Geo - Uttar Pradesh'=> 'Geo - Uttar Pradesh',
'Geo - MP'=> 'Geo - Madhya Pradesh',
'Litres of water saved'=> 'Water conserved - Total - Ltrs',
'Number of enterprises or organisations that were clients of the organization during the reporting period'=> 'Client organisations - Total',
'Area of land indirectly controlled by the organization and under sustainable cultivation or sustainable stewardship.'=> 'Land sustainably managed - Indirectly controlled : sustainable cultivation/stewardship - Acres',
'Total amount of energy saved by the products/services during the reporting period'=> 'Energy - Total amount of energy saved by the products/services during the reporting period - KwH',
'Geo-PB'=> 'Geo - Punjab',
'Client Individuals: Total No of Smallholder clients'=> 'Client Individuals - Farmers : Smallholders',
'Number of villages being impacted'=> 'Geo covered',
'Number of states Ekatvam has implemented their solution in.'=> 'Geo - ',
'Number of groundwater wells being monitored'=> 'Water monitored - Groundwells - Nos',
'Number of client organisations Total number of dug wells/pumping wells monitored in a month in implementaion versus control villages'=> 'Client organisations - Total',
'Number of app users'=> 'Usage - Number of app users',
'Water savings'=> 'Water conserved - Total - Nos',
'Increase in ground water level'=> 'Water recharged - Increase in ground water level - Ltrs',
'Geo - Rajasthan'=> 'Geo - Rajasthan',
'Greenhouse Gas Emissions Avoided'=> 'GHG avoided - Total - KgCo2e',
'Litres of water monitored'=> 'Water monitored - Total - Ltrs',
'Client organization'=> 'Client organisations - Total',
'Geo-TN'=> 'Geo - Tamil Nadu',
'Geo-HR'=> 'Geo - Haryana',
'Geo-AP'=> 'Geo - Andhra Pradesh',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Amount of water saved (liters)'=> 'Water conserved - Total - Ltrs',
'Client Individuals: Smallholder: Total No of smallholder farmers using/receiving Kritsnam services or products (No of end beneficiaries)'=> 'Client Individuals - Farmers : Smallholders',
'Geo-GJ'=> 'Geo - Gujarat',
'Geo- Del'=> 'Geo - Delhi',
'Geo - MP'=> 'Geo - Madhya Pradesh',
'Geo - RJ'=> 'Geo - Rajasthan',
'Geo - Assam'=> 'Geo - Assam',
'Geo - Kerala'=> 'Geo - Kerala',
'Land sustainable managed: growing chemical free produce'=> 'Land sustainably managed - growing chemical free produce - Acres',
'No. of smallholder farmers from whom they buy 90% of produce'=> 'Client Individuals - Farmers : No. of smallholder farmers from whom they buy 90% of produce',
'No. of FPO partnerships for procurement'=> 'Partnerships - No. of FPO partnerships for procurement',
'No. of smallholder farmers reached through FPOs'=> 'Client Individuals - Farmers : No. of smallholder farmers reached through FPOs',
'No. of farmers reached in Tamil Nadu'=> 'Geo - Tamil Nadu',
'No. of farmers reached in Karnataka'=> 'Geo - Karnataka',
'Volumes of potatoes sorted'=> 'Usage - Volumes of potatoes sorted',
'Volumes of onion processed'=> 'Usage - Volumes of onion processed',
'Total number of FPOs benefitted'=> 'Client organisations - FPO',
'Land under sustainable cultivation'=> 'Land sustainably managed - Total - Acres',
'Number of beneficiaries in Chattisgarh'=> 'Geo - Chhatisgarh',
'Number of beneficiaries in Assam'=> 'Geo - Assam',
'Number of beneficiaries from West Bengal'=> 'Geo - West Bengal',
'Number of smallholder farmer suppliers via FPO partnerships'=> 'Supplier Individuals - Farmers : Number of smallholder farmer suppliers via FPO partnerships',
'Number of farmers certified organic (NPOP)'=> 'Client Individuals - Farmers : Number of farmers certified organic (NPOP)',
'Geo- Orissa'=> 'Geo - Orissa',
'Amt of water recharged through borewell installations'=> 'Water recharged - Amt of water recharged through borewell installations - Ltrs',
'Total no. of borewells which saw an increase in water recharged'=> 'Water conserved - Total no. of borewells which saw an increase in water recharged - Nos',
'Total individuals trained'=> 'Individuals trained - Total individuals trained',
'Total client organizations'=> 'Client organisations - Total',
'Geo- MH'=> 'Geo - Maharashtra',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-Urban'=> 'Geo - Rural',
'Geo-Rural'=> 'Geo - Urban',
'Avg usage per month'=> 'Usage - Avg usage per month',
'Average income of Kirana hosts'=> 'Income  - Average income of Kirana hosts',
'Number of Kirana hosts'=> 'Client Individuals - Kirana hosts',
'Geo-OD'=> 'Geo - Orissa',
'Total Number of Client Individuals'=> 'Client Individuals - Total',
'Number of Client Individual female'=> 'Client Individuals - Female',
'Number of Client Individual Unknown'=> 'Client Individuals - Unknown',
'Number of client organisation serviced (unique)'=> 'Client organisations - New',
'Total amount of potential  lifetime greenhouse gas (GHG) emissions avoided'=> 'GHG avoided - Total amount of potential lifetime greenhouse gas (GHG) emissions avoided - KgCo2e',
'Number of products sold'=> 'Units Sold - Total',
'Geo-KA'=> 'Geo - Karnataka',
'Geo-UP'=> 'Geo - Uttar Pradesh',
'Geo-MH'=> 'Geo - Maharashtra',
'Geo-MN'=> 'Geo - Manipur',
'Geo-AS'=> 'Geo - Assam',
'Other geography sales'=> 'Geo - ',
'Bihar Sales'=> 'Geo Sales - Bihar Sales',
'Uttar Pradhesh Sales'=> 'Geo Sales - Uttar Pradhesh Sales',
'GHG emission avoided in reporting period (Tonnes CO2 eq)'=> 'GHG avoided - Total - Tonnes Co2 eq',
'Unique individuals trained (All gender)'=> 'Individuals trained - Unique individuals trained (All gender)',
'Unique women trained'=> 'Individuals trained - Unique women trained',
'Distinct new cluster/SHG/other group serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'Increase in milk yield'=> 'Yield Increase - Increase in milk yield',
'Volume of water conserved'=> 'Water conserved - Total - Ltrs',
'Total Number of cattle fed'=> 'Others - Total Number of cattle fed',
'GG Emissions avoided'=> 'GHG avoided - Total - KgCo2e',
'Number of Client Individuals (Total)'=> 'Client Individuals - Total',
'Number of Client Individuals female'=> 'Client Individuals - Female',
'Number of Client Individuals Unknown'=> 'Client Individuals - Unknown',
'Number of client enterprises serviced (Unique)'=> 'Client organisations - New',
'Total amount of GHG emissions avoided'=> 'GHG avoided - Total - KgCo2e',
'Geo-JH'=> 'Geo - Jharkhand',
'Geo-AS'=> 'Geo - Assam',
'Geo-OD'=> 'Geo - Orissa',
'Geo-KA'=> 'Geo - Karnataka',
'Geo- MH'=> 'Geo - Maharashtra',
'Geo-MP'=> 'Geo - Madhya Pradesh',
'Other states sales'=> 'Geo Sales - Other states sales',
'Punjab Sales'=> 'Geo Sales - We can now make timely interventions to identify areas where they can scale their impact, contributing to their growth and success.',
'Uttar Pradhesh sales'=> 'Geo Sales - Uttar Pradhesh Sales',
'Uttarakhand Sales'=> 'Geo Sales - Uttarakhand',
'Maharasthra Sales'=> 'Geo Sales - Maharasthra',
'Himachal Pradhesh sales'=> 'Geo Sales - Himachal Pradhesh',
'Distinct new FPO/SHG or other groups serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'Number of units sold in reporting period'=> 'Units Sold - Total',
'Waste to Wealth Creation'=> 'Waste Recovered - Waste to Wealth - Kgs',
'GHG Emission Reduction'=> 'GHG avoided - Total - KgCo2e',
'Any other state sales'=> 'Geo Sales - Any other state',
'Madhya Pradhesh Sales'=> 'Geo Sales - Madhya Pradhesh',
'Karnataka Sales'=> 'Geo Sales - Karnataka',
'Jharkhand Sales'=> 'Geo Sales - Jharkhand',
'Chattisgarh Sales'=> 'Geo Sales - Chattisgarh',
'Odisha Sales'=> 'Geo Sales - Odisha',
'North East sales - Geographic distribution'=> 'Geo Sales - North East sales',
'Number of products sold in reporting period'=> 'Units Sold - Total',
'Distinct new FPO/NGO/SHG etc groups serviced'=> 'Client organisations - Number of distinct new FPOs / NGOs / Cooperatives / SHG serviced',
'Lifetime GHG emission savings in tonnes of CO2 eq for products sold in reporting period'=> 'GHG reduced - Lifetime GHG emission savings in tonnes of CO2 eq for products sold in reporting period - Tonnes Co2 eq',
'Geography'=> 'Geo - ',
'Increase in farmer income'=> 'Income Increase - Increase in Farmer Income',
'GHG Emission reduction'=> 'GHG avoided - Total - KgCo2e',
'Life Transformed'=> 'End Beneficiaries  - Life Transformed',
'Number of user trials conducted'=> 'User trials - Total',
'Organisations partnered with'=> 'Partnerships - Total',
'Target Stakeholder Geography'=> 'Geo - ',
'No. of end beneficiaries through counselling'=> 'End Beneficiaries - No. of end beneficiaries through counselling',
'No. of end beneficiaries through workshops'=> 'End Beneficiaries - No. of end beneficiaries through workshops',
'Number of counselling sessions'=> 'Usage - Number of counselling sessions',
'Number of workshops and webinars'=> 'Usage - Number of workshops and webinars',
'No. of partnerships built (CSR/School/Others)'=> 'Partnerships - No. of partnerships built (CSR/School/Others)',
'No. of childless couples provided counseling (IVF)'=> 'Usage - No. of childless couples provided counseling (IVF)',
'Number of modules added'=> 'Usage - Number of modules added',
'Total geography reached (cities/pincodes)'=> 'Geo covered - cities/pincodes',
'No of idrect jobs created'=> 'Direct Jobs - No of idrect jobs created',
'No. of physical/virtual events'=> 'Events - No. of physical/virtual events',
'Plastic waste diverted'=> 'Waste Avoided - Plastic waste diverted - Kgs',
'No. of Pads sold'=> 'Units Sold - Pads',
'Geographic distribution - Haryana'=> 'Geo - Haryana',
'Geographic distribution - Bihar'=> 'Geo - Bihar',
'Number of female end beneficiaries'=> 'End Beneficiaries - Number of female end beneficiaries',
'Number of end beneficiaries (Unknown)'=> 'End Beneficiaries - Number of end beneficiaries (Unknown)',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of end beneficiaries  (Daksh)'=> 'Client  Individuals - Daksh',
'Number of end beneficiaries  (Keyar)'=> 'Client  Individuals - Keyar',
'Geographic distribution- Delhi'=> 'Geo - Delhi',
'Geographic distribution- Karnataka'=> 'Geo - Karnataka',
'Geographic distribution- Maharastra'=> 'Geo - Maharashtra',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of products sold (Daksh)'=> 'Units Sold - Daksh',
'Number of products sold (Keyar)'=> 'Units Sold - Keyar',
'Number of Integrated Product sold (KEYAR+DAKSH)'=> 'Units Sold - Keyar + Daksh',
'Number of user trials conducted'=> 'User trials - Total',
'Number of intermediaries impacted'=> 'Individuals trained - Total',
'Geographic distribution - Eastern Cape, South Africa'=> 'Geo - Eastern Cape, South Africa',
'Geographic distribution- Andhra Pradesh'=> 'Geo - Andhra Pradesh',
'Geographic distribution- Kerala'=> 'Geo - Kerala',
'Geographic distribution- Madhya Pradesh'=> 'Geo - Madhya Pradesh',
'Geographic distribution- Nigeria'=> 'Geo - Nigeria',
'Geographic distribution- Ghana'=> 'Geo - Ghana',
'Geographic distribution- Giyon, Ethiopia'=> 'Geo - Giyon, Ethiopia',
'Geographic distribution- West Bengal'=> 'Geo - West Bengal',
'Geographic distribution- Tamil Nadu'=> 'Geo - Tamil Nadu',
'Geographic distribution- Rajasthan'=> 'Geo - Rajasthan',
'Geographic distribution- Gujarat'=> 'Geo - Gujarat',
'Geographic distribution- Meghalaya'=> 'Geo - Meghalaya',
'Geographic distribution- Chattisgarh'=> 'Geo - Chhattisgarh',
'Geographic distribution- Arunachal Pradesh'=> 'Geo - Arunachal Pradesh',
'Geographic distribution - Assam'=> 'Geo - Assam',
'Geographic distribution - Chandigarh'=> 'Geo - Chandigarh',
'Geographic distribution - Goa'=> 'Geo - Goa',
'Geographies Covered'=> 'Geo covered -',
'Material recycled'=> 'Waste Recovered - Material recycled - Kgs',
'Landfill space saved ( 1pad=0.5 ltr)'=> 'Landfill - Landfill space saved ( 1pad=0.5 ltr)',
'Carbon conserved (1 pad = 5.3 kg co2 )'=> 'GHG reduced - Carbon conserved (1 pad = 5.3 kg co2 ) - KgCo2e',
'No. of direct women beneficiaries'=> 'End Beneficiaries - No. of direct women beneficiaries',
'No. of physical/ virtual events'=> 'Usage - No. of physical/ virtual events',
'Sanitary napkin waste collected (kg)'=> 'Waste Collected - Sanitary napkin waste collected  - Kgs',
'No. MHM (menstruation hygiene management) services provided'=> 'Units Sold - No. MHM (menstruation hygiene management) services provided',
'No. of non english speakers getting access to SRH services'=> 'End Beneficiaries - No. of non english speakers getting access to SRH services',
'Amount of IP generated for gynecologist assistance for  consultations'=> 'Usage - Amount of IP generated for gynecologist assistance for  consultations',
'No. of women end beneficiaries'=> 'End Beneficiaries - No. of women end beneficiaries',
'No. of gynecologist consultations'=> 'Usage - No. of gynecologist consultations',
'Number of user trials conducted'=> 'User trials - Total',
'Number of institutions partnered with for R&D'=> 'Partnerships - R & D',
'No. of experts/therapists'=> 'Usage - No. of experts/therapists',
'Total geography reached'=> 'Geo covered ',
'No. of end beneficiaries- teleconsultation'=> 'End Beneficiaries - No. of end beneficiaries- teleconsultation',
'No. of end beneficiaries - chatbot'=> 'End Beneficiaries - No. of end beneficiaries - chatbot',
'Total client organisations'=> 'Client organisations - Total',
'Total private client organisations - affordable access clinics'=> 'Client organisations - Private : affordable accesss clinics',
'Total private client organisations - corporate and other clients'=> 'Client organisations - Private : corporate and other clients',
'Total government clients'=> 'Client organisations - Government',
'Total individual lives reached'=> 'End Beneficiaries - Total individual lives reached',
'Number of female lives reached'=> 'End Beneficiaries - Number of female lives reached',
'Number of male lives reached'=> 'End Beneficiaries - Number of male lives reached',
'Number of lives of unknown gender reached'=> 'End Beneficiaries - Number of lives of unknown gender reached',
'Total geography reached'=> 'Geo covered ',
'No. of health counselling calls offered'=> 'Usage - No. of health counselling calls offered',
'No of app monthly app downloads'=> 'Usage - No of app monthly app downloads',
'No of Monthly active users'=> 'Usage - No of Monthly active users',
'No. of physical/ virtual events conducted'=> 'Usage - No. of physical/ virtual events conducted',
'No of beneficiaries from workshops'=> 'End Beneficiaries - No of beneficiaries from workshops',
'No. of partnerships built'=> 'Partnerships - Total',
'No. of free health counselling calls'=> 'Usage - No. of free health counselling calls',
'No. of consultations'=> 'Usage - No. of consultations',
'No. of physical/ virtual events (partner led events)'=> 'Usage - No. of physical/ virtual events (partner led events)',
'New Activated Users'=> 'Usage - New Activated Users',
'No. of end beneficiaries- Total Activated Users'=> 'End Beneficiaries - No. of end beneficiaries- Total Activated Users',
'Number of end beneficiaries - Distinct new patients'=> 'Patients - Distinct new patients',
'Number of client enterprises serviced'=> 'Client organisations - Total',
'Number of government client enterprises serviced'=> 'Client organisations - Government',
'Number of products sold (NEURO TOUCH)'=> 'Units Sold - NeuroTouch',
'Number of user trials conducted  (Kadam)'=> 'User trials - Kadam',
'Number of products sold (Velox)'=> 'Units Sold - Velox',
'No. of beds occupied'=> 'Usage - No. of beds occupied',
'No. of beds listed'=> 'Usage - No. of beds listed',
'Number of client enterprises'=> 'Client organisations - Total',
'Tyre rCB recycled (Kgs)'=> 'Waste Recovered - Tyre rCB recycled - Kgs',
'C&D Waste recycled - Marble & Quary(kgs)'=> 'Waste Recovered - Tyre rCB recycled - Kgs',
'GHG Emission Reduction (kgCO2e)'=> 'GHG reduced - Total - KgCo2e',
'No of client enterprises'=> 'Client organisations - Total',
'Increase in farmer income (INR)'=> 'Income Increase - Increase in farmer income (INR)',
'No. of units sold'=> 'Units Sold - Total',
'Amount of agricultural waste recycled (kg)'=> 'Waste Recovered - C&D Waste recycled : Marble & Quary - Kgs',
'Carbon Capture (KgCo2e)'=> 'GHG reduced - Carbon Capture (KgCo2e) - KgCo2e',
'GHG Emission reduction (KgCo2e)'=> 'GHG reduced - Total - KgCo2e',
'Number of client enterprises'=> 'Client organisations - Total',
'Number of units sold'=> 'Units Sold - Total',
'Amount of waste plastic/ recycled collecting (kg)'=> 'Waste Recovered - Amount of waste plastic/ recycled collecting - Kgs',
'Carbon Capture (KgCo2e)'=> 'GHG reduced - Carbon Capture (KgCo2e) - KgCo2e',
'GHG Emission Reduction (KgCo2e)'=> 'GHG reduced - Total - KgCo2e',
'States covered'=> 'Geo covered - States',
'No. of Partners onboarded (Diagnostic/ Hospitals) PRIVATE'=> 'Partnerships - Private',
'No. of Partners onboarded (Diagnostic/ Hospitals) GOVT'=> 'Partnerships - Government',
'No. of Doctors onboarded'=> 'Usage - No. of Doctors onboarded',
'No. of Health Camps organised'=> 'Usage - No. of Health Camps organised',
'No. of Awareness Camps organised'=> 'Usage - No. of Awareness Camps organised',
'No. of door step agri input provided'=> 'Usage - No. of door step agri input provided',
'Increase in income for the farmer in the season'=> 'Income Increase - Increase in income for the farmer in the season',
'No. of farm land mapped (in hectares)'=> 'Usage - No. of farm land mapped (in hectares)',
'No. of appointment for technical advisory registered on app'=> 'Usage - No. of appointment for technical advisory registered on app',
'No. of farmers registered on apps'=> 'Usage - No. of farmers registered on apps',
'Geographic distribution'=> 'Geo - ',
'Total carbon emissions saved'=> 'GHG reduced - Total - KgCo2e',
'Total weight of waste collected (Tonnes)'=> 'Waste Collected - Total - Kgs',
'Number of states operating in'=> 'Geo covered - States',
'Reduction in GHG emissions'=> 'GHG reduced  - Total - KgCo2e',
'Pilot shelter units deployed'=> 'Units Sold - Pilot shelter units deployed');
foreach($HistoricMetrics as $key => $value){
	$condition = array('name'=>$key);
	$getReject_reason = $this->Common_model->get_all_details('master_metrics', $condition, array(), '', '');
	$UpdateCondition = array();
	$updateData = array();
	if($getReject_reason){
		echo $key." =========== ".$value; 
		$ID = $getReject_reason[0]->id;
		$UpdateCondition =array('id'=>$ID);
		$updateData = array('name'=>$value);
		echo'<pre>';print_r($UpdateCondition);
		echo'<pre>';print_r($updateData);
		echo "*************************************";  echo'<br>';
		$this->Common_model->update_data('master_metrics', $UpdateCondition, $updateData);
	}
	//echo'<pre>';print_r($getReject_reason);
}
die; */

	 $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
	$partner = $this->session->userdata('partner_id');
	$data['master_type'] = 'Master Metrics';
	$this->load->vars($data);
	$this->load->view('incubation_masters/master_metrics', $data);
	
}

 public function insertEditMaster_metrics() {

        $reason_edit_id = $this->input->post('master_edit_id');
        $reason = $this->input->post('master_name');
        $status_val = $this->input->post('status');
        $description = $this->input->post('description');
        $status_data = '';
        $updateData = $InsetData = array();
		 
         if (!empty($reason)) {
            $is_record = 0;
            foreach ($reason as $id => $value) {
                $partner_id = $this->session->userdata('partner_id');
                if ($reason[$id] != '') {
                    if ($reason[$id] != '') {
							echo'<pre>';print_r($_POST);
							$status_data = $status_val[$id];
                            if ($status_val[$id] == '') { 
                                $status_data = 1;
                            }
                        if ($reason_edit_id[$id]) {
                            $condition = array('id' => $reason_edit_id[$id]);
                            $updateData = array('name' => $reason[$id],'description'=>$description[$id], 'partner_id' => $partner_id, 'status' => $status_data, 'updated_at' => date('Y-m-d H:i:s'));
							$this->Common_model->update_data('master_metrics', $condition, $updateData);
                        } else {
                            
                            $InsetData = array('name' => $reason[$id],'description'=>$description[$id], 'partner_id' => $partner_id, 'status' => $status_data, 'created_at' => date('Y-m-d H:i:s'));
							$this->Common_model->insert_data('master_metrics', $InsetData);
                        }
                    }
                    $is_record++;
                }
            }
            if ($is_record > 0) {
                $this->session->set_flashdata('successMsg', "Metrics details saved successfully");
            }
        }
        redirect('incubation_master/master_metrics');
}

 public function DTMetrics() {
        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;
	
		
		$columns = array('name','description','status');

        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];
		$orderby_sec = array($columns[$requestData['order'][0]['column']-1] => $requestData['order'][0]['dir']);
      
		$condition = array('partner_id' =>  $this->session->userdata('partner_id') );
		$search_field = $this->input->post('search_field');
		if ($search_field != '') {
			$condition['name LIKE'] = "%$search_field%";
		}
 
        $getReject_reason = $this->Common_model->get_all_details('master_metrics', $condition, array(), '', '', $orderby_sec);
        $count_reject = count($getReject_reason);

        $start = $this->input->post('start');
        $limit = 10;
        $getReject_details = $this->Common_model->get_all_details('master_metrics', $condition, array(), $limit, $start, $orderby_sec);

      
        $option_list = '';
        $orderby = '';
		$data = array();
        foreach ($getReject_details as $lists) {
			
			$selected = '';
			$selected2 = '';
            if ($lists->status == 1) {
                $selected = 'selected';
            } else if ($lists->status == 2) {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="master_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->name . '" name="master_name[' . $i . ']" disabled>';
			  $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->description . '" name="description[' . $i . ']" disabled>';
         
            $nestedData[] = '<select class="form-control" name="status[' . $i . ']"  disabled >
            <option value="" >--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive </option>
            </select>';
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }
		
			#echo'<pre>';print_r($data);die;
		
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getReject_details)),
            "recordsFiltered" => intval($count_reject),
            "data" => $data
        );
        echo json_encode($json_data);
    }
	
	
	

public function meeting_type() {
    if ($this->session->userdata('user_type') != 'superadmin') {
        redirect('portfolio/dashboard');
    } else {
        $this->load->view('incubation_masters/meeting_type', $data);
    }
}

public function DTProgramMaster() {

    $requestData = $_POST;
    $data = array();
    $i = $requestData['start'] + 1;

    $columnIndex = $_POST['order'][0]['column'];
    $columnSortOrder = $_POST['order'][0]['dir'];
    $columnArr = array('program_name', 'emp_name', 'emp_name_sec');

    if ($columnSortOrder == 'asc') {
        $columnSortOrder = 'asc';
        $manual_sort = SORT_ASC;
    } else if ($columnSortOrder == 'desc') {
        $columnSortOrder = 'desc';
        $manual_sort = SORT_DESC;
    }
    $orderby = '';
    $orderBy_status = false;
    $orderby_emp = $orderby_sec = '';
    $order_sort = '';
    if ($columnArr[$columnIndex] != '') {
        $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        if ($columnArr[$columnIndex] == 'program_name') {
            $orderby_sec = array($columnArr[$columnIndex] => $columnSortOrder);
        }
    }
    /* $branch_id = $this->session->userdata('partner_id');
    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        #$condition = array('pitch' => $pitch_id, 'parent_id' => 0);
    } else {
        #$condition = array('parent_id' => 0);
    } */
    $start = $this->input->post('start');
    $limit = 10;

    $search_field = $this->input->post('search_field');
    if ($search_field != '') {
        $condition['program_name LIKE'] = "%$search_field%";
    }

    $this->load->model('incubation_master/sector_model');
    $response = array();
	$getProgramCountDetails = $this->Common_model->get_all_details('program_type', $condition, array(), '', '', $orderby_sec);
	$getProgramCount = json_decode(json_encode($getProgramCountDetails), true);
	
	$get_program_details = $this->Common_model->get_all_details('program_type', $condition, array(), $limit, $start, $orderby_sec);
	
	  $baseUrl = base_url();
	  $nestedData = $data = array();
	  foreach ($get_program_details as $lists) {
		$mappedSectorList = '';
		if($lists->sector!=''){
			$getSectorIds = explode(",",$lists->sector);
			$getSector = $this->Sector_model->getSectorDetails($getSectorIds);
			$getSectorArray = array_column($getSector,'sector');
			if(!empty($getSectorArray)){
				 $mappedSectorList  = implode(', ', $getSectorArray);
			}
		} 
		$nestedData = array();
		$nestedData[] = "<a href='" . $baseUrl . "index.php/incubation_master/view_program/" . $lists->id . "'>" . $lists->program_name . "</a>";
		$nestedData[] = $mappedSectorList;
		$nestedData[] = "<input type='hidden' class='get_sector_id' value=" . $lists->id . " >";
		$data[] = $nestedData;
		$i++;
	}
	$json_data = array(
		"draw" => intval($requestData['draw']),
		"recordsTotal" => intval(count($get_program_details)),
		"recordsFiltered" => intval(count($getProgramCount)),
		"data" => $data,
		"POST" => $_POST
	);
	echo json_encode($json_data);
}
	
	

public function DTsector() {

    $requestData = $_POST;
    $data = array();
    $i = $requestData['start'] + 1;

    $columnIndex = $_POST['order'][0]['column'];
    $columnSortOrder = $_POST['order'][0]['dir'];
    $columnArr = array('sector', 'emp_name', 'emp_name_sec');

    if ($columnSortOrder == 'asc') {
        $columnSortOrder = 'asc';
        $manual_sort = SORT_ASC;
    } else if ($columnSortOrder == 'desc') {
        $columnSortOrder = 'desc';
        $manual_sort = SORT_DESC;
    }
    $orderby = '';
    $orderBy_status = false;
    $orderby_emp = $orderby_sec = '';
    $order_sort = '';
    if ($columnArr[$columnIndex] != '') {
        $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        if ($columnArr[$columnIndex] == 'sector') {
            $orderby_sec = array($columnArr[$columnIndex] => $columnSortOrder);
        }
        if ($columnArr[$columnIndex] == 'emp_name') {
            $orderBy_name = array(1);
            $orderBy_status = true;
        }
        if ($columnArr[$columnIndex] == 'emp_name_sec') {
            $orderBy_name = array(2);
            $orderBy_status = true;
        }
    }

    $branch_id = $this->session->userdata('partner_id');
    if ($this->session->userdata('user_type') != 'superadmin') {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $condition = array('pitch' => $pitch_id, 'parent_id' => 0);
    } else {
        $condition = array('parent_id' => 0);
    }
    $start = $this->input->post('start');
    $limit = 10;

    $search_field = $this->input->post('search_field');
    if ($search_field != '') {
        $condition['sector LIKE'] = "%$search_field%";
    }
	 $condition['status'] = "1";
	#echo'<pre>';print_r($condition);die;
    $getSectorCounts = $this->Common_model->get_all_details('sector_category', $condition, array(), '', '', $orderby_sec);
    $getSectorCount = json_decode(json_encode($getSectorCounts), true);
    $sector_details = $this->Common_model->get_all_details('sector_category', $condition, array(), $limit, $start, $orderby_sec);

        #echo'<pre>';print_r($sector_details);die;
    $datas['sector_details'] = $sector_details = json_decode(json_encode($sector_details), true);

    $this->load->model('login/Muser');
    $this->load->model('incubation_master/sector_model');
    $userSetup1 = $this->Common_model->getUserSetup_branch($branch_id);
    $datas['userbranch'] = $this->Common_model->getYbranch($branch_id);
    $datas['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
    $datas['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

    $condition_1 = array('sector_id !=' => '0', 'status' => '1');
    if ($this->session->userdata('user_type') != 'superadmin' && $branch_id != '') {
        $condition_1['partner_id'] = $branch_id;
    }
    $employee_lists = $this->Common_model->get_all_details('assign_sector_lead', $condition_1, array());
    $datas['employee_lists'] = json_decode(json_encode($employee_lists), true);
    $count = count($datas['employee_lists']);
    $response = array();

    foreach ($datas['sector_details'] as $key => $value) {
        foreach ($datas['employee_lists'] as $k => $val) {
            if ($value['id'] == $val['sector_id']) {
                $orderbyArr = array($columnArr[$columnIndex], $columnSortOrder);
                $dd = $this->Sector_model->getEmployeeNameByID($val['employee_id']);
                if (array_key_exists($value['id'], $response)) {
                    $response[$value['id']]['emp_name'] = $response[$value['id']]['emp_name'] . '<br/> ' . $dd['emp_name'];
                } else {
                    $response[$value['id']]['emp_name'] = $dd['emp_name'];
                }
            }
            if (array_key_exists($value['id'], $response)) {
                $datas['sector_details'][$key]['emp_name'] = $response[$value['id']]['emp_name'];
            }
        }
    }
        #error_reporting(-1);
    $data1['employee_lists_sec'] = $employee_lists_sec = $this->Sector_model->getEmployeePartner($branch_id);
    $count = count($data1['employee_lists_sec']);
    $response1 = array();
    foreach ($datas['sector_details'] as $key1 => $value1) {
        foreach ($data1['employee_lists_sec'] as $k => $val1) {
            if ($value1['id'] == $val1['sector_id']) {
                $dd = $this->Sector_model->getEmployeeNameByID($val1['associate_employee']);
                if (array_key_exists($value1['id'], $response1)) {
                    $response1[$value1['id']]['emp_name'] = $response1[$value1['id']]['emp_name'] . '<br/> ' . $dd['emp_name'];
                } else {
                    $response1[$value1['id']]['emp_name'] = $dd['emp_name'];
                }
            }
            if (array_key_exists($value1['id'], $response1)) {
                $datas['sector_details'][$key1]['emp_name_sec'] = $response1[$value1['id']]['emp_name'];
            }
        }
    }

        /* if($orderBy_status == true){
          $data = msort($datas['sector_details'], array('1'),$manual_sort);
          }
          echo'<pre>';print_r($datas['sector_details']);
         */
          $baseUrl = base_url();
          $nestedData = $data = array();
		  $anUserNames = array();
		  $anRequserUserStr = '';
          foreach ($datas['sector_details'] as $lists) {
			  
			$get_sector_an_requester = $this->Common_model->get_all_details('sector_an_requester', array('sector_id' => $lists['id']), array('employee_id'));
			$anUserNames = [];
			if (!empty($get_sector_an_requester)) {
				foreach ($get_sector_an_requester as $requester) {
					if (!empty($requester->employee_id)) { 
						$getEmployeeData = $this->Sector_model->getEmployeeNameByID($requester->employee_id);
						if (!empty($getEmployeeData['emp_name'])) { 
							$anUserNames[] = $getEmployeeData['emp_name'];
						}
					}
				}
			}

			if (!empty($anUserNames)) {
				$anRequserUserStr = implode("<br/>", $anUserNames);
			} else {
				$anRequserUserStr = '';
			}
			#echo'<pre>';print_r($anRequserUserStr);
			
			$nestedData = array();
            $nestedData[] = "<a href='" . $baseUrl . "index.php/incubation_master/view_sectors/" . $lists['id'] . "'>" . $lists['sector'] . "</a>";
            $nestedData[] = $lists['emp_name_sec'];
            $nestedData[] = $lists['emp_name'];
            $nestedData[] = "<input type='hidden' class='get_sector_id' value=" . $lists['id'] . " >";
			$nestedData[] = $anRequserUserStr;
            $data[] = $nestedData;
            $i++;
        }
		
        #$data = msort($data, $orderBy_name,$manual_sort);
        #$data = msort($data, array(2),SORT_DESC);
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($sector_details)),
            "recordsFiltered" => intval(count($getSectorCount)),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTreason() {

        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        #echo $this->session->userdata('user_type');die;

        $where = '';
        $offset = 4;
        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];

        $orderby_sec = array('id' => 'desc');
        $condition = array("status !=" => "-1", 'master_type' => 'Reject Reasons');
        if ($this->session->userdata('user_type') != 'superadmin') {
            $condition['partner_id'] = $this->session->userdata('partner_id');
        }

        $condition['master_name LIKE'] = "%$search_field%";
        if ($branch != '') {
            $condition['partner_id'] = $branch;
        }

        $getReject_reason = $this->Common_model->get_all_details('master_settings', $condition, array(), '', '', $orderby_sec);
        $count_reject = count($getReject_reason);

        $start = $this->input->post('start');
        $limit = 10;
        $getReject_details = $this->Common_model->get_all_details('master_settings', $condition, array(), $limit, $start, $orderby_sec);


        $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_list = '';

        $orderby = '';

        #echo'<pre>';print_r($getReject_details);die;
        foreach ($getReject_details as $lists) {
            $selected = $selected2 = '';
            if ($lists->status == 1) {
                $selected = 'selected';
            } else if ($lists->status == 0) {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->master_name . '" name="reason[' . $i . ']" disabled>';
            if ($this->session->userdata('user_type') == 'admin') {
                $getBranchName = $this->Common_model->get_all_details('hr_branch', $condition, array('branch_name'), '', '', $orderby, true, 'hris');
                $nestedData[] = $getBranchName[0]->branch_name;
            } else {
                $getBranchNames = $this->Common_model->get_all_details('hr_branch', array('id' => $lists->partner_id), array('branch_name', 'id'), '', '', '', true, 'hris');
                $branchId = $getBranchNames[0]->id;
                $option_lists = '';
                foreach ($getBranch_records as $list) {
                    $select_pid = '';
                    if ($list->id == $branchId) {
                        $select_pid = 'selected';
                    }
                    $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
                }
                $nestedData[] = '<select class="form-control" name="branch[' . $i . ']" disabled>
                <option value="">--Select--</option>' . $option_lists . '</select>';
            }
            $nestedData[] = '<select class="form-control" name="status[' . $i . ']"  disabled >
            <option value="" >--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="0" ' . $selected2 . '>Inactive </option>
            </select>';
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getReject_details)),
            "recordsFiltered" => intval($count_reject),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTpreliminary_reason() {

        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        #echo $this->session->userdata('user_type');die;

        $where = '';
        $offset = 4;
        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];

        $orderby_sec = array('id' => 'desc');
        if ($this->session->userdata('user_type') != 'superadmin') {
            $condition = array("partner_id" => $this->session->userdata('partner_id'));
        }

        if ($search_field != '') {
            $condition['name LIKE'] = "%$search_field%";
        }

        if ($branch != '') {
            $condition['partner_id'] = $branch;
        }

        $getReject_reason = $this->Common_model->get_all_details('preliminary_reasons', $condition, array(), '', '', $orderby_sec);
        $count_reject = count($getReject_reason);

        $start = $this->input->post('start');
        $limit = 10;
        $getReject_details = $this->Common_model->get_all_details('preliminary_reasons', $condition, array(), $limit, $start, $orderby_sec);


        $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_list = '';

        $orderby = '';

        $selected = $selected2 = '';
        foreach ($getReject_details as $lists) {

            if ($lists->status == '1') {
                $selected = 'selected';
            } else if ($lists->status == '2') {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->name . '" name="reason[' . $i . ']" disabled>';
            if ($this->session->userdata('user_type') == 'admin') {
                $getBranchName = $this->Common_model->get_all_details('hr_branch', $condition, array('branch_name'), '', '', $orderby, true, 'hris');
                $nestedData[] = $getBranchName[0]->branch_name;
            } else {
                $getBranchNames = $this->Common_model->get_all_details('hr_branch', array('id' => $lists->partner_id), array('branch_name', 'id'), '', '', '', true, 'hris');
                $branchId = $getBranchNames[0]->id;
                $option_lists = '';
                foreach ($getBranch_records as $list) {
                    $select_pid = '';
                    if ($list->id == $branchId) {
                        $select_pid = 'selected';
                    }
                    $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
                }
                $nestedData[] = '<select class="form-control" name="branch[' . $i . ']" disabled>
                <option value="">--Select--</option>' . $option_lists . '</select>';
            }
            $nestedData[] = '<select class="form-control" name="status[' . $i . ']"  disabled >
            <option value="" >--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive </option>
            </select>';
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($count_reject),
            "recordsFiltered" => intval(count($getReject_details)),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTdonor_fit() {

        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        #echo $this->session->userdata('user_type');die;

        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];

        $orderby_sec = array('id' => 'desc');
        if ($this->session->userdata('user_type') != 'superadmin') {
            $condition = array("partner_id" => $this->session->userdata('partner_id'));
        }

        if ($search_field != '') {
            $condition['name LIKE'] = "%$search_field%";
        }

        if ($branch != '') {
            $condition['partner_id'] = $branch;
        }

        $getReject_reason = $this->Common_model->get_all_details('donor_fit_master', $condition, array(), '', '', $orderby_sec);
        $count_reject = count($getReject_reason);

        $start = $this->input->post('start');
        $limit = 10;
        $getReject_details = $this->Common_model->get_all_details('donor_fit_master', $condition, array(), $limit, $start, $orderby_sec);

        $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_list = '';

        $orderby = '';

        #echo'<pre>';print_r($getReject_details);die;
        $selected = $selected2 = '';
        foreach ($getReject_details as $lists) {

            if ($lists->status == 1) {
                $selected = 'selected';
            } else if ($lists->status == 2) {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->name . '" name="reason[' . $i . ']" disabled>';
            if ($this->session->userdata('user_type') == 'admin') {
                $getBranchName = $this->Common_model->get_all_details('hr_branch', $condition, array('branch_name'), '', '', $orderby, true, 'hris');
                $nestedData[] = $getBranchName[0]->branch_name;
            } else {
                $getBranchNames = $this->Common_model->get_all_details('hr_branch', array('id' => $lists->partner_id), array('branch_name', 'id'), '', '', '', true, 'hris');
                $branchId = $getBranchNames[0]->id;
                $option_lists = '';
                foreach ($getBranch_records as $list) {
                    $select_pid = '';
                    if ($list->id == $branchId) {
                        $select_pid = 'selected';
                    }
                    $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
                }
                $nestedData[] = '<select class="form-control" name="branch[' . $i . ']" disabled>
                <option value="">--Select--</option>' . $option_lists . '</select>';
            }
            $nestedData[] = '<select class="form-control" name="status[' . $i . ']"  disabled >
            <option value="" >--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive </option>
            </select>';
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getReject_details)),
            "recordsFiltered" => intval($count_reject),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function DTdocument_type() {

        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array('', 'name', 'status');
        $start = $this->input->post('start');

        $orderby = array('id' => 'desc');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        $condition = array('status !=' => 3, 'type' => 1);
        $getDocument_type = $this->Common_model->get_all_details('diligence_document_types', $condition, array(), '', '', $orderby);
        $count_Document = count($getDocument_type);

        $limit = 10;
        $getDocument_details = $this->Common_model->get_all_details('diligence_document_types', $condition, array(), $limit, $start, $orderby);

        #echo'<pre>';print_r($getReject_details);die;
        foreach ($getDocument_details as $lists) {
            $selected = $selected2 = '';
            if ($lists->status == 1) {
                $selected = 'selected';
            } else if ($lists->status == 2) {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->name . '" name="name[' . $i . ']" disabled>';
            $nestedData[] = '<select class="form-control" name="status[' . $i . ']"  disabled >
            <option value="" >--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive </option>
            </select>';
            $nestedData[] = "";
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getDocument_details)),
            "recordsFiltered" => intval($count_Document),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function DTmeeting_type() {

        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array('', 'name', 'status');
        $start = $this->input->post('start');

        $orderby = array('id' => 'desc');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        $condition = array('status !=' => 3);
        $getDocument_type = $this->Common_model->get_all_details('diligence_meeting_type', $condition, array(), '', '', $orderby);
        $count_Document = count($getDocument_type);

        $limit = 10;
        $getDocument_details = $this->Common_model->get_all_details('diligence_meeting_type', $condition, array(), $limit, $start, $orderby);

        #echo'<pre>';print_r($getReject_details);die;
        foreach ($getDocument_details as $lists) {
            $selected = $selected2 = '';
            if ($lists->status == 1) {
                $selected = 'selected';
            } else if ($lists->status == 2) {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->name . '" name="name[' . $i . ']" disabled>';
            $nestedData[] = '<select class="form-control" name="status[' . $i . ']"  disabled >
            <option value="" >--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive </option>
            </select>';
            $nestedData[] = "";
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getDocument_details)),
            "recordsFiltered" => intval($count_Document),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function DTmaster_settings() {

        $length = $this->input->post('length');
        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $master_type = $this->input->post('master_type');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        #echo $this->session->userdata('user_type');die;

        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];

        $orderby_sec = array('id' => 'desc');
        $condition = array("status !=" => "-1");
        if ($search_field != '') {
            $condition['master_name LIKE'] = "%$search_field%";
        }
        if ($master_type != '') {
            $condition['master_type'] = $master_type;
        }

        $getReject_reason = $this->Common_model->get_all_details('master_settings', $condition, array(), '', '', $orderby_sec);
        $count_reject = count($getReject_reason);

        $start = $this->input->post('start');
        $limit = $length;
        $getReject_details = $this->Common_model->get_all_details('master_settings', $condition, array(), $limit, $start, $orderby_sec);

        $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_list = '';

        $orderby = '';

        #echo'<pre>';print_r($getReject_details);die;
        $selected = $selected2 = '';
        foreach ($getReject_details as $lists) {

            if ($lists->status == 1) {
                $selected = 'selected';
            } else if ($lists->status == 0) {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->master_name . '" name="reason[' . $i . ']" disabled>';
            $nestedData[] = '<select class="form-control" name="status[' . $i . ']"  disabled >
            <option value="" >--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive </option>
            </select>';
            $nestedData[] = "";
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getReject_details)),
            "recordsFiltered" => intval($count_reject),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTportfolio_settings() {

        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $table_name = $this->input->post('table_name');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;


        $where = '';

        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];

        $orderby_sec = array('id' => 'desc');
        $condition = array("status !=" => 3, "partner_id" => $this->session->userdata('partner_id'));

        $search_field = $this->input->post('search_field');
        if ($search_field != '') {
            $condition['name LIKE'] = "%$search_field%";
        }


        $getReject_reason = $this->Common_model->get_all_details($table_name, $condition, array());
        $count_reject = count($getReject_reason);

        $start = $this->input->post('start');
        $limit = 10;
        $get_details = $this->Common_model->get_all_details($table_name, $condition, array(), $limit, $start, $orderby_sec);
        $get_details_count = count($get_details);
        $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_list = '';

        $orderby = '';
        $selected = $selected2 = '';
        foreach ($get_details as $lists) {

            if ($lists->status == 1) {
                $selected = 'selected';
            } else if ($lists->status == 2) {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->name . '" name="name[' . $i . ']" disabled>';
            if ($this->session->userdata('user_type') == 'superadmin') {
                $getBranchNames = $this->Common_model->get_all_details('hr_branch', array('id' => $lists->partner_id), array('branch_name', 'id'), '', '', '', true, 'hris');
                $branchId = $getBranchNames[0]->id;
                $option_lists = '';
                foreach ($getBranch_records as $list) {
                    $select_pid = '';
                    if ($list->id == $branchId) {
                        $select_pid = 'selected';
                    }
                    $option_lists .= '<option value="' . $list->id . '" ' . $select_pid . '>' . $list->branch_name . '</option>';
                }
                $nestedData[] = '<select class="form-control" name="branch[' . $i . ']" disabled>
                <option value="">--Select--</option>' . $option_lists . '</select>';
            }
            $nestedData[] = '<select class="form-control" name="status[' . $i . ']"  disabled >
            <option value="" >--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive </option>
            </select>';
            $nestedData[] = "";
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_reject),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTcompany_target() {

        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $table_name = 'port_dashboard_master';
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;


        $where = '';

        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];

        $orderby_sec = array('id' => 'desc');
        $condition = array("status !=" => 3, "partner_id" => $this->session->userdata('partner_id'));

        $getReject_reason = $this->Common_model->get_all_details('port_dashboard_master', $condition, array());
        $count_reject = count($getReject_reason);

        $start = $this->input->post('start');
        $limit = 5;
        $get_details = $this->Common_model->get_all_details('port_dashboard_master', $condition, array(), $limit, $start, $orderby_sec);
        $get_details_count = count($get_details);
        $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $option_list = '';

        $orderby = '';
        #echo'<pre>';print_r($get_details);die;
        $selected = '';
        foreach ($get_details as $lists) {

            $sector_id = $lists->sector;
            $partner_id = $lists->partner_id;

            $getsector_category = $this->Common_model->get_all_details('sector_category', array('id' => $sector_id), array('sector', 'id'));
            $getBranch_records = $this->Common_model->get_all_details('hr_branch', array('id' => $partner_id), array('branch_name'), '', '', '', true, 'hris');
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '">';
            $nestedData[] = "<a href=''>" . $getsector_category[0]->sector . "</a>";
            $nestedData[] = $lists->financial_year;
            $nestedData[] = $getBranch_records[0]->branch_name;
            $nestedData[] = $lists->app_annual;
            $nestedData[] = $lists->pard_annual;
            $nestedData[] = $lists->iic_annual;
            $nestedData[] = $lists->eic_annual;
            $nestedData[] = $lists->tot_annual;
            $nestedData[] = $lists->new_annual;
            $nestedData[] = $lists->ext_annual;

            if ($lists->status == 1) {
                $selected = 'Active';
            } else if ($lists->status == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_reject),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTincubation_progress() {

        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $table_name = 'port_dashboard_master';
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array('', 'criteria_title', 'period', 'label', 'input_type', 'required', 'status');

        $start = $this->input->post('start');
        $options['num'] = 10;
        $options['offset'] = $start;

        $optionsCount = array();
        if ($columnArr[$columnIndex] != '') {
            $optionsCount['orderby'] = $columnArr[$columnIndex];
            $optionsCount['ordertype'] = $columnSortOrder;

            $options['orderby'] = $columnArr[$columnIndex];
            $options['ordertype'] = $columnSortOrder;
        }
        $condition = array();
        $criteria = $this->input->post('criteria');
        if ($criteria != '') {
            $condition['criteria'] = $criteria;
        }

        $search_field = $this->input->post('search_field');
        if ($search_field != '') {
            $condition['label LIKE'] = "%$search_field%";
        }

        $getCountDetails = $this->Common_model->getLimitRecords($optionsCount, $condition);
        $count_num = count($getCountDetails);

        $get_details = $this->Common_model->getLimitRecords($options, $condition);
        $get_details_count = count($get_details);

        $periods = array(1 => 'Weekly Report', 2 => 'Monthly Report', 3 => 'Quarterly Report', 4 => 'Yearly Report');
        $baseUrl = base_url() . 'index.php/';
        $editUrl = base_url() . 'index.php/incubation_master/edit_incubation_field/';
        $listingSubfield = base_url() . 'index.php/incubation_master/incubation_subfield/';
        #echo'asd';die;
        $selected = '';
        foreach ($get_details as $lists) {

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists['id'] . '">';
            $nestedData[] = $lists['criteria_title'];
            $nestedData[] = $periods[$lists['period']];
            $nestedData[] = $lists['label'];
            $nestedData[] = $lists['input_type'];
            $nestedData[] = ucfirst($lists['required']);
            if ($lists['status'] == 1) {
                $selected = 'Active';
            } else if ($lists['status'] == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $nestedData[] = "<a href=" . $listingSubfield . $lists['id'] . ">Sub-Fields</a>";
            $nestedData[] = "<a href=" . $editUrl . $lists['id'] . "><img src='" . base_url() . "source/images/detail.png' border='20' height='20'></a>";
            $selected = '';
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTincubation_subfield($id) {

        $id = $this->input->post('id');
        $search_field = $this->input->post('search_field');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array('', 'parent_value', 'label', 'input_type', 'required', 'value', 'status');

        $start = $this->input->post('start');

        $orderby = '';
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }
        $condition = array('pid' => $id);
        $get_details = $this->Common_model->get_all_details('progress_master', $condition, array(), '', '');
        $get_details_count = count($get_details);

        $start = $this->input->post('start');
        $limit = 10;
        $getProgressMaster = $this->Common_model->get_all_details('progress_master', $condition, array(), $limit, $start, $orderby);
        $getProgressMaster = json_decode(json_encode($getProgressMaster), true);


        $editUrl = base_url() . 'index.php/incubation_master/edit_incubation_subfield/';
        $listingSubfield = base_url() . 'index.php/incubation_master/incubation_subfield/';
        $selected = '';
        foreach ($getProgressMaster as $lists) {

            $unserializeData = unserialize($lists["value"]);
            if (is_array($unserializeData)) {
                $values = implode(', ', $unserializeData);
            } else {
                $values = $unserializeData;
            }

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists['id'] . '">';
            $nestedData[] = $lists['parent_value'];
            $nestedData[] = $lists['label'];
            $nestedData[] = $lists['input_type'];
            $nestedData[] = ucfirst($lists['required']);
            $nestedData[] = $values;
            if ($lists['status'] == 1) {
                $selected = 'Active';
            } else if ($lists['status'] == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $nestedData[] = "<a href=" . $listingSubfield . $lists['id'] . ">Sub-Fields</a>";
            $nestedData[] = "<a href=" . $editUrl . $lists['id'] . '/' . $id . "><img src='" . base_url() . "source/images/detail.png' border='20' height='20'></a>";
            $data[] = $nestedData;
            $i++;
        }
        #echo'<pre>';print_r($data);die;
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getProgressMaster)),
            "recordsFiltered" => intval($get_details_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTscreening_subfields($id) {

        $pid = $this->input->post('id');
        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $table_name = 'port_dashboard_master';
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array('', 'parent_value', 'label', 'input_type', 'required', 'required', 'status');

        $start = $this->input->post('start');
        $options['num'] = 10;
        $options['offset'] = $start;

        $optionsCount = array();
        if ($columnArr[$columnIndex] != '') {
            $optionsCount['orderby'] = $columnArr[$columnIndex];
            $optionsCount['ordertype'] = $columnSortOrder;

            $options['orderby'] = $columnArr[$columnIndex];
            $options['ordertype'] = $columnSortOrder;
        }
        $orderby = '';
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        $condition = array('pid' => $pid, 'parent_value !=' => '');

        $get_details = $this->Common_model->get_all_details('screening_master', $condition, array(), '', '');
        $get_details_count = count($get_details);

        $start = $this->input->post('start');
        $limit = 10;
        $getProgressMaster = $this->Common_model->get_all_details('screening_master', $condition, array(), $limit, $start, $orderby);
        $getProgressMaster = json_decode(json_encode($getProgressMaster), true);


        $periods = array(1 => 'Weekly Report', 2 => 'Monthly Report', 3 => 'Quarterly Report', 4 => 'Yearly Report');
        $baseUrl = base_url() . 'index.php/';
        $editUrl = base_url() . 'index.php/incubation_master/edit_screening_subfield/';
        $listingSubfield = base_url() . 'index.php/incubation_master/screening_subfields/';


        #echo'<pre>';print_r($getProgressMaster);die;
        $selected = '';
        foreach ($getProgressMaster as $lists) {
            $unserializeData = unserialize($lists["value"]);
            if (is_array($unserializeData)) {
                $values = implode(', ', $unserializeData);
            } else {
                $values = $unserializeData;
            }

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists['id'] . '">';
            $nestedData[] = $lists['parent_value'];
            $nestedData[] = $lists['label'];
            $nestedData[] = $lists['input_type'];
            $nestedData[] = ucfirst($lists['required']);
            $nestedData[] = $values;
            if ($lists['status'] == 1) {
                $selected = 'Active';
            } else if ($lists['status'] == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $nestedData[] = "<a  href=" . $listingSubfield . $lists['id'] . "> Sub-Fields</a>";
            $nestedData[] = "<a href=" . $editUrl . $lists['id'] . '/' . $pid . "><img src='" . base_url() . "source/images/detail.png' border='20' height='20'></a>";
            $selected = '';
            $data[] = $nestedData;
            $i++;
        }
        #echo'<pre>';print_r($data);die;
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getProgressMaster)),
            "recordsFiltered" => intval($get_details_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTassessment($id) {

        $pid = $this->input->post('id');
        $search_field = $this->input->post('search_field');
        $branch = $this->input->post('branch');
        $table_name = 'port_dashboard_master';
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array('', 'label', 'input_type', 'required', 'required', 'status');

        $start = $this->input->post('start');
        $options['num'] = 10;
        $options['offset'] = $start;

        $optionsCount = array();
        if ($columnArr[$columnIndex] != '') {
            $optionsCount['orderby'] = $columnArr[$columnIndex];
            $optionsCount['ordertype'] = $columnSortOrder;

            $options['orderby'] = $columnArr[$columnIndex];
            $options['ordertype'] = $columnSortOrder;
        }
        $orderby = '';
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        $condition = array('pid' => $pid, 'parent_value' => null);

        $get_details = $this->Common_model->get_all_details('screening_master', $condition, array(), '', '');
        $get_details_count = count($get_details);

        $start = $this->input->post('start');
        $limit = 10;
        $getProgressMaster = $this->Common_model->get_all_details('screening_master', $condition, array(), $limit, $start, $orderby);
        $getProgressMaster = json_decode(json_encode($getProgressMaster), true);


        $periods = array(1 => 'Weekly Report', 2 => 'Monthly Report', 3 => 'Quarterly Report', 4 => 'Yearly Report');
        $baseUrl = base_url() . 'index.php/';
        $editUrl = base_url() . 'index.php/incubation_master/edit_screening_subfield/';
        $listingSubfield = base_url() . 'index.php/incubation_master/screening_subfields/';


        #echo'<pre>';print_r($getProgressMaster);die;
        $selected = '';
        foreach ($getProgressMaster as $lists) {
            $unserializeData = unserialize($lists["value"]);
            if (is_array($unserializeData)) {
                $values = implode(', ', $unserializeData);
            } else {
                $values = $unserializeData;
            }

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists['id'] . '">';
            $nestedData[] = $lists['label'];
            $nestedData[] = $lists['input_type'];
            $nestedData[] = ucfirst($lists['required']);
            $nestedData[] = $values;
            if ($lists['status'] == 1) {
                $selected = 'Active';
            } else if ($lists['status'] == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $selected = '';
            $data[] = $nestedData;
            $i++;
        }
        #echo'<pre>';print_r($data);die;
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getProgressMaster)),
            "recordsFiltered" => intval($get_details_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function source_instance_master() {

        $data['get_source_type'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Source Type'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            $data['isAuth'] = true;
        } else {
            $options['employee'] = $this->session->userdata('emp_number');
            $data['isAuth'] = false;
        }
        $this->load->view('incubation_masters/source_instance_master', $data);
    }

    public function view_source_instance() {

        $data['get_source_type'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Source Type'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            $data['isAuth'] = true;
        } else {
            $options['employee'] = $this->session->userdata('emp_number');
            $data['isAuth'] = false;
        }
        $this->load->view('incubation_masters/view_source_instance', $data);
    }

    public function DTsource_instance_master($id) {

        $source = $this->input->post('source');
        $source_type = $this->input->post('source_type');
        $source_name = $this->input->post('source_name');
        $search_field = $this->input->post('search_field');
        $contact_person = $this->input->post('contact_person');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $optionsCount = array();
        $columnArr = array();



        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            $isAuth = true;
            $columnArr = array('', 'master_name', 'source_name', 'emp_name', 'contact_person', 'designation', 'status');
        } else {
            $options['employee'] = $this->session->userdata('emp_number');
            $optionsCount['employee'] = $this->session->userdata('emp_number');
            $isAuth = false;
            $columnArr = array('master_name', 'source_name', 'emp_name', 'contact_person', 'designation');
        }

        if ($source == 1) {
            unset($optionsCount['employee']);
            unset($options['employee']);
        }
        if ($source_type != '') {
            $optionsCount['source_type'] = $source_type;
            $options['source_type'] = $source_type;
        }
        if ($source_type != '') {
            $optionsCount['source_name'] = $source_name;
            $options['source_name'] = $source_name;
        }
        if ($source_type != '') {
            $optionsCount['contact_person'] = $contact_person;
            $options['contact_person'] = $contact_person;
        }


        $start = $this->input->post('start');
        $options['num'] = 20;
        $options['offset'] = $start;
        if ($columnArr[$columnIndex] != '') {
            $optionsCount['orderby'] = $columnArr[$columnIndex];
            $optionsCount['ordertype'] = $columnSortOrder;

            $options['orderby'] = $columnArr[$columnIndex];
            $options['ordertype'] = $columnSortOrder;
        }
        $condition = array();

        $search_field = $this->input->post('search_field');
        if ($search_field != '') {
            $condition['label LIKE'] = "%$search_field%";
        }
        /* echo'<pre>';print_r($options);
        echo'<pre>';print_r($condition);die; */
        $getCountDetails = $this->Common_model->get_source_master($optionsCount, $condition);
        $count_num = count($getCountDetails);

        #echo'<pre>';print_r($options);
        $get_details = $this->Common_model->get_source_master($options, $condition);
        $get_details_count = count($get_details);
        #echo'<pre>';print_r($get_details);die;

        $periods = array(1 => 'Weekly Report', 2 => 'Monthly Report', 3 => 'Quarterly Report', 4 => 'Yearly Report');
        $baseUrl = base_url() . 'index.php/';
        $editUrl = base_url() . 'index.php/incubation_master/edit_source/';
        $view_source_instance = base_url() . 'index.php/incubation_master/view_source_instance/';


        #echo'<pre>';print_r($get_details);die;
        $selected = '';
        foreach ($get_details as $lists) {

            $nestedData = array();
            if ($isAuth) {
                $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists['id'] . '">';
            }
            $nestedData[] = $lists['master_name'];
            $nestedData[] = $lists['source_name'];
            $nestedData[] = $lists['emp_name'];
            $nestedData[] = $lists['contact_person'];
            $nestedData[] = $lists['designation'];
            if ($isAuth) {
                if ($lists['status'] == 1) {
                    $selected = 'Active';
                } else if ($lists['status'] == 2) {
                    $selected = 'Inactive';
                }
                $nestedData[] = "$selected";
            }
            $nestedData[] = "<a href=" . $view_source_instance . $lists['id'] . ">View Instance</a>";
            $nestedData[] = "<a href=" . $editUrl . $lists['id'] . "><img src='" . base_url() . "source/images/detail.png' border='20' height='20'></a>";
            $selected = '';
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTview_source_instance($id) {

        $id = $this->input->post('id');
        $source_name = $this->input->post('source_name');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $optionsCount = array();


        $condition = array('source_id' => $id);

        if ($source_name != '') {
            $condition['instance_name LIKE'] = $source_name;
        }

        if ($date_from != '') {
            $date_from = date('Y-m-d', strtotime($date_from));
            $condition['date >='] = $date_from;
        }
        if ($date_to != '') {
            $date_to = date('Y-m-d', strtotime($date_to));
            $condition['date <='] = $date_to;
        }
        #echo'<pre>';print_r($condition);die;
        $columnArr = array('', 'sm.source_name', 'instance_name', 'date', 'remarks', '', 'remarks');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }
        $start = $this->input->post('start');
        $limit = 10;

        $join[0]['select'] = "source_name,instance_name,remarks,instance_master.date,instance_master.document,instance_master.status,instance_master.id";
        $join[0]['table'] = 'source_master as sm';
        $join[0]['condition'] = "sm.id = instance_master.source_id";
        $join[0]['type'] = "LEFT";

        $getcount = $this->Common_model->get_all_details('instance_master', $condition, array(), '', '', $orderby, '', '', $join);
        $count_num = count($getcount);
        $get_details = $this->Common_model->get_all_details('instance_master', $condition, array(), $limit, $start, $orderby, '', '', $join);
        $get_details_count = count($get_details);
        #echo'<pre>';print_r($get_details);die;
        $editUrl = base_url() . 'index.php/incubation_master/addEdit_source_instance/';
        $selected = '';
        foreach ($get_details as $lists) {
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '">';

            $nestedData[] = $lists->source_name;
            $nestedData[] = $lists->instance_name;
            $nestedData[] = mysql2date($lists->date);
            $nestedData[] = $lists->remarks;

            if ($lists->document == '') {
                $nestedData[] = '-';
            } else {
                $nestedData[] = '<a href="' . base_url() . 'uploads/instance/' . $lists->document . '" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a>';
            }

            if ($lists->status == 1) {
                $selected = 'Active';
            } else if ($lists->status == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $nestedData[] = "<a href=" . $editUrl . $lists->id . '/' . $id . "><img src='" . base_url() . "source/images/detail.png' border='20' height='20'></a>";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTscreening_master($id) {

        $criteria = $this->input->post('criteria');
        $label = $this->input->post('label');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $optionsCount = array();
        $columnArr = array('', 'criteria_title', 'label', 'input_type', 'required', 'status');


        $start = $this->input->post('start');
        $options['num'] = 10;
        $options['offset'] = $start;
        if ($columnArr[$columnIndex] != '') {
            $optionsCount['orderby'] = $columnArr[$columnIndex];
            $optionsCount['ordertype'] = $columnSortOrder;

            $options['orderby'] = $columnArr[$columnIndex];
            $options['ordertype'] = $columnSortOrder;
        }
        $condition = array();

        if ($criteria != '') {
            $condition['criteria'] = $criteria;
        }
        if ($label != '') {
            $condition['label LIKE'] = "%$label%";
        }

        #echo'<pre>';print_r($options);die;
        $getCountDetails = $this->Common_model->get_screeningRecords($optionsCount, $condition);
        $count_num = count($getCountDetails);

        $get_details = $this->Common_model->get_screeningRecords($options, $condition);
        $get_details_count = count($get_details);

        $editUrl = base_url() . 'index.php/incubation_master/edit_screening_field/';
        $listingSubfield = base_url() . 'index.php/incubation_master/screening_subfields/';
        $assessment = base_url() . 'index.php/incubation_master/assessment/';


        #echo'<pre>';print_r($get_details);die;
        $selected = '';
        foreach ($get_details as $lists) {

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists['id'] . '">';

            $nestedData[] = $lists['criteria_title'];
            $nestedData[] = $lists['label'];
            $nestedData[] = $lists['input_type'];
            $nestedData[] = ucfirst($lists['required']);
            if ($lists['status'] == 1) {
                $selected = 'Active';
            } else if ($lists['status'] == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $nestedData[] = "<a href=" . $assessment . $lists['id'] . ">Assessment</a> <a href=" . $listingSubfield . $lists['id'] . "> Sub-Fields</a>";
            $nestedData[] = "<a href=" . $editUrl . $lists['id'] . "><img src='" . base_url() . "source/images/detail.png' border='20' height='20'></a>";

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTmeans_validation($id) {

        $criteria = $this->input->post('criteria');
        $value = $this->input->post('value');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $optionsCount = array();
        $condition = array();

        if ($criteria != '') {
            $condition['criteria'] = $criteria;
        }
        if ($value != '') {
            $condition['validation LIKE'] = "%$value%";
        }

        $columnArr = array('', 'criteria_title', 'validation', 'status');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }
        $start = $this->input->post('start');
        $limit = 10;

        $fields = array('means_validation.*,(select master_name from master_settings where id=means_validation.criteria) as criteria_title');
        $getcount = $this->Common_model->get_all_details('means_validation', $condition, $fields, '', '', $orderby);
        $count_num = count($getcount);
        $get_details = $this->Common_model->get_all_details('means_validation', $condition, $fields, $limit, $start, $orderby);
        $get_details_count = count($get_details);
        $selected = '';
        foreach ($get_details as $lists) {

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '">';

            $nestedData[] = $lists->criteria_title;
            $nestedData[] = $lists->validation;
            if ($lists->status == 1) {
                $selected = 'Active';
            } else if ($lists->status == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTchecklist($id) {

        $area = $this->input->post('area');
        $document_description = $this->input->post('document_description');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $optionsCount = array();
        $condition = array();
        $condition = '';

        $columnArr = array('', 'criteria_title', 'validation', 'status');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        $optionsCount = array();
        $columnArr = array('', 'master_name', 'document_description', 'status');


        $start = $this->input->post('start');
        $options['offset'] = 10;
        $options['num'] = $start;
        if ($columnArr[$columnIndex] != '') {
            $optionsCount['orderby'] = $columnArr[$columnIndex];
            $optionsCount['ordertype'] = $columnSortOrder;

            $options['orderby'] = $columnArr[$columnIndex];
            $options['ordertype'] = $columnSortOrder;
        }

        if ($area != '') {
            $condition = "where area = '" . $area . "'";
        }
        if ($document_description != '') {
            $condition = "where document_description like '%" . $document_description . "%'";
        }
        if ($area != '' && $document_description != '') {
            $condition = "where area = '" . $area . "' AND document_description like '%" . $document_description . "%'";
        }

        $getCountDetails = $this->Common_model->get_checklist($optionsCount, $condition);
        $count_num = count($getCountDetails);
        $get_details = $this->Common_model->get_checklist($options, $condition);
        $get_details_count = count($get_details);
        $selected = '';
        foreach ($get_details as $lists) {

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists['id'] . '">';

            $nestedData[] = $lists['master_name'];
            $nestedData[] = $lists['document_description'];
            if ($lists['status'] == 1) {
                $selected = 'Active';
            } else if ($lists['status'] == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTprogram_service_master($id) {

        $program_service = $this->input->post('program_service');
        $program_type = $this->input->post('program_type');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array();
        $condition = array();
        $orderby = '';

        $columnArr = array('', 'master_name', 'title', 'status');
        if ($source == 1) {
            unset($optionsCount['employee']);
            unset($options['employee']);
        }
        if ($source_type != '') {
            $optionsCount['source_type'] = $source_type;
        }
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }
        $fields = array('program_service_offering.*,(select master_name from master_settings where id=program_service_offering.program_type) as master_name');
        $getcount = $this->Common_model->get_all_details('program_service_offering', $condition, $fields, '', '', $orderby);
        $count_num = count($getcount);

        $start = $this->input->post('start');
        $limit = 10;
        $get_details = $this->Common_model->get_all_details('program_service_offering', $condition, $fields, $limit, $start, $orderby);
        $get_details_count = count($get_details);

        $editUrl = base_url() . 'index.php/incubation_master/addEdit_program_service/';
        #echo'<pre>';print_r($get_details);die;
        $selected = '';
        foreach ($get_details as $lists) {

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '">';

            $nestedData[] = $lists->master_name;
            $nestedData[] = $lists->title;
            if ($lists->status == 1) {
                $selected = 'Active';
            } else if ($lists->status == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $nestedData[] = "<a href=" . $editUrl . $lists->id . "><img src='" . base_url() . "source/images/detail.png' border='20' height='20'></a>";
            $selected = '';
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTprogram_stage_master($id) {

        $program_service = $this->input->post('program_service');
        $program_type = $this->input->post('program_type');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array();
        $condition = array();
        $orderby = '';

        $columnArr = array('', 'master_name', 'title', 'status');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        $editUrl = base_url() . 'index.php/incubation_master/addEdit_program_service/';

        $start = $this->input->post('start');
        $options['num'] = 10;
        $options['offset'] = $start;
        if ($columnArr[$columnIndex] != '') {
            $optionsCount['orderby'] = $columnArr[$columnIndex];
            $optionsCount['ordertype'] = $columnSortOrder;

            $options['orderby'] = $columnArr[$columnIndex];
            $options['ordertype'] = $columnSortOrder;
        }
        $condition = array();

        $search_field = $this->input->post('search_field');
        if ($search_field != '') {
            $condition['label LIKE'] = "%$search_field%";
        }

        $getCountDetails = $this->Common_model->getProgram_stage($optionsCount, $condition);
        $count_num = count($getCountDetails);

        $get_details = $this->Common_model->getProgram_stage($options, $condition);
        $get_details_count = count($get_details);
        $selected = '';
        foreach ($get_details as $lists) {

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists['id'] . '">';

            $nestedData[] = $lists['master_name'];
            $nestedData[] = $lists['program_service_title'];
            $nestedData[] = $lists['title'];
            if ($lists['status'] == 1) {
                $selected = 'Active';
            } else if ($lists['status'] == 2) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $nestedData[] = "<a href=" . $editUrl . $lists->id . "><img src='" . base_url() . "source/images/detail.png' border='20' height='20'></a>";
            $selected = '';
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTgrading_master($id) {

        $programServiceOffering = $this->input->post('programServiceOffering');
        $program_type = $this->input->post('program_type');
        $programStage = $this->input->post('programStage');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array();
        $condition = array();
        $orderby = '';

        $columnArr = array('', 'master_name', 'criteria', 'waitage', 'scale');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }
        $condition = array('program_stage' => '5');
        $join[0]['select'] = "grading_master.*,(select master_name from master_settings where id=grading_master.category) as category_name";
        $join[0]['table'] = 'master_settings as ms';
        $join[0]['condition'] = "ms.id = grading_master.category";
        $join[0]['type'] = "LEFT";

        $fields = array('ms.id as master_id,ms.master_name as master_name');
        $getcount = $this->Common_model->get_all_details('grading_master', $condition, $fields, '', '', $orderby, '', '', $join);
        $count_num = count($getcount);

        $start = $this->input->post('start');
        $limit = 10;
        $get_details = $this->Common_model->get_all_details('grading_master', $condition, $fields, $limit, $start, $orderby, '', '', $join);
        $get_details_count = count($get_details);

        foreach ($get_details as $lists) {

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="reason_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '">';
            $nestedData[] = $lists->master_name;
            $nestedData[] = $lists->criteria;
            $nestedData[] = $lists->waitage;
            $nestedData[] = $lists->scale;
            $selected = '';
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_num),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function mail_template() {
        $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $this->load->view('incubation_masters/mail_template', $data);
    }

    public function DTmail_template() {

        $search_field = $this->input->post('search_field');
        $module = $this->input->post('module');
        $branch = $this->input->post('branch');
        $messageType = $this->input->post('filter_search');
        $template_type = $this->input->post('template_type');
        $status = $this->input->post('status');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;
        $mail_template_type = '';

        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $columnArr = array();
        $condition = array();
        $orderby = '';
        $columnArr = array('messagetype', 'messagesubject', 'status');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        if ($module == 'mis') {


            $mail_template_type = 0;
            $partner_id = $this->session->userdata['partner_id'];
            if ($branch != '') {
                $partner_id = $this->input->post('branch');
            }

            $condition = array("status !=" => 3, "partner_id" => $partner_id);
            if ($status != '') {
                $condition['status'] = $status;
            }
            if ($search_field != '') {
                $condition['messagetype LIKE'] = "%$search_field%";
            }
            $getmail_reason = $this->Common_model->get_all_details('master_mailtemplate', $condition, array());
            $count_mail = count($getmail_reason);

            $start = $this->input->post('start');
            $limit = 10;
            $get_details = $this->Common_model->get_all_details('master_mailtemplate', $condition, array(), $limit, $start, $orderby);
            $get_details_count = count($get_details);
            $get_details = $this->Common_model->get_all_details('master_mailtemplate', $condition, array(), $limit, $start, $orderby);
        } else if ($module == 'ais') {
            $mail_template_type = 1;
            if ($template_type != '') {
                $condition['messagetype LIKE'] = "%$template_type%";
            }
            if ($status != '') {
                $condition['status'] = $status;
            }
            $getmail_reason = $this->Common_model->get_all_details('mailtemplate', $condition, array(), '', '', '', true, 'ais');

            $count_mail = count($getmail_reason);
            $start = $this->input->post('start');
            $limit = 10;
            $get_details = $this->Common_model->get_all_details('mailtemplate', $condition, array(), $limit, $start, $orderby, true, 'ais');
            $get_details_count = count($get_details);
        }
        $selected = '';
        foreach ($get_details as $lists) {

            $nestedData = array();
            $nestedData[] = "<a href=''> $lists->messagetype </a>";
            $nestedData[] = $lists->messagesubject;
            $selected = '';
            if ($lists->status == 1) {
                $selected = 'Active';
            } else if ($lists->status == 0) {
                $selected = 'Inactive';
            }
            $nestedData[] = "$selected";
            $nestedData[] = "<input type='hidden' class='mail_template_id' value=" . $lists->id . " >";
            $nestedData[] = "<input type='hidden' class='mail_template_type' value=" . $mail_template_type . " >";
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($get_details_count),
            "recordsFiltered" => intval($count_mail),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function msort($array, $key, $sort_flags = SORT_REGULAR, $order = SORT_ASC) {
        if (is_array($array) && count($array) > 0) {
            if (!empty($key)) {
                $mapping = array();
                foreach ($array as $k => $v) {
                    $sort_key = '';
                    if (!is_array($key)) {
                        $sort_key = $v[$key];
                    } else {
                        foreach ($key as $key_key) {
                            $sort_key .= $v[$key_key];
                        }
                        $sort_flags = SORT_STRING;
                    }
                    $mapping[$k] = $sort_key;
                }
                switch ($order) {
                    case SORT_ASC:
                    asort($mapping, $sort_flags);
                    break;
                    case SORT_DESC:
                    arsort($mapping, $sort_flags);
                    break;
                }
                $sorted = array();
                foreach ($mapping as $k => $v) {
                    $sorted[] = $array[$k];
                }
                return $sorted;
            }
        }
        return $array;
    }

    public function getSectorIncharges() { 

        $this->load->model('incubation_master/sector_model');
        $returnArr['response'] = '';
        $returnArr['incharge_id'] = '';

        $sector_type = $this->input->post('sector_type');
        $branch_id = $this->session->userdata('partner_id');
        $userSetup1 = $this->Common_model->getUserSetup_branch($branch_id);
		
        $data['usersList'] = $usersList = $this->sector_model->getUsersList1($userSetup1['abi'], $branch_id);

        $id = $this->input->post('id');
		
        $inchargeId = array();
        if ($sector_type == 0) {
            $this->load->model('scouting/Mincharge');
            $data['inchargeList'] = $this->Mincharge->getSectors($id);
			
            $inchargeId = array_column($data['inchargeList'], 'associate_employee');
        } else if ($sector_type == 1) {
            $this->load->model('scouting/Mincharge');
            $data['inchargeList'] = $this->Mincharge->getSectorLeads($id);
            $inchargeId = array_column($data['inchargeList'], 'employee_id');
        }else if ($sector_type == 2) {
            $this->load->model('scouting/Mincharge'); 
            $data['inchargeList'] = $this->Mincharge->getAnSectorRequester($id);
            $inchargeId = array_column($data['inchargeList'], 'employee_id');
			
			$this->load->model('user/Common_model');
			$branch = $this->input->post('branch');
			$usersList = $this->Common_model->getUsersList_sa($branch);
			
        }
        if (!empty($inchargeId)) {
            $returnArr['incharge_id'] = $inchargeId;
        }
        if (!empty($usersList)) {
            $returnArr['response'] = $usersList;
        }
      
        echo json_encode($returnArr);
    }
	
	 public function getSectorLists() {
		 
		$returnArr['response'] = '';
        $returnArr['incharge_id'] = '';
		
		$programId = $this->input->post('id');
		$branch_id = $this->session->userdata('partner_id');
		if ($this->session->userdata('user_type') != 'superadmin') {
			$partner_id = $this->session->userdata('partner_id');
			if ($partner_id == '10') {
				$pitch_id = '3';
			} else {
				$pitch_id = '1';
			}
			$condition = array('pitch' => $pitch_id, 'parent_id' => 0);
		} else {
			$condition = array('parent_id' => 0);
		}
		$sector_details = $this->Common_model->get_all_details('sector_category', $condition, array());
		
		$inchargeId = array();
		$get_program_details = $this->Common_model->get_all_details('program_type', array('id'=>$programId), array());
		if(!empty($get_program_details)){
			if($get_program_details[0]->sector!=''){
				$inchargeId = explode(',', $get_program_details[0]->sector);
			}
		}
		if (!empty($inchargeId)) {
            $returnArr['incharge_id'] = $inchargeId;
        }
		 if (!empty($sector_details)) {
            $returnArr['response'] = $sector_details;
         }
        echo json_encode($returnArr);
    }
	
	

    public function insertEditSector() {
        $this->load->model('incubation_master/sector_model');
        $sector_id = $this->input->post('sector_id');
        $associate_employee = $this->input->post('associate_employee');
        $associate_sector_lead = $this->input->post('associate_sector_lead');
		$an_request_users = $this->input->post('an_request_users');

        if ($sector_id != '') {
            $data['partner_id'] = $this->session->userdata('partner_id');
            $data['sector_id'] = $_POST['sector_id'];
            if (!empty($associate_employee)) {
                $data['employee_number'] = $_POST['associate_employee'];
                $id = $this->sector_model->addSectorIncharge($data);
            }
            if (!empty($associate_sector_lead)) {
                $data['employee_number'] = $_POST['associate_sector_lead'];
                $id = $this->sector_model->addSectorIncharge($data, 'assign_sector_lead');
            }
			if (!empty($an_request_users)) {
				$data['employee_number'] = $_POST['an_request_users'];
				$data['sector_id'] = $_POST['sector_id'];
				$data['partner_id'] = $this->session->userdata('partner_id');
				$id = $this->sector_model->addanRequester($data, 'sector_an_requester');
			}
			
            $this->session->set_flashdata('successMsg', "Sectors details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('incubation_master/sectors');
    }
	
	public function insertProgram() {
		$this->load->model('incubation_master/sector_model');
		$program_name = $this->input->post('program_name');
		$associate_sector = $this->input->post('associate_sector');
		
		if ($program_name != '') {
			$getProgramCountDetails = $this->Common_model->get_all_details('program_type', array(), array());
			$getProgramCount = count(json_decode(json_encode($getProgramCountDetails), true));
			
			$sectorIds = '';	
			if(!empty($associate_sector)){
				$sectorIds =  implode(',',$associate_sector);
			}
			 $InsetData = array('program_id' =>$getProgramCount+1,'program_name' =>$program_name,'status' => 1,'sector'=>$sectorIds);
			 
			 $this->Common_model->insert_data('program_type', $InsetData);
			$this->session->set_flashdata('successMsg', "Program Added Successfully");
		} else {
			$this->session->set_flashdata('errormsg', 'Value Missing');
		}
		redirect('incubation_master/program_master_list');
	}

	
	 public function insertEditProgram() {
        $this->load->model('incubation_master/sector_model');
        $program_id = $this->input->post('program_id');
		$associate_sector = $this->input->post('associate_sector');
		
        if ($program_id != '') {
			$condition = array('id' => $program_id);
			$sectorIds = '';
			if(!empty($associate_sector)){
				$sectorIds = implode(',',$associate_sector);
			}
			$updateData = array('sector' => $sectorIds);
			$this->Common_model->update_data('program_type', $condition, $updateData);
            $this->session->set_flashdata('successMsg', "Program details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('incubation_master/program_master_list');
    }
	
	public function insertSector() {
		
		$this->load->model('incubation_master/sector_model');
        $sector_id = $this->input->post('sector_id');
        $sector_name = $this->input->post('sector_name');
        $associate_employee = $this->input->post('associate_employee');
        $associate_sector_lead = $this->input->post('associate_sector_lead');
		
		if($sector_name!=''){
			$pitch_id = '0';
			$parent_id = $this->session->userdata('partner_id');
			if ($this->session->userdata('user_type') != 'superadmin') {
				$partner_id = $this->session->userdata('partner_id');
				if ($partner_id == '10') {
					$pitch_id = '3';
				} else {
					$pitch_id = '1';
				}
				$InsetData = array('incubation' =>0,'status' => 1,'parent_id' => 0,'pitch' => $pitch_id,'sector'=>$sector_name,'slug'=>strtolower(str_replace(' ', '-', $sector_name)));
			} else {
				$InsetData = array('incubation' =>0,'status' => 1,'parent_id' => 0,'pitch' => $pitch_id,'sector'=>$sector_name,'slug'=>strtolower(str_replace(' ', '-', $sector_name)));
			}
             $this->Common_model->insert_data('sector_category', $InsetData);
			 $sectorId = $this->db->insert_id();
			if ($sectorId != '') {
				$data['partner_id'] = $this->session->userdata('partner_id');
				$data['sector_id'] = $sectorId;
				
				if (!empty($associate_employee)) {
					$data['employee_number'] = $_POST['associate_employee'];
					$id = $this->sector_model->addSectorIncharge($data);
				}
				if (!empty($associate_sector_lead)) {
					$data['employee_number'] = $_POST['associate_sector_lead'];
					$id = $this->sector_model->addSectorIncharge($data, 'assign_sector_lead');
				}
				
				$an_request_users = $this->input->post('an_request_users');
				if (!empty($an_request_users)) {
						$data['employee_number'] = $_POST['an_request_users'];
						$data['sector_id'] = $sectorId;
						$data['partner_id'] = $this->session->userdata('partner_id');
						$id = $this->sector_model->addanRequester($data, 'sector_an_requester');
				}
				
				$this->session->set_flashdata('successMsg', "Sectors details saved successfully");
			} else {
				$this->session->set_flashdata('errormsg', 'Value Missing');
			}
			 redirect('incubation_master/sectors'); 
		}
		
	}
	
	public function checkSectorName() {
		
		$sectorName =trim($this->input->post('sectorName'));
		$returnArr['status'] = '0';
		if($sectorName!=''){
			  if ($this->session->userdata('user_type') != 'superadmin') {
				$partner_id = $this->session->userdata('partner_id');
				if ($partner_id == '10') {
					$pitch_id = '3';
				} else {
					$pitch_id = '1';
				}
				$condition = array('pitch' => $pitch_id, 'parent_id' => 0);
			} else {
				$condition = array('parent_id' => 0);
			}
			$condition['sector'] = $sectorName;
			$checkDataExists = $this->Common_model->get_all_details('sector_category', $condition, array('id'));
			if(!empty($checkDataExists)){
				$returnArr['status'] = '1';
			}
		}
        echo json_encode($returnArr);
		
	}
	public function checkSProgramName() {
		
		$programName =trim($this->input->post('programName'));
		$returnArr['status'] = '0';
		if($programName!=''){
			$condition['program_name'] = $programName;
			$checkDataExists = $this->Common_model->get_all_details('program_type', $condition, array('id'));
			if(!empty($checkDataExists)){
				$returnArr['status'] = '1';
			}
		}
        echo json_encode($returnArr);
		
	}

    public function insertEditReason() {

        $reason_edit_id = $this->input->post('reason_edit_id');
        $reason = $this->input->post('reason');
        $status_val = $this->input->post('status');
        $branch = $this->input->post('branch');
        $status_data = '';
        $updateData = $InsetData = array();

        if (!empty($reason)) {
            $i = 0;
            foreach ($reason as $id => $value) {
                #$partner_id = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : ($this->session->userdata('partner_id'));
                $partner_id = $this->session->userdata('partner_id');
                if ($this->session->userdata('user_type') == 'superadmin') {
                    $partner_id = $branch[$id];
                }
                if ($reason[$id] != '') {
                    if ($reason_edit_id[$id] != '') {
                        $condition = array('id' => $reason_edit_id[$id]);
                        $updateData = array('master_name' => $reason[$id], 'partner_id' => $partner_id, 'status' => $status_val[$id], 'modified_date' => date('Y-m-d H:i:s'));
                        $this->Common_model->update_data('master_settings', $condition, $updateData);
                    } else {
                        $status_data = $status_val[$id];
                        if ($status_data == '') {
                            $status_data = 1;
                        }
                        $InsetData = array('master_name' => $reason[$id], 'partner_id' => $partner_id, 'status' => $status_data, 'master_type' => 'Reject Reasons', 'created_date' => date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('master_settings', $InsetData);
                    }
                    $i++;
                }
            }
            if ($i > 0) {
                $this->session->set_flashdata('successMsg', "Reason details saved successfully");
            }
        }
        redirect('incubation_master/reason');
    }

    public function insertEditPreliminary_Reason() {
        #echo'<pre>';print_r($_POST);die;
        $reason_edit_id = $this->input->post('reason_edit_id');
        $reason = $this->input->post('reason');
        $status_val = $this->input->post('status');
        $branch = $this->input->post('branch');
        $status_data = '';
        $updateData = $InsetData = array();

        if (!empty($reason)) {
            $is_record = 0;
            foreach ($reason as $id => $value) {
                $partner_id = $this->session->userdata('partner_id');
                if ($this->session->userdata('user_type') == 'superadmin') {
                    $partner_id = $branch[$id];
                }
                #echo'<pre>';print_r($reason[$id]);die;
                if ($reason[$id] != '') {
                    if ($reason_edit_id[$id] != '') {
                        $condition = array('id' => $reason_edit_id[$id]);
                        $updateData = array('name' => $reason[$id], 'partner_id' => $partner_id, 'status' => $status_val[$id]);
                        $this->Common_model->update_data('preliminary_reasons', $condition, $updateData);
                        #echo'<pre>';print_r($updateData);die
                    } else {
                        $status_data = $status_val[$id];
                        $InsetData = array('name' => $reason[$id], 'partner_id' => $partner_id, 'status' => $status_data, 'created_date' => date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('preliminary_reasons', $InsetData);
                        #echo'<pre>';print_r($InsetData);die;
                    }
                    $is_record++;
                }
            }
            if ($is_record > 0) {
                $this->session->set_flashdata('successMsg', "Preliminary reasons details saved successfully");
            }
        }
        redirect('incubation_master/preliminary_reason');
    }

    public function insertEditDonor_fit() {

        $reason_edit_id = $this->input->post('reason_edit_id');
        $reason = $this->input->post('reason');
        $status_val = $this->input->post('status');
        $branch = $this->input->post('branch');
        $status_data = '';
        $updateData = $InsetData = array();

        if (!empty($reason)) {
            $is_record = 0;
            foreach ($reason as $id => $value) {
                $partner_id = $this->session->userdata('partner_id');
                if ($this->session->userdata('user_type') == 'superadmin') {
                    $partner_id = $branch[$id];
                }
                if ($reason[$id] != '') {
                    if ($reason[$id] != '') {
                        if ($reason_edit_id[$id] != '') {
                            $condition = array('id' => $reason_edit_id[$id]);
                            $updateData = array('name' => $reason[$id], 'partner_id' => $partner_id, 'status' => $status_val[$id]);
                            $this->Common_model->update_data('donor_fit_master', $condition, $updateData);
                        } else {
                            $status_data = $status_val[$id];
                            if ($status_data == '' || $status_data == 0) {
                                $status_data = 2;
                            }
                            $InsetData = array('name' => $reason[$id], 'partner_id' => $partner_id, 'status' => $status_data, 'created_date' => date('Y-m-d H:i:s'));
                            #echo'<pre>';print_r($InsetData);die;
                            $this->Common_model->insert_data('donor_fit_master', $InsetData);
                        }
                    }
                    $is_record++;
                }
            }
            if ($is_record > 0) {
                $this->session->set_flashdata('successMsg', "Donor fit details saved successfully");
            }
        }
        redirect('incubation_master/donor_fit');
    }

    public function insertEditmaster_settings() {

        $redirect_page = $this->input->post('redirect_page');
        $reason_edit_id = $this->input->post('reason_edit_id');
        $reason = $this->input->post('reason');
        $status_val = $this->input->post('status');
        $branch = $this->input->post('branch');
        $master_type = $this->input->post('master_type');
        $status_data = '';
        $updateData = $InsetData = array();

        if (!empty($reason)) {
            $is_record = 0;
            foreach ($reason as $id => $value) {
                $partner_id = $this->session->userdata('partner_id');
                if ($this->session->userdata('user_type') == 'superadmin') {
                    $partner_id = $branch[$id];
                }
                if ($reason[$id] != '') {
                    if ($reason_edit_id[$id] != '') {
                        $condition = array('id' => $reason_edit_id[$id]);
                        $updateData = array('master_name' => $reason[$id], 'status' => $status_val[$id], 'modified_date' => date('Y-m-d H:i:s'));
                        #echo'<pre>';print_r($condition);
                        $this->Common_model->update_data('master_settings', $condition, $updateData);
                    } else {
                        $status_data = $status_val[$id];
                        $InsetData = array('master_name' => $reason[$id], 'master_type' => $this->input->post('master_type'), 'status' => $status_data, 'created_date' => date('Y-m-d H:i:s'));
                        #echo'<pre>';print_r($InsetData);
                        $this->Common_model->insert_data('master_settings', $InsetData);
                    }
                    $is_record++;
                }
            }
            if ($is_record > 0) {
                $this->session->set_flashdata('successMsg', "Records saved successfully");
            }
        }
        redirect("incubation_master/master_settings/$redirect_page");
    }

    public function insertEditportfolio_settings() {
        #echo'<pre>';print_r($_POST);

        $redirect_page = $this->input->post('redirect_page');
        $reason_edit_id = $this->input->post('reason_edit_id');
        $name = $this->input->post('name');
        $status_val = $this->input->post('status');
        $branch = $this->input->post('branch');
        $table_name = $this->input->post('table_name');
        $status_data = '';
        $updateData = $InsetData = array();

        if (!empty($name)) {
            $is_record = 0;
            foreach ($name as $id => $value) {
                $partner_id = $this->session->userdata('partner_id');
                if ($this->session->userdata('user_type') == 'superadmin') {
                    $partner_id = $branch[$id];
                }
                if ($name[$id] != '') {
                    if ($reason_edit_id[$id] != '') {
                        $condition = array('id' => $reason_edit_id[$id]);
                        $updateData = array('name' => $name[$id], 'partner_id' => $partner_id, 'status' => $status_val[$id], 'created_at' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('emp_number'));
                        #echo'<pre>';print_r($condition);
                        $this->Common_model->update_data($table_name, $condition, $updateData);
                    } else {
                        $checkCond = array('name' => $name[$id], 'partner_id' => $partner_id);
                        $checkDataExists = $this->Common_model->get_all_details($table_name, $checkCond, array('id'));


                        if (empty($checkDataExists[0])) {
                            $status_data = $status_val[$id];
                            $InsetData = array('name' => $name[$id], 'partner_id' => $partner_id, 'status' => $status_data, 'created_at' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('emp_number'));
                            $this->Common_model->insert_data($table_name, $InsetData);
                        }
                    }
                    $is_record++;
                }
            }#die;
            if ($is_record > 0) {
                $this->session->set_flashdata('successMsg', "Records saved successfully");
            }
        }
        redirect("incubation_master/portfolio_settings/$redirect_page");
    }

    public function insertEditStage_efficiency() {

        $condition = array('id' => '1');
        $updateData = array(
            'new' => $this->input->post('new'),
            'entry' => $this->input->post('entry'),
            'lead' => $this->input->post('lead'),
            'shortlisted' => $this->input->post('shortlisted'),
            'due_diligence' => $this->input->post('due_diligence'),
            'incubation' => $this->input->post('incubation')
        );
        $this->Common_model->update_data('stagefficiency', $condition, $updateData);
        $this->session->set_flashdata('successMsg', "Stage efficiency details saved successfully");
        redirect("incubation_master/stage_efficiency");
    }

    public function insertEditDocument_type() {
        #echo'<pre>';print_r($_POST);die;
        $edit_id = $this->input->post('edit_id');
        $name = $this->input->post('name');
        $status_val = $this->input->post('status');
        $status_data = '';
        $updateData = $InsetData = array();

        if (!empty($name)) {
            $is_record = 0;
            foreach ($name as $id => $value) {
                if ($name[$id] != '') {
                    if ($edit_id[$id] != '') {
                        $condition = array('id' => $edit_id[$id]);
                        $updateData = array('name' => $name[$id], 'type' => '1', 'status' => $status_val[$id]);
                        $this->Common_model->update_data('diligence_document_types', $condition, $updateData);
                    } else {
                        $status_data = $status_val[$id];
                        $InsetData = array('name' => $name[$id], 'type' => '1', 'status' => $status_data);
                        $this->Common_model->insert_data('diligence_document_types', $InsetData);
                    }
                    $is_record++;
                }
            }
            if ($is_record > 0) {
                $this->session->set_flashdata('successMsg', "Document type saved successfully");
            }
        }
        redirect('incubation_master/document_type');
    }

    public function insertEditmeeting_type() {
        #echo'<pre>';print_r($_POST);die;
        $edit_id = $this->input->post('edit_id');
        $name = $this->input->post('name');
        $status_val = $this->input->post('status');
        $status_data = '';
        $updateData = $InsetData = array();

        if (!empty($name)) {
            $is_record = 0;
            foreach ($name as $id => $value) {
                if ($name[$id] != '') {

                    if ($edit_id[$id] != '') {
                        $condition = array('id' => $edit_id[$id]);
                        $updateData = array('name' => $name[$id], 'status' => $status_val[$id]);
                        $this->Common_model->update_data('diligence_meeting_type', $condition, $updateData);
                    } else {
                        $status_data = $status_val[$id];
                        $InsetData = array('name' => $name[$id], 'status' => $status_data);
                        $this->Common_model->insert_data('diligence_meeting_type', $InsetData);
                    }
                    $is_record++;
                }
            }
            if ($is_record > 0) {
                $this->session->set_flashdata('successMsg', "Meeting type saved successfully");
            }
        }
        redirect('incubation_master/meeting_type');
    }

    public function EditMail_template() {

        $id = $this->input->post('id');
        $module = $this->input->post('module');
        $messagesubject = $this->input->post('messagesubject');
        $messagebody = $this->input->post('messagebody');
        $status = $this->input->post('status');

        if ($id != '' && $status !== '' && $module != '') {
            $condition = array('id' => $id);
            $updateData = array('messagesubject' => $messagesubject, 'messagebody' => $messagebody, 'status' => $status);
            $table = 'master_mailtemplate';
            if ($module == 1) {
                $this->Common_model->update_data('mailtemplate', $condition, $updateData, true, 'ais');
            } else {
                $this->Common_model->update_data('master_mailtemplate', $condition, $updateData);
            }
            $this->session->set_flashdata('successMsg', "Mail template saved successfully");
        }
        redirect('incubation_master/mail_template');
    }

    public function add_company_target() {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $condition1 = array('pitch' => $pitch_id);
        $data['sectorDetails'] = $this->Common_model->get_all_details('sector_category', $condition1, array());
        $data['fin_year'] = $this->Common_model->getAllFinancialYear($partner_id);
        $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        $this->load->view('incubation_masters/add_company_target', $data);
    }

    public function add_incubation_field() {

        $data['mastertype'] = $this->Common_model->getmastertype();
        $this->load->view('incubation_masters/add_incubation_field', $data);
    }

    public function add_source() {

        $data['sourceType'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Source Type'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
        $data['usersList'] = $this->Common_model->getUsersList();
        $this->load->view('incubation_masters/add_source', $data);
    }

    public function addEdit_source_instance() {

        $id = $this->uri->segment(3);
        $source_id = $this->uri->segment(4);
        $condition = array('id' => $id);
        $instance_master = $this->Common_model->get_all_details('instance_master', $condition);
        $data['instance_master'] = $instance_master[0];
        $this->load->view('incubation_masters/addEdit_source_instance', $data);
    }

    public function add_screening_field() {

        $data['criteriaList'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Grading Category'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));

        $this->load->view('incubation_masters/add_screening_field', $data);
    }

    public function add_incubation_subfield() {
        $pid = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $con = array('id' => $pid);
        $fields = array("progress_master.*,(select master_name from master_settings where id=progress_master.criteria) as criteria_title");
        $get_progress_master = $this->Common_model->get_all_details('progress_master', $con, $fields);
        $data['get_progress_master'] = $get_progress_master[0];

        $get_innovation_pool = $this->Common_model->get_all_details('innovation_pool', array('stage' => '5'), array('id', 'name_of_enterprise'));
        $data['get_innovation_pool'] = $get_innovation_pool[0];
        $data['subfieldsDetails'] = array();
        if ($id != '') {
            $con = array('id' => $id);
            $fields = array("progress_master.*,(select master_name from master_settings where id=progress_master.criteria) as criteria_title");
            $subfieldsDetails = $this->Common_model->get_all_details('progress_master', $con, $fields);
            $data['subfieldsDetails'] = $subfieldsDetails[0];
        }

        $this->load->view('incubation_masters/add_incubation_subfield', $data);
    }

    public function add_screening_subfield() {
        $fields = array("screening_master.*,(select master_name from master_settings where id=screening_master.criteria) as criteria_title");
        $id = $this->uri->segment(3);
        $con = array('id' => $id);
        $get_parent_value = $this->Common_model->get_all_details('screening_master', $con, $fields);
        $data['criteria'] = $get_parent_value[0]->criteria;
        $data['get_parent_value'] = unserialize($get_parent_value[0]->value);
        $this->load->view('incubation_masters/add_screening_subfield', $data);
    }

    public function add_assessment_field() {
        $fields = array("screening_master.*,(select master_name from master_settings where id=screening_master.criteria) as criteria_title");
        $id = $this->uri->segment(3);
        $con = array('id' => $id);
        $get_parent_value = $this->Common_model->get_all_details('screening_master', $con, $fields);
        $data['criteria'] = $get_parent_value[0]->criteria;
        $this->load->view('incubation_masters/add_assessment_field', $data);
    }

    public function edit_assessment_field() {
        $pid = $this->uri->segment(4);
        $id = $this->uri->segment(3);
        $fields = array("screening_master.*,(select master_name from master_settings where id=screening_master.criteria) as criteria_title");

        if ($pid != '') {
            $con = array('id' => $pid);
            $get_parent_value = $this->Common_model->get_all_details('screening_master', $con, $fields);
            $data['criteria'] = $get_parent_value[0]->criteria;
            $data['get_parent_value'] = unserialize($get_parent_value[0]->value);
        }
        if ($id != '') {
            $con = array('id' => $id);
            $get_subfields = $this->Common_model->get_all_details('screening_master', $con, $fields);
            $data['get_subfields'] = $get_subfields[0];
        }
        $this->load->view('incubation_masters/edit_assessment_field', $data);
    }

    public function edit_screening_subfield() {

        $pid = $this->uri->segment(4);
        $id = $this->uri->segment(3);
        $fields = array("screening_master.*,(select master_name from master_settings where id=screening_master.criteria) as criteria_title");

        if ($pid != '') {
            $con = array('id' => $pid);
            $get_parent_value = $this->Common_model->get_all_details('screening_master', $con, $fields);
            $data['criteria'] = $get_parent_value[0]->criteria;
            $data['get_parent_value'] = unserialize($get_parent_value[0]->value);
        }
        if ($id != '') {
            $con = array('id' => $id);
            $get_subfields = $this->Common_model->get_all_details('screening_master', $con, $fields);
            $data['get_subfields'] = $get_subfields[0];
        }
        #echo'<pre>';print_r($data['get_subfields']);die;
        $this->load->view('incubation_masters/edit_screening_subfield', $data);
    }

    public function edit_source() {

        $id = $this->uri->segment(3);
        $con = array('id' => $id);
        $getsource_master = $this->Common_model->get_all_details('source_master', $con, array());
        $data['source_master'] = $getsource_master[0];
        $data['sourceType'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Source Type'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
        $data['usersList'] = $this->Common_model->getUsersList();

        #echo'<pre>';print_r($getsource_master);die;
        $this->load->view('incubation_masters/edit_source', $data);
    }

    public function edit_incubation_subfield() {


        $pid = $this->uri->segment(4);
        $id = $this->uri->segment(3);
        $con = array('id' => $pid);
        $fields = array("progress_master.*,(select master_name from master_settings where id=progress_master.criteria) as criteria_title");
        $get_progress_master = $this->Common_model->get_all_details('progress_master', $con, $fields);
        $data['get_progress_master'] = $get_progress_master[0];

        $get_innovation_pool = $this->Common_model->get_all_details('innovation_pool', array('stage' => '5'), array('id', 'name_of_enterprise'));
        $data['get_innovation_pool'] = $get_innovation_pool[0];
        $data['subfieldsDetails'] = array();
        if ($id != '') {
            $con = array('id' => $id);
            $fields = array("progress_master.*,(select master_name from master_settings where id=progress_master.criteria) as criteria_title");
            $subfieldsDetails = $this->Common_model->get_all_details('progress_master', $con, $fields);
            $data['subfieldsDetails'] = $subfieldsDetails[0];
        }

        $data['mastertype'] = $this->Common_model->getmastertype();
        #echo'<pre>';print_r($data);die;


        $this->load->view('incubation_masters/edit_incubation_subfield', $data);
    }

    public function edit_screening_field() {

        $id = $this->uri->segment(3);
        $con = array('id' => $id);
        $field = array('screening_master.*,(select master_name from master_settings where id=screening_master.criteria) as criteria_title');
        $screening_master = $this->Common_model->get_all_details('screening_master', $con, $field);
        $data['screening_master'] = $screening_master[0];

        $data['criteriaList'] = $this->Common_model->get_all_details('master_settings', array('status' => '1', 'master_type' => 'Grading Category'), array('master_name', 'id'), '', '', array('master_name' => 'asc'));
        #echo'<pre>';print_r($data);die;
        $this->load->view('incubation_masters/edit_screening_field', $data);
    }

    public function ajax_criteria() {
        $returnArr['status'] = '0';
        $mastertype = $this->input->post('mastertypes');
        $selected_criteria = $this->input->post('selected_criteria');
        $get_masterData = $this->Common_model->get_all_details('master_settings', array('master_type' => $mastertype), array('id', 'master_name'));

        if (!empty($get_masterData)) {
            $option = '<option  value="" >--Select--</option>';
            foreach ($get_masterData as $lists) {
                $selected_opt = '';
                if (isset($selected_criteria) && $selected_criteria != '') {
                    if ($selected_criteria == $lists->id) {
                        $selected_opt = 'selected';
                    }
                }
                $option .= '<option  ' . $selected_opt . ' value="' . $lists->id . '" >' . $lists->master_name . '</option>';
                $returnArr['status'] = '1';
            }
        }
        $returnArr['response'] = $option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    public function view_company_target() {
        $id = $this->uri->segment(3);
        if ($id != '') {

            $get_companyData = $this->Common_model->get_all_details('port_dashboard_master', array('id' => $id), array());
            $partner_id = $this->session->userdata('partner_id');
            $data['companyData'] = $get_companyData[0];
            if ($partner_id == '10') {
                $pitch_id = '3';
            } else {
                $pitch_id = '1';
            }
            $condition1 = array('pitch' => $pitch_id);
            $data['sectorDetails'] = $this->Common_model->get_all_details('sector_category', $condition1, array());
            $data['fin_year'] = $this->Common_model->getAllFinancialYear($partner_id);
            $data['barnch_details'] = $getBranch_records = $this->Common_model->get_all_details('hs_hr_branch', array('status' => 'active'), array(), '', '', '', true, 'hris');
        }
        $this->load->view('incubation_masters/edit_company_target', $data);
    }

    public function view_mail_template() {
        $id = $this->uri->segment(3);
        $moudle = $this->uri->segment(4);
        if ($id != '' && $moudle != '') {
            if ($moudle == 1) {
                $data['mail_details'] = $get_details = $this->Common_model->get_all_details('mailtemplate', array('id' => $id), array(), '', '', '', true, 'ais');
            } else {
                $data['mail_details'] = $get_mailData = $this->Common_model->get_all_details('master_mailtemplate', array('id' => $id), array());
            }
            $data['module_type'] = $moudle;
        }
        $this->load->view('incubation_masters/view_mail_template', $data);
    }

    public function insertcompany_target() {

        $partner_type = isset($_POST['partner_id']) && $_POST['partner_id'] != '' ? $_POST['partner_id'] : $this->session->userdata('partner_id');
        $sector = $this->input->post('sector');
        $financial_year = $this->input->post('financial_year');
        $partner_id = $this->input->post('partner_id');
        $status = $this->input->post('status');
        if ($sector != '' && $financial_year != '' && $partner_id != '') {
            $checkCond = array('partner_id' => $partner_type, 'financial_year' => $financial_year, 'sector' => $sector, 'status !=' => '3');
            $checkDataExists = $this->Common_model->get_all_details('port_dashboard_master', $checkCond, array('id'));
            if (!empty($checkDataExists[0])) {
                $this->session->set_flashdata('errorMsg', "Record already exists");
            } else {
                $post_data = $_POST;
                unset($post_data['partner_id']);
                $post_data['partner_id'] = $partner_type;
                $post_data['created_by'] = $this->session->userdata('emp_number');
                $post_data['created_at'] = date('Y-m-d H:i:s');
                $InsertData = $post_data;
                $this->Common_model->insert_data('port_dashboard_master', $InsertData);
                $this->session->set_flashdata('successMsg', "Records saved successfully");
            }
        }
        redirect('incubation_master/portfolio_settings/company_target');
    }

    public function insertincubation_field() {
        #echo'<pre>';print_r($_POST);die;
        $incubation_field_id = $this->input->post('incubation_field_id');
        $post_data = $_POST;
        if (!empty($post_data)) {
            $values = serialize(array_filter($this->input->post('value')));
            unset($post_data['value']);
            $post_data['value'] = $values;
            $post_data['type'] = 'metrices';
            if ($incubation_field_id != '') {
                unset($post_data['incubation_field_id']);
                $id = $this->input->post('incubation_field_id');
                $condition = array('id' => $id);
                $updateData = $post_data;
                $this->Common_model->update_data('progress_master', $condition, $updateData);
            } else {
                $fields = array('max(`order`)+1 as total');
                $con = array('criteria' => $this->input->post('criteria'), 'pid' => '0');
                $Totalcount = $this->Common_model->get_all_details('progress_master', $con, $fields);
                $count_totalData = $Totalcount[0]->total;
                $post_data['order'] = $count_totalData;
                $this->Common_model->insert_data('progress_master', $post_data);
            }
            $this->session->set_flashdata('successMsg', "Record saved successfully");
        }
        redirect('incubation_master/incubation_progress');
    }

    public function insertincubation_subfield() {
        #echo'<pre>';print_r($_POST);die;
        $pid = $this->input->post('pid');
        $id = $this->input->post('id');
        $post_data = $_POST;
        if (!empty($post_data)) {
            $values = serialize(array_filter($this->input->post('value')));
            unset($post_data['value']);
            unset($post_data['type']);
            unset($post_data['criteria']);
            unset($post_data['mastertype']);
            unset($post_data['subcategory']);
            unset($post_data['period']);
            unset($post_data['type']);
            $post_data['value'] = $values;
            $post_data['type'] = 'metrices';
            if ($id != '') {
                unset($post_data['id']);
                $id = $this->input->post('id');
                $condition = array('id' => $id);
                $updateData = $post_data;
                $this->Common_model->update_data('progress_master', $condition, $updateData);
            } else {
                $this->Common_model->insert_data('progress_master', $post_data);
            } #echo'<pre>';print_r($condition);die;
            $this->session->set_flashdata('successMsg', "Record saved successfully");
        }
        redirect('incubation_master/incubation_progress');
    }

    public function insertEdit_screeningSub() {

        $pid = $this->input->post('pid');
        $id = $this->input->post('id');
        $post_data = $_POST;
        if (!empty($post_data)) {
            $values = serialize(array_filter($this->input->post('value')));
            unset($post_data['value']);
            $post_data['value'] = $values;
            if ($id != '') {
                unset($post_data['criteria']);
                unset($post_data['id']);
                $id = $this->input->post('id');
                $condition = array('id' => $id);
                $updateData = $post_data;
                $this->Common_model->update_data('screening_master', $condition, $updateData);
            } else {
                $this->Common_model->insert_data('screening_master', $post_data);
            }
            $this->session->set_flashdata('successMsg', "Record saved successfully");
        } #echo'<pre>';print_r($updateData);die;
        redirect("incubation_master/screening_subfields/$pid");
    }

    public function insertEdit_assessment() {

        $pid = $this->input->post('pid');
        $id = $this->input->post('id');
        $post_data = $_POST;
        if (!empty($post_data)) {
            $values = serialize(array_filter($this->input->post('value')));
            unset($post_data['value']);
            $post_data['value'] = $values;
            if ($id != '') {
                unset($post_data['criteria']);
                unset($post_data['id']);
                $id = $this->input->post('id');
                $condition = array('id' => $id);
                $updateData = $post_data;
                $this->Common_model->update_data('screening_master', $condition, $updateData);
            } else {
                $fields = array('max(`order`)+1 as total');
                $con = array('parent_value' => null, 'pid' => $id);
                $Totalcount = $this->Common_model->get_all_details('screening_master', $con, $fields);
                $count_totalData = $Totalcount[0]->total;
                $post_data['order'] = $count_totalData;
                $this->Common_model->insert_data('screening_master', $post_data);
            }
            $this->session->set_flashdata('successMsg', "Record saved successfully");
        } #echo'<pre>';print_r($updateData);die;
        redirect("incubation_master/assessment/$pid");
    }

    public function insert_screening_field() {

        $id = $this->input->post('id');
        $post_data = $_POST;
        if (!empty($post_data)) {

            if ($id != '') {
                $values = serialize(array_filter($this->input->post('value')));
                unset($post_data['id']);
                unset($post_data['value']);
                $post_data['value'] = $values;
                $id = $this->input->post('id');
                $condition = array('id' => $id);
                $updateData = $post_data;
                $this->Common_model->update_data('screening_master', $condition, $updateData);
            } else {
                $fields = array('max(`order`)+1 as total');
                $con = array('criteria' => $this->input->post('criteria'), 'pid' => '0');
                $Totalcount = $this->Common_model->get_all_details('screening_master', $con, $fields);
                $count_totalData = $Totalcount[0]->total;
                $post_data['order'] = $count_totalData;
                #echo'<pre>';print_r($post_data);die;
                $this->Common_model->insert_data('screening_master', $post_data);
            }
            $this->session->set_flashdata('successMsg', "Record saved successfully");
        }
        redirect('incubation_master/screening_master');
    }

    public function insertEdit_programService() {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $program_type = $this->input->post('program_type');
        $description = $this->input->post('description');
        if ($id != '') {
            $condition = array('id' => $id);
            $updateData = array('program_type' => $program_type, 'title' => $title, 'description' => $description);
            $this->Common_model->update_data('program_service_offering', $condition, $updateData);
        } else {
            $insertData = array('program_type' => $program_type, 'title' => $title, 'description' => $description);
            $this->Common_model->insert_data('program_service_offering', $insertData);
        }
        $this->session->set_flashdata('successMsg', "Record saved successfully");
        redirect('incubation_master/program_service_master');
    }

    public function insertEdit_programStage() {

        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $program_service_offering = $this->input->post('program_service_offering');
        if ($id != '') {
            $condition = array('id' => $id);
            $updateData = array('program_service_offering' => $program_service_offering, 'title' => $title, 'modified_date' => date('Y-m-d H:i:s'), 'modified_by' => $this->session->userdata('emp_number'));
            $this->Common_model->update_data('program_stage', $condition, $updateData);
        } else {
            $insertData = array('program_service_offering' => $program_service_offering, 'title' => $title, 'created_date' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('emp_number'));
            $this->Common_model->insert_data('program_stage', $condition, $updateData);
        }
        $this->session->set_flashdata('successMsg', "Record saved successfully");
        redirect('incubation_master/program_stage_master');
    }

    public function insertEdit_grading_master() {
        $id = $this->input->post('id');
        $program_stage = $this->input->post('program_stage');
        $category = $this->input->post('category');
        $criteria = $this->input->post('criteria');
        $waitage = $this->input->post('waitage');
        $scale = $this->input->post('scale');
        $scaling_factor = serialize($this->input->post('scaling_factor'));
        if ($id != '') {
            $condition = array('id' => $id);
            $updateData = array('category' => $category, 'criteria' => $criteria, 'waitage' => $waitage, 'scale' => $scale, 'scaling_factor' => $scaling_factor, 'modified_date' => date('Y-m-d H:i:s'), 'modified_by' => $this->session->userdata('emp_number'));
            #echo'<pre>';print_r($condition);die;
            $this->Common_model->update_data('grading_master', $condition, $updateData);
        } else {
            $insertData = array('program_stage' => $program_stage, 'category' => $category, 'criteria' => $criteria, 'waitage' => $waitage, 'scale' => $scale, 'scaling_factor' => $scaling_factor, 'created_date' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('emp_number'));
            $this->Common_model->insert_data('grading_master', $updateData);
        }
        $this->session->set_flashdata('successMsg', "Record saved successfully");
        redirect('incubation_master/grading_master');
    }

    public function insertEdit_source() {

        $id = $this->input->post('id');

        $data = array('employee' => $this->input->post('employee'), 'source_type' => $this->input->post('source_type'),
            'source_name' => $this->input->post('source_name'), 'contact_person' => $this->input->post('contact_person'),
            'designation' => $this->input->post('designation'), 'address' => $this->input->post('address'), 'phone' => $this->input->post('phone'),
            'mobile' => $this->input->post('mobile'), 'email' => $this->input->post('email'), 'fax' => $this->input->post('fax'),
            'frequency' => $this->input->post('frequency'), 'date' => date('Y-m-d H:i:s', strtotime($this->input->post('date'))),
            'alert' => $this->input->post('alert'), 'link' => $this->input->post('link'), 'username' => $this->input->post('username'), 'password' => $this->input->post('password'), 'pagecontent' => $this->input->post('pagecontent'), 'description' => $this->input->post('description'));


        $_POST['document'] = '';
        $config['file_name'] = '';
        $file_name = '';
        if ($_FILES['document']['name'] != '') {
            $config['upload_path'] = './uploads/source';
            $config['allowed_types'] = 'gif|jpg|png|pdf|doc|txt';
            #$config['encrypt_name'] = FALSE;
            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $_FILES['document']['name']);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('document')) {
                $data['errorMsg'] = $this->upload->display_errors();
            } else {
                $file_name = $config['file_name'];
                #$_POST['document'] = $config['file_name'];
            }
        }
        if ($id != '') {
            $condition = array('id' => $id);
            if ($file_name != '') {
                $data['document'] = $file_name;
                @unlink('uploads/source/' . $_POST['document']);
            }
            $data['modified_date'] = date('Y-m-d H:i:s');
            $data['modified_by'] = $this->session->userdata('emp_number');
            $this->Common_model->update_data('source_master', $condition, $data);
        } else {
            #echo '<pre>';print_r($data);die;
            $data['document'] = $file_name;
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('emp_number');
            $this->Common_model->insert_data('source_master', $data);
        }
        #echo'<pre>';print_r($data);die;
        $this->session->set_flashdata('successMsg', "Record saved successfully");
        redirect('incubation_master/source_instance_master');
    }

    public function insertEdit_sourceInstance() {
        $id = $this->input->post('id');
        $source_id = $this->input->post('source_id');
        $data = array(
            'source_id' => $this->input->post('source_id'),
            'instance_name' => $this->input->post('instance_name'),
            'date' => date('Y-m-d H:i:s', strtotime($this->input->post('date'))),
            'remarks' => $this->input->post('remarks'),
        );
        $_POST['document'] = '';
        $config['file_name'] = '';
        $file_name = '';
        if ($_FILES['document']['name'] != '') {
            $config['upload_path'] = './uploads/instance';
            $config['allowed_types'] = 'gif|jpg|png|pdf|doc|txt';
            #$config['encrypt_name'] = FALSE;
            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $_FILES['document']['name']);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('document')) {
                $data['errorMsg'] = $this->upload->display_errors();
            } else {
                $file_name = $config['file_name'];
            }
        }
        if ($id != '') {
            $condition = array('id' => $id);
            if ($file_name != '') {
                $data['document'] = $file_name;
                @unlink('uploads/instance/' . $_POST['document']);
            }
            $data['modified_date'] = date('Y-m-d H:i:s');
            $data['modified_by'] = $this->session->userdata('emp_number');
            $this->Common_model->update_data('instance_master', $condition, $data);
        } else {
            $data['document'] = $file_name;
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('emp_number');
            $this->Common_model->insert_data('instance_master', $data);
        }

        $this->session->set_flashdata('successMsg', "Record saved successfully");
        redirect("incubation_master/view_source_instance/$source_id");
    }

    public function Editcompany_target() {
        $id = $this->input->post('id');
        if ($id != '') {
            $partner_type = isset($_POST['partner_id']) && $_POST['partner_id'] != '' ? $_POST['partner_id'] : $this->session->userdata('partner_id');
            $sector = $this->input->post('sector');
            $financial_year = $this->input->post('financial_year');
            $partner_id = $this->input->post('partner_id');
            if ($sector != '' && $financial_year != '' && $partner_id != '') {
                $checkCond = array('id !=' => $id, 'partner_id' => $partner_type, 'financial_year' => $financial_year, 'sector' => $sector, 'status !=' => '3');
                $checkDataExists = $this->Common_model->get_all_details('port_dashboard_master', $checkCond, array('id'));
                if (!empty($checkDataExists[0])) {
                    $this->session->set_flashdata('errorMsg', "Record already exists");
                } else {
                    $post_data = $_POST;
                    unset($post_data['partner_id']);
                    unset($post_data['id']);
                    $post_data['partner_id'] = $partner_type;
                    $post_data['created_by'] = $this->session->userdata('emp_number');
                    $post_data['created_at'] = date('Y-m-d H:i:s');
                    $condition = array('id' => $id);
                    $updateData = $post_data;
                    $this->Common_model->update_data('port_dashboard_master', $condition, $updateData);
                    $this->session->set_flashdata('successMsg', "Records saved successfully");
                }
            }
        }
        redirect('incubation_master/portfolio_settings/company_target');
    }

    public function ajax_incubation_pm_export() {
        $returnArr['status'] = '1';
        $orderby = array('mastertype' => 'asc');
        $getprogress_master = $this->Common_model->get_all_details('progress_master', array(), array(), '', '', $orderby);
        $data['exceloutput'] = $getprogress_master = json_decode(json_encode($getprogress_master), true);
        $this->load->view('incubation_masters/exceloutput', $data);
    }

    public function ajax_source_export() {

        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("Documents Master List")
        ->setSubject("Documents Master List")
        ->setDescription("Documents Master List")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Documents Master List");

        $styletitle = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
        );

        $getCountDetails = $this->Common_model->get_source_master($optionsCount, $condition);
        $count_num = count($getCountDetails);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Source Type');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Source Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Employee');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Contact Person');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Designation');
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);

        $i = 2;

        $source = $this->input->post('source');
        $source_type = $this->input->post('source_type');
        $source_name = $this->input->post('source_name');
        $search_field = $this->input->post('search_field');
        $contact_person = $this->input->post('contact_person');

        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            $isAuth = true;
            $columnArr = array('', 'master_name', 'source_name', 'emp_name', 'contact_person', 'designation', 'status');
        } else {
            $options['employee'] = $this->session->userdata('emp_number');
            $optionsCount['employee'] = $this->session->userdata('emp_number');
            $isAuth = false;
            $columnArr = array('master_name', 'source_name', 'emp_name', 'contact_person', 'designation');
        }

        if ($source == 1) {
            unset($optionsCount['employee']);
            unset($options['employee']);
        }
        if ($source_type != '') {
            $optionsCount['source_type'] = $source_type;
            $options['source_type'] = $source_type;
        }
        if ($source_type != '') {
            $optionsCount['source_name'] = $source_name;
            $options['source_name'] = $source_name;
        }
        if ($source_type != '') {
            $optionsCount['contact_person'] = $contact_person;
            $options['contact_person'] = $contact_person;
        }


        $start = $this->input->post('start');
        $options['num'] = 10;
        $options['offset'] = $start;
        if ($columnArr[$columnIndex] != '') {
            $optionsCount['orderby'] = $columnArr[$columnIndex];
            $optionsCount['ordertype'] = $columnSortOrder;

            $options['orderby'] = $columnArr[$columnIndex];
            $options['ordertype'] = $columnSortOrder;
        }
        $condition = array();

        $search_field = $this->input->post('search_field');
        if ($search_field != '') {
            $condition['label LIKE'] = "%$search_field%";
        }
        $getCountDetails = $this->Common_model->get_source_master($options, $condition);
        /* echo'<pre>';print_r($options);
          echo'<pre>';print_r($condition);
          echo'<pre>';print_r($getCountDetails);die; */

        foreach ($getCountDetails as $list) {#echo'<pre>';print_r($list);die;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $list['master_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $list['source_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $list['emp_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $list['contact_person']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $list['designation']);
        $i++;
    }

    $file_name = 'source_master.xlsx';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file_name . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');

    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    $objWriter->save('php://output');
    exit;
}

public function commonDelete() {
    $id = array_filter($this->input->post('id'));
    $table = $this->input->post('table');
    $returnArr['status'] = '0';
    if (!empty($id) && $table != '') {
        $returnArr['status'] = '1';
        $condition = array('id' => $id);
        $this->Common_model->delete_data_in($table, $condition);
        $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
    }
    echo json_encode($returnArr);
}

function user_setup_sa() {
    $branch = $this->input->post('branch');
    $users = $this->Common_model->getUsersList_sa($branch);
    $default = $this->Common_model->getUserSetup($branch);
    $defaultval = array();
    if (!empty($default)) {
        $defaultval = $default;
    }
    echo json_encode(array('users' => $users, 'defaultt' => $defaultval));
}

}

?>
