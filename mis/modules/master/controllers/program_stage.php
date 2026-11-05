<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Program_stage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mprogram_stage');
        $this->load->model('Mmaster_settings');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('master/program_stage/view_list');
    }
    public function view_list()
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/program_stage/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mprogram_stage->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['programStageList'] = $this->Mprogram_stage->getLimitRecords($options);
		$data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Program Stage Master";
        $data['cpage'] = "program_stage/listProgramStage";

        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');

        $this->load->view('../template', $data);
    }
    public function add()
    {
        $data['errorMsg'] = '';
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
		#echo'<pre>';print_r($data['programType']);die;
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $result = $this->Mprogram_stage->insert($_POST);
                $this->session->set_flashdata('successMsg', 'Record inserted !');
                redirect('master/program_stage/view_list');
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }

        }
        $data['cpagetitle'] = "Add Program Stage";
        $data['cpage'] = "program_stage/addProgramStage";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('stage_service');
        $this->load->view('../template', $data);
    }
    public function edit($id)
    {
        $data['errorMsg'] = '';
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $_POST['id'] = $id;
                $this->Mprogram_stage->update($_POST);
                $this->session->set_flashdata('successMsg', 'Record Updated !');
                redirect('master/program_stage/view_list');
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }

        }
        #Loading View and data
        $data['programType'] = $this->Mmaster_settings->getMasterSetting('Program Type');
        $data['programStageDetails'] = $this->Mprogram_stage->getProgramStageInfo($id);
        $data['cpagetitle'] = "Edit Program Stage";
        $data['cpage'] = "program_stage/editProgramStage";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('stage_service');
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
            $result = $this->Mprogram_stage->delete($id);
            $this->session->set_flashdata('successMsg', 'Record deleted Successfully');
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/program_stage/view_list');
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
            $this->Mprogram_stage->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Source Status updated');
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/program_stage/view_list');
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

    public function program_stage_combo()
    {
        $program_service = $this->input->post('program_service');
        $selected = $this->input->post('selected');
        echo '<option value="">-Select-</option>';
        if ($program_service != '') {
            $programStageList = $this->Mprogram_stage->getProgramStageCombo($program_service);
            if (count($programStageList)) {
                foreach ($programStageList as $row):
                ?>
					<option value="<?=$row['id']?>" <?=($selected == $row['id']) ? 'selected' : '';?>><?=$row['title']?></option>
					<?php
endforeach;
            }
        }
    }

}
?>