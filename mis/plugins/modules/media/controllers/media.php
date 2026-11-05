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
        $this->load->model('scouting/Minnovation');
        $this->load->helper('common_helper');

    }
    public function index()
    {
        redirect('media/view_list/' . $innovationid);
    }
    public function view_list($innovationid = null)
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        $options['innovationid'] = $innovationid;
        $data['applicantList'] = $this->Mmedia->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['isincubAuth'] = false;

        /**** For showing the innovator Name ****/
        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);
        $data['innovator'] = $data['innovation']['name_of_entrepreneur'];
        /**** End ***/
        $data['innovationid'] = $innovationid;
        $data['isincubAuth'] = false;
        $data['cpagetitle'] = "Recongnition Through Media";
        $data['cpage'] = "listmedia";

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;
            $data['left_box'] = array('incubation');
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');
        }
        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function addmedia_detail($innovationid = null, $id = null)
    {

        $data['mediaDetails']['list1'] = $this->Mmedia->getmediaDetails($id);
        $data['mediaDetails']['list2'] = $this->Mmedia->getmediamaster($id);
        $data['cpage'] = "addmedia_detail";
        $data['cpagetitle'] = "Add Media Detail";
        $data['innovationid'] = $innovationid;
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;
            $options['uploadpath'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/article/';
            $this->articleupload($options);
            $filename = $_FILES['document']['name'];
            $options['filename'] = $filename;
            $options['publish_date'] = date2mysql($options['publish_date']);

            $result = $this->Mmedia->insertmedia_detail($options);
            $this->Mmedia->changestatus($options['id']);
            $msg = "Record Inserted!";
            $this->session->set_flashdata('successMsg', $msg);
            redirect('media/view_list/' . $innovationid);
        } else {
            $data['innovationid'] = $innovationid;
            $data['id'] = $id;
            $data['cpage'] = "addmedia_detail";
            $this->load->view('../template', $data);
        }

    }
    public function liststatus($decision = null, $innovationid = null, $id = null)
    {

        if ($decision == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();
                $options = $_POST;
                $this->Mmedia->updateliststatus($options);
                redirect('media/view_list/' . $innovationid);
            }
            $data['cpagetitle'] = "Approve Request";
            $data['innovationid'] = $innovationid;

            $data['id'] = $id;
            $data['cpage'] = "listRequest";
            $this->load->view('../template_plain', $data);
        } else {
            if (isset($_POST['rejectSubmit'])) {

                $options = array();
                $options = $_POST;
                $this->Mmedia->updateliststatus($options);
                redirect('media/view_list/' . $innovationid);
            }

            $data['cpagetitle'] = "Reject Request";
            $data['innovationid'] = $innovationid;
            $data['id'] = $id;
            $data['cpage'] = "listReject";
            $this->load->view('../template_plain', $data);
        }
    }
    public function addapplicant($innovationid = null, $id = null)
    {
        $data['cpage'] = "addapplicant";
        $data['cpagetitle'] = "Requesting Media";
        $data['innovationid'] = $innovationid;
        $data['id'] = $id;
        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function form($innovationid = null, $id = null)
    {

        $data['mediaDetails'] = array();
        if ($id != '') {

            $data['cpagetitle'] = "Edit Media";
            $data['mediaDetails'] = $this->Mmedia->getmediaDetails($id);
        } else {
            $data['cpagetitle'] = "Add Media";
        }

        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $options = array();
                $options = $_POST;
                $options['uploadpath'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/media/';
                $this->doupload($options);
                $filename = $_FILES['document']['name'];
                $options['filename'] = $filename;
                $result = $this->Mmedia->update($_POST);
                $msg = "Record Updated!";
            } else {
                $options = array();
                $options = $_POST;
                $options['uploadpath'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/media/';
                $this->doupload($options);
                $filename = $_FILES['document']['name'];
                $options['filename'] = $filename;
                $options['requested_on'] = date2mysql($options['requested_on']);

                $result = $this->Mmedia->insert($options);
                $msg = "Record Inserted!";
            }

            $this->session->set_flashdata('successMsg', $msg);
            redirect('media/view_list/' . $innovationid);
        }

        $data['innovationid'] = $innovationid;
        $data['id'] = $id;
        $data['cpage'] = "addmediareq";
        $this->load->view('../template', $data);
    }
    public function doupload($options)
    {

        if ($_FILES['document']['name'] != '') {

            $filename = $_FILES['document']['name'];

            $_FILES['ty']['name'] = $_FILES['document']['name'];
            $_FILES['ty']['tmp_name'] = $_FILES['document']['tmp_name'];
            $_FILES['ty']['size'] = $_FILES['document']['size'];
            $_FILES['ty']['error'] = $_FILES['document']['error'];
            $_FILES['ty']['type'] = $_FILES['document']['type'];
            $config['upload_path'] = $options['uploadpath'];
            $config['allowed_types'] = '*';
            $config['file_name'] = $filename;
            $this->load->library('upload');
            $this->upload->initialize($config);
            $data['success_msg'] = $this->upload->do_upload('ty');
            $this->load->view('addmediareq', $data);

        }
    }
    public function articleupload($options)
    {
        if ($_FILES['document']['name'] != '') {

            $filename = $_FILES['document']['name'];

            $_FILES['ty']['name'] = $_FILES['document']['name'];
            $_FILES['ty']['tmp_name'] = $_FILES['document']['tmp_name'];
            $_FILES['ty']['size'] = $_FILES['document']['size'];
            $_FILES['ty']['error'] = $_FILES['document']['error'];
            $_FILES['ty']['type'] = $_FILES['document']['type'];
            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $filename);
            $config['upload_path'] = $options['uploadpath'];
            $config['allowed_types'] = '*';
            $config['file_name'] = $filename;
            $this->load->library('upload');
            $this->upload->initialize($config);
            $data['success_msg'] = $this->upload->do_upload('ty');
            $this->load->view('addmedia_detail', $data);

        }
    }
    public function delete($id = '')
    {
        if ($id != '') {
            $result = $this->Mmedia->delete($id);
            $this->session->set_flashdata('successMsg', 'Applicant deleted Success fully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('media/view_list');
    }
    public function showdetail($id)
    {
        $data['applicantList'] = $this->Mmedia->getmediaDetails($id);

        $data['cpage'] = 'media/showdetail';
        $data['cpagetitle'] = 'Recognition Through Media';
        $this->load->view('../template_plain', $data);
    }
    public function addinnovator_detail($innovation, $id)
    {
        $data['innovationid'] = $innovation;
        $data['id'] = $id;
        if (isset($_POST['txtsubmit'])) {
            $options = $_POST;
            $this->Mmedia->insertinformation($options);
            $this->session->set_flashdata('successMsg', 'Information Added Successfully');
            redirect('media/view_list/' . $innovation);
        }
        $data['cpage'] = 'addinnovatordetail';
        $data['cpagetitle'] = 'Additional Information of Incubatee';
        $this->load->view('../template_plain', $data);
    }
    public function publisharticle($innovation = null)
    {
        $data['mediaList'] = $this->Mmedia->getmediaList($innovation);
        if (isset($_POST['txtSubmit'])) {
            $innovation = $_POST['innovation'];
            $options = $_POST;
            $options['uploadpath'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/media/';
            $this->doupload($options);
            $filename = $_FILES['document']['name'];
            $options['filename'] = $filename;
            $this->Mmedia->insertdirect_media($options);
            $this->session->set_flashdata('successMsg', 'Information Added Successfully');
            redirect('media/view_list/' . $innovation);
        }
        $data['innovationid'] = $innovation;
        $data['cpage'] = 'publisharticle';
        $data['cpagetitle'] = 'Published Article';
        $this->load->view('../template', $data);
    }

}
