<?php

class Master extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->Mauth->isLoggedCheck();
        $this->load->model('master/Mmaster');
        $this->load->model('login/Muser');
        $this->load->model('master_pro/common_model');
        //$this->load->library('pagination');
    }
    public function master_settings() { #echo'<pre>';print_r($_POST); die;
        checkAuth();
        $setting_type =  $this->uri->segment(4);

        if(isset($setting_type) && $setting_type!=''){
            $data['filter_val'] = '';
            $table_name = 'master_settings';
            $data['tab_title'] = '';
            $data['donorList'] = $data['donorList_search'] = $data['get_results'] = array();
            $fields = array();
            $condition = array();
            $change_db = true; $db_name = 'ais';
            $countField = array('master_id');
            if($setting_type == 'travel_mode'){
                $condition = array('master_type'=>'Travel Mode','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'Travel Mode';
            }else if($setting_type == "books_category"){
                $condition = array('master_type'=>'Books Category','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'Books Category';
            }else if($setting_type == 'general_asset'){
                $condition = array('master_type'=>'General Asset','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'General Asset';
            }else if($setting_type == 'it_asset'){
                $condition = array('master_type'=>'IT Asset','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'IT Asset';
            }else if($setting_type == 'business_card_catsset'){
                $condition = array('master_type'=>'Business Card Category','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'Business Card Category';
            }else if($setting_type == 'utilities'){
                $condition = array('master_type'=>'Utilities Type','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'Utilities Type';
            }else if($setting_type == 'pay_grade'){
                $table_name = 'hr_salary_grade';
                $condition = array();
                $data['tab_title'] = 'Pay Grade';
                $change_db = false;$db_name = '';
                $countField = array('id');
            }else if($setting_type == 'job_specification'){
                $table_name = 'hr_job_specification';
                $condition = array();
                $data['tab_title'] = 'Job Specification';
                $change_db = false;$db_name = '';
                $countField = array('id');
            }

            $search_base_url = site_url('master_pro/master/master_settings/'.$setting_type.'?');
            $donor_val = base64_decode($this->input->get('donor_val'));
            $donor_filter = '';
            if($donor_val!=''){
                $condition['pid'] = $donor_val;
                $donor_filter = '&donor_val='.$this->input->get('donor_val');
                $data['donor_val'] = $donor_val;
                $search_base_url = site_url('master_pro/master/master_settings/'.$setting_type.'?'.$donor_filter);
            }    
            $filter_val = base64_decode($this->input->get('filter_val'));
            if($filter_val!=''){
                if($setting_type == 'pay_grade'){
                    $condition['grade_name'] = trim($filter_val);
                    $data['filter_val'] = $filter_val;
                    $search_filter = 'filter_val='.$this->input->get('filter_val');
                }else if($setting_type == 'job_specification'){
                    $condition['specification_name'] = trim($filter_val);
                    $data['filter_val'] = $filter_val;
                    $search_filter = 'filter_val='.$this->input->get('filter_val');
                }else{
                    $condition['master_name'] = trim($filter_val);
                    $data['filter_val'] = $filter_val;
                    $search_filter = 'filter_val='.$this->input->get('filter_val');
                }
                $search_base_url = site_url('master_pro/master/master_settings/'.$setting_type.'?'.$search_filter.$donor_filter);
            }
            $getMasterData_count = $this->common_model->get_all_details($table_name,$condition,$countField,'','','',$change_db,$db_name);
            
            $start ='';
            if($this->input->get('per_page')!=''){
                $start = $this->input->get('per_page');
            }
            $limit = 10;
            #echo'<pre>';print_r($fields);die;
            $data['get_results'] = $master_get_results = $this->common_model->get_all_details($table_name,$condition,$fields,$limit,$start,'',$change_db,$db_name);
            
            #echo'<pre>';print_r($master_get_results);die;
            if($setting_type == 'budget_head'){
                $data['donorList'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
            }  
            if($setting_type == 'line_item'){
                $data['donorList_search'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
                $data['budgetList'] = $this->common_model->getMasterSetting('Budget Head','','','',true,'ais');
            }  
            #echo'<pre>';print_r($data);die;
            $this->load->library('pagination');
            $config['num_links'] = 10;
            $config['display_pages'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = $search_base_url;
            $config['total_rows'] = php72_count($getMasterData_count);
            $config['per_page'] = $limit;
            $config['uri_segment'] = 4;
            $config['num_links'] = 3;
            
            #echo'<pre>';print_r($config);die;
            $this->pagination->initialize($config);
            $data['pagination'] =  $this->pagination->create_links('display_lists');
        }
        $data['cpage'] = 'master_settings/master_settings';
        $data['cpagetitle'] = 'Master Options';

        if($setting_type=='copy'){
            $data['cpage'] = 'master_settings/display_master_settings_copy';
            $data['cpagetitle'] = 'Master Options';
        }
        
        $form_type =  $this->input->post('form_type');
        $filter_type =  $this->input->post('filter_type');

        if($setting_type=='pay_grade' || $form_type=='pay_grade'){ #echo'd';die;

            $data['form_type'] = $form_type;
            $data['filter_type'] = $filter_type;
            $data['cpage'] = 'master_settings/display_master_settings';
            $data['cpagetitle'] = 'Master Options';
        }
        $this->load->view('../templates/common_template', $data);
    }

    public function disaplay_asset() {
        checkAuth();
        $setting_type =  $this->uri->segment(4);
        if(isset($setting_type) && $setting_type!=''){
            $data['filter_val'] = '';
            $table_name = 'master_settings';
            $data['tab_title'] = '';
            $data['donorList'] = $data['donorList_search'] = $data['get_results'] = array();
            $fields = array();
            $condition = array(); #error_reporting(-1);
            if($setting_type == 'donor'){
                $condition = array('master_type'=>'Donor','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'Donor';
            }else if($setting_type == 'budget_head'){
                $data['donorList'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
                $condition = array('master_type'=>'Budget Head','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'Budget Head';
            }else if($setting_type == 'line_item'){
                $data['donorList_search'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
                $data['budgetList'] = $this->common_model->getMasterSetting('Budget Head','','','',true,'ais');
                $condition = array('master_type'=>'Line Item','partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'Line Item';
            }else if($setting_type == 'additional_info'){
                $data['donorList'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
                $con_addInfo = array('status'=>1,'partner_id'=>$this->session->userdata('partner_id'));
                $data['programme'] = $this->common_model->get_all_details('master_programme',$con_addInfo,array('programme_id','programme'),'','','',true,'ais');
                $data['budgetList'] = $this->common_model->getMasterSetting('Budget Head','','','',true,'ais');
                $data['lineitemList'] = $this->common_model->getMasterSetting('Line Item', NULL, '','',true,'ais');
                $condition = array('partner_id'=>$this->session->userdata('partner_id'));
                $data['tab_title'] = 'Additional info';
            }
            #echo'<pre>';print_r($data['lineitemList']);die;
            
            $search_base_url = site_url('master_pro/master/disaplay_asset/'.$setting_type.'?');
            $donor_val = base64_decode($this->input->get('donor_val'));
            $donor_filter = '';
            if($donor_val!=''){
                $condition['pid'] = $donor_val;
                $donor_filter = '&donor_val='.$this->input->get('donor_val');
                $data['donor_val'] = $donor_val;
                $search_base_url = site_url('master_pro/master/disaplay_asset/'.$setting_type.'?'.$donor_filter);
            }
            $budget_id = base64_decode($this->input->get('budget_id'));
            $donor_id = base64_decode($this->input->get('donor_id'));
            $budget_filter = '';
            if($budget_id!=''){
                $condition['pid'] = $budget_id;
                $budget_filter = '&budget_id='.$this->input->get('budget_id');
                if($donor_id !=''){
                    $budget_filter = '&budget_id='.$this->input->get('budget_id').'&donor_id='.$this->input->get('donor_id');
                }
                $data['budget_id'] = $budget_id;
                $data['donor_id'] = $donor_id;
                $search_base_url = site_url('master_pro/master/disaplay_asset/'.$setting_type.'?'.$budget_filter);
            }
            $addinfo_search_base_url = $search_filter ='';
            if($setting_type == 'additional_info'){
                $programmes_filter = base64_decode($this->input->get('programmes_filter'));
                $donor_filter = base64_decode($this->input->get('donor_filter'));
                $budget_filter = base64_decode($this->input->get('budget_filter'));
                $lineitemList_filter = base64_decode($this->input->get('lineitemList_filter'));
                if($programmes_filter!=''){
                    $search_filter = 'programmes_filter='.$this->input->get('programmes_filter');
                    $condition['programme']= $data['programmes_filter']= $programmes_filter;
                }
                if($donor_filter!=''){
                    $search_filter = $search_filter.'&donor_filter='.$this->input->get('donor_filter');
                    $condition['donor']= $data['donor_filter']= $donor_filter;
                }
                if($budget_filter!=''){
                    $search_filter = $search_filter.'&budget_filter='.$this->input->get('budget_filter');
                    $condition['budgethead']= $data['budget_filter']= $budget_filter;
                }
                if($lineitemList_filter!=''){
                    $search_filter = $search_filter.'&lineitemList_filter='.$this->input->get('lineitemList_filter');
                    $condition['lineitem']= $data['lineitemList_filter']= $lineitemList_filter;
                }
                $addinfo_search_filter =  $search_filter;
                $search_base_url = site_url('master_pro/master/disaplay_asset/'.$setting_type.'?'.$search_filter.$donor_filter.$budget_filter);
            }
            $filter_val = base64_decode($this->input->get('filter_val'));
            if($filter_val!=''){
                if($setting_type == 'additional_info'){
                    $condition['additionalinfo'] = trim($filter_val);
                    $data['filter_val'] = $filter_val;
                    $search_filter = 'filter_val='.$this->input->get('filter_val');
                    $search_base_url = site_url('master_pro/master/disaplay_asset/'.$setting_type.'?'.$search_filter.$addinfo_search_filter);
                }else{
                    $condition['master_name'] = trim($filter_val);
                    $data['filter_val'] = $filter_val;
                    $search_filter = 'filter_val='.$this->input->get('filter_val');
                    $search_base_url = site_url('master_pro/master/disaplay_asset/'.$setting_type.'?'.$search_filter.$donor_filter.$budget_filter);
                }       
            }
            
            #echo $search_base_url;die;
            $start ='';
            if($this->input->get('per_page')!=''){
                $start = $this->input->get('per_page');
            }
            $limit = 10;
            #echo'<pre>';print_r($condition);die;
            if($setting_type == 'additional_info'){#echo'<pre>';print_r($condition);die;
                $cpage = 'master_settings/additional_info';
                $orderby= array("id"=>"desc");
                $getMasterData_count = $this->common_model->get_all_details('additional_info',$condition,array(),'','',$orderby,true,'ais');
                $data['get_results'] = $master_get_results = $this->common_model->get_all_details('additional_info',$condition,array(),$limit,$start,$orderby,true,'ais');
            }else{
                $getMasterData_count = $this->common_model->get_all_details($table_name,$condition,array('master_id'),'','','',true,'ais');
                $data['get_results'] = $master_get_results = $this->common_model->get_all_details($table_name,$condition,$fields,$limit,$start,'',true,'ais');
                $cpage = 'master_settings/asset_settings';
            }
            #echo'<pre>';print_r($master_get_results);die;
           
            $this->load->library('pagination');
            $config['num_links'] = 10;
            $config['display_pages'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['base_url'] = $search_base_url;
            $config['total_rows'] = php72_count($getMasterData_count);
            $config['per_page'] = $limit;
            $config['uri_segment'] = 4;
            $config['num_links'] = 3;
            
            #echo'<pre>';print_r($data);die;
            $this->pagination->initialize($config);
            $data['pagination'] =  $this->pagination->create_links('display_lists');
        }
        $data['cpage'] = $cpage;
        $data['cpagetitle'] = 'Master Options';
        $this->load->view('../templates/common_template', $data);
    }

    public function disaplay_add_asset_form() {
        $data['menuMaster'] = array('travel_mode' => 'Travel Mode','books_category' => 'Books Category','general_asset' => 'General Asset',
            'it_asset' => 'IT Asset','business_card' => 'Business Card Category','utilities_type' => 'Utilities Type',
            'donor' => 'Donor','budget_head' => 'Budget Head','line_item' => 'Line Item','partner_currency' => 'Currency','additional_info' => 'Additional info');
       
        $form_titles = array('travel_mode' => 'Travel Mode','books_category' => 'Books Category','general_asset' => 'General Asset',
        'it_asset' => 'IT Asset','business_card_catsset' => 'Business Card Category','utilities' => 'Utilities Type',
        'donor' => 'Donor','budget_head' => 'Budget Head','line_item' => 'Line Item','partner_currency' => 'Currency','additional_info' => 'Additional info');

        $form_mode =  $this->uri->segment(4);
        $data['cpage'] = 'master_settings/add_asset_settings';
        $data['cpagetitle'] = 'Master Options';
        $data['tab_title'] = $form_titles[$form_mode];
        $data['donorList'] = array();
        if($form_mode == 'budget_head'){
            $data['donorList'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
        }
        if($form_mode == 'line_item'){
            $data['donorList'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
        }
        if($form_mode == 'additional_info'){
            $data['donorList'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
            $data['programme'] = $this->common_model->get_all_details('master_programme',$con_addInfo,array('programme_id','programme'),'','','',true,'ais');
            $data['budgetList'] = $this->common_model->getMasterSetting('Budget Head','','','',true,'ais');
            $data['lineitemList'] = $this->common_model->getMasterSetting('Line Item', NULL, '','',true,'ais');
            $data['tab_title'] = 'Additional Info';
            $data['cpage'] = 'master_settings/add_additional_info';
        }
        $this->load->view('../templates/common_template', $data);
    }

    public function disaplay_add_edit_form() {
        //Dropdown
        $data['menuMaster'] = array('travel_mode' => 'Travel Mode','books_category' => 'Books Category','general_asset' => 'General Asset',
            'it_asset' => 'IT Asset','business_card' => 'Business Card Category','utilities_type' => 'Utilities Type',
            'pay_grade'=>'Pay grade','job_specification'=>'Job specification');
        //Title
        $form_titles = array('travel_mode' => 'Travel Mode','books_category' => 'Books Category','general_asset' => 'General Asset',
        'it_asset' => 'IT Asset','business_card_catsset' => 'Business Card Category','utilities' => 'Utilities Type',
       'pay_grade'=>'Grade name','job_specification'=>'Specification Name');

        $form_mode =  $this->uri->segment(4);
        $data['cpage'] = 'master_settings/add_edit_master_settings';
        $data['cpagetitle'] = 'Master Options';
        $data['tab_title'] = $form_titles[$form_mode];
        $data['donorList'] = array();
        if($form_mode == 'budget_head'){
            $data['donorList'] = $this->common_model->getMasterSetting('Donor','','','',true,'ais');
        }
        $this->load->view('../templates/common_template', $data);
    }
        
    public function insert_edit_master_settings() { #echo'<pre>';print_r($_POST);die;
        $tab_title = $this->input->post('tab_title');
        $master_type = $this->input->post('master_type');
        $master_name = $this->input->post('master_name');
        $main_tab = $this->input->post('main_tab');
        $donor_master_id = $this->input->post('donor_master_id');

        $description = $this->input->post('description');
        $duties = $this->input->post('duties');
        
        
        $form_titles = array('travel_mode' => 'Travel Mode','books_category' => 'Books Category','general_asset' => 'General Asset',
            'it_asset' => 'IT Asset','business_card' => 'Business Card Category','utilities' => 'Utilities Type',
            'donor' => 'Donor','budget_head' => 'Budget Head','line_item' => 'Line Item','partner_currency' => 'Currency');

        if($master_type !='' && $master_name!=''){
            $table_name = 'master_settings';$fields = array('master_id');$change_db= true;$db_name= 'ais';
            if($master_type !='' && $master_name!=''){
                $pid =0;
                if($donor_master_id !=''){
                    $pid = $donor_master_id;
                }
                $data = $condition = array(
                    'master_type' =>(string) $form_titles[$master_type],
                    'pid' => $pid,
                    'partner_id' => $this->session->userdata('partner_id'),
                    'master_name' => $master_name
                );
                #echo'<pre>';print_r($data);die;
                if($master_type == 'pay_grade'){
                    $table_name = 'hr_salary_grade';$fields = array('id');$change_db= false;$db_name= '';
                    $data = $condition = array(
                            'grade_name'=>$master_name,
                            'status'=>1
                    );
                }else if($master_type == 'job_specification'){
                    $table_name = 'hr_job_specification';$fields = array('id');$change_db= false;$db_name= '';
                    $data = $condition = array(
                            'specification_name'=>$master_name,
                            'specification_description'=>$description,
                            'specification_duties'=>$duties,
                            'status'=>1
                    );
                }
                #echo'<pre>';print_r($data);die;
                $check_data = $this->common_model->get_all_details($table_name,$condition,$fields,'','','',$change_db,$db_name);
                if(!empty($check_data)){
                    $this->setErrorMessage('error','Record already exists');
                    redirect('master_pro/master/disaplay_add_edit_form/'.$main_tab); exit;   
                }else{
                    $this->common_model->insert_data($table_name,$data,$change_db,$db_name);
                    $this->setErrorMessage('Success','Record Inserted Sucessfully');
                }
            }
            if($master_type == 'business_card'){
                $master_type= 'business_card_catsset';
               }   
            redirect('master_pro/master/master_settings/'.$master_type);    
        }else{
            $this->setErrorMessage('error','Record Inserted failed');
            redirect('master_pro/master/disaplay_add_edit_form/'.$main_tab);   
        }
    }

    public function insert_edit_asset_settings() { #echo'<pre>';print_r($_POST);die;
        $tab_title = $this->input->post('tab_title');
        $master_type = $this->input->post('master_type');
        $master_name = $this->input->post('master_name');
        $main_tab = $this->input->post('main_tab');
        $donor_master_id = $this->input->post('donor_master_id');
        $budget_filter_msid = $this->input->post('budget_filter_msid');
        
        $form_titles = array('travel_mode' => 'Travel Mode','books_category' => 'Books Category','general_asset' => 'General Asset',
            'it_asset' => 'IT Asset','business_card_catsset' => 'Business Card Category','utilities' => 'Utilities Type',
            'donor' => 'Donor','budget_head' => 'Budget Head','line_item' => 'Line Item','partner_currency' => 'Currency');

        if($master_type !='' && $master_name!=''){
            if($master_type !='' && $master_name!=''){
                $pid =0;
                if($donor_master_id !=''){
                    $pid = $donor_master_id;
                }
                if($master_type == 'line_item' && $budget_filter_msid!=''){
                    $pid = $budget_filter_msid;
                }
                $table_name = 'master_settings';
                $data = $condition = array(
                    'master_type' =>(string) $form_titles[$master_type],
                    'pid' => $pid,
                    'partner_id' => $this->session->userdata('partner_id'),
                    'master_name' => $master_name
                );
                #echo'<pre>';print_r($data);die;
                $fields = array('master_id');
                $check_data = $this->common_model->get_all_details($table_name,$condition,$fields,'','','',true,'ais');
                if(!empty($check_data)){
                    $this->setErrorMessage('error','Record already exists');
                    redirect('master_pro/master/disaplay_add_asset_form/'.$main_tab); exit;   
                }else{
                    $this->common_model->insert_data($table_name,$data,true,'ais');
                    $this->setErrorMessage('Success','Record Inserted Sucessfully');
                }
            }
            redirect('master_pro/master/disaplay_asset/'.$master_type);    
        }else{
            $this->setErrorMessage('error','Record Inserted failed');
            redirect('master_pro/master/disaplay_asset/'.$main_tab);   
        }
    }

    public function insert_edit_additional_info() { #error_reporting(-1);
        $tab_title = $this->input->post('tab_title');
        $master_type = $this->input->post('master_type');
        $master_name = $this->input->post('master_name');
        $main_tab = $this->input->post('main_tab');
        $programme = $this->input->post('programme');
        $donor = $this->input->post('donor');
        $budget = $this->input->post('budget');
        $lineitemList = $this->input->post('lineitemList');
        $master_name = $this->input->post('master_name');

        if($programme!='' && $donor!='' && $budget!='' && $lineitemList!='' && $master_name!=''){
            $fields = array('id');
            $data = $condition = array(
                'programme' =>$programme,
                'donor' => $donor,
                'budgethead' => $budget,
                'lineitem' => $lineitemList,
                'additionalinfo'=>$master_name,
                'partner_id' => $this->session->userdata('partner_id')
            );
            $check_data = $this->common_model->get_all_details('additional_info',$condition,$fields,'','','',true,'ais');
            if(!empty($check_data)){
                $this->setErrorMessage('error','Record already exists');
                redirect('master_pro/master/disaplay_add_asset_form/'.$main_tab); exit;   
            }else{
                $this->common_model->insert_data('additional_info',$data,true,'ais');
                $this->setErrorMessage('Success','Record Inserted Sucessfully');
            }
        }else{
            $this->setErrorMessage('error','Record not inserted');
            redirect('master_pro/master/disaplay_asset/'.$main_tab); 
        }
    }    
    
    public function update_master_data() {  #echo'<pre>';print_r($_POST);die;
        $master_id = $this->input->post('master_id');
        $master_name = $this->input->post('master_name');
        $status = $this->input->post('status');
        $donor_master_id = $this->input->post('donor_master_id');
        $table_name = 'master_settings';$change_db = true;$db_name='ais';
        $master_type = $this->input->post('master_type');
        $description = $this->input->post('description');
        $duties = $this->input->post('duties');
        $pid= 0;
        if($master_type == 'pay_grade'){
            $table_name =  'hr_salary_grade';$change_db = false;$db_name = '';
        }else if($master_type == 'job_specification'){
            $field = array('id');$table_name =  'hr_job_specification';$change_db = false;$db_name = '';
        }
        if(!empty($master_id) && !empty($master_name) && !empty($status)){
           for($id=0;$id<=php72_count($master_id)-1;$id++){
                if($master_type == 'pay_grade'){
                    $condition=array('id'=>$master_id[$id]);
                    $data = array(
                        'grade_name'=>$master_name[$id],
                        'status'=>$status[$id]
                    );
                }else if($master_type == 'job_specification'){
                    $condition=array('id'=>$master_id[$id]);
                    $data = array(
                        'specification_name'=>$master_name[$id],
                        'specification_description'=>$description[$id],
                        'specification_duties'=>$duties[$id],
                        'status'=>$status[$id]
                    );
                }else{
                    $condition=array('master_id'=>$master_id[$id]);
                    $data = array('master_name'=>$master_name[$id], 'status'=>$status[$id]);
                    if($donor_master_id[$id] !=''){
                        $pid = $donor_master_id[$id];
                    }
                    $data['pid']= $pid;
                }
                #echo'<pre>';print_r($duties[$id]);echo'<pre>';print_r($condition);echo'<pre>';print_r($data);
                $this->common_model->update_data($table_name,$condition,$data,$change_db,$db_name);
           }
           $this->setErrorMessage('Success','Record Updated Sucessfully');
        }else{
            for($id=0;$id<=php72_count($master_name)-1;$id++){
                if($master_type == 'pay_grade'){
                    $data = array(
                        'grade_name'=>$master_name[$id],
                        'status'=>$status[$id]
                    );
                }
                $this->common_model->insert_data($table_name,$data);
            }
        }
        redirect('master_pro/master/master_settings/'.$master_type);   
           
    }
    
    
    public function update_asset_master_data() { #echo'<pre>';print_r($_POST);
        $master_id = $this->input->post('master_id');
        $master_name = $this->input->post('master_name');
        $status = $this->input->post('status');
        $donor_master_id = $this->input->post('donor_master_id');
        $table_name = 'master_settings';
        $master_type = $this->input->post('master_type');
        $budget_head = $this->input->post('budget_head');
        $pid= 0;
        if(!empty($master_id) && !empty($master_name) && !empty($status)){
           for($id=0;$id<=php72_count($master_id)-1;$id++){ 
                $condition=array('master_id'=>$master_id[$id]);
                $data = array('master_name'=>trim($master_name[$id]), 'status'=>$status[$id]);
                if($donor_master_id[$id] !=''){
                    $pid = $donor_master_id[$id];
                }
                if($master_type =='line_item' && isset($budget_head)){
                    $pid = $budget_head[$id];      
                }
                $data['pid']= $pid;
                #echo'<pre>';print_r($data);die;
                $this->common_model->update_data($table_name,$condition,$data,true,'ais');
           }
           $this->setErrorMessage('Success','Record Updated Sucessfully');
        }
        redirect('master_pro/master/disaplay_asset/'.$master_type);   
    }  

    public function update_additionalinfo_master_data() {# echo'<pre>';print_r($_POST);die;
        error_reporting(-1);
        $id = $this->input->post('id');
        $programmes = $this->input->post('programmes');
        $donor_master_id = $this->input->post('donor_master_id');
        $budget_head = $this->input->post('budget_head');
        $master_name = $this->input->post('master_name');
        $lineitemList = $this->input->post('lineitemList');
        $status = $this->input->post('status');
        $master_type = trim($this->input->post('master_type')); 
        if(isset($id) && isset($programmes) && isset($donor_master_id) && isset($budget_head) && isset($master_name)){
           for($i=0;$i<=php72_count($id)-1;$i++){ 
                $condition = array('id'=>$id[$i]);
                $data = array('programme'=>$programmes[$i],
                                'donor'=>$donor_master_id[$i],
                                'budgethead'=>$budget_head[$i],
                                'lineitem'=>$lineitemList[$i],
                                'status'=>$status[$i],
                                'additionalinfo'=>$master_name[$i]
                            ); 
                $this->common_model->update_data('additional_info',$condition,$data,true,'ais');              
            }           
            $this->setErrorMessage('Success','Record Updated Sucessfully');
        }else{
            $this->setErrorMessage('error','Record not updated');
        }
        redirect('master_pro/master/disaplay_asset/'.$master_type);  
    }    
    
    
    // Add form ajax asset validation
    public function check_ajax_data() { #echo'<pre>';print_r($_POST);die;
        $master_type = $this->input->post('master_type');
        $master_name = $this->input->post('master_name');
        $tab_title = $this->input->post('tab_title');
        $main_tab = $this->input->post('main_tab');
        $donor_master_id = $this->input->post('donor_master_id');
        $budget_filter_msid = $this->input->post('budget_filter_msid');

        $return_Arr['status'] = '0';
        $return_Arr['err_msg'] = '';
        if($master_type!='' && $master_name!='' && $tab_title!=''){
            $table_name =  'master_settings';$change_db = true;$db_name = 'ais';
            $condition = array(
                'master_type' =>(string) $tab_title,
                'master_name' => $master_name
            );
            if($donor_master_id!=''){
                $condition['pid'] = $donor_master_id;
            }
            if($main_tab == 'line_item'){
                $condition['pid'] = $budget_filter_msid;
            }
            $fields = array('master_id');

            if($master_type == 'pay_grade'){
                $fields = array('id');$table_name = 'hr_salary_grade';$change_db = false;$db_name = '';  
                $condition = array('grade_name'=>$master_name);
            }
            $master_get_results = $this->common_model->get_all_details($table_name,$condition,$fields,'','','',$change_db,$db_name);
            #echo'<pre>';print_r($master_get_results);die;
            if(!empty($master_get_results)){
                $return_Arr['status'] = '1';
                $return_Arr['err_msg'] = 'Data already exists';
            }
        }
        echo json_encode($return_Arr);die;
    }

    // Add form ajax asset validation
    public function check_ajax_asset_data() { #echo'<pre>';print_r($_POST);die;
        $master_type = $this->input->post('master_type');
        $master_name = $this->input->post('master_name');
        $tab_title = $this->input->post('tab_title');
        $donor_master_id = $this->input->post('donor_master_id');

        $return_Arr['status'] = '0';
        $return_Arr['err_msg'] = '';
        if($master_type!='' && $master_name!='' && $tab_title!=''){
            $condition = array(
                'master_type' =>(string) $tab_title,
                'master_name' => $master_name
            );
            if($donor_master_id!=''){
                unset($condition['master_type']);
                $condition['pid'] = $donor_master_id;
            }
            $fields = array('master_id');
            $master_get_results = $this->common_model->get_all_details('master_settings',$condition,$fields,'','','',true,'ais');
            #echo'<pre>';print_r($master_get_results);die;
            if(!empty($master_get_results)){
                $return_Arr['status'] = '1';
                $return_Arr['err_msg'] = 'Master data already exists';
            }
        }
        echo json_encode($return_Arr);die;
    }

    function get_budget_ajax_data() {
        #echo'<pre>';print_r($_POST);die;
        $donor_id = $this->input->post('donor_id');
        $budget_id = (string)$this->input->post('budget_id');
        $returnArr['status']='0';
       
        if($donor_id !=''){
            $get_budget_lists = $this->common_model->getMasterSetting('Budget Head',NULL,$donor_id,'',true,'ais');
            if(isset($get_budget_lists) && !empty($get_budget_lists)){
                foreach($get_budget_lists as $lists){ 
                    $selected_opt = '';
                    if(isset($budget_id) && $budget_id!=''){
                        if($budget_id == $lists['master_id']){
                            $selected_opt = "selected";
                        }
                    }
                    $budget_option .=  '<option '.$selected_opt.' value="'.$lists['master_id'].'" name="a">'.$lists['master_name'].'</option>';
                    $returnArr['status']='1';
                }  
            }
        }
        $returnArr['response'] = $budget_option;
        $output = json_encode($returnArr);
        echo $output; exit;
    }

    function get_ajax_option_data() { #error_reporting(-1);
        $select_type = $this->input->post('select_type');
        $current_id = $this->input->post('current_id');
        $current_value = $this->input->post('current_value');
        $search_type = $this->input->post('search_type');
        $returnArr['status']='0';
        $get_donor_lists = array();
        if($select_type!='' && $select_type!='' && $select_type!=''){
            $returnArr['status']='1';
            if($select_type == 'programmes'){
                if($search_type == '1'){
                    $option_Arr = '<option value="" >Please select the Programme</option>';
                }else{
                    $option_Arr = '<option value="" >-- Select --</option>';
                }
                $get_donor_lists = $this->common_model->getMasterSetting('Donor',NULL, NULL,$current_value,true,'ais');
                if(isset($get_donor_lists) && !empty($get_donor_lists)){
                    foreach($get_donor_lists as $lists){
                        $option_Arr .=  '<option value="'.$lists['master_id'].'" name="a">'.$lists['master_name'].'</option>';
                    }
                }
            }else if($select_type == 'donor'){
                if($search_type == '1'){
                    $option_Arr = '<option value="" >Please select the Donor</option>';
                }else{
                    $option_Arr = '<option value="" >-- Select --</option>';
                }
                $get_donor_lists = $this->common_model->getMasterSetting('Budget Head', NULL, $current_value,Null,true,'ais');
                if(isset($get_donor_lists) && !empty($get_donor_lists)){
                    foreach($get_donor_lists as $lists){
                        $option_Arr .=  '<option value="'.$lists['master_id'].'" name="a">'.$lists['master_name'].'</option>';
                    }
                }
            }else if($select_type == 'budget'){
                if($search_type == '1'){
                    $option_Arr = '<option value="" >Please select the Budge Head</option>';
                }else{
                    $option_Arr = '<option value="" >-- Select --</option>';
                }
                $get_donor_lists = $this->common_model->getMasterSetting('Line Item', NULL, $current_value,Null,true,'ais');
                if(isset($get_donor_lists) && !empty($get_donor_lists)){
                    foreach($get_donor_lists as $lists){
                        $option_Arr .=  '<option value="'.$lists['master_id'].'" name="a">'.$lists['master_name'].'</option>';
                    }
                }
            }
        }
        $returnArr['current_id'] = $current_id;
        $returnArr['response'] = $option_Arr;
        $output = json_encode($returnArr);
        echo $output; exit;
    }

    function check_ajax_masterdata() {#echo'<pre>';print_r($_POST);
        $master_id = $this->input->post('master_id');
        $master_err_id = $this->input->post('master_err_id');
        $master_name = $this->input->post('master_name');
        $master_type = $this->input->post('master_type');
        $description = $this->input->post('description');
        $duties = $this->input->post('duties');
        $data = array();
        $status = array();
        $returnArr['status'] = 0;  $status_sum = $c_master_name = $c_description = $c_duties = $c_master_id = '';
        $field = array('master_id');$table_name =  'master_settings';$change_db = true;$db_name = 'ais';
        if($master_type == 'pay_grade'){
            $field = array('id');$table_name =  'hr_salary_grade';$change_db = false;$db_name = '';
        }else if($master_type == 'job_specification'){
            $field = array('id');$table_name =  'hr_job_specification';$change_db = false;$db_name = '';
        }
        if(isset($master_id) && isset($master_err_id) && isset($master_name)){
            for($i=0;$i<=php72_count($master_id)-1;$i++){
                $c_master_name =  $master_name[$i];
                $c_master_id =  $master_id[$i];
                $c_description = $description[$i];$c_duties = $duties[$i];

                if($c_master_name!=''){
                    $condition = array(
                        'master_name'=>$c_master_name
                    );
                    if($c_master_id!=''){
                        $condition['master_id !='] = $c_master_id;      
                    }
                    if($master_type == 'pay_grade'){
                        unset($condition['master_id !=']);
                        $condition = array(
                            'grade_name'=>$c_master_name
                        );
                        if($c_master_id!=''){
                            $condition['id !='] = $c_master_id;      
                        }
                    }
                    if($master_type == 'job_specification'){
                        unset($condition['master_id !=']);
                        $condition = array(
                            'specification_name'=>$c_master_name
                        );
                        if($c_master_id!=''){
                            $condition['id !='] = $c_master_id;      
                        }
                    } #echo'<pre>';print_r($condition);
                    $master_get_results = $this->common_model->get_all_details($table_name,$condition,$field,'','','',$change_db,$db_name);
                    if(!empty($master_get_results)){
                        if(isset($i)){
                            $data['master_'.$master_err_id[$i]] = 'Data already exists';
                            $status[] = 1; 
                        }
                    }
                }
            }
            $status_sum = array_sum($status);
            if(php72_cmp($status_sum) >0){
                $returnArr['status'] = 1; 
            }
            $returnArr['response'] = $data; 
            $output = json_encode($returnArr);  
            echo $output; exit;
        }
    }

    public function ajax_asset_master_data() { #echo'<pre>';print_r($_POST);die;
        $master_id = $this->input->post('master_id');
        $master_name = $this->input->post('master_name');
        $status = $this->input->post('status');
        $donor_master_id = $this->input->post('donor_master_id');
        $table_name = 'master_settings';
        $master_type = $this->input->post('master_type');
        $budget_head = $this->input->post('budget_head');
        $pid= 0;
        if(!empty($master_id) && !empty($master_name) && !empty($status)){
           for($id=0;$id<=php72_count($master_id)-1;$id++){ 
                $condition=array('master_id'=>$master_id[$id]);
                $data = array('master_name'=>trim($master_name[$id]), 'status'=>$status[$id]);
                if($donor_master_id[$id] !=''){
                    $pid = $donor_master_id[$id];
                }
                if($master_type =='line_item' && isset($budget_head)){
                    $pid = $budget_head[$id];      
                }
                $data['pid']= $pid;
                #echo'<pre>';print_r($data);die;
                $this->common_model->update_data($table_name,$condition,$data,true,'ais');
           }
        }
    }
    public function check_ajax_duplication() { #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
        $master_type = $this->input->post('master_type');
        $master_id = $this->input->post('master_id');
        $hid_donor_master = $this->input->post('hid_donor_master');
        $donor_master_id = $this->input->post('donor_master_id');
        $master_name = $this->input->post('master_name');
        $master_err_id = $this->input->post('master_err_id');
        $budget_head = $this->input->post('budget_head');
        $pid= 0;
        $data = array();$status = array();
        $returnArr['status'] = 0;  $status_sum = $c_master_name = $c_master_id = '';
        if(!empty($master_id) && !empty($master_name) && $master_type!=''){
            for($i=0;$i<=php72_count($master_id)-1;$i++){ 
                if($donor_master_id[$i] !=''){
                    $pid = $donor_master_id[$i];
                }
                if($master_type =='line_item' && isset($budget_head)){
                    $pid = $budget_head[$i];      
                }
                
                $condition=array('master_id !='=>$master_id[$i],'pid'=>$pid,'master_name'=>$master_name[$i]);
                $master_get_results = $this->common_model->get_all_details('master_settings',$condition,array('master_id'),'','','',true,'ais');
                #echo'<pre>';print_r($condition); echo'<pre>';print_r($master_get_results);
                if(!empty($master_get_results)){
                    if(isset($i)){
                        $data['master_'.$master_err_id[$i]] = 'Master data already exists';
                        #$data['donor_master_'.$hid_donor_master[$i]] = 'Master data already exists';
                        $status[] = 1; 
                    }
                }
           }
        } 
        $status_sum = array_sum($status);
        if(php72_cmp($status_sum) >0){
            $returnArr['status'] = 1; 
        }
        $returnArr['response'] = $data; 
        $output = json_encode($returnArr);#echo'<pre>';print_r($output);die;  
        echo $output; exit;
    }

    public function common_delete() { #echo'<pre>';print_r($_POST);die;
        $delete_ids = $this->input->post('delete_ids');
        $redirect_master_type = $this->input->post('redirect_master_type');
        if(isset($delete_ids) && $delete_ids!=''){
            $table_name =  'master_settings';$change_db = true;$db_name = 'ais';
            if($redirect_master_type == 'pay_grade'){
                $table_name =  'hr_salary_grade';$change_db = false;$db_name = '';
            }else if($redirect_master_type == 'job_specification'){
                $table_name =  'hr_job_specification';$change_db = false;$db_name = '';
            }
            $exp_arr =  explode(",",$delete_ids);
            if(!empty($exp_arr)) {
                foreach($exp_arr as $ids){
                    $condition =  array('master_id'=>$ids);
                    if($redirect_master_type == 'pay_grade'){
                        $condition =  array('id'=>$ids);
                    }else if($redirect_master_type == 'job_specification'){
                        $condition =  array('id'=>$ids);
                    }#echo'<pre>';print_r($condition);die;
                    $this->common_model->delete_data($table_name,$condition,$change_db,$db_name);
                }
            }
            $this->setErrorMessage('Success','Record Deleted Sucessfully');
        }
        redirect('master_pro/master/master_settings/'.$redirect_master_type);  
    }

    public function common_asset_delete() {
        $delete_ids = $this->input->post('delete_ids');
        $redirect_master_type = $this->input->post('redirect_master_type');
        if(isset($delete_ids) && $delete_ids!=''){
            $table_name = 'master_settings';
            $exp_arr =  explode(",",$delete_ids);
            if(!empty($exp_arr)) {
                foreach($exp_arr as $ids){
                    $condition =  array('master_id'=>$ids);
                    $this->common_model->delete_data($table_name,$condition,true,'ais');
                }
            }
            $this->setErrorMessage('Success','Record Deleted Sucessfully');
        }
        redirect('master_pro/master/disaplay_asset/'.$redirect_master_type);  
    }

    public function display_datatable() {
        $data['cpage'] = 'master_settings/display_datatable';
        $data['cpagetitle'] = 'Master Options';
        $this->load->view('../templates/common_template', $data);
    
        
    }

    
  function ajax_load_datatable() {
    #echo'<pre>';print_r($_POST);die;

    $table_name = 'hr_salary_grade';
    $change_db = false;$db_name = '';
    $limit = 10;
    $start ='';
    
    checkAuth();
    $data = array();
    $draw = $this->input->post('draw');
    $funder_id = $this->input->post('funder_id');
    $start = $this->input->post('start');
    $columnIndex = $_POST['order'][0]['column']; 
    $columnSortOrder = $_POST['order'][0]['dir'];
    
    $form_type = $this->input->post('form_type');
    $filter_type = $this->input->post('filter_type');

    $condition = array();
    if($form_type!='' && $filter_type!=''){
        $condition = array('grade_name'=>$filter_type);
    }
    $columnArr = array('','grade_name','status');
    $orderby= array($columnArr[$columnIndex]=>$columnSortOrder);
   #echo'<pre>';print_r($orderby);
    $PayGradeCount = $this->common_model->get_all_details('hr_salary_grade',$condition,array(),'','','',$change_db,$db_name);
    $master_get_results = $this->common_model->get_all_details('hr_salary_grade',$condition,array(),$limit,$start,$orderby,$change_db,$db_name);
    $i=0;
    $nestedData  = $grant_list = array();
    foreach($master_get_results as $lists){
        $set_active ='';
        $set_inactive ='';
        if(isset($lists->status) && $lists->status!=''){
            if(php72_cmp($lists->status) == 1){
                $set_active ='selected';       
            }else{
                $set_inactive ='selected';
            }
        }
        
        $checkBox = '<input type="checkbox" name="checkbox[]" value='.$i.' class="form-control check_box_list" >';
        $pay_grade = '<input type="hidden" disabled name="master_id[]" id="hid_'.$lists->id.'" value='.$lists->id.' class="form-control"/><input type="hidden" disabled name="master_err_id[]"  value='.$i.'><input type="text" placeholder="Enter pay grade" disabled  name="master_name[]" data-err="master_'.$i.'" value="'.$lists->grade_name.'" class="form-control alphaonly"><label style="display: block;" class="error tbl_err" id="master_'.$i.'"></label>';
        $status = '<select name="status[]" class="form-control" disabled >
                        <option '. $set_active .' value="1">Active</option>
                        <option '. $set_inactive .' value="0">Inactive</option>
                </select>';
        $nestedData[]  = array($checkBox,$pay_grade,$status);
        $i++;
    }
    $data = $nestedData;
    #echo'<pre>';print_r($getGrantData);die;
    $json_data = array(
        "draw" => intval($draw),
        "recordsTotal" => intval(php72_count($master_get_results)),
        "recordsFiltered" => intval(php72_count($PayGradeCount)),
        "data" => $data,
        'POST'=>$_POST
    );
    #echo'<pre>';print_r($json_data);die;
    echo json_encode($json_data);
}

}

?>
