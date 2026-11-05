<?php

class Minnovation_mail extends CI_Model {

    public function __Construct() {
        parent::__Construct();
        $this->load->model('scouting/Minnovation');
        $this->load->model('Memail');
    }

    #GET SENDER iNFO#

    public function getSender($employee = '', $partner = '') {
        $from = array();
        $employee = ($employee == '') ? $this->session->userdata('emp_number') : $employee;
        if ($employee != '0') {
            $part_email = $this->Muser->getPartneremail($partner);
            $fromUser = $this->Muser->getUsersList($employee, $partner);
            $from['name'] = $fromUser['0']['emp_name'];
            $from['email'] = $fromUser['0']['official_email'];
        } else {
            $part_email = $this->Muser->getPartneremail($partner);
            $from['name'] = $part_email['branch_name'];
            $from['email'] = $part_email['branch_email'];
        }
        return $from;
    }

    #GET RECEIVER INFO#

    public function getReceiver($partner = '') {
        $part_email = $this->Muser->getPartneremail($partner);
        $userSetup = $this->Mmaster->getUserSetup_branch($partner);
        $ceo = $this->Muser->getUsersList($userSetup['ceo']);
        $cio = $this->Muser->getUsersList($userSetup['cio']);
        $icm = $this->Muser->getUsersList($userSetup['icm']);
        $abi = $this->Muser->getUsersList($userSetup['abi']);

        $to['ceo'] = array('name' => $ceo['0']['emp_name'], 'email' => $ceo['0']['official_email']);
        $to['cio'] = array('name' => $cio['0']['emp_name'], 'email' => $cio['0']['official_email']);

        foreach ($icm as $icm_row):
            $to['icm'][] = array('name' => $icm_row['emp_name'], 'email' => $icm_row['official_email']);
        endforeach;

        foreach ($abi as $abi_row):
            $to['abi'][] = array('name' => $abi_row['emp_name'], 'email' => $abi_row['official_email']);
        endforeach;

        $to['pre_ic'] = array('name' => 'Pre Incubation Committe', 'email' => $userSetup['pre_ic']);

        $to['admin'] = array('name' => $part_email['branch_name'], 'email' => $part_email['branch_email']);

        return $to;
    }

    public function send_editrequest($id, $data) {

        $innovation = $this->Minnovation->getInnovation($id);

        $from = $this->getSender();

        $to = $this->getReceiver();
        $partner_id = $this->session->userdata('partner_id');
        $subject = $data['innovation']['subject'];

        $attachment = 'uploads/' . $data['innovation']['document'];

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#from#' => $from['name'],
            '#to#' => $to['pre_ic']['name']);

        $content['#incubation_plan_request#'] = "requesting for changing the incubation plan";

