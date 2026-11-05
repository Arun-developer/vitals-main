<?php

class Mail extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/Mmailtemplate');
        $this->load->model('scouting/Minnovation');
        $this->load->model('Mmail');
    }

    /* MAIL HISTORY */

    public function history($id = '') {
        $innovation = $data['innovation'] = $this->Minnovation->getInnovation($id);
        $options = array();
        $options = $_POST;
        $options['innovation'] = $id;
        $options['num'] = '15';
        $options1['num'] = '15';
        $options1['innovation'] = $id;
        if (isset($_POST['txtSubmit'])) {
            $option = $_POST;
            if ($option['opt'] == 'internal') {
                $options = $_POST;
                $options['innovation'] = $id;
                $options['num'] = '15';
            } else if ($option['opt'] == 'external') {
                $options1 = $_POST;
                $options1['innovation'] = $id;
                $options1['num'] = '15';
            }
        }
        ///////////////////////////// Multiple Pagination//////////////////////////////////
        //all array
        $allArray = array("total_rows" => $this->Mmail->getAllCount($options),
            "per_page" => 15,
        );
        //new array
        $newArray = array("total_rows" => count($this->Mmail->getExtMailList($options1)),
            "per_page" => 15,
        );

        $multiConfig["paginations"] = array("all" => $allArray, "new" => $newArray);
        $multiConfig["base_url"] = site_url('common/mail/history/' . $id);
        $multiConfig["switch_uri"] = 5;
        $multiConfig["dummy_uri"] = 6;
        $multiConfig["dummy_default"] = 0;
        $multiConfig["pagination_uri"] = 7;

        $this->pagination->multiple_initalize($multiConfig);

        $pagData = $this->pagination->create_multiple_links();

        $data['allPageLink'] = $pagData['all'];
        $data['newPageLink'] = $pagData['new'];

        ///////////////////////////////////////////////////////////////////////////////////
        #Loading View and data
        $options['offset'] = ($this->uri->segment($this->pagination->getUriSegment("all"))) ? $this->uri->segment($this->pagination->getUriSegment("all")) : 0;
        $data['mailList'] = $this->Mmail->getLimitRecords($options);
        $options1['offset'] = ($this->uri->segment($this->pagination->getUriSegment("new"))) ? $this->uri->segment($this->pagination->getUriSegment("new")) : 0;
        $data['ext_maillist'] = $this->Mmail->getExtMailList($options1);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Mail History";
        $data['cpage'] = "mail/mailHistory";

        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array('list_page', 'innovation_pool');

        $this->load->view('../template', $data);
    }

    /* SEND OR RESEND MAIL */

    public function form($innovation_id = '', $id = '') {
        $innovation = $data['innovation'] = $this->Minnovation->getInnovation($innovation_id);
        $data['mailType'] = $this->Mmailtemplate->getMailtype();
        if (isset($_POST['txtSubmit'])) {
            $result = $this->Mmail->insert($_POST);
            $msg = "Mail Sent Successfully !";
            $this->session->set_flashdata('successMsg', $msg);
            redirect('common/mail/history/' . $innovation_id);
        }
        if ($id == '') {
            $data['cpagetitle'] = "Send Mail";
            $data['mailDetails'] = array();
        } else {
            $data['cpagetitle'] = "Resend Mail";
            $data['mailDetails'] = $this->Mmail->getMailInfo($id);
        }
        $data['cpage'] = "mail/sendMail";
        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();
        $this->load->view('../template', $data);
    }

    /* DELETE MAIL */

    public function delete($innovation = '', $id = '') {
        if ($innovation != '' && $id != '') {
            $result = $this->Mmail->delete($id);
            $this->session->set_flashdata('successMsg', 'Mail deleted Successfully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('common/mail/history/' . $innovation);
    }

    /* VIEW MAIL */

    public function view($innovation = '', $id = '') {
        $data['cpagetitle'] = "View Mail";
        $data['mailDetails'] = $this->Mmail->getMailInfo($id);
        $data['cpage'] = "mail/viewMail";
        $this->load->view('../template_plain', $data);
    }

    public function add_ext_mail($inno_id) {
        $data['mailType'] = $this->Mmailtemplate->getMailtype();
        $data['inno_id'] = $inno_id;
        if (isset($_POST['txtSubmit'])) {
            $filename = $_FILES['upload']['name'];
            $config['upload_path'] = './uploads/ext_mail_docs/';
            $config['allowed_types'] = '*';
            $this->load->library('upload');
            $this->upload->initialize($config);
            $this->upload->do_upload('upload');
            $data = array(
                'to' => $_POST['to'],
                'subject' => $_POST['subject'],
                'body' => $_POST['body'],
                'sent_on' => date('Y-m-d'),
                'file_name' => $filename,
                'innovation_id' => $_POST['inno_id'],
            );
            $this->Mmail->insert_ext_mail($data);

            $msg = "External Mail Saved Successfully !";
            $this->session->set_flashdata('successMsg', $msg);
            redirect('common/mail/history/' . $inno_id);
        }
        $data['cpagetitle'] = "Send Mail";
        $data['mailDetails'] = array();

        $data['cpage'] = "mail/sendextmail";
        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();
        $this->load->view('../template', $data);
    }

    public function remainder_mail() {
        $options['status'] = '!3';
        $options['grading_status'] = '1';
        $options['orderby'] = 'created_emp';
        $options['ordertype'] = 'ASC';
        $data['innovationList'] = $this->Minnovation_reports->getLimitReportRecords($options);
        $data['getcxo'] = $this->Mmail->getcxo();
    }

}
