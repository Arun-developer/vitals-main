<?php

class Job extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->Mauth->isAdminCheck();
        $this->load->model('Mjob');
        $this->load->model('user/Empuser');
        $this->load->library('upload');
        $this->load->model('portfolio/Mportfolio');
    }

    public function lists() {
        $option['status'] = 1;
        $option['partner_id'] = $this->session->userdata['partner_id'];
        $data['search_field'] = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';

        $data['job_designation'] = $this->Empuser->getCommonDetails('hr_job_designation', $option, 'asc', 'job_title');
        $this->load->vars($data);
        $this->load->view('job/job_listing');
    }

    public function DT_job() {
        $requestData = $_POST;

        if ($this->session->userdata['user_type'] == 'superadmin') {
            $columns = array(
                0 => 'id',
                1 => 'id',
                2 => 'job_title',
                3 => 'partner_name',
                4 => 'grade_name',
                5 => 'specification_name'
            );
        } else {
            $columns = array(
                0 => 'id',
                1 => 'id',
                2 => 'job_title',
                3 => 'grade_name',
                4 => 'specification_name'
            );
        }

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';

        $totalrows = $this->Mjob->getDTJobCount($search_field, $search_value, $columns, $requestData);
        $query = $this->Mjob->getDTJobDetails($requestData['length'], $requestData['start'], $search_field, $search_value, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="job_chk_box" name="job_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['id'];
            $job_title = strlen($row['job_title']) > 40 ? substr($row['job_title'], 0, 40) . ".." : $row['job_title'];
            $nestedData[] = "<a href=" . site_url('job/edit_job/' . $row['id']) . " title='" . $row['job_title'] . "'>" . $job_title . "</a>";
            if ($this->session->userdata['user_type'] == 'superadmin') {
                $nestedData[] = $row['partner_name'];
            }
            $nestedData[] = strlen($row['grade_name']) > 20 ? substr($row['grade_name'], 0, 20) . ".." : $row['grade_name'];
            $nestedData[] = strlen($row['specification_name']) > 25 ? substr($row['specification_name'], 0, 25) . ".." : $row['specification_name'];

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

    public function copy_job() {
        $option['status'] = 1;
        $option['partner_id'] = 1;
        $job_list = $this->Empuser->getCommonDetails('hr_job_designation', $option, 'asc', 'job_title');
        foreach ($job_list as $job) {
            $data['partner_id'] = $this->session->userdata['partner_id'];
            $data['job_title'] = $job['job_title'];
            $data['job_description'] = $job['job_description'];
            $data['job_comment'] = $job['job_comment'];
            $data['pay_grade'] = $job['pay_grade'];
            $data['specification_id'] = $job['specification_id'];
            $data['job_type'] = $job['job_type'];
            $data['created_by'] = $this->session->userdata['user_id'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['status'] = 1;
            $query = $this->Mportfolio->insertPortfolioDetail('hr_job_designation', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Master data copied successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('job/lists');
    }

    public function deleteDetail() {
        $id = $this->input->post('id');
        $condition = "'" . implode("', '", $id) . "'";
        $table = $_POST['table'];
        $query = $this->Mjob->deleteJobDetail($table, $condition);

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
        } else {
            echo '0';
        }
    }

    public function add_job() {
        $option['status'] = 1;
        $data['specification'] = $this->Empuser->getCommonDetails('hr_job_specification', $option, 'asc', 'specification_name');
        $data['grade'] = $this->Empuser->getCommonDetails('hr_salary_grade', $option, 'asc', 'grade_name');
        $this->load->vars($data);
        $this->load->view('job/add_job');
    }

    public function add_jobtitle() {
        $data['partner_id'] = $this->session->userdata['partner_id'];
        $data['job_title'] = $_POST['job_title'];
        $data['job_description'] = $_POST['job_desc'];
        $data['job_comment'] = $_POST['job_comments'];
        $data['pay_grade'] = $_POST['pay_grade'];
        $data['specification_id'] = $_POST['specific_id'];

        $data['created_by'] = $this->session->userdata('emp_number');
        $data['created_at'] = date("Y-m-d H:i:s");
        $query = $this->Mportfolio->insertPortfolioDetail('hr_job_designation', $data);

        if ($query) {
            $this->session->set_flashdata('successMsg', "Job details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('job/lists');
    }

    public function edit_job($id = '') {
        $job['status'] = $option['status'] = 1;
        $job['id'] = $id;
        if ($id != '') {
            $data['job'] = $this->Empuser->getCommonDetails('hr_job_designation', $job);
        }

        $data['specification'] = $this->Empuser->getCommonDetails('hr_job_specification', $option, 'asc', 'specification_name');
        $data['grade'] = $this->Empuser->getCommonDetails('hr_salary_grade', $option, 'asc', 'grade_name');
        $this->load->vars($data);
        $this->load->view('job/edit_job');
    }

    public function edit_jobtitle() {
        $option['id'] = $_POST['job_id'];
        $data['partner_id'] = $this->session->userdata['partner_id'];
        $data['job_title'] = $_POST['job_title'];
        $data['job_description'] = $_POST['job_desc'];
        $data['job_comment'] = $_POST['job_comments'];
        $data['pay_grade'] = $_POST['pay_grade'];
        $data['specification_id'] = $_POST['specific_id'];

        $checkExist = $this->Mportfolio->getDetails('hr_job_designation', $option);
        if (count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_job_designation', $data, $option);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Job details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('job/edit_job/' . $_POST['job_id']);
    }

    public function location() {
        $option['status'] = 1;
        $data['search_field'] = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';

        $data['job_location'] = $this->Empuser->getCommonDetails('hr_job_location', $option, 'asc', 'location_name');
        $this->load->vars($data);
        $this->load->view('job/job_location_listing');
    }

    public function DT_jobLocation() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'location_name',
            3 => 'country',
            4 => 'city',
            5 => 'zipcode'
        );

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';

        $totalrows = $this->Mjob->getDTJobLocationCount($search_field, $search_value, $columns, $requestData);
        $query = $this->Mjob->getDTJobLocationDetails($requestData['length'], $requestData['start'], $search_field, $search_value, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();

            $nestedData[] = '<input type="checkbox" class="chk_box" id="job_chk_box" name="job_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['id'];
            $job_location = strlen($row['location_name']) > 25 ? substr($row['location_name'], 0, 25) . ".." : $row['location_name'];
            $nestedData[] = "<a href=" . site_url('job/edit_job_location/' . $row['id']) . " title='" . $row['location_name'] . "'>" . $job_location . "</a>";
            $nestedData[] = strlen($row['country_name']) > 20 ? substr($row['country_name'], 0, 20) . ".." : $row['country_name'];
            $nestedData[] = strlen($row['city']) > 20 ? substr($row['city'], 0, 20) . ".." : $row['city'];
            $nestedData[] = $row['zipcode'];

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

    public function add_job_location() {
        $option['status'] = 1;
        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');
        $this->load->vars($data);
        $this->load->view('job/add_job_location');
    }

    public function add_joblocation() {
        $data['location_name'] = $_POST['job_location'];
        $data['country'] = $_POST['loc_country'];
        $data['address'] = $_POST['loc_address'];
        $data['state'] = $_POST['loc_state'];
        $data['city'] = $_POST['loc_city'];
        $data['zipcode'] = $_POST['loc_zipcode'];
        $data['phone'] = $_POST['loc_mobile'];
        $data['fax'] = $_POST['loc_fax'];
        $data['comments'] = $_POST['loc_comments'];

        $data['created_by'] = $this->session->userdata('emp_number');
        $data['created_at'] = date("Y-m-d H:i:s");
        $query = $this->Mportfolio->insertPortfolioDetail('hr_job_location', $data);

        if ($query) {
            $this->session->set_flashdata('successMsg', "Job location details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('job/location');
    }

    public function edit_job_location($id = '') {
        $job['status'] = $option['status'] = 1;
        $job['id'] = $id;
        if ($id != '') {
            $data['job_loc'] = $this->Empuser->getCommonDetails('hr_job_location', $job);
        }

        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');
        $this->load->vars($data);
        $this->load->view('job/edit_job_location');
    }

    public function edit_joblocation() {
        $option['id'] = $_POST['location_id'];
        $data['location_name'] = $_POST['job_location'];
        $data['country'] = $_POST['loc_country'];
        $data['address'] = $_POST['loc_address'];
        $data['state'] = $_POST['loc_state'];
        $data['city'] = $_POST['loc_city'];
        $data['zipcode'] = $_POST['loc_zipcode'];
        $data['phone'] = $_POST['loc_mobile'];
        $data['fax'] = $_POST['loc_fax'];
        $data['comments'] = $_POST['loc_comments'];

        $checkExist = $this->Mportfolio->getDetails('hr_job_location', $option);
        if (count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_job_location', $data, $option);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Job location details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('job/edit_job_location/' . $_POST['location_id']);
    }

}

?>