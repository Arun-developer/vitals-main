<?php
/**
 *
 * Incubation Progress Master Page
 *
 * @ControllerName     incub_progress_master.php
 * @Author             Sanjoy Dey
 * @Created Date       11-11-2011
 * @Modified Date      12-11-2011
 * @copyright          Copyright(c) 2011
 * @version            CodeIgniter_2.0.3
 * @link               http://www.codeigniter.com
 * @since              File available since Release 2.0.3
 * @Warning            Any change in this file may cause abnormal behaviour of application.
 *
 */

class Incub_progress_master extends CI_Controller
{

    //Constructor Function
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mprogress_master');
        $this->load->model('Mmaster_settings');
        $this->load->model('Mscreening_master');
        $this->items_perpage = '6';
    }
    public function index()
    {
        redirect('master/incub_progress_master/view_list');
    }
    //Listing Data in Grid View
    public function view_list()
    {
        $options = array();
        if ($this->uri->segment(5) != '') {

            $_POST['criteria'] = $this->uri->segment(5);
        }
        $data['mastertype'] = $this->Mprogress_master->getmastertype();
        if ($this->input->post('mastertypes')) {
            $data['mycriteriaList'] = $this->Mprogress_master->getmastername($this->input->post('mastertypes'));
            echo json_encode($data['mycriteriaList']);exit;
        }
        $options = $_POST;
        $options['num'] = $this->items_perpage;
        $options['offset'] = $this->uri->segment(4);
        #Pagination Scripts Starts
        $this->load->library('pagination');
        $config = array('base_url' => site_url('master/incub_progress_master/view_list'),
            'per_page' => $this->items_perpage,
            'total_rows' => $this->Mprogress_master->getAllCount($options),
            'num_links' => 8,
            'uri_segment' => 4);
        $this->pagination->initialize($config);
        $this->pagination->create_links();
        #pagination Ends

        #Loading View and data

        $data['criteriaList'] = $this->Mprogress_master->getcriteria();
		#echo'<pre>';print_r($data['criteriaList']);die;
        $data['progressList'] = $this->Mprogress_master->getLimitRecords($options);

        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['cpagetitle'] = "Incubation Progress Master";
        $data['cpage'] = "incubation_progress/listField";
        $data['left_box'] = array('master');
        $data['custom_js'] = array('list_page');

        $this->load->view('../template', $data);
    }

    public function export()
    {
        $data['exceloutput'] = $this->Mprogress_master->getfields();
        $data['cpagetitle'] = "Incubation Progress Master";
        $data['cpage'] = "incubation_progress/exceloutput";
        $this->load->view('./template_plain', $data);
    }
    /**
     * Function : form method is used for Add & Edit details of the Progress Master.
     *
     * @param int $id,
     * @param var $status
     *
     */

    public function form($id = ''){ 
	
        if (isset($_POST['txtSubmit'])) {
            if ($_POST['action'] == 'edit') {
                $result = $this->Mprogress_master->update($_POST);
                $msg = "Record Updated!";
            } else {
                $result = $this->Mprogress_master->insert($_POST);
                $msg = "Record inserted!";
            }
            $this->session->set_flashdata('successMsg', $msg);
            redirect('master/incub_progress_master/view_list/');
        }
		
        $data['screeningDetails'] = array();
        if ($id != '') {

            $data['screeningDetails'] = $this->Mprogress_master->getRecords($id);
            if (php72_count($data['screeningDetails']) == 0) {
                redirect('master/incub_progress_master/form');
            }

            $data['cpagetitle'] = "Edit Fields";
        } else {

            $data['cpagetitle'] = "Add Fields";
        }
        $data['mastertype'] = $this->Mprogress_master->getmastertype();
        $data['criteriaList'] = $this->Mprogress_master->getcriteriaList();
        if ($this->input->post('mastertypes')) {
            $data['mycriteriaList'] = $this->Mprogress_master->getmastername($this->input->post('mastertypes'));
            echo json_encode($data['mycriteriaList']);exit;
        }
        $data['cpage'] = "incubation_progress/addField";
        $this->load->view('../template_plain', $data);
    }

    //Delete Method is used to delete records
    public function delete($id = '', $pid = '', $type = '')
    {
        if ($id != '') {
            $result = $this->Mprogress_master->delete($id);
            if (!empty($result)) {
                $this->session->set_flashdata('errorMsg', mysqlError($result));
            } else {
                $this->session->set_flashdata('successMsg', 'Field deleted Success fully');
            }

        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        if ($pid == '') {
            redirect('master/incub_progress_master/view_list');
        } elseif ($type == '') {
            redirect('master/incub_progress_master/assessment/' . $pid);
        } else {
            redirect('master/incub_progress_master/sub_fieldlist/' . $pid);
        }

    }

    /**
     * Function : changestatus method is used for Changing Status of the Progress Master.
     *
     * @param int $id,
     * @param var $status
     *
     */
    public function make_order($criteria = '', $id = '', $order = '', $type = '')
    {
        if ($criteria != '' && $id != '' && $order != '' && $type != '') {
            $this->Mprogress_master->makeOrder($criteria, $id, $order, $type);
        }
        echo "success";
    }
    public function changestatus($id = '', $status = '', $pid = '', $type = '')
    {
        if ($id != '' && $status != '') {
            $options = array('id' => $id, 'status' => $status);
            $this->Mprogress_master->changeStatus($options);
            $this->session->set_flashdata('successMsg', 'Field Status updated');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }

        if ($pid == '') {
            redirect('master/incub_progress_master/view_list');
        } elseif ($type == '') {
            redirect('master/incub_progress_master/assessment/' . $pid);
        } else {
            redirect('master/incub_progress_master/sub_fieldlist/' . $pid);
        }

    }

    //Sub field    List
    public function sub_fieldlist($id = null)
    {
        $data['pid'] = $id;
        $data['screeningDetails'] = $this->Mprogress_master->getProgressInfo($id);
        $data['subfieldList'] = $this->Mprogress_master->getSubfieldList($id);

        $data['cpagetitle'] = "Progress Master - Subfields";
        $data['cpage'] = "incubation_progress/listSubField";
        $data['left_box'] = array('master');
		#echo'<pre>';print_r($data['subfieldList']);die;
        $this->load->view('../template', $data);
    }

    //Add & Edit Subfield details incubateelist
    public function sub_field($pid = '', $id = '')
    {
        $data['screeningDetails'] = array();
        $data['pid'] = $pid;
		
        if ($pid != '') {
            $data['screeningDetails'] = $this->Mprogress_master->getProgressInfo($pid);
            $data['incubateelist'] = $this->Mprogress_master->getincubateelist();
			
        }
		if (isset($_POST['txtSubmit'])) {

            if ($_POST['action'] == 'edit') {

                $result = $this->Mprogress_master->updateSub($_POST);
                $msg = "Record Updated!";
            } else {

                $result = $this->Mprogress_master->insertSub($_POST);
                $msg = "Record Inserted!";
            }

            $this->session->set_flashdata('successMsg', $msg);
            redirect('master/incub_progress_master/sub_fieldlist/' . $pid);
        }
        $data['subfieldsDetails'] = array();
        if ($id != '') {

            $data['subfieldsDetails'] = $this->Mprogress_master->getProgressInfo($id);

            if (php72_count($data['subfieldsDetails']) == 0) {
                redirect('master/incub_progress_master/sub_field/' . $pid);
            }

            $data['cpagetitle'] = "Edit Sub Fields";
        } else {

            $data['cpagetitle'] = "Add Sub Fields";
        }

        $data['cpage'] = "incubation_progress/subfield";
        $this->load->view('../template_plain', $data); //Load Template
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
        if (php72_cmp($val) >= 60) {
            $rem = $val % 60;
            $quo = $val / 60;
            $quo = (int) (php72_cmp($quo) < 0 ? ceil($quo) : floor($quo));
            $result = $quo . '.' . $rem;
        } else {
            $result = '0.' . $val;
        }
        return $result;
    }

}
