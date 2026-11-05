<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Program_service extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mmaster_settings');
        $this->load->model('Mprogram_service');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('master/program_service/view_list');
    }
    public function view_list(){
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/program_service/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mprogram_service->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['programServiceList'] = $this->Mprogram_service->getLimitRecords($options);
		#echo'<pre>';print_r($data['programType']);die;
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Program Service Master";
        $data['cpage'] = "program_service/listProgramService";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');
        $this->load->view('../template', $data);
    }
    public function add()
    {
        $data['errorMsg'] = '';
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $result = $this->Mprogram_service->insert($_POST);
                $this->session->set_flashdata('successMsg', 'Record inserted !');
                redirect('master/program_service/view_list');
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }

        }
        $data['cpagetitle'] = "Add Program Service";
        $data['cpage'] = "program_service/addProgramService";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }
    public function edit($id)
    {
        $data['errorMsg'] = '';
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $_POST['id'] = $id;
                $this->Mprogram_service->update($_POST);
                $this->session->set_flashdata('successMsg', 'Record Updated !');
                redirect('master/program_service/view_list');
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }

        }
        #Loading View and data
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['programServiceDetails'] = $this->Mprogram_service->getProgramServiceInfo($id);
        $data['cpagetitle'] = "Edit Program Service";
        $data['cpage'] = "program_service/editProgramService";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }

    /**
     * Function : delete method is used for delete mailtemplates.
     *
     * @param int $id
     *
     */
    public function delete($id = '')
    {
        if ($id != '') {
            $result = $this->Mprogram_service->delete($id);
            $this->session->set_flashdata('successMsg', 'Record deleted Successfully');
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/program_service/view_list');
    }

    /**
     * Function : changestatus method is used for Changing Status of the mailtemplates.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function changestatus($id = '', $status = '')
    {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mprogram_service->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Source Status updated');
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/program_service/view_list');
    }

    /**
     * Function : _validation method is used for validation before add, edit mailtemplate.
     *
     * Function called by:
     * ---------------
     * $this->add()
     * $this->edit()
     *
     * @param null
     */

    public function _validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('program_type', 'Program Type', 'required');
        $this->form_validation->set_rules('title', 'Program Service', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

    //ajax functions
    public function program_service_combo()
    {
        $program_type = $this->input->post('program_type');
        $selected = $this->input->post('selected');
        echo '<option value="">-Select-</option>';
        if ($program_type != '') {
            $programServiceList = $this->Mprogram_service->getProgramServiceCombo($program_type);
            if (count($programServiceList)) {
                foreach ($programServiceList as $row):
                ?>
					<option value="<?=$row['id']?>" <?=($selected == $row['id']) ? 'selected' : '';?>><?=$row['title']?></option>
					<?php
endforeach;
            }
        }

    }

}
?>