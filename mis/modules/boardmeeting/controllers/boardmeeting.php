<?php
class Boardmeeting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mmeeting');
        $this->load->model('activities/Mactivities');
        $this->load->model('login/Muser');
        $this->load->model('common/Minnovation_mail');
        $this->load->model('scouting/Minnovation');
        $this->load->helper('common_helper');
    }

    public function view_list($innovationid)
    {
        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();
        $data['innovationid'] = $innovationid;
        /**** For adding left box ****/
        $data['innovation'] = $inno = $this->Minnovation->getInnovation($innovationid);
        /**** End ***/
        if ($inno['partner_id'] != '1' || $inno['partner_id'] != '01') {
            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login');
        }
        $data['activityDetails'] = $activityDetails = $this->Mmeeting->getMeetingDetails($innovationid);
        $data['left_box'] = array('incubation', 'innovation_tab');
        $data['cpagetitle'] = "Board Meeting";
        $data['cpage'] = "viewmeetingRequest";
        $data['isincubAuth'] = false;
        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['isincubAuth'] = true;
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');
        }
        $this->load->view('../template', $data);
    }

    public function meetingRequest($id)
    {
        $data['cpagetitle'] = "Board Meeting Request";
        $data['cpage'] = "viewmeetingRequest";
        $this->load->view('../template_plain', $data);
    }

    public function view($innovationid, $meetingid = null, $option = '')
    {
        $data['meetingid'] = $meetingid;
        $data['emp_number'] = $this->session->userdata('emp_number');
        $data['completestatus'] = array('open', 'closed');
        $data['option'] = $option;
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;
            $i = 0;
            foreach ($_FILES as $row) {
                $options['files'][$i] = $row['name'];
                $i++;

            }
            $options['innovationid'] = $_POST['innovationid'];

            /**** This is for file 1 ***/
            if (isset($_FILES['filedoc']['name']) != '') {
                $file = $_FILES['filedoc']['name'];
                {
                    $fileval = $_FILES['filedoc'];
                    $options['file'] = $file;
                    $options['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/boardmeeting/';
                    $this->doupload($options, $fileval);
                }
            } else {
                $file = "";
                $options['file'] = $file;
            }

            /**** End ****/
            /***** This is for File 2 ****/
            if (isset($_FILES['filedoc2']['name']) != '') {
                $file2 = $_FILES['filedoc2']['name'];
                {
                    $fileval = $_FILES['filedoc2'];
                    $options['file2'] = $file2;
                    $options['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/boardmeeting/';
                    $this->doupload($options, $fileval);
                }
            } else {
                $file2 = "";
                $options['file2'] = $file2;
            }
            $this->do_uploads($_FILES);

            /***** End ****/
            if ($_POST['option'] == 'edit') {
                if ($this->input->post('meeting_id') == '') {
                    $this->Mmeeting->insertMeeting($options);
                } else {
                    $this->Mmeeting->updateMeeting($options);
                }
            } else {
                $id = $_POST['meeting_id'];
                $this->Mmeeting->updateResponse($id, $options);
            }
            redirect('boardmeeting/view_list/' . $innovationid);
        }
        $data['innovationid'] = $innovationid;

        /**** For adding left box ****/
        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);
        /**** End ***/

        #Loading View and data

        if ($this->session->userdata('user_type') == 'incubatee') {
            $data['isincubAuth'] = true;
            $data['left_box'] = array('incubation');
        } else {
            $data['isincubAuth'] = false;
            $data['left_box'] = array('incubation', 'innovation_tab');
        }

        $data['meetingDetails'] = $this->Mmeeting->getMeetingDetailstotal($innovationid, $meetingid);
        if (php72_count($data['meetingDetails'])) {
            $meeting_id = $data['meetingDetails']['0']['id'];
        } else {
            $meeting_id = '';
        }

        $data['actionList'] = $this->Mmeeting->getActionList($meeting_id);
        $data['agendaList'] = $this->Mmeeting->getAgendaList($meeting_id);
        $data['attendeesList'] = $attendeesList = $this->Mmeeting->getAttendeesList($meeting_id);
        if (is_array($attendeesList)) {
            foreach ($attendeesList as $key => $value) {
                if ($value['attendence'] == 'Organizer') {
                    $item = $value['employee'];
                } else {
                    $item = "";
                }
            }
        }

        if (!empty($item)) {

            $data['empnumber'] = $item;
        } else {
            $data['empnumber'] = "";
        }

        $data['boardList'] = $this->Mmeeting->getBoardList($innovationid);
        $data['usersList'] = $this->Mmeeting->getUsersList($innovationid);
        $count = php72_count($data['boardList']);
        for ($i = 0; $i < php72_count($data['usersList']); $i++) {

            $data['boardList'][$count]['members'] = $data['usersList'][$i]['emp_firstname'];
            $data['boardList'][$count]['email'] = $data['usersList'][$i]['emp_work_email'];
            $count = $count + 1;
        }
        $data['userList'] = $data['boardList'];
        $data['left_box'] = array('incubation', 'innovation_tab');
        $data['custom_js'] = array();
        $isView = true;

        $data['cpagetitle'] = "Meeting";
        if ($option == 'edit') {
            $data['cpage'] = "editMeeting";
            $isView = false;
        } else {

            $data['cpage'] = "viewMeeting";
            $isView = true;
        }
        $this->load->view('../template', $data);
    }

    public function doupload($options, $fileval)
    {
        $_FILES['ty']['name'] = $fileval['name'];
        $_FILES['ty']['tmp_name'] = $fileval['tmp_name'];
        $_FILES['ty']['size'] = $fileval['size'];
        $_FILES['ty']['error'] = $fileval['error'];
        $_FILES['ty']['type'] = $fileval['type'];
        $config['upload_path'] = $options['path'];
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);
        $this->upload->do_upload('ty');

    }
    public function do_uploads($options)
    {
        $config['upload_path'] = './uploads/boardmeeting/';
        $config['allowed_types'] = '*';
        $this->load->library('upload');
        foreach ($options as $key => $value) {
            $this->upload->initialize($config);
            if (isset($key)) {
                if (!is_array($value['name'])) {
                    if (php72_count($value['name']) > 1) {
                        for ($i = 0; $i < php72_count($value['name']); $i++) {
                            $_FILES['support']['name'] = $value['name'][$i];
                            $_FILES['support']['type'] = $value['type'][$i];
                            $_FILES['support']['tmp_name'] = $value['tmp_name'][$i];
                            $_FILES['support']['size'] = $value['size'][$i];
                            $_FILES['support']['error'] = $value['error'][$i];
                        }
                        $this->upload->do_upload('support');
                    } else if (!$this->upload->do_upload($key)) {
                        $invalid = $this->upload->display_errors();
                    } else {
                        $this->upload->data();
                    }
                }
            }
        }
    }

    public function test()
    {
        $data['cpagetitle'] = "Meeting";
        $data['cpage'] = "test";
        $this->load->view('../template_iframe', $data);
    }

    /**
     * Function : _validation method is used for validation before add, edit mailtemplate.
     *
     * ---------------
     *
     * @param null
     */

    public function _validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('meeting_date', 'Meeting Date', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

}
