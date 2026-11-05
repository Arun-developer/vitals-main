<?php

class Minnovation extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->table = 'innovation_pool';
        $this->load->model('master/Msource');
        $this->load->model('master/Mmaster');
        $this->load->model('login/Muser');
        $this->load->model('master/Mmaster_settings');
    }

    public function getInnvationStage() {
        // return array("0" => 'New', "1" => 'Entry', "2" => 'Lead', "3" => 'Shortlisted', "4" => 'Leads for Due-Diligence', "6" => 'Exited Innovation', "7" => 'Application', "8" => 'PA/RD', "9" => 'Detailed Diligence', "10" => 'Final Negotiations', "11" => 'Incubation', '12' => 'Portfolio');
        return array("7" => 'Application', "8" => 'PA/RD', "9" => 'Detailed Diligence', "10" => 'Final Negotiations', "11" => 'Incubation', '12' => 'Portfolio');
    }

    public function getInnvationStatus() {
        // return array("0" => 'New', "1" => 'Follow-Up', "2" => 'On-Hold', "3" => 'Closed', "4" => 'Draft', "5" => 'Pending', "6" => 'Decision Pending', "7" => 'Lead', "8" => 'Incubation', "9" => 'Exited', "10" => 'Registered', "11" => 'Deleted', "12" => 'Open', "13" => 'Open - IIC Approved', "14" => 'Closed - IIC Rejected', "15" => 'User Accepted', "16" => 'User Rejected', "17" => 'EIC Approved', "18" => 'EIC Rejected', "19" => 'Re-Opened', "20" => 'Final Negotiation', "21" => 'Plan sent for Approval', "22" => 'Plan Approved', "23" => 'Company Graduated', "24" => 'Open-Banked', "25" => 'Shortlisted', "26" => 'Selected');
        return array("3" => 'Closed', "4" => 'Draft', "9" => 'Exited', "10" => 'Registered', "11" => 'Deleted', "12" => 'Open', "13" => 'Open - IIC Approved', "14" => 'Closed - IIC Rejected', "15" => 'User Accepted', "16" => 'User Rejected', "17" => 'EIC Approved', "18" => 'EIC Rejected', "19" => 'Re-Opened', "20" => 'Final Negotiation', "21" => 'Plan sent for Approval', "22" => 'Plan Approved', "23" => 'Company Graduated', "24" => 'Open-Banked', "25" => 'Shortlisted', "26" => 'Selected');
    }

    public function getIndependentStatus() {
        return array("2" => 'On-Hold', "3" => 'Closed', "12" => 'Open', "25" => 'Shortlisted', "26" => 'Selected');
    }

    public function getSectorNameById() {
        return array("0" => '', "1" => 'Agri-business', "2" => 'CleanTech', "4" => 'Climate Action', "3" => 'Education', "5" => 'Healthcare', "6" => 'Waste management', "7" => 'Skill Development', "8" => 'Housing', "9" => 'ICT', "10" => 'Livelihoods', "11" => 'Water and sanitation', "12" => 'Others');
    }

    public function getIncubationPartners() {
        return array("01" => 'Villgro India', "02" => 'Villgro Kenya', "03" => 'Menterra', "04" => 'Startup Oasis', "05" => 'IIM Calcutta', "06" => 'KIIT', "07" => 'SIIC', "08" => 'External Vendors', "10" => "Powering Livelihoods");
    }

    public function checkmailExists($mail, $inv) {
        $partner_id_1 = $this->session->userdata('partner_id');
        $partner_id_2 = '0' . $this->session->userdata('partner_id');
        $cond = "(IP.partner_id = $partner_id_1 or IP.partner_id = $partner_id_2)";
        $this->db->select('IU.*');
        $this->db->from('inv_user IU');
        $this->db->join('innovation_pool IP', 'IP.innovation_id =  IU.inv_no');
        $this->db->where('IU.email', $mail);
        $this->db->where('IP.status !=', '11');
        $this->db->where($cond);
        if ($inv) {
            $this->db->where('IU.inv_no !=', $inv);
        }
        $query = $this->db->get();

        $rows = $query->num_rows();
        return $rows;
    }

    public function checkmailPitchExists($mail, $inv) {
        $start = '2018-07-01 00:00:0000';

        $this->db->select('PU.*');
        $this->db->from('pitch_user PU');
        $this->db->join('innovation_pool IP', 'IP.innovation_id =  PU.inno_id');
        $this->db->where('PU.email', $mail);
        $this->db->where('PU.reg_date >', $start);
        $this->db->where('IP.status !=', '11');
        if ($inv) {
            $this->db->where('PU.inno_id !=', $inv);
        }
        $query = $this->db->get();

        $rows = $query->num_rows();
        return $rows;
    }

    public function getSectorNamePitch($id) {
        $this->db->select('*');
        $this->db->from('sector_category');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

///////////////////////////////EIR PROCESS///////////////////////////////

    public function getState() {
        $this->db->order_by('state_name', 'asc');
        $state = $this->db->get('eir_state');
        return $state->result_array();
    }

    public function getCity($s_id) {
        $this->db->where('state_id', $s_id);
        $cities = $this->db->get('eir_city');
        foreach ($cities->result_array() as $city) {
            $data[$city['id']] = $city['city_name'];
        }
        return $data;
    }

////////////////////////////// SEED PROCESS //////////////////////////////
    public function getCountry() {
        $country = $this->db->get('seed_countries');
        return $country->result_array();
    }

    public function getCitys() {
        $cities = $this->db->get('eir_city');
        return $cities->result_array();
    }

////////////////////////////// SEED PROCESS ENDS /////////////////////////

    public function insert_pool($data) {
        $this->db->insert('innovation_pool', $data);
        $id = $this->db->insert_id();
        $this->updateInnovationNumber($id);
        return $innovation_id = "INV" . $id;
    }

    public function insert_eir_user($data) {
        $this->db->insert('eir_user', $data);
        return $this->db->insert_id();
    }

    public function insert_eir_app($data) {
        $this->db->insert('eir_app', $data);
        return true;
    }

    public function insert_eir_team($data) {
        $this->db->insert('eir_team', $data);
        return true;
    }

    public function insert_eir_file($id, $data1, $data2) {
        $arr = array('app_id' => $id, 'resume' => $data1, 'additional_documents' => $data2);
        $this->db->insert('eir_files', $arr);
        return true;
    }

/////////////////////////////////////////////////////////////////////////
    #Add innovations
    public function insert($form) {
        if (empty($form['source_type'])) {
            $form['source_type'] = 0;
        }
        if ($form['source'] == '') {
            $form['source'] = 0;
        }
        $data = array('source' => $form['source'],
            'source_others' => $form['source_others'],
            'sourceType' => $form['source_type'],
            'sector' => $form['sector'],
            'sector_others' => $form['sector_others'],
            'instance' => $form['instance'],
            'other_partner_id' => $from['other_partner_id'],
            'name_of_entrepreneur' => $form['name_of_entrepreneur'],
            'phone_no' => $form['phone_no'],
            'mobile_no' => $form['mobile_no'],
            'email_id' => $form['email_id'],
            'address_line1' => $form['address_line1'],
            'address_line2' => $form['address_line2'],
            'city' => $form['city'],
            'district' => $form['district'],
            'state' => $form['state'],
            'country' => $form['country'],
            'pincode' => $form['pincode'],
            'name_of_enterprise' => $form['name_of_enterprise'],
            'website' => $form['website'],
            'summary_of_business' => $form['summary'],
            'entreprise_years' => $form['entreprise_years'],
            'business_plan' => $form['business_plan'],
            'business_plan_document' => $form['business_plan_document'],
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('emp_number'));
        $this->db->insert('innovation_pool', $data);
        $id = $this->db->insert_id();
        $this->updateInnovationNumber($id);
        $this->load->model('Msupporting_documents');
        $this->Msupporting_documents->insertSuportingDocuments($id, $form);
        $this->load->model('common/Minnovation_mail');
        $this->Minnovation_mail->new_innovation($id);
        return $id;
    }

    public function update($form = array()) {
        if ($form['source'] != 0) {
            $form['source_others'] = '';
        }

        $data = array('source' => $form['source'],
            'partner_id' => !empty($form['branch_name']) ? $form['branch_name'] : $this->session->userdata('partner_id'),
            'source_others' => $form['source_others'],
            'sourceType' => $form['source_type'],
            'sector' => $form['sector'],
            'sector_others' => $form['sector_others'],
            'instance' => $form['instance'],
            'other_partner_id' => $from['other_partner_id'],
            'name_of_entrepreneur' => $form['name_of_entrepreneur'],
            'phone_no' => $form['phone_no'],
            'mobile_no' => $form['mobile_no'],
            'email_id' => $form['email_id'],
            'address_line1' => $form['address_line1'],
            'address_line2' => $form['address_line2'],
            'city' => $form['city'],
            'district' => $form['district'],
            'state' => $form['state'],
            'country' => $form['country'],
            'pincode' => $form['pincode'],
            'name_of_enterprise' => $form['name_of_enterprise'],
            'website' => $form['website'],
            'summary_of_business' => $form['summary'],
            'entreprise_years' => $form['entreprise_years'],
            'business_plan' => $form['business_plan'],
            'business_plan_document' => $form['business_plan_document'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $form['id']);
        $this->db->update('innovation_pool', $data);
        return true;
    }

    public function directApplication($form) {
        $data = array('name_of_entrepreneur' => $form['name_of_entrepreneur'],
            'other_partner_id' => $from['other_partner_id'],
            'phone_no' => $form['phone_no'],
            'mobile_no' => $form['mobile_no'],
            'email_id' => $form['email_id'],
            'address_line1' => $form['address_line1'],
            'address_line2' => $form['address_line2'],
            'city' => $form['city'],
            'district' => $form['district'],
            'state' => $form['state'],
            'country' => $form['country'],
            'pincode' => $form['pincode'],
            'name_of_enterprise' => $form['name_of_enterprise'],
            'website' => $form['website'],
            'summary_of_business' => $form['summary'],
            'entreprise_years' => $form['entreprise_years'],
            'business_plan' => $form['business_plan'],
            'business_plan_document' => $form['business_plan_document'],
            'reference' => @$form['reference'],
            'other_reference' => $form['other_reference'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => '',
        );
        $this->db->insert('innovation_pool', $data);
        $id = $this->db->insert_id();
        $this->updateInnovationNumber($id);
        $this->load->model('Msupporting_documents');
        $this->Msupporting_documents->insertSuportingDocuments($id, $form);
        $this->load->model('common/Minnovation_mail');
        $this->Minnovation_mail->direct_innovation($id);
        return $id;
    }

    public function updateInnovationNumber($id) {
        $innovation_id = "INV" . $id;
        $copy_id = str_pad($id, 4, "0", STR_PAD_LEFT);
        $this->db->set('innovation_id ', $innovation_id);
        $this->db->set('copy_id ', $copy_id);
        $this->db->where('id', $id);
        $this->db->update('innovation_pool');
    }

    public function PartnerList($id) {
        $sql = "SELECT id,branch_name FROM hs_hr_branch where id IN ($id)";
        $values = array();
        $result = mysqli_query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $values[] = array($row['branch_name']);
        }
        return $values;
    }

    public function Partnername($id) {
        $sql = "SELECT branch_name FROM hs_hr_branch where id =" . $id;

        $result = mysqli_query($sql);
        $row = mysqli_fetch_array($result);
        return $row['branch_name'];
    }

    public function PartnerId($val) {
        $sql = "SELECT id FROM hs_hr_branch where branch_name ='" . $val . "'";
        $result = mysqli_query($sql);
        $row = mysqli_fetch_array($result);
        return $row['id'];
    }

    public function insert_shortlistcomments($data) {
        $comments_insert = $this->db->insert('shortlist_comments', $data);
        return $comments_insert;
    }

    public function update_shortlistcomments($status, $condition) {
        $this->db->set('current_app_status', $status);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update('shortlist_comments');
        return $result;
    }

#get innovations

    public function getAllCount($options = array()) {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(DISTINCT(IP.id)) as total");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('grading_feedback GF', 'GF.innovation_id=IP.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id = pitch.pitch_id', 'left');
        if ($whereQuery != null) {
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    public function getPageCount($options = array()) {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(DISTINCT(IP.id)) as total");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('grading_feedback GF', 'GF.innovation_id=IP.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id = pitch.pitch_id', 'left');
        if ($whereQuery != null) {
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    public function updateEditRequest($innovation) {
        $this->db->set('edit_request', '1');
        $this->db->set('editrequest_status', '0');
        $this->db->where('id', $innovation);

        $query = $this->db->update('innovation_pool');
        return;
    }

    public function getUsername($id) {
        $this->db->select("emp_first_name as emp_firstname");
        $this->db->where('id', $id);
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getSourceName($innovation) {
        $this->db->select("master_name");
        $this->db->where('id', $innovation);
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getNewSectorDetails($id) {

        $this->db->select("sector");
        $this->db->where('id', $id);
        $query = $this->db->get('sector_category');
        $data = $query->result_array();
        $row = ucfirst($data[0]['sector']);
        return $row;
    }

    public function getSectorName($pitch_id) {

        $this->db->select("sector");
        $this->db->where('pitch_id', $pitch_id);
        $query = $this->db->get('pitch_step2');
        $data = $query->result_array();
        $sector = unserialize($data[0]['sector']);
        $row = ucfirst($sector[0]);

        return $row;
    }

    public function getstageName($pitch_id) {

        $this->db->select("stage");
        $this->db->where('pitch_id', $pitch_id);
        $query = $this->db->get('pitch_step2');
        $data = $query->result_array();
        $sector = unserialize($data[0]['stage']);
        $row = ucfirst($sector[0]);

        return $row;
    }

    public function getLimitRecords1($options = array()) {
        $data = array();
        $whereQuery = $this->_search($options);

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        } else {
            $this->db->order_by('id', 'desc');
        }

        $this->db->select("IP.*,SM.source_name,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");

        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->distinct();
        if (isset($options['innovation_score'])) {
            $this->db->select('INS.*');
            $this->db->join('innovation_score INS', 'INS.innovation = IP.id', 'left');
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        $isAssign = false;
        $isExport = false;
        $isAssignCycle = false;
        $isDetails = true;
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            $isAssign = true;
            $isExport = true;
            $isAssignCycle = true;
        }
        $total = $this->getAllCount($options);
        if ($query->num_rows() > 0) {
            $this->load->model('scouting/Mincharge');
            $j = $_GET['iDisplayStart'];
            foreach ($query->result_array() as $row) {
                $asArray = array();
                $associate = $this->Mincharge->getAssociate(array('innovation' => $row['id'], 'active' => 'Active'));
                foreach ($associate as $as):
                    $asArray[] = $as['emp_name'];
                endforeach;
                $row['associate_emp_name'] = implode(', ', $asArray);

                $source = ($row['source_type'] == '0' && $row['source_others'] == '') ? 'Direct Application' : empty($row['source_name']) ? $row['source_others'] : $row['source_name'];
                $sector = ($row['sector'] != 'others') ? $row['sector'] : $row['secotr_others'];
                if ($row['program'] == '1') {
                    $program = 'EIR';
                } else if ($row['program'] == '2') {
                    $program = 'SEED';
                } else if ($row['program'] == '3') {
                    $program = 'Unc Pitch';
                } else {
                    $program = 'Incubation';
                }

                ///////////////////loads stage and status////////////////////////////////
                $stage = $this->Minnovation->getInnvationStage();
                $status = $this->Minnovation->getInnvationStatus();
                $this->load->model('master/Mstageefficiency');
                $timelimit = $this->Mstageefficiency->getMaxDays();
                $stagedate = $this->Mstageefficiency->getStageDate();

                $ischeck = false;

                $fstagedate = @$stagedate[@$stage[$row['stage']]];
                if ($fstagedate != '') {
                    $daylimit = $timelimit[0][$row['stage']];
                    $fdatearr = $row[$fstagedate];
                    $fdatearr = explode(' ', $fdatearr);
                    $fdate = $fdatearr[0];
                    $cdate = date("Y-m-d");
                    $dateDiff = strtotime($cdate) - strtotime($fdate);
                    $fullDays = floor($dateDiff / (60 * 60 * 24));
                    if ($fullDays >= $daylimit) {
                        $ischeck = true;
                    }
                }
                $stage_text = "";
                if ($ischeck) {
                    $stage_text .= '<blink><strong>';
                }
                if ($row['stage'] == '2' && $row['status'] == '1' && $isAssignCycle) {
                    $stage_text .= "<a href=" . site_url('scouting/cycle/' . $row['id']) . " class='fancybox button'>" . $stage[$row['stage']] . "</a>";
                } else {
                    $stage_text .= $stage[$row['stage']];
                }
                if ($ischeck) {
                    $stage_text .= '</strong></blink>';
                }
                //////////////////////stage and status ends/////////////////////////
                //////////////////////////////detail view link/////////////////////
                if ($isDetails) {

                    if ($this->session->userdata('user_name') == 'Altacit') {
                        $detailLink = 'scouting/innovation_details/' . $row['id'];
                    } else {
                        if (($this->uri->segment('3') == 'incubation') || ($this->uri->segment('3') == 'assigned_incubation')) {

                            $detailLink = 'login/myportfolio/' . $row['id'];
                        } else if ($this->uri->segment('3') == 'decision_pending') {
                            $detailLink = 'assessment/view_list/' . $row['id'];
                        } else {
                            $detailLink = 'login/assessment/' . $row['id'];
                        }
                    }
                    $detail_text = ($row['grading_status'] == '1') ? 'Decision Pending' : 'Details';
                    $details = "<a href=" . site_url($detailLink) . " class='button' style='white-space: nowrap'>" . $detail_text . "</a>";
                }

                ///////////////////////delete//////////////////////////
                //////////////////////////// id check box/////////////////////////////
                $select = '';
                if ($row['status'] != '3' && $row['status'] != '4' && in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio'))) {
                    $select = '<input type="checkbox" class="chk_box" name="innovation_id[]" value="' . $row['id'] . '"/>';
                }

                if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
                    $delete = "<a href='javascript:void(0);' program=" . str_replace(" ", "-", $program) . " url=" . site_url('portfolio/delete/' . $row['id']) . " class='DeleteInnovation confirmDelete'><img src='" . base_url() . "source/template/images/icons/cross.png'/></a>";
                    $data[] = array($select, ++$j, $row['innovation_id'], $row['created_emp'], $source, $sector, $program, $row['name_of_enterprise'], mysql2date($row['created_date']), $row['associate_emp_name'], $stage_text, $status[$row['status']], $details, $delete);
                } else {

                    $data[] = array($select, ++$j, $row['innovation_id'], $row['created_emp'], $source, $sector, $program, $row['name_of_enterprise'], mysql2date($row['created_date']), $row['associate_emp_name'], $stage_text, $status[$row['status']], $details);
                }
            }
        }
        $query->free_result();
        $returnArray = array();
        $returnArray = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => array(),
        );

        $returnArray["aaData"] = $data;

        return $returnArray;
    }

    public function getcopyRecords($id, $name, $comment) {
        $data = array();

        $this->db->select("IP.*,SM.source_name,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");

        $this->db->select("GF.fstage,GF.donor_fit,GF.LIS");
        $this->db->select("INV.submitted_date");
        $this->db->select("(select branch_name from  " . $this->hris->database . ".hs_hr_branch where id = IP.partner_id) as branch_name", false);
        $this->db->select("pitch.submitted_date as pitch_submitted_date");
        $this->db->select("eir.date_submitted as eir_submitted_date");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');

        $this->db->join('(SELECT innovation_id, id, fstage, donor_fit, LIS
           FROM grading_feedback AS ga
           INNER JOIN (
           SELECT max( id ) AS maxid
           FROM grading_feedback
           GROUP BY innovation_id
       ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
        $this->db->distinct();

        $this->db->where('IP.id', $id);
        $query = $this->db->get('innovation_pool IP', $id);

        $data = $query->result_array();
        if ($data[0]['program'] == '0') {
            $this->db->select('*');
            $this->db->where('inv_no', $data[0]['innovation_id']);
            $query1 = $this->db->get('inv_user', $data[0]['innovation_id']);
            $data1 = $query1->result_array();

            $this->db->select('*');
            $this->db->where('inv_user_id', $data1[0]['id']);
            $query2 = $this->db->get('inv_additional_info', $data1[0]['id']);
            $data2 = $query2->result_array();

            $this->db->select('*');
            $this->db->where('inv_user_id', $data1[0]['id']);
            $query3 = $this->db->get('inv_ent_info', $data1[0]['id']);
            $data3 = $query3->result_array();

            $this->db->select('*');
            $this->db->where('inv_user_id', $data1[0]['id']);
            $query4 = $this->db->get('inv_impact', $data1[0]['id']);
            $data4 = $query4->result_array();

            $this->db->select('*');
            $this->db->where('inv_user_id', $data1[0]['id']);
            $query5 = $this->db->get('inv_member', $data1[0]['id']);
            $data5 = $query5->result_array();

            $this->db->set('copy_partner_from', $name);
            $this->db->where('id', $id);
            $this->db->update('innovation_pool');

            $partnercount = $data[0]['partner_count'] + 1;
            $innovation_data = array(
                'innovation_id' => $data[0]['innovation_id'],
                'copy_id' => $data[0]['copy_id'],
                'other_partner_id' => $data[0]['other_partner_id'],
                'name_of_entrepreneur' => $data[0]['name_of_entrepreneur'],
                'name_of_enterprise' => $data[0]['name_of_enterprise'],
                'email_id' => $data[0]['email_id'],
                'mobile_no' => $data[0]['mobile_no'],
                'address_line1' => $data[0]['address_line1'],
                'address_line2' => $data[0]['address_line2'],
                'country' => $data[0]['country'],
                'sector' => $data[0]['sector'],
                'status' => '0',
                'stage' => '0',
                'program' => '0',
                'source' => '-1',
                'copied_date' => date('Y-m-d'),
                'created_date' => $data[0]['created_date'],
                'created_by' => $data[0]['created_by'],
                'partner_id' => "0" . $name,
                'copy_text' => $comment,
                'copy_partner_id' => "0" . $this->session->userdata('partner_id'),
                'copy_status' => "4",
                'partner_count' => str_pad($partnercount, 2, "0", STR_PAD_LEFT));
            $table = "innovation_pool";
            $inc_inv_id = $this->pitch_copyinsert($table, $innovation_data);

            /* invuser insert */
            $inv_user_data = array(
                'inv_no' => 'INV' . $inc_inv_id,
                'ent_name' => $data1[0]['ent_name'],
                'applicant_name' => $data1[0]['applicant_name'],
                'email' => $data1[0]['email'],
                'mobile' => $data1[0]['mobile'],
                'address1' => $data1[0]['address1'],
                'address2' => $data1[0]['address2'],
                'country' => $data1[0]['country'],
                'ent_type' => $data1[0]['ent_type'],
                'india_based' => $data1[0]['india_based'],
                'ent_sector' => $data1[0]['ent_sector'],
                'benificiary' => $data1[0]['benificiary'],
                'impact_of_product' => $data1[0]['impact_of_product'],
                'status' => '0',
                'created_date' => date('Y-m-d'),
                'submitted_date' => date('Y-m-d'),
            );

            $table = "inv_user";
            $inv_user_id = $this->Minnovation->pitch_insert($table, $inv_user_data);

            /* invuser insertend */

            /* inv_ent_info insert */

            $ent_info_data = array(
                'inv_user_id' => $inv_user_id,
                'ent_name_info' => $data3[0]['ent_name_info'],
                'in_operation' => $data3[0]['in_operation'],
                'operate_on_state' => $data3[0]['operate_on_state'],
                'develop_product' => $data3[0]['develop_product'],
                'stage_product' => $data3[0]['stage_product'],
                'inv_desc' => $data3[0]['inv_desc'],
                'inv_problem' => $data3[0]['inv_problem'],
                'inv_alternatives' => $data3[0]['inv_alternatives'],
                'pilots' => $data3[0]['pilots'],
                'proposal_desc' => $data3[0]['proposal_desc'],
                'inv_risks' => $data3[0]['inv_risks'],
            );

            $table = "inv_ent_info";
            $result = $this->Minnovation->pitch_insert($table, $ent_info_data);

            /* inv_ent_info insertend */

            /* inv_impact insert */

            $impact_info_data = array(
                'inv_user_id' => $inv_user_id,
                'primary_benifi' => $data4[0]['primary_benifi'],
                'research_cus_seg' => $data4[0]['research_cus_seg'],
                'demographic_profie' => $data4[0]['demographic_profie'],
                'avg_monthly' => $data4[0]['avg_monthly'],
                'inv_impact' => $data4[0]['inv_impact'],
                'others_benefit' => $data4[0]['others_benefit'],
            );

            $table = "inv_impact";
            $result = $this->Minnovation->pitch_insert($table, $impact_info_data);

            /* inv_impact insertend */

            /* inv_additional_info insert */
            $additional_info_data = array(
                'inv_user_id' => $inv_user_id,
                'from_villgro' => $data2[0]['from_villgro'],
                'support_name' => $data2[0]['support_name'],
                'hear_abt' => $data2[0]['hear_abt'],
                'referal_name' => $data2[0]['referal_name'],
                'ant_org' => $data2[0]['ant_org'],
                'ant_org_name' => $data2[0]['ant_org_name'],
                'won_competition' => $data2[0]['won_competition'],
                'competition_name' => $data2[0]['competition_name'],
                'business_plan' => '',
                'add_info' => '',
            );

            $table = "inv_additional_info";
            $result = $this->Minnovation->pitch_insert($table, $additional_info_data);

            /* inv_additional_info insertend */

            /* inv_member insert */

            $member_data = array(
                'mem_name' => $data5[0]['mem_name'],
                'mem_occupation' => $data5[0]['mem_occupation'],
                'mem_org' => $data5[0]['mem_org'],
                'mem_email' => $data5[0]['mem_email'],
                'mem_mobile' => $data5[0]['mem_mobile'],
                'mem_resume' => '',
                'inv_user_id' => $inv_user_id,
            );

            $table = "inv_member";
            $result = $this->Minnovation->pitch_insert($table, $member_data);
        } else if ($data[0]['program'] == '3') {

            $partnercount = $data[0]['partner_count'] + 1;
            $innovation_data = array(
                'innovation_id' => $data[0]['innovation_id'],
                'copy_id' => $data[0]['copy_id'],
                'other_partner_id' => $data[0]['other_partner_id'],
                'name_of_entrepreneur' => $data[0]['name_of_entrepreneur'],
                'name_of_enterprise' => $data[0]['name_of_enterprise'],
                'email_id' => $data[0]['email_id'],
                'mobile_no' => $data[0]['mobile_no'],
                'address_line1' => $data[0]['address_line1'],
                'address_line2' => $data[0]['address_line2'],
                'country' => $data[0]['country'],
                'sector' => $data[0]['sector'],
                'status' => '0',
                'stage' => '0',
                'program' => '3',
                'source' => '-1',
                'copied_date' => date('Y-m-d'),
                'created_date' => $data[0]['created_date'],
                'created_by' => $data[0]['created_by'],
                'partner_id' => "0" . $name,
                'copy_text' => $comment,
                'copy_partner_id' => "0" . $this->session->userdata('partner_id'),
                'copy_status' => "4",
                'partner_count' => str_pad($partnercount, 2, "0", STR_PAD_LEFT));

            $table = "innovation_pool";

            $inc_inv_id = $this->pitch_copyinsert($table, $innovation_data);

            $this->db->select('*');
            $this->db->where('inno_id', $data[0]['innovation_id']);
            $query1 = $this->db->get('pitch_user', $data[0]['innovation_id']);
            $data1 = $query1->result_array();

            $user_data = array(
                'inno_id' => 'INV' . $inc_inv_id,
                'org_name' => $data1[0]['org_name'],
                'app_name' => $data1[0]['app_name'],
                'age' => $data1[0]['age'],
                'email' => $data1[0]['email'],
                'mobileno' => $data1[0]['mobileno'],
                'altmobileno' => $data1[0]['altmobileno'],
                'city' => $data1[0]['city'],
                'status_pitch' => 'completed',
                'submitted_date' => date('Y-m-d'),
            );

            $table = "pitch_user";
            $pitch_id = $this->Minnovation->pitch_insert($table, $user_data);

            $this->db->select('*');
            $this->db->where('pitch_id', $data1[0]['pitch_id']);
            $query2 = $this->db->get('pitch_step1_members', $data1[0]['pitch_id']);
            $data2 = $query2->result_array();

            $member_data = array(
                'name' => $data2[0]['name'],
                'cur_org' => $data2[0]['cur_org'],
                'email' => $data2[0]['email'],
                'phone' => $data2[0]['phone'],
                'pitch_id' => $pitch_id,
            );

            $table = "pitch_step1_members";
            $result = $this->Minnovation->pitch_insert($table, $member_data);

            $this->db->select('*');
            $this->db->where('pitch_id', $data1[0]['pitch_id']);
            $query3 = $this->db->get('pitch_step2', $data1[0]['pitch_id']);
            $data3 = $query3->result_array();
            $org_data = array(
                'addr_problem' => $data3[0]['addr_problem'],
                'quest_1' => $data3[0]['quest_1'],
                'ent_impact' => $data3[0]['ent_impact'],
                'sector' => $data3[0]['sector'],
                'areas_other' => $data3[0]['areas_other'],
                'stage' => $data3[0]['stage'],
                'fund_req' => $data3[0]['fund_req'],
                'revenue' => $data3[0]['revenue'],
                'profile_desc' => $data3[0]['profile_desc'],
                'fund' => $data3[0]['fund'],
                'quest_5' => $data3[0]['quest_5'],
                'awards_yes' => $data3[0]['awards_yes'],
                'city' => $data3[0]['city'],
                'about_us' => $data3[0]['about_us'],
                'emailer' => $data3[0]['emailer'],
                'social_media' => $data3[0]['social_media'],
                'website' => $data3[0]['website'],
                'other_website' => $data3[0]['other_website'],
                'other_aboutus' => $data3[0]['other_aboutus'],
                'pitch_id' => $pitch_id);

            $table = "pitch_step2";
            $result = $this->Minnovation->pitch_insert($table, $org_data);

            $this->db->select('*');
            $this->db->where('pitch_id', $data1[0]['pitch_id']);
            $query4 = $this->db->get('award_share', $data1[0]['pitch_id']);
            $data4 = $query4->result_array();

            $doc_data = array(
                'doc1' => $data4[0]['doc1'],
                'doc2' => $data4[0]['doc2'],
                'doc3' => $data4[0]['doc3'],
                'pitch_id' => $pitch_id);

            $table = "award_share";
            $result = $this->Minnovation->pitch_insert($table, $doc_data);
        }
        /* inv_member insert */

        $this->copyRequestMail($data[0]['name_of_entrepreneur'], $data[0]['email_id'], $data[0]['partner_id'], $name, $data[0]['id'], $inc_inv_id);
        $copustatusupdate = $this->innovationupdate($data[0]['id']);
    }

    public function copyRequestMail($ent_name, $id, $partner, $sourcepartner, $invid, $inc_inv_id) {
        $partnerid = ltrim($partner, '0');
        $sql = "SELECT branch_email,branch_name FROM hs_hr_branch where id = " . $partnerid . "";
        $result = mysqli_query($sql);
        $row1 = mysqli_fetch_array($result);

        $sql1 = "SELECT branch_email,branch_name FROM hs_hr_branch where id = " . $sourcepartner . "";
        $result1 = mysqli_query($sql1);
        $row2 = mysqli_fetch_array($result1);

        $detail_text = 'SEND my application form to your partner organization';
        $detail_No = 'DO NOT SEND my application form to your partner organizations';
        $yes = 'yes';
        $no = 'no';
        $detailLink = 'text.php/?id=' . base64_encode($invid) . '&id1=' . base64_encode($inc_inv_id) . '&id3=' . $sourcepartner . '&yes=' . base64_encode($yes);
        $detailcopyLink = 'text.php/?id=/' . base64_encode($invid) . '&id1=' . base64_encode($inc_inv_id) . '&id3=' . $sourcepartner . '&no=' . base64_encode($no);

        $mailContent = "<p> Dear " . $ent_name . "</p><p>Greetings from " . $row1['branch_name'] . "!</p>
        <p>We have received your incubation application form and would like our partner organization, " . $row2['branch_name'] . " to review your application as well. We feel you might be better suited to their application criterion. </p>
        <p>If you would like us to send the application form to " . $row2['branch_name'] . ", please click here - <a href='" . host_url() . "IncubationForm/" . ($detailLink) . "'>" . $detail_text . "</a>.</p><p>If you do not want your application to be transferred, please click here - <a href='" . host_url() . "IncubationForm/" . ($detailcopyLink) . "'>" . $detail_No . "</a>.</p><p>Please contact us at apply@villgro.org if you have any questions regarding the Incubation program. Or email us at it@villgro.org for technical queries. </p><p>Thank You,</p><p>Your response has been recorded. Please contact us at Villgro Incubation team, if you have any queries. </p>";

        $ci = &get_instance();
        $ci->load->library('email');
        $to = $id;
        $messageSubject = $row1['branch_name'] . " - Request for transfer of Incubation application";
        $messageBody = $mailContent;
        $ci->email->set_newline("\r\n");
        $ci->email->from($from, "Villgro Applications");
        $ci->email->reply_to('apply@villgro.org');
        $ci->email->to($to);

        if ($attach != 'NULL') {
            foreach ($attach as $key => $value):
                $ci->email->attach($value);
            endforeach;
        }
        $ci->email->subject($messageSubject);
        $ci->email->message($messageBody);
        $ci->email->send();
    }

    public function getdealsScoreboard() {
        $end_to = date('d/m/Y');
        $healthcare = 'a:1:{i:0;s:10:"healthcare";}';
        $agri = 'a:1:{i:0;s:13:"agri-business";}';
        $edu = 'a:1:{i:0;s:9:"education";}';
        $others = 'a:1:{i:0;s:6:"others";}';
        $this->db->select("SUM(CASE WHEN pitchstep.sector = '" . $healthcare . "' THEN 1  ELSE 0 END) AS Healthcare,
           SUM(CASE WHEN pitchstep.sector = '" . $agri . "' THEN 1  ELSE 0 END) AS AgriBusiness,
           SUM(CASE WHEN pitchstep.sector = '" . $edu . "' THEN 1 ELSE 0 END) AS Education,
           SUM(CASE WHEN pitchstep.sector = '" . $others . "' THEN 1 ELSE 0 END) AS Others");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = AA.associate_employee) as AssignIncharge", false);
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id');
        $this->db->join('pitch_step2 pitchstep', 'pitchstep.pitch_id = pitch.pitch_id');
        $this->db->where('IP.program', '3');
        $this->db->where('AA.status', '1');
        $this->db->where('pitch.submitted_date >=', '2017-11-22');
        $this->db->where('pitch.submitted_date <=', date2mysql($end_to));
        $this->db->group_by('AssignIncharge');
        $query = $this->db->get('innovation_pool IP');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function pitch_copyinsert($table, $data) {
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();

        return $id;
    }

    public function getPartnersRecords($enterprise, $enterpreneur, $email, $type) {
        // and IP.status != '4'
        $searchArray[] = "IP.copy_status != '4' and IP.status != '10' and IP.status != '11'";
        if (!empty($enterprise) && $enterprise != 1) {
            $searchArray[] = "IP.name_of_enterprise like '%" . $enterprise . "%'";
        }
        if (!empty($enterpreneur) && $enterpreneur != 1) {
            $searchArray[] = "IP.name_of_entrepreneur like '%" . $enterpreneur . "%'";
        }
        if (!empty($email) && $email != 1) {
            $searchArray[] = "(IP.email_id = '" . $email . "' or MEM.mem_email = '" . $email . "')";
        }
        $whereCond = implode(' and ', $searchArray);
        $data = array();

        $this->db->select("IP.*,SM.source_name,pitch.pitch_id,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");
        $this->db->select("GF.fstage,GF.donor_fit,GF.LIS");
        $this->db->select("INV.submitted_date");
        $this->db->select("(select branch_name from  " . $this->hris->database . ".hs_hr_branch where id = IP.partner_id) as branch_name", false);
        $this->db->select("pitch.submitted_date as pitch_submitted_date");
        $this->db->select("eir.date_submitted as eir_submitted_date");
        $this->db->select("IFNULL(IFNULL(pitch.submitted_date, INV.submitted_date),eir.date_submitted) AS dsubmitted");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('inv_member MEM', 'MEM.inv_user_id = INV.id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id=pitch.pitch_id', 'left');
        $this->db->join('inv_additional_info iaf ', 'iaf.inv_user_id=INV.id', 'left');
        $this->db->join('inv_ent_info iet ', 'iet.inv_user_id=INV.id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
        $this->db->join('(SELECT innovation_id, id, fstage, donor_fit,fund_recom,cio_status, LIS
           FROM grading_feedback AS ga
           INNER JOIN (
           SELECT max( id ) AS maxid
           FROM grading_feedback
           GROUP BY innovation_id
       ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
        $this->db->distinct();
        $this->db->order_by('dsubmitted', 'desc');

        if (!empty($whereCond)) {
            $query = $this->db->get_where('innovation_pool IP', $whereCond);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }
        foreach ($query->result_array() as $row) {
            $searchPartners = $row['partner_id'];
            if ($searchPartners == '01') {
                $partnersList = 'Villgro India';
            } else if ($searchPartners == '02') {
                $partnersList = 'Villgro Kenya';
            } else if ($searchPartners == '03') {
                $partnersList = 'Menterra';
            } else if ($searchPartners == '04') {
                $partnersList = 'Startup Oasis';
            } else if ($searchPartners == '05') {
                $partnersList = 'IIMC';
            } else if ($searchPartners == '06') {
                $partnersList = 'KIIT';
            } else if ($searchPartners == '07') {
                $partnersList = 'SIIC';
            } else if ($searchPartners == '08') {
                $partnersList = 'External Vendors';
            } else if ($searchPartners == '10') {
                $partnersList = 'Powering Livelihoods';
            }

            if ($row['copy_partner_id'] == '') {
                $inv_id = $row['copy_id'] . "_" . $row['partner_id'] . "_" . $row['partner_count'];
            } else {
                $inv_id = $row['copy_id'] . "_" . $row['copy_partner_id'] . "_" . $row['partner_count'];
            }
            if ($type == 1) {
                $enterprise = (strlen($row['name_of_enterprise']) > 15) ? substr($row['name_of_enterprise'], 0, 15) . ".." : $row['name_of_enterprise'];
                $entrepreneur = strlen($row['name_of_entrepreneur']) > 15 ? substr($row['name_of_entrepreneur'], 0, 15) . ".." : $row['name_of_entrepreneur'];
            } else if ($type == 2) {
                $enterprise = $row['name_of_enterprise'];
                $entrepreneur = $row['name_of_entrepreneur'];
            }
            if ($row['sector'] == 'MCH') {
                $sector = 'Maternal & child health';
            } else if ($row['sector'] > 0) {
                $sector = $this->Minnovation->getNewSectorDetails($row['sector']);
            } else if ($row['program'] > 0) {
                $sector = $this->Minnovation->getSectorName($row['pitch_id']);
            } else {
                $sector = $row['sector'];
            }

            $stage = $this->Minnovation->getInnvationStage();
            $status = $this->Minnovation->getInnvationStatus();

//            $stage_text = ($row['fstage'] == '') ? $stage[$row['stage']] : $row['fstage'];
            $stage_text = $stage[$row['stage']];
            $status_text = $status[$row['status']];
            if ($row['created_date'] == '0000-00-00 00:00:00') {
                $identified_date = '-';
            } else {
                $identified_date = date("d-M-y", strtotime($row['created_date']));
            }
            $email = $row['email_id'];
            $phone = $row['mobile_no'];
            if ($row['program'] == '1') {
                $program = 'EIR';
                $submitted_date1 = ($row['eir_submitted_date'] != '0000-00-00') ? date("d-M-y", strtotime($row['eir_submitted_date'])) : '-';
                $submitted_date = $submitted_date1;
            } else if ($row['program'] == '2') {
                $program = 'SEED';
                if ($row['id'] == '2336')
                    $submitted_date = '27-May-14';
            } else if ($row['program'] == '3') {
                $program = 'Unc Pitch';
                $submitted_date1 = ($row['pitch_submitted_date'] != '0000-00-00') ? date("d-M-y", strtotime($row['pitch_submitted_date'])) : '-';
                $submitted_date = $submitted_date1;
            } else if ($row['program'] == '4') {
                $program = 'Incubation';
                $submitted_date1 = ($row['pitch_submitted_date'] != '0000-00-00') ? date("d-M-y", strtotime($row['pitch_submitted_date'])) : '-';
                $submitted_date = $submitted_date1;
            } else if ($row['program'] == '0') {
                $program = 'Incubation';
                $submitted_date1 = ($row['submitted_date'] !== '0000-00-00') ? date("d-M-y", strtotime($row['submitted_date'])) : '-';
                $submitted_date = $submitted_date1;
            } else {
                $submitted_date1 = ($row['submitted_date'] !== '0000-00-00') ? date("d-M-y", strtotime($row['submitted_date'])) : '-';
                $submitted_date = $submitted_date1;
            }

            $data[] = [
                'partnersList' => $partnersList,
                'inv_id' => $inv_id,
                'enterprise' => $enterprise,
                'entrepreneur' => $entrepreneur,
                'sector' => $sector,
                'stage' => $stage_text,
                'status_text' => $status_text,
                'identified_date' => $identified_date,
                'email' => $email,
                'phone' => $phone,
                'submitted_date' => $submitted_date,
            ];
        }

        return $data;
    }

    public function getLimitRecords_portfolio($options = array()) {
        $data = array();
        $whereQuery = $this->_search($options);
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        } else {
            $this->db->order_by('dsubmitted', 'desc');
        }

        $this->db->select("IP.*,SM.source_name,pitch.pitch_id,pitch.lang_code,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");
        // $this->db->select("GF.fstage,GF.donor_fit,GF.LIS");
        $this->db->select("INV.submitted_date");
        $this->db->select("(select branch_name from  " . $this->hris->database . ".hs_hr_branch where id = IP.partner_id) as branch_name", false);
        $this->db->select("pitch.submitted_date as pitch_submitted_date");
        $this->db->select("award_share.doc1 as pitch_doc1, award_share.doc2 as pitch_doc2");
        $this->db->select("INV_INFO.business_plan as inc_doc1, INV_INFO.add_info as inc_doc2");
        $this->db->select("eir.date_submitted as eir_submitted_date");
        $this->db->select("IFNULL(IFNULL(pitch.submitted_date, INV.submitted_date),eir.date_submitted) AS dsubmitted");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('inv_additional_info INV_INFO', 'INV_INFO.inv_user_id = INV.id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('award_share', 'award_share.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');

        // $this->db->join('(SELECT innovation_id, id, fstage, donor_fit,fund_recom,cio_status, LIS
        //     FROM grading_feedback AS ga
        //     INNER JOIN (
        //     SELECT max( id ) AS maxid
        //     FROM grading_feedback
        //     GROUP BY innovation_id
        // ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
        $this->db->distinct();

        if (isset($options['innovation_score'])) {
            $this->db->select('INS.*');
            $this->db->join('innovation_score INS', 'INS.innovation = IP.id', 'left');
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        $isAssign = false;
        $isExport = false;
        $isAssignCycle = false;
        $isDetails = true;
        $isCopy = false;
        $isDownload = true;

        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio', 'superadmin'))) {
            $isAssign = true;
            $isExport = true;
            $isAssignCycle = true;
        }
        $total = $this->getAllCount($options);
        if ($query->num_rows() > 0) {

            $this->load->model('scouting/Mincharge');
            $j = $_GET['iDisplayStart'];
            $q = 1;
            foreach ($query->result_array() as $row) {

                $pitch_language = isset($row['lang_code']) && $row['lang_code'] != '' ? $row['lang_code'] : 'en';
                if ($pitch_language == 'hi') {
                    $deals_lang = 'Hindi';
                } else {
                    $deals_lang = 'English';
                }


                $copy = $row['copy_partner_id'];
                $copyud = substr($copy, 1);
                $sql = "SELECT branch_name FROM hs_hr_branch where id = " . $copyud . "";
                $result = mysqli_query($sql);
                $row1 = mysqli_fetch_array($result);

                $asArray = array();
                $associate = $this->Mincharge->getAssociate(array('innovation' => $row['id'], 'active' => 'Active'));

                foreach ($associate as $as):
                    $asArray[] = $as['emp_name'];
                endforeach;
                $row['associate_emp_name'] = implode(', ', $asArray);

                $branch_name = $row['branch_name'];
                if ($row['copy_partner_id'] == '') {
                    $inv_id = $row['copy_id'] . "_" . $row['partner_id'] . "_" . $row['partner_count'];
                } else {
                    $inv_id = $row['copy_id'] . "_" . $row['copy_partner_id'] . "_" . $row['partner_count'];
                }
                if ((in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) && ($this->session->userdata('partner_id') == $row['partner_id'])) || ($this->session->userdata('partner_id') == $row['partner_id']) || $this->session->userdata('user_type') == 'superadmin') {
                    $isCopy = true;
                }
                if ($this->session->userdata('user_name') == 'Altacit') {
                    $detailLink1 = 'scouting/innovation_details/' . $row['id'];
                } else {
                    if (($this->uri->segment('3') == 'incubation') || ($this->uri->segment('3') == 'assigned_incubation')) {
                        $detailLink1 = 'login/myportfolio/' . $row['id'];
                    } else if ($this->uri->segment('3') == 'decision_pending') {
                        $detailLink1 = 'assessment/view_list/' . $row['id'];
                    } else {
                        $detailLink1 = 'login/assessment/' . $row['id'];
                    }
                }
                $ep = (strlen($row['name_of_enterprise']) > 15) ? substr($row['name_of_enterprise'], 0, 15) . ".." : $row['name_of_enterprise'];
                $enterprise = "<a href=" . site_url($detailLink1) . "> <span title='" . $row['name_of_enterprise'] . "'>" . $ep . "</span></a>";
                $er = strlen($row['name_of_entrepreneur']) > 15 ? substr($row['name_of_entrepreneur'], 0, 15) . ".." : $row['name_of_entrepreneur'];
                $entrepreneur = "<span title='" . $row['name_of_entrepreneur'] . "'>" . $er . "</span></a>";

                $userName = $this->Minnovation->getUsername($row['created_by']);
                if ($row['source'] == '0' || $row['source'] == '123') {
                    $source = 'Website';
                } else if ($row['source'] == '124' && $row['sourceType'] == '135') {
                    $source = 'Website - iPitch 2019';
                } else if ($row['source'] == '125' && $row['sourceType'] == '135') {
                    $source = 'Website - Powering Livelihoods';
                } else if ($row['source'] == '2') {
                    $source = 'Imported';
                } else {
                    $source = 'Added by' . " " . $userName[0]['emp_firstname'];
                }
                if (is_numeric($row['sourceType'])) {
                    $SType = $this->Minnovation->getSourceName($row['sourceType']);
                    $source_type = $SType[0]['master_name'];
                } else {
                    $source_type = $row['sourceType'];
                }

                $other_partners = $row['other_partner_id'];
                $partnersList = $get_partner_id = array();
                if ($other_partners != '') {
                    $explode_partners = explode(',', $other_partners);
                    for ($i = 0; $i < count($explode_partners); $i++) {
                        $individual_id = $explode_partners[$i];
                        $this->db->select('t1.partner_id');
                        $this->db->where("t2.id", $individual_id);
                        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
                        $query = $this->db->get('innovation_pool t1');
                        if ($query->num_rows() > 0) {
                            foreach ($query->result_array() as $partner_row) {
                                if ($partner_row['partner_id'] == '01') {
                                    $partner_nam = 'Villgro India';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '02') {
                                    $partnersList = 'Villgro Kenya';
                                } else if ($partner_row['partner_id'] == '03') {
                                    $partnersList = 'Menterra';
                                } else if ($partner_row['partner_id'] == '04') {
                                    $partner_nam = 'Startup Oasis';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '05') {
                                    $partner_nam = 'IIMC';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '06') {
                                    $partner_nam = 'KIIT';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '07') {
                                    $partner_nam = 'SIIC';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '08') {
                                    $partner_nam = 'External Vendors';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '10') {
                                    $partner_nam = 'Powering Livelihoods';
                                    array_push($get_partner_id, $partner_nam);
                                }
                            }
                        }
                    }
                }
                $partnersList = implode(',', array_unique($get_partner_id));
                if ($row['sector'] == 'MCH') {
                    $sector_name = 'Maternal & child health';
                } else if ($row['sector'] > 0) {
                    $sector_name = $this->Minnovation->getNewSectorDetails($row['sector']);
                } else if ($row['program'] > 0) {
                    $sector_name = $this->Minnovation->getSectorName($row['pitch_id']);
                } else {
                    $sector_name = $row['sector'];
                }

                $sector_len = strlen($sector_name) > 12 ? substr($sector_name, 0, 12) . ".." : $sector_name;
                $sector = "<span title='" . $sector_name . "'>" . $sector_len . "</span></a>";
                $stage = $this->Minnovation->getInnvationStage();
                $status = $this->Minnovation->getInnvationStatus();

                $stage_text = strlen($stage[$row['stage']]) > 12 ? substr($stage[$row['stage']], 0, 12) . ".." : $stage[$row['stage']];
                $get_status_text = strlen($status[$row['status']]) > 12 ? substr($status[$row['status']], 0, 12) . ".." : $status[$row['status']];
                $status_text = "<span title='" . $status[$row['status']] . "'>" . $get_status_text . "</span></a>";
                if ($row['created_date'] == '0000-00-00 00:00:00') {
                    $identified_date = '-';
                } else {
                    $identified_date = date("d-M-y", strtotime($row['created_date']));
                }
                $geography = $row['state'];
                $city = $row['city'];
                if ($row['LIS'] == '0') {
                    $lis = 'No';
                } else if ($row['LIS'] == '1') {
                    $lis = 'Yes';
                } else {
                    $lis = '';
                }

                $names = $this->getDonorFitName($row['donor_fit']);
                $donor_fit = implode(',', $names);
                $assign = $row['associate_emp_name'];
                $email = $row['email_id'];
                $phone = $row['mobile_no'];
                $copied_date1 = $row['copied_date'];
                if ($copied_date1 != null) {
                    $copied_date = date("d-m-Y", strtotime($copied_date1));
                } else {
                    $copied_date = '';
                }

                if ($row['program'] == '1') {
                    $program = 'EIR';
                    $submitted_date1 = ($row['eir_submitted_date'] != '0000-00-00') ? $row['eir_submitted_date'] : '0000-00-00';
                    $submitted_date = date("d-M-y", strtotime($submitted_date1));
                } else if ($row['program'] == '2') {
                    $program = 'SEED';
                    if ($row['id'] == '2336')
                        $submitted_date = '27-May-14';
                } else if ($row['program'] == '3') {
                    $program = 'Unc Pitch';
                    $submitted_date1 = ($row['pitch_submitted_date'] != '0000-00-00') ? date("d-M-y", strtotime($row['pitch_submitted_date'])) : '-';
                    $submitted_date = $submitted_date1;
                } else if ($row['program'] == '4') {
                    $program = 'Incubation';
                    $submitted_date1 = ($row['pitch_submitted_date'] != '0000-00-00') ? date("d-M-y", strtotime($row['pitch_submitted_date'])) : '-';
                    $submitted_date = $submitted_date1;
                } else if ($row['program'] == '0') {
                    $program = 'Incubation';
                    $submitted_date1 = ($row['submitted_date'] !== '0000-00-00') ? date("d-M-y", strtotime($row['submitted_date'])) : '-';
                    $submitted_date = $submitted_date1;
                } else {
                    $submitted_date1 = ($row['submitted_date'] !== '0000-00-00') ? date("d-M-y", strtotime($row['submitted_date'])) : '-';
                    $submitted_date = $submitted_date1;
                }
                //////////////////////////////detail view link/////////////////////
                if ($isDetails) {

                    if ($this->session->userdata('user_name') == 'Altacit') {
                        $detailLink = 'scouting/innovation_details/' . $row['id'];
                    } else {
                        if (($this->uri->segment('3') == 'incubation') || ($this->uri->segment('3') == 'assigned_incubation')) {
                            $detailLink = 'login/myportfolio/' . $row['id'];
                        } else if ($this->uri->segment('3') == 'decision_pending') {
                            $detailLink = 'assessment/view_list/' . $row['id'];
                        } else {
                            $detailLink = 'login/assessment/' . $row['id'];
                        }
                    }
                    $detail_text = 'Details';
                    $details = "<a href=" . site_url($detailLink) . " class='button' style='white-space: nowrap'>" . $detail_text . "</a>";
                }
                if ($isCopy) {
                    $sql = "SELECT branch_name FROM hs_hr_branch where id = " . $row['copy_partner_from'] . "";
                    $result = mysqli_query($sql);
                    $row1 = mysqli_fetch_array($result);
                    if ($this->session->userdata('accessTo') != '' || $this->session->userdata('user_type') == 'superadmin' || $this->session->userdata('user_type') == 'admin' || $this->session->userdata('role_id') == '1' || $this->session->userdata('role_id') == '2') {
                        if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '0') {

                            $copytext = 'Copy';
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' class='button' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext . "</a>";
                        } else if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '1') {
                            $copytext = 'Pending';
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' disabled = 'disabled' value='" . $row['id'] . "' style='color:#000' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext . "</a>";
                        } else if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '2') {
                            $copytext1 = 'Copied to ' . $row1['branch_name'];
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' disabled = 'disabled' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' style='color:#000' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext1 . "</a>";
                        } else if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '3') {
                            $copytext = 'Copy Declined';
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' disabled = 'disabled' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' style='color:#000' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext . "</a>";
                        } else if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '5') {
                            $copytext = 'Copy Innovation';
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' disabled = 'disabled' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' style='color:#000' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext . "</a>";
                        }
                    }
                }

                $doc_files = $attach_click = $download_values = '';
                // if ($row['program'] == 0 && ($row['inc_doc1'] != '' || $row['inc_doc2'] != '')) {
                if ($row['program'] == 0) {
                    $doc_files = '"' . $row['id'] . '",0, "' . $row['inc_doc1'] . '","' . $row['inc_doc2'] . '"';
                    $attach_click = "onclick='attachmentDownload(" . $doc_files . ");'";
                    $download_values = $row['id'] . '/' . $options['currentTab'] . '/' . $row['inc_doc1'] . '/' . $row['inc_doc2'];
                    // } else if ($row['program'] == 3 && ($row['pitch_doc1'] != '' || $row['pitch_doc2'] != '')) {
                } else if ($row['program'] == 3) {
                    $doc_files = '"' . $row['id'] . '",3, "' . $row['pitch_doc1'] . '","' . $row['pitch_doc2'] . '"';
                    $attach_click = "onclick='attachmentDownload(" . $doc_files . ");'";
                    $download_values = $row['id'] . '/' . $options['currentTab'] . '/' . $row['pitch_doc1'] . '/' . $row['pitch_doc2'];
                } else if ($row['program'] == 4) {
                    $doc_files = '"' . $row['id'] . '",4, "' . $row['pitch_doc1'] . '","' . $row['pitch_doc2'] . '"';
                    $attach_click = "onclick='attachmentDownload(" . $doc_files . ");'";
                    $download_values = $row['id'] . '/' . $options['currentTab'] . '/' . $row['pitch_doc1'] . '/' . $row['pitch_doc2'];
                }

                //////download//////
                if ($isDownload) {
                    $download_text = 'Download';
                    $downloadLink = 'scouting/export_deals_pdf/' . $download_values;
                    $download = "<a href='javascript:void(0)' " . $attach_click . " class='button downloadIcon' style='white-space: nowrap'><img src='" . base_url() . "source/template/images/icons/download.png'/></a>";
//                    $download = "<a href=" . site_url($downloadLink) . " target='_blank' class='button downloadIcon' style='white-space: nowrap'><img src='" . base_url() . "source/template/images/icons/download.png'/></a>";
                }
                ///////////////////////delete//////////////////////////
                //////////////////////////// id check box/////////////////////////////

                $select = '';
                if ($row['status'] != '3' && $row['status'] != '4' && in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio'))) {
                    $select = '<input type="checkbox" class="chk_box enablefan" name="innovation_id[]" value="' . $row['id'] . '"/>';
                } else {
                    // $select = $q;
                }

                if (($this->session->userdata('user_type') == 'admin' && $this->session->userdata('partner_id') == $row['partner_id'])) {
                    if ($row['status'] != '11') {
                        $delete = "<a href='javascript:void(0);' program=" . str_replace(" ", "-", $program) . " url=" . site_url('scouting/delete/' . $row['id']) . " class='DeleteInnovation confirmDelete downloadIcon'><img src='" . base_url() . "source/template/images/icons/delete.png'/></a>";
                    } else {
                        $delete = '';
                    }
                    $data[] = array($select, $inv_id, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $city, $identified_date, $deals_lang, $partnersList, $assign, $email, $phone, $submitted_date, $delete, $download);
                } else if ($this->session->userdata('user_type') == 'superadmin') {
                    if ($row['status'] != '11') {
                        $delete = "<a href='javascript:void(0);' program=" . str_replace(" ", "-", $program) . " url=" . site_url('scouting/delete/' . $row['id']) . " class='DeleteInnovation confirmDelete downloadIcon'><img src='" . base_url() . "source/template/images/icons/delete.png'/></a>";
                    } else {
                        $delete = '';
                    }
                    $data[] = array($select, $inv_id, $branch_name, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $city, $identified_date, $deals_lang, $partnersList, $assign, $email, $phone, $submitted_date, $delete, $download);
                } else {
                    $data[] = array($inv_id, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $city, $identified_date, $deals_lang, $partnersList, $assign, $email, $phone, $submitted_date, $download);
                }
                $q++;

                /* old deal listing page
                  $select = '';
                  if ($row['status'] != '3' && $row['status'] != '4' && in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio'))) {
                  $select = '<input type="checkbox" class="chk_box enablefan" name="innovation_id[]" value="' . $row['id'] . '"/>';
                  }

                  if (($this->session->userdata('user_type') == 'admin' && $this->session->userdata('partner_id') == $row['partner_id'])) {
                  if ($row['status'] != '11') {
                  $delete = "<a href='javascript:void(0);' program=" . str_replace(" ", "-", $program) . " url=" . site_url('scouting/delete/' . $row['id']) . " class='DeleteInnovation confirmDelete'><img src='" . base_url() . "source/template/images/icons/cross.png'/></a>";
                  } else {
                  $delete = '';
                  }
                  $data[] = array($select, $inv_id, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $identified_date, $city, $partnersList, $assign, $email, $phone, $submitted_date, $copied_date, $details, $download, $delete, $copy);
                  } else if ($this->session->userdata('user_type') == 'superadmin') {
                  if ($row['status'] != '11') {
                  $delete = "<a href='javascript:void(0);' program=" . str_replace(" ", "-", $program) . " url=" . site_url('scouting/delete/' . $row['id']) . " class='DeleteInnovation confirmDelete'><img src='" . base_url() . "source/template/images/icons/cross.png'/></a>";
                  } else {
                  $delete = '';
                  }
                  $data[] = array($select, $inv_id, $branch_name, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $identified_date, $city, $partnersList, $assign, $email, $phone, $submitted_date, $copied_date, $details, $download, $delete, $copy);
                  } else {
                  $data[] = array($select, $inv_id, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $identified_date, $city, $partnersList, $assign, $email, $phone, $submitted_date, $copied_date, $details, $download, $copy);
                  }
                 */
              }
          }
          $query->free_result();
          $returnArray = array();
          $returnArray = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => array(),
        );
          $returnArray["aaData"] = $data;
          return $returnArray;
      }

      public function getLimitRecords_new($options = array()) {
        $data = array();
        $whereQuery = $this->_search($options);
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        } else {
            $this->db->order_by('dsubmitted', 'desc');
        }

        $this->db->select("IP.*,SM.source_name,pitch.pitch_id,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");

        $this->db->select("GF.fstage,GF.donor_fit,GF.LIS");
        $this->db->select("INV.submitted_date");
        $this->db->select("(select branch_name from  " . $this->hris->database . ".hs_hr_branch where id = IP.partner_id) as branch_name", false);
        $this->db->select("pitch.submitted_date as pitch_submitted_date");
        $this->db->select("award_share.doc1 as pitch_doc1, award_share.doc2 as pitch_doc2");
        $this->db->select("INV_INFO.business_plan as inc_doc1, INV_INFO.add_info as inc_doc2");
        $this->db->select("eir.date_submitted as eir_submitted_date");
        $this->db->select("IFNULL(IFNULL(pitch.submitted_date, INV.submitted_date),eir.date_submitted) AS dsubmitted");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('inv_additional_info INV_INFO', 'INV_INFO.inv_user_id = INV.id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('award_share', 'award_share.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');

        $this->db->join('(SELECT innovation_id, id, fstage, donor_fit,fund_recom,cio_status, LIS
            FROM grading_feedback AS ga
            INNER JOIN (
            SELECT max( id ) AS maxid
            FROM grading_feedback
            GROUP BY innovation_id
        ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
        $this->db->distinct();

        if (isset($options['innovation_score'])) {
            $this->db->select('INS.*');
            $this->db->join('innovation_score INS', 'INS.innovation = IP.id', 'left');
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        $isAssign = false;
        $isExport = false;
        $isAssignCycle = false;
        $isDetails = true;
        $isCopy = false;
        $isDownload = true;

        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio', 'superadmin'))) {
            $isAssign = true;
            $isExport = true;
            $isAssignCycle = true;
        }
        $total = $this->getAllCount($options);
        if ($query->num_rows() > 0) {

            $this->load->model('scouting/Mincharge');
            $j = $_GET['iDisplayStart'];

            foreach ($query->result_array() as $row) {

                $copy = $row['copy_partner_id'];
                $copyud = substr($copy, 1);
                $sql = "SELECT branch_name FROM hs_hr_branch where id = " . $copyud . "";
                $result = mysqli_query($sql);
                $row1 = mysqli_fetch_array($result);

                $asArray = array();
                $associate = $this->Mincharge->getAssociate(array('innovation' => $row['id'], 'active' => 'Active'));

                foreach ($associate as $as):
                    $asArray[] = $as['emp_name'];
                endforeach;
                $row['associate_emp_name'] = implode(', ', $asArray);

                $branch_name = $row['branch_name'];
                if ($row['copy_partner_id'] == '') {
                    $inv_id = $row['copy_id'] . "_" . $row['partner_id'] . "_" . $row['partner_count'];
                } else {
                    $inv_id = $row['copy_id'] . "_" . $row['copy_partner_id'] . "_" . $row['partner_count'];
                }
                if ((in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) && ($this->session->userdata('partner_id') == $row['partner_id'])) || ($this->session->userdata('partner_id') == $row['partner_id']) || $this->session->userdata('user_type') == 'superadmin') {
                    $isCopy = true;
                }
                if ($this->session->userdata('user_name') == 'Altacit') {
                    $detailLink1 = 'scouting/innovation_details/' . $row['id'];
                } else {
                    if (($this->uri->segment('3') == 'incubation') || ($this->uri->segment('3') == 'assigned_incubation')) {
                        $detailLink1 = 'login/myportfolio/' . $row['id'];
                    } else if ($this->uri->segment('3') == 'decision_pending') {
                        $detailLink1 = 'assessment/view_list/' . $row['id'];
                    } else {
                        $detailLink1 = 'login/assessment/' . $row['id'];
                    }
                }
                $ep = (strlen($row['name_of_enterprise']) > 15) ? substr($row['name_of_enterprise'], 0, 15) . ".." : $row['name_of_enterprise'];
                $enterprise = "<a href=" . site_url($detailLink1) . ">" . $ep . "</a>";
                $entrepreneur = strlen($row['name_of_entrepreneur']) > 15 ? substr($row['name_of_entrepreneur'], 0, 15) . ".." : $row['name_of_entrepreneur'];

                $userName = $this->Minnovation->getUsername($row['created_by']);
                if ($row['source'] == '0' || $row['source'] == '123' || $row['source'] == '124' || $row['source'] == '125') {
                    $source = 'Website';
                } else if ($row['source'] == '2') {
                    $source = 'Imported';
                } else {
                    $source = 'Added by' . " " . $userName[0]['emp_firstname'];
                }
                if (is_numeric($row['sourceType'])) {
                    $SType = $this->Minnovation->getSourceName($row['sourceType']);
                    $source_type = $SType[0]['master_name'];
                } else {
                    $source_type = $row['sourceType'];
                }

                $other_partners = $row['other_partner_id'];
                $partnersList = $get_partner_id = array();
                if ($other_partners != '') {
                    $explode_partners = explode(',', $other_partners);
                    for ($i = 0; $i < count($explode_partners); $i++) {
                        $individual_id = $explode_partners[$i];
                        $this->db->select('t1.partner_id');
                        $this->db->where("t2.id", $individual_id);
                        $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
                        $query = $this->db->get('innovation_pool t1');
                        if ($query->num_rows() > 0) {
                            foreach ($query->result_array() as $partner_row) {
                                if ($partner_row['partner_id'] == '01') {
                                    $partner_nam = 'Villgro India';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '02') {
                                    $partnersList = 'Villgro Kenya';
                                } else if ($partner_row['partner_id'] == '03') {
                                    $partnersList = 'Menterra';
                                } else if ($partner_row['partner_id'] == '04') {
                                    $partner_nam = 'Startup Oasis';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '05') {
                                    $partner_nam = 'IIMC';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '06') {
                                    $partner_nam = 'KIIT';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '07') {
                                    $partner_nam = 'SIIC';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '08') {
                                    $partner_nam = 'External Vendors';
                                    array_push($get_partner_id, $partner_nam);
                                } else if ($partner_row['partner_id'] == '10') {
                                    $partner_nam = 'Powering Livelihoods';
                                    array_push($get_partner_id, $partner_nam);
                                }
                            }
                        }
                    }
                }
                $partnersList = implode(',', array_unique($get_partner_id));
                if ($row['sector'] == 'MCH') {
                    $sector = 'Maternal & child health';
                } else if ($row['sector'] > 0) {
                    $sector = $this->Minnovation->getNewSectorDetails($row['sector']);
                } else if ($row['program'] > 0) {
                    $sector = $this->Minnovation->getSectorName($row['pitch_id']);
                } else {
                    $sector = $row['sector'];
                }
                $stage = $this->Minnovation->getInnvationStage();
                $status = $this->Minnovation->getInnvationStatus();

                $stage_text = $stage[$row['stage']];
                $status_text = $status[$row['status']];
                if ($row['created_date'] == '0000-00-00 00:00:00') {
                    $identified_date = '-';
                } else {
                    $identified_date = date("d-M-y", strtotime($row['created_date']));
                }
                $geography = $row['state'];
                $city = $row['city'];
                if ($row['LIS'] == '0') {
                    $lis = 'No';
                } else if ($row['LIS'] == '1') {
                    $lis = 'Yes';
                } else {
                    $lis = '';
                }

                $names = $this->getDonorFitName($row['donor_fit']);
                $donor_fit = implode(',', $names);
                $assign = $row['associate_emp_name'];
                $email = $row['email_id'];
                $phone = $row['mobile_no'];
                $copied_date1 = $row['copied_date'];
                if ($copied_date1 != null) {
                    $copied_date = date("d-m-Y", strtotime($copied_date1));
                } else {
                    $copied_date = '';
                }

                if ($row['program'] == '1') {
                    $program = 'EIR';
                    $submitted_date1 = ($row['eir_submitted_date'] != '0000-00-00') ? $row['eir_submitted_date'] : '0000-00-00';
                    $submitted_date = date("d-M-y", strtotime($submitted_date1));
                } else if ($row['program'] == '2') {
                    $program = 'SEED';
                    if ($row['id'] == '2336')
                        $submitted_date = '27-May-14';
                } else if ($row['program'] == '3') {
                    $program = 'Unc Pitch';
                    $submitted_date1 = ($row['pitch_submitted_date'] != '0000-00-00') ? date("d-M-y", strtotime($row['pitch_submitted_date'])) : '-';
                    $submitted_date = $submitted_date1;
                } else if ($row['program'] == '4') {
                    $program = 'Incubation';
                    $submitted_date1 = ($row['pitch_submitted_date'] != '0000-00-00') ? date("d-M-y", strtotime($row['pitch_submitted_date'])) : '-';
                    $submitted_date = $submitted_date1;
                } else if ($row['program'] == '0') {
                    $program = 'Incubation';
                    $submitted_date1 = ($row['submitted_date'] !== '0000-00-00') ? date("d-M-y", strtotime($row['submitted_date'])) : '-';
                    $submitted_date = $submitted_date1;
                } else {
                    $submitted_date1 = ($row['submitted_date'] !== '0000-00-00') ? date("d-M-y", strtotime($row['submitted_date'])) : '-';
                    $submitted_date = $submitted_date1;
                }
                //////////////////////////////detail view link/////////////////////
                if ($isDetails) {

                    if ($this->session->userdata('user_name') == 'Altacit') {
                        $detailLink = 'scouting/innovation_details/' . $row['id'];
                    } else {
                        if (($this->uri->segment('3') == 'incubation') || ($this->uri->segment('3') == 'assigned_incubation')) {
                            $detailLink = 'login/myportfolio/' . $row['id'];
                        } else if ($this->uri->segment('3') == 'decision_pending') {
                            $detailLink = 'assessment/view_list/' . $row['id'];
                        } else {
                            $detailLink = 'login/assessment/' . $row['id'];
                        }
                    }
                    $detail_text = 'Details';
                    $details = "<a href=" . site_url($detailLink) . " class='button' style='white-space: nowrap'>" . $detail_text . "</a>";
                }
                if ($isCopy) {
                    $sql = "SELECT branch_name FROM hs_hr_branch where id = " . $row['copy_partner_from'] . "";
                    $result = mysqli_query($sql);
                    $row1 = mysqli_fetch_array($result);
                    if ($this->session->userdata('accessTo') != '' || $this->session->userdata('user_type') == 'superadmin' || $this->session->userdata('user_type') == 'admin' || $this->session->userdata('role_id') == '1' || $this->session->userdata('role_id') == '2') {
                        if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '0') {

                            $copytext = 'Copy';
                            $copyLink = $row['id'];
                            $copy = "<a href='#openModal' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' class='button' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext . "</a>";
                        } else if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '1') {
                            $copytext = 'Pending Approval';
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' disabled = 'disabled' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' style='color:#000' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext . "</a>";
                        } else if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '2') {
                            $copytext1 = 'Copied to ' . $row1['branch_name'];
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' disabled = 'disabled' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' style='color:#000' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext1 . "</a>";
                        } else if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '3') {
                            $copytext = 'Copy Declined';
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' disabled = 'disabled' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' style='color:#000' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext . "</a>";
                        } else if ($row['status'] != '4' && $row['status'] != '10' && $row['status'] != '11' && $row['copy_status'] == '5') {
                            $copytext = 'Copy Innovation';
                            $copyLink = $row['id'];
                            $copy = "<a href='javascript:void(0);' disabled = 'disabled' value='" . $row['id'] . "' onclick='modal_copy(" . $row['id'] . ")' style='color:#000' data-row_id='" . $row['id'] . "' style='white-space: nowrap'>" . $copytext . "</a>";
                        }
                    }
                }

                $doc_files = $attach_click = '';
                if ($row['program'] == 0) {
                    $doc_files = '"' . $row['id'] . '",0, "' . $row['inc_doc1'] . '","' . $row['inc_doc2'] . '"';
                    $attach_click = "onclick='attachmentDownload(" . $doc_files . ");'";
                } else if ($row['program'] == 3) {
                    $doc_files = '"' . $row['id'] . '",3, "' . $row['pitch_doc1'] . '","' . $row['pitch_doc2'] . '"';
                    $attach_click = "onclick='attachmentDownload(" . $doc_files . ");'";
                } else if ($row['program'] == 4) {
                    $doc_files = '"' . $row['id'] . '",4, "' . $row['pitch_doc1'] . '","' . $row['pitch_doc2'] . '"';
                    $attach_click = "onclick='attachmentDownload(" . $doc_files . ");'";
                }

                //////download//////
                if ($isDownload) {
                    $download_text = 'Download';
                    $downloadLink = 'scouting/export_deals_pdf/' . $row['id'] . '/' . $options['currentTab'];
                    $download = "<a href='javascript:void(0)' " . $attach_click . " class='button' style='white-space: nowrap'>" . $download_text . "</a>";
                }
                ///////////////////////delete//////////////////////////
                //////////////////////////// id check box/////////////////////////////
                $select = '';
                if ($row['status'] != '3' && $row['status'] != '4' && in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio'))) {
                    $select = '<input type="checkbox" class="chk_box enablefan" name="innovation_id[]" value="' . $row['id'] . '"/>';
                }

                if (($this->session->userdata('user_type') == 'admin' && $this->session->userdata('partner_id') == $row['partner_id'])) {
                    if ($row['status'] != '11') {
                        $delete = "<a href='javascript:void(0);' program=" . str_replace(" ", "-", $program) . " url=" . site_url('scouting/delete/' . $row['id']) . " class='DeleteInnovation confirmDelete'><img src='" . base_url() . "source/template/images/icons/cross.png'/></a>";
                    } else {
                        $delete = '';
                    }
                    $data[] = array($select, $inv_id, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $identified_date, $city, $partnersList, $assign, $email, $phone, $submitted_date, $copied_date, $details, $download, $delete, $copy);
                } else if ($this->session->userdata('user_type') == 'superadmin') {
                    if ($row['status'] != '11') {
                        $delete = "<a href='javascript:void(0);' program=" . str_replace(" ", "-", $program) . " url=" . site_url('scouting/delete/' . $row['id']) . " class='DeleteInnovation confirmDelete'><img src='" . base_url() . "source/template/images/icons/cross.png'/></a>";
                    } else {
                        $delete = '';
                    }
                    $data[] = array($select, $inv_id, $branch_name, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $identified_date, $city, $partnersList, $assign, $email, $phone, $submitted_date, $copied_date, $details, $download, $delete, $copy);
                } else {
                    $data[] = array($select, $inv_id, $enterprise, $entrepreneur, $source, $sector, $program, $stage_text, $status_text, $identified_date, $city, $partnersList, $assign, $email, $phone, $submitted_date, $copied_date, $details, $download, $copy);
                }
            }
        }
        $query->free_result();
        $returnArray = array();
        $returnArray = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => array(),
        );

        $returnArray["aaData"] = $data;

        return $returnArray;
    }

    public function getLimitRecords($options = array()) {
        $whereQuery = $this->_search($options);
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        } else {
            $this->db->order_by('id', 'desc');
        }

        $this->db->select("IP.*,SM.source_name,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");
        $this->db->select("(select branch_name from  " . $this->hris->database . ".hs_hr_branch where id = IP.partner_id) as branch_name", false);
        $this->db->select("GF.fstage,GF.donor_fit,GF.LIS");
        $this->db->select('INV.submitted_date');
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('(SELECT innovation_id, id, fstage, donor_fit, LIS
            FROM grading_feedback AS ga
            INNER JOIN (
            SELECT max( id ) AS maxid
            FROM grading_feedback
            GROUP BY innovation_id
        ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');

        $this->db->distinct();
        if (isset($options['innovation_score'])) {
            $this->db->select('INS.*');
            $this->db->join('innovation_score INS', 'INS.innovation = IP.id', 'left');
        }
        $this->db->group_by('IP.id');
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        if ($query->num_rows() > 0) {
            ini_set('memory_limit', '-1');
            $this->load->model('scouting/Mincharge');
            foreach ($query->result_array() as $row) {
                $asArray = array();
                $associate = $this->Mincharge->getAssociate(array('innovation' => $row['id'], 'active' => 'Active'));

                foreach ($associate as $as):
                    $asArray[] = $as['emp_name'];
                endforeach;
                $row['associate_emp_name'] = implode(', ', $asArray);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function _search($options = array()) {
        $currentTab = 'all';

        $searchArray = array();
        $searchArray1 = array();
        $where = null;
        if (is_array($options['associate'])) {
            $searchArray[] = "IP.id IN ('" . implode("','", $options['associate']) . "')";
            $currentTab = 'assigned';
        }

        if (!empty($options['sector'])) {
            $searchArray[] = "(SC.id = '" . $options['sector'] . "')";
//            $searchArray[] = "(SC.sector like '%" . $options['sector'] . "%' OR pitch_step2.sector like '%" . $options['sector'] . "%')";
        }

        if (isset($options['source_type']) && $options['source_type'] == '0') {
            $searchArray[] = "IP.source IN (0,101,103,123) and (IP.created_by = 0 or IP.created_by IS NULL)";
        } else if (isset($options['source_type']) && $options['source_type'] == '1') {
            $searchArray[] = "IP.source NOT IN (0,101,103,123) and IP.created_by > 0 and IP.created_by IS NOT NULL";
        } else if (isset($options['source_type']) && $options['source_type'] == '2') {
            $searchArray[] = "IP.source = '124'";
        }

        if (isset($options['program']) && $options['program'] != "") {
            if ($options['program'] == 0) {
                $searchArray[] = "(IP.program = 0 or IP.program = 4)";
            } else {
                $searchArray[] = "IP.program = '" . $options['program'] . "'";
            }
        }

        $copypartner = $options['copy_id'];
        $copyid = explode("ab", $copypartner);
        if (isset($options['copy_id']) && $options['copy_id'] != "") {
            $searchArray[] = "IP.copy_id ='" . $copyid[0] . "' and (IP.partner_id ='" . ltrim($copyid[1], '0') . "' or IP.partner_id ='0" . $options['branch'] . "') and IP.partner_count ='" . $copyid[2] . "'";
        }

        $searchArray[] = "IP.copy_status != '4'";
        if ($copypartner == '') {
            if (isset($options['branch_name']) && !empty($options['branch_name'])) {
                $searchArray[] = "(IP.partner_id = '" . $options['branch_name'] . "' or IP.partner_id ='0" . $options['branch_name'] . "')";
            } else {

                if (!empty($options['branch'])) {
                    $searchArray[] = "(IP.partner_id = '" . $options['branch'] . "' or IP.partner_id ='0" . $options['branch'] . "')";
                }
            }
        }

        if (!empty($options['employee'])) {
            $searchArray[] = "IP.created_by = '" . $options['employee'] . "'";
        }

        if (!empty($options['assign_employee'])) {
            $searchArray[] = "AA.associate_employee = '" . $options['assign_employee'] . "'";
        }

        if (!empty($options['created_by'])) {
            $searchArray[] = "IP.created_by = '" . $options['created_by'] . "'";
        }

        if (!empty($options['created_date'])) {
            $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . " 00:00:00'";
        }

        if (!empty($options['created_date_to'])) {
            $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . " 23:59:59'";
        }

        $stage_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '!1', '!2', '!3', '!4', '!5', '!6', '!7', '!8', '!9', '!10', '!11', '!12');
        $status_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '!1', '!2', '!3', '!4', '!5', '!6', '!7', '!8', '!9', '!10', '!11', '!12', '!13', '!14', '!15', '!16', '!17', '!18', '!19', '!20');

        if (isset($options['sstage']) && $options['sstage'] != '' && isset($options['sstatus']) && $options['sstatus'] != '') {

            if (in_array($options['sstage'], $stage_array) && in_array($options['sstatus'], $status_array)) {
                if (strpos($options['sstatus'], '!') !== false && strpos($options['sstage'], '!') !== false) {
                    $searchArray[] = "IP.status != '" . str_replace('!', '', $options['sstatus']) . "' and IP.stage != '" . str_replace('!', '', $options['sstage']) . "'";
                } else if (strpos($options['sstatus'], '!') !== false && strpos($options['sstage'], '!') === false) {
                    $searchArray[] = "IP.status != '" . str_replace('!', '', $options['sstatus']) . "' and IP.stage = '" . $options['sstage'] . "'";
                } else if (strpos($options['sstatus'], '!') === false && strpos($options['sstage'], '!') !== false) {
                    $searchArray[] = "IP.status != '" . $options['sstatus'] . "' and IP.stage != '" . str_replace('!', '', $options['sstage']) . "'";
                } else if (strpos($options['sstatus'], '!') === false && strpos($options['sstage'], '!') === false) {
                    $searchArray[] = "IP.stage='" . $options['sstage'] . "' AND IP.status='" . $options['sstatus'] . "'";
                }
            }
        }

        if (isset($options['istage']) && $options['istage'] != '' && isset($options['istatus']) && $options['istatus'] != '') {

            if (in_array($options['istage'], $stage_array) && in_array($options['istatus'], $status_array)) {

                $searchArray[] = "(IP.stage='" . $options['istage'] . "' OR IP.status='" . $options['istatus'] . "')";
            }
        }

        if (isset($options['stage']) && @$options['stage'] != '') {
            if ($options['stage'] == '!5') {
                $searchArray[] = "IP.stage != '5'";
            } else if (in_array($options['stage'], $stage_array)) {
                $searchArray[] = "IP.stage = '" . $options['stage'] . "'";
            } else {
                $searchArray[] = "GF.fstage = '" . $options['stage'] . "'";
            }
        }

        if (isset($options['status']) && @$options['status'] != '') {
            // if ($options['status'] == '!3') {
            //     $status = "IP.status != '3'";
            // } else {
            //     $status = "IP.status = '" . $options['status'] . "'";
            // }
            // $status_where = '(' . $status;
            // if (isset($options['dstatus']) && $options['dstatus'] != '' && strpos($options['dstatus'], '!') === false) {
            //     $dstatus = "IP.status = '" . $options['dstatus'] . "'";
            //     $status_where .= ' or ' . $dstatus;
            // }
            // if (isset($options['rstatus']) && $options['rstatus'] != '' && strpos($options['rstatus'], '!') === false) {
            //     $rstatus = "IP.status = '" . $options['rstatus'] . "'";
            //     $status_where .= ' or ' . $rstatus;
            // }
            // if (isset($options['delstatus']) && $options['delstatus'] != '' && strpos($options['delstatus'], '!') === false) {
            //     $delstatus = "IP.status = '" . $options['delstatus'] . "'";
            //     $status_where .= ' or ' . $delstatus;
            // }
            // $status_where .= ')';
            // echo '**'.$options['status'];
            $status_where = "IP.status IN (" . $options['status'] . ")";
            $searchArray[] = $status_where;
        }

        if (isset($options['dstatus']) && $options['dstatus'] != '') {
            if (strpos($options['dstatus'], '!') !== false) {
                $searchArray[] = "IP.status != '" . str_replace('!', '', $options['dstatus']) . "'";
            }
        }
        if (isset($options['rstatus']) && $options['rstatus'] != '') {
            if (strpos($options['rstatus'], '!') !== false) {
                $searchArray[] = "IP.status != '" . str_replace('!', '', $options['rstatus']) . "'";
            }
        }
        if (isset($options['delstatus']) && $options['delstatus'] != '') {
            if (strpos($options['delstatus'], '!') !== false) {
                $searchArray[] = "IP.status != '" . str_replace('!', '', $options['delstatus']) . "'";
            }
        }

        if (isset($options['decision_status']) && $options['decision_status'] != '') {
            $searchArray[] = "(IP.status = '" . $options['decision_status'] . "' OR IP.grading_status = '" . $options['grading_status'] . "')";
        } else {
            if (isset($options['grading_status']) && @$options['grading_status'] != '') {
                $searchArray[] = "IP.grading_status = '" . $options['grading_status'] . "'";
            }
        }

        $options['name_of_enterprise'] = $this->db->escape_str($options['name_of_enterprise']);
        $options['name_of_entrepreneur'] = $this->db->escape_str($options['name_of_entrepreneur']);
        if (!empty($options['name_of_enterprise'])) {
            $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
        }

        if (!empty($options['incubation_cycle'])) {
            $searchArray[] = "IP.incubation_cycle = '" . $options['incubation_cycle'] . "'";
        }

        if (!empty($options['summary_of_business'])) {
            $searchArray[] = "IP.summary_of_business LIKE '%" . $options['summary_of_business'] . "%'";
        }

        if (!empty($options['website'])) {
            $searchArray[] = "IP.website LIKE '%" . $options['website'] . "%'";
        }

        if (!empty($options['name_of_entrepreneur'])) {
            $searchArray[] = "IP.name_of_entrepreneur like '%" . $options['name_of_entrepreneur'] . "%'";
        }

        if (!empty($options['geography'])) {
            $searchArray[] = "IP.state like '%" . $options['geography'] . "%'";
        }

        if (!empty($options['city'])) {
            $searchArray[] = "IP.city like '%" . $options['city'] . "%'";
        }

        if (!empty($options['email'])) {
            $searchArray[] = "IP.email_id = '" . $options['email'] . "'";
        }

        if (!empty($options['mobile'])) {
            $searchArray[] = "IP.mobile_no like '%" . $options['mobile'] . "%'";
        }

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "") {
            $searchArray[] = "AA.associate_employee = '" . $options['assigned_incharge'] . "'";
            $searchArray[] = "AA.status=1";
        }

        global $assign;
        if (isset($options['lis']) && $options['lis'] != '') {
            $searchArray[] = "GF.LIS ='" . $options['lis'] . "'";
        }

        if (isset($options['donor_fit']) && $options['donor_fit'] != '') {
            $searchArray[] = "FIND_IN_SET( '" . $options['donor_fit'] . "', donor_fit )";
        }

        if ($options['copy_id'] == '' && $options['email'] == '' && $options['name_of_enterprise'] == '' && $options['name_of_entrepreneur'] == '' && $options['source_type'] == '' && $options['source'] == '' && $options['sector'] == '' && $options['status'] == '' && $options['stage'] == '' && $options['lis'] == '' && $options['donor_fit'] == '' && $options['mobile'] == '') {

        }

        if ((isset($options['firstdraft']) && dealsearch == 'draft') && $options['dealsearch'] != 1) {

            if ($currentTab == 'all') {
                $searchArray[] = "IP.is_deleted != '0' AND ((
                (INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' or INV.submitted_date = '0000-00-00')
                and (INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = '0000-00-00')
                and INV.created_date >='" . date2mysql($options['submitted_date']) . "'
                and INV.created_date <='" . date2mysql($options['submitted_date_to']) . "'
                ) or
                ((pitch.submitted_date >='" . date2mysql($options['submitted_date']) . "' OR pitch.submitted_date = '0000-00-00')
                and (pitch.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' OR pitch.submitted_date = '0000-00-00')
                and date(pitch.reg_date) >='" . date2mysql($options['submitted_date']) . "'
                and date(pitch.reg_date) <='" . date2mysql($options['submitted_date_to']) . "')
            )";
        } else {
            $searchArray[] = "IP.is_deleted != '0'";
        }
    }

    if ((isset($options['firstdraft']) && $options['firstdraft'] == 'draft') && $options['dealsearch'] == 1) {
        $searchArray[] = "IP.is_deleted != '0'";
    }
    if ((isset($options['firstw']) && $options['firstw'] == '') && $options['dealsearch'] != 1 && $options['rstatus'] != 10) {
        if ($currentTab == 'all') {
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch.submitted_date >='" . date2mysql($options['submitted_date']) . "' and  pitch.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
        } else {
            $searchArray[] = "IP.is_deleted != '0'";
        }
    }

    if ((isset($options['firstw']) && $options['firstw'] == '') && $options['dealsearch'] == 1) {
        $searchArray[] = "IP.is_deleted != '0'";
    }

    if (isset($options['first']) && $options['first'] == 1) {
        $searchArray[] = "IP.is_deleted != '0'";
    } else if (isset($options['checkbox']) && $options['checkbox'] == 0) {
        if ($currentTab == 'all') {
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' and INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = 0000-00-00) or (pitch.submitted_date >='" . date2mysql($options['submitted_date']) . "' and  pitch.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or pitch.submitted_date = 0000-00-00))";
        } else {
            $searchArray[] = "IP.is_deleted != '0'";
        }
    } else if (isset($options['first']) && $options['first'] == 0) {
        if ($currentTab == 'all') {
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch.submitted_date >='" . date2mysql($options['submitted_date']) . "' and  pitch.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
        } else {
            $searchArray[] = "IP.is_deleted != '0'";
        }
    } else if (isset($options['first']) && $options['first'] == 'draft') {
        if ($currentTab == 'all') {
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' and INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = 0000-00-00) or (pitch.submitted_date >='" . date2mysql($options['submitted_date']) . "' and  pitch.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or pitch.submitted_date = 0000-00-00))";
        } else {
            $searchArray[] = "IP.is_deleted != '0'";
        }
    } else {
        if ((isset($options['submitted_date']) && $options['submitted_date'] != '') || (isset($options['submitted_date_to']) && $options['submitted_date_to'] != '')) {
            if ($currentTab == 'all') {
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch.submitted_date >='" . date2mysql($options['submitted_date']) . "' and  pitch.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }
    }

    if (count($searchArray)) {
        $where = implode(' and ', $searchArray);
    }

    if (count($searchArray1)) {
        $where .= " AND (" . implode(' or ', $searchArray1) . ")";
    }

    return $where;
}

public function getInnovationDetails($id) {
    $data = array();
    $this->db->select("IP.*,SM.source_name,SM.source_type as source_type_id,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");
    $this->db->select("(select count(id) from innovation_document ID where ID.innovation = IP.id) as innovation_document");

    $this->db->select("(select master_name from master_settings where id=IP.reasons) as reasons_title");
    $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IP.created_by) as created_emp", false);
    $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IP.modified_by) as modified_emp", false);
    $this->db->select("(select branch_name from  " . $this->hris->database . ".hs_hr_branch where id = IP.partner_id) as branch_name", false);
    $this->db->select("DATE_FORMAT(IFNULL(IFNULL(pitch_user.submitted_date, INV.submitted_date),EIR.date_submitted), '%d-%m-%Y') AS Submitted_Date");
    $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
    $this->db->join('pitch_user', 'pitch_user.inno_id = IP.innovation_id', 'left');
    $this->db->join('eir_user EIR', 'EIR.innovation_no = IP.innovation_id', 'left');
    $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
    $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
    $this->db->where('IP.id', $id);
    $query = $this->db->get('innovation_pool IP');

    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }
    $query->free_result();
    return $data;
}

