<?php

/*-

 * Masters Module Controller

 * This section for setting  purpose

 *

 * Master's Controller

 * @quadrupleindia.com

 * author - Prabakar

 */

class Invester extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';

        $this->load->model('Minvester');

        $this->load->model('Minvesterdoc');

        $this->load->model('scouting/Minnovation');

        $this->load->model('master/Mmaster_settings');

        $this->load->helper('common_helper');

    }

    public function index()
    {

        redirect('invester/view_list/' . $innovationid);

    }

    public function view_list($innovationid)
    {

        $options = array();

        $options = $_POST;

        $options['num'] = $this->items_perpage;

        $options['offset'] = $this->uri->segment(4);

        $options['innovationid'] = $innovationid;

        $data['investerList'] = $this->Minvester->getLimitRecords($options);

        $data['orderby'] = $this->input->post('sort_column');

        $data['ordertype'] = $this->input->post('sort_order');

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $data['innovationid'] = $innovationid;

        $data['isincubAuth'] = false;

        $data['cpagetitle'] = "Invester Request";

        $data['cpage'] = "listinvester";

        $data['statusArr'] = statusArr();

        $data['isAbi'] = $isAbi = false;

        if (in_array($this->session->userdata('user_type'), array('abi'))) {

            $data['isAbi'] = $isAbi = true;

        }

        if ($this->session->userdata('user_type') == 'incubatee') {

        } else {

            $data['left_box'] = array('incubation', 'innovation_tab');

        }

        $data['custom_js'] = array('list_page');

        $this->load->vars($data);
        if ($this->session->userdata('user_type') != 'incubatee') {
            $this->load->view('../template');
        } else {
            $this->load->view('../dashboard_template');
        }
    }

    public function form($innovationid = null, $id = null)
    {

        $data['sectorarr'] = $sectorarr = array(1 => 'Agriculture', 2 => 'Water', 3 => 'Energy', 4 => 'Others');

        $data['investerDetails'] = array();

        if ($id != '') {

            $data['cpagetitle'] = "Edit Invester";

            $data['investerDetails'] = $this->Minvester->getinvesterDetails($id);

        } else {

            $data['cpagetitle'] = "Add Invester";

        }

        if (isset($_POST['txtSubmit'])) {

            if ($_POST['action'] == 'edit') {

                $options = array();

                $options = $_POST;

                $result = $this->Minvester->update($_POST);

                $msg = "Record Updated!";

            } else {

                $options = array();

                $options = $_POST;

                $result = $this->Minvester->insert($options);

                $msg = "Record Inserted!";

            }

            $this->session->set_flashdata('successMsg', $msg);

            redirect('invester/view_list/' . $innovationid);

        }

        $data['innovationid'] = $innovationid;

        $data['cpage'] = "addinvester";

        $this->load->view('../template_plain', $data);

    }

    public function allUpdate($innovationid = null, $requestid = null)
    {

        $options = array();

        $options = $_POST;

        $update = $this->Minvester->updateAll($options, $innovationid, $requestid);

        redirect('invester/investerDetail/' . $innovationid . '/' . $requestid);

    }

    public function changevillgrostatus($status = null, $innovationid = null, $id = null, $requestid = null, $investerid = null)
    {

        if ($status == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $id = $_POST['id'];

                $this->Minvester->updatevillgrostatus($options);

                $this->Minvester->investeractionHistory($options);

                redirect('invester/investerDetail/' . $innovationid . '/' . $id);

            }

            $data['cpagetitle'] = "Approve Request";

            $data['innovationid'] = $innovationid;

            $data['id'] = $id;

            $data['requestid'] = $requestid;

            $data['investerid'] = $investerid;

            $data['cpage'] = "approveRequest";

            $this->load->view('../template_plain', $data);

        } else {

            if (isset($_POST['rejectSubmit'])) {

                $options = array();

                $options = $_POST;

                $id = $_POST['id'];

                $this->Minvester->updatevillgrostatus($options);

                $this->Minvester->investeractionHistory($options);

                redirect('invester/investerDetail/' . $innovationid . '/' . $id);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['requestid'] = $requestid;

            $data['investerid'] = $investerid;

            $data['id'] = $id;

            $data['cpage'] = "rejectRequest";

            $this->load->view('../template_plain', $data);

        }

    }

    public function changeincubateestatus($status = null, $innovationid = null, $id = null, $requestid = null, $investerid = null)
    {

        if ($status == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $id = $_POST['id'];

                $this->Minvester->updateincubateestatus($options);

                redirect('invester/investerDetail/' . $innovationid . '/' . $id);

            }

            $data['cpagetitle'] = "Approve Request";

            $data['innovationid'] = $innovationid;

            $data['requestid'] = $requestid;

            $data['investerid'] = $investerid;

            $data['id'] = $id;

            $data['cpage'] = "approveincubateeRequest";

            $this->load->view('../template_plain', $data);

        } else {

            if (isset($_POST['rejectSubmit'])) {

                $options = array();

                $options = $_POST;

                $id = $_POST['id'];

                $this->Minvester->updateincubateestatus($options);

                redirect('invester/investerDetail/' . $innovationid . '/' . $id);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['requestid'] = $requestid;

            $data['investerid'] = $investerid;

            $data['id'] = $id;

            $data['cpage'] = "rejectincubateeRequest";

            $this->load->view('../template_plain', $data);

        }

    }

    public function changeinvesterstatus($status = null, $innovationid = null, $id = null, $requestid = null, $investerid = null)
    {

        if ($status == 'approve') {

            if (isset($_POST['approvesubmit'])) {

                $options = array();

                $options = $_POST;

                $id = $_POST['id'];

                $this->Minvester->updateinvesterstatus($options);

                redirect('invester/investerDetail/' . $innovationid . '/' . $id);

            }

            $data['cpagetitle'] = "Approve Request";

            $data['innovationid'] = $innovationid;

            $data['id'] = $id;

            $data['requestid'] = $requestid;

            $data['investerid'] = $investerid;

            $data['cpage'] = "approveinvesterRequest";

            $this->load->view('../template_plain', $data);

        } else {

            if (isset($_POST['rejectSubmit'])) {

                $options = array();

                $options = $_POST;

                $id = $_POST['id'];

                $this->Minvester->updateinvesterstatus($options);

                redirect('invester/investerDetail/' . $innovationid . '/' . $id);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['id'] = $id;

            $data['requestid'] = $requestid;

            $data['investerid'] = $investerid;

            $data['cpage'] = "rejectinvesterRequest";

            $this->load->view('../template_plain', $data);

        }

    }

    public function liststatus($status = null, $innovationid = null, $id = null)
    {

        if ($status == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $this->Minvester->updateliststatus($options);

                redirect('invester/view_list/' . $innovationid);

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

                $this->Minvester->updateliststatus($options);

                redirect('invester/view_list/' . $innovationid);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['id'] = $id;

            $data['cpage'] = "listReject";

            $this->load->view('../template_plain', $data);

        }

    }

    public function investerDetail($innovationid = null, $id = null, $tabid = '113', $comment = null)
    {

        $title = "Raise Investment";

        $data['statusArr'] = statusArr();

        $stageandservice = $this->Minvester->getProgramstageandProgramservice($title);

        $data['pstage'] = $stageandservice['id'];

        $data['pservice'] = $stageandservice['program_service_offering'];

        $data['isAbi'] = $isAbi = false;

        if (in_array($this->session->userdata('user_type'), array('abi'))) {

            $data['isAbi'] = $isAbi = true;

        }

        /**** This is for uploading document and comments for business document ,Pitch document ****/

        if ($tabid != "") {

            $data['requestid'] = $requestid = $id;

            if ($tabid == '113') {

                $data['tabid'] = $tabid;

                $data['commentdata'] = $this->Minvesterdoc->selectbusiness_comment($innovationid, $id);

                if ($comment != '') {

                    if (isset($_POST['commentSubmit'])) {

                        $options = array();

                        $options = $_POST;

                        $inserted = $this->Minvesterdoc->insertbusiness_comment($options);

                    }

                    redirect('invester/investerDetail/' . $innovationid . '/' . $id);

                } else {

                    $data['commentfile'] = $this->Minvesterdoc->selectbusiness_file($innovationid, $id);

                    $data['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/businessdoc/';

                    if (isset($_POST['fileSubmit'])) {

                        $options = array();

                        $options = $_POST;

                        $options['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/businessdoc/';

                        $filename = $_FILES['filedoc']['name'];

                        $file = $_FILES['filedoc'];

                        $this->doupload($options, $file);

                        $options['filename'] = $filename;

                        $insertedfile = $this->Minvesterdoc->insertbusiness_file($options);

                    }

                }

            } elseif ($tabid == '114') {

                $data['tabid'] = $tabid;

                $data['commentdata'] = $this->Minvesterdoc->selectboardresolution_comment($innovationid, $id);

                if ($comment != '') {

                    if (isset($_POST['commentSubmit'])) {

                        $options = array();

                        $options = $_POST;

                        $inserted = $this->Minvesterdoc->insertboardresolution_comment($options);

                    }

                    redirect('invester/investerDetail/' . $innovationid . '/' . $id);

                } else {

                    $data['commentfile'] = $this->Minvesterdoc->selectbusiness_file($innovationid, $id);

                    $data['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/businessdoc/';

                    if (isset($_POST['fileSubmit'])) {

                        $options = array();

                        $options = $_POST;

                        $options['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/businessdoc/';

                        $filename = $_FILES['filedoc']['name'];

                        $file = $_FILES['filedoc'];

                        $this->doupload($options, $file);

                        $options['filename'] = $filename;

                        $insertedfile = $this->Minvesterdoc->insertboardResulation_file($options);

                    }

                }

            } elseif ($tabid == '115') {

                $data['tabid'] = $tabid;

                $data['commentdata'] = $this->Minvesterdoc->selectpitch_comment($innovationid, $id);

                if ($comment != '') {

                    if (isset($_POST['commentSubmit'])) {

                        $options = array();

                        $options = $_POST;

                        $inserted = $this->Minvesterdoc->insertpitch_comment($options);

                    }

                    redirect('invester/investerDetail/' . $innovationid . '/' . $id);

                } else {

                    $data['commentfile'] = $this->Minvesterdoc->selectpitch_file($innovationid, $id);

                    $data['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/pitchdocument/';

                    if (isset($_POST['fileSubmit'])) {

                        $options = array();

                        $options = $_POST;

                        $options['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/pitchdocument/';

                        $filename = $_FILES['filedoc']['name'];

                        $file = $_FILES['filedoc'];

                        $this->doupload($options, $file);

                        $file = $_FILES['filedoc'];

                        $options['filename'] = $filename;

                        $insertedfile = $this->Minvesterdoc->insertpitchDocument_file($options);

                    }

                }

            }

        }

        /****** End *****/

        $data['cpagetitle'] = "Invester Request";

        $data['statusarr'] = statusArr();

        $data['pubarr'] = publishArr();

        $masterType = 'Invester Document';

        if ($id != '') {

            $data['investerDetails'] = $this->Minvester->getinvesterDetails($id);

            $data['id'] = $id;

        }

        $incubatsession = $this->session->userdata('is_incubatee');

        $data['assignedinvester'] = $this->Minvester->assignedinvester($innovationid, $id);

        $data['match'] = $this->Minvester->matchDocumentMaster($masterType, $innovationid);

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        $data['innovationid'] = $innovationid;

        /**** For adding left box ****/

        /**** End ***/

        $data['cpage'] = "investerdetail";

        $data['document'] = $this->Mmaster_settings->getMasterSetting($masterType);

        $data['isincubAuth'] = "false";

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubation');

        } else {

            $data['left_box'] = array('innovation_tab');

        }

        $this->load->vars($data);

        $this->load->view('../template');

    }

    public function documentDelete($innovation = null, $id = null, $docName = null, $tabKey = '')
    {

        if ($id != '' and $docName != '') {

            $result = $this->Minvesterdoc->deleteDocByID($id, $docName);

            $filepath = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/pitchdocument/';

            $fullFilePath = $filepath . $docName;

            if (is_file($fullFilePath)) {

                unlink($fullFilePath);

            }

            $this->session->set_flashdata('successMsg', 'Document deleted Successfully');

            redirect('invester/investerDetail/' . $innovation . '/' . $id . '/' . $tabKey . '/');

        }

    }

    public function deleteComments($createdDate = null, $innovation = null, $id = '', $tabkey = null)
    {

        $result = $this->Minvesterdoc->deleteCommentsByID($id, $createdDate);

        $this->session->set_flashdata('successMsg', 'Comments deleted Successfully');

        redirect('invester/investerDetail/' . $innovation . '/' . $id . '/' . $tabkey . '/');

    }

    public function doupload($options, $file)
    {

        if ($file['name'] != '') {

            $filename = $file['name'];

            $_FILES['ty']['name'] = $file['name'];

            $_FILES['ty']['tmp_name'] = $file['tmp_name'];

            $_FILES['ty']['size'] = $file['size'];

            $_FILES['ty']['error'] = $file['error'];

            $_FILES['ty']['type'] = $file['type'];

            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $filename);

            $config['upload_path'] = $options['path'];

            $config['allowed_types'] = '*';

            $config['file_name'] = $filename;

            $this->load->library('upload', $config);

            $this->upload->do_upload('ty');

        }

    }

    public function agreement($innovationid, $id, $investerid, $rowid = null)
    {

        $data['innovationid'] = $innovationid;

        $data['investerid'] = $investerid;

        $data['id'] = $id;

        $data['isincubAuth'] = "false";

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubation');

        } else {

            $data['left_box'] = array('innovation_tab');

        }

        if (isset($_POST['fileSubmit'])) {

            $options = array();

            $options = $_POST;

            if ($options['uploadby'] == 'Invester') {

                if ($_FILES['investerfiledoc']['name'] != '') {

                    $options['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/agreement/investeragreement';

                    $filename = $_FILES['investerfiledoc']['name'];

                    $file = $_FILES['investerfiledoc'];

                    $this->doupload($options, $file);

                } else {

                    $filename = "";

                }

            } else {

                if ($_FILES['incubateefiledoc']['name'] != '') {

                    $filename = $_FILES['incubateefiledoc']['name'];

                    $options['path'] = '../ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/invester/agreement/incubateeagreement';

                    $file = $_FILES['incubateefiledoc'];

                    $this->doupload($options, $file);

                } else {

                    $filename = "";

                }

            }

            $options['filename'] = $filename;

            $options['id'] = $_POST['id'];

            $options['uploadby'] = $options['uploadby'];

            $updatefile = $this->Minvesterdoc->updateagreement_file($options);

            $this->session->set_flashdata('successMsg', 'Document Uploaded Successfully!');

            redirect('invester/investerDetail/' . $innovationid . '/' . $id);

        }

        $data['rowdata'] = $this->Minvesterdoc->findagreementDoc($id);

        $data['cpagetitle'] = "Terms & Condition";

        $data['cpage'] = "agreement";

        $this->load->vars($data);

        $this->load->view('../template_plain', $data);

    }

    public function suggestInvester($innovationid = null, $id = null)
    {

        if (isset($_POST['txtSubmit'])) {

            $suggest = array();

            foreach ($_POST['check'] as $value) {

                $suggest[] = $value;

            }

            $id = $_POST['id'];

            $suggestmember = $this->Minvester->insertSuggestInvester($innovationid, $id, $suggest);

            redirect('invester/investerDetail/' . $innovationid . '/' . $id);

        }

        $data['sectorar'] = sectorArray();

        $options = array();

        $options = $_POST;

        $searchinvester = array();

        $data['ordertype'] = $this->input->post('ordertype');

        $data['orderby'] = $this->input->post('orderby');

        $searchinvester = $this->Minvester->searchinvester($options);

        $data['searchinvester'] = $searchinvester;

        /*** This all information to check whether user is incubateee or not ***/

        $data['isincubAuth'] = false;

        $incubatsession = $this->session->userdata('is_incubatee');

        $data['innovationid'] = $innovationid;

        $data['cpagetitle'] = "Suggest Invester";

        $data['id'] = $id;

        $data['cpage'] = "suggestinvester";

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubatee');

        } else {

            $data['left_box'] = array('innovation_tab');

        }

        $this->load->vars($data);

        $this->load->view('../template');

    }

    public function assigninvesterDetail($innovationid = null, $investerid = null)
    {

        $investertotaldetail = $this->Minvester->assigninvesterDetail($innovationid, $investerid);

        $data['investertotaldetail'] = $investertotaldetail;

        $data['cpage'] = "masterinvesterdetail";

        $data['cpagetitle'] = "Invester Detail";

        $this->load->vars($data);

        $this->load->view('../template_plain', $data);

    }

    public function masterinvesterDetail($innovationId, $investerID)
    {

        $data['investertotaldetail'] = $investertotaldetail = $this->Minvester->masterinvesterDetail($investerID);

        $data['cpage'] = "masterinvesterdetail";

        $data['cpagetitle'] = "Invester Detail";

        $this->load->vars($data);

        $this->load->view('../template_plain', $data);

    }

    public function requestDoc($innovationid = null, $id = null)
    {

        if (isset($_POST['txtSubmit'])) {

            $options = array();

            $options = $_POST;

            $this->Minvester->assignChecklist($options);

            $this->session->set_flashdata('successMsg', 'Checklist Assigned Successfully!');

            redirect('invester/investerDetail/' . $innovationid . '/' . $id);

        }

        $checkboxval = $this->Minvester->getMasterSettingsbyinnovation($innovationid);

        $checkbox = array();

        if (!empty($checkboxval)) {

            $data['checkbox'] = $checkbox = $checkboxval[0]['checklist'];

        } else {

            $data['checkbox'] = "";

        }

        $data['innovationid'] = $innovationid;

        $data['id'] = $id;

        $masterType = 'Invester Document';

        $data['cpagetitle'] = "Request Document";

        $document = $this->Mmaster_settings->getMasterSetting($masterType);

        $data['document'] = $document;

        $data['cpage'] = "requestdocument";

        $this->load->view('../template_plain', $data);

    }

    public function actionHistory($investerid = null)
    {

        $data = array();

        $data['historylist'] = $this->Minvester->getactionHistory($investerid);

        $data['cpagetitle'] = "Action History";

        $data['cpage'] = "actionHistory";

        $data['stage'] = $this->Minvester->statusArr();

        $this->load->view('../template_plain', $data);

    }

    public function investerincubateeComments($innovation = null, $id = null, $returnid = null)
    {

        $data['cpagetitle'] = "Incubatee Comments";

        $data['innovation'] = $innovation;

        $data['id'] = $id;

        $data['returnid'] = $returnid;

        if (isset($_POST['txtSubmit'])) {

            $options = array();

            $options = $_POST;

            $returnid = $_POST['returnid'];

            $inubateecomments = $this->Minvester->insertincubateeComments($innovation, $id, $options);

            redirect('invester/investerDetail/' . $innovation . '/' . $returnid);

        }

        $data['selectComments'] = array();

        $data['selectComments'] = $this->Minvester->selectincubateeComments($innovation, $id);

        $data['cpage'] = "investerincubateecomments";

        $this->load->view('../template_plain', $data);

    }

    public function investermemberComments($innovation = null, $id = null, $returnid = null)
    {

        $data['cpagetitle'] = "Invester Member Comments";

        $data['innovation'] = $innovation;

        $data['id'] = $id;

        $data['returnid'] = $returnid;

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

        }

        if (isset($_POST['txtSubmit'])) {

            $options = array();

            $options = $_POST;

            $comments = $this->Minvester->insertinvestermemberComments($innovation, $id, $options);

            $returnid = $_POST['returnid'];

            redirect('invester/investerDetail/' . $innovation . '/' . $returnid);

        }

        $data['selectComments'] = array();

        $data['selectComments'] = $searchmastermember = $this->Minvester->selectinvestermemberComments($innovation, $id);

        $data['cpage'] = "investermembercomments";

        $this->load->view('../template_plain', $data);

    }

}
