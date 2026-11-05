<?php
class Useraccess extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck(); // Load form validation library
        $this->load->model('museraccess');
    }

    public function index()
    {

        $data = array();
        $data['userlist'] = $this->museraccess->getuserlist();
        $data['users'] = $this->museraccess->getusers();
        $data['usergrouplist'] = $this->museraccess->getusergrouplist();
        $data['cpagetitle'] = "User Access Information";
        $data['cpage'] = 'useraccess';
        $this->load->view('../dashboard_template', $data);
    }
    public function viewrights($id = null)
    {
        $data['id'] = $id;
        $data['viewrights'] = $this->museraccess->getviewrights($id);
        $data['mip'] = $this->museraccess->getmipmodule();
        $data['cpage'] = 'viewrights';
        $data['cpagetitle'] = 'User Access Control';
        $this->load->view('../dashboard_template', $data);
    }
    public function changestatus($userid, $moduleid, $smodule_id, $action, $value)
    {
        $this->museraccess->changestatus($userid, $moduleid, $smodule_id, $action, $value);
        $this->session->set_flashdata('successMsg', 'Permission Status updated');
        redirect('mainmaster/useraccess/viewrights/' . $userid);
    }
    public function changemipstatus($usergid, $mipid)
    {
        $data['getmipusers'] = array_pop($this->museraccess->getmipusersfrmid($usergid));
        $mipuserid = array_pop($data['getmipusers']);
        $data['addpermission'] = $this->museraccess->addmippermission($mipuserid, $mipid);
        $this->session->set_flashdata('successMsg', 'Permission Successfully Added');
        redirect('mainmaster/useraccess/index');
    }
    public function adduser($id = null)
    {
        $data['usergroup'] = array();
        $data['userg_id'] = $this->museraccess->getuserg_id();
        if ($id != '') {
            $data['usergroup'] = $this->museraccess->getusergroup();
        }
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $options = $_POST;
                $this->museraccess->updateusergroup($options);
                $this->session->set_flashdata('successMsg', 'User Group Successfully Updated');
                redirect('mainmaster/useraccess/index');
            } else {
                $options = $_POST;
                $this->museraccess->addusergroup($options);
                $this->session->set_flashdata('successMsg', 'User Group Successfully Added');
                redirect('mainmaster/useraccess/index');
            }

        }
        $data['cpage'] = 'adduser';
        $data['cpagetitle'] = 'Add User Group';
        $this->load->view('../dashboard_template', $data);
    }
    public function change()
    {
        if ($this->input->post('usergid')) {
            $this->museraccess->change($this->input->post('usergid'), $this->input->post('modid'), $this->input->post('smodid'));
            exit;
        }

    }
    public function viewusers($groupid)
    {
        $data['grouplist'] = $this->museraccess->getusergrouplist($groupid);
        $data['cpage'] = 'viewusers';
        $data['cpagetitle'] = 'Users In Group';
        $this->load->view('../dashboard_template', $data);
    }
    public function get()
    {
        if ($this->input->post('groupid')) {
            $data['usergrouplist'] = $this->museraccess->getusergrouplist($this->input->post('groupid'));
            echo json_encode($data['usergrouplist']);exit;
        }
    }
    public function updateuser()
    {
        if ($this->input->post('groupid')) {
            $groupid = $this->input->post('groupid');
            $userid = $this->input->post('userid');
            $result = $this->museraccess->updateuser($groupid, $userid);
            $this->session->set_flashdata('successMsg', "User Successfully added to the Group");
        }
    }
    public function removeuser($userid)
    {
        if ($this->input->post('userid')) {
            $userid = $this->input->post('userid');
        }
        $result = $this->museraccess->removeuser($userid);
        $this->session->set_flashdata('successMsg', 'User Successfully deleted from the Group');

    }
    public function addmodule($id = null)
    {
        $data['module'] = array();
        if ($id != '') {
            $data['module'] = $this->museraccess->getmodule();
        }
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $options = $_POST;
                $this->museraccess->updatemodule($options);
                $this->session->set_flashdata('successMsg', 'Module Successfully Updated');
                redirect('mainmaster/useraccess/index');
            } else {
                $options = $_POST;
                $this->museraccess->addmodule($options);
                $this->session->set_flashdata('successMsg', 'Module Successfully Added');
                redirect('mainmaster/useraccess/index');
            }

        }
        $data['mod_id'] = $this->museraccess->getmod_id();
        $data['cpage'] = 'addmodule';
        $data['cpagetitle'] = 'Add Module';
        $this->load->view('../template_plain', $data);
    }
    public function addsubmodule($id = null)
    {
        $data['submodule'] = array();
        $data['module'] = $this->museraccess->getmodulename();
        if ($id != '') {
            $data['submodule'] = $this->museraccess->getmodule($id);
        }
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $options = $_POST;
                $this->museraccess->addsubmodule($options);
                $this->session->set_flashdata('successMsg', 'Module Successfully Updated');
                redirect('mainmaster/useraccess/index');
            } else {
                $options = $_POST;
                $this->museraccess->addsubmodule($options);
                $this->session->set_flashdata('successMsg', 'Module Successfully Added');
                redirect('mainmaster/useraccess/index');
            }

        }
        if ($this->input->post('moduleid')) {
            $data['smod_id'] = $this->museraccess->getsmod_id($this->input->post('moduleid'));
            $num = substr(array_pop($data['smod_id']), 4);
            if ($num != '') {
                $cnt = strlen($num);
                $num++;
                $num1 = str_pad($num, $cnt, 0, STR_PAD_LEFT);
                $smod_id = "SMOD" . $num1;
            } else {
                $smod_id = "SMOD" . "001";
            }
            echo $smod_id;exit;
        }
        $data['cpage'] = 'addsubmodule';
        $data['cpagetitle'] = 'Add Sub Module';
        $this->load->view('../template_plain', $data);
    }
    public function delete($mod_id, $smod_id)
    {
        $this->museraccess->deletemodule($mod_id, $smod_id);
        $this->session->set_flashdata('successMsg', 'Module Successfully Deleted');
    }
    public function essusers()
    {
        $data['cpage'] = 'essusers';
        $data['cpagetitle'] = "Add Employee";
        $this->load->view('../dashboard_template', $data);

    }
    public function jobtitle()
    {
        $data['cpage'] = 'jobview';
        $data['cpagetitle'] = "Add Job";
        $this->load->view('../dashboard_template', $data);

    }
    public function joblocation()
    {
        $data['cpage'] = 'joblocation';
        $data['cpagetitle'] = "Add JobLocation";
        $this->load->view('../dashboard_template', $data);

    }
    public function addgroup()
    {
        $data['cpage'] = 'addgroup';
        $data['cpagetitle'] = "Add Employee";
        $this->load->view('../dashboard_template', $data);
    }
    public function addadmin()
    {
        $data['cpage'] = 'addadmin';
        $data['cpagetitle'] = "Add Employee";
        $this->load->view('../dashboard_template', $data);
    }
    public function employee()
    {
        $data['cpage'] = 'employee';
        $data['left_box'] = array('user_left');
        $data['cpagetitle'] = 'add employee';
        $this->load->view('../dashboard_template', $data);
    }
    public function pim()
    {
        $data['cpage'] = 'pim';
        $data['left_box'] = array('user_left');
        $data['cpagetitle'] = 'PIM';
        $this->load->view('../dashboard_template', $data);
    }
    public function fellow()
    {
        $data['fellowusers'] = $this->museraccess->getfellowusers();
        $data['cpage'] = 'fellow';
        $data['left_box'] = array('user_left');
        $data['cpagetitle'] = 'Add Fellow';
        $this->load->view('../dashboard_template', $data);

    }
    public function addfellow()
    {
        $data['cpage'] = 'addfellow';
        $data['left_box'] = array('user_left');
        $data['cpagetitle'] = 'Add Fellow Infromation';
        $this->load->view('../dashboard_template', $data);
    }
    public function addincubatee()
    {
        $data['incuabteeusers'] = $this->museraccess->getincubateeuser();
        $data['cpage'] = 'addincubatee';
        $data['cpagetitle'] = 'Add Incubatee Users';
        $data['left_box'] = array('user_left');
        $this->load->view('../dashboard_template', $data);
    }
    public function editincubatee($id)
    {
        $data['incubateelist'] = $this->museraccess->getincubateelist($id);
        $data['cpage'] = 'editincubatee';
        $data['cpagetitle'] = 'edit incubatee users';
        $data['left_box'] = array('user_left');
        $this->load->view('../dashboard_template', $data);
    }
    public function saveincubatee($id)
    {
        $this->museraccess->saveincubatee($_POST);
        $this->session->set_flashdata('successMsg', 'Module Successfully Updated');
        redirect('mainmaster/useraccess/addincubatee');
    }
    public function essuserssuperadmin()
    {
        $data['cpage'] = 'essuserssuperadmin';
        $data['cpagetitle'] = "Add Employee";
        $this->load->view('../dashboard_template', $data);

    }

}

/* End of file useaccess.php */
