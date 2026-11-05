<?php

class Master extends CI_Controller {

    function __construct() { #error_reporting(-1);
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->Mauth->isAdminCheck();
        $this->load->model('login/Muser');
        $this->load->model('leave/Mleave');
        $this->load->model('user/Empuser');
        $this->load->model('master/Mmaster');
        $this->load->model('approval/Mapproval');
        $this->load->model('portfolio/Mportfolio');
        $this->load->library('upload');
    }

    function user_setup() {
        if (isset($_POST['txtSubmit'])) {
            $this->Mmaster->updateUserSetup($_POST);
            $this->session->set_flashdata('successMsg', 'User Setup Updated Successfully');
            redirect('master/user_setup');
        }
        $data['branch'] = $this->Mmaster->getBranch();
        $data['userSetup'] = $this->Mmaster->getUserSetup_branch($this->session->userdata('partner_id'));
        $data['cpagetitle'] = "User Setup";
        if ($this->session->userdata('user_type') == 'superadmin') {
            $data['cpage'] = "masters/userSetup_supadmin";
        } else {
            $data['cpage'] = "masters/userSetup";
        }
        $data['left_box'] = array('master');
        $data['settings'] = $this->Mmaster->getRecords('approval_setting', 'partner_id', $this->session->userdata('partner_id'));
        $data['userListFinance'] = $this->Mmaster->getAllUserList();
        $data['usersList'] = $this->Muser->getUsersList_sa($this->session->userdata('partner_id'));
        $this->load->vars($data);
        $this->load->view('../template');
    }

    function user_setup_sa() {
        $branch = $_POST['branch'];
        $users = $this->Muser->getUsersList_sa($branch);
        $default = $this->Mmaster->getUserSetup_branch($branch);
        echo json_encode(array('users' => $users, 'defaultt' => $default));
    }

    function user_setup_add() {
        $result = $this->Mmaster->insertUserSetup($_POST);
        if ($result)
            $this->session->set_flashdata('successMsg', 'User Setup Updated Successfully');
        redirect('master/user_setup');
    }

    public function partners_list() {
        $this->Mauth->isSuperAdminCheck();
        $option['status'] = 1;
        $data['search_field'] = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';

        $data['partner'] = $this->Empuser->getCommonDetails('hr_partner_type', $option, 'asc', 'partner_name');
        $this->load->vars($data);
        $this->load->view('masters/partner_listing');
    }

