<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author -
 */
class Incubationprogress extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->items_perpage = '15';
        $this->load->model('Mincubationprogress');
        $this->load->model('scouting/Minnovation');
        $this->load->model('login/Muser');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        if (isset($_POST)) {
            $this->Mincubationprogress->update_data($_POST['field'], $_POST['data'], $_POST['rownum']);
            redirect('Incubationprogress/form');
        }
    }

    public function form($innovation, $mastertype = null, $mastername = null, $type = null, $subcategory = null, $frequency = null, $yearly = null, $monthly = null, $quarterly = null, $weekly = null)
    {
        $data['mastertype'] = $this->Mincubationprogress->getmastertype();
        $data['innovation'] = $this->Minnovation->getInnovation($innovation);
        $data['innovation'] = $innovation;
        $data['type'] = array('metrices', 'activity');
        $data['frequency'] = array('Weekly' => 1, 'Monthly' => 2, 'Quarterly' => 3, 'Yearly' => 4);
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['quarterly'] = array('1', '2', '3', '4');
        $data['weekly'] = array('1', '2', '3', '4', '5');
        $mastertype = urldecode($mastertype);
        $mastername = urldecode($mastername);
        $type = urldecode($type);
        $subcategory = urldecode($subcategory);
        if ($mastertype == null) {
            $mastertype = $data['mastertype'][0]['master_type'];
        }
        $data['defaultms'] = $mastertype;
        $data['submastertype'] = $this->Mincubationprogress->getsubmastertype($mastertype);
        if ($mastername == null) {
            $mastername = $data['submastertype'][0]['master_name'];
        }
        $data['defaultsubms'] = $mastername;
        if ($type == null) {
            $type = $data['type'][0];
        }
        $data['defaulttype'] = $type;
        if ($type == 'metrices') {
            $data['subcategory'] = $this->Mincubationprogress->getsubcategory($mastertype, $mastername, $type);

            if ($subcategory == null) {
                $subcategory = $data['subcategory'][0]['subcategory'];
            }
            $data['defaultsubcategory'] = $subcategory;
        }
        if ($frequency == null) {
            $frequency = $data['frequency']['Monthly'];
        }
        $data['defaultfrequency'] = $frequency;
        if ($frequency != '4') {
            if ($yearly == null) {
                $yearly = date('Y');
            }
            $data['defaultyearly'] = $yearly;
            if ($monthly == null) {
                $monthly = date('m');
            }
            $data['defaultmonthly'] = $monthly;
            if ($quarterly == null) {
                $quarterly = $data['quarterly'][0];
            }
            $data['defaultquarterly'] = $quarterly;
            if ($weekly == null) {
                $weekly = $data['weekly'][0];
            }
            $data['defaultweekly'] = $weekly;
        }
        if ($frequency == '1') {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];
            $data['weekreport'] = $this->Mincubationprogress->getweekreport($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);
            for ($i = 0; $i < count($data['weekly']); $i++) {
                $data['weekanswerreport' . $i] = $this->Mincubationprogress->getweekanswerreport($frequency, $data['innovationChecklist'], $innovation, $monthly, $subcategory, $yearly, $type, $mastertype, $criteria);
            }
        }
        if ($frequency == '2') {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];
            $data['monthreport'] = $this->Mincubationprogress->getmonthreport($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);
            
            for ($i = 0; $i < count($data['monthly']); $i++) {
                $data['monthanswerreport' . $i] = $this->Mincubationprogress->getmonthanswerreport($frequency, $data['innovationChecklist'], $innovation, $data['monthly'][$i], $subcategory, $yearly, $type, $mastertype, $criteria);
            }
        }
        if ($frequency == '3') {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];
            $data['quarterlyreport'] = $this->Mincubationprogress->getquarterlyreport($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);
            
            for ($i = 0; $i < count($data['quarterly']); $i++) {
                $data['quarterreport' . $i] = $this->Mincubationprogress->getquarterreport($frequency, $data['innovationChecklist'], $innovation, $data['quarterly'][$i], $subcategory, $yearly, $type, $mastertype, $criteria);
            }
        } else {
            $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
            $data['criteria'] = $this->Mincubationprogress->getcriteria($mastername);
            $criteria = $data['criteria'][0]['id'];
            $data['yearreport'] = $this->Mincubationprogress->getyear_report($innovation, $criteria, $data['innovationChecklist'], $type, $frequency, $subcategory);
            for ($i = 0; $i < count($data['yearly']); $i++) {
                $data['yearanswerreport' . $i] = $this->Mincubationprogress->getyearanswerreport($frequency, $data['innovationChecklist'], $innovation, $data['yearreport'], $subcategory, $data['yearly'][$i], $type, $mastertype, $criteria);
            }
        }
        $data['company'] = $this->Minnovation->getInnovation($innovation);
        $data['name_of_enterprise'] = $data['company']['name_of_enterprise'];
        $data['cpage'] = "form";
        if ($this->session->userdata('user_type') != 'incubatee') {
            $data['left_box'] = array('incubation', 'innovation_tab');
        } else {
            $data['left_box'] = array('incubation');
        }

        $data['cpagetitle'] = "Incubation Progress";
        $this->load->view('../template', $data);
    }
    public function update()
    {

        $start_date = '';
        $end_date = '';
        $post = $this->input->post('value');
        if ($_POST['frequency'] == 3) {
            switch ($_POST['months']) {

                case "1":
                    $start_date = date('Y-m-01', strtotime('January' . $_POST['year']));
                    $end_date = date('Y-m-t', strtotime('March' . $_POST['year']));

                    break;
                case "2":
                    $start_date = date('Y-m-01', strtotime('April' . $_POST['year']));
                    $end_date = date('Y-m-t', strtotime('June' . $_POST['year']));

                    break;
                case "3":

                    $start_date = date('Y-m-01', strtotime('July' . $_POST['year']));
                    $end_date = date('Y-m-t', strtotime('September' . $_POST['year']));
                    break;
                case "4":
                    $start_date = date('Y-m-01', strtotime('October' . $_POST['year']));
                    $end_date = date('Y-m-t', strtotime('December' . $_POST['year']));
                    break;
            }
        } elseif ($_POST['frequency'] == '2') {
            if ($_POST['type'] == 'metrices') {
                $months = date("M", mktime(0, 0, 0, $_POST['months'], 1, 2000));
                $date = $_POST['year'] . $months;
            } else {
                $months = date("M", mktime(0, 0, 0, $_POST['months'] + 1, 1, 2000));
                $date = $_POST['year'] . $months;
            }
            $start_date = date('Y-m-01', strtotime($date));
            $end_date = date('Y-m-t', strtotime($date));
        } else {
            $start_date = date('Y-m-01', strtotime('January' . $_POST['year']));
            $end_date = date('Y-m-t', strtotime('December' . $_POST['year']));
        }
        $this->Mincubationprogress->update_data($_POST['field'], $post, $_POST['rownum'], $start_date, $end_date, $_POST['frequency'], $_POST['type'], $_POST['innovation']);

    }

    public function fileupload($innovation = null, $year = null, $type = null, $month = null, $criteria = null, $field = null, $frequency = null)
    {
        $data['year'] = $year;
        $data['criteria'] = $criteria;
        $data['field'] = $field;
        $data['month'] = $month;
        $data['innovation'] = $innovation;
        $data['type'] = $type;
        $data['frequency'] = $frequency;
        if (isset($_POST['txtSubmit'])) {
            $options = array();
            $options = $_POST;
            if ($_POST['frequency'] == '2') {
                $date = $_POST['year'] . $_POST['month'];
                $start_date = date('Y-m-01', strtotime($date));
                $end_date = date('Y-m-t', strtotime($date));

            } elseif ($_POST['frequency'] == '3') {
                switch ($_POST['month']) {

                    case "1":
                        $start_date = date('Y-m-01', strtotime('January' . $_POST['year']));
                        $end_date = date('Y-m-t', strtotime('March' . $_POST['year']));

                        break;
                    case "2":
                        $start_date = date('Y-m-01', strtotime('April' . $_POST['year']));
                        $end_date = date('Y-m-t', strtotime('June' . $_POST['year']));

                        break;
                    case "3":

                        $start_date = date('Y-m-01', strtotime('July' . $_POST['year']));
                        $end_date = date('Y-m-t', strtotime('September' . $_POST['year']));
                        break;
                    case "4":
                        $start_date = date('Y-m-01', strtotime('October' . $_POST['year']));
                        $end_date = date('Y-m-t', strtotime('December' . $_POST['year']));
                        break;
                }
            } else {
                $start_date = date('Y-m-01', strtotime('January' . $_POST['year']));
                $end_date = date('Y-m-t', strtotime('December' . $_POST['year']));
            }
            $options['start_date'] = $start_date;
            $options['end_date'] = $end_date;
            $options['uploadpath'] = './uploads/';
            $this->upload($options);
            $filename = $_FILES['userfile']['name'];
            $options['filename'] = $filename;
            $this->Mincubationprogress->insertdocument($options);
            redirect('incubationprogress/form/' . $options['innovation']);
        }
        $data['cpage'] = 'file_upload';
        $data['cpagetitle'] = 'File Upload';
        $this->load->view('../template_plain', $data);
    }
    public function upload()
    {
        if (count($_FILES["userfile"]['name']) > 0) { //check if any file uploaded
            $GLOBALS['msg'] = ""; //initiate the global message
            for ($j = 0; $j < count($_FILES["userfile"]['name']); $j++) { //loop the uploaded file array
                $filen = $_FILES["userfile"]['name']["$j"]; //file name
                $path = 'uploads/' . $filen; //generate the destination path
                if (move_uploaded_file($_FILES["userfile"]['tmp_name']["$j"], $path)) { //upload the file
                    $GLOBALS['msg'] .= "File# " . ($j + 1) . " ($filen) uploaded successfully<br>"; //Success message
                }
            }
        } else {
            $GLOBALS['msg'] = "No files found to upload"; //Failed message
        }
    }
    public function articleupload($options)
    {
        if ($_FILES['userfile']['name'] != '') {
            $filename = $_FILES['userfile']['name'];
            $_FILES['ty']['name'] = $_FILES['userfile']['name'];
            $_FILES['ty']['tmp_name'] = $_FILES['userfile']['tmp_name'];
            $_FILES['ty']['size'] = $_FILES['userfile']['size'];
            $_FILES['ty']['error'] = $_FILES['userfile']['error'];
            $_FILES['ty']['type'] = $_FILES['userfile']['type'];
            $config['file_name'] = rand() . "_" . str_replace(' ', '_', $filename);
            $config['upload_path'] = $options['uploadpath'];
            $config['allowed_types'] = '*';
            $config['file_name'] = $filename;
            $this->load->library('upload');
            $this->upload->initialize($config);
            $data['success_msg'] = $this->upload->do_upload('ty'); //exit
        }
    }
    public function assign($year = null, $month = null, $label = null, $type = null, $id = null)
    {
        $data['year'] = $year;
        $data['month'] = $month;
        $data['label'] = $label;
        $data['type'] = $type;
        $data['lbl'] = $this->Mincubationprogress->getlabel($label);
        $data['innovation'] = $id;
        if (isset($_POST['txtSubmit'])) {
            $this->Mincubationprogress->insertassign($_POST);
            redirect('incubationprogress/form/' . $_POST['id']);
        }
        $data['usersList'] = $this->Muser->getUsersList();
        $data['fellowList'] = $this->Mincubationprogress->getfellowList();
        $data['cpage'] = 'assign';
        $this->load->view('../template_plain', $data);
    }
    public function formula($innovation = null)
    {
        $data['innovationChecklist'] = $this->Mincubationprogress->getAssignedChecklist($innovation);
        $data['ratioslabel'] = $this->Mincubationprogress->getratios($innovation, $data['innovationChecklist']);
        $data['criteria'] = $this->Mincubationprogress->getcriteria('Accounting System');
        $criteria = $data['criteria'][0]['id'];
        $type = 'metrices';
        $data['innovation'] = $innovation;
        $data['labelsList'] = $this->Mincubationprogress->getmonthreport($innovation, $criteria, $data['innovationChecklist'], $type, '2');
        if (isset($_POST['txtSubmit'])) {
            $innovation = $_POST['innovation'];
            unset($_POST['innovation']);
            unset($_POST['txtSubmit']);
            $this->Mincubationprogress->insertanswer($innovation, $_POST);
            redirect('incubationprogress/form/' . $innovation);
        }
        $data['cpage'] = 'formula';
        $data['cpagetitle'] = 'Adding Formula';
        $this->load->view('../dashboard_template', $data);

    }
    public function doneactivity($label, $innovation)
    {
        $result = $this->Mincubationprogress->activitydone($label, $innovation);
        redirect('incubator_metrics/wglobal_report/index/' . $innovation . '/2/sub');
    }
    public function insertlist()
    {
        if ($this->input->post('label')) {
            if ($_POST['frequency'] == '2') {
                $date = $_POST['year'] . $_POST['month'];
                $start_date = date('Y-m-01', strtotime($date));
                $end_date = date('Y-m-t', strtotime($date));

            } elseif ($_POST['frequency'] == '3') {
                switch ($_POST['month']) {

                    case "1":
                        $start_date = date('Y-m-01', strtotime('January' . $_POST['year']));
                        $end_date = date('Y-m-t', strtotime('March' . $_POST['year']));

                        break;
                    case "2":
                        $start_date = date('Y-m-01', strtotime('April' . $_POST['year']));
                        $end_date = date('Y-m-t', strtotime('June' . $_POST['year']));

                        break;
                    case "3":

                        $start_date = date('Y-m-01', strtotime('July' . $_POST['year']));
                        $end_date = date('Y-m-t', strtotime('September' . $_POST['year']));
                        break;
                    case "4":
                        $start_date = date('Y-m-01', strtotime('October' . $_POST['year']));
                        $end_date = date('Y-m-t', strtotime('December' . $_POST['year']));
                        break;
                }
            } else {
                $start_date = date('Y-m-01', strtotime('January' . $_POST['year']));
                $end_date = date('Y-m-t', strtotime('December' . $_POST['year']));
            }
            $this->Mincubationprogress->insertlist($this->input->post('label'), $this->input->post('criteria'), $this->input->post('option'), $this->input->post('innovation'), $this->input->post('date_type'), $start_date, $end_date);
        }
    }
}
