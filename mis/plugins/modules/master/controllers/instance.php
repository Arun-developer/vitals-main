<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Instance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Msource');
        $this->load->model('Minstance');
        $this->load->model('Mmaster_settings');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('master/instance/view_list');
    }
    public function view_list($source = null)
    {
        $data['sourceDetails'] = $this->Msource->getSourceDetails($source);
        if (count($data['sourceDetails']) == 0 || empty($source)) {
            redirect('master/source/view_list');
        }

        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(5);
        $options['source'] = $data['source'] = $source;
        if (!empty($instance)) {
            $data['instanceDetails'] = $this->Minstance->getInstanceDetails($source);
        }

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/instance/view_list/' . $source),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Minstance->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 5);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['sourceDetails'] = $this->Msource->getSourceDetails($source);
        $data['instanceList'] = $this->Minstance->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Instance Master";
        $data['cpage'] = "instance/listInstance";

        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');

        $this->load->view('../template', $data);
    }
    public function instanceform($source = null, $instance = null)
    {
        //getting source
        $data['sourceDetails'] = $this->Msource->getSourceDetails($source);
        if (count($data['sourceDetails']) == 0 || empty($source)) {
            redirect('master/source/view_list');
        }

        if (isset($_POST['txtSubmit'])) {
            if ($this->_validation()) {
                $_POST['document'] = '';
                if ($_FILES['document']['name'] != '') {
                    $config['upload_path'] = './uploads/instance';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|doc|txt';
                    $config['file_name'] = rand() . "_" . str_replace(' ', '_', $_FILES['document']['name']);
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('document')) {
                        $data['errorMsg'] = $this->upload->display_errors();
                    } else {
                        $_POST['document'] = $config['file_name'];
                    }

                    if ($_POST['pre_document'] != '') {
                        @unlink('uploads/instance/' . $_POST['pre_document']);
                    }

                }
                if (empty($data['errorMsg'])) {
                    if ($_POST['action'] == 'edit') {
                        if ($_POST['document'] == '') {
                            $_POST['document'] = $_POST['pre_document'];
                        }

                        $this->Minstance->update($_POST);
                        $this->session->set_flashdata('successMsg', 'Record Updated!');
                    } else {
                        $result = $this->Minstance->insert($_POST);
                        $this->session->set_flashdata('successMsg', 'Record inserted !');
                    }
                    redirect('master/instance/view_list/' . $source);
                }
            } else {
                $this->session->set_flashdata('errorMsg', 'Validation error found, check it again!');
            }

        }

        if ($instance != '') {
            $data['instanceDetails'] = $this->Minstance->getInstanceDetails($instance);
            if (count($data['instanceDetails']) == 0) {
                redirect('master/instance/instanceform/' . $source);
            }

            $data['cpagetitle'] = "Edit Instance";
        } else {
            $data['instanceDetails'] = array();
            $data['cpagetitle'] = "Add Instance";
        }
        $data['source'] = $source;
        $data['cpage'] = "instance/addInstance";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);

    }

    /**
     * Function : delete method is used for delete mailtemplates.
     *
     * @param int $id
     *
     */

    public function delete($source = null, $instance = null)
    {
        if ($instance != '') {
            $result = $this->Minstance->delete($instance);
            if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Master deleted Successfully');
            }

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/instance/view_list/' . $source);
    }

    /**
     * Function : changestatus method is used for Changing Status of the mailtemplates.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function changestatus($source = '', $id = '', $status = '')
    {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Minstance->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Source Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/instance/view_list/' . $source);
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
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('instance_name', 'Instance Name', 'required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }

    #get ajax instance by source#
    public function get_instance_combo()
    {
        $source = $this->input->post('source');
        $instance_select = $this->input->post('instance_select');
        echo '<option value="">-Select-</option>';
        if ($source != '') {
            $instanceList = $this->Minstance->getInstanceCombo($source);
            if (count($instanceList)) {
                foreach ($instanceList as $row):
                ?>
					<option value="<?=$row['id']?>" <?=($instance_select == $row['id']) ? 'selected' : '';?> ><?=$row['instance_name']?></option>
					<?php
				endforeach;
            }
        }

    }

}
?>