    public function DT_partner() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'partner_name',
            2 => 'partner_email',
            3 => 'currency',
            4 => 'ais_privilege',
            5 => 'status'
        );

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';

        $totalrows = $this->Mmaster->getDTPartnerCount($search_field, $search_value, $columns, $requestData);
        $query = $this->Mmaster->getDTPartnerDetails($requestData['length'], $requestData['start'], $search_field, $search_value, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();

            $nestedData[] = '<input type="checkbox" class="chk_box" id="chk_box" name="partner_id[]" value="' . $row['id'] . '"/>';
            $partner_name = strlen($row['partner_name']) > 35 ? substr($row['partner_name'], 0, 35) . ".." : $row['partner_name'];
            $nestedData[] = "<a href=" . site_url('master/edit_partner/' . $row['id']) . " title='" . $row['partner_name'] . "'>" . $partner_name . "</a>";
            $nestedData[] = strlen($row['partner_email']) > 40 ? substr($row['partner_email'], 0, 40) . ".." : $row['partner_email'];
            $currency = strlen($row['currency']) > 20 ? substr($row['currency'], 0, 20) . ".." : $row['currency'];
            $nestedData[] = isset($currency) && $currency != '' ? $currency : '-';
            $active = $row['ais_privilege'];
            if ($active == '1') {
                $status = 'Enable';
            } else {
                $status = 'Disable';
            }
            $nestedData[] = $status;
            $part_active = $row['status'];
            if ($part_active == '1') {
                $part_status = 'Active';
            } else {
                $part_status = 'Inactive';
            }
            $nestedData[] = $part_status;

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function add_partner() {
        $this->Mauth->isSuperAdminCheck();
        $option['status'] = 1;
        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');
        $this->load->vars($data);
        $this->load->view('masters/add_partner');
    }

    public function submit_partner() {
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/partner_logo';
        if ($_FILES["profile_pic"]["name"] != "") {
            $split_name = explode('.', $_FILES["profile_pic"]["name"]);
            $get_extension = array_pop($split_name);
            $get_name = implode('', $split_name);

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'png|jpg|jpeg';
            $rename_file = str_replace(' ', '_', strtolower($get_name));
            $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
            $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

            $this->upload->initialize($config);

            $_FILES['upload_pic']['name'] = $_FILES['profile_pic']['name'];
            $_FILES['upload_pic']['tmp_name'] = $_FILES['profile_pic']['tmp_name'];
            $_FILES['upload_pic']['size'] = $_FILES['profile_pic']['size'];
            $_FILES['upload_pic']['type'] = $_FILES['profile_pic']['type'];
            $_FILES['upload_pic']['error'] = $_FILES['profile_pic']['error'];

            if (!$this->upload->do_upload('upload_pic')) {
                $upload_error = $this->upload->display_errors();
                echo $upload_error . "--" . $i;
            } else {
                $upload_data = $this->upload->data();
                $data['partner_logo'] = $upload_data['file_name'];
            }
            unset($config);
        } else {
            $data['partner_logo'] = '';
        }

        $data['partner_name'] = $_POST['partner_name'];
        $data['partner_email'] = $_POST['partner_email'];
        $data['partner_country'] = $_POST['partner_country'];
        $data['partner_mobile'] = $_POST['partner_mobile'];
        $data['ais_privilege'] = $_POST['partner_ais'];
        $data['partner_address'] = $_POST['partner_address'];
        $data['currency'] = $_POST['partner_currency'];

        $data['smtp_protocol'] = $_POST['smtp_protocol'];
        $data['smtp_host'] = $_POST['smtp_host'];
        $data['smtp_port'] = $_POST['smtp_port'];
        $data['smtp_username'] = $_POST['smtp_username'];
        $data['smtp_password'] = $_POST['smtp_password'];
        $data['smtp_subject'] = $_POST['smtp_subject'];

        $data['created_by'] = $this->session->userdata('emp_number');
        $data['created_at'] = date("Y-m-d H:i:s");
        $query = $this->Mportfolio->insertPortfolioDetail('hr_partner_type', $data);

        if ($query) {
            $this->session->set_flashdata('successMsg', "Partner details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('master/partners_list');
    }

    public function edit_partner($id = '') {
        $this->Mauth->isSuperAdminCheck();
        $option['status'] = 1;
        $partner['id'] = $id;
        if ($id != '') {
            $data['partner'] = $this->Empuser->getCommonDetails('hr_partner_type', $partner);
        }

        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');
        $this->load->vars($data);
        $this->load->view('masters/edit_partner');
    }

    public function update_partner() {
        $option['id'] = $_POST['partner_id'];
        $data['partner_name'] = $_POST['partner_name'];
        $data['partner_email'] = $_POST['partner_email'];
        $data['partner_country'] = $_POST['partner_country'];
        $data['partner_mobile'] = $_POST['partner_mobile'];
        $data['ais_privilege'] = $_POST['partner_ais'];
        $data['status'] = $_POST['partner_status'];
        $data['partner_address'] = $_POST['partner_address'];
        $data['currency'] = $_POST['partner_currency'];

        $data['smtp_protocol'] = $_POST['smtp_protocol'];
        $data['smtp_host'] = $_POST['smtp_host'];
        $data['smtp_port'] = $_POST['smtp_port'];
        $data['smtp_username'] = $_POST['smtp_username'];
        $data['smtp_password'] = $_POST['smtp_password'];
        $data['smtp_subject'] = $_POST['smtp_subject'];

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/partner_logo';
        if ($_FILES["profile_pic"]["name"] != "") {
            $split_name = explode('.', $_FILES["profile_pic"]["name"]);
            $get_extension = array_pop($split_name);
            $get_name = implode('', $split_name);

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'png|jpg|jpeg';
            $rename_file = str_replace(' ', '_', strtolower($get_name));
            $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
            $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

            $this->upload->initialize($config);

            $_FILES['upload_pic']['name'] = $_FILES['profile_pic']['name'];
            $_FILES['upload_pic']['tmp_name'] = $_FILES['profile_pic']['tmp_name'];
            $_FILES['upload_pic']['size'] = $_FILES['profile_pic']['size'];
            $_FILES['upload_pic']['type'] = $_FILES['profile_pic']['type'];
            $_FILES['upload_pic']['error'] = $_FILES['profile_pic']['error'];

            if (!$this->upload->do_upload('upload_pic')) {
                $upload_error = $this->upload->display_errors();
                echo $upload_error . "--" . $i;
            } else {
                $upload_data = $this->upload->data();
                $data['partner_logo'] = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['old_profile_pic']) && $_POST['old_profile_pic'] != '') {
            $data['partner_logo'] = $_POST['old_profile_pic'];
        } else {
            $data['partner_logo'] = '';
        }

        $checkExist = $this->Mportfolio->getDetails('hr_partner_type', $option);
        if (count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_partner_type', $data, $option);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Partner details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('master/edit_partner/' . $_POST['partner_id']);
    }

    /* delete particular master detail */

    public function deleteSettings() {
        $id = $_POST['id'];
        $condition = explode(',', $id);
        $ids = implode(',', $condition);
        // $condition = "'" . implode("', '", $id) . "'";
        $trimmed_ids = ltrim($ids, ',');
        $table = $_POST['table'];
        $query = $this->Mmaster->deleteMasterDetail($table, $trimmed_ids);

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
        } else {
            echo '0';
        }
    }

    /* delete particular master detail */

    public function deleteMasterSetting() {
        $id = $_POST['id'];
        $condition = explode(',', $id);
        $ids = implode(',', $condition);
        $field = isset($_POST['field']) ? $_POST['field'] : 'master_id';
        $delval = isset($_POST['delval']) ? $_POST['delval'] : '-1';
        // $condition = "'" . implode("', '", $id) . "'";
        $trimmed_ids = ltrim($ids, ',');
        $table = $_POST['table'];

        $query = $this->Mmaster->deleteMasterSetting($table, $trimmed_ids, $field, $delval);

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
        } else {
            echo '0';
        }
    }

    /* Job type */

    public function job_type() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "job_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $data['job_type'] = $this->Mmaster->getMasterDetails('hr_job_type', $result_cond, 3);
        $this->load->vars($data);
        $this->load->view('masters/job_type');
    }

    public function DTJobType() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'job_name',
            2 => 'status'
        );

        $search_type = isset($_POST['search_type']) ? $_POST['search_type'] : '';
        if ($search_type != '') {
            if ($search_type == 1) {
                $search_column = 'job_name';
            }
        } else {
            $search_column = 'job_name';
        }

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        if ($search_field != '') {
            if ($search_type == 2) {
                if ($search_field == 'active') {
                    $search_stat = '1';
                } else if ($search_field == 'inactive') {
                    $search_stat = '2';
                } else {
                    $search_stat = '';
                }
                if ($search_stat != '') {
                    $cond_arr[] = "status = " . $search_stat;
                }
            } else {
                $cond_arr[] = $search_column . " LIKE '%" . $search_field . "%'";
            }
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $totalrows = $this->Mmaster->getDTJobTypeCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTJobTypeDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'selected';
            } else if ($row['status'] == 2) {
                $selected2 = 'selected';
            }
            $nestedData = array();

            $nestedData[] = '<input type="hidden" name="job_edit_id[]" id="job_edit_id_' . $i . '" value="' . $row['id'] . '"><input class="form-control type_check" type="checkbox" name="jobtype_check[]" id="jobtype_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['id'] . '  opacity5 none-pointer " name="job_name[]" id="job_name_' . $i . '" readonly disabled value="' . $row['job_name'] . '" placeholder="Enter name" />';
            $nestedData[] = '<select class="form-control inline_field_' . $row['id'] . ' opacity5 none-pointer" name="job_status[]" id="job_status_' . $i . '" readonly >
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive</option>
            </select>';
            $nestedData[] = '';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function addJobType() {
        for ($i = 0; $i < count($_POST['job_name']); $i++) {
            if ($_POST['job_name'][$i] != '') {
                $option['id'] = $_POST['job_edit_id'][$i];
                $data['job_name'] = $_POST['job_name'][$i];
                $data['status'] = isset($_POST['job_status'][$i]) && $_POST['job_status'][$i] != '' ? $_POST['job_status'][$i] : '1';

                $checkExist = $this->Mportfolio->getDetails('hr_job_type', $option);
                if (count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $query = $this->Mleave->updateLeaveDetail('hr_job_type', $option, $data);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mleave->insertLeaveDetail('hr_job_type', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Job type details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('master/job_type');
    }

    /* Job type */

    public function job_department() {
        $partner_id = $this->session->userdata['partner_id'];
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "partner_id = $partner_id";
            $cond_arr[] = "job_department LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = "partner_id = $partner_id";
        }
        $data['job_department'] = $this->Mmaster->getMasterDetails('hr_job_department', $result_cond, 3);
        $this->load->vars($data);
        $this->load->view('masters/job_department');
    }

    public function DTJobDept() {
        $requestData = $_POST;

        if ($this->session->userdata['user_type'] == 'superadmin') {
            $columns = array(
                0 => 'id',
                1 => 'job_department',
                2 => 'partner_name',
                3 => 'status'
            );
        } else {
            $columns = array(
                0 => 'id',
                1 => 'job_department',
                2 => 'status'
            );
        }

        $search_type = isset($_POST['search_type']) ? $_POST['search_type'] : '';
        if ($search_type != '') {
            if ($search_type == 1) {
                $search_column = 'job_department';
            } else if ($search_type == 3) {
                $search_column = 't2.partner_name';
            }
        }

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        if ($search_field != '') {
            if ($search_type == 2) {
                if ($search_field == 'active') {
                    $search_stat = '1';
                } else if ($search_field == 'inactive') {
                    $search_stat = '2';
                } else {
                    $search_stat = '';
                }
                if ($search_stat != '') {
                    $cond_arr[] = "status = " . $search_stat;
                }
            } else {
                $cond_arr[] = $search_column . " LIKE '%" . $search_field . "%'";
            }
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $totalrows = $this->Mmaster->getDTJobDeptCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTJobDeptDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'selected';
            } else if ($row['status'] == 2) {
                $selected2 = 'selected';
            }
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="dept_edit_id[]" id="dept_edit_id_' . $i . '" value="' . $row['id'] . '"><input class="form-control dept_check" type="checkbox" name="jobdept_check[]" id="jobdept_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['id'] . '  opacity5 none-pointer " name="job_department[]" id="job_department_' . $i . '" readonly disabled value="' . $row['job_department'] . '" placeholder="Enter name" />';
            if ($this->session->userdata['user_type'] == 'superadmin') {
                $nestedData[] = $row['partner_name'];
            }
            $nestedData[] = '<select class="form-control inline_field_' . $row['id'] . ' opacity5 none-pointer" name="job_status[]" id="job_status_' . $i . '" readonly >
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive</option>
            </select>';
            $nestedData[] = '<input type="hidden" class="parent_name_hid" value="' . $row['partner_name'] . '">';
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function copy_job_department() {
        $option['status'] = 1;
        $option['partner_id'] = 1;
        $job_list = $this->Empuser->getCommonDetails('hr_job_department', $option, 'asc', 'job_department');
        foreach ($job_list as $job) {
            $data['partner_id'] = $this->session->userdata['partner_id'];
            $data['job_department'] = $job['job_department'];
            $data['created_by'] = $this->session->userdata['user_id'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['status'] = 1;
            $query = $this->Mportfolio->insertPortfolioDetail('hr_job_department', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Master data copied successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('master/job_department');
    }

    public function addJobDept() {
        for ($i = 0; $i < count($_POST['job_department']); $i++) {
            if ($_POST['job_department'][$i] != '') {
                $option['id'] = $_POST['dept_edit_id'][$i];
                $data['partner_id'] = $this->session->userdata['partner_id'];
                $data['job_department'] = $_POST['job_department'][$i];
                $data['status'] = isset($_POST['job_status'][$i]) && $_POST['job_status'][$i] != '' ? $_POST['job_status'][$i] : '1';

                $checkExist = $this->Mportfolio->getDetails('hr_job_department', $option);
                if (count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $query = $this->Mleave->updateLeaveDetail('hr_job_department', $option, $data);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mleave->insertLeaveDetail('hr_job_department', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Job department details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('master/job_department');
    }

    /* Job specification */

    public function job_specification() {
        // $option['status'] = 1;
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "specification_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $data['job_spec'] = $this->Mmaster->getMasterDetails('hr_job_specification', $result_cond, 3);

        $this->load->vars($data);
        $this->load->view('masters/job_specification');
    }

    public function DTJobspec() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'specification_name',
            2 => 'specification_description',
            3 => 'specification_duties',
            4 => 'status'
        );
        $search_type = isset($_POST['search_type']) ? $_POST['search_type'] : '';
        if ($search_type != '') {
            if ($search_type == 1) {
                $search_column = 'specification_name';
            } else if ($search_type == 2) {
                $search_column = 'specification_description';
            } else if ($search_type == 3) {
                $search_column = 'specification_duties';
            } else {
                $search_column = 'specification_name';
            }
        } else {
            $search_column = 'specification_name';
        }
        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        if ($search_field != '') {
            if ($search_type == 4) {
                if ($search_field == 'active') {
                    $search_stat = '1';
                } else if ($search_field == 'inactive') {
                    $search_stat = '2';
                } else {
                    $search_stat = '';
                }
                if ($search_stat != '') {
                    $cond_arr[] = "status = " . $search_stat;
                }
            } else {
                $cond_arr[] = $search_column . " LIKE '%" . $search_field . "%'";
            }
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }


        $totalrows = $this->Mmaster->getDTJobCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTJobDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;

        foreach ($query as $row) {
            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'selected';
            } else if ($row['status'] == 2) {
                $selected2 = 'selected';
            }

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="jobspec_edit_id[]" id="jobspec_edit_id_' . $i . '" value="' . $row['id'] . '"><input class="form-control job_check" type="checkbox" name="jobspec_check[]" id="jobspec_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['id'] . '  opacity5 none-pointer " name="specification_name[]" id="specification_name_' . $i . '" readonly disabled value="' . $row['specification_name'] . '" placeholder="Enter name" />';
            $nestedData[] = '<textarea class="form-control commonAlphaNum inline_field_' . $row['id'] . ' opacity5 none-pointer " name="specification_description[]" id="specification_description_' . $i . '" readonly disabled placeholder="Enter description">' . $row['specification_description'] . '</textarea>';
            $nestedData[] = '<textarea class="form-control commonAlphaNum inline_field_' . $row['id'] . ' opacity5 none-pointer" name="specification_duties[]" id="specification_duties_' . $i . '" readonly disabled placeholder="Enter name">' . $row['specification_duties'] . '</textarea>';
            $nestedData[] = '<select class="form-control inline_field_' . $row['id'] . ' opacity5 none-pointer" name="specification_status[]" id="specification_status_' . $i . '" readonly disabled >
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive</option>
            </select>';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert job specification details to db */

    public function addJobspecification() {
        #echo'<pre>';print_r($_POST);die;
        $cnt = count($_POST['specification_name']);
        if ($cnt > 0) {
            for ($i = 0; $i < count($_POST['specification_name']); $i++) {
                $jobspecdata = array();
                if ($_POST['specification_name'][$i] != '') {
                    $option['id'] = $_POST['jobspec_edit_id'][$i];
                    $jobspecdata['specification_name'] = $_POST['specification_name'][$i];
                    $jobspecdata['specification_description'] = $_POST['specification_description'][$i];
                    $jobspecdata['specification_duties'] = $_POST['specification_duties'][$i];
                    $jobspecdata['status'] = isset($_POST['specification_status'][$i]) && $_POST['specification_status'][$i] != '' ? $_POST['specification_status'][$i] : '1';

                    // $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';

                    $checkExist = $this->Mportfolio->getDetails('hr_job_specification', $option);
                    if (count($checkExist) > 0) {
                        $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
                        $hm_query = $this->Mportfolio->updatePortfolioDetail('hr_job_specification', $jobspecdata, $option);
                    } else {
                        $jobspecdata['created_by'] = $this->session->userdata('emp_number');
                        $jobspecdata['created_at'] = date("Y-m-d H:i:s");
                        $hm_query = $this->Mportfolio->insertPortfolioDetail('hr_job_specification', $jobspecdata);
                    }
                }
            }


            if ($hm_query) {

                $this->session->set_flashdata('successMsg', "Job specification details saved successfully");
            } else {
                $this->session->set_flashdata('errormsg', 'Value Missing');
            }

            redirect('master/job_specification');
        }
    }

    /* pay grade */

    public function pay_grade() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "grade_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $data['pay_grade'] = $this->Mmaster->getMasterDetails('hr_salary_grade', $result_cond, 3);
        $this->load->vars($data);
        $this->load->view('masters/pay_grade');
    }

    public function DTPaygrade() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'grade_name',
            2 => 'status'
        );

        $search_type = isset($_POST['search_type']) ? $_POST['search_type'] : '';
        if ($search_type != '') {
            if ($search_type == 1) {
                $search_column = 'grade_name';
            }
        } else {
            $search_column = 'grade_name';
        }

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        if ($search_field != '') {
            if ($search_type == 2) {
                if ($search_field == 'active') {
                    $search_stat = '1';
                } else if ($search_field == 'inactive') {
                    $search_stat = '2';
                } else {
                    $search_stat = '';
                }
                if ($search_stat != '') {
                    $cond_arr[] = "status = " . $search_stat;
                }
            } else {
                $cond_arr[] = $search_column . " LIKE '%" . $search_field . "%'";
            }
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }


        $totalrows = $this->Mmaster->getDTGradeCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTGradeDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'selected';
            } else if ($row['status'] == 2) {
                $selected2 = 'selected';
            }
            $nestedData = array();

            $nestedData[] = '<input type="hidden" name="grade_edit_id[]" id="grade_edit_id_' . $i . '" value="' . $row['id'] . '"><input class="form-control pay_check" type="checkbox" name="paygrade_check[]" id="paygrade_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['id'] . '  opacity5 none-pointer " name="grade_name[]" id="grade_name_' . $i . '" readonly disabled value="' . $row['grade_name'] . '" placeholder="Enter name" />';
            $nestedData[] = '<select class="form-control inline_field_' . $row['id'] . ' opacity5 none-pointer" name="grade_status[]" id="grade_status_' . $i . '" readonly >
            <option value="" ' . '' . '>--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="2" ' . $selected2 . '>Inactive</option>
            </select>';
            $nestedData[] = '';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert job specification details to db */

    public function addPaygrade() {

        for ($i = 0; $i < count($_POST['grade_name']); $i++) {
            if ($_POST['grade_name'][$i] != '') {
                $option['id'] = $_POST['grade_edit_id'][$i];
                $jobspecdata['grade_name'] = $_POST['grade_name'][$i];
                $jobspecdata['status'] = isset($_POST['grade_status'][$i]) && $_POST['grade_status'][$i] != '' ? $_POST['grade_status'][$i] : '1';

                // $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';

                $checkExist = $this->Mportfolio->getDetails('hr_salary_grade', $option);
                if (count($checkExist) > 0) {
                    $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
                    $hm_query = $this->Mleave->updateLeaveDetail('hr_salary_grade', $option, $jobspecdata);
                } else {
                    $jobspecdata['created_by'] = $this->session->userdata('emp_number');
                    $jobspecdata['created_at'] = date("Y-m-d H:i:s");
                    $hm_query = $this->Mleave->insertLeaveDetail('hr_salary_grade', $jobspecdata);
                }
            }
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Pay grade details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        if (!isset($_POST['postype'])) {
            if ($edit_id != '') {
                redirect('master/pay_grade/' . $edit_id);
            } else {
                redirect('master/pay_grade');
            }
        } else {

            if ($hm_query) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    /* Donor */

    public function donor() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "master_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Donor');
        $data['master_type'] = 'Donor';
        $data['redirect'] = 'donor';
        $this->load->vars($data);
        $this->load->view('masters/donor');
    }

    public function travel_mode() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "master_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Travel Mode');
        $data['master_type'] = 'Travel Mode';
        $data['redirect'] = 'travel_mode';
        $this->load->vars($data);
        $this->load->view('masters/donor');
    }

    public function books_category() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "master_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Books Category');
        $data['master_type'] = 'Books Category';
        $data['redirect'] = 'books_category';
        $this->load->vars($data);
        $this->load->view('masters/donor');
    }

    public function general_asset() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "master_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'General Asset');
        $data['master_type'] = 'General Asset';
        $data['redirect'] = 'general_asset';
        $this->load->vars($data);
        $this->load->view('masters/donor');
    }

    public function it_asset() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "master_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'IT Asset');
        $data['master_type'] = 'IT Asset';
        $data['redirect'] = 'it_asset';
        $this->load->vars($data);
        $this->load->view('masters/donor');
    }

    public function business_card() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "master_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Business Card Category');
        $data['master_type'] = 'Business Card Category';
        $data['redirect'] = 'business_card';
        $this->load->vars($data);
        $this->load->view('masters/donor');
    }

    public function utilities_type() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';
        if ($filter_search != '') {
            $cond_arr[] = "master_name LIKE '%" . $filter_search . "%'";
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Utilities Type');
        $data['master_type'] = 'Utilities Type';
        $data['redirect'] = 'utilities_type';
        $this->load->vars($data);
        $this->load->view('masters/donor');
    }

    public function DTDonor() {
        $requestData = $_POST;

        $columns = array(
            1 => 'master_name',
            2 => 'status'
        );

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['master_type'] = $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        if ($search_field != '') {
            $cond_arr[] = "master_name LIKE '%" . $search_field . "%'";
        }

        if ($master_type != '') {
            $cond_arr[] = "master_type ='" . $master_type . "'";
        }

        $partner = $this->session->userdata('partner_id');
        if ($partner != '') {
            $cond_arr[] = "partner_id ='" . $partner . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $totalrows = $this->Mmaster->getDTMasterCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTMasterDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'selected';
            } else if ($row['status'] == 0) {
                $selected2 = 'selected';
            }
            $nestedData = array();

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['master_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['master_id'] . '  opacity5 none-pointer " name="master_name[]" id="master_name_' . $i . '" readonly value="' . $row['master_name'] . '" placeholder="Enter name" />';
            $nestedData[] = '<select class="form-control inline_field_' . $row['master_id'] . ' opacity5 none-pointer" name="master_status[]" id="master_status_' . $i . '" readonly >
            <option value="">--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="0" ' . $selected2 . '>Inactive</option>
            </select>';
            $nestedData[] = '';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert job specification details to db */

    public function addMaster() {

        $redirect = $_POST['redirect'];
        $partner_id = $this->session->userdata('partner_id');
        for ($i = 0; $i < count($_POST['master_name']); $i++) {
            if ($_POST['master_name'][$i] != '') {
                $option['master_id'] = $_POST['master_edit_id'][$i];
                $mas_data['master_name'] = $_POST['master_name'][$i];
                $mas_data['status'] = $_POST['master_status'][$i];
                $mas_data['master_type'] = $_POST['master_type'];
                $mas_data['partner_id'] = $partner_id;
                // $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';

                $checkExist = $this->Mmaster->getMasterAisDetails('master_settings', $option, '', '', '', 'master_id');
                if (count($checkExist) > 0) {
                    // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
                    $hm_query = $this->Mmaster->updateMasterDetail('master_settings', $option, $mas_data);
                } else {
                    // $jobspecdata['created_by'] = $this->session->userdata('emp_number');
                    $mas_data['added_date'] = date("Y-m-d H:i:s");
                    $hm_query = $this->Mmaster->insertMasterDetail('master_settings', $mas_data);
                }
            }
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Master settings details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        if (!isset($_POST['postype'])) {
            if ($edit_id != '') {
                redirect('master/' . $redirect . '/' . $edit_id);
            } else {
                redirect('master/' . $redirect);
            }
        } else {

            if ($hm_query) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    /* budget head */

    public function budget_head() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';

        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Donor');
        $data['budget_head'] = $this->Mmaster->getMasterList($partner, 'Budget Head');
        $data['master_type'] = 'Budget Head';
        $this->load->vars($data);
        $this->load->view('masters/budget_head');
    }

    public function DTBudget() {
        $requestData = $_POST;

        $columns = array(
            1 => 'parent_name',
            2 => 'master_name',
            3 => 't1.status'
        );

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['master_type'] = $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        $data['donor_search'] = $donor_search = (isset($_POST['donor_search'])) ? $_POST['donor_search'] : '';
        $data['pid'] = $pid = (isset($_POST['pid'])) ? $_POST['pid'] : '';
        if ($search_field != '') {
            $cond_arr[] = "t1.master_name LIKE '%" . $search_field . "%'";
        }

        if ($master_type != '') {
            $cond_arr[] = "t1.master_type ='" . $master_type . "'";
        }
        if ($donor_search != '') {
            $cond_arr[] = "t1.pid ='" . $donor_search . "'";
        }

        $partner = $this->session->userdata('partner_id');
        if ($partner != '') {
            $cond_arr[] = "t1.partner_id ='" . $partner . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        
        $donors = $this->Mmaster->getMasterList($partner, 'Donor');
        $option_list = '';


        $totalrows = $this->Mmaster->getDTBudgetCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTBudgetDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            foreach ($donors as $list) {

                if ($list['master_id'] == $row['pid']) {
                    $select_pid = 'selected';
                } else {
                    $select_pid = '';
                }
                $option_list .= '<option value="' . $list['master_id'] . '" ' . $select_pid . '>' . $list['master_name'] . '</option>';
            }

            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'selected';
            } else if ($row['status'] == 0) {
                $selected2 = 'selected';
            }
            $nestedData = array();

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['master_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<select class="form-control inline_field_' . $row['master_id'] . ' opacity5 none-pointer" name="parent_type[]" id="parent_type_' . $i . '" readonly >
            <option value="">--Select--</option>' . $option_list . '</select>';
            $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['master_id'] . '  opacity5 none-pointer " name="master_name[]" id="master_name_' . $i . '" readonly value="' . $row['master_name'] . '" placeholder="Enter name" />';
            $nestedData[] = '<select class="form-control inline_field_' . $row['master_id'] . ' opacity5 none-pointer" name="master_status[]" id="master_status_' . $i . '" readonly >
            <option value="">--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="0" ' . $selected2 . '>Inactive</option>
            </select>';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert budget head details to db */

    public function addBudget() {

        #error_reporting(-1);
        for ($i = 0; $i < count($_POST['master_name']); $i++) {
            if ($_POST['master_name'][$i] != '') {
                $option['master_id'] = $_POST['master_edit_id'][$i];
                $mas_data['master_name'] = $_POST['master_name'][$i];
                $mas_data['status'] = $_POST['master_status'][$i];
                $mas_data['master_type'] = $_POST['master_type'];
                $mas_data['pid'] = $_POST['parent_type'][$i];
                $mas_data['partner_id'] = $this->session->userdata('partner_id');


                // $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';

                $checkExist = $this->Mmaster->getMasterAisDetails('master_settings', $option, '', '', '', 'master_id');
                if (count($checkExist) > 0) {
                    // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
                    $hm_query = $this->Mmaster->updateMasterDetail('master_settings', $option, $mas_data);
                } else {
                    // $jobspecdata['created_by'] = $this->session->userdata('emp_number');
                    $mas_data['added_date'] = date("Y-m-d H:i:s");
                    $hm_query = $this->Mmaster->insertMasterDetail('master_settings', $mas_data);
                }
            }
        }


        if ($hm_query) {
            if ($_POST['parent_type'][0] != '' || $_POST['master_name'][0] != '' || $_POST['master_status'][0] != '') {
                $this->session->set_flashdata('successMsg', "Master settings details saved successfully");
            }
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        if (!isset($_POST['postype'])) {
            if ($edit_id != '') {
                redirect('master/budget_head/' . $edit_id);
            } else {
                redirect('master/budget_head');
            }
        } else {

            if ($hm_query) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    /* Line item */

    public function line_item() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';

        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Donor');
        $data['budget_head'] = $this->Mmaster->getMasterList($partner, 'Budget Head');
        $data['line_item'] = $this->Mmaster->getMasterList($partner, 'Line Item');
        $data['master_type'] = 'Line Item';
        $this->load->vars($data);
        $this->load->view('masters/line_item');
    }

    public function getBudgetlist() {
        $pid = $_POST['parent'];
        $mtype = $_POST['m_type'];
        $childlist = $this->Mmaster->getChildMasterList($pid, $mtype);
        $options = '<option value="">--Select--</option>';
        foreach ($childlist as $list) {
            $options .= '<option value="' . $list['master_id'] . '">' . $list['master_name'] . '</option>';
        }
        echo $options;
    }

    public function getGrantlist() {
        $pid = isset($_POST['parent']) ? $_POST['parent'] : '';
        $gid = isset($_POST['grantid']) ? $_POST['grantid'] : '';

        if ($pid != '') {
            $cond_arr[] = "funder_id ='" . $pid . "'";
        }
        if ($gid != '') {
            $cond_arr[] = "id ='" . $gid . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        // $mtype = $_POST['m_type'];
        $childlist = $this->Mmaster->getGrantByDonor($result_cond);
        $options = '<option value="">--Select--</option>';
        foreach ($childlist as $list) {
            $options .= '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
        }
        echo $options;
    }

    public function getGrantamt() {
        $pid = isset($_POST['parent']) ? $_POST['parent'] : '';
        $programme_id = isset($_POST['programme_id']) ? $_POST['programme_id'] : '';
        $donor_id = isset($_POST['donor_id']) ? $_POST['donor_id'] : '';

        if ($donor_id != '') {
            $cond_arr[] = "funder_id ='" . $donor_id . "'";
        }
        if ($pid != '') {
            $cond_arr[] = "id ='" . $pid . "'";
        }
        $cond_arr[] = "status = 1";


        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        // $mtype = $_POST['m_type'];
        $childlist = $this->Mmaster->getGrantByDonor($result_cond);
        $original_amt = $childlist[0]['grant_amount'];
        if ($original_amt != '') {
            $returnArr['status'] = '1';
            $returnArr['post_data'] = $_POST;
        }

        $returnArr['total_available_amt'] = formatnumber($original_amt);
        $ApprovalAmount = $this->Mmaster->checkApprovalNoteAmtManual($programme_id, $donor_id, $childlist[0]['id']);
        #echo'<pre>';print_r($ApprovalAmount);die;
        $original_amt = $ApprovalAmount;
        $returnArr['response'] = formatnumber($original_amt);
        $returnArr['projected_amt'] = formatnumber($original_amt);
        // echo $options;
        echo json_encode($returnArr);
        exit;
    }

    public function DTLineitem() {
        $requestData = $_POST;

        $columns = array(
            1 => 'donor_name',
            2 => 'budget_name',
            3 => 'master_name',
            4 => 'status'
        );

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['master_type'] = $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        $data['donor_search'] = $donor_search = (isset($_POST['donor_search'])) ? $_POST['donor_search'] : '';
        $data['budget_search'] = $budget_search = (isset($_POST['budget_search'])) ? $_POST['budget_search'] : '';
        $data['pid'] = $pid = (isset($_POST['pid'])) ? $_POST['pid'] : '';

        #$search_field ="t1.master_name LIKE '%AT%' and t1.master_name ='AT' and t1.partner_id ='1'";
        if ($search_field != '') {
            $cond_arr[] = "t1.master_name ='" . $search_field . "'";
        }
        if ($pid != '') {
            $cond_arr[] = "t1.pid ='" . $pid . "'";
        }
        if ($budget_search != '') {
            $cond_arr[] = "t1.master_id ='" . $budget_search . "'";
        }
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id != '') {
            $cond_arr[] = "t1.partner_id ='" . $partner_id . "'";
        }

        if ($donor_search != '' && $budget_search == '' && $search_field == '') {
            $childlist = $this->Mmaster->getChildMasterList($donor_search, 'Budget Head');
            $child_arr = array();
            foreach ($childlist as $c_list) {
                $child_arr[] = $c_list['master_id'];
            }
            $child_ids = implode(',', $child_arr);
            $cond_arr[] = "t1.pid IN (" . $child_ids . ")";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');
        $donors = $this->Mmaster->getMasterList($partner, 'Donor');
        $budget_head = $this->Mmaster->getMasterList($partner, 'Budget Head');
        $option_list = '';

        $totalrows = $this->Mmaster->getDTLineCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTLineDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        /* echo $result_cond;
        echo'<pre>';print_r($query);die; */

        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;

        foreach ($query as $row) {

            foreach ($donors as $list) {

                if ($list['master_id'] == $row['donorid']) {
                    $select_did = 'selected';
                } else {
                    $select_did = '';
                }

                $donors_list .= '<option value="' . $list['master_id'] . '" ' . $select_did . '>' . $list['master_name'] . '</option>';
            }

            foreach ($budget_head as $list) {

                if ($list['master_id'] == $row['pid']) {
                    $select_pid = 'selected';
                } else {
                    $select_pid = '';
                }
                $option_list .= '<option value="' . $list['master_id'] . '" ' . $select_pid . '>' . $list['master_name'] . '</option>';
            }

            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'selected';
            } else if ($row['status'] == 0) {
                $selected2 = 'selected';
            }
            $nestedData = array();

            $nestedData[] = '<input type="hidden" class="inline_field_' . $row['master_id'] . ' opacity5 none-pointer" readonly disabled name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['master_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<select class="form-control inline_field_' . $row['master_id'] . ' opacity5 none-pointer" name="parent_type[]" onchange="getBudget(' . $i . ', this.value)" id="parent_type_' . $i . '" readonly disabled>
            <option value="">--Select--</option>' . $donors_list . '</select>';
            $nestedData[] = '<select class="form-control inline_field_' . $row['master_id'] . ' opacity5 none-pointer" name="budget_head[]" id="budget_head_' . $i . '" readonly disabled>
            <option value="">--Select--</option>' . $option_list . '</select>';
            $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['master_id'] . '  opacity5 none-pointer " name="master_name[]" id="master_name_' . $i . '" readonly disabled value="' . $row['master_name'] . '" placeholder="Enter name" />';
            $nestedData[] = '<select class="form-control inline_field_' . $row['master_id'] . ' opacity5 none-pointer" name="master_status[]" id="master_status_' . $i . '" readonly disabled>
            <option value="">--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="0" ' . $selected2 . '>Inactive</option>
            </select>';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert line item details to db */

    public function addLineitem() {

        for ($i = 0; $i < count($_POST['master_name']); $i++) {
            if ($_POST['master_name'][$i] != '') {
                $option['master_id'] = $_POST['master_edit_id'][$i];
                $mas_data['master_name'] = $_POST['master_name'][$i];
                $mas_data['status'] = $_POST['master_status'][$i];
                $mas_data['master_type'] = $_POST['master_type'];
                $mas_data['pid'] = $_POST['budget_head'][$i];
                $mas_data['partner_id'] = $this->session->userdata('partner_id');

                // $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';

                $checkExist = $this->Mmaster->getMasterAisDetails('master_settings', $option, '', '', '', 'master_id');

                #echo'<pre>';print_r($mas_data);die;
                if (count($checkExist) > 0) {
                    // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
                    $hm_query = $this->Mmaster->updateMasterDetail('master_settings', $option, $mas_data);
                } else {
                    // $jobspecdata['created_by'] = $this->session->userdata('emp_number');
                    $mas_data['added_date'] = date("Y-m-d H:i:s");
                    $hm_query = $this->Mmaster->insertMasterDetail('master_settings', $mas_data);
                }
            }
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Master settings details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/line_item');
    }

    /* additional info */

    public function additional_info($add = '', $editid = '') {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';

        $partner = $this->session->userdata('partner_id');
        $data['programme'] = $this->Mmaster->getProgramme();
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Donor');
        $data['budget_head'] = $this->Mmaster->getMasterList($partner, 'Budget Head');
        $data['line_item'] = $this->Mmaster->getMasterList($partner, 'Line Item');
        $data['master_type'] = 'Additional Info';
        if ($add != '') {
            $data['editid'] = isset($editid) && $editid != '' ? $editid : '';
            $data['additional_details'] = $this->Mmaster->getAdditoinalInfoByid($editid);
            $this->load->vars($data);
            $this->load->view('masters/add_additional');
        } else {
            $this->load->vars($data);
            $this->load->view('masters/additional_info');
        }
    }

    public function DTAdditional() {
        $requestData = $_POST;

        $columns = array(
            1 => 'programme_name',
            2 => 'donor_name',
            3 => 'budgethead_name',
            4 => 'lineitem_name',
            5 => 'additionalinfo',
            6 => 't1.status'
        );

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['programme_search'] = $programme_search = (isset($_POST['programme_search'])) ? $_POST['programme_search'] : '';
        $data['donor_search'] = $donor_search = (isset($_POST['donor_search'])) ? $_POST['donor_search'] : '';
        $data['budget_search'] = $budget_search = (isset($_POST['budget_search'])) ? $_POST['budget_search'] : '';
        $data['line_search'] = $line_search = (isset($_POST['line_search'])) ? $_POST['line_search'] : '';
        if ($search_field != '') {
            $cond_arr[] = "additionalinfo LIKE '%" . $search_field . "%'";
        }

        if ($programme_search != '') {
            $cond_arr[] = "t1.programme ='" . $programme_search . "'";
        }

        if ($budget_search != '') {
            $cond_arr[] = "t1.budgethead ='" . $budget_search . "'";
        }

        if ($donor_search != '') {
            $cond_arr[] = "t1.donor ='" . $donor_search . "'";
        }

        if ($line_search != '') {
            $cond_arr[] = "t1.lineitem ='" . $line_search . "'";
        }

        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id != '') {
            $cond_arr[] = "t1.partner_id ='" . $partner_id . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $totalrows = $this->Mmaster->getDTAdditionalCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTAdditionalDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'Active';
            } else if ($row['status'] == 2) {
                $selected = 'Inactive';
            }
            $nestedData = array();
            $programme = strlen($row['programme_name']) > 50 ? substr($row['programme_name'], 0, 50) . "..." : $row['programme_name'];
            $donorname = strlen($row['donor_name']) > 50 ? substr($row['donor_name'], 0, 50) . "..." : $row['donor_name'];
            $budgetname = strlen($row['budgethead_name']) > 50 ? substr($row['budgethead_name'], 0, 50) . "..." : $row['budgethead_name'];
            $lineitem = strlen($row['lineitem_name']) > 50 ? substr($row['lineitem_name'], 0, 50) . "..." : $row['lineitem_name'];
            $additionalinfo = strlen($row['additionalinfo']) > 50 ? substr($row['additionalinfo'], 0, 50) . "..." : $row['additionalinfo'];

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = $programme;
            $nestedData[] = $donorname;
            $nestedData[] = $budgetname;
            $nestedData[] = $lineitem;
            $nestedData[] = $additionalinfo;
            $nestedData[] = $selected;

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function getPrgmDonor() {
        $pid = $_POST['parent'];
        $prgmlist = $this->Mmaster->getProgramme('', $pid);

        $donor_programme = unserialize($prgmlist['0']['donor']);

        $donor_arr = implode(',', $donor_programme);
        $donorlist = $this->Mmaster->getDonorByProgramme($donor_arr, 'Donor');

        $options = '<option value="">--Select--</option>';
        foreach ($donorlist as $list) {
            $options .= '<option value="' . $list['master_id'] . '">' . $list['master_name'] . '</option>';
        }
        echo $options;
    }

    /* insert additional info details to db */

    public function addAdditionalinfo() {
        $option['id'] = $_POST['edit_id'];
        $add_data['partner_id'] = $this->session->userdata('partner_id');
        $add_data['programme'] = $_POST['programme'];
        $add_data['donor'] = $_POST['donor'];
        $add_data['budgethead'] = $_POST['budget_head'];
        $add_data['lineitem'] = $_POST['line_item'];
        $add_data['additionalinfo'] = $_POST['additional_info'];

        $add_data['status'] = 1;
        /*if ($_POST['status'] == '') {
            $add_data['status'] = 0;
        }*/

        #echo'<pre>';print_r($add_data);die;
        if ($_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query = $this->Mmaster->updateMasterDetail('additional_info', $option, $add_data);
        } else {
            $hm_query = $this->Mmaster->insertMasterDetail('additional_info', $add_data);
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Additional info saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/additional_info');
    }

    /* financial year */

    public function financial_year() {
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';

        $partner = $this->session->userdata('partner_id');
        $data['financial_lists'] = $this->Mmaster->getMasterAisDetails('financial_year', '', 3);
        $data['master_type'] = 'Financial Year';
        $this->load->vars($data);
        $this->load->view('masters/financial_year');
    }

    public function DTFinancialyear() {
        $requestData = $_POST;
        #echo'<pre>';print_r($_POST);die;
        $columns = array(
            0 => 'id',
            1 => 'from',
            2 => 'to',
            3 => 'status'
        );


        $searchArray[] = "partner_id = '" . $this->session->userdata('partner_id') . "'";
        $where = implode(' and ', $searchArray);
        $totalrows = $this->Mmaster->getDTFinancialCount('', $columns, $requestData);
        $query = $this->Mmaster->getDTFinancialDetails($requestData['length'], $requestData['start'], $where, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;

        foreach ($query as $row) {

            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'selected';
            } else if ($row['status'] == 0 && $row['status'] != '') {
                $selected2 = 'selected';
            }
            #echo $selected2;die;
            $nestedData = array();

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<input type="text" data-atrr=' . $i . ' class="form-control financial_date inline_field_' . $i . ' opacity5 none-pointer from_date" name="fromdate[]" id="fromdate_' . $i . '" readonly value="' . $row['from'] . '" /><div id="from_err_' . $i . '"></div>';
            $nestedData[] = '<input type="text" data-atrr=' . $i . ' class="form-control financial_date inline_field_' . $i . ' opacity5 none-pointer to_date" name="todate[]" id="todate_' . $i . '" readonly value="' . $row['to'] . '" /><div id="to_err_' . $i . '"></div>';
            $nestedData[] = '<select class="form-control inline_field_' . $i . ' opacity5 none-pointer status_cls status_count_' . $i . '" name="master_status[]" id="master_status_' . $i . '" readonly >
            <option value="">--Select--</option>
            <option value="1" ' . $selected . '>Active</option>
            <option value="0" ' . $selected2 . '>Inactive</option>
            </select>';

            #echo'<pre>';print_r($nestedData);die;
            $data[] = $nestedData;
            $i++;
        }


        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert budget head details to db */

    public function addFinancial() {


        $mas_data_inactive = array('status' => '0');
        $where_inactive = array('partner_id' => $this->session->userdata('partner_id'));
        $this->Mmaster->updateMasterDetail('financial_year', $where_inactive, $mas_data_inactive);

        for ($i = 0; $i < count($_POST['fromdate']); $i++) {
            if ($_POST['fromdate'][$i] != '') {
                $option['id'] = $_POST['master_edit_id'][$i];
                $mas_data['from'] = $_POST['fromdate'][$i];
                $mas_data['to'] = $_POST['todate'][$i];
                $mas_data['status'] = $_POST['master_status'][$i];
                $mas_data['partner_id'] = $this->session->userdata('partner_id');

                if ($mas_data['status'] == '') {
                    $mas_data['status'] = 3;
                }
                // $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';
                #echo'<pre>';print_r($mas_data);die;
                $checkExist = $this->Mmaster->getMasterAisDetails('financial_year', $option, '', '', '', '');
                if (count($checkExist) > 0) {
                    // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
                    $hm_query = $this->Mmaster->updateMasterDetail('financial_year', $option, $mas_data);
                } else {
                    $hm_query = $this->Mmaster->insertMasterDetail('financial_year', $mas_data);
                }
            }
        }



        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Financial year details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/financial_year');
    }

    /* Programme */

    public function programme($add = '', $editid = '') {
		
		$branch_id = $this->session->userdata('partner_id');
		if ($this->session->userdata('user_type') != 'superadmin') {
			$partner_id = $this->session->userdata('partner_id');
			if ($partner_id == '10') {
				$pitch_id = '3';
			} else {
				$pitch_id = '1';
			}
			$condition = array('pitch' => $pitch_id, 'parent_id' => 0);
		} else {
			$condition = array('parent_id' => 0);
		}
		$start = $this->input->post('start');
		$limit = 10;
		$this->load->model('user/Common_model');
		$sector_details = $this->Common_model->get_all_details('sector_category', $condition, array());
		$data['sector_details'] = $sector_details = json_decode(json_encode($sector_details), true);
		
		
        $data['filter_search'] = $filter_search = isset($_POST['filter_search']) ? $_POST['filter_search'] : '';

        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Donor');
        $data['userList'] = $this->Mmaster->getAllUserList();
        // getUserNameInfo
        $data['master_type'] = 'Programme';
		
		$this->load->model('user/Common_model');
		$branch = $this->input->post('branch');
        $users = $this->Common_model->getUsersList_sa($branch);
		$data['user_list'] = $users;
		#echo'<pre>';print_r($users);die;
        if ($add != '') {
            $data['editid'] = isset($editid) && $editid != '' ? $editid : '';
            $data['programme_details'] = $this->Mmaster->getProgrammeDetails($editid);
			 $this->load->vars($data);
            $this->load->view('masters/addprogramme');
        } else {
            $this->load->vars($data);
            $this->load->view('masters/programme');
        }
    }

    public function DTProgramme() {
        $requestData = $_POST;

        $columns = array(
            1 => 't1.programme',
            2 => 't1.programme_head'
        );

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['prgramme'] = $prgramme = (isset($_POST['prgramme'])) ? $_POST['prgramme'] : '';
        $data['programme_head'] = $programme_head = (isset($_POST['programme_head'])) ? $_POST['programme_head'] : '';

        if ($search_field != '') {
            $cond_arr[] = "t1.programme LIKE '%" . $search_field . "%'";
        }

        if ($programme_head != '') {
            $cond_arr[] = "t1.programme_head ='" . $programme_head . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');
        $donors = $this->Mmaster->getMasterList($partner, 'Donor');
        $userList = $this->Mmaster->getAllUserList();
        $option_list = '';

        $totalrows = $this->Mmaster->getDTProgrammeCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTProgrammeDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
        
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            foreach ($donors as $list) {

                if ($list['master_id'] == $row['donorid']) {
                    $select_did = 'selected';
                } else {
                    $select_did = '';
                }

                $donors_list .= '<option value="' . $list['master_id'] . '" ' . $select_did . '>' . $list['master_name'] . '</option>';
            }

            foreach ($userList as $ulist) {
                if ($ulist['id'] == $row['programme_head']) {
                    $select_uid = 'selected';
                } else {
                    $select_uid = '';
                }

                $users_list .= '<option value="' . $ulist['id'] . '" ' . $select_uid . '>' . $ulist['user_name'] . '</option>';
            }

            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'Active';
            } else if ($row['status'] == 0) {
                $selected = 'Inactive';
            }
            $donorr = unserialize($row["donor"]);
            $donors = '';
            foreach (unserialize($row["donor"]) as $key => $value):
                if (count($donorr != 1))
                    $donors .= $this->Mmaster->showMaster($value) . ", ";
                else
                    $donors .= $this->Mmaster->showMaster($value);
            endforeach;
            $nestedData = array();
            $programme = strlen($row['programme']) > 25 ? substr($row['programme'], 0, 25) . "..." : $row['programme'];
            $head_name = $this->Mmaster->getEmployeenameFromUserId($row['programme_head']);
            $budgetheadname = strlen($head_name) > 50 ? substr($head_name, 0, 50) . "..." : $head_name;
            $donors = rtrim($donors, ', ');
            $donorname = strlen($donors) > 25 ? substr($donors, 0, 25) . "..." : $donors;
			
			$this->load->model('user/Common_model');
			$an_sector_user = '';
			if($row['an_request_sector']!=''){
				$sector_details = $this->Common_model->get_all_details('sector_category', array('id'=>$row['an_request_sector']));
				$an_sector_user = $sector_details[0]->sector;
			}
			
            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['programme_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = $programme;
            $nestedData[] = $head_name;
            $nestedData[] = $donorname;
			$nestedData[] = $an_sector_user;
            $nestedData[] = $selected;

            // $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['programme_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            // $nestedData[] = '<input type="text" class="form-control commonAlphaNum inline_field_' . $row['programme_id'] . '  opacity5 none-pointer " name="programme_name[]" id="programme_name_' . $i . '" readonly disabled value="' . $row['programme'] . '" placeholder="Enter name" />';
            // $nestedData[] = '<select class="form-control inline_field_' . $row['programme_id'] . ' opacity5 none-pointer" name="programme_head[]" id="programme_head_' . $i . '" readonly disabled>
            //     <option value="">--Select--</option>'. $users_list . '</select>';
            // $nestedData[] = '<select class="form-control donor_types inline_field_' . $row['programme_id'] . ' opacity5 none-pointer" multiple="multiple" name="donor_types[]" id="donor_types_' . $i . '" readonly disabled>
            //     <option value="">--Select--</option>'. $donors_list . '</select>';
            // $nestedData[] = '<select class="form-control inline_field_' . $row['programme_id'] . ' opacity5 none-pointer" name="master_status[]" id="master_status_' . $i . '" readonly disabled>
            //     <option value="">--Select--</option>
            //     <option value="1" ' . $selected . '>Active</option>
            //     <option value="2" ' . $selected2 . '>Inactive</option>
            //     </select>';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert programme details to db */

    public function addProgramme() {

        $option['programme_id'] = $_POST['edit_id'];
        $mas_data['programme'] = $_POST['programme_name'];
        $mas_data['programme_head'] = $_POST['programme_head'];
        $mas_data['donor'] = serialize($_POST['donor_types']);
        $mas_data['status'] = $_POST['status'];
        $mas_data['partner_id'] = $this->session->userdata('partner_id');
		$mas_data['an_assign_user'] = $_POST['an_assign_user'];
		$mas_data['an_request_sector'] = $_POST['an_request_sector'];
        #echo'<pre>';print_r($mas_data);die;

        if (isset($_POST['edit_id']) && $_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query = $this->Mmaster->updateMasterDetail('master_programme', $option, $mas_data);
        } else {
            $hm_query = $this->Mmaster->insertMasterDetail('master_programme', $mas_data);
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Programme details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/programme');
    }

    /* set admin email */

    public function set_admin_email($add, $editid) {

        $data['adminemail'] = $this->Mmaster->getAdminemail();

        $data['master_type'] = 'Set Admin Email';
        $this->load->vars($data);
        $this->load->view('masters/set_admin_email');
    }

    public function addAdminemail() {

        $hm_query = $this->Mmaster->add_adminemail($_POST['adminmail']);


        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Admin email updated successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/set_admin_email');
    }

    /* Asset module */

    public function asset($tab = 'general', $action = '', $editid = '') {

        if ($tab == '') {
            $tab = 'general';
        }
        if ($tab == 'it') {
            $type = 'IT Asset';
        } else if ($tab == 'general') {
            $type = 'General Asset';
        } else if ($tab == 'general_asset') {
            $type = 'General Asset';
        } else if ($tab == 'it_asset') {
            $type = 'IT Asset';
        }
        $data['master_type'] = $type;
        $partner = $this->session->userdata('partner_id');
        $data['assettype'] = $this->Mmaster->getMasterList($partner, $type);
        #echo'<pre>';print_r($data['assettype']);die;
        $data['vendorList'] = $this->Mmaster->getVendorsList();
        $data['userList'] = $this->Mmaster->getAllUserList();
        $data['type'] = $tab;
        #echo $action;die;
        if ($action != '') {
            $data['editid'] = isset($editid) && $editid != '' ? $editid : '';
            // if($editid != ''){
            $data['assetlist'] = $this->Mmaster->getAssetDetails($tab, $editid);
            #echo'<pre>';print_r($data['assetlist']);die;
            // }
            $this->load->vars($data);
            $this->load->view('masters/addasset');
        } else {
            $this->load->vars($data);
            if ($tab == 'it') {
                $this->load->view('masters/assetit');
            } else {
                $this->load->view('masters/asset');
            }
        }
    }

    public function DTAsset() {
        $requestData = $_POST;
        if ($_POST['type'] == 'general') {
            $columns = array(
                1 => 'master_name',
                2 => 't1.asset_no',
                3 => 't1.asset_code',
                4 => 't1.asset_name',
                5 => 't1.description',
                6 => 't1.purchase_date',
                7 => 't1.warrenty_expiry_date',
                8 => 't1.vendor_name',
                9 => 't1.AMC',
                10 => 't1.AMC_vendor',
                11 => 't1.available_status'
            );
        } else {
            $columns = array(
                1 => 'master_name',
                2 => 't1.asset_no',
                3 => 't1.asset_code',
                4 => 't1.asset_name',
                5 => 't1.brand_name',
                6 => 't1.model',
                7 => 't1.serial_no',
                8 => 't1.purchase_date',
                9 => 't1.warrenty_expiry_date',
                10 => 't1.vendor_name',
                11 => 't1.AMC',
                12 => 't1.AMC_vendor',
                13 => 't1.available_status'
            );
        }
        $data['type'] = $type = (isset($_POST['type'])) ? $_POST['type'] : '';
        $data['search_field'] = $type_search = (isset($_POST['type_search'])) ? $_POST['type_search'] : '';
        $data['asset_name'] = $asset_name = (isset($_POST['asset_name'])) ? $_POST['asset_name'] : '';
        $data['asset_number'] = $asset_number = (isset($_POST['asset_number'])) ? $_POST['asset_number'] : '';
        $data['asset_code'] = $asset_code = (isset($_POST['asset_code'])) ? $_POST['asset_code'] : '';
        $data['purchase_date'] = $purchase_date = (isset($_POST['purchase_date'])) ? $_POST['purchase_date'] : '';
        $data['purchaseto_date'] = $purchaseto_date = (isset($_POST['purchaseto_date'])) ? $_POST['purchaseto_date'] : '';

        $data['reason_search'] = $reason_search = (isset($_POST['reason_search'])) ? $_POST['reason_search'] : '';
        $data['not_available'] = $not_available = (isset($_POST['not_available'])) ? $_POST['not_available'] : '';

        if ($type_search != '') {
            $cond_arr[] = "t1.asset_type ='" . $type_search . "'";
        }

        if ($asset_name != '') {
            $cond_arr[] = "t1.asset_name LIKE '%" . $asset_name . "%'";
        }
        if ($asset_number != '') {
            $cond_arr[] = "t1.asset_no LIKE '%" . $asset_number . "%'";
        }
        if ($asset_code != '') {
            $cond_arr[] = "t1.asset_code LIKE '%" . $asset_code . "%'";
        }
        if ($purchase_date != '' && $purchaseto_date != '') {
            $cond_arr[] = "t1.purchase_date >= '" . $purchase_date . "' and t1.purchase_date <= '" . $purchaseto_date . "'";
        }
        if ($reason_search != '') {
            $cond_arr[] = "t1.ina_reason LIKE '%" . $reason_search . "%'";
        }

        if ($type != '') {
            $cond_arr[] = "t1.type  ='" . $type . "'";
        } 
        if ($not_available != '') {
            $cond_arr[] = "t1.available_status  ='" . $not_available . "'";
        }

        $partner = $this->session->userdata('partner_id');
        if ($partner != '') {
            $cond_arr[] = "t2.partner_id  ='" . $partner . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $totalrows = $this->Mmaster->getDTAssetCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTAssetDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);


        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            $selected = $selected2 = '';
            $purchase_date = $warrenty_date = '--';
            if ($row['status'] == 1) {
                $selected = 'Active';
            } else if ($row['status'] == 0) {
                $selected = 'Inactive';
            }

            if ($row['available_status'] == 1) {
                $avail_status = 'Available';
            } else if ($row['available_status'] == 0) {
                $avail_status = 'Unavailable';
            }

            if ($row['purchase_date'] != '' && $row['purchase_date'] != '0000-00-00') {
                $purchase_date = date('d-m-Y', strtotime($row['purchase_date']));
            }
            if ($row['warrenty_expiry_date'] != '' && $row['warrenty_expiry_date'] != '0000-00-00') {
                $warrenty_date = date('d-m-Y', strtotime($row['warrenty_expiry_date']));
            }
            $vendorname = $this->Mmaster->getVendorsList($row['vendor'], '');
            $vendor_name="";
            if(isset($vendorname[0])){
                $vendor_name=$vendorname[0]['vendor_name'];
            }
            
            $nestedData = array();

            $mastername = strlen($row['master_name']) > 30 ? substr($row['master_name'], 0, 30) . "..." : $row['master_name'];
            $asset_no = strlen($row['asset_no']) > 30 ? substr($row['asset_no'], 0, 30) . "..." : $row['asset_no'];
            $asset_code = strlen($row['asset_code']) > 30 ? substr($row['asset_code'], 0, 30) . "..." : $row['asset_code'];
            $asset_name = strlen($row['asset_name']) > 30 ? substr($row['asset_name'], 0, 30) . "..." : $row['asset_name'];
            $description = strlen($row['description']) > 30 ? substr($row['description'], 0, 30) . "..." : $row['description'];
            $serial_no = strlen($row['serial_no']) > 30 ? substr($row['serial_no'], 0, 30) . "..." : $row['serial_no'];

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['asset_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = $mastername;
            $nestedData[] = $asset_no;
            $nestedData[] = $asset_code;
            $nestedData[] = $asset_name;
            if ($_POST['type'] == 'it') {
                $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/edit/' . $row['asset_id'] . '">' . $row['brand_name'] . '</a>';
                $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/edit/' . $row['asset_id'] . '">' . $row['model'] . '</a>';
                $nestedData[] = $serial_no;
            } else {
                $nestedData[] = $description;
            }
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/edit/' . $row['asset_id'] . '">' . $purchase_date . '</a>';
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/edit/' . $row['asset_id'] . '">' . $warrenty_date . '</a>';
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/general/edit/' . $row['asset_id'] . '">' . $vendor_name . '</a>';
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/edit/' . $row['asset_id'] . '">' . ucfirst($row['AMC']) . '</a>';
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/edit/' . $row['asset_id'] . '">' . $row['amc_name'] . '</a>';
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/edit/' . $row['asset_id'] . '">' . $avail_status . '</a>';
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/asset/general/edit/' . $row['asset_id'] . '">' . $selected . '</a>';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert asset details to db */

    public function addAsset() {

        $option['asset_id'] = $_POST['edit_id'];
        $mas_data['type'] = $_POST['type'];
        $mas_data['asset_type'] = $_POST['asset_type'];
        $mas_data['asset_no'] = $_POST['asset_no'];
        $mas_data['asset_code'] = $_POST['asset_code'];
        $mas_data['asset_name'] = $_POST['asset_name'];
        $mas_data['brand_name'] = isset($_POST['brand_name']) ? $_POST['brand_name'] : '';
        $mas_data['model'] = isset($_POST['model']) ? $_POST['model'] : '';
        $mas_data['serial_no'] = isset($_POST['serial_no']) ? $_POST['serial_no'] : '';

        $mas_data['description'] = isset($_POST['description']) ? $_POST['description'] : '';
        $mas_data['warrenty_expiry_date'] = isset($_POST['warrenty_expiry_date']) && $_POST['warrenty_expiry_date'] != '' ? date('Y-m-d', strtotime($_POST['warrenty_expiry_date'])) : '';
        $mas_data['purchase_date'] = isset($_POST['purchase_date']) && $_POST['purchase_date'] != '' ? date('Y-m-d', strtotime($_POST['purchase_date'])) : '';
        $mas_data['vendor'] = $_POST['vendor'];
        $mas_data['price'] = $_POST['price'];
        $mas_data['bill_no'] = $_POST['bill_no'];
        $mas_data['bill_date'] = isset($_POST['bill_date']) && $_POST['bill_date'] != '' ? date('Y-m-d', strtotime($_POST['bill_date'])) : '';
        $mas_data['AMC'] = isset($_POST['amc']) && $_POST['amc'] != '' ? $_POST['amc'] : '0';
        if ($_POST['amc'] == 1) {
            $mas_data['AMC_period'] = isset($_POST['AMC_period']) && $_POST['AMC_period'] != '' ? date('Y-m-d', strtotime($_POST['AMC_period'])) : '';
            $mas_data['AMC_vendor'] = $_POST['AMC_vendor'];
        }
        $mas_data['status'] = $_POST['status'];


        if (isset($_POST['edit_id']) && $_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query = $this->Mmaster->updateMasterDetail('master_asset', $option, $mas_data);
        } else {
            $hm_query = $this->Mmaster->insertMasterDetail('master_asset', $mas_data);
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Asset details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/asset/general');
    }

    /* vendor master */

    public function vendor_master($action = '', $editid = '') {

        $data['master_type'] = $type = 'Vendor Master';
        $partner = $this->session->userdata('partner_id');
        $data['userList'] = $this->Mmaster->getAllUserList();
        $data['type'] = $action;
        #echo $action;die;
        if ($action != '') {
            $data['editid'] = isset($editid) && $editid != '' ? $editid : '';
            $data['vendorList'] = $this->Mmaster->getVendorsList($editid);
            if ($editid != '') {

                $data['vendorcontacts'] = $this->Mmaster->getVendorscontactList($editid);
            }
            $this->load->vars($data);
            $this->load->view('masters/addvendor');
        } else {
            $this->load->vars($data);
            $this->load->view('masters/vendor');
        }
    }

    public function DTVendor() {
        $requestData = $_POST;

        $columns = array(
            1 => 'vendor_name',
            2 => 'vendor_email',
            3 => 'contact_person',
            4 => 'address',
            5 => 'contact_no',
            6 => 'website'
        );


        $data['contact_person'] = $contact_person = (isset($_POST['contact_person'])) ? $_POST['contact_person'] : '';
        $data['vendor_name'] = $vendor_name = (isset($_POST['vendor_name'])) ? $_POST['vendor_name'] : '';

        if ($contact_person != '') {
            $cond_arr[] = "contact_person LIKE '%" . $contact_person . "%'";
        }

        if ($vendor_name != '') {
            $cond_arr[] = "vendor_name LIKE '%" . $vendor_name . "%'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');

        $totalrows = $this->Mmaster->getDTVendorCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTVendorDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);


        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            $selected = $selected2 = '';
            if ($row['status'] == 1) {
                $selected = 'Active';
            } else if ($row['status'] == 0) {
                $selected = 'Inactive';
            }

            $nestedData = array();
            $vendor_name = strlen($row['vendor_name']) > 25 ? substr($row['vendor_name'], 0, 25) . "..." : $row['vendor_name'];
            $contact_person = strlen($row['contact_person']) > 25 ? substr($row['contact_person'], 0, 25) . "..." : $row['contact_person'];
            $address = strlen($row['address']) > 25 ? substr($row['address'], 0, 25) . "..." : $row['address'];

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['vendor_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = '<a href="" >' . $vendor_name . '</a>';
            $nestedData[] = $row['vendor_email'];
            $nestedData[] = $contact_person;
            $nestedData[] = $address;
            $nestedData[] = $row['contact_no'];
            $nestedData[] = '<a href="javascript:void(0)" id="morecontacts" onclick="showContacts(' . $row['vendor_id'] . ')">More Contacts</a>';
            $nestedData[] = $row['website'];
            $nestedData[] = $selected;

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function showmorecontacts() {
        $vendorid = (isset($_POST['id'])) ? $_POST['id'] : '';
        $vendorcontacts = $this->Mmaster->getVendorscontactList($vendorid);
        $reault = '';
        if (count($vendorcontacts) > 0) {
            foreach ($vendorcontacts as $clist) {
                $result .= '<tr><td>' . $clist['name'] . '</td><td>' . $clist['contact_no'] . '</td><td>' . $clist['email'] . '</td></tr>';
            }
        } else {
            $result .= '<tr><td colspan="3" style="text-align: center;">No result found</td></tr>';
        }
        echo $result;
    }

    /* insert vendor details to db */

    public function addVendor() {

        $option['vendor_id'] = $_POST['edit_id'];
        $mas_data['vendor_name'] = $_POST['vendor_name'];
        $mas_data['contact_person'] = $_POST['contact_person'];
        $mas_data['contact_no'] = $_POST['contact_no'];
        $mas_data['vendor_email'] = $_POST['vendor_email'];
        $mas_data['address'] = $_POST['address'];
        $mas_data['website'] = isset($_POST['website']) ? $_POST['website'] : '';
        $mas_data['status'] = '1';


        if (isset($_POST['edit_id']) && $_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query = $this->Mmaster->updateMasterDetail('master_vendor', $option, $mas_data);
            $vendor_id = $_POST['edit_id'];
        } else {
            $hm_query = $this->Mmaster->insertMasterDetail('master_vendor', $mas_data);
            $vendor_id = $this->db->insert_id();
        }

        if ($hm_query) {

            if ($_POST['contactmore_person'][0] != '') {
                for ($i = 0; $i < count($_POST['contactmore_person']); $i++) {
                    $leavedata = array();

                    $option['contact_id'] = $_POST['contact_edit_id'][$i];
                    $contactdata['name'] = $leave_type_id = $_POST['contactmore_person'][$i];
                    $contactdata['contact_no'] = $_POST['contactmore_no'][$i];
                    $contactdata['email'] = $_POST['contactmore_email'][$i];
                    $contactdata['vendor_id'] = $vendor_id;
// print_r($holidaydata);
// die;

                    $checkExist = $this->Mmaster->getAisMasterDetails('master_vendor_contact', $option);
                    if (count($checkExist) > 0) {
                        $contact_query = $this->Mmaster->updateMasterDetail('master_vendor_contact', $option, $contactdata);
                    } else {
                        $contact_query = $this->Mmaster->insertMasterDetail('master_vendor_contact', $contactdata);
                    }
                }
            }

            $this->session->set_flashdata('successMsg', "Vendor details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/vendor_master');
    }

    /* books master */

    public function books_master($action = '', $editid = '') {

        $data['master_type'] = $type = ($tab == 'it') ? 'IT Asset' : 'General Asset';
        $partner = $this->session->userdata('partner_id');
        $data['books_category'] = $this->Mmaster->getMasterList($partner, 'Books Category');
        $data['type'] = $action;

        if ($action != '') {
            $data['editid'] = isset($editid) && $editid != '' ? $editid : '';
            // if($editid != ''){
            $data['booksList'] = $this->Mmaster->getBooksList($editid);
            // }
            $this->load->vars($data);
            $this->load->view('masters/addbook');
        } else {
            $this->load->vars($data);
            $this->load->view('masters/books');
        }
    }

    public function DTBooks() {
        $requestData = $_POST;

        $columns = array(
            1 => 't2.master_name',
            2 => 't1.book_number',
            3 => 't1.book_name',
            4 => 't1.author'
        );

        $data['books_category'] = $books_category = (isset($_POST['books_category'])) ? $_POST['books_category'] : '';
        $data['books_name'] = $books_name = (isset($_POST['books_name'])) ? $_POST['books_name'] : '';
        $data['author'] = $author = (isset($_POST['author'])) ? $_POST['author'] : '';

        if ($books_category != '') {
            $cond_arr[] = "t1.master_id = " . $books_category . "";
        }

        if ($books_name != '') {
            $cond_arr[] = "book_name LIKE '%" . $books_name . "%'";
        }

        if ($author != '') {
            $cond_arr[] = "author LIKE '%" . $author . "%'";
        }

        $partner = $this->session->userdata('partner_id');
        if ($partner != '') {
            $cond_arr[] = "t2.partner_id ='" . $partner . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        
        $totalrows = $this->Mmaster->getDTBooksCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTBooksDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);


        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            $selected = $selected2 = $available = '';
            if ($row['status'] == 1) {
                $selected = 'Active';
            } else if ($row['status'] == 0) {
                $selected = 'Inactive';
            }

            if ($row['available'] == 1) {
                $available = 'available';
            } else if ($row['available'] == 0) {
                $available = 'Not available';
            }

            $nestedData = array();
            $master_name = strlen($row['master_name']) > 25 ? substr($row['master_name'], 0, 25) . "..." : $row['master_name'];
            $book_number = strlen($row['book_number']) > 25 ? substr($row['book_number'], 0, 25) . "..." : $row['book_number'];
            $book_name = strlen($row['book_name']) > 25 ? substr($row['book_name'], 0, 25) . "..." : $row['book_name'];
            $author = strlen($row['author']) > 25 ? substr($row['author'], 0, 25) . "..." : $row['author'];

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['book_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = $master_name;
            $nestedData[] = $book_number;
            $nestedData[] = $book_name;
            $nestedData[] = $author;
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/books_master/edit/' . $row['book_id'] . '">' . ucfirst($available) . '</a>';
            $nestedData[] = '<a href="' . base_url() . 'index.php/master/books_master/edit/' . $row['book_id'] . '">' . ucfirst($selected) . '</a>';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert book details to db */

    public function addBooks() {

        $option['book_id'] = $_POST['edit_id'];
        $mas_data['book_name'] = $_POST['book_name'];
        $mas_data['author'] = $_POST['author'];
        $mas_data['master_id'] = $_POST['master_id'];
        $mas_data['book_number'] = $_POST['book_number'];
        $mas_data['status'] = '1';
        $mas_data['available'] = '1';


        if (isset($_POST['edit_id']) && $_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query = $this->Mmaster->updateMasterDetail('master_books', $option, $mas_data);
        } else {
            $hm_query = $this->Mmaster->insertMasterDetail('master_books', $mas_data);
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Books details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/books_master');
    }

    /* visitors log */

    public function visitors_log($action = '', $editid = '') {

        $data['master_type'] = $type = ($tab == 'it') ? 'IT Asset' : 'General Asset';
        $partner = $this->session->userdata('partner_id');
        $data['userList'] = $this->Mmaster->getAllUserList();
        $data['type'] = $action;
        #echo $action;die;
        if ($action != '') {
            $data['editid'] = isset($editid) && $editid != '' ? $editid : '';
            // if($editid != ''){
            $data['visitorsList'] = $this->Mmaster->getVisitorsList($editid);
            // }
            $this->load->vars($data);
            $this->load->view('masters/addvisitor');
        } else {
            $this->load->vars($data);
            $this->load->view('masters/visitorslog');
        }
    }

    public function DTVisitorslog() {
        $requestData = $_POST;

        $columns = array(
            1 => 't1.date',
            2 => 't1.name_of_visitor',
            3 => 't1.name_of_organization',
            4 => 't1.intending_to_meet',
            5 => 'purpose'
        );

        $data['userid'] = $userid = (isset($_POST['userid'])) ? $_POST['userid'] : '';
        $data['date_search'] = $date_search = (isset($_POST['date_search'])) ? $_POST['date_search'] : '';
        $data['month_search'] = $month_search = (isset($_POST['month_search'])) ? $_POST['month_search'] : '';
        $data['year_search'] = $year_search = (isset($_POST['year_search'])) ? $_POST['year_search'] : '';

        if ($userid != '') {
            $cond_arr[] = "t1.intending_to_meet ='" . $userid . "'";
        }

        if ($date_search != '') {
            $cond_arr[] = "t1.date = '" . $date_search . "'";
        }

        if ($month_search != '') {
            $cond_arr[] = "MONTH(t1.date) = '" . $month_search . "'";
        }
        if ($year_search != '') {
            $cond_arr[] = "YEAR(t1.date) = '" . $year_search . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');

        $totalrows = $this->Mmaster->getDTVisitorsCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTVisitorsDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);

        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            $selected = $selected2 = $available = '';
            if ($row['status'] == 1) {
                $selected = 'Active';
            } else if ($row['status'] == 0) {
                $selected = 'Inactive';
            }

            if ($row['date'] != '' || $row['date'] != '0000-00-00') {
                $log_date = date('d-m-Y', strtotime($row['date']));
            } else {
                $log_date = '--';
            }


            $nestedData = array();
            $name_of_visitor = strlen($row['name_of_visitor']) > 25 ? substr($row['name_of_visitor'], 0, 25) . "..." : $row['name_of_visitor'];
            $name_of_organization = strlen($row['name_of_organization']) > 25 ? substr($row['name_of_organization'], 0, 25) . "..." : $row['name_of_organization'];
            $intending_to_meet = strlen($row['user_name']) > 25 ? substr($row['user_name'], 0, 25) . "..." : $row['user_name'];
            $purpose = strlen($row['purpose']) > 25 ? substr($row['purpose'], 0, 25) . "..." : $row['purpose'];

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['log_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = $log_date;
            $nestedData[] = $name_of_visitor;
            $nestedData[] = $name_of_organization;
            $nestedData[] = $intending_to_meet;
            $nestedData[] = $purpose;
            $nestedData[] = $row['time_in'];
            $nestedData[] = $row['time_out'];
            $nestedData[] = $row['innovation'];
            $nestedData[] = $selected;

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert visitors log details to db */

    public function addVisitorslog() {

        $option['log_id'] = $_POST['edit_id'];
        $mas_data['name_of_visitor'] = $_POST['name_of_visitor'];
        $mas_data['name_of_organization'] = $_POST['name_of_organization'];
        $mas_data['intending_to_meet'] = $_POST['intending_to_meet'];
        $mas_data['date'] = date('Y-m-d', strtotime($_POST['log_date']));
        $mas_data['purpose'] = $_POST['purpose'];
        $mas_data['time_in'] = $_POST['time_in'];
        $mas_data['time_out'] = $_POST['time_out'];
        $mas_data['innovation'] = $_POST['innovation'];
        $mas_data['status'] = '1';


        if (isset($_POST['edit_id']) && $_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query = $this->Mmaster->updateMasterDetail('visitors_log', $option, $mas_data);
        } else {
            $hm_query = $this->Mmaster->insertMasterDetail('visitors_log', $mas_data);
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Visitors log details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/visitors_log');
    }

    /* dispatch inward */

    public function dispatch_inward($tab = '', $action = '', $editid = '') {
        if ($tab == '') {
            $tab = 'pending';
        }
        $data['master_type'] = $tab;
        $partner = $this->session->userdata('partner_id');
        $data['userList'] = $this->Mmaster->getAllUserList();
        $data['type'] = $action;
        if ($action != '') {
            $data['editid'] = isset($editid) && $editid != '' ? $editid : '';
            // if($editid != ''){
            $data['inwardList'] = $this->Mmaster->getInwardList($editid, $tab);
            // print_r($data['inwardList']);
            // die;
            // }
            $this->load->vars($data);
            $this->load->view('masters/addinward');
        } else {
            $this->load->vars($data);
            $this->load->view('masters/inward');
        }
    }

    public function DTInward() {
        $requestData = $_POST;
        if ($_POST['master_type'] == 'pending') {
            $columns = array(
                1 => 't1.received_date',
                2 => 'user_name',
                3 => 't1.person_name',
                4 => 't1.company_name',
                5 => 't1.content',
                6 => 't1.vendor',
                7 => 't1.status'
            );
        } else if ($_POST['master_type'] == 'confirmed') {
            $columns = array(
                1 => 't1.received_date',
                2 => 'user_name',
                3 => 't1.person_name',
                4 => 't1.company_name',
                5 => 't1.content',
                6 => 't1.vendor',
                7 => 't1.status',
                8 => 't1.handover_to',
                9 => 't1.handover_date'
            );
        }

        $data['master_type'] = $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        $data['emp_search'] = $emp_search = (isset($_POST['emp_search'])) ? $_POST['emp_search'] : '';
        $data['handover_from'] = $handover_from = (isset($_POST['handover_from'])) ? $_POST['handover_from'] : '';
        $data['handover_to'] = $handover_to = (isset($_POST['handover_to'])) ? $_POST['handover_to'] : '';

        if ($emp_search != '') {
            $cond_arr[] = "t1.employee_id = '" . $emp_search . "'";
        }

        if ($handover_from != '') {
            $cond_arr[] = "handover_date >= '" . $handover_from . "'";
        }

        if ($handover_to != '') {
            $cond_arr[] = "handover_date <= '" . $handover_to . "'";
        }
        if ($master_type != '') {
            $cond_arr[] = "t1.status = '" . $master_type . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');

        $totalrows = $this->Mmaster->getDTInwardCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTInwardDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);


        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $received_date = $handover_date = '';
            if ($row['received_date'] != '' || $row['received_date'] != '0000-00-00') {
                $received_date = date('d-m-Y', strtotime($row['received_date']));
            }

            if ($row['handover_date'] != '' || $row['handover_date'] != '0000-00-00') {
                $handover_date = date('d-m-Y', strtotime($row['handover_date']));
            }

            $username = $this->Mmaster->getUserNameInfo($row['employee_id']);
            $handoverto = $this->Mmaster->getUserNameInfo($row['handover_to']);

            $nestedData = array();
            $person_name = strlen($row['person_name']) > 25 ? substr($row['person_name'], 0, 25) . "..." : $row['person_name'];
            $company_name = strlen($row['company_name']) > 25 ? substr($row['company_name'], 0, 25) . "..." : $row['company_name'];
            $content = strlen($row['content']) > 25 ? substr($row['content'], 0, 25) . "..." : $row['content'];
            $vendor = strlen($row['vendor']) > 25 ? substr($row['vendor'], 0, 25) . "..." : $row['vendor'];

            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['inward_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = $received_date;
            $nestedData[] = $username[0]['user_name'];
            $nestedData[] = $person_name;
            $nestedData[] = $company_name;
            $nestedData[] = $content;
            $nestedData[] = $vendor;
            $nestedData[] = $row['status'];
            if ($_POST['master_type'] == 'confirmed') {
                $nestedData[] = $handoverto[0]['user_name'];
                $nestedData[] = $handover_date;
            }

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert inward details to db */

    public function addInward() {

        $option['inward_id'] = $_POST['edit_id'];
        $mas_data['received_date'] = date('Y-m-d', strtotime($_POST['received_date']));
        $mas_data['employee_id'] = $_POST['employee_id'];
        $mas_data['person_name'] = $_POST['person_name'];
        $mas_data['company_name'] = $_POST['company_name'];
        $mas_data['content'] = $_POST['content'];
        $mas_data['vendor'] = $_POST['vendor'];
        $mas_data['status'] = 'pending';


        if (isset($_POST['edit_id']) && $_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query = $this->Mmaster->updateMasterDetail('dispatch_inward', $option, $mas_data);
        } else {
            $hm_query = $this->Mmaster->insertMasterDetail('dispatch_inward', $mas_data);
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Dispatch inward details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/dispatch_inward');
    }

    /* insert handover to details to db */

    public function addhandover_to() {

        $option['inward_id'] = $_POST['inward_handoverto'];
        $mas_data['handover_date'] = date('Y-m-d', strtotime($_POST['handover_date']));
        $mas_data['handover_to'] = $_POST['handover_to'];
        $mas_data['status'] = 'confirmed';

        $hm_query = $this->Mmaster->updateMasterDetail('dispatch_inward', $option, $mas_data);

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Handedover details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/dispatch_inward');
    }

    /* dispatch outward */

    public function dispatch_outward($tab = '', $action = '', $editid = '') {

        if ($tab == '') {
            $tab = 'pending';
        }
        $data['master_type'] = $tab;
        $partner = $this->session->userdata('partner_id');
        $data['userList'] = $this->Mmaster->getAllUserList();
        $data['type'] = $action;
        #echo'<pre>';print_r($action);die;
        if ($action != '') {
            $data['editid'] = isset($editid) && $editid != '' ? $editid : '';
            // if($editid != ''){
            $data['outwardList'] = $this->Mmaster->getOutwardList($editid, $tab);
            // }
            $this->load->vars($data);
            $this->load->view('masters/addoutward');
        } else {
            $this->load->vars($data);
            $this->load->view('masters/outward');
        }
    }

    public function DTOutward() {
        $requestData = $_POST;

        if ($_POST['master_type'] == 'pending' || $_POST['master_type'] == 'report') {
            $columns = array(
                1 => 't1.dispatch_date',
                2 => 'user_name',
                3 => 't1.person_name',
                4 => 't1.company_name',
                5 => 't1.city',
                6 => 't1.state',
                7 => 't1.pincode',
                8 => 't1.content',
                9 => 't1.status'
            );
        } else if ($_POST['master_type'] == 'confirmed') {
            $columns = array(
                1 => 't1.dispatch_date',
                2 => 'user_name',
                3 => 't1.person_name',
                4 => 't1.company_name',
                5 => 't1.city',
                6 => 't1.state',
                7 => 't1.pincode',
                8 => 't1.content',
                9 => 't1.consignment_no',
                10 => 't1.vendor',
                11 => 't1.sent_date',
                12 => 't1.status'
            );
        }


        $data['master_type'] = $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        $data['emp_search'] = $emp_search = (isset($_POST['emp_search'])) ? $_POST['emp_search'] : '';
        $data['dispatch_from'] = $dispatch_from = (isset($_POST['dispatch_from'])) ? $_POST['dispatch_from'] : '';
        $data['dispatch_to'] = $dispatch_to = (isset($_POST['dispatch_to'])) ? $_POST['dispatch_to'] : '';

        if ($emp_search != '') {
            $cond_arr[] = "t1.employee_id = '" . $emp_search . "'";
        }

        if ($dispatch_from != '') {
            $cond_arr[] = "dispatch_date >= '" . $dispatch_from . "'";
        }

        if ($dispatch_to != '') {
            $cond_arr[] = "dispatch_date <= '" . $dispatch_to . "'";
        }

        if ($master_type != '' && $master_type != 'report') {
            $cond_arr[] = "t1.status = '" . $master_type . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');

        $totalrows = $this->Mmaster->getDTOutwardCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTOutwardDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);

        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            $dispatch_date = $sent_date = '';
            if ($row['dispatch_date'] != '' || $row['dispatch_date'] != '0000-00-00') {
                $dispatch_date = date('d-m-Y', strtotime($row['dispatch_date']));
            }

            if ($row['sent_date'] != '' || $row['sent_date'] != '0000-00-00') {
                $sent_date = date('d-m-Y', strtotime($row['sent_date']));
            }

            $username = $this->Mmaster->getUserNameInfo($row['employee_id']);

            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['outward_id'] . '"><input class="form-control master_check" style="width: 12px;" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = $dispatch_date;
            $nestedData[] = $username[0]['user_name'];
            $nestedData[] = $row['person_name'];
            $nestedData[] = $row['company_name'];
            $nestedData[] = $row['city'];
            $nestedData[] = $row['state'];
            $nestedData[] = $row['pincode'];
            $nestedData[] = $row['content'];
            if ($_POST['master_type'] == 'confirmed') {
                $nestedData[] = $row['consignment_no'];
                $nestedData[] = $row['vendor'];
                $nestedData[] = $sent_date;
            }
            $nestedData[] = $row['status'];

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert inward details to db */

    public function addOutward() {

        $option['outward_id'] = $_POST['edit_id'];
        $mas_data['dispatch_date'] = date('Y-m-d', strtotime($_POST['dispatch_date']));
        $mas_data['employee_id'] = $_POST['employee_id'];
        $mas_data['person_name'] = $_POST['person_name'];
        $mas_data['company_name'] = $_POST['company_name'];
        $mas_data['city'] = $_POST['city'];
        $mas_data['state'] = $_POST['state'];
        $mas_data['pincode'] = $_POST['pincode'];
        $mas_data['content'] = $_POST['content'];
        $mas_data['status'] = 'pending';


        if (isset($_POST['edit_id']) && $_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query = $this->Mmaster->updateMasterDetail('dispatch_outward', $option, $mas_data);
        } else {
            $hm_query = $this->Mmaster->insertMasterDetail('dispatch_outward', $mas_data);
        }

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Dispatch outward details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/dispatch_outward');
    }

    /* insert handover of dispatch outward to details to db */

    public function addOutwardSent_to() {

        $option['outward_id'] = $_POST['outward_handoverto'];
        $mas_data['sent_date'] = date('Y-m-d', strtotime($_POST['sent_date']));
        $mas_data['vendor'] = $_POST['vendor'];
        $mas_data['status'] = 'confirmed';

        $hm_query = $this->Mmaster->updateMasterDetail('dispatch_outward', $option, $mas_data);

        if ($hm_query) {

            $this->session->set_flashdata('successMsg', "Dispatch outward details sent successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/dispatch_outward');
    }

    /* balance sheet module starts */

    public function balance_sheet() {
        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $from = $cur_year . '-' . '04-01';
        $data['to'] = $to = date("Y-m-t", strtotime($next_year . '-' . '03'));
        $queryArray = array('to' => $to, 'from' => $from);
        $wher = 'Donor';
        $data['listDonor'] = $this->Mmaster->getBalance($report_nam, $queryArray, $wher);
        $data['master_type'] = 'Balance Sheet';
        $data['current_year'] = $cur_year;
        $data['next_year'] = $next_year;
        $this->load->vars($data);
        $this->load->view('masters/balance_sheet');
    }

    public function multipleAmountHistory() {
        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $from = $cur_year . '-' . '04-01';
        $data['to'] = $to = date("Y-m-t", strtotime($next_year . '-' . '03'));
        $partner = $this->session->userdata('partner_id');

        if ($from != '') {
            $amt_fromdate = date('Y-m-d', strtotime($from));
            $cond_arr[] = "t1.amount_date >= '" . $amt_fromdate . "'";
        }

        if ($to != '') {
            $amt_todate = date('Y-m-d', strtotime($to));
            $cond_arr[] = "t1.amount_date <= '" . $amt_todate . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $data['history_action'] = $this->Mmaster->getBalanceHistory($result_cond);
        #echo'<pre>';print_r($data['history_action']);die;
        $data['master_type'] = 'Balance Sheet';
        // print_r($data['listDonor']);
        $this->load->vars($data);
        $this->load->view('masters/multipledonor_history');
    }

    public function DTBalance() {
        $requestData = $_POST;

        $columns = array(
            0 => 'MP.programme',
            1 => 'D.master_name',
            2 => 'grant_name',
            3 => 'budget_head',
            4 => 'line_item'
        );

        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;

        // $cur_year = date('Y') - 1;
        $data['from'] = $fromperiod = $cur_year . '-' . '04-01';
        $data['to'] = $toperiod = date("Y-m-t", strtotime($next_year . '-' . '03'));

        $data['donorid'] = $donorid = (isset($_POST['donorid'])) ? $_POST['donorid'] : '';
        $data['master_type'] = $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        $data['from_year'] = $from_year = (isset($_POST['from_year'])) && $_POST['from_year'] != '' ? $_POST['from_year'] . '-' . '04-01' : $fromperiod;
        $data['from_to'] = $from_to = (isset($_POST['from_to'])) && $_POST['from_to'] != '' ? $_POST['from_to'] . '-' . '03-31' : $toperiod;
        $data['programme_search'] = $programme_search = (isset($_POST['programme_search'])) ? $_POST['programme_search'] : '';

        $cond_arr[] = "MP.partner_id = '" . $this->session->userdata('partner_id') . "'";

        if ($donorid != '') {
            $cond_arr[] = "D1A.donor_id = '" . $donorid . "'";
        }
        if ($master_type != '') {
            $cond_arr[] = "D.master_type = '" . $master_type . "'";
        }

        if ($from_year != '') {
            $amt_fromdate = date('Y-m-d', strtotime($from_year));
            $cond_arr[] = "D1A.amount_date >= '" . $amt_fromdate . "'";
        }

        if ($from_to != '') {
            $amt_todate = date('Y-m-d', strtotime($from_to));
            $cond_arr[] = "D1A.amount_date <= '" . $amt_todate . "'";
        }

        if ($programme_search != '') {
            $cond_arr[] = "MP.programme LIKE '%" . $programme_search . "%'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');
        $length = 2000;
        $start = 0;

        #echo $length.'=='.$start.'=='.$result_cond.'=='.$columns.'=='.$requestData;
        $totalrows = $this->Mmaster->getDTBalanceCount($result_cond, $columns, $requestData);
        #$query = $this->Mmaster->getDTBalanceDetails($length, $start, $result_cond, $columns, $requestData);

        $query = $this->Mmaster->getDonorLimitRecords($length, $start, $result_cond, $columns, $requestData);
		#echo'<pre>';print_r($query);die;
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;

        $na = '';
        $nb = '';

        $na_prog = '';
        $na_budget = '';
        $programme = '';

        foreach ($query as $row) {

            $assignAmountArray[] = $row['amount'];
            $assign_amt = formatnumber($row['amount']);

            $add_info_value = $this->Mmaster->getAdditionalInfo($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid']);
            $additional_info = $add_info_value['add_info_value'];

            $approvalAmount = $this->Mmaster->checkApprovalNoteAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
            $approvalAmount = ($approvalAmount != '') ? round($approvalAmount, 2) : $approvalAmount;
            $approvalAmountArray[] = $approvalAmount;
            $approval_amt = formatnumber($approvalAmount);

            $internalAmount = $this->Mmaster->checkInternalAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
            $internalAmount = ($internalAmount != '') ? round($internalAmount, 2) : $internalAmount;
            $internalAmountArray[] = $internalAmount;
            $internal_amt = formatnumber($internalAmount);

            $recovered_amount = $this->Mmaster->checkRecoveredAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
            $recoveredAmountArray[] = $recovered_amount;
            $recovered_amt = formatnumber($recovered_amount);

            $available = ($row['amount'] - ($approvalAmount)) + $recovered_amount;
            $availbleAmountArray[] = $available;
            $available_amt = formatnumber($available);

            $unuitizedAmount = $approvalAmount - ($internalAmount);
            $unutilizedamountArray[] = $unuitizedAmount;
            $unutilized_amt = formatnumber($unuitizedAmount);

            $nestedData = array();
            // $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['outward_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';

            $na_prog = $row['programme'];
            $na_budget = $row['master_name'];
            $programme = '';$programme_limit = '';
            
            if ($na_prog != $na) {
                $programme = $row['programme'];
				$programme_limit = strlen($programme) > 12 ? substr($programme, 0, 12) . "..." : $programme;
            }

            $donorname = '';$donorname_limit = '';
            if ($na_budget != $nb || ($na_prog != $na && $na_budget == $nb)) {
                $donorname = $row['master_name'];
				$donorname_limit = strlen($donorname) > 15 ? substr($donorname, 0, 15) . "..." : $donorname;
            }
            if ($row['grant_id'] != '') {
                $grant_id_set = $row['donor_id'] . '_' . $row['grant_id'] . '_' . $row['programme_id'];
            }
            $grant_name = '';
            if ($set_grantId != $row['donor_id'] . '_' . $row['grant_id'] . '_' . $row['programme_id']) {
                $grant_name = $row['grant_name'];
            }
            $edit_link = '';
            if ($set_grantIds != $row['donor_id'] . '_' . $row['grant_id'] . '_' . $row['programme_id']) {
                $edit_link = '<a href="' . base_url() . 'index.php/master/addMultipledonor/' . $row['programme_id'] . '/' . $row['donor_id'] . '/' . $row['grant_id'] . '" ><img src="' . base_url() . 'source/images/detail.png" border="20" height="20" / ></a>';
                $set_grantIds = $grant_id_set;
            }
            //$nestedData[] = $programme;
			$nestedData[] = '<a title="'.$programme.'">'.$programme_limit.'<a>';
            $nestedData[] = '<a title="'.$donorname.'">'.$donorname_limit.'<a>';
            $nestedData[] = $grant_name;
            $nestedData[] = $row['budget_head'];
            $nestedData[] = $row['line_item'];
//            $nestedData[] = $additional_info;
            $nestedData[] = $assign_amt;
            $nestedData[] = $approval_amt;
            $nestedData[] = $internal_amt;
            $nestedData[] = $recovered_amt;
            $nestedData[] = $available_amt;
            $nestedData[] = $unutilized_amt;
            $nestedData[] = $edit_link;

            $data[] = $nestedData;
            $i++;

            $na = $na_prog;
            $nb = $na_budget;
            $set_grantId = $grant_id_set;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function addMultipledonor($programmeid = '', $donorid = '', $grantid = '') {
        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $from = $cur_year . '-' . '04-01';
        $data['to'] = $to = date("Y-m-t", strtotime($next_year . '-' . '03'));
        $queryArray = array('to' => $to, 'from' => $from);
        $partner = $this->session->userdata('partner_id');

        $data['programme_edit'] = $programmeid;
        $data['donor_edit'] = $donorid;
        $data['grant_edit'] = $grantid;
        $data['balance'] = $balancedata = $this->Mmaster->getEditBalance($programmeid, $donorid, $grantid);

        $tot_budget = 0;
        foreach ($balancedata as $bllist) {
            $tot_budget += $bllist['amount'];
        }

        $data['tot_budget'] = $tot_budget;

        $data['programme'] = $this->Mmaster->getProgramme();

        if ($programmeid != '') {
            $pid = $programmeid;

            $prgmlist = $this->Mmaster->getProgramme('', $pid);

            $donor_programme = unserialize($prgmlist['0']['donor']);
            $donor_arr = implode(',', $donor_programme);
            $data['donors'] = $this->Mmaster->getDonorByProgramme($donor_arr, 'Donor');
        } else {
            $data['donors'] = $this->Mmaster->getMasterList($partner, 'Donor');
        }

        if ($donorid != '') {
            $data['budget_head'] = $this->Mmaster->getChildMasterList($donorid, 'Budget Head');

            $cond_arr[] = "funder_id ='" . $donorid . "'";

            if (count($cond_arr) > 0) {
                $result_cond = implode(' and ', $cond_arr);
            } else {
                $result_cond = '';
            }
            // $mtype = $_POST['m_type'];
            $data['grantlist'] = $grantlist = $this->Mmaster->getGrantByDonor($result_cond);
            $original_amt = $grantlist[0]['grant_amount'];

            $data['total_available_amt'] = $original_amt;
            // $ApprovalAmount = $this->Mmaster->checkApprovalNoteAmtManual($programmeid, $donorid, $grantlist[0]['id']);
            #echo'<pre>';print_r($ApprovalAmount);die;
            $ApprovalAmount = $this->Mmaster->checkApprovalNoteAmtManual('', $donorid, $grantlist[0]['id']);
            $original_amt = $ApprovalAmount;
            $data['projected_amt'] = $original_amt;
        } else {
            // $data['budget_head'] = $this->Mmaster->getMasterList($partner, 'Budget Head');
        }


		#echo $_SERVER['REMOTE_ADDR'];die;

        $data['master_type'] = 'Balance Sheet';
        #print_r($data);
        $this->load->vars($data);
        $this->load->view('masters/addmultipledonor');
    }

    public function DTBudgetamt() {
        $requestData = $_POST;

        if($_SERVER['REMOTE_ADDR']=='172.31.21.9'){
			#echo'<pre>';print_r($requestData);;die;
        }
        $columns = array(
            1 => 'budget_head',
            2 => 'line_item',
            3 => 'Subline_item'
        );

        $data['prgmedit_id'] = $prgmedit_id = (isset($_POST['old_programme'])) ? $_POST['old_programme'] : '';
        $data['donoredit_id'] = $donoredit_id = (isset($_POST['old_donor'])) ? $_POST['old_donor'] : '';
        $data['grantedit_id'] = $grantedit_id = (isset($_POST['old_grant'])) ? $_POST['old_grant'] : '';

        if ($prgmedit_id != '') {
            $cond_arr[] = "D1A.programme_id = '" . $prgmedit_id . "'";
        }

        if ($donoredit_id != '') {
            $cond_arr[] = "D1A.donor_id ='" . $donoredit_id . "'";
        }
        if ($grantedit_id != '') {
            $cond_arr[] = "D1A.grant_id ='" . $grantedit_id . "'";
        }


        if ($donoredit_id != '') {
            $budget_head = $this->Mmaster->getChildMasterList($donoredit_id, 'Budget Head');
        } else {
            $budget_head = $this->Mmaster->getMasterList($partner, 'Budget Head');
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');

        $option_list = '';

        $totalrows = $this->Mmaster->getDTEditbalanceCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTEditbalanceDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);
		//print_r($query);// die;
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            foreach ($budget_head as $list) {

                if ($list['master_id'] == $row['budget_id']) {
                    $select_pid = 'selected';
                } else {
                    $select_pid = '';
                }
                $option_list .= '<option value="' . $list['master_id'] . '" ' . $select_pid . '>' . $list['master_name'] . '</option>';
            }


            if ($row['budget_id'] != '') {
                $line_item = $this->Mmaster->getChildMasterList($row['budget_id'], 'Line Item');
            } else {
                $line_item = $this->Mmaster->getMasterList($partner, 'Line Item');
            }

            foreach ($line_item as $llist) {

                if ($llist['master_id'] == $row['line_itemid']) {
                    $select_lid = 'selected';
                } else {
                    $select_lid = '';
                }
                $optionline_list .= '<option value="' . $llist['master_id'] . '" ' . $select_lid . '>' . $llist['master_name'] . '</option>';
            }

            if ($row['line_itemid'] != '') {
                $subline_item = $this->Mmaster->getChildMasterList($row['line_itemid'], 'Cost Centre');
            } else {
                $subline_item = $this->Mmaster->getMasterList($partner, 'Cost Centre');
            }

            foreach ($subline_item as $slist) {

                if ($slist['master_id'] == $row['subline_itemid']) {
                    $select_sid = 'selected';
                } else {
                    $select_sid = '';
                }
                $optionsubline_list .= '<option value="' . $slist['master_id'] . '" ' . $select_sid . '>' . $slist['master_name'] . '</option>';
            }

            $nestedData = array();

            // $nestedData[] = '<input type="hidden" class="amountInput inline_field_' . $row['id'] . '"  disabled name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            /*  $nestedData[] = '<input type="hidden" class="amountInput inline_field_' . $row['id'] . '"  disabled name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['id'] . '">' . $i; */

            $nestedData[] = '<input type="hidden" name="edit_id[' . $i . ']" value="' . $row['id'] . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $row['id'] . '"> ';
            $nestedData[] = '<select class="form-control amountInput budget_head inline_field_' . $row['id'] . ' " onchange="getLineitem(' . $i . ', this.value)"  name="budget_head[]" id="budget_head_' . $i . '" disabled>
            <option value="">--Select--</option>' . $option_list . '</select><input type="hidden" name="old_BH[]" id="old_BH_' . $i . '" value="' . $row['budget_id'] . '" />';
            $nestedData[] = '<select class="form-control amountInput line_item inline_field_' . $row['id'] . ' " onchange="getSublineitem(' . $i . ', this.value)" name="line_item[]" id="line_item_' . $i . '" disabled>
            <option value="">--Select--</option>' . $optionline_list . '</select><input type="hidden" name="old_LI[]" id="old_LI_' . $i . '" value="' . $row['line_itemid'] . '" />';
            $nestedData[] = '<select class="form-control amountInput subline_item inline_field_' . $row['id'] . ' " name="subline_item[]" id="subline_item_' . $i . '"  disabled>
            <option value="">--Select--</option>' . $optionsubline_list . '</select><input type="hidden" name="old_SLI[]" id="old_SLI_' . $i . '" value="' . $row['subline_itemid'] . '" />';
            $nestedData[] = '<input type="text" class="form-control amountInput commonAlphaNum budget_amt inline_field_' . $row['id'] . '" onkeyup="sumTotal(this.value);" name="budget_amt[]" id="budget_amt_' . $i . '" disabled  value="' . formatnumber($row['amount']) . '"/><input type="hidden" name="old_amount[]" id="old_amount_' . $i . '" value="' . $row['amount'] . '" />';

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert donor multiple amount to db */

    public function insertlineitemAmount_old() {


        for ($i = 0; $i < count($_POST['budget_head']); $i++) {
            if ($_POST['budget_head'][$i] != '') {
                $option['id'] = $_POST['master_edit_id'][$i];
                $mas_data['budget_id'] = $_POST['budget_head'][$i];
                $mas_data['line_itemid'] = $_POST['line_item'][$i];
                $mas_data['subline_itemid'] = $_POST['subline_item'][$i];
                $mas_data['amount'] = str_replace(',', '', $_POST['budget_amt'][$i]);
                $mas_data['programme_id'] = $_POST['programme'];
                $mas_data['donor_id'] = $_POST['donor'];
                $mas_data['grant_id'] = $_POST['grant'];
                $mas_data['amount_date'] = date('Y-m-d', strtotime($_POST['amt_date']));


                $history_data['budget_id'] = $_POST['budget_head'][$i];
                $history_data['line_itemid'] = $_POST['line_item'][$i];
                $history_data['subline_itemid'] = $_POST['subline_item'][$i];
                $history_data['amount'] = str_replace(',', '', $_POST['budget_amt'][$i]);
                $history_data['programme_id'] = $_POST['programme'];

                $history_data['donor_id'] = $_POST['donor'];
                $history_data['grant_id'] = $_POST['grant'];
                $history_data['amount_date'] = date('Y-m-d', strtotime($_POST['amt_date']));
                $history_data['ipaddress'] = $_SERVER['REMOTE_ADDR'];

                // $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';

                $checkExist = $this->Mmaster->getMasterAisDetails('balance_amount', $option);

                if (count($checkExist) > 0) {
                    $history_data['operation'] = 'updation';
                    // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
                    $hm_query1 = $this->Mmaster->updateMasterDetail('balance_amount', $option, $mas_data);
                    $hm_query2 = $this->Mmaster->insertMasterDetail('masteramount_actionhistory', $history_data);

                    if (isset($_POST['reasonforchange'])) {
                        if (($_POST['programme'] != $_POST['old_programme']) || ($_POST['donor'] != $_POST['old_donor']) || ($_POST['budget_head'][$i] != $_POST['old_BH'][$i]) || ($_POST['line_item'][$i] != $_POST['old_LI'][$i]) || ($_POST['subline_item'][$i] != $_POST['old_SLI'][$i]) || ($_POST['amount'][$i] != $_POST['old_amount'][$i])) {
                            $change_balancesheet['programme_id'] = $_POST['programme'];
                            $change_balancesheet['donor_id'] = $_POST['donor'];
                            $change_balancesheet['budget_id'] = $_POST['budget_head'][$i];
                            $change_balancesheet['line_itemid'] = $_POST['line_item'][$i];
                            $change_balancesheet['subline_itemid'] = $_POST['subline_item'][$i];
                            $change_balancesheet['amount'] = str_replace(',', '', $_POST['budget_amt'][$i]);
                            $change_balancesheet['pre_programme_id'] = $_POST['old_programme'];
                            $change_balancesheet['pre_donor_id'] = $_POST['old_donor'];
                            $change_balancesheet['pre_budget_id'] = $_POST['old_BH'][$i];
                            $change_balancesheet['pre_line_itemid'] = $_POST['line_item'][$i];
                            $change_balancesheet['pre_subline_itemid'] = $_POST['old_SLI'][$i];
                            $change_balancesheet['pre_amount'] = $_POST['old_amount'][$i];
                            $change_balancesheet['reason'] = $_POST['reasonforchange'];
                            $change_balancesheet['ipaddress'] = $_SERVER['REMOTE_ADDR'];

                            /* echo'<pre>';print_r($_POST);
                            echo'<pre>';print_r($change_balancesheet);die; */
                            $hm_query3 = $this->Mmaster->insertMasterDetail('balance_sheet_edit_history', $change_balancesheet);
                        }
                    }
                } else {
                    #echo'<pre>';print_r($option);
                    #echo'<pre>';print_r($_POST);die;
                    $history_data['operation'] = 'Added';
                    // $jobspecdata['created_by'] = $this->session->userdata('emp_number');
                    $mas_data['added_date'] = date("Y-m-d H:i:s");
                    #echo'<pre>';print_r($mas_data);die;
                    #echo'<pre>';print_r($mas_data);die;
                    $hm_query1 = $this->Mmaster->insertMasterDetail('balance_amount', $mas_data);
                    $hm_query1 = $this->Mmaster->insertMasterDetail('masteramount_actionhistory', $history_data);
                }
            }
        }


        if ($hm_query1) {

            $this->session->set_flashdata('successMsg', "Donor amount details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/balance_sheet');
    }

    public function insertlineitemAmount() {


      $master_edit_count = count($_POST['master_edit_id']);
      $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';

      $editID_arr = array();
      $key_count = 0;
      foreach ($edit_id as $key => $row){
       $key_count++;
       $editID_arr[$key_count] = $row;
   }

   $edit_count = 1;
   for ($i = 0; $i < count($_POST['budget_head']); $i++) {
    if ($_POST['budget_head'][$i] != '') {
        $option['id'] = $_POST['master_edit_id'][$i];


        $mas_data['budget_id'] = $_POST['budget_head'][$i];
        $mas_data['line_itemid'] = $_POST['line_item'][$i];
        $mas_data['subline_itemid'] = $_POST['subline_item'][$i];
        $mas_data['amount'] = str_replace(',', '', $_POST['budget_amt'][$i]);
        $mas_data['programme_id'] = $_POST['programme'];
        $mas_data['donor_id'] = $_POST['donor'];
        $mas_data['grant_id'] = $_POST['grant'];
        $mas_data['amount_date'] = date('Y-m-d', strtotime($_POST['amt_date']));


        $history_data['budget_id'] = $_POST['budget_head'][$i];
        $history_data['line_itemid'] = $_POST['line_item'][$i];
        $history_data['subline_itemid'] = $_POST['subline_item'][$i];
        $history_data['amount'] = str_replace(',', '', $_POST['budget_amt'][$i]);
        $history_data['programme_id'] = $_POST['programme'];

        $history_data['donor_id'] = $_POST['donor'];
        $history_data['grant_id'] = $_POST['grant'];
        $history_data['amount_date'] = date('Y-m-d', strtotime($_POST['amt_date']));
        $history_data['ipaddress'] = $_SERVER['REMOTE_ADDR'];

                #$edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';



        $checkExist = $this->Mmaster->getMasterAisDetails('balance_amount', $option);
        /* echo'<pre>';print_r($_POST);echo'===';echo'<pre>';print_r($checkExist);die; */
        if (count($checkExist) > 0) {
            $history_data['operation'] = 'updation';
                    // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query1 = $this->Mmaster->updateMasterDetail('balance_amount', $option, $mas_data);
            $hm_query2 = $this->Mmaster->insertMasterDetail('masteramount_actionhistory', $history_data);

            if (isset($_POST['reasonforchange'])) {
                if (($_POST['programme'] != $_POST['old_programme']) || ($_POST['donor'] != $_POST['old_donor']) || ($_POST['budget_head'][$i] != $_POST['old_BH'][$i]) || ($_POST['line_item'][$i] != $_POST['old_LI'][$i]) || ($_POST['subline_item'][$i] != $_POST['old_SLI'][$i]) || ($_POST['amount'][$i] != $_POST['old_amount'][$i])) {
                    $change_balancesheet['programme_id'] = $_POST['programme'];
                    $change_balancesheet['donor_id'] = $_POST['donor'];
                    $change_balancesheet['budget_id'] = $_POST['budget_head'][$i];
                    $change_balancesheet['line_itemid'] = $_POST['line_item'][$i];
                    $change_balancesheet['subline_itemid'] = $_POST['subline_item'][$i];
                    $change_balancesheet['amount'] = str_replace(',', '', $_POST['budget_amt'][$i]);
                    $change_balancesheet['pre_programme_id'] = $_POST['old_programme'];
                    $change_balancesheet['pre_donor_id'] = $_POST['old_donor'];
                    $change_balancesheet['pre_budget_id'] = $_POST['old_BH'][$i];
                    $change_balancesheet['pre_line_itemid'] = $_POST['line_item'][$i];
                    $change_balancesheet['pre_subline_itemid'] = $_POST['old_SLI'][$i];
                    $change_balancesheet['pre_amount'] = $_POST['old_amount'][$i];
                    $change_balancesheet['reason'] = $_POST['reasonforchange'];
                    $change_balancesheet['ipaddress'] = $_SERVER['REMOTE_ADDR'];

                            /* echo'<pre>';print_r($_POST);
                            echo'<pre>';print_r($change_balancesheet);die; */
                            $hm_query3 = $this->Mmaster->insertMasterDetail('balance_sheet_edit_history', $change_balancesheet);
                        }
                    }
                } else {  

                    $history_data['operation'] = 'Added';
                    // $jobspecdata['created_by'] = $this->session->userdata('emp_number');
                    $mas_data['added_date'] = date("Y-m-d H:i:s");

                    $options  = array();
                    if($_POST['master_edit_id'][$i]!=''){
						#echo'insert';echo'<br>';echo'<pre>';print_r($mas_data);
                      $this->Mmaster->insertMasterDetail('balance_amount', $mas_data);
                      $this->Mmaster->insertMasterDetail('masteramount_actionhistory', $history_data);
                  }else{
                      $mas_data1['budget_id'] = $_POST['budget_head'][$i];
                      $mas_data1['line_itemid'] = $_POST['line_item'][$i];
                      $mas_data1['subline_itemid'] = $_POST['subline_item'][$i];
                      $mas_data1['amount'] = str_replace(',', '', $_POST['budget_amt'][$i]);
                      $mas_data1['programme_id'] = $_POST['programme'];
                      $mas_data1['donor_id'] = $_POST['donor'];
                      $mas_data1['grant_id'] = $_POST['grant'];
                      $mas_data1['amount_date'] = date('Y-m-d', strtotime($_POST['amt_date']));

                      $history_data1['budget_id'] = $_POST['budget_head'][$i];
                      $history_data1['line_itemid'] = $_POST['line_item'][$i];
                      $history_data1['subline_itemid'] = $_POST['subline_item'][$i];
                      $history_data1['amount'] = str_replace(',', '', $_POST['budget_amt'][$i]);
                      $history_data1['programme_id'] = $_POST['programme'];

                      $history_data1['donor_id'] = $_POST['donor'];
                      $history_data1['grant_id'] = $_POST['grant'];
                      $history_data1['amount_date'] = date('Y-m-d', strtotime($_POST['amt_date']));
                      $history_data1['ipaddress'] = $_SERVER['REMOTE_ADDR'];
                      $history_data1['operation'] = 'updation';



                      if($editID_arr[$edit_count] !=''){
                       $options['id'] = $editID_arr[$edit_count];

                       if($_SERVER['REMOTE_ADDR']=='172.31.45.7'){

                       }
							/* echo'<pre>';print_r($_POST);echo'===';
								echo'<pre>';print_r($options);echo'===';
								echo'<pre>';print_r($mas_data1);die;
							 */
                               $this->Mmaster->updateMasterDetail('balance_amount', $options, $mas_data1);
                               $this->Mmaster->insertMasterDetail('masteramount_actionhistory', $history_data1);
                           } 

						#echo $edit_count;
                           $edit_count++;
                       }

                   }
               }
           }

           if ($hm_query1) {
            $this->session->set_flashdata('successMsg', "Donor amount details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/balance_sheet');
    }

    /* donor amount */

    public function donorAmountlist($donorid = '') {
        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $from = $cur_year . '-' . '04-01';
        $data['to'] = $to = date("Y-m-t", strtotime($next_year . '-' . '03'));
        $queryArray = array('to' => $to, 'from' => $from);
        $wher = 'Donor';
        $data['donor_id'] = $donorid;
        $data['master_type'] = 'Balance Sheet';
        // print_r($data['listDonor']);
        $this->load->vars($data);
        $this->load->view('masters/donoramountlist');
    }

    public function addDonorAmount($donorid = '') {

        $data['donor_id'] = $donorid;

        $partner = $this->session->userdata('partner_id');
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Donor');
        if ($donorid != '') {
            $data['edit_id'] = $donorid;
            $data['donoramount'] = $donoramount = $this->Mmaster->getDonoramounts($donorid);
        }
        $donor_amt = $this->numberToCurrency($donoramount[0]['amount']);
        $data['donor_amt'] = $donor_amt;
        $data['master_type'] = 'Balance Sheet';
        // print_r($data['donoramount']);
        // die;
        $this->load->vars($data);
        $this->load->view('masters/adddonoramount');
    }

    public function numberToCurrency($num, $type = '') { #echo $num;die;
        $RES = explode('.', $num);
        $num = $RES[0];
        $digit = '';
        if ($RES[1] > 0) {
            $digit = '.' . $RES[1];
        }
        if ($type == 'view') {
            $digit = '.' . $RES[1];
        }
        if (setlocale(LC_MONETARY, 'en_IN'))
            return money_format('%.0n', $num);
        else {
            $explrestunits = "";
            if (strlen($num) > 3) {
                $lastthree = substr($num, strlen($num) - 3, strlen($num));
                $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
                $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);
                for ($i = 0; $i < sizeof($expunit); $i++) {
                    // creates each of the 2's group and adds a comma to the end
                    if ($i == 0) {
                        $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
                    } else {
                        $explrestunits .= $expunit[$i] . ",";
                    }
                }
                $thecash = $explrestunits . $lastthree . $digit;
            } else {
                $thecash = $num . $digit;
            }
            return '' . $thecash;
        }
    }

    public function donorAmountHistory() {
        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $from = $cur_year . '-' . '04-01';
        $data['to'] = $to = date("Y-m-t", strtotime($next_year . '-' . '03'));
        $partner = $this->session->userdata('partner_id');

        if ($from != '') {
            $amt_fromdate = date('Y-m-d', strtotime($from));
            $cond_arr[] = "t2.amount_date >= '" . $amt_fromdate . "'";
        }

        if ($to != '') {
            $amt_todate = date('Y-m-d', strtotime($to));
            $cond_arr[] = "t2.amount_date <= '" . $amt_todate . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $data['history_action'] = $this->Mmaster->getDonorhistory($result_cond);
        $data['master_type'] = 'Balance Sheet';
        // print_r($data['listDonor']);
        $this->load->vars($data);
        $this->load->view('masters/donor_history');
    }

    public function DTDonoramount() {
        $requestData = $_POST;
        if (isset($_POST['donor_id']) && $_POST['donor_id'] != '') {
            $columns = array(
                1 => 't1.master_name',
                2 => 't2.amount',
                3 => 't2.amount_date'
            );
        } else {
            $columns = array(
                1 => 't1.master_name',
                2 => 't2.amount',
            );
        }


        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $fromperiod = $cur_year . '-' . '04-01';
        $data['to'] = $toperiod = date("Y-m-t", strtotime($next_year . '-' . '03'));
        $partner = $this->session->userdata('partner_id');
        $data['donor_id'] = $donor_id = (isset($_POST['donor_id'])) ? $_POST['donor_id'] : '';
        $data['from_year'] = $from_year = (isset($_POST['from_year'])) && $_POST['from_year'] != '' ? $_POST['from_year'] : $fromperiod;
        $data['from_to'] = $from_to = (isset($_POST['from_to'])) && $_POST['from_to'] != '' ? $_POST['from_to'] : $toperiod;

        if ($donor_id != '') {
            $bydonor = 1;
            $cond_arr[] = "t2.donor_id = '" . $donor_id . "'";
        } else {
            $bydonor = '';
        }

        if ($from_year != '') {
            $amt_fromdate = date('Y-m-d', strtotime($from_year));
            $cond_arr[] = "t2.amount_date >= '" . $amt_fromdate . "'";
        }

        if ($from_to != '') {
            $amt_todate = date('Y-m-d', strtotime($from_to));
            $cond_arr[] = "t2.amount_date <= '" . $amt_todate . "'";
        }

        $cond_arr[] = "t2.partner_id = '" . $partner . "'";
        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }



        $totalrows = $this->Mmaster->getDTDonoramtCount($result_cond, $columns, $requestData, $bydonor);
        $query = $this->Mmaster->getDTDonoramtDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData, $bydonor);

        // print_r($totalrows);
        // die;
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['master_name'];
            $nestedData[] = number_format($row['amount']);

            if (isset($_POST['donor_id']) && $_POST['donor_id'] != '') {

                $nestedData[] = date('d-m-Y', strtotime($row['amount_date']));
                $nestedData[] = '<a href="' . base_url() . 'index.php/master/addDonorAmount/' . $row['id'] . '" ><img src="' . base_url() . 'source/images/detail.png" border="20" height="20" / ></a>';
            } else {
                $nestedData[] = '<a href="' . base_url() . 'index.php/master/donorAmountlist/' . $row['donor_id'] . '" ><img src="' . base_url() . 'source/images/detail.png" border="20" height="20" / ></a>';
            }

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* insert donor amount to db */

    public function insertdonorAmount() {
// print_r($_POST);
// die;
        $partner = $this->session->userdata('partner_id');
        $option['id'] = $_POST['edit_id'];
        $mas_data['donor_id'] = $_POST['donor'];
        $mas_data['partner_id'] = $partner;
        $mas_data['amount'] = str_replace(',', '', $_POST['donor_amt']);
        $mas_data['amount_date'] = date('Y-m-d', strtotime($_POST['amt_date']));


        $history_data['amount'] = $_POST['donor_amt'];
        $history_data['donor_id'] = $_POST['donor'];
        $history_data['amount_date'] = date('Y-m-d', strtotime($_POST['amt_date']));
        $history_data['ipaddress'] = $_SERVER['REMOTE_ADDR'];

        if ($_POST['edit_id'] != '') {
            // $jobspecdata['updated_by'] = $this->session->userdata('emp_number');
            $hm_query1 = $this->Mmaster->updateMasterDetail('donors_amount', $option, $mas_data);
            $hm_query2 = $this->Mmaster->insertMasterDetail('donoramount_actionhistory', $history_data);
        } else {
            $hm_query1 = $this->Mmaster->insertMasterDetail('donors_amount', $mas_data);
            $hm_query2 = $this->Mmaster->insertMasterDetail('donoramount_actionhistory', $history_data);
        }


        if ($hm_query1) {

            $this->session->set_flashdata('successMsg', "Donor amount details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('master/donorAmountlist');
    }

    public function balance_report() {
        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $from = $cur_year . '-' . '04-01';
        $data['to'] = $to = date("Y-m-t", strtotime($next_year . '-' . '03'));
        $queryArray = array('to' => $to, 'from' => $from);
        $wher = 'Donor';
        $data['listDonor'] = $this->Mmaster->getBalance($report_nam, $queryArray, $wher);
        $data['master_type'] = 'Balance Sheet';

        $data['programme'] = $this->Mmaster->getProgramme();
        $data['donors'] = $this->Mmaster->getMasterList($partner, 'Donor');
        $data['budget_head'] = $this->Mmaster->getMasterList($partner, 'Budget Head');
        $data['line_item'] = $this->Mmaster->getMasterList($partner, 'Line Item');
        // print_r($data['listDonor']);
        $this->load->vars($data);
        $this->load->view('masters/balance_sheet_report');
    }

    public function DTBalanceReport() {
        $requestData = $_POST;

        $columns = array(
            0 => 'MP.programme',
            1 => 'D.master_name',
            2 => 'grant_name',
            3 => 'budget_head',
            4 => 'line_item'
        );


        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $fromperiod = $cur_year . '-' . '04-01';
        $data['to'] = $toperiod = date("Y-m-t", strtotime($next_year . '-' . '03'));

        $data['donorid'] = $donorid = (isset($_POST['donorid'])) ? $_POST['donorid'] : '';
        $data['master_type'] = $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        $data['from_year'] = $from_year = (isset($_POST['from_year'])) && $_POST['from_year'] != '' ? $_POST['from_year'] . '-' . '04-01' : $fromperiod;
        $data['from_to'] = $from_to = (isset($_POST['from_to'])) && $_POST['from_to'] != '' ? $_POST['from_to'] . '-' . '03-31' : $toperiod;
        $data['programme_search'] = $programme_search = (isset($_POST['programme_search'])) ? $_POST['programme_search'] : '';
        $data['grant_search'] = $grant_search = (isset($_POST['grant_search'])) ? $_POST['grant_search'] : '';
        $data['donor_search'] = $donor_search = (isset($_POST['donor_search'])) ? $_POST['donor_search'] : '';
        $data['budget_search'] = $budget_search = (isset($_POST['budget_search'])) ? $_POST['budget_search'] : '';
        $data['lineitem_search'] = $lineitem_search = (isset($_POST['lineitem_search'])) ? $_POST['lineitem_search'] : '';
        $data['costcenter_search'] = $costcenter_search = (isset($_POST['costcenter_search'])) ? $_POST['costcenter_search'] : '';

        $cond_arr[] = "MP.partner_id = '" . $this->session->userdata('partner_id') . "'";

        if ($donorid != '') {
            $cond_arr[] = "D1A.donor_id = '" . $donorid . "'";
        }
        if ($master_type != '') {
            $cond_arr[] = "D.master_type = '" . $master_type . "'";
        }

        if ($from_year != '') {
            $amt_fromdate = date('Y-m-d', strtotime($from_year));
            $cond_arr[] = "D1A.amount_date >= '" . $amt_fromdate . "'";
        }

        if ($from_to != '') {
            $amt_todate = date('Y-m-d', strtotime($from_to));
            $cond_arr[] = "D1A.amount_date <= '" . $amt_todate . "'";
        }

        if ($programme_search != '') {
            $cond_arr[] = "D1A.programme_id = '" . $programme_search . "'";
        }
        if ($donor_search != '') {
            $cond_arr[] = "D1A.donor_id = '" . $donor_search . "'";
        }
        if ($budget_search != '') {
            $cond_arr[] = "D1A.budget_id = '" . $budget_search . "'";
        }
        if ($lineitem_search != '') {
            $cond_arr[] = "D1A.line_itemid = '" . $lineitem_search . "'";
        }
        if ($costcenter_search != '') {
            $cond_arr[] = "D1A.subline_itemid = '" . $costcenter_search . "'";
        }
        if ($grant_search != '') {
            $cond_arr[] = "D1A.grant_id = '" . $grant_search . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');

        $totalrows = $this->Mmaster->getDTBalanceCount($result_cond, $columns, $requestData);
        $query = $this->Mmaster->getDTBalanceDetails($requestData['length'], $requestData['start'], $result_cond, $columns, $requestData);

        // print_r($totalrows);
        // die;
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {

            $assignAmountArray[] = $row['amount'];
            $assign_amt = formatnumber($row['amount']);

            $add_info_value = $this->Mmaster->getAdditionalInfo($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid']);
            $additional_info = $add_info_value['add_info_value'];

            $approvalAmount = $this->Mmaster->checkApprovalNoteAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
            $approvalAmount = ($approvalAmount != '') ? round($approvalAmount, 2) : $approvalAmount;
            $approvalAmountArray[] = $approvalAmount;
            $approval_amt = formatnumber($approvalAmount);

            $internalAmount = $this->Mmaster->checkInternalAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
            $internalAmount = ($internalAmount != '') ? round($internalAmount, 2) : $internalAmount;
            $internalAmountArray[] = $internalAmount;
            $internal_amt = formatnumber($internalAmount);

            $recovered_amount = $this->Mmaster->checkRecoveredAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
            $recoveredAmountArray[] = $recovered_amount;
            $recovered_amt = formatnumber($recovered_amount);

            $available = ($row['amount'] - ($approvalAmount)) + $recovered_amount;
            $availbleAmountArray[] = $available;
            $available_amt = formatnumber($available);

            $unuitizedAmount = $approvalAmount - ($internalAmount);
            $unutilizedamountArray[] = $unuitizedAmount;
            $unutilized_amt = formatnumber($unuitizedAmount);

            $nestedData = array();
            // $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['outward_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            $nestedData[] = $row['programme'];
            $nestedData[] = $row['master_name'];
            $nestedData[] = $row['grant_name'];
            $nestedData[] = $row['budget_head'];
            $nestedData[] = $row['line_item'];
            $nestedData[] = $assign_amt;
            $nestedData[] = $approval_amt;
            $nestedData[] = $internal_amt;
            $nestedData[] = $available_amt;
            $nestedData[] = $unutilized_amt;

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* No due certificate */

    public function nodue_certificate($employee = '') {
        $data['certificate'] = 'no';
        $data['download'] = 'no';
        $data['userList'] = $this->Mmaster->getAllUserList();

        if (isset($_POST['generate'])) {
            $data['certificate'] = 'yes';
            if ($_POST['employee_id'] != '') {
                $data['username'] = $username = $this->Mmaster->getUserNameInfo($_POST['employee_id']);
                $data['employee_id'] = $_POST['employee_id'];
                $data['library_dues'] = $this->Mmaster->getLibraryDues($_POST['employee_id']);
                $data['asset_dues'] = $this->Mmaster->getAssetDues($_POST['employee_id']);
                // print_r($data['asset_dues']);
                // die;
            }
            if (isset($_POST['txtsave'])) {
                $data['formaction'] = base_url() . 'index.php/master/print_duecertificate';
                $data['download'] = 'yes';
                $data['description'] = (isset($_POST['description'])) ? $_POST['description'] : array();
                $data['details'] = $_POST['details'];
                $data['obtain'] = $_POST['obtain'];
                $data['remarks'] = $_POST['remarks'];
            }
        }
        $this->load->vars($data);
        $this->load->view('masters/nodue_certificate');
    }

    public function print_duecertificate() {

        $data['username'] = $username = $this->Mmaster->getUserNameInfo($_POST['employee_id']);
        $data['employee_id'] = $_POST['employee_id'];
        $data['description'] = (isset($_POST['description'])) ? $_POST['description'] : array();
        $data['details'] = $_POST['details'];
        $data['obtain'] = $_POST['obtain'];
        $data['remarks'] = $_POST['remarks'];

        $this->load->view('masters/pdf_duecertificate', $data);
        $pdfName = $username[0]['user_name'] . '_Nodue_Certificate';
        $html = $this->output->get_output();
        #echo'<pre>';print_r($html);die;
        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->set_option('isRemoteEnabled', TRUE);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream($pdfName, array("Attachment" => 1));
    }

    /* print option */

    public function print_balance_pdf() {

        $print_amt = (isset($_POST['print_amt'])) ? $_POST['print_amt'] : '';
        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $fromperiod = $cur_year . '-' . '04-01';
        $data['to'] = $toperiod = date("Y-m-t", strtotime($next_year . '-' . '03'));


        $data['from_year'] = $from_year = (isset($_POST['from_year'])) && $_POST['from_year'] != '' ? $_POST['from_year'] . '-' . '04-01' : $fromperiod;
        $data['from_to'] = $from_to = (isset($_POST['from_to'])) && $_POST['from_to'] != '' ? $_POST['from_to'] . '-' . '03-31' : $toperiod;
        $data['programme_search'] = $programme_search = (isset($_POST['programme_search'])) ? $_POST['programme_search'] : '';
        $data['grant_search'] = $grant_search = (isset($_POST['grant_search'])) ? $_POST['grant_search'] : '';
        $data['donor_search'] = $donor_search = (isset($_POST['donor_search'])) ? $_POST['donor_search'] : '';
        $data['budget_search'] = $budget_search = (isset($_POST['budget_search'])) ? $_POST['budget_search'] : '';
        $data['lineitem_search'] = $lineitem_search = (isset($_POST['lineitem_search'])) ? $_POST['lineitem_search'] : '';
        $data['costcenter_search'] = $costcenter_search = (isset($_POST['costcenter_search'])) ? $_POST['costcenter_search'] : '';

        $cond_arr[] = "MP.partner_id = '" . $this->session->userdata('partner_id') . "'";

        if ($from_year != '') {
            $amt_fromdate = date('Y-m-d', strtotime($from_year));
            $cond_arr[] = "D1A.amount_date >= '" . $amt_fromdate . "'";
        }

        if ($from_to != '') {
            $amt_todate = date('Y-m-d', strtotime($from_to));
            $cond_arr[] = "D1A.amount_date <= '" . $amt_todate . "'";
        }

        // if ($programme_search != '') {
        //     $cond_arr[] = "MP.programme LIKE '%" . $programme_search . "%'";
        // }
        // if ($programme_search != '') {
        //     $cond_arr[] = "D1A.programme_id = '" . $programme_search . "'";
        // }
        if ($programme_search != '') {
            $cond_arr[] = "D1A.programme_id = '" . $programme_search . "' OR MP.programme LIKE '%" . $programme_search . "%'";
        }
        if ($donor_search != '') {
            $cond_arr[] = "D1A.donor_id = '" . $donor_search . "'";
        }
        if ($budget_search != '') {
            $cond_arr[] = "D1A.budget_id = '" . $budget_search . "'";
        }
        if ($lineitem_search != '') {
            $cond_arr[] = "D1A.line_itemid = '" . $lineitem_search . "'";
        }
        if ($costcenter_search != '') {
            $cond_arr[] = "D1A.subline_itemid = '" . $costcenter_search . "'";
        }
        if ($grant_search != '') {
            $cond_arr[] = "D1A.grant_id = '" . $grant_search . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $partner = $this->session->userdata('partner_id');

        $data['query'] = $this->Mmaster->printBalanceDetails($result_cond);

        $data['print_amt'] = $print_amt;

        return $this->load->view('masters/print_balance', $data);
        // print_r($query);
    }

    public function print_asset_pdf($tab) {
        $data['tab'] = $tab = (isset($_POST['tab'])) && $_POST['tab'] != '' ? $_POST['tab'] : '';
        $data['assetlist'] = $this->Mmaster->getAssetDetails($tab);
        return $this->load->view('masters/print_asset', $data);
    }

    public function print_books_pdf() {
        $data['booklist'] = $this->Mmaster->getBooksList();
        return $this->load->view('masters/print_book', $data);
    }

    public function print_visitor_pdf() {
        $data['visitorsList'] = $this->Mmaster->getVisitorsList();
        return $this->load->view('masters/print_visitor', $data);
    }

    public function print_inward_pdf() {
        $data['tab'] = $tab = (isset($_POST['tab'])) && $_POST['tab'] != '' ? $_POST['tab'] : '';
        $data['inwardList'] = $this->Mmaster->getInwardList('', $tab);
        return $this->load->view('masters/print_inward', $data);
    }

    public function print_outward_pdf() {
        $data['tab'] = $tab = (isset($_POST['tab'])) && $_POST['tab'] != '' ? $_POST['tab'] : '';
        $data['outwardList'] = $this->Mmaster->getOutwardList('', $tab);
        return $this->load->view('masters/print_outward', $data);
    }

    function asset_export($tab) {
        $export_type = $this->uri->segment(3);

        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("Documents Master List")
        ->setSubject("Documents Master List")
        ->setDescription("Documents Master List")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Documents Master List");

        $styletitle = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
        );

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'S.No');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Asset Type');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Asset Number');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Asset Name');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Asset Code');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Brand Name');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Description');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Model');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Serial Number');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Purchase Date');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Price');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Bill Number');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Bill Date');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Warranty');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Vendor');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'AMC');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'AMC Vendor');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', 'AMC Period');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', 'Available Status');
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);



        $type = (isset($_POST['type'])) ? $_POST['type'] : '';
        $type_search = (isset($_POST['type_search'])) ? $_POST['type_search'] : '';
        $asset_name = (isset($_POST['asset_name'])) ? $_POST['asset_name'] : '';
        $asset_number = (isset($_POST['asset_number'])) ? $_POST['asset_number'] : '';
        $asset_code = (isset($_POST['asset_code'])) ? $_POST['asset_code'] : '';
        $purchase_date = (isset($_POST['purchase_date'])) ? $_POST['purchase_date'] : '';
        $purchaseto_date = (isset($_POST['purchaseto_date'])) ? $_POST['purchaseto_date'] : '';
        $reason_search = (isset($_POST['reason_search'])) ? $_POST['reason_search'] : '';
        if ($type_search != '') {
            $cond_arr[] = "t1.asset_type ='" . $type_search . "'";
        }

        if ($asset_name != '') {
            $cond_arr[] = "t1.asset_name LIKE '%" . $asset_name . "%'";
        }
        if ($asset_number != '') {
            $cond_arr[] = "t1.asset_no LIKE '%" . $asset_number . "%'";
        }
        if ($asset_code != '') {
            $cond_arr[] = "t1.asset_code LIKE '%" . $asset_code . "%'";
        }
        if ($purchase_date != '' && $purchaseto_date != '') {
            $cond_arr[] = "t1.purchase_date >= '" . $purchase_date . "' and t1.purchase_date <= '" . $purchaseto_date . "'";
        }
        if ($reason_search != '') {
            $cond_arr[] = "t1.ina_reason LIKE '%" . $reason_search . "%'";
        }

        if ($type != '') {
            $cond_arr[] = "t1.type  ='" . $type . "'";
        }


        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        /* if ($search_field != '') {
          $this->ais->where($search_field);
      } */

      $assetlist = $this->Mmaster->getAssetDetails($tab, '', $result_cond, $export_type);
        #echo'<pre>';print_r($assetlist);die;
        #echo'<pre>';print_r($assetlist);die;
      $i = 2;
      foreach ($assetlist as $list) {

        if (is_numeric($list['serial_no']))
            $column = $list['serial_no'];
        $purchase_date = date('d-m-Y', strtotime($list['purchase_date']));
        if ($list['purchase_date'] == '0000-00-00')
            $purchase_date = '';
        $bill_date = date('d-m-Y', strtotime($list['bill_date']));
        if ($list['bill_date'] == '0000-00-00 00:00:00' || $list['bill_date'] == '01-01-1970  00:00:00')
            $bill_date = '';
        $warrenty_expiry_date = date('d-m-Y', strtotime($list['warrenty_expiry_date']));
        if ($list['warrenty_expiry_date'] == '0000-00-00')
            $warrenty_expiry_date = '';
        $AMC_period = date('d-m-Y', strtotime($list['AMC_period']));
        if ($list['AMC_period'] == '0000-00-00')
            $AMC_period = '';


        if ($list['available_status'] == 1) {
            $avail_status = 'Available';
        } else if ($list['available_status'] == 0) {
            $avail_status = 'Unavailable';
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $list['asset_id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $list['master_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $list['asset_no']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $list['asset_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $list['asset_code']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $list['brand_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $list['description']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $list['model']);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I' . $i, $column, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $purchase_date);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $list['price']);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('L' . $i, $list['bill_no'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $bill_date);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $warrenty_expiry_date);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $list['vendor_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $list['AMC']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $list['AMC_vendor']);
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $AMC_period);
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $avail_status);
        $i++;
    }

    $file_name = 'general_asset.xlsx';
    if ($export_type == 'it') {
        $file_name = 'it_asset.xlsx';
    }

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file_name . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');

    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    $objWriter->save('php://output');
    exit;
}

/* vendor export */

function vendor_export() {
    $this->load->library('Excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Villgro")
    ->setLastModifiedBy("Villgro")
    ->setTitle("Documents Master List")
    ->setSubject("Documents Master List")
    ->setDescription("Documents Master List")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Documents Master List");

    $styletitle = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '000000'),
            'size' => 11,
            'name' => 'Times New Roman',
        ),
    );

    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'S.No');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Vendor Name');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Email');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Contact Person');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Company Address');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Contact Number');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Website');
    $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);


    $contact_person = (isset($_POST['contact_person'])) ? $_POST['contact_person'] : '';
    $vendor_name = (isset($_POST['vendor_name'])) ? $_POST['vendor_name'] : '';

    if ($contact_person != '') {
        $cond_arr[] = "contact_person LIKE '%" . $contact_person . "%'";
    }

    if ($vendor_name != '') {
        $cond_arr[] = "vendor_name LIKE '%" . $vendor_name . "%'";
    }

    if (count($cond_arr) > 0) {
        $result_cond = implode(' and ', $cond_arr);
    } else {
        $result_cond = '';
    }

    $vendorlist = $this->Mmaster->getVendorsList('', $result_cond);
    $i = 2;
    foreach ($vendorlist as $list) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i - 1);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $list['vendor_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $list['vendor_email']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $list['contact_person']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $list['address']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $list['contact_no']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $list['website']);
        $i++;
    }

    $file_name = 'vendor_master.xlsx';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file_name . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');

    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    $objWriter->save('php://output');
    exit;
}

/* books export */

function books_export() {
    $this->load->library('Excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Villgro")
    ->setLastModifiedBy("Villgro")
    ->setTitle("Documents Master List")
    ->setSubject("Documents Master List")
    ->setDescription("Documents Master List")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Documents Master List");

    $styletitle = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '000000'),
            'size' => 11,
            'name' => 'Times New Roman',
        ),
    );

    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'S.No');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Category Name');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Book Number');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Book Name');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Author');
    $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);


    $books_category = (isset($_POST['books_category'])) ? $_POST['books_category'] : '';
    $books_name = (isset($_POST['books_name'])) ? $_POST['books_name'] : '';
    $author = (isset($_POST['author'])) ? $_POST['author'] : '';

    if ($books_category != '') {
        $cond_arr[] = "t1.master_id = " . $books_category . "";
    }
    if ($books_name != '') {
        $cond_arr[] = "book_name LIKE '%" . $books_name . "%'";
    }
    if ($author != '') {
        $cond_arr[] = "author LIKE '%" . $author . "%'";
    }
    if (count($cond_arr) > 0) {
        $result_cond = implode(' and ', $cond_arr);
    } else {
        $result_cond = '';
    }
        $booklist = $this->Mmaster->getBooksList('', $result_cond); #echo'<pre>';print_r($booklist);die;

        $i = 2;
        $count = 1;
        foreach ($booklist as $list) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $count);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $list['master_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $list['book_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $list['book_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $list['author']);
            $i++;
            $count++;
        }

        $file_name = 'books_master.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

    /* visitor's log export */

    function visitor_export() {

        $export_type = (isset($_POST['export_type'])) ? $_POST['export_type'] : '';
        #echo'<pre>';print_r($_POST);die;

        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("Documents Master List")
        ->setSubject("Documents Master List")
        ->setDescription("Documents Master List")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Documents Master List");

        $styletitle = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
        );

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);

        if ($export_type == 2) {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Name Of Visitor');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Innovation');
            $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Date');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name Of Visitor');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Name Of Organization');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Intending To Meet');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Purpose');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Time In');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Time Out');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Innovation');
            $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);
        }



        $data['userid'] = $userid = (isset($_POST['userid'])) ? $_POST['userid'] : '';
        $data['date_search'] = $date_search = (isset($_POST['date_search'])) ? $_POST['date_search'] : '';
        $data['month_search'] = $month_search = (isset($_POST['month_search'])) ? $_POST['month_search'] : '';
        $data['year_search'] = $year_search = (isset($_POST['year_search'])) ? $_POST['year_search'] : '';

        if ($userid != '') {
            $cond_arr[] = "t1.intending_to_meet ='" . $userid . "'";
        }

        if ($date_search != '') {
            $cond_arr[] = "t1.date = '" . $date_search . "'";
        }

        if ($month_search != '') {
            $cond_arr[] = "MONTH(t1.date) = '" . $month_search . "'";
        }
        if ($year_search != '') {
            $cond_arr[] = "YEAR(t1.date) = '" . $year_search . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }

        $visitorsList = $this->Mmaster->getVisitorsList('', $result_cond);
        
        $i = 2;
        foreach ($visitorsList as $list) {

            if ($export_type == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $list['name_of_visitor']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $list['innovation']);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, date('d-m-Y', strtotime($list['date'])));
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $list['name_of_visitor']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $list['name_of_organization']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $list['user_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $list['purpose']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $list['time_in']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $list['time_out']);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $list['innovation']);
            }
            $i++;
        }
        $file_name = 'visitorslog.xlsx';
        if ($export_type == 2) {
            $file_name = 'visitors_innovation.xlsx';
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

    /* dispatch inward export */

    function inward_export($tab) {

        $tab = $this->uri->segment(3);

        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("Documents Master List")
        ->setSubject("Documents Master List")
        ->setDescription("Documents Master List")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Documents Master List");

        $styletitle = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
        );

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'SNo');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Employee');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Received Date');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', "Person's Name");
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "Company's Name");
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Content');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Vendor');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Status');
        if ($tab == 'confirmed') {
            $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Handover To');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Handover Date');
        }
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);



        $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        $emp_search = (isset($_POST['emp_search'])) ? $_POST['emp_search'] : '';
        $handover_from = (isset($_POST['handover_from'])) ? $_POST['handover_from'] : '';
        $handover_to = (isset($_POST['handover_to'])) ? $_POST['handover_to'] : '';

        if ($emp_search != '') {
            $cond_arr[] = "t1.employee_id = '" . $emp_search . "'";
        }

        if ($handover_from != '') {
            $cond_arr[] = "handover_date >= '" . $handover_from . "'";
        }

        if ($handover_to != '') {
            $cond_arr[] = "handover_date <= '" . $handover_to . "'";
        }
        if ($master_type != '') {
            $cond_arr[] = "t1.status = '" . $master_type . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $inwardList = $this->Mmaster->getInwardList('', $tab, $result_cond);
        $i = 2;
        foreach ($inwardList as $list) {

            $username = $this->Mmaster->getUserNameInfo($list['employee_id']);
            if ($tab == 'confirmed') {
                $handoverto = $this->Mmaster->getUserNameInfo($list['handover_to']);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $username[0]['user_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, date('d-m-Y', strtotime($list['received_date'])));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $list['person_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $list['company_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $list['content']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $list['vendor']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $list['status']);
            if ($tab == 'confirmed') {
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $handoverto[0]['user_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, date('d-m-Y', strtotime($list['handover_date'])));
            }
            $i++;
        }

        #$file_name = 'dispatchinward.xlsx';
        $file_name = 'dispatch_inward_pending_dispatches.xlsx';
        if ($tab == 'confirmed') {
            $file_name = 'handedover.xlsx';
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

    /* dispatch outward export */

    function outward_export($tab) {

        $tab = $this->uri->segment(3);
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("Documents Master List")
        ->setSubject("Documents Master List")
        ->setDescription("Documents Master List")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Documents Master List");

        $styletitle = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
        );

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'SNo');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Employee');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Dispatch Date');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', "Person's Name");
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "Company's Name");
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'City');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'State');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Pincode');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Content');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Consignment No');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Sent Date');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Vendor');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Status');
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);

        #echo'<pre>';print_r($_POST);die;

        $master_type = (isset($_POST['master_type'])) ? $_POST['master_type'] : '';
        $emp_search = (isset($_POST['emp_search'])) ? $_POST['emp_search'] : '';
        $dispatch_from = (isset($_POST['dispatch_from'])) ? $_POST['dispatch_from'] : '';
        $dispatch_to = (isset($_POST['dispatch_to'])) ? $_POST['dispatch_to'] : '';

        if ($emp_search != '') {
            $cond_arr[] = "t1.employee_id = '" . $emp_search . "'";
        }

        if ($dispatch_from != '') {
            $cond_arr[] = "dispatch_date >= '" . $dispatch_from . "'";
        }

        if ($dispatch_to != '') {
            $cond_arr[] = "dispatch_date <= '" . $dispatch_to . "'";
        }

        if ($master_type != '' && $master_type != 'report') {
            $cond_arr[] = "t1.status = '" . $master_type . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        #echo'<pre>';print_r($result_cond);die;
        $outwardList = $this->Mmaster->getOutwardList('', $tab, $result_cond);
        #echo'<pre>';print_r($tab);die;
        $i = 1;
        foreach ($outwardList as $list) {
            $dispatch_date = date('d-m-Y', strtotime($list['dispatch_date']));
            if ($list['dispatch_date'] == '0000:00:00') {
                $dispatch_date = '';
            }
            $sent_date = $list['sent_date'];
            if ($list['sent_date'] == '0000-00-00 00:00:00') {
                $sent_date = '';
            }
            $username = $this->Mmaster->getUserNameInfo($list['employee_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $username[0]['user_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $dispatch_date);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $list['person_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $list['company_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $list['city']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $list['state']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $list['pincode']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $list['content']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $list['consignment_no']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sent_date);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $list['vendor']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $list['status']);
            $i++;
        }

        $file_name = 'dispatchoutward_pending_dispatches.xlsx';

        if ($tab == 'report') {
            $file_name = 'report.xlsx';
        } else if ($tab == 'confirmed') {
            $file_name = 'sent_dispatches.xlsx';
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

    /* balance export */

    function balance_export() {


        $export_amt = $this->uri->segment(3);

        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("Documents Master List")
        ->setSubject("Documents Master List")
        ->setDescription("Documents Master List")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Documents Master List");

        $styletitle = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
        );

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'S.No');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Programme');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Donor');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Grant ID');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Budget Head');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Line Item');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Additional Info');
        
        if ($export_amt == 1) {
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Assigned Amount (INR)');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Approval Notes (INR)');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Internal Notes (INR)');
            $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Recovered Amount (INR)');
            $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Available Amount (INR)');
            $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Unutilized Amount (INR)');
        }
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styletitle);


        // $cur_year = date('Y');
        $cur_year = current_FYstartYear($this->session->userdata('partner_id'));
        $next_year = $cur_year + 1;
        $data['from'] = $fromperiod = $cur_year . '-' . '04-01';
        $data['to'] = $toperiod = date("Y-m-t", strtotime($next_year . '-' . '03'));


        $data['from_year'] = $from_year = (isset($_POST['year_from'])) && $_POST['year_from'] != '' ? $_POST['year_from'] . '-' . '04-01' : $fromperiod;
        $data['from_to'] = $from_to = (isset($_POST['year_to'])) && $_POST['year_to'] != '' ? $_POST['year_to'] . '-' . '03-31' : $toperiod;
        $data['programme_search'] = $programme_search = (isset($_POST['programme_search'])) ? $_POST['programme_search'] : '';
        $data['grant_search'] = $grant_search = (isset($_POST['grant_search'])) ? $_POST['grant_search'] : '';
        $data['donor_search'] = $donor_search = (isset($_POST['donor_search'])) ? $_POST['donor_search'] : '';
        $data['budget_search'] = $budget_search = (isset($_POST['budget_search'])) ? $_POST['budget_search'] : '';
        $data['lineitem_search'] = $lineitem_search = (isset($_POST['lineitem_search'])) ? $_POST['lineitem_search'] : '';
        $data['costcenter_search'] = $costcenter_search = (isset($_POST['costcenter_search'])) ? $_POST['costcenter_search'] : '';

        $cond_arr[] = "MP.partner_id = '" . $this->session->userdata('partner_id') . "'";

        if ($from_year != '') {
            $amt_fromdate = $from_year = date('Y-m-d', strtotime($from_year));
            $cond_arr[] = "D1A.amount_date >='" . $from_year . "'";
        }

        if ($from_to != '') {
            $amt_todate = $from_to = date('Y-m-d', strtotime($from_to));
            $cond_arr[] = "D1A.amount_date <= '" . $amt_todate . "'";
        }

        if ($programme_search != '') {
         $cond_arr[] = "MP.programme LIKE '%" . $programme_search . "%'";
     }

        /* if ($programme_search != '') {
            $cond_arr[] = "D1A.programme_id = '" . $programme_search . "' OR MP.programme LIKE '%" . $programme_search . "%'";
        } */
        if ($donor_search != '') {
            $cond_arr[] = "D1A.donor_id = '" . $donor_search . "'";
        }
        if ($budget_search != '') {
            $cond_arr[] = "D1A.budget_id = '" . $budget_search . "'";
        }
        if ($lineitem_search != '') {
            $cond_arr[] = "D1A.line_itemid = '" . $lineitem_search . "'";
        }
        if ($costcenter_search != '') {
            $cond_arr[] = "D1A.subline_itemid = '" . $costcenter_search . "'";
        }
        if ($grant_search != '') {
            $cond_arr[] = "D1A.grant_id = '" . $grant_search . "'";
        }

        if (count($cond_arr) > 0) {
            $result_cond = implode(' and ', $cond_arr);
        } else {
            $result_cond = '';
        }
        $partner = $this->session->userdata('partner_id');

        #$query = $this->Mmaster->printBalanceDetails($result_cond);
        $query = $this->Mmaster->getDonorLimitRecords($length, $start, $result_cond, $columns, $requestData);
        $i = 2;

        foreach ($query as $row) {
            if ($row['grant_name'] != '') {
                $assignAmountArray[] = $row['amount'];
                $assign_amt = formatnumber($row['amount']);

                $add_info_value = $this->Mmaster->getAdditionalInfo($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid']);
                $additional_info = $add_info_value['add_info_value'];

                $approvalAmount = $this->Mmaster->checkApprovalNoteAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
                $approvalAmount = ($approvalAmount != '') ? round($approvalAmount, 2) : $approvalAmount;
                $approvalAmountArray[] = $approvalAmount;
                $approval_amt = formatnumber($approvalAmount);

                $internalAmount = $this->Mmaster->checkInternalAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
                $internalAmount = ($internalAmount != '') ? round($internalAmount, 2) : $internalAmount;
                $internalAmountArray[] = $internalAmount;
                $internal_amt = formatnumber($internalAmount);

                $recovered_amount = $this->Mmaster->checkRecoveredAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod, $row['grant_id']);
                $recoveredAmountArray[] = $recovered_amount;
                $recovered_amt = formatnumber($recovered_amount);

                $available = ($row['amount'] - ($approvalAmount)) + $recovered_amount;
                $availbleAmountArray[] = $available;
                $available_amt = formatnumber($available);

                $unuitizedAmount = $approvalAmount - ($internalAmount);
                $unutilizedamountArray[] = $unuitizedAmount;
                $unutilized_amt = formatnumber($unuitizedAmount);

                $get_additional_info = $this->Mmaster->getAdditionalInfo($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid']);
                $get_info_val = isset($get_additional_info['add_info']) && $get_additional_info['add_info'] != '' || $get_additional_info['add_info'] != 0 ? $get_additional_info['add_info'] : '';
                $add_details = substr($get_info_val, 0, strlen($get_info_val) - 2);

                $grant_name = ' ' . $row['grant_name'] . ' ';
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $row['programme']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $row['master_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $grant_name);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $row['budget_head']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $row['line_item']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $add_details);

                if ($export_amt == 1) {
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $assign_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $approval_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $internal_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $recovered_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $available_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $unutilized_amt);
                }
                $i++;
            }
        }
        $file_name = 'balance_sheet_without_amount.xlsx';
        if ($export_amt == 1) {
            $file_name = 'balance_sheet_with_amount.xlsx';
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

    public function commonDelete() {

        $this->load->model('incubation_master/Common_model');
        $id = array_filter($this->input->post('id'));
        $table = $this->input->post('table');
        $returnArr['status'] = '0';

        if (!empty($id)) {
            foreach ($id as $lists) {
                $this->ais = $this->load->database('ais', TRUE);
                $this->ais->where('id', $lists);
                $data = $this->ais->delete('balance_amount');
            }
            $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
        }
        echo json_encode($returnArr);
    }

}

?>
