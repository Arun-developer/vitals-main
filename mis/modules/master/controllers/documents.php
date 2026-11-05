<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Documents extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mdocuments');
        $this->items_perpage = '15';
        $this->Mauth->isLoggedCheck();
    }
    public function index()
    {
        redirect('master/documents/view_list');
    }
    public function view_list($activity_id = null)
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(5);

        $data['activity_id'] = $activity_id;
        $options['activity_id'] = $activity_id;
        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/documents/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mdocuments->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends
        #Loading View and data
        $data['documentsList'] = $this->Mdocuments->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Documents Master";
        $data['cpage'] = "documents/listDocuments";

        $data['custom_js'] = array('list_page');

        $this->load->view('../template_iframe', $data);

    }

    public function form($activity_id = null, $id = '')
    {
        $data['activity_id'] = $activity_id;
        if (isset($_POST['txtSubmit'])) {

            $msg = $this->upload($_FILES);
            $options = $_POST;
            for ($i = 0; $i < php72_count($_FILES['document']['name']); $i++) {
                $_POST['document'][$i] = $_FILES['document']['name'][$i];
            }
            if ($msg == '') {
                if ($_POST['action'] == 'edit') {
                    $result = $this->Mdocuments->update($_POST);
                    $msg = "Record inserted!";
                } else {
                    $result = $this->Mdocuments->insert($_POST);
                    $msg = "Record Updated!";
                }
                $this->session->set_flashdata('successMsg', $msg);
            } else {
                $this->session->set_flashdata('errorMsg', $msg);
            }

            redirect('master/documents/view_list/' . $_POST['field']);
        }

        $data['documentsDetails'] = array();
        if ($id != '') {
            $data['documentsDetails'] = $this->Mdocuments->getDocumentsInfo($id);
            if (php72_count($data['documentsDetails']) == 0) {
                redirect('master/documents/form/' . $activity_id);
            }

            $data['cpagetitle'] = "Edit Documents";
        } else {
            $data['cpagetitle'] = "Add Documents";
        }
        $data['cpage'] = "documents/addDocuments";
        $this->load->view('../template_plain', $data);
    }

    /**
     * Function : delete method is used for delete documentss.
     *
     * @param int $id
     *
     */
    public function delete($table = 'a', $row = 'a', $id = '')
    {
        if ($id != '') {
            $documentsDetails = $this->Mdocuments->getDocumentsInfo($id);
            $path = './uploads/documents/' . $documentsDetails['0']['document'];
            if (file_exists($path)) {
                unlink($path);
            }

            $this->Mdocuments->delete($id);
            $this->session->set_flashdata('successMsg', 'Document deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/documents/view_list/' . $table . '/' . $row);
    }

    /**
     * Function : changestatus method is used for Changing Status of the documentss.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function changestatus($id = '', $status = '')
    {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mdocuments->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Document Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/documents/view_list/' . $table . '/' . $row);
    }

    #file upload and assign file to post
    public function upload($options)
    {
        $msg = '';
        $config['upload_path'] = './uploads/documents/';
        $config['allowed_types'] = '*';
        $_POST['document'] = '';
        $this->load->library('upload');
        for ($i = 0; $i < php72_count($options['document']['name']); $i++) {
            if ($options['document']['name'][$i] != '') {
                $_FILES['ty']['name'] = $options['document']['name'][$i];
            }

            $_FILES['ty']['tmp_name'] = $options['document']['tmp_name'][$i];
            $_FILES['ty']['size'] = $options['document']['size'][$i];
            $_FILES['ty']['type'] = $options['document']['type'][$i];
            $this->upload->initialize($config);
            $this->upload->do_upload('ty');
        }
        return $msg;
    }

}
