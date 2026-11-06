<?php

class Mmail extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Memail');
    }

    public function insert($options = array()) {
        $partner_id = $this->session->userdata('partner_id');
        $data = array('innovation' => $options['innovation'],
            'from' => $options['from'],
            'to' => $options['to'],
            'mail_type' => $options['mail_type'],
            'sent_date' => date('Y-m-d'),
            'subject' => $options['subject'],
            'body' => $options['body'],
            'send_by' => $this->session->userdata('emp_number'),
        );
        $result = $this->db->insert('innovation_mail_history', $data);

        $options['body'] = $this->imgUrl($options['body']);
        $this->Memail->send($options['from'], $options['to'], $options['subject'], $options['body'], $partner_id);
        return $result;
    }

    public function bulkmailinsert($options = array()) {
        $partner_id = $this->session->userdata('partner_id');
        $chk_mail = $this->checkMailexist();
        $count = php72_count($chk_mail);
        $mail_recips = explode(',', $options['to']);
        $mail_invs = explode(',', $options['to_inv_id']);
        $data = array(
            'sender_id' => $this->session->userdata('emp_number'),
            'receipients_count' => count($mail_recips),
            'mail_type' => $options['mail_type'],
            'mail_subject' => $options['subject'],
            'mail_body' => $options['body'],
            'created_at' => date("Y-m-d H:i:s"),
            'status' => 0,
        );
        $result = $this->db->insert('deals_mail', $data);
        $deals_mail_id = $this->db->insert_id();
        if ($result) {
            $j = 0;
            $inc = 1;
            foreach ($mail_recips as $recip_list) {

                $mail_data = array(
                    'bulk_id' => $deals_mail_id,
                    'inv_id' => $mail_invs[$j],
                    'mail_to' => $recip_list,
                    'mail_sent_date' => date("Y-m-d H:i:s"),
                    'status' => 0,
                );

                $mail_query = $this->db->insert('deals_mail_details', $mail_data);
                $j++;
                $inc++;
            }
            // $upddata = array(
            //     'receipients_count' => $inc
            // );
            // $this->db->where('id', $deals_mail_id);
            // $this->db->update('deals_mail', $upddata);
        }

        // $this->Memail->send($options['from'], $options['to'], $options['subject'], $options['body'], $partner_id);
        return $mail_query;
    }

    public function bulkhistoryinsert($options = array()) {
        $partner_id = $this->session->userdata('partner_id');
        $data = array('innovation' => $options['innovation'],
            'from' => $options['from'],
            'to' => $options['to'],
            'mail_type' => $options['mail_type'],
            'sent_date' => date('Y-m-d H:i:s'),
            'subject' => $options['subject'],
            'body' => $options['body'],
            'send_by' => $this->session->userdata('emp_number'),
        );
        $result = $this->db->insert('innovation_mail_history', $data);

        return $result;
    }

    public function bulkmailupdate($options = array()) {
        $data = array(
            'mail_sent_date' => date("Y-m-d H:i:s"),
            'status' => $options['status'],
            'mail_error_message' => $options['mail_error_message']
        );
        $this->db->where('id', $options['id']);
        $result = $this->db->update('deals_mail_details', $data);

        return $result;
    }

    public function bulkmailparent($options = array()) {
        $data = array(
            'status' => $options['status'],
        );
        $this->db->where('id', $options['id']);
        $result = $this->db->update('deals_mail', $data);

        return $result;
    }

    public function checkMailexist() {
        $data = array();
        // $this->db->where("id", $id);
        $query = $this->db->get('deals_mail');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getBulkMails($options = '', $offlimits = '') {
        $data = array();

        // $whereQuery = implode(' and ', $searchArray);
        if ($options != '') {
            $this->db->where($options);
        }
        // $this->db->limit(1);
        if (isset($offlimits['num']) && isset($offlimits['offset'])) {
            $this->db->limit($offlimits['num'], $offlimits['offset']);
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('deals_mail');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function MailDetails($options = '') {
        $data = array();

        // $whereQuery = implode(' and ', $searchArray);
        if ($options != '') {
            $this->db->where($options);
        }
        // $this->db->limit(1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('deals_mail_details');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function update($options = array()) {
        $data = array('innovation' => $options['innovation'],
            'from' => $options['from'],
            'to' => $options['to'],
            'mail_type' => $options['mail_type'],
            'sent_date' => date('Y-m-d'),
            'subject' => $options['subject'],
            'body' => $options['body'],
            'send_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $options['id']);
        $result = $this->db->update('innovation_mail_history', $data);

        $options['body'] = $this->imgUrl($options['body']);
        $this->Memail->send($options['from'], $options['to'], $options['subject'], $options['body']);
        return $result;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('innovation_mail_history');
        return true;
    }

    public function getAllCount($options = array()) {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(*) as total");

        if ($whereQuery != null) {
            $query = $this->db->get_where('innovation_mail_history', $whereQuery);
        } else {
            $query = $this->db->get('innovation_mail_history');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    public function getLimitRecords($options = array()) {
        $data = array();
        $whereQuery = $this->_search($options);

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('innovation_mail_history', $whereQuery);
        } else {
            $query = $this->db->get('innovation_mail_history');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function _search($options = array()) {
        $searchArray = array();
        $where = null;
        if (!empty($options['innovation'])) {
            $searchArray[] = "innovation = '" . $options['innovation'] . "'";
        }

        if (!empty($options['mail_type'])) {
            $searchArray[] = "mail_type like '%" . $options['mail_type'] . "%'";
        }

        if (!empty($options['sent_date'])) {
            $searchArray[] = "sent_date >= '" . $options['sent_date'] . "'";
        }

        if (!empty($options['sent_date_to'])) {
            $searchArray[] = "sent_date <= '" . $options['sent_date_to'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function _search1($options = array()) {
        $searchArray = array();
        $where = null;
        if (!empty($options['sent_date'])) {
            $temp = explode('/', $options['sent_date']);
            $date = $temp[2] . '/' . $temp[1] . '/' . $temp[0];
            $searchArray[] = "sent_on >= '" . $date . "'";
        }
        if (!empty($options['sent_date_to'])) {
            $temp2 = explode('/', $options['sent_date_to']);
            $date2 = $temp2[2] . '/' . $temp2[1] . '/' . $temp2[0];
            $searchArray[] = "sent_on <= '" . $date2 . "'";
        }
        if (!empty($options['innovation'])) {
            $searchArray[] = "innovation_id = '" . $options['innovation'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function getMailInfo($id) {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('innovation_mail_history');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getMailContent($id, $mailType, $partner_id = 1, $model = '') {
        if (php72_cmp($model) == 1)
            $this->load->model('common/Minnovation_mail');
        else
            $this->load->model('Minnovation_mail');

        $from = $this->Minnovation_mail->getSender();
        $to = $this->Minnovation_mail->getReceiver();
        $innovationDetails = $this->Minnovation->getInnovationDetails($id);
        $innovation = $innovationDetails['0'];
        if ($mailType == 'Rejection') {
            $applied_date = $innovation['Submitted_Date'];
        } else {
            $applied_date = mysql2date($innovation['created_date']);
        }

        $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
            '#name_of_entrepreneur#' => $innovation['name_of_entrepreneur'],
            '#applied_date#' => $applied_date,
            '#reasons#' => $innovation['reasons_title'],
            '#action_employee#' => $to['ceo']['name'],
            '#innovation_id#' => $innovation['innovation_id'],
            '#to#' => $to['ceo']['name'],
            '#from#' => $from['name']);

        $this->load->model('master/Mmailtemplate');
        $templateContent = $this->Mmailtemplate->getMailTemplate($mailType, $partner_id);
        $template = $this->Memail->parseContent($content, $templateContent);

        if ($innovation['program'] == '0') {
            $template['from'] = "scouting@villgro.org";
        } else if ($innovation['program'] == '1') {
            $template['from'] = "eir@villgro.org";
        } else if ($innovation['program'] == '2') {
            $template['from'] = "seed@villgro.org";
        } else if ($innovation['program'] == '3') {
            $template['from'] = "ipitch@villgro.org";
        } else {
            $template['from'] = $from['email'];
        }
        if (php72_cmp($partner_id) == 2) {
            $template['from'] = 'admin@villgrokenya.or.ke';
        } else if (php72_cmp($partner_id) == 4) {
            $template['from'] = 'invent@startupoasis.in';
        } else if (php72_cmp($partner_id) == 5) {
            $template['from'] = 'invent@iimcip.org';
        } else if (php72_cmp($partner_id) == 6) {
            $template['from'] = 'invent@kiitincubator.in';
        } else if (php72_cmp($partner_id) == 7) {
            $template['from'] = 'incubator@iitk.ac.in';
        }
        return $template;
    }

    public function getBulkMailContent($mailType, $partner_id = 1) {
        // $this->load->model('Minnovation_mail');

        $this->load->model('master/Mmailtemplate');
        $templateContent = $this->Mmailtemplate->getMailTemplate($mailType, $partner_id);
        // $template = $this->Memail->parseContent($content, $templateContent);

        if (php72_cmp($partner_id) == 2) {
            $templateContent['from'] = 'admin@villgrokenya.or.ke';
        } else if (php72_cmp($partner_id) == 4) {
            $templateContent['from'] = 'invent@startupoasis.in';
        } else if (php72_cmp($partner_id) == 5) {
            $templateContent['from'] = 'invent@iimcip.org';
        } else if (php72_cmp($partner_id) == 6) {
            $templateContent['from'] = 'invent@kiitincubator.in';
        } else if (php72_cmp($partner_id) == 7) {
            $templateContent['from'] = 'incubator@iitk.ac.in';
        }
        return $templateContent;
    }

    public function imgUrl($source) {
        $imgLink = '/S*src\s*=\s*[\""\']?([^\""\']*)/i';
        preg_match_all($imgLink, $source, $matches);
        $matchVal = php72_array_filter($matches);
        $count = count($matchVal);
        if ($count != 0) {
            $imageArray = $matchVal['1'];
            foreach ($imageArray as $key => $img):
                $imgArray[] = $img;
                $imgFullPath[] = base_url() . str_replace('../', '', $img);

            endforeach;
            $source = str_replace($imgArray, $imgFullPath, $source);
        } //count the array elements

        return $source;
    }

    public function insert_ext_mail($data) {
        $this->db->insert('external_mail_history', $data);
    }

    public function getExtMailList($options) {
        $data = array();
        $whereQuery = $this->_search1($options);

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery) && $whereQuery != "innovation = '" . $options['innovation'] . "'") {
            $query = $this->db->get_where('external_mail_history', $whereQuery);
        } else {
            $query = $this->db->get('external_mail_history');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
