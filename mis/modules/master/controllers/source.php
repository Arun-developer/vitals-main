<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Source extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Msource');
        $this->load->model('Mmaster_settings');
        $this->load->model('login/Muser');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('master/source/view_list');
    }
    public function view_list($tab = null){
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        if ($this->uri->segment(4) != 'all') {
            $options['offset'] = $this->uri->segment(4);
        } else {
            $options['offset'] = $this->uri->segment(5);
        }

        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            $data['isAuth'] = true;
        } else {
            $options['employee'] = $this->session->userdata('emp_number');
            $data['isAuth'] = false;
        }
		#$data['isAuth'] = true;
        if ($tab == 'all') {
            $id = array_pop($options);
            $data['tab'] = $tab;

        } else {
            $data['tab'] = 'NULL';
        }
		
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/source/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Msource->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends
		#echo'<pre>';print_r($options);die;
        #Loading View and data
        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['sourceList'] = $this->Msource->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');

        if (!empty($options['export'])) {
            $options['num'] = '';
            $options['offset'] = '';
            $reportData = $this->Msource->getLimitRecords($options);
            if (count($reportData)) {
                $this->Mexport->export($reportData, $options['export']);
            } else {
                $data['errorMsg'] = "No Matched records found!";
            }

        }
        $data['cpagetitle'] = "Source Master";
        $data['cpage'] = "source/listSource";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');
		$this->load->view('../template', $data);
    }
    public function sourceform($id = ''){ #echo'<pre>';print_r($_POST);die;
        $data['errorMsg'] = '';
        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $_POST['document'] = '';
                if ($_FILES['document']['name'] != '') {
                    $config['upload_path'] = './uploads/source';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|doc|txt';
                    $config['file_name'] = rand() . "_" . str_replace(' ', '_', $_FILES['document']['name']);
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('document')) {
                        $data['errorMsg'] = $this->upload->display_errors();
                    } else {
                        $_POST['document'] = $config['file_name'];
                    }

                }
                if (empty($data['errorMsg'])) {
                    if ($_POST['action'] == 'edit') {
                        if ($_POST['document'] == '') {
                            $_POST['document'] = $_POST['pre_document'];
                        } else {
                            @unlink('uploads/source/' . $_POST['pre_document']);
                        }
                        $this->Msource->update($_POST);
                        $this->session->set_flashdata('successMsg', 'Record Updated!');
                    } else {
                        $result = $this->Msource->insert($_POST);
                        $this->session->set_flashdata('successMsg', 'Record inserted !');
                    }
                    redirect('master/source/view_list');
                }
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }

        }
        $data['tinyMCE'] = 'yes';
        $data['sourceDetails'] = array();
        if ($id != '') {
            $data['sourceDetails'] = $this->Msource->getSourceDetails($id);
            if (count($data['sourceDetails']) == 0) {
                redirect('master/source/sourceform');
            }

            $data['cpagetitle'] = "Edit Source";
        } else {
            $data['cpagetitle'] = "Add Source";
        }
        $data['usersList'] = $this->Muser->getUsersList();
        $data['sourceType'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['cpage'] = "source/addSource";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }
    public function view_details($id)
    {
        $data['cpagetitle'] = "View Source";
        $data['sourceDetails'] = $this->Msource->getSourceDetails($id);
        $data['cpage'] = "source/viewSource";
        $this->load->view('../template_plain', $data);
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
            $result = $this->Msource->delete($id);
            if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Master deleted Successfully');
            }

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/source/view_list');
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
            $this->Msource->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Source Status updated');
        } else {
            $this->session->set_flashdata('errorMsg', 'Value Missing');
        }

        redirect('master/source/view_list');
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
        $this->form_validation->set_rules('source_type', 'Source Type', 'required');
        $this->form_validation->set_rules('source_name', 'Source Name', 'required');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
        $this->form_validation->set_rules('designation', 'Designation', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('frequency', 'Frequency', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

    //ajax content by soure type
    public function get_source_combo()
    {

        $sourceType = $this->input->post('source_type');
        $sourceSelect = $this->input->post('source_select');

        $source_others = $this->input->post('source_others');
        echo '<option value="">-Select-</option>';
        if ($sourceType != '') {
            $sourceList = $this->Msource->getSourceCombo($sourceType);
            if (count($sourceList)) {
                foreach ($sourceList as $row):
                ?>
					<option value="<?=$row['id']?>" <?=($sourceSelect == $row['id']) ? 'selected' : '';?>><?=$row['source_name']?></option>
					<?php
				endforeach;
            }
            ?>
                    <option value="-1" <?=($source_others != null || $sourceSelect == '-1') ? 'selected' : '';?> >Others</option>
				<?php
}

    }

}
?>