        $this->Memail->send($from['email'], $to['pre_ic']['email'], $content, $subject, $partner_id, $attachment);
    }

    #GET ASSIGNED ASSOCIATE INFO#

    public function getAssociate($id) {
        $this->load->model('scouting/Mincharge');
        $associate_member = $this->Mincharge->getAssociateId($id);
        $incharge = $this->Muser->getUsersList($associate_member);

        foreach ($incharge as $row):
            $associate[] = array('name' => $row['emp_name'], 'email' => $row['official_email']);
        endforeach;

        return $associate;
    }

    #DIRECT APPLICATION#

    public function direct_innovation($id) {
        $from = $this->getSender();
        $to = $this->getReceiver();
        $partner_id = $this->session->userdata('partner_id');
        $da['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);
        $innovation = $innovationDetails['0'];

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#innovation_details#' => $this->load->view('innovation_details_content', $da, true),
            '#to#' => $to['ceo']['name'],
            '#from#' => $innovation['name_of_entrepreneur']);

        $toEmail = array('scouting@villgro.org');
        $reply = 'scouting@villgro.org';
        #sending mail
        $this->Memail->_send($innovation['email_id'], $toEmail, $content, 'Application filled by the innovator', $partner_id);

        //response to user
        $content1 = array('#to#' => $innovation['name_of_entrepreneur']);
        $toEmail = array($innovation['email_id']);
        $this->Memail->_send('scouting@villgro.org', $toEmail, $content1, 'Direct Incubation Application Response', $partner_id, '', $reply);
    }

    public function EIR_innovation($id) {
        $to = $this->getReceiver();
        $partner_id = $this->session->userdata('partner_id');
        $data['basic_info'] = $basic_info = $this->Eirmodel->fetch_data('eir_user', $id);

        $data['team_info'] = $this->Eirmodel->fetch_data('eir_team', $id);
        $data['app_info'] = $this->Eirmodel->fetch_data('eir_app', $id);
        $this->load->view('EIR_app_detail', $data);
        $content = array(
            '#innovation_details#' => $this->load->view('EIR_app_detail', $data, true),
        );
        $toEmail = array('eir@villgro.org');

        // #sending mail
        $this->Memail->_send($basic_info[0]['email_id'], $toEmail, $content, 'EIR Application', $partner_id);
    }

    public function SEED_innovation($id) {

        $to = $this->getReceiver();
        $partner_id = $this->session->userdata('partner_id');
        $data['step1'] = $step1 = $this->Minnovation->get_seed('seed_step1', $id);

        $data['member'] = $this->Minnovation->get_seed(' seed_step1_member', $step1[0]['app_id']);

        $data['step2'] = $this->Minnovation->get_seed(' seed_step2', $step1[0]['app_id']);

        $data['step3'] = $this->Minnovation->get_seed(' seed_step3', $step1[0]['app_id']);

        $this->load->view('SEED_app_detail', $data);
        $content = array(
            '#innovation_details#' => $this->load->view('SEED_app_detail', $data, true),
        );

        $toEmail = array('seed@villgro.org');

        // #sending mail
        $this->Memail->_send($step1[0]['email'], $toEmail, $content, 'SEED Application', $partner_id);
    }

    public function Pitch_innovation($id) {
        $partner_id = $this->session->userdata('partner_id');
        $data['pitch_user'] = $this->Minnovation->get_pitch('pitch_user', $id);
        $data['pitch_member'] = $this->Minnovation->get_pitch('pitch_step1_members', $data['pitch_user'][0]['pitch_id']);
        $data['pitch_org'] = $this->Minnovation->get_pitch('pitch_step2', $data['pitch_user'][0]['pitch_id']);
        $data['pitch_doc'] = $this->Minnovation->get_pitch('award_share', $data['pitch_user'][0]['pitch_id']);

        $this->load->view('pitch_app_detail', $data);

        $content = array(
            '#innovation_details#' => $this->load->view('pitch_app_detail', $data, true),
        );

        $toEmail = array('ipitch@villgro.org');

        // #sending mail
        $this->Memail->_send($data['pitch_user'][0]['email'], $toEmail, $content, 'Pitch Application', $partner_id);
    }

    public function Inv_innovation($id, $partner_id, $email) {

        $result = $this->db->query("SELECT s2.sector FROM innovation_pool t1 left join sector_category as s2 on s2.id = t1.sector WHERE t1.innovation_id='" . $id . "'");
        foreach ($result->result_array() as $row) {
            $data['sector_name'] = $data1 = $row['sector'];
        }
        $sector = $data1;
        $data['inv_user'] = $this->Minnovation->get_innovation('inv_user', $id);
        $data['inv_team'] = $this->Minnovation->get_innovation('inv_member', $data['inv_user'][0]['id']);
        $data['inv_ent_info'] = $this->Minnovation->get_innovation('inv_ent_info', $data['inv_user'][0]['id']);
        $data['inv_impact'] = $this->Minnovation->get_innovation('inv_impact', $data['inv_user'][0]['id']);
        $data['add_info'] = $this->Minnovation->get_innovation('inv_additional_info', $data['inv_user'][0]['id']);

        $from = $this->getSender();

        $da['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);
        $innovation = $innovationDetails['0'];
        $identify = $this->getSender($innovation['created_by']);
        $identified = $identify['name'];

        $content = array(
            '#identified#' => $identified,
            '#innovation_details#' => $this->load->view('application/incubatee/inv_app_detail', $data, true),
            '#from#' => $from['name'],
        );
        if ($partner_id == 1) {
            $toEmail = $email;
        } else if ($partner_id == 2) {
            $toEmail = $email;
        } else if ($partner_id == 3) {
            $toEmail = $email;
        } else if ($partner_id == 4) {
            $toEmail = $email;
        } else if ($partner_id == 5) {
            $toEmail = $email;
        } else if ($partner_id == 6) {
            $toEmail = $email;
        } else if ($partner_id == 7) {
            $toEmail = $email;
        }
        // #sending mail
        $this->Memail->_send($data['inv_user'][0]['email'], $toEmail, $content, 'Innovation identified by associate', $partner_id, $sector);
    }

    public function mailSendIncharge($id, $partner_id, $email, $emp_names) {

        preg_match_all('!\d+!', $id, $matches);
        $invID = $matches[0][0];

        $this->db->select('S.sector');
        $this->db->from('sector_category AS S');
        $this->db->join('innovation_pool AS IP', 'S.ID = IP.sector', 'INNER');
        $this->db->where('IP.innovation_id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        $sector = $result[0]['sector'];

        $data['inv_user'] = $this->Minnovation->get_innovation('inv_user', $id);
        $data['inv_team'] = $this->Minnovation->get_innovation('inv_member', $data['inv_user'][0]['id']);
        $data['inv_ent_info'] = $this->Minnovation->get_innovation('inv_ent_info', $data['inv_user'][0]['id']);
        $data['inv_impact'] = $this->Minnovation->get_innovation('inv_impact', $data['inv_user'][0]['id']);
        $data['add_info'] = $this->Minnovation->get_innovation('inv_additional_info', $data['inv_user'][0]['id']);
        $from = $this->getSender();

        $da['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);
        $innovation = $innovationDetails['0'];
        $identify = $this->getSender($innovation['created_by']);
        $identified = $identify['name'];

        $content = array(
            '#identified#' => $identified,
            '#innovation_details#' => $this->load->view('application/incubatee/inv_app_detail', $data),
            '#from#' => $from['name'],
        );

        for ($i = 0; $i < count($email); $i++) {
            $toEmail = $email[$i];

            $da['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($invID);
            $innovation = $innovationDetails['0'];
            $partner = ltrim($innovation['partner_id'], '0');
            $from = $this->getSender('', $partner);
            $to = $this->getReceiver($partner);

            $content = array(
                '#to#' => $emp_names[$i],
                '#name_of_enterprise#' => $innovation['name_of_enterprise'],
                '#email#' => $innovation['email_id'],
                '#name_of_entrepreneur#' => $innovation['name_of_entrepreneur'],
                '#innovation_id#' => $innovation['innovation_id'],
                '#innovation_details#' => $this->load->view('application/incubatee/innovation_details_content', $da, true),
                '#from#' => $from['name']);
            $this->Memail->_send('aravindhan.p@claritaz.com', $toEmail, $content, 'New Incubation application submitted and assigned to you', $partner_id);
        }
    }

    public function pitch_mailSendIncharge($id, $partner_id, $email, $employee_name) {

        preg_match_all('!\d+!', $id, $matches);
        $invID = $matches[0][0];

        $this->db->select('S.sector');
        $this->db->from('sector_category AS S');
        $this->db->join('innovation_pool AS IP', 'S.ID = IP.sector', 'INNER');
        $this->db->where('IP.innovation_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        $sector = $result[0]['sector'];

        $data['pitch_user'] = $this->Minnovation->get_pitch('pitch_user', "INV" . $id);
        $data['pitch_member'] = $this->Minnovation->get_pitch('pitch_step1_members', $data['pitch_user'][0]['pitch_id']);
        $data['pitch_org'] = $this->Minnovation->get_pitch('pitch_step2', $data['pitch_user'][0]['pitch_id']);
        $data['pitch_doc'] = $this->Minnovation->get_pitch('award_share', $data['pitch_user'][0]['pitch_id']);
        $data['pitch_info'] = $this->Minnovation->get_pitch('pitch_step1_info', $data['pitch_user'][0]['pitch_id']);

        $from = $this->getSender();

        for ($i = 0; $i < count($email); $i++) {
            $toEmail = $email[$i];

            $da['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($invID);
            $innovation = $innovationDetails['0'];
            $partner = ltrim($innovation['partner_id'], '0');
            $from = $this->getSender('', $partner);
            $to = $this->getReceiver($partner);

            $content = array(
                '#to#' => $employee_name[$i],
                '#name_of_enterprise#' => $innovation['name_of_enterprise'],
                '#email#' => $innovation['email_id'],
                '#name_of_entrepreneur#' => $innovation['name_of_entrepreneur'],
                '#innovation_id#' => $innovation['innovation_id'],
                '#innovation_details#' => $this->load->view('innovation_details_content', $da, true),
                '#from#' => $from['name']);

            $this->Memail->_send('ashokkumar.g@claritaz.com', $toEmail, $content, 'New iPitch Application assigned to you', $partner_id);
        }
    }

    # NEW APPLICATION IDENTIFIED #

    public function new_innovation($id) {
        $from = $this->getSender();
        $to = $this->getReceiver();
        $partner_id = $this->session->userdata('partner_id');
        $da['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);
        $innovation = $innovationDetails['0'];
        $identify = $this->getSender($innovation['created_by']);
        $identified = $identify['name'];

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#identified#' => $identified,
            '#email#' => $innovation['email_id'],
            '#name_of_entrepreneur#' => $innovation['name_of_entrepreneur'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#innovation_details#' => $this->load->view('innovation_details_content', $da, true),
            '#to#' => $to['ceo']['name'],
            '#from#' => $from['name']);

        $toEmail = 'incubation@villgro.org';
        #sending mail
        $this->Memail->_send($from['email'], $toEmail, $content, 'Innovation identified by associate', $partner_id);
    }

    # ASSIGNED TO ASSOCIATE #

    public function assign($id, $employee, $partner_id, $pa_rd) {
        $da['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);
        $innovation = $innovationDetails['0'];
        $partner = ltrim($innovation['partner_id'], '0');
        $from = $this->getSender('', $partner);
        $to = $this->getReceiver($partner);
        $emp = $this->getSender($employee, $partner);
        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#email#' => $innovation['email_id'],
            '#name_of_entrepreneur#' => $innovation['name_of_entrepreneur'],
//            '#innovation_details#' => $this->load->view('innovation_details_content', $da, true),
            '#to#' => $emp['name'],
            '#from#' => $from['name'],
            '#assigned_by#' => $this->session->userdata['emp_name']);

        $toEmail = array($emp['email']);
        #sending mail
        /* if ($pa_rd != '') {
            $this->Memail->_send('ashokkumar.g@claritaz.com', $toEmail, $content, 'New Entry assigned to associate(s)', $partner_id);
        } else {
            $this->Memail->_send('ashokkumar.g@claritaz.com', $toEmail, $content, 'Entry assigned to associate(s)', $partner_id);
        } */
		if ($pa_rd != '') {
            $this->Memail->_send_phpmailer('ashokkumar.g@claritaz.com', $toEmail, $content, 'New Entry assigned to associate(s)', $partner_id);
        } else {
            $this->Memail->_send_phpmailer('ashokkumar.g@claritaz.com', $toEmail, $content, 'Entry assigned to associate(s)', $partner_id);
        } 
    }

    # ASSIGN INCUBATION CYCLE #

    public function assign_cycle($id) {
        $from = $this->getSender();
        $to = $this->getReceiver();
        $associate = $this->getAssociate($id);
        $partner_id = $this->session->userdata('partner_id');
        $this->load->model('scouting/Mcycle');
        $cycle = $this->Mcycle->getIncubationCycle($id);
        $innovation = $this->Minnovation->getInnovation($id);

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#cycle#' => $cycle['0']['cycle_name'],
            '#comments#' => $cycle['0']['comments'],
            '#to#' => $to['ceo']['name'],
            '#from#' => $from['name']);
        $toEmail = array($to['ceo']['email'], $to['cio']['email'], $to['admin']['email']);

        foreach ($associate as $assoc):
            $toEmail[] = $assoc['email'];
        endforeach;

        #sending mail
        $this->Memail->_send($from['email'], $toEmail, $content, 'Incubation Cycle Assigned', $partner_id);
    }

    # ASSESSMENT COMMENTS #

    public function assessment_comments($id) {
        $from = $this->getSender();
        $to = $this->getReceiver();
        $associate = $this->getAssociate($id);
        $partner_id = $this->session->userdata('partner_id');
        $innovation = $this->Minnovation->getInnovation($id);

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#from#' => $from['name']);

        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            foreach ($associate as $as):
                $content['#to#'] = $as['name'];
                $toEmail = $as['name'];
                $this->Memail->_send($from['email'], $as['email'], $content, 'Comments Posted', $partner_id);
            endforeach;
        } else {
            $content['#to#'] = $to['ceo']['name'];
            $toEmail = array($to['ceo']['email'], $to['cio']['email'], $to['admin']['email']);
            $this->Memail->_send($from['email'], $toEmail, $content, 'Comments Posted by Associate', $partner_id);
        }
    }

    # CHANGE STATUS #

    public function change_stage($id, $stage) {
        if ($stage == 2) {
            $this->assessment_approval($id);
        }
    }

    # APPROVAL OF ASSESSMENT #

    public function assessment_approval($id) {
        $from = $this->getSender();
        $to = $this->getReceiver();
        $associate = $this->getAssociate($id);
        $partner_id = $this->session->userdata('partner_id');
        $innovation = $this->Minnovation->getInnovation($id);

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#from#' => $from['name']);

        foreach ($associate as $as):
            $content['#to#'] = $as['name'];
            $toEmail = $as['name'];
            $this->Memail->_send($from['email'], $as['email'], $content, 'Approval of Assessment', $partner_id);
        endforeach;
    }

    #INVITE for detailed diligence #

    public function invitation_mail($id) {
        $from = $this->getSender();
        $innovation = $this->Minnovation->getInnovation($id);
        $this->load->model('screening/Minvitation');
        $invite = $this->Minvitation->getInviteInfo($id);
        $partner_id = $this->session->userdata('partner_id');

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#from#' => $from['name'],
            '#to#' => $innovation['name_of_entrepreneur'],
            '#message#' => $invite['0']['description'],
            '#link#' => site_url('screening/form/' . $invite['0']['invite_code']));

        $toEmail = $invite['0']['email'];

        $this->load->model('Memail');
        $this->Memail->_send($from['email'], $toEmail, $content, 'Invite for detailed diligence', $partner_id);
    }

    # SEND TO PRE - IC#

    public function send_pre_ic($form) {
        $from = $this->getSender();
        $partner_id = $this->session->userdata('partner_id');
        $attachment = array();
        $attachment[] = 'uploads/' . $form['document'];
        $this->load->model('Memail');
        $this->Memail->send($from['email'], $form['email'], $form['subject'], $form['body'], $partner_id, $attachment);
    }

    # SEND INNCUBATION PLAN#

    public function send_incubation_plan($id) {
        $innovation = $this->Minnovation->getInnovation($id);
        $attachment[] = 'uploads/' . str_replace(' ', '_', $innovation['name_of_enterprise']) . '-Screening_details.doc';
        $partner_id = $this->session->userdata('partner_id');
        $from = $this->getSender();
        $to = $this->getReceiver();

        $userSetup = $this->Mmaster->getUserSetup();
        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#from#' => $from['name'],
            '#to#' => $to['pre_ic']['name']);
        $this->load->model('seedfunding/Msfactivities');
        $content['#incubation_plan#'] = $this->Msfactivities->mailContent($id);
        $this->Memail->_send($from['email'], $to['pre_ic']['email'], $content, 'Pre - IC Incubation Plan', $partner_id, $attachment);
    }

    public function sendmeetingEmail($id, $options) {
        $innovation = $this->Minnovation->getInnovation($options['innovationid']);
        $partner_id = $this->session->userdata('partner_id');
        foreach ($options['files'] as $key => $value) {
            if (isset($key)) {
                $attachment[] = './uploads/' . $value;
            }
        }
        $from = $innovation['email_id'];
        $to = $options['email'];
        $attendees = array();
        foreach ($options['employee'] as $row) {
            $attendees[] = $row;
        }
        $attendlist = implode(',', $attendees);
        $content = array('#subject#' => $options['subject'],
            '#location#' => $options['location'],
            '#start_time#' => $options['start_datetime'],
            '#end_time#' => $options['end_datetime'],
            '#fromEmail#' => $from,
            '#toEmail#' => 'All',
            '#attendees#' => $attendlist,
        );
        $this->Memail->_send($from, $to, $content, 'Board Meeting', $partner_id, $attachment);
    }

    public function getemail($id, $options) {
        $data = array();
        $query = "SELECT BD.members,IP.email_id FROM board_details as BD JOIN innovation_pool as IP ON(BD.innovation = IP.id) JOIN boardmeeting_attendees  as BA ON(BA.employee = BD.members) where BA.id = $id GROUP BY BA.employee";
        $result = $this->db->query($query);
        debug_last_query();
        return $result->result_array();
    }

}
