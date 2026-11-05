<?php

class Mincharge extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->load->model('master/Msource');
        $this->load->model('master/Mmaster_settings');
        $this->load->model('scouting/mincharge');
    }

    public function sendInnovationStageMail($id, $stage) {
        if ($stage == '2') {
            $tem = 'Approval of Assessment';
        } else {
            $tem = '';
            return false;
        }
        $innovationInfo = $this->getInnovationDetails($id);
        $innovation = $innovationInfo['0'];
        //user details
        if (!$this->session->userdata('isAdmin')) {
            $fromUser = $this->Muser->getUsersList($this->session->userdata('emp_number'));
            $fromName = (@$fromUser['0']['emp_name'] != '') ? $fromUser['0']['emp_name'] : 'Admin';
            $fromEmail = $fromUser['0']['emp_work_email'];
        } else {
            $fromName = 'Admin';
            $fromEmail = 'mis@mis.villgroapps.org';
        }

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#from#' => $fromName);

        $associate = $this->Mincharge->getAssociate(array('innovation' => $id));

        $this->load->model('Memail');

        foreach ($associate as $as):
            $associate_emp = $this->Muser->getUsersList($as['associate_employee']);
            $content['#to#'] = $associate_emp['0']['emp_name'];
            $toEmail[] = $associate_emp['0']['emp_work_email'];
            $template = $this->Memail->parseContent($content, $tem);
            $this->Memail->send($fromEmail, $toEmail, $template['subject'], $template['body']);
        endforeach;
    }

    //getting mail content
    public function mailContent($id) {
        $innovationInfo = $this->getInnovationDetails($id);
        $innovation = $innovationInfo['0'];
        $content = array('#name_of_entrepreneur#' => $innovation['name_of_entrepreneur'],
            '#email_id#' => $innovation['email_id'],
            '#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#applied_date#' => mysql2date($innovation['created_date']),
            '#entry_date#' => mysql2date($innovation['entry_date']),
            '#lead_date#' => mysql2date($innovation['entry_date']),
            '#reasons#' => $innovation['reasons_title'],
            '#comments#' => $innovation['comments']);
        return $content;
    }

    //sending mail for new application
    public function mailInnovation($id, $section, $to = '') {
        $innovationInfo = $this->getInnovationDetails($id);
        $innovation = $innovationInfo['0'];
        $da['innovationDetails'] = $innovationInfo;

        //user details
        if (!$this->session->userdata('isAdmin')) {
            $fromUser = $this->Muser->getUsersList($this->session->userdata('emp_number'));
            $fromName = (@$fromUser['0']['emp_name'] != '') ? $fromUser['0']['emp_name'] : 'Admin';
            $fromEmail = $fromUser['0']['emp_work_email'];
        } else {
            $fromName = 'Admin';
            $fromEmail = 'admin@villgro.org';
        }

        //get cio,ceo,associate information
        $userSetup = $this->Mmaster->getUserSetup();
        $ceo = $this->Muser->getUsersList($userSetup['0']['ceo']);
        $cio = $this->Muser->getUsersList($userSetup['0']['cio']);
        $abi = $this->Muser->getUsersList($userSetup['0']['abi']);

        $toName = $ceo['0']['emp_name'];

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#from#' => $fromName);

//        $content['#innovation_details#'] = $this->load->view('innovation_details_content', $da, true);
        switch ($section) {
            case 'new':
                $content['#to#'] = $cio['0']['emp_name'];
                $toEmail[] = $ceo['0']['emp_work_email'];
                $toEmail[] = $cio['0']['emp_work_email'];
                $template = 'Innovation identified by associate';
                break;
            case 'direct':
                $content['#to#'] = $cio['0']['emp_name'];
                $toEmail[] = $ceo['0']['emp_work_email'];
                $toEmail[] = $cio['0']['emp_work_email'];
                $template = 'Application filled by the innovator';
                break;
            case 'assigned':
                $associate = $this->Muser->getUsersList($to);
                $content['#to#'] = $associate['0']['emp_name'];
                $toEmail[] = $ceo['0']['emp_work_email'];
                $toEmail[] = $associate['0']['emp_work_email'];
                $template = 'Entry assigned to associate(s)';

                break;
        }

        #sending mail
        $this->load->model('Memail');
        $template = $this->Memail->parseContent($content, $template);
        $this->Memail->send($fromEmail, $toEmail, $template['subject'], $template['body']);
    }

}