public function getInnovation($id) {
    $data = array();
    $this->db->where('id', $id);
    $query = $this->db->get('innovation_pool');
    if ($query->num_rows() > 0) {
        $this->load->model('scouting/Mincharge');
        foreach ($query->result_array() as $row) {
            $row['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
            $data[] = $row;
        }
    }
    $query->free_result();

    if (count($data) == 0) {
        show_error('Page Not Found!');
    }

    return array_pop($data);
}

public function getInnovationCombo() {
    $data = array();
    $this->db->select("name_of_enterprise as name,id");
    $query = $this->db->get('innovation_pool');
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }
    $query->free_result();
    return $data;
}

public function diligence_stage($id) {
    $this->db->set('stage', '9');
    $this->db->set('status', '12');
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function agreement_status($id, $status) {
    $this->db->set('status', $status);
    $this->db->set('stage', '11');
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function approve_scoring($id, $status) {
    $this->db->set('status', $status);
    $this->db->set('stage', '8');
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

    #updateing status of innovation

public function changeStatus($id, $status) {
    $this->db->set('status', $status);
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function changeStage($id, $stage) {
    $this->db->set('stage', $stage);
    if ($stage == '1') {
        $this->db->set('entry_date', date($this->config->item('mysqlDate')));
    } elseif ($stage == '2') {
        $this->db->set('lead_date', date($this->config->item('mysqlDate')));
    } elseif ($stage == '3') {
        $this->db->set('shortlist_date', date($this->config->item('mysqlDate')));
    }
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');

    $this->load->model('common/Minnovation_mail');
    $this->Minnovation_mail->change_stage($id, $stage);

    return true;
}

public function gradingStatus($id, $status) {
    $this->db->set('grading_status', $status);
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function updateComments($id, $form, $status = '') {
    $this->db->set('comments', $form['comments']);
    $this->db->set('reasons', $form['reasons']);
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    $this->updateAction($id, $form, $status);
    return true;
}

public function updateAction($id, $form, $status = '') {
    $this->db->set('status', $status);
    $this->db->set('comments', $form['comments']);
    $this->db->set('reasons', $form['reasons']);
    $this->db->set('added_by', $this->session->userdata('emp_number'));
    $this->db->set('added_date', date($this->config->item('mysqlDate')));
    $this->db->set('innovation', $id);
    $this->db->insert('innovation_action');
    return true;
}

public function getActionHistory($innovation) {
    $data = array();
    $this->db->select("IA.*");
    $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IA.added_by) as added_emp", false);
    $this->db->select("(select master_name from master_settings where id=IA.reasons) as reasons_title");
    $this->db->where('IA.innovation', $innovation);
    $query = $this->db->get('innovation_action IA');
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }
    return $data;
}

public function updatePreIc($id) {
    $this->db->set('pre_ic_mail', '1');
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function updateIncubationPlan($id) {
    $this->db->set('incubation_plan', '1');
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function updatePreIcStatus($status, $id) {
    $this->db->set('pre_ic_status', $status);
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function updateAgreement($status, $id) {
    $this->db->set('agreement', $status);
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function updateAcceptStatus($status, $id) {
    $this->db->set('accept_status', $status);
    $this->db->set('modified_by', $this->session->userdata('emp_number'));
    $this->db->set('modified_date', date($this->config->item('mysqlDate')));
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');
    return true;
}

public function deleteinnovation($id) {
    $this->db->set('status', '11');
    $this->db->where('id', $id);
    $this->db->update('innovation_pool');

    $employees = $this->Sector_model->getEmpId($id);
    $emp_Ids = array_map(function ($emp_Ids) {
        return $emp_Ids['associate_employee'];
    }, $employees);
    $employees_id = rtrim(implode(',', $emp_Ids), ',');

    $data['innovation'] = $this->Minnovation->getInnovation($id);

    $log_data = array(
        'innovation_id' => $data['innovation']['id'],
        'stage' => $data['innovation']['stage'],
        'status' => 11,
        'assigned_user' => $employees_id,
        'modified_by' => $this->session->userdata['emp_number'],
        'modified_date' => date('Y-m-d H:i:s'),
    );

    $table_log = "application_status_log";
    $result = $this->Minnovation->pitch_insert($table_log, $log_data);

    return $result;
}

public function get_program_type($id) {
    $this->db->select('program');
    $this->db->where('id', $id);
    $query = $this->db->get('innovation_pool');
    return $query->result_array();
}

public function checkinnovation_documentexists($id) {
    $this->db->where('innovation', $id);
    $result = $this->db->get('innovation_document');
    return $result->num_rows();
}

public function getinfo($id) {
    $data = array();
    $query = "SELECT IP.*,I.* from innovation_pool as IP JOIN incubatee as I ON(IP.id = I.innovation) where IP.id = '" . $id . "'";
    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data;
}

public function getoldinnovation($where = null, $options = array()) {
    $data = array();
    $whereArray = array();
    if ($options['offset'] == '') {
        $options['offset'] = 0;
    }
    $query = "select * from innovations11";

    if ($where != null) {
        $whereArray[] = $where;
    }

    $whereCond = implode(' and ', $whereArray);

    if ($whereCond != '') {
        $query .= " where " . $whereCond;
    }

    $query .= " LIMIT " . $options['offset'] . "," . $options['num'];
        #echo $query;die;
    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data;
}

public function getoldinnovations($where = null, $options = array()) {
    $data = array();
    $whereArray = array();
    if ($options['offset'] == '') {
        $options['offset'] = 0;
    }

    $query = "select * from innovations09";
    if ($where != null) {
        $whereArray[] = $where;
    }

    $whereCond = implode(' and ', $whereArray);

    if ($whereCond != '') {
        $query .= " where " . $whereCond;
    }

    $query .= " LIMIT " . $options['offset'] . "," . $options['num'];
    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data;
}

public function getoldinnovationss($where = null, $options = array()) {
    $data = array();
    $whereArray = array();
    if ($options['offset'] == '') {
        $options['offset'] = 0;
    }
    $query = "select * from innovations05";

    if ($where != null) {
        $whereArray[] = $where;
    }

    $whereCond = implode(' and ', $whereArray);

    if ($whereCond != '') {
        $query .= " where " . $whereCond;
    }

    $query .= " LIMIT " . $options['offset'] . "," . $options['num'];
    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data;
}

public function getoldcount($where = null) {
    $whereArray = array();
    $query = "select count(*) as total from innovations11";
    if ($where != null) {
        $whereArray[] = $where;
    }

    $whereCond = implode(' and ', $whereArray);

    if ($whereCond != '') {
        $query .= " where " . $whereCond;
    }

    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data['0']['total'];
}

public function getoldcounts($where = null) {
    $whereArray = array();
    $query = "select count(*) as total from innovations09";
    if ($where != null) {
        $whereArray[] = $where;
    }

    $whereCond = implode(' and ', $whereArray);

    if ($whereCond != '') {
        $query .= " where " . $whereCond;
    }

    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data['0']['total'];
}

public function getoldcountss($where = null) {
    $whereArray = array();
    $query = "select count(*) as total from innovations05";
    if ($where != null) {
        $whereArray[] = $where;
    }

    $whereCond = implode(' and ', $whereArray);

    if ($whereCond != '') {
        $query .= " where " . $whereCond;
    }

    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        $data[] = $row;
    }
    return $data['0']['total'];
}

public function new_innovation_import_CSV($arr = array()) {
    $emp = $this->session->userdata('emp_number');
    if (empty($emp)) {
        $emp = '0';
    }

    if (!empty($arr)) {
        $lastId = $this->getLastinsertedId();
        $lastId = $lastId + 1;
        for ($i = 1; $i < count($arr); $i++) {
            $innovation_id = "INV" . $lastId;
            $source_others = '';
            $source_id = '';
            $source_type_id = 0;
            $source_type_others = '';
            $source = str_replace('#', ',', $arr[$i][0]);
            $query_type = $this->db->query('SELECT * FROM master_settings WHERE master_type = "Source Type" AND master_name LIKE "' . $source . '"');
            if ($query_type->num_rows() > 0) {
                foreach ($query_type->result() as $row_type) {
                    $source_type_id = $row_type->id;
                }
            } else {
                $source_type_id = str_replace('#', ',', $arr[$i]['0']);
                $source_type_others = str_replace('#', ',', $arr[$i]['0']);
            }
            $query = $this->db->query('SELECT * FROM source_master WHERE source_name LIKE "' . str_replace('#', ',', $arr[$i]['1']) . '" AND source_type = "' . $source_type_id . '"');
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $source_id = $row->id;
                }
            } else if ($arr[$i]['1'] != '') {
                $source_id = '-1';
                $source_others = str_replace('#', ',', $arr[$i]['1']);
            } else {
                $source_id = '0';
            }
            $data = array(
                'innovation_id' => $innovation_id,
                'source' => $source_id,
                'source_others' => $source_others,
                'sourceType' => $source_type_id,
                'sourceType_others' => $source_type_others,
                'instance' => str_replace('#', ',', $arr[$i]['2']),
                'name_of_entrepreneur' => str_replace('#', ',', $arr[$i]['3']),
                'phone_no' => str_replace('#', ',', $arr[$i]['4']),
                'mobile_no' => str_replace('#', ',', $arr[$i]['5']),
                'email_id' => str_replace('#', ',', $arr[$i]['6']),
                'address_line1' => str_replace('#', ',', $arr[$i]['7']),
                'address_line2' => str_replace('#', ',', $arr[$i]['8']),
                'city' => str_replace('#', ',', $arr[$i]['9']),
                'district' => str_replace('#', ',', $arr[$i]['10']),
                'state' => str_replace('#', ',', $arr[$i]['11']),
                'country' => str_replace('#', ',', $arr[$i]['12']),
                'pincode' => str_replace('#', ',', $arr[$i]['13']),
                'name_of_enterprise' => str_replace('#', ',', $arr[$i]['14']),
                'website' => str_replace('#', ',', $arr[$i]['15']),
                'summary_of_business' => str_replace('#', ',', $arr[$i]['16']),
                'entreprise_years' => str_replace('#', ',', $arr[$i]['17']),
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $emp,
            );
            $this->db->insert('innovation_pool', $data);
            $this->load->model('common/Minnovation_mail');
            $lastId++;
        }
        return true;
    } else {

        return false;
    }
}

public function get_user_eir($id = '') {
    $this->db->where('innovation_no', $id);
    $query = $this->db->get('eir_user');
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
}

public function getEIR($id = '') {
    $query = $this->db->query("SELECT T . * , A . *
        FROM eir_team T
        INNER JOIN  eir_user U ON U.id = T.app_id
        INNER JOIN eir_app A ON U.id = A.app_id
        AND U.innovation_no = '" . $id . "'");
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
}

public function getTeam($id = '') {
    $this->db->select('eir_team.*');
    $this->db->join('eir_user', 'eir_user.id = eir_team.app_id', 'left');
    $this->db->where('eir_user.innovation_no', $id);
    $query = $this->db->get('eir_team');
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
}

    //////////////////////////// SEED Process/////////////////////////////////
public function insert_seed($table, $data) {
    $this->db->insert($table, $data);

    if ($table == "innovation_pool") {
        $id = $this->db->insert_id();
        $this->updateInnovationNumber($id);

        return "INV" . $id;
    } else if ($table == "seed_user") {
        $id = $this->db->insert_id();
        return $id;
    } else if ($table == "seed_step1") {
        $id = $this->db->insert_id();
        return $id;
    }
    return true;
}

public function get_seed($table, $id) {
    if ($table == "seed_step1") {
        $this->db->where('inno_id', $id);
    } else {
        $this->db->where('app_id', $id);
    }
    $result = $this->db->get($table);
    return $result->result_array();
}

public function get_step1_id($app_id) {
    $this->db->where('app_id', $app_id);
    $this->db->select('id');
    $query = $this->db->get('seed_step1');
    return $query->result_array();
}

public function seed_update($table, $where, $data) {
    if ($table == "seed_step1_member" && !is_array($where)) {
        $this->db->insert($table, $data);
    } else {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
}

public function fetch_source_data() {
    $this->db->select('st.id as source_type,s.id as source');
    $this->db->join('source_master as s', 's.source_type = st.id');
    $this->db->where('st.master_type', 'Source Type');
    $this->db->where('st.master_name', 'SEED');
    $query = $this->db->get('master_settings as st');
    return $query->result_array();
}

    /////////////////////////// SEED Process ends/////////////////////////////
    //////////////////////////// PITCH Process starts ////////////////////////////
public function get_pitch($table, $id) {

    if ($table == "pitch_user") {
        $this->db->where('inno_id', $id);
    } else {
        $this->db->where('pitch_id', $id);
    }
    $result = $this->db->get($table);
    return $result->result_array();
}

public function pitch_update($table, $data, $where = null) {
    $this->db->select('*');
    $this->db->where($where);
    $query = $this->db->get($table);
    if ($query->num_rows() > 0) {
        $this->db->where($where);
        $this->db->update($table, $data);
    } else {
        $this->db->insert($table, $data);
    }

    return 1;
}

public function pitch_insert($table, $data) {
    $this->db->insert($table, $data);
    $id = $this->db->insert_id();
    if ($table == "innovation_pool") {
        $innovationid = "INV" . $id;
        $this->updateInnovationNumber($id);
    }
    return $id;
}

public function get_sdg_align($id) {
    $this->db->where('id', $id);
    $this->db->select('name');
    $query = $this->db->get('pitch_sdg_aligns');
    return $query->result_array();
}

    //////////////////////////// PITCH Process ends //////////////////////////////

public function getDonorFit() {
    $partner_id = $this->session->userdata('partner_id');
    $this->db->where('partner_id', $partner_id);
    $this->db->where('status', '1');
    $this->db->select('*');
    $this->db->order_by('name', 'asc');
    $query = $this->db->get('donor_fit_master');
    return $query->result_array();
}

public function getDonorFitName($ids) {
    $data = array();
    $id = explode(',', $ids);
    $ids = "'" . implode("','", $id) . "'";
    $result = $this->db->query('SELECT name FROM donor_fit_master WHERE id IN(' . $ids . ')');
    foreach ($result->result_array() as $row) {
        $data[] = $row['name'];
    }
    return $data;
}

public function getCountryName($id) {
    $result = $this->db->query("SELECT country_name FROM seed_countries WHERE id=" . $id);
    foreach ($result->result_array() as $row) {
        $data[] = $row['country_name'];
    }
    return $data;
}

public function getStateName($id) {
    $result = $this->db->query("SELECT state_name FROM eir_state WHERE id=" . $id);
    foreach ($result->result_array() as $row) {
        return $row['state_name'];
    }
}

public function getCityName($id) {
    $result = $this->db->query("SELECT city_name FROM eir_city WHERE id=" . $id);
    foreach ($result->result_array() as $row) {
        return $row['city_name'];
    }
}

public function get_innovation($table, $id) {
    if ($table == "inv_user") {
        $this->db->where('inv_no', $id);
    } else if ($table == "grading_feedback") {
        $this->db->where('innovation_id', $id);
    } else {
        $this->db->where('inv_user_id', $id);
    }
    $result = $this->db->get($table);
    return $result->result_array();
}

public function getDraftInv_partner() {
    $data = array();
    $this->db->select("INV.*,IP.partner_id");
    $this->db->from("inv_user INV");
    $this->db->join("innovation_pool IP", "IP.innovation_id = INV.inv_no", 'left');
        $this->db->where('INV.status', 'Draft'); // draft status
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return $data;
        }
    }

    public function inv_status_update($in, $id) {
        $this->db->set('status', 'Deleted');
        $this->db->where('inv_no', $in);
        $this->db->where('id', $id);
        $this->db->update('inv_user');
        if ($this->db->affected_rows() > 0) {
            $this->db->set('status', '11');
            $this->db->where('innovation_id', $in);
            $this->db->update('innovation_pool');
        }
        return true;
    }

    public function findCurrentFinancialYear() {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('status', '1');
        $query = $this->ais->get('financial_year');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function umailcheck($email) {
        $finyear = $this->findCurrentFinancialYear();
        $fdate = $finyear[0]['from'];
        $ldate = $finyear[0]['to'];
        $timestamp = strtotime($fdate);
        $timestamps = strtotime($ldate);
        $from = date('2015-m-d', $timestamp);
        $to = date('2016-m-31', $timestamps);
        $query = "Select * from pitch_user where email='$email' and DATE(reg_date) between '" . $from . "' and '" . $to . "'";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            $resp = array('status' => 'true');
        } else {
            $resp = array('status' => 'false');
        }
        return $resp;
    }

    public function getKenyaState() {
        $state = $this->db->get('eir_kenya_state');
        return $state->result_array();
    }

    public function getPartnerState($id) {
        if ($id != '') {
            $this->db->where('partner_id', $id);
        }
        $this->db->order_by('state_name', 'asc');
        $state = $this->db->get('partner_state');
        return $state->result_array();
    }

    public function getPartnerCity($id) {
        $this->db->select('*');
        $this->db->where('partner_id', $id);
        $city = $this->db->get('partner_city');
        return $city->result_array(copy_status_yes);
    }

    public function changecopyStatusYes($id1, $inno_id1, $Partner) {
        $id = base64_decode($id1);
        $inno_id = base64_decode($inno_id1);
        $this->db->set('copy_status', '2');
        $this->db->where('id', $id);
        $this->db->update('innovation_pool');
        $this->db->set('copy_status', '5');
        $this->db->where('id', $inno_id);
        $this->db->update('innovation_pool');

        $sql = "SELECT branch_email,branch_name FROM hs_hr_branch where id = " . $Partner . "";
        $result = mysqli_query($sql);
        $row1 = mysqli_fetch_array($result);

        if ($Partner == 1) {
            redirect('login/copy_request' . '/' . base64_encode($row1['branch_email']));
        } else if ($Partner == 2) {
            redirect('login/copy_request' . '/' . base64_encode($row1['branch_email']));
        }
    }

    public function changecopyStatusNo($id, $inno_id, $Partner) {
        $this->db->set('copy_status', '3');
        $this->db->where('id', $id);
        $this->db->update('innovation_pool');
        $sql = "SELECT branch_email,branch_name FROM hs_hr_branch where id = " . $Partner . "";
        $result = mysqli_query($sql);
        $row1 = mysqli_fetch_array($result);

        if ($Partner == 1) {
            redirect('login/copy_request' . '/' . base64_encode($row1['branch_email']));
        } else if ($Partner == 2) {
            redirect('login/copy_request' . '/' . base64_encode($row1['branch_email']));
        }
    }

    public function innovationupdate($id) {
        $this->db->set('copy_status', '1');
        $this->db->where('id', $id);
        $this->db->update('innovation_pool');
        redirect('scouting/innovation_pool/all');
        return true;
    }

    public function getemp_id($first, $last) {
        $query = "SELECT id as emp_number FROM hr_user_profile WHERE emp_first_name LIKE '" . $first . "' AND emp_last_name LIKE '" . $last . "'";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data[0]['emp_number'];
    }

    public function getAssignIncharge($id, $val) {
        $this->db->select("associate_employee");
        $this->db->where('innovation', $id);
        $this->db->where("status", '1');
        $this->db->group_by('associate_employee');
        $query = $this->db->get('assign_associate');
        $data = $query->result_array();
        foreach ($data as $a) {
            $query = "SELECT emp_first_name, emp_last_name FROM hr_user_profile where id = '" . $a['associate_employee'] . "'";
            $q = $this->db->query($query);
            $name = $q->result_array();
            if ($val == 1) {
                $emp_name[] = $name[0]['emp_first_name'];
            } else {
                $emp_name[] = $name[0]['emp_first_name'] . ' ' . $name[0]['emp_last_name'];
            }
        }

        sort($emp_name);
        $assign_to = implode(', ', $emp_name);
        return $assign_to;
    }

    public function getShortlistComments($invid = '', $userid = '') {

        if ($invid != "") {
            $this->db->where('inv_id', $invid);
        }
        if ($userid != '') {
            $this->db->where('created_by', $userid);
        }
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('shortlist_comments');
        return $result->result_array();
    }

}
