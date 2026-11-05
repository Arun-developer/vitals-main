<?php

class Museraccess extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

        $this->hris = $this->load->database('hris', true);

    }

    //Adding MIP Module into user rights
    public function getmipmodule()
    {

        $data = array();

        $query = "select * from hrisvill_orangehrm.user_permission";

        $result = $this->db->query($query);

        foreach ($result->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    public function addmippermission($mipuserid, $mipid)
    {

        $data = array();

        $ans = $this->checkduplicate($mipuserid, $mipid);

        if ($ans == false) {

            $query = "INSERT INTO villtest_mipvillg_mipdb.user_permission_matrix (user_info_id,permission_id) VALUES ('$mipuserid','$mipid')";

            $result = $this->db->query($query);

            return $result;

        } else {

        }

    }

    public function checkduplicate($userid, $mipid)
    {

        $query = "select * from villtest_mipvillg_mipdb.user_permission_matrix where user_info_id = '" . $userid . "' and permission_id = '" . $mipid . "'";

        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {

            return true;

        } else {
            return false;
        }

    }

    //finding the mip user based on the user group id

    public function getmipusersfrmid($usergid)
    {

        $data = array();

        $query = "select mip_id from hs_hr_users where userg_id = '" . $usergid . "' and mip_id != '0'";

        $result = $this->hris->query($query);

        foreach ($result->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    // Update the password in database with New password from user input

    public function getusers()
    {

        $data = array();

        $this->hris->select('hr_user_group.userg_name,hr_user_group.userg_id');

        $query = $this->hris->get('hr_user_group');

        foreach ($query->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    // Get the User List from the users table

    public function getuserlist()
    {

        $data = array();

        $bdquery = "select HR.*,HE.emp_type from hs_hr_users as HR LEFT JOIN hs_hr_employee as HE ON(HR.emp_number = HE.emp_number)  where isnull(HR.userg_id) ORDER BY HE.emp_type";

        $query = $this->hris->query($bdquery);

        foreach ($query->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    //change the all status at a time

    public function change($usergid, $modid, $smodid)
    {

        $query = "UPDATE hs_hr_rights SET addition = 1,deletion =1 ,editing =1,viewing =1 ,approve =1 where userg_id ='" . $usergid . "' AND mod_id = '" . $modid . "' AND smod_id = '" . $smodid . "'";

        $result = $this->hris->query($query);

        foreach ($result->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    // Get the Usergroup list join with users list to show which user in which group

    public function getusergrouplist($usergroupid = null)
    {

        $data = array();

        $query = "select HU.user_name,HU.id,HU.userg_id from hs_hr_users as HU where HU.userg_id ='" . $usergroupid . "'";

        $result = $this->hris->query($query);

        foreach ($result->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    //GET THE VIEW RIGHTS TO SHOW

    public function getviewrights($id)
    {

        $data = array();
        $query = "select HR.*, M.name, M.sname,HU.userg_name from hs_hr_rights as HR RIGHT JOIN hs_hr_module as M ON HR.mod_id = M.mod_id and HR.smod_id = M.smod_id LEFT JOIN hs_hr_user_group as HU ON(HR.userg_id = HU.userg_id) Where HR.userg_id = '" . $id . "' ORDER BY HR.mod_id";
        $result = $this->hris->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    //Changing Status for ADD,VIEW,EDIT,DEL

    public function changestatus($userid, $moduleid, $smodule_id = null, $action, $value)
    {

        if ($action == 'add') {

            $action = 'addition';

        } else if ($action == 'edit') {

            $action = 'editing';

        } else if ($action == 'view') {

            $action = 'viewing';

        } else if ($action == 'del') {

            $action = 'deletion';

        } else {

            $action = 'approve';

        }

        $query = "UPDATE hs_hr_rights SET " . $action . "=" . $value . " where userg_id ='" . $userid . "' AND mod_id = '" . $moduleid . "' AND smod_id = '" . $smodule_id . "'";

        $result = $this->hris->query($query);

        return true;

    }

    //Getting the Last Inserted User Group ID

    public function getuserg_id()
    {

        $data = array();

        $this->hris->select_max('userg_id');

        $this->hris->limit(1, 0);

        $query = $this->hris->get('hr_user_group');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;

            }

        }

        return $data;

    }

    // Adding a New User Group

    public function addusergroup($options)
    {

        $data = array(  'userg_id' => $options['userg_id'],
                        'userg_name' => $options['userg_name']
                    );

        $query = $this->hris->insert('hr_user_group', $data);

        $bdquery = "select mod_id,smod_id from hs_hr_module";

        $res = $this->hris->query($bdquery);

        foreach ($res->result_array() as $row) {

            $data2 = array('userg_id' => $options['userg_id'],

                'smod_id' => $row['smod_id'],

                'mod_id' => $row['mod_id']);

            $this->hris->insert('hr_rights', $data2);

        }

        return true;

    }

    //adding a new module

    public function addmodule($options)
    {

        $data = array('mod_id' => $options['mod_id'],

            'name' => $options['name'],

            'owner' => $options['owner'],

            'owner_email' => $options['owner_email'],

            'version' => $options['version'],

            'description' => $options['description']);

        $query = $this->hris->insert('hr_module', $data);

        return true;

    }

    public function getmname($modid)
    {

        $this->hris->select('name');

        $this->hris->where('mod_id', $modid);

        return $this->hris->get('hr_module')->row_array();

    }

    public function getowner($modid)
    {

        $this->hris->select('owner');

        $this->hris->where('mod_id', $modid);

        return $this->hris->get('hr_module')->row_array();

    }

    //adding a new module

    public function addsubmodule($options)
    {

        $modulename = array_pop($this->getmname($options['mod_id']));

        $owner = array_pop($this->getowner($options['mod_id']));

        $data = array('smod_id' => $options['smod_id'],

            'mod_id' => $options['mod_id'],

            'name' => $modulename,

            'owner' => $owner,

            'sname' => $options['sname']);

        $submodule = array_pop($this->getsmod_id($options['mod_id']));

        if ($submodule != null) {

            $query = $this->hris->insert('hr_module', $data);

        } else {

            $this->hris->where('mod_id', $options['mod_id']);

            $query = $this->hris->update('hr_module', $data);

        }

        $bdquery = "select distinct(userg_id) from hs_hr_rights";

        $res = $this->hris->query($bdquery);

        foreach ($res->result_array() as $row) {

            $data2 = array('userg_id' => $row['userg_id'],

                'mod_id' => $options['mod_id'],

                'smod_id' => $options['smod_id']);

            $this->hris->insert('hr_rights', $data2);

        }

        return true;

    }

    //get the last inserted module id

    public function getmod_id()
    {

        $data = array();

        $this->hris->select_max('mod_id');

        $this->hris->limit(1, 0);

        $query = $this->hris->get('hr_module');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;

            }

        }

        return $data;

    }

    //get the last inserted module id

    public function getsmod_id($mod_id)
    {

        $data = array();

        $this->hris->select_max('smod_id');

        $this->hris->where('mod_id', $mod_id);

        return $this->hris->get('hr_module')->row_array();

    }

    //UPDATE users table to insert the group ID

    public function updateuser($groupid, $userid)
    {
        $replace = "','";

        $search = ',';

        $userid = str_replace($search, $replace, $userid);

        $query = "UPDATE hs_hr_users SET userg_id = '" . $groupid . "' where id IN ('" . $userid . "')";

        $result = $this->hris->query($query);

    }

    public function removeuser($userid)
    {

        $replace = "','";

        $search = ",";

        $userid = str_replace($search, $replace, $userid);

        $query = "UPDATE hs_hr_users SET userg_id ='' where id IN('" . $userid . "')";

        $result = $this->hris->query($query);

    }

    public function getmodule($id = null)
    {

        $data = array();

        if ($id != '') {

            $this->hris->where('id', $id);

        }

        $query = $this->hris->get('hr_module');

        $result = $this->hris->query($query);

        foreach ($result->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    public function getsubmodule()
    {

        $data = array();

        $query = "select * from hs_hr_module";

        $result = $this->hris->query($query);

        foreach ($result->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    public function getmodulename()
    {

        $data = array();

        $query = "select mod_id,name from hs_hr_module";

        $result = $this->hris->query($query);

        foreach ($result->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    //checking edit permission for innovation_pool

    public function editpermission($usergroupid, $smodule, $module)
    {

        $data = array();

        $query = "select HR.editing from hs_hr_rights as HR LEFT JOIN hs_hr_module as M ON HR.mod_id = M.mod_id and HR.smod_id = M.smod_id where HR.userg_id ='" . $usergroupid . "'  AND M.sname ='" . $smodule . "' AND M.name = '" . $module . "'";

        $result = $this->hris->query($query);

        return $result->row_array();

    }

    public function addpermisssion($usergroupid, $smodule, $module)
    {

        $data = array();

        $query = "select HR.addition from hs_hr_rights as HR LEFT JOIN hs_hr_module as M ON HR.mod_id = M.mod_id and HR.smod_id = M.smod_id where HR.userg_id ='" . $usergroupid . "'  AND M.sname ='" . $smodule . "' AND M.name = '" . $module . "'";

        $result = $this->hris->query($query);

        return $result->row_array();

    }

    public function delpermission($usergroupid, $smodule, $module)
    {

        $data = array();

        $query = "select HR.deletion from hs_hr_rights as HR LEFT JOIN hs_hr_module as M ON HR.mod_id = M.mod_id and HR.smod_id = M.smod_id where HR.userg_id ='" . $usergroupid . "'  AND M.sname ='" . $smodule . "' AND M.name = '" . $module . "'";

        $result = $this->hris->query($query);

        return $result->row_array();

    }

    public function approvepermission($usergroupid, $smodule, $module)
    {

        $data = array();

        $query = "select HR.approve from hs_hr_rights as HR LEFT JOIN hs_hr_module as M ON HR.mod_id = M.mod_id and HR.smod_id = M.smod_id where HR.userg_id ='" . $usergroupid . "'  AND M.sname ='" . $smodule . "' AND M.name = '" . $module . "'";

        $result = $this->hris->query($query);

        return $result->row_array();

    }

    public function viewpermission($usergroupid, $smodule, $module)
    {

        $data = array();

        $query = "select HR.viewing from hs_hr_rights as HR LEFT JOIN hs_hr_module as M ON HR.mod_id = M.mod_id and HR.smod_id = M.smod_id where HR.userg_id ='" . $usergroupid . "'  AND M.sname ='" . $smodule . "' AND M.name = '" . $module . "'";

        $result = $this->hris->query($query);

        return $result->row_array();

    }

    public function delete($mod_id, $smod_id)
    {

        $this->hris->where('mod_id', $mod_id);

        $this->hris->where('smod_id', $smod_id);

        $this->hris->delete('hr_module');

    }

    public function getfellowusers()
    {

        $query = "select emp_number,CONCAT(emp_firstname,emp_lastname) as name from hs_hr_employee where emp_type = 'fellow' order by emp_number";

        $result = $this->hris->query($query);

        return $result->result_array();

    }

    public function getincubateeuser()
    {

        $data = array();

        $dbquery = "select I.*,IP.name_of_enterprise from incubatee as I JOIN innovation_pool as IP ON (I.innovation = IP.id)";

        $query = $this->db->query($dbquery);

        foreach ($query->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    public function getincubateelist($id)
    {

        $data = array();

        $dbquery = "select * from incubatee where innovation = '" . $id . "'";

        $query = $this->db->query($dbquery);

        foreach ($query->result_array() as $row) {

            $data[] = $row;

        }

        return $data;

    }

    public function saveincubatee($options = array())
    {

        $data = array();

        $query = "UPDATE incubatee SET status = '" . $options['status'] . "' where innovation = '" . $options['id'] . "'";

        $result = $this->db->query($query);

        return true;

    }

}
