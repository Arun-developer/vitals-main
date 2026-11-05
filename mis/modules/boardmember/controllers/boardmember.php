<?php

/*-

 * Masters Module Controller

 * This section for setting  purpose

 *

 * Master's Controller

 * @quadrupleindia.com

 * author - Prabakar

 */

class Boardmember extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->items_perpage = '15';
        $this->load->model('Massociate_boardmember');
        $this->load->model('scouting/Minnovation');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        redirect('boardmember/view_list/' . $innovation);
    }

    public function view_list($innovationid)
    {
        $options = array();
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);
        $options['innovationid'] = $innovationid;
        $data['boardList'] = $this->Massociate_boardmember->getLimitRecords($options);
        $data['orderby'] = $this->input->post('sort_column');
        $data['ordertype'] = $this->input->post('sort_order');
        $data['innovationid'] = $innovationid;
        $data['isincubAuth'] = false;
        $data['cpagetitle'] = "Board Meeting";
        $data['innovation'] = $inno = $this->Minnovation->getInnovation($innovationid);
        if ($inno['partner_id'] != '1' || $inno['partner_id'] != '01') {
            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login');
        }

        $data['requeststatus'] = requestStatus();
        $data['statusArr'] = statusArr();

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $data['isincubAuth'] = $isincubAuth = false;
        if (in_array($this->session->userdata('user_type'), array('incubatee'))) {
            $data['isincubAuth'] = $isincubAuth = true;
        } else {
            $data['left_box'] = array('incubation', 'innovation_tab');
        }

        $data['isAbi'] = $isAbi = false;
        if (in_array($this->session->userdata('user_type'), array('abi'))) {
            $data['isAbi'] = $isAbi = true;
        }

        $data['cpage'] = "listboardmember";
        $this->load->vars($data);
        if ($this->session->userdata('user_type') != 'incubatee') {
            $this->load->view('../template');
        } else {
            $this->load->view('../dashboard_template');
        }

    }

    public function form($innovationid = null, $id = null)
    {
        $data['memberDetails'] = array();

        if ($id != '') {

            $data['cpagetitle'] = "Edit Board Member Request";

            $data['memberDetails'] = $this->Massociate_boardmember->getmemberDetails($id);

        } else {

            $data['cpagetitle'] = "Add Board Member Request";

        }

        if (isset($_POST['txtSubmit'])) {

            if ($_POST['action'] == 'edit') {

                $options = array();

                $options = $_POST;

                $result = $this->Massociate_boardmember->update($_POST);

                $msg = "Record Updated!";

            } else {

                $options = array();

                $options = $_POST;

                $result = $this->Massociate_boardmember->insert($options);

                $msg = "Record Inserted!";

            }

            $this->session->set_flashdata('successMsg', $msg);

            redirect('boardmember/view_list/' . $innovationid);

        }

        $data['innovationid'] = $innovationid;

        $data['cpage'] = "addboard_member";

        $this->load->view('../template_plain', $data);

    }

    public function liststatus($status = null, $innovationid = null, $id = null)
    {

        if ($status == 'approve') {

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $this->Massociate_boardmember->updateliststatus($options);

                redirect('boardmember/view_list/' . $innovationid);

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

                $this->Massociate_boardmember->updateliststatus($options);

                redirect('boardmember/view_list/' . $innovationid);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['id'] = $id;

            $data['cpage'] = "listReject";

            $this->load->view('../template_plain', $data);

        }

    }

    /**

     * Function : delete method is used for delete vendors.

     *

     * @param int $id

     *

     */

    public function delete($id = '')
    {

        if ($id != '') {

            $result = $this->Mvendor->delete($id);

            $this->session->set_flashdata('successMsg', 'Vendor deleted Success fully');

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/vendor/view_list');

    }

    public function changevillgrostatus($status, $innovationid, $id, $requestid = null, $boardid = null)
    {

        if ($status == 'approve') {

            $data['id'] = $id;

            $data['innovationid'] = $innovationid;

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $detailid = $options['detailid'];

                $boardid = $options['boardid'];

                $innovationid = $options['innovationid'];

                $boardid = $options['boardid'];

                $boardmemberinfo = $this->Massociate_boardmember->selectboardmemberinfo($boardid);

                $this->Massociate_boardmember->updatevillgrostatus($options);

                $this->Massociate_boardmember->memberactionHistory($options);

                $options['innovationid'] = $innovationid;

                $options['members'] = $boardmemberinfo['first_name'];

                $options['profile'] = $boardmemberinfo['comments'];

                $this->Massociate_boardmember->insertscreenbooarddetails($options);

                redirect('boardmember/memberDetail/' . $innovationid . '/' . $detailid);

            }

            $data['cpagetitle'] = "Approve Request";

            $data['requestid'] = $requestid;

            $data['boardid'] = $boardid;

            $data['cpage'] = "approveRequest";

            $this->load->view('../template_plain', $data);

        } else {

            $data['id'] = $id;

            if (isset($_POST['rejectSubmit'])) {

                $options = array();

                $options = $_POST;

                $innovationid = $options['innovationid'];

                $this->Massociate_boardmember->updatevillgrostatus($options);

                $this->Massociate_boardmember->memberactionHistory($options);

                $detailid = $options['detailid'];

                redirect('boardmember/memberDetail/' . $innovationid . '/' . $detailid);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['requestid'] = $requestid;

            $data['boardid'] = $boardid;

            $data['cpage'] = "rejectRequest";

            $this->load->view('../template_plain', $data);

        }

    }

    public function changeincubateestatus($status, $innovationid, $id, $requestid = null, $boardid = null)
    {

        if ($status == 'approve') {

            $data['id'] = $id;

            $data['innovationid'] = $innovationid;

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $detailid = $options['detailid'];

                $requestid = $options['requestid'];

                $innovationid = $options['innovationid'];

                $boardid = $options['boardid'];

                $this->Massociate_boardmember->updateincubateestatus($options);

                $options['document_description'] = $status;

                $options['description'] = $options['comments'];

                $this->Massociate_boardmember->insertboardmemeberComments($innovationid, $requestid, $options);

                $detailid = $_POST['detailid'];

                redirect('boardmember/memberDetail/' . $innovationid . '/' . $detailid);

            }

            $data['cpagetitle'] = "Approve Request";

            $data['requestid'] = $requestid;

            $data['boardid'] = $boardid;

            $data['cpage'] = "approveincubateeRequest";

            $this->load->view('../template_plain', $data);

        } else {

            $data['id'] = $id;

            if (isset($_POST['rejectSubmit'])) {

                $options = array();

                $options = $_POST;

                $innovationid = $options['innovationid'];

                $this->Massociate_boardmember->updateincubateestatus($options);

                $options['document_description'] = $status;

                $options['description'] = $options['comments'];

                $this->Massociate_boardmember->insertincubateeComments($innovationid, $requestid, $options);

                $detailid = $_POST['detailid'];

                redirect('boardmember/memberDetail/' . $innovationid . '/' . $detailid);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['requestid'] = $requestid;

            $data['boardid'] = $boardid;

            $data['cpage'] = "rejectincubateeRequest";

            $this->load->view('../template_plain', $data);

        }

    }

    public function changememberstatus($status, $innovationid, $id, $requestid = null, $boardid = null)
    {

        if ($status == 'approve') {

            $data['id'] = $id;

            $data['innovationid'] = $innovationid;

            if (isset($_POST['approveSubmit'])) {

                $options = array();

                $options = $_POST;

                $detailid = $options['detailid'];

                $requestid = $options['requestid'];

                $innovationid = $options['innovationid'];

                $boardid = $options['boardid'];

                $this->Massociate_boardmember->updatememberstatus($options);

                $options['document_description'] = $status;

                $options['description'] = $options['comments'];

                $this->Massociate_boardmember->insertincubateeComments($innovationid, $requestid, $options);

                redirect('boardmember/memberDetail/' . $innovationid . '/' . $detailid);

            }

            $data['cpagetitle'] = "Approve Request";

            $data['requestid'] = $requestid;

            $data['boardid'] = $boardid;

            $data['cpage'] = "approvememberRequest";

            $this->load->view('../template_plain', $data);

        } else {

            $data['id'] = $id;

            if (isset($_POST['rejectSubmit'])) {

                $options = array();

                $options = $_POST;

                $innovationid = $options['innovationid'];

                $this->Massociate_boardmember->updatememberstatus($options);

                $options['document_description'] = $status;

                $options['description'] = $options['comments'];

                $this->Massociate_boardmember->insertboardmemeberComments($innovatioinid, $requestid, $options);

                redirect('boardmember/memberDetail/' . $innovationid . '/' . $detailid);

            }

            $data['cpagetitle'] = "Reject Request";

            $data['innovationid'] = $innovationid;

            $data['requestid'] = $requestid;

            $data['boardid'] = $boardid;

            $data['cpage'] = "rejectmemberRequest";

            $this->load->view('../template_plain', $data);

        }

    }

    public function memberDetail($innovationid = null, $id = null)
    {

        /***** For Activities ****/

        $title = "Board Formation";

        $stageandservice = $this->Massociate_boardmember->getProgramstageandProgramservice($title);

        $data['pstage'] = $stageandservice['id'];

        $data['pservice'] = $stageandservice['program_service_offering'];

        /****** End ****/

        /***** Checking no of boardmember to close request ****/

        $data['nboardmember'] = $this->Massociate_boardmember->getnoboardmemberAssigned($innovationid, $id);

        if ($data['nboardmember']['total'] == $data['nboardmember']['no_boardmember']) {

            $this->Massociate_boardmember->closRequest($id);

        }

        /**** End ***/

        $data['cpagetitle'] = "Board Member Request";

        $data['statusArr'] = statusArr();

        $data['pubarr'] = publishArr();

        if ($id != '') {

            $data['memberDetails'] = $this->Massociate_boardmember->getmemberDetails($id);

            $data['id'] = $id;

        }

        $incubatsession = $this->session->userdata('is_incubatee');

        $data['assignedmember'] = $this->Massociate_boardmember->assignedBoardmember($innovationid, $id);

        $data['innovationid'] = $innovationid;

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $data['cpage'] = "memberdetail";

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

            $data['left_box'] = array('incubation');

        } else {

            $data['isincubAuth'] = false;

            $data['left_box'] = array('incubation', 'innovation_tab');

        }

        $data['isAbi'] = $isAbi = false;

        if (in_array($this->session->userdata('user_type'), array('abi'))) {

            $data['isAbi'] = $isAbi = true;

        }

        $this->load->vars($data);

        $this->load->view('../template');

    }

    public function allUpdate($innovation = null, $detailid = null)
    {

        $options = array();

        $options = $_POST;

        $update = $this->Massociate_boardmember->updateAll($options, $innovation);

        redirect('boardmember/memberDetail/' . $innovation . '/' . $detailid);

    }

    public function suggestMember($innovationid = null, $id = null)
    {

        $data['sectorar'] = sectorArray();

        $options = array();

        $options = $_POST;

        $searchmember = array();

        $data['ordertype'] = $this->input->post('ordertype');

        $data['orderby'] = $this->input->post('orderby');

        $assigndata = $this->Massociate_boardmember->assignedBoardmember($innovationid);

        $assign = array();

        foreach ($assigndata as $value) {

            $assign[] = $value['board_id'];

        }

        $data['assign'] = $assign;

        $searchmember = $this->Massociate_boardmember->searchBoardmember($options);

        $data['searchmember'] = $searchmember;

        /*** This all information to check whether user is incubateee or not ***/

        $data['isincubAuth'] = false;

        $incubatsession = $this->session->userdata('is_incubatee');

        $data['innovationid'] = $innovationid;

        $data['cpagetitle'] = "Suggest Board Members";

        $data['id'] = $id;

        $data['cpage'] = "suggestmember";

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

    public function suggestSubmit($innovationid = null, $id = null)
    {

        if (isset($_POST['txtSubmit'])) {

            $suggest = array();

            foreach ($_POST['check'] as $value) {

                $suggest[] = $value;

            }

        }

        /**** For adding left box ****/

        $data['innovation'] = $this->Minnovation->getInnovation($innovationid);

        /**** End ***/

        $suggestmember = $this->Massociate_boardmember->insertSuggestMember($innovationid, $id, $suggest);

        redirect('boardmember/memberDetail/' . $innovationid . '/' . $id);

    }

    public function masterMemberDetail($innovationid = null, $boardid)
    {

        $data['cpagetitle'] = "Board Member Profile";

        $data['boardmemberdetail'] = $this->Massociate_boardmember->mastermemeberDetail($innovationid, $boardid);

        $data['cpage'] = "mastermemberdetail";

        $this->load->view('../template_plain', $data);

    }

    public function boardmemberComments($innovation = null, $id = null, $boardid = null)
    {

        $data['cpagetitle'] = "Board Member Comments";

        $data['innovation'] = $innovation;

        $data['id'] = $id;

        $data['boardid'] = $boardid;

        $data['isincubAuth'] = false;

        if ($this->session->userdata('user_type') == 'incubatee') {

            $data['isincubAuth'] = true;

        }

        if (isset($_POST['txtSubmit'])) {

            $options = array();

            $options = $_POST;

            $comments = $this->Massociate_boardmember->insertboardmemeberComments($innovation, $id, $options);

            redirect('boardmember/memberDetail/' . $innovation . '/' . $boardid);

        }

        $data['selectComments'] = array();

        $data['selectComments'] = $searchmastermember = $this->Massociate_boardmember->selectboardmemberComments($innovation, $id);

        $data['cpage'] = "boardmembercomments";

        $this->load->view('../template_plain', $data);

    }

    public function boardincubateeComments($innovation = null, $memberid = null, $id = null)
    {

        $data['cpagetitle'] = "Incubatee Comments";

        $data['innovation'] = $innovation;

        $data['id'] = $id;

        if (isset($_POST['txtSubmit'])) {

            $options = array();

            $options = $_POST;

            $id = $_POST['id'];

            $inubateecomments = $this->Massociate_boardmember->insertincubateeComments($innovation, $id, $options);

            redirect('boardmember/memberDetail/' . $innovation . '/' . $id);

        }

        $data['selectComments'] = array();

        $data['selectComments'] = $this->Massociate_boardmember->selectincubateeComments($innovation, $id);

        $data['cpage'] = "boardincubateecomments";

        $this->load->view('../template_plain', $data);

    }

    /**

     * Function : changestatus method is used for Changing Status of the vendors.

     *

     * @param int $id,

     * @param var $status

     *

     */

    public function changestatus($id = '', $status = '')
    {

        if ($id != '' && $status != '') {

            $options = array('vendor_id' => $id, 'status' => $status);

            $this->Mvendor->changeStatus($options);

            $this->session->set_flashdata('successMsg', 'Vendor Status updated');

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        redirect('master/vendor/view_list');

    }

    public function actionHistory($boardid = null, $innovationid = null)
    {

        $data['historylist'] = array();

        $data['historylist'] = $this->Massociate_boardmember->getactionHistory($boardid);

        $data['cpagetitle'] = "Action History";

        $data['cpage'] = "actionHistory";

        $data['stage'] = $this->Massociate_boardmember->statusArr();

        $this->load->view('../template_plain', $data);

    }

    public function previousHistory($boardid = null, $innovationid = null)
    {

        $data['previouslist'] = $this->Massociate_boardmember->getpreviousHistory($boardid, $innovationid);

        $data['cpagetitle'] = "Previous History";

        $data['cpage'] = "previousHistory";

        $data['stage'] = $this->Massociate_boardmember->statusArr();

        $this->load->view('../template_plain', $data);

    }

}
