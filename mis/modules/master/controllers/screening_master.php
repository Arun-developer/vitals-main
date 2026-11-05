<?php

class Screening_master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mscreening_master');
        $this->load->model('Mmaster_settings');
        $this->items_perpage = '15';
    }
    public function index()
    {
        redirect('master/screening_master/view_list');
    }

    public function view_list()
    {
        $options = array();
        if ($this->uri->segment(5) != '') {
            $_POST['criteria'] = $this->uri->segment(5);
        }
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);

        #Pagination Scripts Starts
        $config = array('base_url' => site_url('master/screening_master/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mscreening_master->getAllCount($options),
            'num_links' => 10,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        #pagination Ends

        #Loading View and data
        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');
        $data['screeningList'] = $this->Mscreening_master->getLimitRecords($options);
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Screening Master";
        $data['cpage'] = "screening/listField";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');

        $this->load->view('../template', $data);
    }

    public function form($id = '')
    { 
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Mscreening_master->update($_POST);
                $msg = "Record Updated!";
            } else {
                $result = $this->Mscreening_master->insert($_POST);
                $msg = "Record inserted!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('master/screening_master/view_list/cri/' . $_POST['criteria']);
        }
        $data['screeningDetails'] = array();
        if ($id != '') {
            $data['screeningDetails'] = $this->Mscreening_master->getReportsInfo($id);
            if (php72_count($data['screeningDetails']) == 0) {
                redirect('master/screening_master/form');
            }

            $data['cpagetitle'] = "Edit Fields";
        } else {
            $data['cpagetitle'] = "Add Fields";
        }
		#echo'<pre>';print_r($data);die;
        $data['criteriaList'] = $this->Mmaster_settings->getMasterSetting('Grading Category');
        $data['cpage'] = "screening/addField";
        $this->load->view('../template_plain', $data);
    }

    public function assessment($id = null)
    {
        $data['pid'] = $id;
        $data['screeningDetails'] = $this->Mscreening_master->getReportsInfo($id);
        $data['assessmentList'] = $this->Mscreening_master->getAssessmentList($id);
        $data['cpagetitle'] = "Screening Master - Assessment Fields";
        $data['cpage'] = "screening/listAssessField";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }

    public function assessform($pid = '', $id = '')
    {
        $data['pid'] = $pid;
        if ($pid != '') {
            $data['screeningDetails'] = $this->Mscreening_master->getReportsInfo($pid);
            if (php72_count($data['screeningDetails']) == 0) {
                redirect('master/screening_master/view_list');
            }
        } else {
            redirect('master/screening_master/view_list');
        }

        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Mscreening_master->updateAssess($_POST);
                $msg = "Record inserted!";
            } else {
                $result = $this->Mscreening_master->insertAssess($_POST);
                $msg = "Record Updated!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('master/screening_master/assessment/' . $pid);
        }
        $data['assessDetails'] = array();
        if ($id != '') {
            $data['assessDetails'] = $this->Mscreening_master->getReportsInfo($id);
            if (php72_count($data['assessDetails']) == 0) {
                redirect('master/screening_master/assessform/' . $pid);
            }

            $data['cpagetitle'] = "Edit Assessment Fields";
        } else {
            $data['cpagetitle'] = "Add Assessment Fields";
        }
        $data['cpage'] = "screening/addAssessField";
        $this->load->view('../template_plain', $data);
    }

    public function delete($id = '', $pid = '', $type = '')
    {
        if ($id != '') {
            $result = $this->Mscreening_master->delete($id);
            if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Field deleted Success fully');
            }

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        if ($pid == '') {
            redirect('master/screening_master/view_list');
        } elseif ($type == '') {
            redirect('master/screening_master/assessment/' . $pid);
        } else {
            redirect('master/screening_master/sub_fieldlist/' . $pid);
        }

    }

    /**
     * Function : changestatus method is used for Changing Status of the screening_masters.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function make_order($criteria = '', $id = '', $order = '', $type = '')
    {
        if ($criteria != '' && $id != '' && $order != '' && $type != '') {
            $this->Mscreening_master->makeOrder($criteria, $id, $order, $type);
        }
        echo "success";
    }
    public function changestatus($id = '', $status = '', $pid = '', $type = '')
    {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mscreening_master->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Field Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        if ($pid == '') {
            redirect('master/screening_master/view_list');
        } elseif ($type == '') {
            redirect('master/screening_master/assessment/' . $pid);
        } else {
            redirect('master/screening_master/sub_fieldlist/' . $pid);
        }

    }

    //sub field

    public function sub_fieldlist($id = null)
    {
        $data['pid'] = $id;
        $data['screeningDetails'] = $this->Mscreening_master->getReportsInfo($id);
        $data['subfieldList'] = $this->Mscreening_master->getSubfieldList($id);
		#echo'<pre>';print_r($data['subfieldList']);die;
        $data['cpagetitle'] = "Screening Master - Subfields";
        $data['cpage'] = "screening/listSubField";
        $data['left_box'] = array('master');
        $this->load->view('../template', $data);
    }
    public function sub_field($pid = '', $id = '')
    { 	
		#echo'<pre>';print_r($_POST);die;
        $data['screeningDetails'] = array();
        $data['pid'] = $pid;

        if ($pid != '') {
            $data['screeningDetails'] = $this->Mscreening_master->getReportsInfo($pid);
        }

        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Mscreening_master->updateSub($_POST);
                $msg = "Record inserted!";
            } else {
                $result = $this->Mscreening_master->insertSub($_POST);
                $msg = "Record Updated!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('master/screening_master/sub_fieldlist/' . $pid);
        }
        $data['subfieldsDetails'] = array();
        if ($id != '') {
            $data['subfieldsDetails'] = $this->Mscreening_master->getReportsInfo($id);
            if (php72_count($data['subfieldsDetails']) == 0) {
                redirect('master/screening_master/sub_field/' . $pid);
            }

            $data['cpagetitle'] = "Edit Sub Fields";
        } else {
            $data['cpagetitle'] = "Add Sub Fields";
        }
        $data['cpage'] = "screening/subfield";
        $this->load->view('../template_plain', $data);
    }

    public function newtotal($value = array('2.5', '0', '0', '0'))
    {
        $firstVal = array();
        $secondVal = array();
        $total = 0;
        foreach ($value as $key => $number):
            $number = number_format($number, 2);
            $splitVal = explode(".", $number);
            $firstVal[] = $splitVal[0];
            $secondVal[] = $splitVal[1];
        endforeach;
        $firstValTotal = array_sum($firstVal);
        $secondTotal = $this->toTime(array_sum($secondVal));
        print('<pre>');
        print_r($value);
        print_r($firstVal);
        print_r($secondVal);
        echo $firstValTotal + $secondTotal;exit;
    }
    public function toTime($val = '')
    {
        $quo = 0;
        $rem = 0;
        if ($val >= 60) {
            $rem = $val % 60;
            $quo = $val / 60;
            $quo = (int) ($quo < 0 ? ceil($quo) : floor($quo));
            $result = $quo . '.' . $rem;
        } else {
            $result = '0.' . $val;
        }
        return $result;
    }

}
