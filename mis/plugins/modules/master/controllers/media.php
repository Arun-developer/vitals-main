<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Media extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->items_perpage = '15';
        $this->load->model('Mmedia');
    }
    public function index()
    {
        redirect('master/media/view_list');
    }
    public function view_list()
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Loading View and data
        $data['left_box'] = array('master');
        $data['mediaList'] = $this->Mmedia->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['cpagetitle'] = "Media List";
        $data['cpage'] = "media/listmedia";
        $this->load->view('../template', $data);

    }
    public function download($article)
    {
        $this->load->helper('download');
        $path = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/media/';
        $data = file_get_contents("../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/media/" . $article);
        force_download($article, $data);
    }

    public function form($id = null)
    {
        $data['mediaDetails'] = array();
        if ($id != '') {
            $data['cpagetitle'] = "Edit Media";
            $data['mediaDetails'] = $this->Mmedia->getmediamaster($id);
        } else {
            $data['cpagetitle'] = "Add Media_Master";
        }

        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $options = array();
                $options = $_POST;
                $result = $this->Mmedia->update($options);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record Updated !');
                    redirect('master/media/view_list');
                }
            } else {
                $options = array();
                $options = $_POST;
                $result = $this->Mmedia->insert($options);
                if ($result) {
                    $this->session->set_flashdata('successMsg', 'Record inserted !');
                    redirect('master/media');
                }
            }
        }
        $data['id'] = $id;
        $data['cpage'] = "media/addmediamaster";
        $this->load->view('../template', $data);
    }

    public function viewprofile($id = null)
    {
        $data['applicantDetails'] = $this->Mmedia->getmediamaster($id);
        $data['cpagetitle'] = "View Profile";
        $data['cpage'] = "media/viewprofile";
        $this->load->view('../template_plain', $data);
    }

    public function delete($id = '')
    {
        if ($id != '') {
            $result = $this->Mmedia->delete($id);
            $this->session->set_flashdata('successMsg', 'Applicant deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/media/view_list');
    }

    public function article($media_name = null)
    {
        $data['mediaList'] = $this->Mmedia->article($media_name);

        $data['cpagetitle'] = "Article Manager";
        $data['cpage'] = "master/media/article";
        $this->load->view('../template_plain', $data);
    }

    public function changestatus($id = '', $status = '')
    {
        if ($id != '' && $status != '') {

            $options = array('id' => $id, 'status' => $status);

            $this->Mapplicant->changeStatus($options);
            $this->session->set_flashdata('successMsg', ' Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/applicant/view_list');
    }
    public function _validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required');
        $this->form_validation->set_rules('vendor_email', 'Email Address', 'required|valid_email');
        if ($this->form_validation->run() == false) {
            return false;
        }
        return true;
    }
    public function articleupload()
    {
        $options = $_POST;

        if ($_FILES['document']['name'] != '') {
            $filename = $_FILES['document']['name'];

            $_FILES['ty']['name'] = $_FILES['document']['name'];
            $_FILES['ty']['tmp_name'] = $_FILES['document']['tmp_name'];
            $_FILES['ty']['size'] = $_FILES['document']['size'];
            $_FILES['ty']['error'] = $_FILES['document']['error'];
            $_FILES['ty']['type'] = $_FILES['document']['type'];
            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $filename);
            $config['upload_path'] = './uploads/article/';
            $config['allowed_types'] = '*';
            $config['file_name'] = $filename;
            $this->upload->initialize($config);
            $data['success_msg'] = $this->upload->do_upload('ty'); 
            $this->load->view('addmedia_detail', $data);

        }
    }

}
