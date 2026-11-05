<?php

class Mailtemplate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mmailtemplate');
        $this->load->model('Mmaster');
        $this->items_perpage = '15';
    }

    public function index() {
        redirect('master/mailtemplate/view_list');
    }

    public function view_list($partner_id) {
        $data['branch'] = $this->Mmaster->getBranch();
        $data['partner_id'] = $partner_id;
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);
        $options['partner_id'] = $partner_id ? $partner_id : $this->session->userdata['partner_id'];

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/mailtemplate/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mmailtemplate->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends
        #Loading View and data
        $data['templateList'] = $this->Mmailtemplate->getLimitRecord($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Mail Templates";
        $data['cpage'] = "mailtemplate/listTemplates";

        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');

        $this->load->view('../template', $data);
    }

    public function form($id = '') {
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                if ($_POST['action'] == 'add') {
                    $result = $this->Mmailtemplate->insert($_POST);
                    $msg = "Record inserted !";
                } else {
                    $result = $this->Mmailtemplate->update($_POST);
                    $msg = "Record Updated !";
                }

                $this->session->set_flashdata('successMsg', $msg);
                redirect('master/mailtemplate/view_list');
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        if ($id == '') {
            $data['cpagetitle'] = "Add Tempalte";
            $data['templateDetails'] = array();
        } else {
            $data['cpagetitle'] = "Edit Tempalte";
            $data['templateDetails'] = $this->Mmailtemplate->getTemplateInfo($id);
        }
        $data['cpage'] = "mailtemplate/addTemplate";

        $data['left_box'] = array('master');

        $this->load->view('../template', $data);
    }

    public function delete($id = '') {
        if ($id != '') {
            $result = $this->Mmailtemplate->delete($id);
            $this->session->set_flashdata('successMsg', 'Vendor deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/mailtemplate/view_list');
    }

    public function changestatus($id = '', $status = '') {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mmailtemplate->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Vendor Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/mailtemplate/view_list');
    }

    public function _validation() {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('messagesubject', 'Message Subject', 'required');
        $this->form_validation->set_rules('messagebody', 'Message Body', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

    public function view_mailtemplate() {
        $data['tinyMCE'] = 'yes';
        $where = "";
        $searchArray = array();
        $data['form_name'] = "master_search";
        $action = $this->uri->segment(4);
        switch ($action) {
            case "add":
                if (isset($_POST['txtsubmit'])) {
                    $this->load->library("form_validation");
                    //Validations
                    $this->form_validation->set_rules('messagesubject', 'Message Subject', 'required');
                    $this->form_validation->set_rules('messagebody', 'Message Body', 'required');
                    if ($this->form_validation->run() != false) {
                        $result = $this->Mmailtemplate->insertTemplate();
                        if ($result) {
                            $this->session->set_flashdata('successMsg', 'Master added!');
                            redirect('master/master_settings/' . $currentTab);
                        }
                    } else {
                        $data['errormsg'] = "Validation error found, check it again!";
                    }
                }
                $data['cpagetitle'] = "Add Template";
                $data['cpage'] = "master/addTemplate";
                break;
            case "edit":
                #Update vendors
                if (isset($_POST['txtsubmit'])) {
                    $this->load->library("form_validation");
                    //Validations
                    $this->form_validation->set_rules('messagesubject', 'Message Subject', 'required');
                    $this->form_validation->set_rules('messagebody', 'Message Body', 'required');
                    if ($this->form_validation->run() != false) {
                        $result = $this->Mmailtemplate->updateTemplate();
                        if ($result) {
                            $this->session->set_flashdata('successMsg', 'Record updated!');
                        }
                        redirect('master/mailtemplate');
                    } else {
                        $data['errorMsg'] = "Validation error found, check it again!";
                    }
                }
                if ($this->uri->segment(5) == '') {
                    $this->session->set_flashdata('infoMsg', 'Value Missing!');
                    redirect('master/mailtemplate/view_mailtemplate');
                }
                $data['templateDetails'] = $this->Mmailtemplate->getRecords('mailtemplate', 'id', $this->uri->segment(5));
                $data['cpagetitle'] = "Edit Templates";
                $data['left_box'] = array('master');
                $data['cpage'] = "master/mailtemplate/editTemplate";
                break;
            case "delete":
                if ($this->uri->segment(5) == '') {
                    redirect('master/mailtemplate', 'refresh');
                }
                $Response = $this->Mmailtemplate->delete('mailtemplate', 'id', $this->uri->segment(5));
                if ($Response) {
                    $this->session->set_flashdata('successMsg', 'Master deleted Successfully');
                    redirect('master/mailtemplate/view_mailtemplate');
                }
                break;
            case "status":
                if ($this->uri->segment(5) == '') {
                    redirect('master/mailtemplate', 'refresh');
                }
                $Response = $this->Mmailtemplate->changeState('mailtemplate', 'id', $this->uri->segment(5), $this->uri->segment(6));
                if ($Response) {
                    $this->session->set_flashdata('successMsg', 'Master Status updated');
                    redirect('master/mailtemplate/view_mailtemplate');
                }
                break;
            default:
                switch ($action) {
                    case "search":
                        if ($this->input->post('message_type') != "") {
                            $searchArray[] = "messagetype like '%" . $this->input->post('message_type') . "%'";
                        }

                        if ($this->input->post('status') != "") {
                            $searchArray[] = "mailtemplate.status = '" . $this->input->post('status') . "'";
                        }
                        break;
                }
                $where = implode(' and ', $searchArray);
                #Pagination Scripts Starts
                $total = $this->Mmailtemplate->getAllCounts($where, 'mailtemplate');
                $config['base_url'] = site_url('master/mailtemplate/search');
                $config['total_rows'] = $total;
                $config['per_page'] = 15;
                $config['num_links'] = 10;
                $config['full_tag_open'] = '<div id="pagination">';
                $config['full_tag_close'] = '</div>';
                $config['uri_segment'] = "4";
                $queryArray = array('table' => 'mailtemplate',
                    'where' => $where,
                    'num' => $config['per_page'],
                    'offset' => $this->uri->segment(4),
                    'orderby' => $this->input->post('sort_column'),
                    'ordertype' => $this->input->post('sort_order'),
                    'export' => 'no');

                $data['templateList'] = $this->Mmailtemplate->getLimitRecords($queryArray);
                $data['sort_column'] = @$this->input->post('sort_column');
                $data['sort_order'] = @$this->input->post('sort_order');
                $this->pagination->initialize($config);
                #Pagination Scripts Ends
                $data['cpagetitle'] = "Mail Templates";
                $data['left_box'] = array('master');
                $data['cpage'] = "mailtemplate/listTemplate";
                break;
        }
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function hrismail() {
        $data['templateList'] = $this->Mmailtemplate->gethrrecords();
        $config['base_url'] = site_url('master/mailtemplate/search');
        $config['total_rows'] = 10;
        $config['per_page'] = 15;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['uri_segment'] = "4";
        $this->pagination->initialize($config);
        $file = host_url() . "vill/templates/leave/mails/subordinate/approval-subject.txt";
        $f = fopen($file, "r");
        while ($line = fgets($f, 1000)) {
            $data['approval-subject'] = $line;
        }
        $file1 = host_url() . "vill/templates/leave/mails/subordinate/assign-subject.txt";
        $f1 = fopen($file1, "r");
        while ($line1 = fgets($f1, 1000)) {
            $data['assign-subject'] = $line1;
        }
        $file2 = host_url() . "vill/templates/leave/mails/subordinate/rejected-subject.txt";
        $f2 = fopen($file2, "r");
        while ($line2 = fgets($f2, 1000)) {
            $data['reject-subject'] = $line2;
        }
        $file3 = host_url() . "vill/templates/leave/mails/supervisor/applied-subject.txt";
        $f3 = fopen($file3, "r");
        while ($line3 = fgets($f3, 1000)) {
            $data['applied-subject'] = $line3;
        }
        $file4 = host_url() . "vill/templates/leave/mails/supervisor/cancelled-subject.txt";
        $f4 = fopen($file4, "r");
        while ($line4 = fgets($f4, 1000)) {
            $data['cancel-subject'] = $line4;
        }
        $file5 = host_url() . "vill/templates/leave/mails/subordinate/cancelled-subject.txt";
        $f5 = fopen($file5, "r");
        while ($line5 = fgets($f5, 1000)) {
            $data['cancelled-subject'] = $line5;
        }
        $data['mail'] = $data;
        $data['cpage'] = 'mailtemplate/hrismail';
        $data['cpagetitle'] = 'HR mail template';
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }

    public function readhrmail($foldername, $filename) {
        $file = host_url() . "vill/templates/leave/mails/" . $foldername . "/" . $filename . "-subject.txt";
        $f = fopen($file, "r");
        while ($line = fgets($f, 1000)) {
            $data['subject'] = $line;
        }
        $file2 = host_url() . "vill/templates/leave/mails/" . $foldername . "/" . $filename . ".txt";
        $file_handle = fopen($file2, "r");
        $data['body'] = '';
        while ($line2 = fgets($file_handle, 100000)) {
            $data['body'] .= $line2;
        }
        $data['mail'] = $data;
        $data['filename'] = $filename;
        $data['foldername'] = $foldername;
        $data['cpage'] = 'mailtemplate/hrismailtemplate';
        $data['cpagetitle'] = 'HR mail template';
        $this->load->view('../template', $data);
    }

    public function writehrismail() {
        $options = array();
        $options = $_POST;
        $foldername = "";
        $filename = "";
        $foldername = $_POST['foldername'];
        $filename = $_POST['filename'];
        $myFile = "../ctl_vill/templates/leave/mails/" . $foldername . "/" . $filename . "-subject.txt";
        $fh = fopen($myFile, 'w') or die("can't open file");
        $stringData = $_POST['subject'];
        fwrite($fh, $stringData);
        fclose($fh);

        $myFile1 = "../ctl_vill/templates/leave/mails/" . $foldername . "/" . $filename . ".txt";
        $fh1 = fopen($myFile1, 'w') or die("can't open file");
        $stringData1 = $_POST['body'];
        fwrite($fh1, $stringData1);
        fclose($fh1);
        $msg = "Record Updated !";
        $this->session->set_flashdata('successMsg', $msg);
        redirect('master/mailtemplate/hrismail');
    }

    public function hrform($id = '') {
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                if ($_POST['action'] == 'add') {
                    $result = $this->Mmailtemplate->insert($_POST);
                    $msg = "Record inserted !";
                } else {
                    $result = $this->Mmailtemplate->hrupdate($_POST);
                    $msg = "Record Updated !";
                    $this->session->set_flashdata('successMsg', $msg);
                    redirect('master/mailtemplate/hrismail');
                }

                $this->session->set_flashdata('successMsg', $msg);
                redirect('master/mailtemplate/view_list');
            } else {
                $data['errormsg'] = "Validation error found, check it again!";
            }
        }
        if ($id == '') {
            $data['cpagetitle'] = "Add Template";
            $data['templateDetails'] = array();
        } else {
            $data['cpagetitle'] = "Edit Template";
            $data['templateDetails'] = $this->Mmailtemplate->gethrTemplateInfo($id);
        }
        $data['cpage'] = "mailtemplate/addhrtemplate";

        $data['left_box'] = array('master');

        $this->load->view('../template', $data);
    }

}
